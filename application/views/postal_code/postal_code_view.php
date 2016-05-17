<script type="text/javascript" src="<?php echo base_url(); ?>plugins/js/slickgrid.formatters.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>plugins/js/slickgrid-print-plugin.js"></script>
<?php
$road_name_checked = count($selection) > 0 ? ($selection['road_name'] ? 'checked' : '') : 'checked';
$suburb_checked = count($selection) > 0 ? ($selection['suburb'] ? 'checked' : '') : 'checked';
$city_checked = count($selection) > 0 ? ($selection['town_city'] ? 'checked' : '') : 'checked';
$post_code = count($selection) > 0 ? ($selection['post_code'] ? 'checked' : '') : 'checked';
$disabled = count($selection) > 0 ?
    (($selection['road_name'] || $selection['suburb'] || $selection['town_city'] || $selection['post_code'] ) ? '' : 'disabled') : '';
?>
<div class="row">
    <div class="col-sm-12">
        <a href="#" class="btn btn-sm btn-primary pull-right print-btn"><i class="glyphicon glyphicon-print"></i> Print</a>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-sm-8">
        <div id="postal_code_list" class="grid" style="border: 1px solid #000000;height: 450px;"></div>
        <div class="row" style="margin-top: 5px;">
            <div class="col-sm-12">
                <a href="#" class="text-success action-btn"><i class="glyphicon glyphicon-plus"></i></a>&nbsp;
                <a href="#" class="text-danger action-btn disabled"><i class="glyphicon glyphicon-minus"></i></a>&nbsp;
                <a href="#" class="text-primary action-btn disabled"><i class="glyphicon glyphicon-pencil"></i></a>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <?php
        echo form_open('','class="postal-form"');
        ?>
        <div class="max-col-height">
            <div class="row">
                <div class="col-sm-12">
                    <input type="text" class="form-control input-sm search-class" name="search" placeholder="Search.." <?php echo $disabled;?> ><br/>
                    <label class="checkbox-inline"><input type="checkbox" name="road_name" class="checkbox road_name" data-name="road_name" value="1" <?php echo $road_name_checked?>> Road Name</label>
                    <label class="checkbox-inline"><input type="checkbox" name="suburb" class="checkbox suburb" data-name="suburb" value="1" <?php echo $suburb_checked?>> Suburb</label>
                    <label class="checkbox-inline"><input type="checkbox" name="town_city" class="checkbox town_city" data-name="town_city" value="1" <?php echo $city_checked?>> City</label>
                    <label class="checkbox-inline"><input type="checkbox" name="post_code" class="checkbox post_code" data-name="post_code" value="1" <?php echo $post_code?>> Postcode</label>
                </div>
            </div><br/>
            <div class="row">
                <div class="col-sm-8">
                    <?php echo form_dropdown('franchise',$franchise,'','class="form-control input-sm" id="franchise"');?>
                </div>
            </div>
        </div><br/>
        <div class="row">
            <div class="col-sm-12">
                <strong class="row-count"></strong>&nbsp;
                <button type="button" class="btn btn-sm btn-primary export-record">Export</button>
                <button type="button" class="btn btn-sm btn-primary import-record">Import</button>
            </div>
        </div>
        <?php
        echo form_close();
        ?>
    </div>
</div>
<style>
    .action-btn{
        font-size: 16px;
    }
    .disabled{
        pointer-events: none;
        color: #808080;
    }
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
    .franchise{
        margin-top: -5px;
    }
</style>
<?php
unset($franchise[null]);
?>
<script>
var franchise_dp = jQuery.parseJSON('<?php echo json_encode($franchise)?>');
var drop_down = function(value){
    var drop_down = '<select name="franchise" class="franchise">';
        drop_down += '<option value>All Franchise</option>';
    $.each(franchise_dp,function(index,val){
        drop_down += '<option value="' + index + '" ' + (index == value ? 'selected' : '') + '>' + val + '</option>';
    });

    drop_down += '</select>';

    return drop_down;
};
function formatter(row, cell, value, columnDef, dataContext) {
    if (value)
        return drop_down(value);
    else
        return drop_down();
}

