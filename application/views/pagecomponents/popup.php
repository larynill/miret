<script type="text/javascript">
    $(function(){
        $('.modal').bPopup({
            zIndex: 1000,
            closeClass: '.close',
            modalClose: false,
            modalColor: 'rgba(0, 0, 0, 0.5)',
            onOpen: function(e){

            }
        });
    });
</script>

<!--popup window-->
<div id="" class="modal">
    <div id="heading">
        Quote for Inspection
    </div>
    <div id="modal_content">
        <div class="sep-dashed"></div>
        <div style=" padding: 0 10px 10px 0">
            <div style="text-align: right;">
                <button class="m-btn green close" >Close</button>
            </div>
        </div>
    </div>
</div>
<!--popup window style-->
<style>
    .modal {
        display:none;
        width:600px;
        padding:8px;

        background:rgba(0,0,0,.3);
        z-index:101;
    }

    .modal #heading {
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

    .modal #modal_content {
        /*width:600px;*/
        background:#fcfcfc;

        -webkit-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        -moz-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        box-shadow:0px 1px 3px rgba(0,0,0,.25);
    }


    .modal #modal_content p {
        font-size:14px;
        font-weight:normal;
        line-height:22px;
        color:#555555;
        width:100%;
        margin:0;
    }
</style>