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
<style>
    .odd > thead > tr > th{
        background: #000000!important;
    }
</style>