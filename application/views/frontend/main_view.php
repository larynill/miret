<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>ScopePro</title>
    <meta name="keywords" content="ScopePro" />
    <meta name="description" content="ScopePro">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<link rel="shortcut icon" type="image/png" href="img/favicon.png" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Libs CSS -->
    <link href="<?php echo base_url()?>plugins/css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>plugins/frontend/css/style.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>plugins/frontend/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>plugins/frontend/css/v-nav-menu.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>plugins/frontend/css/v-animation.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>plugins/frontend/css/v-bg-stylish.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>plugins/frontend/css/v-shortcodes.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>plugins/frontend/css/theme-responsive.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>plugins/frontend/owl-carousel/owl.theme.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>plugins/frontend/owl-carousel/owl.carousel.css" rel="stylesheet" />

    <!-- Current Page CSS -->
    <link href="<?php echo base_url()?>plugins/frontend/rs-plugin/css/settings.css" rel="stylesheet" />
    <link href="<?php echo base_url()?>plugins/frontend/rs-plugin/css/custom-captions.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url()?>plugins/frontend/css/custom.css">

    <!--Bootstrap Datetimepicker-->
    <link href="<?php echo base_url();?>plugins/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

    <!--Slickgrid-->
    <link href="<?php echo base_url();?>plugins/slick-grid/css/example-bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>plugins/slick-grid/css/slick.grid.css" rel="stylesheet">
    <style>
        .form-control{
            border: 1px solid #b3b3b3 !important;
        }
    </style>
</head>

<body class="no-page-top">

