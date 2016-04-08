<div class="row">
    <div class="col-sm-9">
        <div class="col-sm-3">
            <input type="text" class="form-control input-sm search-class" name="search" placeholder="Search..">
        </div>
        <div class="col-sm-3">
            <?php echo form_dropdown('franchise_id',$franchise,'','class="form-control input-sm" id="franchise_id"');?>
        </div>
        <div class="branch" style="display: none;">
            <div class="col-sm-2">
                <?php echo form_dropdown('branch_id',$branch,'','class="form-control input-sm" id="branch_id"');?>
            </div>
        </div>
        <!--<div class="col-sm-2">
            <?php /*echo form_dropdown('agent_id',$agent,'','class="form-control input-sm" id="agent_id"');*/?>
        </div>-->
        <div class="pull-right">
            <a href="#" class="btn btn-sm btn-primary add-agent"><i class="glyphicon glyphicon-plus"></i> Add</a>
        </div>
    </div>
</div><br/>
<div class="row">
    <div class="col-sm-9">
        <div id="contact_list" class="grid" style="border: 1px solid #000000;height: 450px;"></div>
    </div>
    <div class="col-sm-3">
        <div class="info-col">
            <div class="panel panel-primary">
                <div class="panel-heading">Agent Information</div>
                <div class="panel-body sm-font">
                    <div class="contact-info">
                        No agent selected.
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
</style>
<script>
    $(function(e){
        var rowData = '';
        var columnsBasic = [
            {id: "name", name: "Name", field: "name", sortable: true},
            {id: "code", name: "Code", width: 15, field: "code", sortable: true,cssClass: "text-center"},
            {id: "agent", name: "Agent", width: 15, field: "agent", sortable: true,cssClass: "text-center"},
            {id: "email", name: "Email", width: 50, field: "email", sortable: true,cssClass: "text-center"},
            {id: "franchise_name", name: "Franchise", width: 20, field: "franchise_name", sortable: true,cssClass: "text-center"},
            {id: "branch", name: "Branch", field: "branch", width: 20, cssClass: "text-center"}
        ];
        var dataFull = <?php echo $contacts;?>;
        var contact_info = <?php echo $contact_info;?>;

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

        var getBranch = function(id){
            if(id){
                $.post(bu + 'contactList',{agent_id:id},function(data){
                    var _data = jQuery.parseJSON(data);
                    var dp = '<option value>Select Branch</option>';
                    $.each(_data,function(k,val){
                        dp += '<option value="' + k + '">' + val + '</option>';
                    });
                    if(_data.length > 0){
                        $('.branch').css({'display':'inline'});
                        $('#branch_id').html(dp);
                    }
                });
            }
            else{
                $('.branch').css({'display':'none'});
            }
        };

        $("#contact_list").slickgrid({
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
                var branch = "";
                var agent = "";
                var franchise = "";

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
                    if (args.branch != "" && item["id"].indexOf(args.branch) == -1) {
                        return false;
                    }

                    if (args.agent != "" && item["agent_id"].indexOf(args.agent) == -1) {
                        return false;
                    }

                    if (args.franchise != "" && item["franchise_id"].indexOf(args.franchise) == -1) {
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
                    getAgentInfo(rowData);
                    if(!parseInt(rowData.is_branch)){
                        getBranch(rowData.id);
                    }
                    else{
                        getBranch(0);
                    }
                });
                grid.onDblClick.subscribe(function(e, args){
                    var currentRow = args.row;
                    rowData = dataView.getItem(currentRow);
                    var link = bu + 'contactList/' + rowData.id + '?a=1&agent_id=' + rowData.agent_id;
                    $(this).modifiedModal({
                        'url': link,
                        'type': 'large',
                        'title': 'Edit Contact'
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

                $("#franchise_id").change(function (e) {
                    Slick.GlobalEditorLock.cancelCurrentEdit();

                    // clear on Esc
                    if (e.which == 27) {
                        this.value = "";
                    }

                    franchise = this.value;
                    updateFilter();
                });

                $("#agent_id").change(function (e) {
                    Slick.GlobalEditorLock.cancelCurrentEdit();

                    // clear on Esc
                    if (e.which == 27) {
                        this.value = "";
                    }

                    agent = this.value;
                    updateFilter();
                });

                $("#branch_id").change(function (e) {
                    Slick.GlobalEditorLock.cancelCurrentEdit();

                    // clear on Esc
                    if (e.which == 27) {
                        this.value = "";
                    }

                    branch = this.value;
                    updateFilter();
                });

                function updateFilter() {
                    dataView.setFilterArgs({
                        franchise: franchise,
                        agent: agent,
                        branch: branch,
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
                    franchise: franchise,
                    agent: agent,
                    branch: branch,
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
        var user_btn = $('.user_management');
        user_btn.tooltip();
        $('.add-agent').click(function(){
            $(this).modifiedModal({
                url: bu + 'contactList?a=1',
                title: 'Add New Agent',
                type: 'large'
            });
        });
    });
</script>