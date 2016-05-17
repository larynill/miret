<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'plugins/css/buttons/pattern-buttons.css'; ?>"/>

<script>
    $(function(){
        var uTable = $('#example').dataTable( {
            "sScrollY": 300,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bLengthChange": false

        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );
    });
</script>
<style type="text/css">
    td{
        text-align: center;
    }
</style>
<div class="grid_16">
    <div class="box">
        <?php
        if(count($_userDataTable) > 0){
            foreach($_userDataTable as $user)
            {
            $userType = $user->AccountType;
            /* echo $userType;*/
        ?>
        <h2>
            <a href="#" id="toggle-articles"><?php echo $dashboardHeader; ?></a>
        </h2>
        <div class="block" id="articles">
            <div class="first article">
                <div class="sixteen_column section">
                    <div class="sixteen column">
                        <div class="column_content">

                            <a href="#" class="image">
                                <img src="<?php echo base_url() . 'plugins/img/photo_60x60.jpg'?>" width="60" height="60" alt="photo" />
                            </a>
                            <h3>
                                <a href="#"><?php echo $user->Username;?></a>
                            </h3>
                            <h4></h4>
                            <p class="meta">Registered since: <?php echo date('F d, Y', strtotime($user->DateRegistered))?></p>


                        </div>
                    </div>
                </div>

                <div class="clear"></div>
            </div>
        </div>
        <div style="padding: 10px;">
            <?php
            if($userType == 6)
            {
                ?>
                    <table >
                        <thead>
                        <tr>
                            <th>Client</th>
                            <th>To Manager</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if(count($assignData) > 0)
                            {
                                foreach($assignData as $client)
                                {
                                    echo '<td>'.$client->CompanyName.'</td>';
                                    if(!$client->ToManager){
                                        echo '<td><button>'.'Pass Over'.'</button></td>';
                                    }
                                    else{
                                        echo '<td>'.'Done'.'</td>';
                                    }
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                <?php
            }
            ?>

            <?php
/*                if(count($_clientData) > 0){

                foreach($_clientData as $client){
                $name = $client->FirstName . ' ' . $client->LastName;
                $company = $client->CompanyName;
                $title = $name ? $name . ' - '. $company : $company;
                $workPhone = json_decode($client->WorkPhone);

                if(is_object($workPhone)){
                    $c3 = $workPhone->area_code .' '. $workPhone->number .' '. $workPhone->ext;
                }
                $mobilePhone = $client->MobilePhone;
                $number = $mobilePhone ? $c3 . ' - ' . $mobilePhone : $c3;
                */?><!--
                    <div style="float:left; margin-top: 15px;">
                        <span style="font-size: 18px;"><?php /*echo $title;*/?></span><br/>
                        <span style=""><?php /*echo $number;*/?></span>
                    </div>
                    <div style="float:right;">
                        <button class="m-btn"> I dont know</button>
                    </div>
                    <table >
                        <thead>
                        <tr>
                            <th >Plant Description</th>
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
/*                        if(count($client->Equipment) > 0){
                            foreach($client->Equipment as $equip){
                                $e1 = $equip->PlantDescription;
                                $e2 = $equip->EquipmentNumber;
                                $e3 = $equip->TypeEquipment;
                                $e4 = $equip->Manufacturer;
                                $e5 = $equip->LastReportNumber;
                                $e6 = date('d/m/Y', strtotime($equip->InspectionDate));
                                $e7 = date('d/m/Y', strtotime($equip->ExpectationDate));
                                */?>
                                <tr>
                                    <td style="text-align: center;"><?php /*echo $e1; */?></td>
                                    <td style="text-align: center;"><?php /*echo $e2; */?></td>
                                    <td style="text-align: center;"><?php /*echo $e3; */?></td>
                                    <td style="text-align: center;"><?php /*echo $e4; */?></td>
                                    <td style="text-align: center;"><?php /*echo $e5; */?></td>
                                    <td style="text-align: center;"><?php /*echo $e6; */?></td>
                                    <td style="text-align: center;"><?php /*echo $e7; */?></td>
                                </tr>
                            <?php
/*                            }
                        }
                        */?>
                        </tbody>
                    </table>
                    <div class="sep-dashed"></div>
                --><?php
               /* }
            }*/
            ?>

        </div>
    </div>
    <?php
        }
    }
    ?>
</div>
<style>
    table{
        width: 100%;
        margin-top: 10px;
    }
    table th{
        font-weight: normal;
    }
    table thead{
        border-bottom: 1px solid #c9c9c9;
        font-style: italic;
    }
</style>