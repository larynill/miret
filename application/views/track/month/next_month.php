
<script type="text/javascript">
    $(function(){
        $('a.client').aToolTip({
            tipContent: '',
            closeTipBtn: 'aToolTipCloseBtn'
        });
        /*$('a').aToolTip({
            // no need to change/override
            closeTipBtn: 'aToolTipCloseBtn',
            toolTipId: 'aToolTip',
            // ok to override
            fixed: false,                   // Set true to activate fixed position
            clickIt: false,                 // set to true for click activated tooltip
            inSpeed: 200,                   // Speed tooltip fades in
            outSpeed: 100,                  // Speed tooltip fades out
            tipContent: '',                 // Pass in content or it will use objects 'title' attribute
            toolTipClass: 'defaultTheme',   // Set class name for custom theme/styles
            xOffset: 5,                     // x position
            yOffset: 5,                     // y position
            onShow: null,                   // callback function that fires after atooltip has shown
            onHide: null                    // callback function that fires after atooltip has faded out
        });*/
    });

</script>
<div class="spinx-header">
    <?php echo $nextMonthTableHeader;?>
</div>
<!--<a href="#" class="fixedTip exampleTip" title="Hello, I am aToolTip">Fixed Tooltip</a> - This is a fixed tooltip that doesnt follow the mouse.-->
<div class="spinx-content">
    <table cellpadding="0" cellspacing="0" border="0" class="display">
        <thead>
        <tr>
            <th>Client</th>
            <th>Equipment</th>
            <th>Inspection Due By</th>
            <th>First Reminder</th>
            <th>Quote Request</th>
            <th>To Manager</th>
            <th>Quote Sent</th>
            <th>Quote Accept</th>
            <th>Assigned To</th>
			<th>Report</th>
			<th>Invoice</th>
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
                    <td>
                        <a class="client"
                           <?php
                            $clientDateRegistered = date('F d Y', strtotime($client->DateRegistered));
                            $clientPostal = json_decode($client->PostalAdress);
							//DisplayArray($clientPostal);
							$address = is_object($clientPostal) ?
								$clientPostal->street.' '.$clientPostal->street_name.' '.$clientPostal->suburb.', '.$clientPostal->city_id.', '.$clientPostal->country_id :
								'';
                            $clientPersonInCharge = $client->PersonInCharge;
                            $clientMobilePhone = $client->MobilePhone;
                            $clientFaxNumber = $client->FaxNumber;
                            $clientEmail = $client->Email;
                            $clientLastUpdate =date('d/m/Y', strtotime( $client->LastUpdate));
                            $clientNotes = $client->Notes;
                            $clientAddress = json_decode($client->PhysicalAddress);
                            //$clientAddress = $address['address'];
                            //$clientCity = $address['city_id'];
                            //$clientCountry = $address['country_id'];
                            //$clientZip = $address['zip'];
                            $designation = $client->AreaDesignationID;
                            $workPhone = json_decode($client->WorkPhone);
                            $phoneArea = $workPhone->area_code;
                            $phoneNumber = $workPhone->number;
                            $phoneExt = $workPhone->ext;
                            $workPhone = json_decode($client->WorkPhone);
                            $phoneArea = $workPhone->area_code;
                            $phoneNumber = $workPhone->number;
                            $phoneExt = $workPhone->ext;

                            $customData = array(
                                'Contact Person: ' => $client->FirstName,
                                'Email: ' => $client->Email,
                                'Work Phone: ' => $phoneArea.$phoneNumber.$phoneExt,
                                'Mobile Phone: ' => $clientMobilePhone,
                                'Date Registered: ' => $clientDateRegistered,
                                'Address: ' => $address,

                            );
                            $customEquipData = array();
                            ?>
                           id="<?php echo $client->ID;?>"
                           href="<?php echo base_url() . 'viewClient/' . $this->encryption->encode($client->ID); ?>"
                           title="
                           <?php
                                   foreach($customData as $key=>$custom){ echo $key . $custom . '<br>';}

                                   foreach($client->Equipment as $equip)
                                   {
                                       echo '<br>';
                                       echo 'Plant Description: ' . $equip->PlantDescription . '<br>';;
                                       echo 'Equipment Number: ' . $equip->EquipmentNumber
                                           . '<br>';
                                   }
                                //foreach($customEquipData as $key=>$equip){ echo $key . $equip . '<br>';}
                           ?>"
                           style="color:#364C50;">
                            <span><?php echo $client->CompanyName; ?></span>
                        </a>
                    </td>
                    <td>
                        <?php
                        foreach($client->Equipment as $equip)
                        {
                            ?>
                            <?php echo $equip->PlantDescription.'<br/>'?>
                            <!--<ul style="list-style: none">
                                <li style="white-space: nowrap;"><?php /*echo $equip->PlantDescription*/?></li>
                            </ul>-->
                        <?php
                        }
                        ?>
                    </td>
                    <td style="text-align: center;">

                        <?php
                        foreach($client->Equipment as $equip)
                        {
                            ?>
                            <?php echo date('j-M-Y', strtotime($equip->InspectionDate)).'<br/>';?>
                            <!--<ul style="list-style: none">
                                <li style="white-space: nowrap;"><?php /*echo date('d-m-Y', strtotime($equip->InspectionDate))*/?></li>
                            </ul>-->
                        <?php
                        }
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                            if($client->FirstReminder){echo 'Sent';}
                            else{ ?>
                                <a href="<?php echo base_url() . 'request/reminder/' . $client->ID; ?>"
                                   class="m-btn green"
                                   style="margin-bottom: 5px;padding: 2px 5px 2px 5px">Force Send
                                </a>
                            <?php
                            }
                        ?>
                    </td>
                    <td class="quote-request" style="text-align: center">
                        <?php
                        if($client->QuoteRequest)
                        {
							if($client->ToManager){?>
								<span style="color: #1bb522;font-size: 12px; ">Forwarded To Manager</span>
							<?php
							}else{?>
								<span style="color: #ffa500">Received</span>
								<div style="font-size: 10px"><?php echo date('d-m-Y', strtotime($client->QuoteRequestDate)); ?></div>
							<?php
							}?>

                            <?php
                        }
                        ?>
                    </td>
                    <td style="text-align: center">

                        <?php
                        if($client->ToManager){
                            ?>
                            <span style="color: <?php echo $color = !$client->QuoteSent ? '#FF0000' : '#1bb522'?>;">Sent</span>
                            <div style="font-size: 10px"><?php echo date('d-m-Y', strtotime($client->ToManagerDate)); ?></div>
                            <?php
                        }
                        else {
                            if($client->QuoteRequest){
                            ?>
                                <a href="<?php echo base_url() .'inspection_queue/' . $client->ID .'/' . $client->TrackerID;?>"
                                   class="m-btn green"
                                   style="margin-bottom: 5px;padding: 2px 5px 2px 5px">
                                    Send
                                </a>
                            <?php
                            }
                        }
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        if($client->QuoteSent){
                            ?><span>Sent</span>
                            <div style="font-size: 10px"><?php echo date('d-m-Y', strtotime($client->QuoteSentDate)); ?></div><?php
                        }else{

                        }?>
                    </td>
                    <td style="text-align: center">
                    <?php
                    if($client->QuoteAccepted){
                        ?><span style="color: #1bb522">Accept</span>
                            <div style="font-size: 10px"><?php echo date('d-m-Y', strtotime($client->QuoteAcceptedDate)); ?></div><?php
                        }else{

                    }?>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        if($client->AssignedToID){
                            ?>
							<span style="color: #1e90ff"><?php echo $client->AssignedToName;?></span>
                            <div style="font-size: 10px"><?php echo date('d-m-Y', strtotime($client->AssignedToDate)); ?></div><?php
                        }else if(!$client->AssignedToID && $client->QuoteAccepted){?>
							<span style="color: #ff0000;">Waiting..</span>
                        <?php
						}?>
                    </td>
					<td></td>
					<td></td>
                </tr>
            <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>
<style>
    .display > tbody > tr > td span{
        padding: 5px;
    }
    .display > tbody > tr > td{
        border: 1px solid #b9b9b9;
        padding: 5px!important;
    }
</style>