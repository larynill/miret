<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title><?php echo $page_title;?> | Merit Builders</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="stylesheet" href="<?php echo base_url() ?>plugins/css/style.css">

    <!-- fluid 960 -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>plugins/css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>plugins/css/layout.css" media="screen" />
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
		<script src="<?php echo base_url(); ?>plugins/js/libs/jquery-1.8.2.min.js"></script>
		<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo base_url();?>js/libs/jquery-1.8.2.min.js"%3E%3C/script%3E'))</script>
	<?php }else{?>
		<script src="<?php echo base_url() ?>plugins/js/libs/jquery-1.5.1.min.js"></script>
		<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo base_url();?>js/libs/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script>
	<?php }
	?>


    <!-- //jqueryUI -->
    <script type="text/javascript" src="<?php echo base_url(); ?>plugins/js/jquery-ui-1.8.13.custom.min.js"></script>
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
	<script src="<?php echo base_url(); ?>plugins/js/superfish.js"></script>
	<script src="<?php echo base_url(); ?>plugins/js/supersubs.js"></script>
	<script src="<?php echo base_url(); ?>plugins/js/hoverIntent.js"></script>
    <!-- modernizr -->
    <script src="<?php echo base_url() ?>plugins/js/libs/modernizr-1.7.min.js"></script>
    <!-- fullcalendar -->
    <link href='<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.css' rel='stylesheet' />
    <link href='<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <script src='<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.min.js'></script>

    <script src='<?php echo base_url(); ?>plugins/js/number.js'></script>

    <!--tooltip-->
    <link href='<?php echo base_url(); ?>plugins/tooltip/atooltip.css' rel='stylesheet' media='print' />
    <script src='<?php echo base_url(); ?>plugins/tooltip/jquery.atooltip.js'></script>

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

    <!--email validation-->
    <script src="<?php echo base_url();?>plugins/js/email.validation.js" language="JavaScript"></script>

    <script language="JavaScript">
		var bu = '<?php echo base_url();?>';
        $(function(){
            //treeview for inner menus
            $("#browser").treeview({
                toggle: function() {
                    console.log("%s was toggled.", $(this).find(">span").text());
                }
            });

            // menu superfish
            $('#navigationTop').superfish();

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
            $('#dialog').dialog({
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
            });

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

            var uTable = $('#bTable').dataTable( {
                "sScrollY": 500,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "aLengthMenu" : ["All"],
                "iDisplayLength" : -1
            } );
            $(window).bind('resize', function () {
                uTable.fnAdjustColumnSizing();
            } );
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
        });
    </script>
</head>
