<div class="row">
    <div class="col-sm-9">
        <div class="col-sm-3">
            <input type="text" class="form-control input-sm search-class" name="search" placeholder="Search..">
        </div>
        <div class="pull-right">
            <label class="inline-checkbox sm-font">
                <input type="checkbox" class="show_archive" value="0"> Show Archive?
            </label>&nbsp;
            <a href="#" class="btn btn-sm btn-primary add-agent"><i class="glyphicon glyphicon-plus"></i> Add</a>
        </div>
    </div>
</div><br/>
<div class="row">
    <div class="col-sm-9">
        <div id="franchise_list" class="grid" style="border: 1px solid #000000;height: 450px;"></div>
    </div>
    <div class="col-sm-3">
        <div class="info-col">
            <div class="panel panel-primary">
                <div class="panel-heading">Franchise Information</div>
                <div class="panel-body sm-font">
                    <div class="contact-info">
                        No franchise selected.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .sm-font{
        font-size: 13px;
    }
    .slick-cell{
        cursor: pointer;
    }
    .slick-row:hover {
        background: #9fa7c1 !important;
    }
    .slick-row.active{
        background: #8c7b99 !important;
    }
    .info{
        color: #4e6eff;
        margin-left: 5px;
    }
    .is_archive{
        background: #c16550 !important;
        color: #FFFFff;
    }
</style>
<script>
    $(function(e){
        var rowData = '';
        var columnsBasic = [
            {id: "name", name: "Name", field: "name", sortable: true},
            {id: "franchise_code", name: "Code", width: 10, field: "franchise_code", sortable: true,cssClass: "text-center"},
            {id: "franchise_owner", name: "Owner", width: 50, field: "franchise_owner", sortable: true,cssClass: "text-center"},
            {id: "phone", name: "Phone", width: 25, field: "phone", sortable: true,cssClass: "text-center"},
            {id: "mobile", name: "Mobile", width: 25, field: "mobile", sortable: true,cssClass: "text-center"},
            {id: "ird_num", name: "IRD Num", width: 50, field: "ird_num", sortable: true,cssClass: "text-center"}
        ];
        var dataFull = <?php echo $franchise?>;
        var contact_info = <?php echo $franchise_info?>;

        var getAgentInfo = function(data){
            var ele = '';
            $.each(contact_info,function(k,v){
                var fld = v.field_name;
                if(data[fld] != undefined && data[fld]){
                    ele += '<strong>' + v.label + ': </strong><span class="info">' + data[fld] + '</span><br/>';
                }
            });
            $('.contact-info').html(ele);
        };

        $("#franchise_list").slickgrid({
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
                var show_archive = '0';


                function requiredFieldValidator(value) {
                    if (value == null || value == undefined || !value.length) {
                        return {valid: false, msg: "This is a required field"};
                    }
                    else {
                        return {valid: true, msg: null};
                    }
                }

                function myFilter(item, args) {
                    var name = item["name"].toLowerCase();

                    if (args.searchString != "" && name.indexOf(args.searchString) == -1) {
                        return false;
                    }

                    if (args.show_archive != "" && item["is_archive"].indexOf(args.show_archive) == -1) {
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
                    getAgentInfo(rowData);
                });
                grid.onDblClick.subscribe(function(e, args){
                    var currentRow = args.row;
                    rowData = dataView.getItem(currentRow);
                    var link = bu + 'franchiseList/' + rowData.id + '?a=1';
                    $(this).modifiedModal({
                        'url': link,
                        'type': 'large',
                        'title': 'Edit Franchise (' + rowData.name + ')'
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
                    dataView.getItemMetadata = function (row) {
                        var item = dataView.getItem(row);
                        if(parseInt(item.is_archive)){
                            return {
                                'cssClasses': 'is_archive'
                            };
                        }

                    };
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

                $(".show_archive").click(function (e) {
                    Slick.GlobalEditorLock.cancelCurrentEdit();

                    // clear on Esc
                    if (e.which == 27) {
                        this.value = "";
                    }

                    show_archive = $(this).is(':checked') ? '' : '0';
                    updateFilter();
                });

                function updateFilter() {
                    dataView.setFilterArgs({
                        searchString: searchString,
                        show_archive: show_archive
                    });
                    dataView.refresh();
                }
                // set the initial sorting to be shown in the header
                if (sortCol) {
                    grid.setSortColumn(sortCol, sortDir);
                }

                // initialize the model after all the events have been hooked up
                dataView.setFilterArgs({
                    searchString: searchString,
                    show_archive: show_archive
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
        var user_btn = $('.user_management');
        user_btn.tooltip();
        $('.add-agent').click(function(){
            $(this).modifiedModal({
                url: bu + 'franchiseList?a=1',
                title: 'Add New Franchise',
                type: 'large'
            });
        });
    });
</script>