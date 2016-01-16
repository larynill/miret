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
        background: #F3F3F3 url(../img/i_ok.png) no-repeat 4px center;
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
<link href="<?php echo base_url()?>plugins/microsoft-buttons/css/m-styles.min.css" rel="stylesheet" />

<!--jQuery Plugin-->
<script src='<?php echo base_url(); ?>plugins/js/libs/jquery-1.10.2.min.js'></script>
<script src='<?php echo base_url(); ?>plugins/js/jquery-ui-1.8.13.custom.min.js'></script>

<!--popup button-->
<script src='<?php echo base_url(); ?>plugins/popup_window/jquery.bpopup.min.js'></script>
<link href='<?php echo base_url(); ?>plugins/popup_window/popup_style.css' rel='stylesheet' />

<!-- email validation-->
<script src='<?php echo base_url(); ?>plugins/email_validate/jquery.validate.js'></script>

<script>
    $(function(){
        $('.sign_up_btn').click(function(e){
            e.preventDefault();
            $('#modal').bPopup({
                appendTo: '#required-form',
                zIndex: 2,
                modalClose: true,
                modalColor: 'rgba(0, 0, 0, 0.5)'
            });
        });
        $('.my_modal').bPopup({
            appendTo: '#required-form',
            zIndex: 2,
            modalClose: true,
            modalColor: 'rgba(0, 0, 0, 0.5)',
            onClose: function(e){
                location.reload();
            }
        });


        $("form#required-form").validate({
            rules:{
                Username: {
                    required: true,
                    minlength: 4

                },
                Password:{
                    required: true,
                    minlength: 6
                },
                PasswordConfirm: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },
                EmailAddress:{
                    required: true,
                    email: true
                },
                AccountType:{
                    required: true
                },
                Authenticate: {
                    required: true
                }
            }
        });


        $("#type_dropdown").change(function(e){
            if($(this).val() == 1 || $(this).val() == 2 ){
                if($('#authen').length <= 0){ // check if element exists.
                    $('.authenticate').append(
                        '<br/><label>Authentication:</label><input type="password" name="Authenticate" id="authen"/>'
                    );
                }
            }
        });

    });
</script>

<div class="wrap">
    <div id="content">
        <div id="main">
            <div class="full_w">
                <form action="" method="post" id="">
                <label for="login">Username:</label>
                <input id="login" name="login" class="text" />
                <label for="pass">Password:</label>
                <input id="pass" name="pass" type="password" class="text" />
                <div class="sep"></div>
                <div style="margin-left: 210px">
                    <button type="submit" name="signup" class="m-btn green sign_up_btn">Register</button>
                    <button type="submit" name="submit" class="m-btn blue">Login</button>
                </div>
                </form>
                <?php if($_hasLogError){
                ?>
                    <div class="ui-widget" style="color:red">
                        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
                            <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                                <strong>Alert:</strong> <?php echo $_errorMessage;?></p>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>

            <form action="" method="post" id="required-form">
                <div id="modal" class="">
                    <div id="heading">
                       Signup form
                    </div>
                    <div id="modal_content">
                        <div id="signup_form">
                            <div class="element">
                                <label><em class="required">*</em> Username:</label>
                                <input type="text" name="Username"class=""/>
                            </div>
                            <div class="element">
                                <label><em class="required">*</em> Password:</label>
                                <input type="password" name="Password" id="password">
                            </div>
                            <div class="element">
                                <label>Re-type Password:</label>
                                <input type="password" name="PasswordConfirm">
                            </div>
                            <div class="element">
                                <label><em class="required">*</em> Email Address:</label>
                                <input type="text" name="EmailAddress" class=" email error"/>
                            </div>
                            <div class="element">
                                <label><em class="required">*</em> Account Type:</label>
                                <?php
                                    $attr = array('id' => 'type_dropdown');
                                    echo form_dropdown('AccountType', $_accountType, 5, 'id="type_dropdown"');
                                ?>
                            </div>
                            <div class="authenticate"></div>
                            <div class="sep"></div>
                            <div class="element">
                                <button class="m-btn green" name="signup" id="signup_btn" >Yes, Sign me up!</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php if($_registrationSuccess == true){
            ?>
                <div>
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
