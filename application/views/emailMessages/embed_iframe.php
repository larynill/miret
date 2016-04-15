<link type="text/css" href="<?php echo base_url();?>plugins/js/ui/ui-lightness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />

<script src="<?php echo base_url();?>plugins/js/ui/jquery.js"></script>
<script src="<?php echo base_url();?>plugins/js/ui/jquery-ui-1.8.18.custom.min.js"></script>
<script src='<?php echo base_url();?>plugins/js/number.js' language="JavaScript"></script>
<?php
ini_set("memory_limit","512M");
set_time_limit(900000);
header("Content-type: text/html");

echo form_open_multipart('mail_registration/'.$this->uri->segment(2));
?>
<div style="border: 1px solid #d2d2d2;font-family: Arial,sans-serif;width: 850px;background: #e8e7b7">
	<table style="width: 100%;">
		<tr>
			<td style="padding: 20px 5px;text-align: left;width: 150px!important;">
				<img src="<?php echo base_url();?>plugins/img/sample-logo.png" width="250"><br/>
				<strong style="text-transform: uppercase;">Universal Inspector</strong><br/>
				<span>Long Street, Auckland</span><br/>
				<span>P.O Box </span><br/>
				<span>Email:</span>
			</td>
		</tr>
		<tr>
			<th colspan="3" style="padding: 15px 5px 5px ;border-bottom: 1px solid #d2d2d2;border-top: 1px solid #d2d2d2;text-transform: uppercase;">
				Registration Form
			</th>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="3">Company Name:</td>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="3"><input type="text" name="CompanyName" style="padding: 5px;width: 98%;"></td>
		</tr>
		<tr>
			<td style="padding: 5px;font-weight: bold;border-bottom: 1px solid #d2d2d2" colspan="3">Contact Person:</td>
		</tr>
		<tr>
			<td style="padding: 5px;">First Name:</td>
			<td style="padding: 5px;">Last Name:</td>
		</tr>
		<tr>
			<td style="padding: 5px;"><input type="text" name="FirstName" style="padding: 5px;width: 95%;"></td>
			<td style="padding: 5px;" colspan="2"><input type="text" name="LastName" style="padding: 5px;width: 95%;"></td>
		</tr>
		<tr>
			<td style="font-weight: bold;border-bottom: 1px solid #d2d2d2;" colspan="3">Physical Address</td>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="3">
				Street Number:
				<input type="text" name="PhysicalAddress[]" style="padding: 5px;width: 10%;">
				Street Name:
				<input type="text" name="PhysicalAddress[]" style="padding: 5px;width: 30%;">
				Suburb:
				<input type="text" name="PhysicalAddress[]" style="padding: 5px;width: 25%;">
			</td>
		</tr>
		<tr>
			<td style="padding: 5px;">City/Town:</td>
			<td style="padding: 5px;">Country:</td>
			<td style="padding: 5px;">Postal Code:</td>
		</tr>
		<tr>
			<td style="padding: 5px;"><?php echo form_dropdown('PhysicalAddress[]',$city,'','style="padding: 5px;width: 100%;"')?></td>
			<td style="padding: 5px;"><?php echo form_dropdown('PhysicalAddress[]',array('163' => 'New Zealand'),'','style="padding: 5px;width: 100%;"')?></td>
			<td style="padding: 5px;"><input type="text" name="PhysicalAddress[]" style="padding: 5px;width: 95%;" class="number-input"></td>
		</tr>
		<tr>
			<td style="font-weight: bold;border-bottom: 1px solid #d2d2d2;">Postal Address</td>
			<td style="border-bottom: 1px solid #d2d2d2;" colspan="2">
				Is the same as Physical Address?
				Yes <input type="radio" name="option" value="Yes" checked="">
				No <input type="radio" name="option" value="No">
			</td>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="3">
				Box Number:
				<input type="text" name="PostalAddress[]" style="padding: 5px;width: 15%;">
				Suburb:
				<input type="text" name="PostalAddress[]" style="padding: 5px;width: 50%;">
			</td>
		</tr>
		<tr>
			<td style="padding: 5px;">City/Town:</td>
			<td style="padding: 5px;">Country:</td>
			<td style="padding: 5px;">Postal Code:</td>
		</tr>
		<tr>
			<td style="padding: 5px;"><?php echo form_dropdown('PostalAddress[]',$city,'','style="padding: 5px;width: 100%;"')?></td>
			<td style="padding: 5px;"><?php echo form_dropdown('PostalAddress[]',array('163' => 'New Zealand'),'','style="padding: 5px;width: 100%;"')?></td>
			<td style="padding: 5px;"><input type="text" name="PostalAddress[]" style="padding: 5px;width: 95%;" class="number-input"></td>
		</tr>
		<tr>
			<td style="font-weight: bold;border-bottom: 1px solid #d2d2d2;" colspan="3">Work Phone</td>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="3">
				Area Code: <input type="text" name="WorkPhone[]" style="padding: 5px;width: 10%;" class="number-input">
				Number: <input type="text" name="WorkPhone[]" style="padding: 5px;width: 20%;" class="number-input">
				Extension: <input type="text" name="WorkPhone[]" style="padding: 5px;width: 30%;" class="number-input">
			</td>

		</tr>
		<tr>
			<td style="padding: 5px;" colspan="2">Email:</td>
			<td style="padding: 5px;">Mobile Phone:</td>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="2"><input type="text" name="Email" style="padding: 5px;width: 95%;"></td>
			<td style="padding: 5px;"><input type="text" name="MobilePhone" style="padding: 5px;width: 95%;" class="number-input"></td>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="2">Person In Charge:</td>
			<td style="padding: 5px;">Fax Number:</td>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="2"><input type="text" name="PersonInCharge" style="padding: 5px;width: 95%;"></td>
			<td style="padding: 5px;"><input type="text" name="FaxNumber" style="padding: 5px;width: 95%;" class="number-input"></td>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="3">Notes:</td>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="3"><textarea name="Notes" style="font-family: Arial, sans-serif;width: 99%;height: 100px;"></textarea></td>
		</tr>
		<tr>
			<th colspan="3" style="padding: 5px;border-bottom: 1px solid #d2d2d2;text-transform: uppercase;">Equipment Registration</th>
		</tr>
		<tr>
			<td style="padding:5px;border-bottom: 1px solid #d2d2d2;" colspan="3"><input type="file" name="uploadFile" style="cursor: pointer;width: 500px;" accept=".xls"></td>
		</tr>
		<tr>
			<td style="padding:5px;">Your excel file must contain the following order of column:</td>
		</tr>
		<tr>
			<?php
			$dataArr = array(
				"Equipment Number",
				"Plant Description",
				"Type of Equipment",
				"Manufacturer",
				"Inspection Date",
				"Expiry Date",
			);
			echo '<td>';
			foreach($dataArr as $k=>$v){
				echo $k + 1 .'. '.$v.' <br/>';
			}
			echo '</td>';

			$data = array(
				"Haz Equip/IQP's",
				"Repairs",
				"Sold/Out of Service",
				"SWL",
				"Certificate Number",
				"Additional Information"
			);

			echo '<td colspan="2">';
			$ref = 6;
			foreach($data as $k=>$v){
				echo $ref + 1 .'. '.$v.' <br/>';
				$ref++;
			}
			echo '</td>';
			?>
		</tr>
        <tr>
            <td colspan="3" style="border-bottom: 1px solid #d2d2d2;padding-top: 20px;color: #ff0000">
                Note: Your excel file would be .xls file so that you can upload your file to the system.
            </td>
        </tr>
		<tr>
			<th colspan="3" style="padding: 5px;border-bottom: 1px solid #d2d2d2;text-transform: uppercase;">Account Registration</th>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="3">Contact Person (Account):</td>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="3"><input type="text" name="AccountContactPerson" style="padding: 5px;width: 98%;"></td>
		</tr>
		<tr>
			<td style="padding: 5px;font-weight: bold;border-bottom: 1px solid #d2d2d2;" colspan="3">Tel. No.</td>
		</tr>
		<tr>
			<td style="padding: 5px;" colspan="3">
				Number:
				<input type="text" name="TelNo[]" style="padding: 5px;width: 10%;" class="number-input">
				Extension:
				<input type="text" name="TelNo[]" style="padding: 5px;width: 15%;" class="number-input">
				Email Address:
				<input type="text" name="AccountMail" style="padding: 5px;width: 42%;" >
			</td>
		</tr>
		<!--<tr>
			<td style="padding: 5px;" colspan="3">
				Email Address:
				<input type="text" name="AccountMail" style="padding: 5px;width: 98%;">
			</td>
		</tr>-->
		<tr>
			<td style="padding: 5px;">Invoice Cut Off Date:</td>
			<td style="padding: 5px;" colspan="2">If Other specify:</td>
		</tr>
		<tr>
			<td style="padding: 5px;"><?php echo form_dropdown('CutOff',$cutOff,'','style="padding: 5px;width: 100%;"')?></td>
			<td style="padding: 5px;" colspan="2"><input type="text" name="Others" style="padding: 5px;width: 98%;"></td>
		</tr>
		<tr>
			<td style="padding: 20px 5px;text-align: right;"colspan="3">
				<input type="submit" name="Submit" value="Submit" style="padding: 5px 15px;color: #ffffff;background: #259d25;cursor: pointer;border:none;">
			</td>
		</tr>
	</table>
</div>
<?php echo form_close();?>

<script>
    $(function(e){
       $('.number-input').numberOnly();
    });
</script>