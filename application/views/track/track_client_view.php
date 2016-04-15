<script type="text/javascript">
    $(function(){
        var uTable = $('.display').dataTable( {
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bLengthChange": false
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );
        $('.spinx-content.toggle').hide();
        $('.toggle-spinx').click(function(e){

            $('.spinx-content.toggle').toggle(
                "blind",            //effect
                {                       //options
                    queue: false
                },
                500                     //duration
            );
        });

		/*var clientLink = $('.client');
    	var clientInfoArea = $('.clientInfoArea');
    	var cEle = '<div class="clientInfoArea">HEigasdas asdasd </div>';
    	clientLink.hover(
        	function(e){
            		$(this).append(cEle);
            		
            		var left = $(this).innerWidth();
            		var top = clientInfoArea.innerHeight();
            		console.log(wid);
            		clientInfoArea.css({
        				margin: '-' + wid + 'px'
            		});
			clientInfoArea.load();
        	},
        	function(e){
            		$('.clientInfoArea').remove();
        	}
    	);*/
        /*$('a.fixedTip').aToolTip({
            clickIt: true,
            tipContent: 'hello',
            closeTipBtn: 'aToolTipCloseBtn'
        });
        */
        $('a.client').aToolTip({
            clickIt: true,
            tipContent: '<?php $this->load->view('track/hover/client_information_view');?>',
            closeTipBtn: 'aToolTipCloseBtn'
        });
    });
</script>
<div class="grid_16">
    <!--<a class="m-btn green" href="<?php /*echo base_url(). 'track/client/current'*/?>">Current Month</a>
    <a class="m-btn green" href="<?php /*echo base_url(). 'track/client/next'*/?>">Next Month</a>-->
    <div class="spinx">
        <?php
        if($monthBase == 'current_month'){
            $this->load->view('track/month/current_month');
        }
        else if($monthBase == 'next_month')
        {
            $this->load->view('track/month/next_month');
        }
        ?>
    </div>
</div>

<!--popup window-->
<div id="modal" class="quote-modal">
    <div id="heading">
        Quote for Inspection
    </div>
    <div id="modal_content">
        <p style="text-align: center; padding: 10px 14px">Force quote sending will tolerate the email notification for sending quote.</p>
        <p style="text-align: center; padding: 10px 14px">Quote calculation will be process here soon.</p>
        <div class="sep-dashed"></div>
        <div style=" padding: 0 10px 10px 0">
            <p style="text-align: center; padding: 10px">Do you want to forcefully send a quote?</p>
            <div style="text-align: right;">
                <button class="m-btn green accept" >Yes</button>
                <button class="m-btn green close" >No</button>
            </div>
        </div>
    </div>
</div>





<!--popup window style-->
<style>

    #modal {
        display:none;
        width:600px;
        padding:8px;

        background:rgba(0,0,0,.3);
        z-index:101;
    }

    #heading {
        /*width:600px;*/
        height:44px;

        background-color: coral;
        border-bottom:1px solid #bababa;

        -webkit-box-shadow:
            inset 0px -1px 0px #fff,
            0px 1px 3px rgba(0,0,0,.08);
        -moz-box-shadow:
            inset 0px -1px 0px #fff,
            0px 1px 3px rgba(0,0,0,.08);
        box-shadow:
            inset 0px -1px 0px #fff,
            0px 1px 3px rgba(0,0,0,.08);

        font-size:18px;
        text-align:center;
        line-height:44px;
        color:#ffffff;

    }

    #modal_content {
        /*width:600px;*/
        background:#fcfcfc;

        -webkit-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        -moz-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        box-shadow:0px 1px 3px rgba(0,0,0,.25);
    }


    #modal_content p {
        font-size:14px;
        font-weight:normal;
        line-height:22px;
        color:#555555;
        width:100%;
        margin:0;
    }
</style>




<style>
    table td{
        padding: 0 !important;
        margin: 0 !important;
    }
    ul
    {
        padding: 0 !important;
        margin: 0 !important;
    }
    .display .odd{
        background-color: #e9e9e9;
    }
    .display .even{
        background-color: #f3f3f3;
    }
    #example td{

    }
    .spinx{
        margin-top: 20px;
        width: 100%;
        font-size: 14px;
    }
    .spinx .spinx-header{
        padding: 10px 14px;
        background-color: #35aa47;
        color: #fff;
        cursor: pointer;
    }
    #section-menu{
        font: inherit;
    }
    #section-menu li a{
        padding: 10px;
    }

	.clientInfoArea{
		position: absolute;
		z-index: 99;
		border: 1px solid #000000;
	}
</style>

<style type="text/css">
    .quote-request{
        cursor: pointer;
    }

    #aToolTip {
        position: absolute;
        display: none;
        z-index: 50000;
    }

    #aToolTip .aToolTipContent {
        position:relative;
        margin:0;
        padding:0;
    }
    .defaultTheme {
        border:2px solid #444;
        background:#555;
        color:#fff;
        margin:0;
        padding:6px 12px;
        font-size: 12px;
        -moz-border-radius: 12px 12px 12px 0;
        -webkit-border-radius: 12px 12px 12px 0;
        -khtml-border-radius: 12px 12px 12px 0;
        border-radius: 12px 12px 12px 0;

        -moz-box-shadow: 2px 2px 5px #111;  for Firefox 3.5+
    -webkit-box-shadow: 2px 2px 5px #111;  for Safari and Chrome
        box-shadow: 2px 2px 5px #111;  for Safari and Chrome
        }

    .defaultTheme #aToolTipCloseBtn {
        display:block;
        height:18px;
        width:18px;
        background:url(<?php echo base_url() . 'plugins/tooltip/closeBtn.png'?>) no-repeat;
        text-indent:-9999px;
        outline:none;
        position:absolute;
        top:-20px;
        right:-30px;
        margin:2px;
        padding:4px;
    }
</style>