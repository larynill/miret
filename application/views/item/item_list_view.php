<style>
    .slick-row:hover {
        background: #9fa7c1 !important;
    }
    .slick-row.active{
        background: #8c7b99 !important;
    }
    .slick-cell{
        cursor: pointer;
    }
    .item_management{
        z-index: 20;
    }
    .column-center{
        text-align: center!important;
    }
</style>
<script>
    $(function(){
        var rowData = '';
        var columnsBasic = [
            {id: "item_name", name: "Item Name", field: "item_name", width: 50, sortable: true},
            {id: "item_code", name: "Item Code", width: 20, field: "item_code", sortable: true,cssClass: "column-center"},
            {id: "default_rate", name: "Default Rate", width: 20,field: "default_rate", sortable: true,cssClass: "column-center"},
            {id: "unit_from", name: "Unit", field: "unit_from", width: 20,cssClass: "column-center"},
            {id: "report_text", name: "Report Text", field: "report_text", cssClass: "column-center"},
            {id: "auto_item_status", name: "Auto Item?", field: "auto_item_status", width: 15, cssClass: "column-center"},
            {id: "tags", name: "Tags", field: "tags",cssClass: "column-center"}
        ];
        var dataFull = <?php echo $items_list;?>;

        $("#item_list").slickgrid({
            columns: columnsBasic,
            data: dataFull,
            slickGridOptions: {
                enableCellNavigation: true,
                enableColumnReorder: true,
                forceFitColumns: true,
                inlineFilters: true,
                asyncEditorLoading: true,
                editable: true,
                rowHeight: 30
            },
            sortCol: undefined,
            sortDir: true,
            handleCreate: function(){
                var o = this.wrapperOptions;
                var dataView = new Slick.Data.DataView();
                var grid = new Slick.Grid(this.element, dataView, o.columns, o.slickGridOptions);
                var searchString = "";
                var unitType = "";

                function requiredFieldValidator(value) {
                    if (value == null || value == undefined || !value.length) {
                        return {valid: false, msg: "This is a required field"};
                    }
                    else {
                        return {valid: true, msg: null};
                    }
                }

                function myFilter(item, args) {
                    var name = item["item_name"].toLowerCase();
                    if (args.unitType != "" && item["unit_id"].indexOf(args.unitType) == -1) {
                        return false;
                    }

                    if (args.searchString != "" && name.indexOf(args.searchString) == -1) {
                        return false;
                    }

                    return true;
                }
                grid.onCellChange.subscribe(function (e, args) {
                    dataView.updateItem(args.item.id, args.item);
                });

                grid.onClick.subscribe(function(e, args) {
                    var currentRow = args.row;
                    rowData = dataView.getItem(currentRow);
                    $('.slick-row').removeClass('active');
                    check_data_click();
                });
                grid.onDblClick.subscribe(function(e, args){
                    var currentRow = args.row;
                    rowData = dataView.getItem(currentRow);
                    var link = bu + 'manageItem/edit/' + rowData.id;
                    $(this).modifiedModal({
                        url: link,
                        title: 'Edit Item'
                    });
                });

                var sortCol = o.sortCol;
                var sortDir = o.sortDir;
                function compare(a, b) {
                    var x = a[sortCol], y = b[sortCol];
                    return (x == y ? 0 : (x > y ? 1 : -1));
                }
                grid.onSort.subscribe(function (e, args) {
                    sortDir = args.sortAsc;
                    sortCol = args.sortCol.field;
                    dataView.sort(compare, sortDir);
                    grid.invalidateAllRows();
                    grid.render();
                });

                dataView.onRowCountChanged.subscribe(function (e, args) {
                    grid.updateRowCount();
                    grid.render();
                });

                dataView.onRowsChanged.subscribe(function (e, args) {
                    grid.invalidateRows(args.rows);
                    grid.render();
                });

                grid.onKeyDown.subscribe(function (e) {
                    // select all rows on ctrl-a
                    if (e.which != 65 || !e.ctrlKey) {
                        return false;
                    }

                    var rows = [];
                    for (var i = 0; i < dataView.getLength(); i++) {
                        rows.push(i);
                    }

                    grid.setSelectedRows(rows);
                    e.preventDefault();
                });

                $(".search-class").keyup(function (e) {
                    Slick.GlobalEditorLock.cancelCurrentEdit();

                    // clear on Esc
                    if (e.which == 27) {
                        this.value = "";
                    }

                    searchString = this.value;
                    updateFilter();
                });

                $(".unit-type").change(function (e) {
                    Slick.GlobalEditorLock.cancelCurrentEdit();

                    // clear on Esc
                    if (e.which == 27) {
                        this.value = "";
                    }

                    unitType = this.value;
                    updateFilter();
                });

                function updateFilter() {
                    dataView.setFilterArgs({
                        unitType: unitType,
                        searchString: searchString
                    });
                    dataView.refresh();
                }
                // set the initial sorting to be shown in the header
                if (sortCol) {
                    grid.setSortColumn(sortCol, sortDir);
                }

                // initialize the model after all the events have been hooked up
                dataView.setFilterArgs({
                    unitType: unitType,
                    searchString: searchString
                });
                dataView.setFilter(myFilter);
                dataView.beginUpdate();
                dataView.setItems(o.data);
                dataView.endUpdate();

                grid.resizeCanvas();
            }
        });

        $('.slick-row').on('click',function(){
            $('.slick-row').removeClass('active');
            $(this).addClass('active');
        });
        var item_btn = $('.item_management');
        item_btn.tooltip();

        var check_data_click = function(){
            var btn = $('.disabled-btn');
            btn.css({
                'pointer-events' : 'none',
                'background' : '#484848',
                'border-color' : '#484848'
            });
            if(rowData != ''){
                btn.css({
                    'pointer-events' : 'inherit',
                    'background' : '#428bca',
                    'border-color' : '#357ebd'
                });
            }
        };
        check_data_click();

        item_btn.on('click', function(){
            var btn_type = $(this).attr('id');
            var selected_id = rowData.id;
            var link;
            if(rowData != ''){
                if(rowData.id.length){
                    if(btn_type == 'edit'){
                        link = bu + 'manageItem/edit/' + selected_id;
                        $(this).modifiedModal({
                            url: link,
                            title: 'Edit Item'
                        });
                    }else if(btn_type == 'delete'){
                        link = bu + 'manageItem/delete/' + selected_id;
                        var ele =
                            '<div class="modal-body">' +
                                '<div class="row">' +
                                    '<div class="col-sm-12">' +
                                    'Do you want to continue deleting item?' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-success btn-sm yes-btn" data-dismiss="modal">Yes</button>' +
                                '<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>' +
                            '</div>';
                        $(this).modifiedModal({
                            html: ele,
                            title: 'Delete Item'
                        });
                        $('.yes-btn').click(function(e){
                            e.preventDefault();
                            $.post(link,{id:selected_id},function(data){});
                            location.reload();
                        });

                    }
                }
            }
            if(btn_type == 'add'){
                link = bu + 'manageItem/add';
                $(this).modifiedModal({
                    url: link,
                    title: 'Add Item'
                });
            }

        });

    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="pull-left">
            <div class="col-lg-8">
                <input type="text" class="form-control input-sm search-class" name="search" placeholder="Search..">
            </div>
            <div class="col-lg-4">
                <?php echo form_dropdown('unit',$unit,'','class="form-control input-sm unit-type"')?>
            </div>
        </div>
        <div class="pull-right">
            <button class="btn btn-primary btn-sm item_management" data-toggle="tooltip" data-placement="left" id="add" title="Add Item"><i class="fa fa-fw fa-plus"></i> </button>
            <button class="btn btn-primary btn-sm item_management disabled-btn" data-toggle="tooltip" data-placement="left" id="delete" title="Delete Item"><i class="fa fa-fw fa-minus-circle"></i> </button>
            <button class="btn btn-primary btn-sm item_management disabled-btn" data-toggle="tooltip" data-placement="left" id="edit" title="Edit Item"><i class="fa fa-fw fa-pencil"></i> </button>
        </div>
    </div>
</div><br/>
<div class="row">
    <div class="col-lg-12">
        <div id="item_list" class="grid" style="border: 1px solid #000000;height: 500px;"></div>
    </div>
</div