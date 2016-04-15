<div class="row">
    <div class="col-lg-12">
        <div class="pull-left">
            <div class="col-lg-8">
                <input type="text" class="form-control input-sm search-class" name="search" placeholder="Search..">
            </div>
            <div class="col-lg-6" style="margin-left: 10px;">

            </div>
        </div>
        <div class="pull-left" style="margin-left: -30px;">
            <div class="col-lg-12">

            </div>
        </div>
    </div>
</div><br/>
<div class="row">
    <div class="col-lg-8">
        <div id="job_audit_log" class="grid" style="border: 1px solid #000000;height: 500px;"></div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="glyphicon glyphicon-cog"></i> Email Settings <a href="#" class="link-btn pull-right"><i class="glyphicon glyphicon-chevron-down"></i></a></div>
            <div class="panel-body">
                Panel content
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="glyphicon glyphicon-list"></i> Change Log <a href="#" class="link-btn pull-right"><i class="glyphicon glyphicon-chevron-down"></i></a></div>
            <div class="panel-body">
                Panel content
            </div>
        </div>
    </div>
</div>
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
    .user_management{
        z-index: 20;
    }
    .column-center{
        text-align: center!important;
    }
    a.link-btn{
        color: #ffffff;
    }
</style>
<script>
    $(function(){
        var rowData = '';
        var columnsBasic = [
            {id: "name", name: "Name", field: "name", sortable: true},
            {id: "username", name: "Username", width: 50, field: "username", sortable: true,cssClass: "column-center"},
            {id: "alias", name: "Alias", width: 20,field: "alias", sortable: true,cssClass: "column-center"},
            {id: "email", name: "Email", field: "email"},
            {id: "active", name: "Active", field: "active",width: 20,cssClass: "column-center"},
            {id: "account_type", name: "Account type", field: "account_type",width: 50,cssClass: "column-center"}
        ];
        var dataFull = <?php echo $users;?>;

        $("#job_audit_log").slickgrid({
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
                var accountStatus = "";
                var accountType = "";

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
                    if (args.accountType != "" && item["account_type_id"].indexOf(args.accountType) == -1) {
                        return false;
                    }

                    if (args.accountStatus != "" && item["is_active"].indexOf(args.accountStatus) == -1) {
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
                });
                grid.onDblClick.subscribe(function(e, args){
                    var currentRow = args.row;
                    rowData = dataView.getItem(currentRow);
                    var link = bu + 'manageUser/edit/' + rowData.id;
                    $('.modal-title').html('Edit User');
                    $('.lg-page-load').load(link);
                    $('.largeModal').modal();
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

                $(".account-type").change(function (e) {
                    Slick.GlobalEditorLock.cancelCurrentEdit();

                    // clear on Esc
                    if (e.which == 27) {
                        this.value = "";
                    }

                    accountType = this.value;
                    updateFilter();
                });

                $(".status").change(function (e) {
                    Slick.GlobalEditorLock.cancelCurrentEdit();

                    // clear on Esc
                    if (e.which == 27) {
                        this.value = "";
                    }

                    accountStatus = this.value;
                    updateFilter();
                });

                function updateFilter() {
                    dataView.setFilterArgs({
                        accountStatus: accountStatus,
                        accountType: accountType,
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
                    accountStatus: accountStatus,
                    accountType: accountType,
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
    });
</script>