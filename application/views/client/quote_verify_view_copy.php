

<script type="text/javascript">
    $(function(){
        $('.confirm-btn').click(function(e){
            var clientID = this.id;

            $('#modal.confirm').bPopup({
                zIndex: 1000,
                modalClose: false,
                modalColor: 'rgba(0, 0, 0, 0.5)',

            });
        });

        $('.decline-btn').click(function(e){
            var clientID = this.id;

            $('#modal.decline').bPopup({
                zIndex: 1000,
                modalClose: false,
                modalColor: 'rgba(0, 0, 0, 0.6)',

            });
        });
    });
</script>

<?php
    if( $_errorMessage != ''){
    ?>
        <div style="padding:10px 14px; width: inherit; background-color: #e96738; color: #fff; margin-top: 20px">
            <?php echo $_errorMessage; ?>
        </div>
    <?php
    }
    else{
        if(isset($_isAccepted)){
            if($_isAccepted == true){ // if the quote confirmation is accepted
                ?>
                <div style="padding:10px 14px; width: inherit; background-color: goldenrod; color: #fff; margin-top: 20px">
                    You have accepted the quote. We will be updating you through emails.
                </div>

            <?php
            }else{
                ?>
                <div style="padding:10px 14px; width: inherit; background-color: #e96738; color: #fff; margin-top: 20px">
                    You declined the quote. If you really wish to decline, could you please state the reason.
                </div>
                <br/><br/>
                <form>
                    <label>Reason: </label>
                    <textarea rows="8" cols="20"></textarea>
                    <button class="m-btn green" style="float: right">Submit</button>
                </form>
            <?php
            }
        }else{

            if(count($_clientData) > 0){
                foreach($_clientData as $client){
                    $name = $client->FirstName . ' ' . $client->LastName;
                    $company = $client->CompanyName;
                    $clientID = $client->ID;
                    ?>
                    <div>
                        <h2><?php echo $name;?></h2>
                        <h3><?php echo $company; ?></h3>
                        <p>
                            You have a total of $0.00 charge for the equipment inspection.
                        </p>
                        <p>
                            Would you like to accept the quote?
                        </p>
                        <button class="m-btn green confirm-btn" id="<?php echo $clientID; ?>">Confirm</button>
                        <button class="m-btn green decline-btn" id="<?php echo $clientID; ?>">Decline</button>
                    </div>
                <?php
                }
            }
        }
    }
?>

<?php


?>

<!--popup window-->
<div id="modal" class="confirm">
    <div id="heading">
        Confirm Inspection
    </div>
    <div id="modal_content">
        <p style="">Are you sure you want to confirm the inspection?</p>
        <br/>

        <form method="post" action="">
        <button class="m-btn green" name="confirm">Yes, Confirm</button> <br/> <br/>
        </form>
    </div>
</div>

<!--popup window-->
<div id="modal" class="decline">
    <div id="heading">
        Decline Inspection
    </div>
    <div id="modal_content">
        <p style="">Are you sure you do not want to continue with <br/> the inspection?</p>
        <br/>

        <form method="post" action="">
            <button class="m-btn green" name="decline">No, Decline</button> <br/> <br/>
        </form>
    </div>
</div>






<!--popup window style-->
<style>
    #modal {
        display:none;
        width:400px;
        padding:8px;
        background:rgba(0,0,0,.3);
        z-index:101;
    }
    #heading {
        width:400px;
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
        width:400px;
        background:#fcfcfc;

        -webkit-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        -moz-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        box-shadow:0px 1px 3px rgba(0,0,0,.25);
        text-align: center;
    }
    #modal_content p {
        font-size:14px;
        padding: 10px 10px 0 10px;
        font-weight:normal;
        line-height:22px;
        color:#555555;
        width:100%;
        margin:0;

    }
</style>

<style>
    .small-heading{
        font-size: 20px;
        padding: 10px 14px;
        margin-left: 20px;
    }
    .division3{
        width: 100%;
        margin: 0;
        padding: 0;
    }
    table{
        width: 100%;
        margin-bottom: 50px;
    }
    table thead th{
        font-weight: normal;
        font-style: italic;
    }
    .division3 div{
        font-size: 22px;
    }
    .sep-bold{
        border: 1px solid #000;
    }
</style>