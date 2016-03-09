<script type="text/javascript">
    $(function(){
        $('.confirm-btn').click(function(e){
            var clientID = this.id;

            $('.quoteAccepted').bPopup({
                zIndex: 1000,
                modalClose: true,
                modalColor: 'rgba(0, 0, 0, 0.5)'
            });
            $('.confirm').bPopup({
                zIndex: 1000,
                modalClose: false,
                closeClass: ('.no-btn'),
                modalColor: 'rgba(0, 0, 0, 0.5)',
                onOpen : function(e){
                    $('.yes-btn').click(function(e){
                        $.post(
                            '',
                            {
                                confirm:true
                            },function(e){
                                location.reload();
                            }
                        );
                    });
                }
            });
        });

        $('.decline-btn').click(function(e){
            var clientID = this.id;

            $('.decline').bPopup({
                zIndex: 1000,
                modalClose: false,
                modalColor: 'rgba(0, 0, 0, 0.6)',
                onOpen : function(e){
                    $('.yes-btn').click(function(e){
                        $.post(
                            '',
                            {
                                decline:true
                            },function(e){
                                location.reload();
                            }
                        );
                    });
                }
            });
        });
    });
</script>
<div class="grid_16">
<?php
    if(count($_clientData) > 0){
    foreach($_clientData as $client){
    $name = $client->FirstName . ' ' . $client->LastName;
    $company = $client->CompanyName;
    $clientID = $client->ID;
    ?>

    <div>
        <div class="small-heading">
            Potential Inspections for Month of <?php echo date('F', strtotime('+ 1 month')); ?>
        </div>
    </div>

        <div>
            <p style="font-size: 18px; font-weight: bold">
                <em style="float:left"><?php echo $company;?></em>
                <em style="margin-left: 15%"> &nbsp  </em>
                <em style="float:right"> <?php echo $name;?></em>
            </p>
        </div>
        <div class="sep-bold"></div>
        <table class="table table-colored-header">
            <thead>
            <tr>
                <th>Plant Description</th>
                <th>Equipment Number</th>
                <th>Type of Equipment</th>
                <th>Manufacturer</th>
                <th>Report Number</th>
                <th>Inspection Date</th>
                <th>Expiry Date</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(count($client->Equipment) > 0){
                foreach($client->Equipment as $equip){
                    $e1 = $equip->PlantDescription;
                    $e2 = $equip->EquipmentNumber;
                    $e3 = $equip->TypeEquipment;
                    $e4 = $equip->Manufacturer;
                    $e5 = $equip->LastReportNumber;
                    $e6 = date('F d, Y', strtotime($equip->InspectionDate));
                    $e7 = date('F d, Y', strtotime($equip->ExpectationDate));
                    ?>
                    <tr>
                        <td><?php echo $e1; ?></td>
                        <td style="text-align: center;"><?php echo $e2; ?></td>
                        <td style="text-align: center;"><?php echo $e3; ?></td>
                        <td style="text-align: center;"><?php echo $e4; ?></td>
                        <td style="text-align: center;"><?php echo $e5; ?></td>
                        <td style="text-align: center;"><?php echo $e6; ?></td>
                        <td style="text-align: center;"><?php echo $e7; ?></td>
                    </tr>
                <?php
                }
            }
            ?>
            </tbody>
        </table>
        <div style="float:right;">
        <button class="m-btn green confirm-btn" id="<?php echo $clientID; ?>">Confirm</button>
        <button class="m-btn green decline-btn" id="<?php echo $clientID; ?>">Decline</button>
        </div>
    <?php
    }
}
else{
    if($_errorMessage){
    ?>
        <div style="padding:10px 14px; width: inherit; background-color: #e96738; color: #fff; margin-top: 20px">
            <?php echo $_errorMessage; ?>
        </div>
    <?php
    }

    if($this->session->flashdata('quoteAccepted')){
    ?>
        <!--popup window-->
        <div class="modal quoteAccepted">
            <div id="heading">
                Quote Accepted
            </div>
            <div id="modal_content">
                <p style="">Thank you for accepting the quote!</p>
                <br/>
            </div>
        </div>
    <?php
    }
}
?>
</div>

<!--popup window-->
<div class="modal confirm">
    <div id="heading">
        Confirm Inspection
    </div>
    <div id="modal_content">
        <p style="">Are you sure you want to confirm the inspection?</p>
        <br/>
        <button class="m-btn green no-btn" >No</button>
        <button class="m-btn green yes-btn" >Yes, Confirm</button><br/> <br/><br/>
    </div>
</div>

<!--popup window-->
<div class="modal decline">
    <div id="heading">
        Decline Inspection
    </div>
    <div id="modal_content">
        <p style="">Are you sure you do not want to continue with <br/> the inspection?</p>
        <br/>

        <button class="m-btn green no-btn" >No</button>
        <button class="m-btn green yes-btn" >Yes, Decline</button><br/> <br/><br/>
    </div>
</div>

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

    .modal p{
        text-align: center;
    }
    .modal button{
        float: right;
        margin: 10px;
    }
</style>