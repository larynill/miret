<script language="JavaScript">
	$(function(e){
		var distance = [];
		<?php
		if(count($distanceName)>0){
			$ref = 1;
			foreach($distanceName as $distID=>$distVal){
				echo 'distance[' . $distID . '] = [];' . "\r\n";
				if(count($distVal)>0){
					foreach($distVal as $distVal_id=>$name){
						echo 'distance[' . $distID . '][' . $ref . '] = [];' . "\r\n";
						echo 'distance[' . $distID . '][' . $ref . '][' . $distVal_id . '] = "' . $name . '";' . "\r\n";
						$ref++;
					}
				}
			}
		}
		?>

		$('.distanceFrom').selectCountry({
			cityName: 'Distance',
			city: distance,
			style: 'width: 150px;',
			appendWhere: $('.distanceVal')
		});
	});
</script>
<div class="clear"></div>
    <fieldset>
        <legend>Client Information</legend>
        <div class="sixteen_column section">
            <div class="four column">
                <div class="column_content">
                    <label>Contact Person: </label>
                    <input type="text" id="firstName" name="FirstName" class="required" title="FirstName" />
                </div>
            </div>
            <div class="eight column">
                <div class="column_content">
                    <label>Company Name: </label>
                    <input type="text" class="required" name="CompanyName" class="required" title="CompanyName"/>
                </div>
            </div>
        </div>

        <div class="sixteen_column section">
            <div class="six column">
                <div class="column_content">
                    <label>Physical Address: </label>
                    <input type="text" name="PhysicalAddress[]" placeholder="Street Number, Suburban" class=""/>
                </div>
            </div>
            <div class="four column">
                <div class="column_content">
                    <label>City/Town: </label>
                    <?php
                    echo form_dropdown('PhysicalAddress[]', $_city, '', "class=''");
                    ?>
                </div>
            </div>
            <div class="four column">
                <div class="column_content">
                    <label>Country: </label>
                    <?php
                    echo form_dropdown('PhysicalAddress[]', $_country, '', "class=''");
                    ?>
                </div>
            </div>
            <div class="two column">
                <div class="column_content">
                    <label>Postal Code: </label>
                    <input type="text" name="PhysicalAddress[]" value="" class="numberOnly" />
                </div>
            </div>
        </div>
        <div class="sixteen_column section">
            <div class="eight column">
                <div class="column_content">
                    <label>Postal Address </label>
                    <input type="text" name="PostalAdress" class=""/>
                </div>
            </div>
            <div class="two column">
                <div class="column_content">
                    <label>Work Phone: </label>
                    <input type="text" name="WorkPhone[]" placeholder="area code" class="required numberOnly" title="Work Phone"/>
                </div>
            </div>
            <div class="two column">
                <div class="column_content">
                    <label>&nbsp </label>
                    <input type="text" name="WorkPhone[]" placeholder="number" class="required numberOnly" title="Work Phone"/>
                </div>
            </div>
            <div class="two column">
                <div class="column_content">
                    <label>&nbsp </label>
                    <input type="text" name="WorkPhone[]" placeholder="extension " class="required numberOnly" title="Work Phone"/>
                </div>
            </div>
        </div>
        <div class="sixteen_column section">
            <div class="eight column">
                <div class="column_content">
                    <label>Email: </label>
                    <input type="text" name="Email" class=""/>
                </div>
            </div>
            <div class="eight column">
                <div class="column_content">
                    <label>Mobile Phone: </label>
                    <input type="text" name="MobilePhone" class="required numberOnly" title="Mobile Phone"/>
                </div>
            </div>
        </div>
        <div class="sixteen_column section">
            <div class="eight column">
                <div class="column_content">
                    <label>Person In Charge: </label>
                    <input type="text" name="PersonInCharge" class=""/>
                </div>
            </div>
            <div class="eight column">
                <div class="column_content">
                    <label>Fax Number: </label>
                    <input type="text" name="FaxNumber" class="numberOnly "/>
                </div>
            </div>
        </div>
		<?php
		if($this->session->userdata('userAccountType') == 1){
		?>
			<div class="sixteen_column section">
				<div class="eight column">
					<div class="column_content">
						<label>Last Update: </label>
						<input type="text" class="datepicker" name="LastUpdate" class=""/>
					</div>
				</div>
				<div class="eight column">
					<div class="column_content">
						<label>Our Area Designation: </label>
						<?php echo form_dropdown('AreaDesignationID', $_designation_area, '', 'class="required"'); ?>
					</div>
				</div>
			</div>
			<div class="sixteen_column section">
				<div  class="four column">
					<div class="column_content">
						<label>Distance from:</label>
						<table>
							<tr>
								<td style="padding: 0 5px;">
									<?php echo form_dropdown('Distance', $distanceFrom, '', 'class="required distanceFrom"'); ?>
								</td>
								<td style="padding: 0 5px;">
									To
								</td>
								<td style="padding: 0 5px;">
									<?php echo form_dropdown('DistanceFrom', $distanceName, '', 'class="required distanceVal" style="width:300px;"'); ?> (One Way)
								</td>
								<td style="padding: 0 5px;">
									<input type="text" name="KmDistance" style="width: 100;" class="required"> (Km)
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		<?php
		}
		?>
        <div class="sixteen_column section">
            <div class="sixteen column ">
                <div class="column_content">
                    <lable>Notes: </lable>
                    <textarea rows="8" name="Notes" class=""></textarea>
                </div>
            </div>
        </div>
    </fieldset>