<!--Header-->
<!--Set your own background color to the header-->
<header class="semi-transparent-header" data-bg-color="rgba(9, 103, 139, 0.36)" data-font-color="#fff">
    <div class="container">

        <!--Site Logo-->
        <div class="logo" data-sticky-logo="img/logo-white.png" data-normal-logo="img/logo.png">
            <a href="<?php echo base_url();?>">
                ScopePro
            </a>
        </div>
        <!--End Site Logo-->

        <div class="navbar-collapse nav-main-collapse collapse">
            <!--Main Menu-->
            <nav class="nav-main mega-menu one-page-menu">
                <ul class="nav nav-pills nav-main" id="mainMenu">
                    <?php
                    if(count($links) > 0){
                        foreach($links as $url=>$name){
                            $icon = $icons[$url];
                            $_url = $url ? base_url() . '?p=' . $url : base_url();
                            $active_link = $active == $url ? 'class="active"' : '';
                            ?>
                            <li <?php echo $active_link;?> >
                                <a href="<?php echo $_url;?>"><i class="fa <?php echo $icon;?>"></i><?php echo $name;?></a>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </nav>
            <!--End Main Menu-->
        </div>
        <button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
            <i class="fa fa-bars"></i>
        </button>
    </div>
</header>
<!--End Header-->

<div id="container">

    <!--Set your own slider options. Look at the v_RevolutionSlider() function in 'theme-core.js' file to see options-->
    <div class="home-slider-wrap fullwidthbanner-container" id="home">
        <div class="shadow-right"></div>
    </div>

    <div class="container">
        <div class="v-spacer col-sm-12 v-height-small"></div>
    </div>
    <?php $this->load->view($page)?>

    <div class="container">
        <div class="v-spacer col-sm-12 v-height-standard"></div>
    </div>

</div>

<!--Footer-Wrap-->
<div class="footer-wrap">

    <div class="copyright">
        <div class="container">
            <p style="font-family: arial, sans-serif">© Copyright <?php echo date('Y')?> by ScopePro. All Rights Reserved.</p>
            <nav class="footer-menu std-menu">
                <ul class="menu">
                    <?php
                    if(count($links) > 0){
                        foreach($links as $url=>$name){
                            $icon = $icons[$url];
                            $_url = $url ? base_url() . '?p=' . $url : base_url();
                            $active_link = $active == $url ? 'class="active"' : '';
                            ?>
                            <li>
                                <a href="<?php echo $_url;?>" <?php echo $active_link;?>><i class="fa <?php echo $icon;?>"></i> <?php echo $name;?></a>
                            </li>
                        <?php
                        }
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<!--End Footer-Wrap-->

<!--/ BACK TO TOP /-->
<div id="back-to-top" class="animate-top"><i class="fa fa-angle-up"></i></div>

<!--small modal-->
<div class="modal fade bs-example-modal-sm sm-modal smallModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title sm-title">New Order</h4>
            </div>
            <div class="sm-load-page sm-page-load"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Libs -->
<script src="<?php echo base_url()?>plugins/frontend/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>plugins/js/jquery-ui.min.js"></script>
<script src='<?php echo base_url();?>plugins/fullcalendar/moment.js'></script>
<script src="<?php echo base_url()?>plugins/frontend/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>plugins/frontend/js/jquery.flexslider-min.js"></script>
<script src="<?php echo base_url()?>plugins/frontend/js/jquery.easing.js"></script>
<script src="<?php echo base_url()?>plugins/frontend/js/jquery.fitvids.js"></script>
<script src="<?php echo base_url()?>plugins/frontend/js/jquery.carouFredSel.min.js"></script>
<script src="<?php echo base_url()?>plugins/frontend/js/theme-plugins.js"></script>
<script src="<?php echo base_url()?>plugins/frontend/js/jquery.isotope.min.js"></script>
<script src="<?php echo base_url()?>plugins/frontend/js/imagesloaded.js"></script>

<script src="<?php echo base_url()?>plugins/frontend/js/view.min.js?auto"></script>

<script src="<?php echo base_url()?>plugins/frontend/plugins/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="<?php echo base_url()?>plugins/frontend/plugins/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

<script src="<?php echo base_url()?>plugins/frontend/js/theme-core.js"></script>
<!--Slick Grid-->
<script src="<?php echo base_url();?>plugins/slick-grid/js/jquery.event.drag-2.2.js"></script>
<script src="<?php echo base_url();?>plugins/slick-grid/js/slick.core.js"></script>
<script src="<?php echo base_url();?>plugins/slick-grid/js/slick.rowselectionmodel.js"></script>
<script src="<?php echo base_url();?>plugins/slick-grid/js/slick.formatters.js"></script>
<script src="<?php echo base_url();?>plugins/slick-grid/js/slick.editors.js"></script>
<script src="<?php echo base_url();?>plugins/slick-grid/js/slick.grid.js"></script>
<script src="<?php echo base_url();?>plugins/slick-grid/js/slick.dataview.js"></script>
<script src="<?php echo base_url();?>plugins/slick-grid/js/bootstrap-slickgrid.js"></script>
<script src="<?php echo base_url();?>plugins/js/slickgrid.formatters.js"></script>
<script src="<?php echo base_url();?>plugins/js/slickgrid-print-plugin.js"></script>

<script src="<?php echo base_url();?>plugins/js/bootstrap-datetimepicker.js"></script>
<script>
    var bu = '<?php echo base_url();?>';
</script>

<script src="<?php echo base_url();?>plugins/js/modified-modal.js"></script>

<script>
    var purchase_btn = function(value){
        return '<a href="' + value + '" class="btn btn-sm btn-primary purchase-btn">Add to Cart</a>';
    };
    function formatter(row, cell, value, columnDef, dataContext) {
        if (value)
            return purchase_btn(value);
        else
            return purchase_btn(value);
    }
    $(function(){
        $(document).ready(function(){
            resizeDiv();
        });

        window.onresize = function(event) {
            resizeDiv();
        };

        function resizeDiv() {
            var vpw = $(window).width();
            var vph = $(window).height();
            $('#container').css({'min-height': (vph - 150 ) + 'px'});
        }
        $('.datetimepicker').datetimepicker({
            format: "hh:mm a",
            useCurrent: false,
            pickDate: false,
            pickTime: true
        });
        $('input[name=request]').on('click',function(e){
            var empty = false;
            $('.require').each(function(e){
                if(!$(this).val()){
                   empty = true;
                   $(this).css({'border':'1px solid #ff0000'});
                }else{
                   $(this).removeAttr('style');
                }
            });
            if(empty){
                e.preventDefault();
            }
        });
        var rowData = '',
            rowId = 0,
            cellId = 0;
        var columnsBasic = [
            {id: "address", name: "Street Address", field: "address", sortable: true},
            {id: "suburb", name: "Suburb", field: "suburb", sortable: true},
            {id: "city", name: "City", field: "city", sortable: true},
            {id: "date_report", name: "Report Date", width: 25, field: "date_report", sortable: true},
            {id: "purchase_url", name: "&nbsp;", width: 55, field: "purchase_url", sortable: true,formatter: formatter}
        ];
        $('#search-input').on('keyup',function(e){
            if($(this).val() && $(this).val().length >= 2){
                $("#search-content").css('display','');
                $('.no-result-found').css({'display':'none'});
            }else{
                $("#search-content").css({'display':'none'});
                $('.no-result-found').css({'display':'inline'});
                $('.label').remove();
            }

        });

        $.ajax({
            dataType: "json",
            url: bu + '?search=1',
            success: function(json){
                LoadGrid(json);
            }
        });

        function LoadGrid(dataFull){
            $("#search-content").slickgrid({
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
                        for (var i = 0; i < searchList.length; i += 1) {
                            found = false;
                            $.each(item, function(obj, objValue) {
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

                    $(".search-address").keyup(function (e) {
                        Slick.GlobalEditorLock.cancelCurrentEdit();

                        // clear on Esc
                        if (e.which == 27) {
                            this.value = "";
                        }
                        searchList = $.trim(this.value.toLowerCase()).split(' ');
                        searchString = this.value.toLowerCase();

                        updateFilter();
                    });


                    function updateFilter() {
                        dataView.setFilterArgs({
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

        $('.slick-row').on('click',function(){
            $('.slick-row').removeClass('active');
            $(this).addClass('active');
        });

        $('#search-content').on('click','.purchase-btn',function(e){
            e.preventDefault();
            var item_name = '';
            if(rowData.address){
                item_name += rowData.address;
            }
            if(rowData.suburb){
                item_name += (rowData.address ? ', ' : '') + rowData.suburb;
            }
            if(rowData.city){
                item_name += (rowData.suburb ? ', ' : '') + rowData.city;
            }
            $.post($(this).attr('href'),{
                purchase: 1,
                name: item_name
            },function(res){
                $('.column-content').prepend('<div class="label label-success pull-left" style="margin-bottom:10px;font-size: 13px!important;">Success! New Item added to cart.</div>');
            });

        });
        $('.remove-item').on('click',function(e){
            var _id = this.id;
            var ele =
                '<div class="modal-body">' +
                    '<div class="row">' +
                        '<div class="col-sm-12">' +
                        'Do you want to continue deleting Item?' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="modal-footer">' +
                    '<button type="button" class="btn btn-success btn-sm yes-btn" data-dismiss="modal">Yes</button>' +
                    '<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>' +
                '</div>';
            $(this).modifiedModal({
                html: ele,
                title: 'Delete Item',
                type: 'small'
            });

            $('.yes-btn').on('click',function(e){
                $.post(bu + '?p=purchase',{
                    remove: 1,
                    rowid: _id
                },function(res){
                    $('.column-' + _id).remove();
                });
            });
        });
    });
</script>
</body>
</html>
