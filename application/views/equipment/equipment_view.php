<div class="grid_16">
    <div id="unique-table-3">
        <p style="text-align: center; margin-bottom: 20px; margin-top: 5px;">List of Clients existing Equipment covered under the H.S.E Hazardous Equipment Regulations</p>
        <?php
        if(count($_clientData) > 0){
            foreach($_clientData as $client){
                $clientID = $client->ID;
                $c1 = $client->CompanyName;
                $c2 = $client->FirstName . ' ' . $client->LastName;
                if($c1 == ''){
                    $header = $c2;
                }
                else {
                    $header = $c1 . ' - ' .$c2;
                }
            ?>

                <div class="unique-table-header"><a style="color: #333;font-weight: bold;text-decoration: underline" href="<?php echo base_url() . 'viewClient/' . $this->encryption->encode($clientID); ?>">
                <?php echo $header; ?></a>
                </div>
                <table class="table3">
                    <thead>
                    <tr>
                        <th>Plant Description</th>
                        <th>Equipment Number</th>
                        <th>Type of Equipment</th>
                        <th>Manufacturer</th>
                        <th>Report Number</th>
                        <th>Last Inspection Date</th>
                        <th>Inspection Frequency</th>
                        <th>Expiry Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(count($client->Equipment) > 0){
                        foreach($client->Equipment as $equip){
                            ?>
                            <tr>
                                <td><?php echo $equip->PlantDescription; ?></td>
                                <td style="text-align: center;"><?php echo $equip->EquipmentNumber; ?></td>
                                <td style="text-align: center;"><?php echo $equip->TypeEquipment; ?></td>
                                <td style="text-align: center;"><?php echo $equip->Manufacturer; ?></td>
                                <td style="text-align: center;"><?php echo $equip->LastReportNumber; ?></td>
                                <td style="text-align: center;"><?php echo date('d/m/Y', strtotime($equip->InspectionDate)) ?></td>
                                <td style="text-align: center;"><?php echo $equip->InspectionFrequency; ?></td>
                                <td style="text-align: center;"><?php echo date('d/m/Y', strtotime($equip->ExpectationDate)); ?></td>
                            </tr>
                        <?php
                        }
                    }else{?>
                        <tr>
                            <td colspan="8" style="text-align: center">No equipment has been found.</td>
                        </tr>
                    <?php
                    }?>
                    </tbody>
                </table>
            <?php
            }
        }?>


    </div>
</div>
<style>
    #unique-table-3 table{
        width: 100%;
    }
    .table3 tr td{
        background-color: #f2f2f2;
    }
    #unique-table-3 .unique-table-header{
        background-color: #dfdfdf;
        padding: 5px;
    }
	.table3 tr td,.table3 tr th{
		border: 1px solid #dbdbdb;
	}
    .table3 tr th{
        background: #484848;
        color: #ffffff;
        font-weight: normal;
    }
</style>