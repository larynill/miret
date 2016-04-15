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

    /*$('.clientName').hover(
        function(){

        }
    );*/

});
</script>
<div class="grid_16">
    <a class="m-btn green" href="<?php echo base_url(). 'track/client/current'?>">Current Month</a>
    <a class="m-btn green" href="<?php echo base_url(). 'track/client/next'?>">Next Month</a>
    <div class="spinx">
    <?php
        if($monthBase == 'current_month'){
            ?>
                <div class="spinx-header">
                    <?php echo $tableHeader;?>
                </div>
                <div class="spinx-content">
                    <table cellpadding="0" cellspacing="0" border="0" class="display">
                        <thead>
                        <tr>
                            <th>Client</th>
                            <th>Equipment</th>
                            <th>Inspection Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $clientCount = 0;
                        if(count($clientData) > 0){
                            foreach($clientData as $client){
                                $clientCount++;
                                ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <a class="client"
                                           id="<?php echo $client->ID;?>"
                                           href="<?php echo base_url() . 'viewClient/' . $this->encryption->encode($client->ID); ?>"
                                           style="color:#364C50;">
                                            <?php echo $client->CompanyName; ?>
                                        </a>
                                    </td>
                                    <td style="text-align: center">
                                        <?php
                                        foreach($client->Equipment as $equip)
                                        {
                                            ?>
                                            <ul style="list-style: none">
                                                <li><?php echo $equip->PlantDescription?></li>
                                            </ul>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: center">
                                        <?php
                                        foreach($client->Equipment as $equip)
                                        {
                                            ?>
                                            <ul style="list-style: none">
                                                <li><?php echo date('d-m-Y', strtotime($equip->InspectionDate))?></li>
                                            </ul>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <!--<td style="width: 80px">
                                        <form action="<?php /*echo base_url() . 'clients/action';*/?>" method="post">
                                            <input type="hidden" name="clientID" value="<?php /*echo $client->ID; */?>"/>
                                            <input type="submit" name="sendReminder" value="remind"/>
                                        </form>
                                    </td>-->
                                </tr>
                            <?php
                            }
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
            <?php
        }
        else if($monthBase == 'next_month')
        {
            ?>
            <div class="spinx-header">
                <?php echo $nextMonthTableHeader;?>
            </div>
            <div class="spinx-content">
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                    <thead>
                    <tr>
                        <th>Client</th>
                        <th>Equipment</th>
                        <th>Inspection Date</th>
                        <th>First Reminder</th>
                        <th>Quote Request</th>
                        <th>To Manager</th>
                        <th>Quote Sent</th>
                        <th>Quote Accept</th>
                        <th>Assigned To</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($nextMonthInspectionData) > 0)
                    {
                        $clientCount = 0;
                        foreach($nextMonthInspectionData as $client)
                        {
                            $clientCount++;
                            ?>
                            <tr class="odd gradeX">
                                <td class="clientName">
                                    <a class="client"
                                       id="<?php echo $client->ID;?>"
                                       href="<?php echo base_url() . 'viewClient/' . $this->encryption->encode($client->ID); ?>"
                                       style="color:#364C50;">
                                        <?php echo $client->CompanyName; ?>
                                    </a>
                                </td>
                                <td style="text-align: center">
                                    <?php
                                    foreach($client->Equipment as $equip)
                                    {
                                        ?>
                                        <ul style="list-style: none">
                                            <li><?php echo $equip->PlantDescription?></li>
                                        </ul>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td style="text-align: center">
                                    <?php
                                    foreach($client->Equipment as $equip)
                                    {
                                        ?>
                                        <ul style="list-style: none">
                                            <li><?php echo date('d-m-Y', strtotime($equip->InspectionDate))?></li>
                                        </ul>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <!--<td style="width: 80px">
                                <form action="<?php /*echo base_url() . 'clients/action';*/?>" method="post">
                                    <input type="hidden" name="clientID" value="<?php /*echo $nextMonth->ID; */?>"/>
                                    <input type="submit" name="sendReminder" value="remind"/>
                                </form>
                            </td>-->
                            </tr>
                        <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
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

<!--popup window-->
<div id="modal" class="my-modal">
    <div id="heading">
        Quote for Inspection
    </div>
    <div id="modal_content">
        <p style="text-align: center; padding: 20px">
            Force Delete will make the client invisible from the system. <br/>
            Are you sure you want to force delete this client?
        </p>
        <div class="sep-dashed"></div>
        <div style=" padding: 0 10px 10px 0">
            <div style="text-align: right;">
                <button class="m-btn green yes" >Yes</button>
                <button class="m-btn green close" >No</button>
            </div>
        </div>
    </div>
</div>


<!--popup window-->
<div id="modal" class="equip-modal" style="width: 950px;">
    <div id="heading">
        Client Equipment
    </div>
    <div id="modal_content">
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="view-equip-table" >
            <thead>
            <tr>
                <th>No.</th>
                <th>Plant Description</th>
                <th>Equipment Number</th>
                <th>Type of Equipment</th>
                <th>Manufacturer</th>
                <th>Report Number</th>
                <th>Inspection Date</th>
                <th>Expiry Date</th>
            </tr>
            </thead>
            <tbody class="table-content">

            </tbody>
        </table>

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
</style>