$(function(e){
    var rowData = '',rowId = 0,cellId = 0,_road_name = $('.road_name'), _suburb = $('.suburb'), _town_city = $('.town_city'), _post_code = $('.post_code');
    var columnsBasic = [
        {id: "road_name", name: "Road Name", field: "road_name", sortable: true},
        {id: "num_range", name: "No. Range", width: 20, field: "num_range", sortable: true},
        {id: "suburb", name: "Suburb", width: 50, field: "suburb", sortable: true},
        {id: "town_city", name: "Town/City", width: 35, field: "town_city", sortable: true},
        {id: "postcode", name: "Postal Code", width: 15, field: "postcode", sortable: true,cssClass: "text-center"},
        {id: "franchise_id", name: "Franchise", width: 60, field: "franchise_id", sortable: true,cssClass: "text-center",formatter: formatter}
    ];
    $(this).newForm.addLoadingForm();
    $.ajax({
        dataType: "json",
        url: bu + 'postalCodesJson?json=1',
        success: function(json){
            LoadGrid(json);
            $(this).newForm.removeLoadingForm();
        }
    });

    function LoadGrid(dataFull){
        $("#postal_code_list").slickgrid({
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
                var printPlugin = new Slick.Plugins.Print();
                grid.registerPlugin(printPlugin);

                var searchString = '';
                var searchList = [];
                var road_name = _road_name.is(':checked') ? _road_name.val() : '';
                var suburb = _suburb.is(':checked') ? _suburb.val() : '';
                var town_city = _town_city.is(':checked') ? _town_city.val() : '';
                var post_code = _post_code.is(':checked') ? _post_code.val() : '';
                var franchise_address = '';

                function requiredFieldValidator(value) {
                    if (value == null || value == undefined || !value.length) {
                        return {valid: false, msg: "This is a required field"};
                    }
                    else {
                        return {valid: true, msg: null};
                    }
                }

                function myFilter(item, args) {
                    var found;
                    var _item = {};
                    $.each(item, function(key,value){
                        if(args.road_name != "" && key == 'road_name'){
                            _item[key] = item[key];
                        }
                        if(args.suburb != "" && key == 'suburb'){
                            _item[key] = item[key];
                        }
                        if(args.town_city != "" && key == 'town_city'){
                            _item[key] = item[key];
                        }
                        if(args.post_code != "" && key == 'postcode'){
                            _item[key] = item[key];
                        }
                    });

                    if(franchise_address){
                        if (args.franchise != "" && item["franchise_id"].indexOf(args.franchise) == -1) {
                            return false;
                        }
                    }
                    for (i = 0; i < searchList.length; i += 1) {
                        found = false;
                        $.each(_item, function(obj, objValue) {
                            if (typeof objValue !== 'undefined' && objValue != null
                                && objValue.toString().toLowerCase().indexOf(searchList[i]) != -1) {
                                found = true;
                                return false; //this breaks the $.each loop
                            }
                        });
                        if (!found) {
                            return false;
                        }
                    }

                    return true;
                }
                grid.onCellChange.subscribe(function (e, args) {
                    dataView.updateItem(args.item.id, args.item);
                });

                grid.onClick.subscribe(function(e, args) {
                    rowId = args.row;
                    cellId = args.cell;
                    rowData = dataView.getItem(rowId);
                    $('.slick-row').removeClass('active');
                    $('.action-btn').removeClass('disabled');
                });
                grid.onDblClick.subscribe(function(e, args){
                    var currentRow = args.row;
                    rowData = dataView.getItem(currentRow);
                    $('.action-btn.text-primary').trigger('click');
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
                    var data =  grid.getDataLength();
                    var rows_str = 'Rows: <span style="color:red;">' + data + '</span>';
                    $('.row-count').html(rows_str)
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

                $('.print-btn').on('click', function () {
                    var data = $('.postal-form').serializeArray();
                    data.push({name:'submit',value:1});
                    var add_url = data.length > 0 ? '?' + $.param(data) : '';
                    var myWindow = window.open(
                        bu + 'postalCodesJson' + add_url,
                        'Notification PDF'
                    );
                });

                $(".search-class").keyup(function (e) {
                    Slick.GlobalEditorLock.cancelCurrentEdit();

                    // clear on Esc
                    if (e.which == 27) {
                        this.value = "";
                    }
                    searchList = $.trim(this.value.toLowerCase()).split(' ');
                    searchString = this.value.toLowerCase();

                    updateFilter();
                });

                $("#franchise").change(function (e) {
                    Slick.GlobalEditorLock.cancelCurrentEdit();

                    // clear on Esc
                    if (e.which == 27) {
                        this.value = "";
                    }

                    franchise_address = this.value;
                    updateFilter();
                });

                $(".checkbox").change(function (e) {
                    Slick.GlobalEditorLock.cancelCurrentEdit();

                    // clear on Esc
                    if (e.which == 27) {
                        this.value = "";
                    }
                    road_name = _road_name.is(':checked') ? _road_name.val() : '';
                    suburb = _suburb.is(':checked') ? _suburb.val() : '';
                    town_city = _town_city.is(':checked') ? _town_city.val() : '';
                    post_code = _post_code.is(':checked') ? _post_code.val() : '';

                    saveCheckboxData();
                    hasCheck();
                    updateFilter();
                });

                $('.grid').on('change','.franchise',function(){
                    var value = $(this).val();
                    $.post(bu + 'postalCodesJson?postal_id=' + rowData.id + '&franchise_id=' + $(this).val(), {submit:1},function(){
                        grid.invalidateRow(rowId);
                        o.data[rowId][grid.getColumns()[cellId].field] = value;
                        grid.render();
                    });
                });

                $('.action-btn').click(function(){
                    if($(this).hasClass('text-success')){
                        $(this).modifiedModal({
                            url: bu + 'postalCodesJson?new=1',
                            title: 'Add New Postal Code'
                        });
                    }
                    else if($(this).hasClass('text-danger')){
                        var ele =
                            '<div class="modal-body">' +
                                '<div class="row">' +
                                    '<div class="col-sm-12">' +
                                        'Would you like to continue deleting Postal Code?' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-success btn-sm" id="yes-btn" data-dismiss="modal">Yes</button>' +
                                '<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>' +
                            '</div>';
                        $(this).modifiedModal({
                            html:ele,
                            title: 'Delete Postal Code'
                        });

                        $('#yes-btn').click(function(){
                            $.post(bu + 'postalCodesJson?delete=1',{postal_id:rowData.id},function(data){
                                location.reload();
                            });
                        });
                    }
                    else if($(this).hasClass('text-primary')){
                        $(this).modifiedModal({
                            url: bu + 'postalCodesJson/' + rowData.id,
                            title: 'Update Postal Code'
                        });
                    }
                });

                function updateFilter() {
                    dataView.setFilterArgs({
                        franchise: franchise_address,
                        road_name: road_name,
                        suburb: suburb,
                        town_city: town_city,
                        post_code: post_code,
                        searchString: searchString,
                        searchList: searchList
                    });
                    dataView.refresh();
                }
                // set the initial sorting to be shown in the header
                if (sortCol) {
                    grid.setSortColumn(sortCol, sortDir);
                }

                // initialize the model after all the events have been hooked up
                dataView.setFilterArgs({
                    franchise: franchise_address,
                    road_name: road_name,
                    suburb: suburb,
                    town_city: town_city,
                    post_code: post_code,
                    searchString: searchString,
                    searchList: searchList
                });
                dataView.setFilter(myFilter);
                dataView.beginUpdate();
                dataView.setItems(o.data);
                dataView.endUpdate();

                grid.resizeCanvas();
            }
        });
    }

    function saveCheckboxData(){
        var data = {};
        $('.checkbox').each(function(){
            data[$(this).data('name')] = $(this).is(':checked') ? $(this).val() : '';
        });

        data['submit'] = 1;
        $.post(bu + 'postCheckboxSession',data,function(data){
        });
    }

    function hasCheck(){
        var checkbox = $('input:checkbox:not(":checked")').length;
        var count_checkbox = $('input:checkbox').length;
        if(checkbox == count_checkbox){
            $('.search-class').attr('disabled','disabled');
        }
        else{
            $('.search-class').removeAttr('disabled');
        }
    }

    $('.slick-row').on('click',function(){
        $('.slick-row').removeClass('active');
        $(this).addClass('active');
    });
});
</script>