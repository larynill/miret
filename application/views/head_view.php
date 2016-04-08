<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php echo $page_title;?> | Synergy Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--<link rel="shortcut icon" href="/favicon.ico">-->
    <!--<link rel="apple-touch-icon" href="/apple-touch-icon.png">-->
    <link rel="stylesheet" href="<?php echo base_url() ?>plugins/css/style.css">

    <!-- fluid 960 -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>plugins/css/text.css" media="screen" />
    <!--<link rel="stylesheet" type="text/css" href="<?php /*echo base_url() */?>plugins/css/layout.css" media="screen" />-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>plugins/css/grid.css" media="screen" />

    <!-- superfish menu -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>plugins/css/superfish.css" media="screen" />

    <!-- tags css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/css/jquery.tagsinput.css">

    <!-- treeview css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/css/jquery.treeview.css">

    <!-- dataTable css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/css/demo_table_jui.css">

    <!-- fluid GS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>plugins/css/fluid.gs.css" media="screen" />
    <!--[if lt IE 8 ]>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>plugins/css/fluid.gs.lt_ie8.css" media="screen"/>
    <![endif]-->

    <!-- //jqueryUI css -->
    <link type="text/css" href="<?php echo base_url(); ?>plugins/css/custom-theme/jquery-ui-1.8.13.custom.css" rel="stylesheet" />

    <!-- //jquery -->
	<?php
	if($this->session->userdata('registration_page') != 'equipment' && $this->session->userdata('registration_page') != 'accounting'){
	?>
		<script src="<?php echo base_url(); ?>plugins/js/libs/jquery-1.10.2.min.js"></script>
		<!--<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php /*echo base_url();*/?>js/libs/jquery-1.8.2.min.js"%3E%3C/script%3E'))</script>-->
	<?php }else{?>
		<script src="<?php echo base_url() ?>plugins/js/libs/jquery-1.10.1.min.js"></script>
		<!--<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php /*echo base_url();*/?>js/libs/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script>-->
	<?php }
	?>


    <!-- //jqueryUI -->
    <script type="text/javascript" src="<?php echo base_url(); ?>plugins/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>plugins/js/jquery-fluid16.js"></script>

    <script src="<?php echo base_url(); ?>plugins/js/jquery.tagsinput.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/css/jquery.tagsinput.css">

    <!--[if lt IE 7 ]>
    <script src="<?php echo base_url(); ?>plugins/js/libs/dd_belatedpng.js"></script>
    <script> DD_belatedPNG.fix('img, .png_bg');</script>
    <![endif]-->
	<!-- treeview -->
	<script src="<?php echo base_url(); ?>plugins/js/jquery.treeview.js"></script>

	<!-- dataTable -->
	<script src="<?php echo base_url(); ?>plugins/js/jquery.dataTables.min.js"></script>

	<!-- superfish menu and needed js for menu -->
	<!--<script src="<?php /*echo base_url(); */?>plugins/js/superfish.js"></script>
	<script src="<?php /*echo base_url(); */?>plugins/js/supersubs.js"></script>
	<script src="<?php /*echo base_url(); */?>plugins/js/hoverIntent.js"></script>-->
    <!-- modernizr -->
    <!--<script src="<?php /*echo base_url() */?>plugins/js/libs/modernizr-1.7.min.js"></script>-->
    <!--Bootstrap Datepicker-->
    <script src="<?php echo base_url();?>plugins/js/bootstrap-datepicker.js"></script>

    <!-- fullcalendar -->
    <script src='<?php echo base_url(); ?>plugins/fullcalendar/moment.js'></script>
    <link href='<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.css' rel='stylesheet' />
    <link href='<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <script src='<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.min.js'></script>

    <script src='<?php echo base_url(); ?>plugins/js/number.js'></script>

    <!--tooltip-->
    <!--<link href='<?php /*echo base_url(); */?>plugins/tooltip/atooltip.css' rel='stylesheet' media='print' />
    <script src='<?php /*echo base_url(); */?>plugins/tooltip/jquery.atooltip.js'></script>-->

    <!-- microsoft buttons -->
    <link href="<?php echo base_url()?>plugins/microsoft-buttons/css/m-styles.min.css" rel="stylesheet" />
    <script src="<?php echo base_url()?>plugins/popup_window/jquery.bpopup.min.js" type="text/javascript"></script>

	<!--pop new form-->
	<script language="JavaScript" src="<?php echo base_url();?>/plugins/js/select.country.js"></script>

	<!--fancy box-->
	<link href="<?php echo base_url()?>plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
	<script src="<?php echo base_url()?>plugins/fancybox/source/jquery.fancybox.js" type="text/javascript"></script>


    <!--add new form-->
    <link href="<?php echo base_url();?>plugins/css/addForm.css" rel="stylesheet"/>
    <script src="<?php echo base_url();?>plugins/js/addForm.js" language="JavaScript"></script>

    <!--Bootstrap-->
    <link href="<?php echo base_url();?>plugins/css/bootstrap.css" rel="stylesheet"/>
    <link href="<?php echo base_url();?>plugins/css/bootstrap-theme.css" rel="stylesheet"/>
    <script src="<?php echo base_url();?>plugins/js/bootstrap.min.js"></script>

    <!--Bootstrap Datetimepicker-->
    <link href="<?php echo base_url();?>plugins/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="<?php echo base_url();?>plugins/js/bootstrap-datetimepicker.js"></script>

    <!--Multi-select-->
    <link href="<?php echo base_url();?>plugins/multi-select/css/bootstrap-multiselect.css" rel="stylesheet">
    <script src="<?php echo base_url();?>plugins/multi-select/js/bootstrap-multiselect.js"></script>

    <!--Slick Grid-->
    <link href="<?php echo base_url();?>plugins/slick-grid/css/example-bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>plugins/slick-grid/css/slick.grid.css" rel="stylesheet">
    <script src="<?php echo base_url();?>plugins/slick-grid/js/jquery.event.drag-2.2.js"></script>
    <script src="<?php echo base_url();?>plugins/slick-grid/js/slick.core.js"></script>
    <script src="<?php echo base_url();?>plugins/slick-grid/js/slick.rowselectionmodel.js"></script>
    <script src="<?php echo base_url();?>plugins/slick-grid/js/slick.formatters.js"></script>
    <script src="<?php echo base_url();?>plugins/slick-grid/js/slick.editors.js"></script>
    <script src="<?php echo base_url();?>plugins/slick-grid/js/slick.grid.js"></script>
    <script src="<?php echo base_url();?>plugins/slick-grid/js/slick.dataview.js"></script>
    <script src="<?php echo base_url();?>plugins/slick-grid/js/bootstrap-slickgrid.js"></script>

    <!--Font Awesome-->
    <link href="<?php echo base_url();?>plugins/font-awesome-4.1.0/css/font-awesome.css" rel="stylesheet">

    <!--Modified Modal-->
    <script src="<?php echo base_url();?>plugins/js/modified-modal.js"></script>

    <!--Date Format-->
    <script src="<?php echo base_url();?>plugins/js/jquery-dateFormat.js"></script>

    <!--email validation-->
    <script src="<?php echo base_url();?>plugins/js/email.validation.js"></script>
    <script src="<?php echo base_url();?>plugins/js/idle-timer.js"></script>


    <script>
        /*$.ajaxSetup({ cache: true });*/
		var bu = '<?php echo base_url();?>';
        var hasRecordPage = 1;
        var page_uri = '<?php echo $this->uri->segment(1); ?>';
        $(function(){
            //treeview for inner menus
            /*$("#browser").treeview({
                toggle: function() {
                    console.log("%s was toggled.", $(this).find(">span").text());
                }
            });*/

            // menu superfish
            //$('#navigationTop').superfish();

            // tags
            $("#tags_input").tagsInput();

            // Accordion
            $("#accordion").accordion({ header: "h3" });

            // Accordion2
            $("#accordion2").accordion({ header: "h3" });

            // Tabs
            $('#tabs').tabs();
            $('#tabsOut').tabs();


            // Dialog
            /*$('#dialog').dialog({
                autoOpen: false,
                width: 600,
                buttons: {
                    "Ok": function() {
                        $(this).dialog("close");
                    },
                    "Cancel": function() {
                        $(this).dialog("close");
                    }
                }
            });

            // Dialog Link
            $('#dialog_link').click(function(){
                $('#dialog').dialog('open');
                return false;
            });*/

            // Slider
            $('#slider').slider({
                range: true,
                values: [17, 67]
            });

            // Progressbar
            $("#progressbar").progressbar({
                value: 20
            });

            //hover states on the static widgets
            $('#dialog_link, ul#icons li').hover(
                function() { $(this).addClass('ui-state-hover'); },
                function() { $(this).removeClass('ui-state-hover'); }
            );

            /*var uTable = $('#bTable').dataTable( {
                "sScrollY": 500,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "aLengthMenu" : ["All"],
                "iDisplayLength" : -1
            } );
            $(window).bind('resize', function () {
                uTable.fnAdjustColumnSizing();
            } );*/
			$('.time').numberOnly({
				"hasMaxChar": true,
				"maxCharLen": 0
			});

            $('.sendRegistrationBtn').click(function(e){
                e.preventDefault();
                $(this).newForm.addNewForm({
                    title:'Send Email Registration',
                    url:'<?php echo base_url().'sendRegistration'?>',
                    toFind:'.add-email'
                });
                //console.log('click');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script src="<?php echo base_url();?>plugins/js/notifications.js"></script>
</head>
