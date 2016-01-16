<title>Login | Merit Builders</title>
<style>
    body{
        background: #f3f3f3 url("<?php echo base_url(). 'plugins/img/bg_login_top.jpg'?>") no-repeat top center;
        font: 14px "Segoe UI",Helvetica,Arial,sans-serif;
    }
    .wrap{
        margin: 0 auto;
        width: 400px;
    }

    #content{
        margin: 120px 0 10px 0;
    }

    /* CONTENT MAIN START */

    #content #main{
        float: right;
        margin: 0 0 12px 0;
        width: 400px;
    }
    #main .full_w{
        background: #ffffff;
        border: 1px solid #DCDDE1;
        border-radius: 0;
        -webkit-box-shadow:  2px 2px 0px 1px rgba(235, 235, 235, 1);
        -moz-box-shadow:  2px 2px 0px 1px rgba(235, 235, 235, 1);
        box-shadow:  2px 2px 0px 1px rgba(235, 235, 235, 1);
        color: #848484;
        margin: 0 0 5px 0;
    }


    #main form{
        margin: 15px;
    }

    #main form label{
        color: #575757;
        display: block;
        font-size: 14px;
        margin: 0 0 5px 0;
        padding: 0 0 0 3px;
    }
    #main form label span{
        color: #b8b8b8;
        font-size: 11px;
        font-weight: normal;
    }
    #main form input, #main form select, #main form textarea{
        background: #FFFFFF;
        border: 1px solid #DDDDDD;
        border-radius: 0;
        font-size: 14px;

        padding: 8px;
    }
    #main form input:focus, #main form select:focus, #main form textarea:focus{	border: 1px solid #b3b3b3;}

    #main form select{
        border: 1px solid #DDDDDD;
        border-radius: 0;

    }
    #main form .text{
        margin: 0 0 12px 0;
        width: 98%;
    }

    #main form .ok{
        background: #F3F3F3 url(../../img/i_ok.png) no-repeat 4px center;
        padding-left: 25px;
    }

    #main .footer{
        margin: 0 15px;
        text-align: center;
        text-shadow: 1px 1px 0px #ffffff;
    }
    #main .footer a{
        color: #bebebe;
    }
    .sep{ border-bottom: 1px dashed #DDDDDD; margin: 10px 0;}

    .errorMessage{
        font-size: 12px;
        background-color: #666666;
        color: #fff;
    }
    .errorMessage p{
        text-align: center;
    }
</style>



<!-- microsoft buttons -->
<link type="text/css" href="<?php echo base_url(); ?>plugins/js/ui/ui-lightness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
<link href="<?php echo base_url()?>plugins/microsoft-buttons/css/m-styles.min.css" rel="stylesheet" />

<!--jQuery Plugin-->
<script src="<?php echo base_url() ?>plugins/js/ui/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>plugins/js/ui/jquery-ui-1.8.18.custom.min.js"></script>

<!--popup button-->
<script src='<?php echo base_url(); ?>plugins/popup_window/jquery.bpopup.min.js'></script>
<link href='<?php echo base_url(); ?>plugins/popup_window/popup_style.css' rel='stylesheet' />

<!-- email validation-->
<script src='<?php echo base_url(); ?>plugins/email_validate/jquery.validate.js'></script>

<link href="<?php echo base_url();?>plugins/css/addForm.css" rel="stylesheet"/>
<script src="<?php echo base_url();?>plugins/js/addForm.js" language="JavaScript"></script>

<div class="wrap">
    <div id="content">
        <div id="main">
            <div class="full_w">
                <form action="<?php echo base_url() . 'logging'?>" method="post" id="">
                <label for="login">Username:</label>
                <input id="login" name="login" class="text" />
                <label for="pass">Password:</label>
                <input id="pass" name="pass" type="password" class="text" />
                <div class="sep"></div>
                <div style="margin-left: 210px;text-align: right;">
                    <button type="submit" name="submit" class="m-btn blue login-btn">Login</button>
					<!--<button type="button" name="signup" class="m-btn green register-btn">Register</button>-->
                </div>
                </form>
				<?php echo $this->session->flashdata('_errorMessage');?>
            </div>

            <?php if($_registrationSuccess == true){
            ?>
                <div style="z-index: 9999!important;">
                    <div class="my_modal">
                        <div class="my_modal_heading">
                            Registration Successful
                        </div>
                        <div class="my_modal_modal_content">
                            <p>You are now successfully registered!</p><br/>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
    <div class="footer"></div>
</div>
<script>
    $(function(e){
        var bu = '<?php echo base_url()?>';
        $('.login-btn').click(function(e){
            var hasEmpty = false;
            $('.text').each(function(e){
                if(!$(this).val()){
                    hasEmpty = true;
                    $(this).css({
                       border:'1px solid #ff0000'
                    });
                }
            });
            if(hasEmpty){
                e.preventDefault();
            }
        });
        /*$('.register-btn').click(function(e){
            e.preventDefault();
            $(this).newForm.addNewForm({
                title:'Send Email Registration',
                url: bu +'sendRegistration',
                toFind:'.add-email'
            });
        });*/
    });
</script>