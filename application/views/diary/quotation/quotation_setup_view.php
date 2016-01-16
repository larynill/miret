<script language="JavaScript">
	$(function(e){
		var radio = $('.check-box');
		var textBox = $('.textbox-class');
		var disableTextInput = function(){
			textBox.attr('disabled','disabled');
		};
		radio.change(function(e){
			var uptextBox = $(this).parent().parent().find('.unit-price');
			var phtextBox = $(this).parent().parent().find('.per-hour');
			var travtextBox = $(this).parent().parent().find('.travel-time');
			var tdvtextBox = $(this).parent().parent().find('.travel-distance');
			var ftimetextBox = $(this).parent().parent().find('.flight-time');
			var ftextBox = $(this).parent().parent().find('.flight-textbox');
			var accommodation = $(this).parent().parent().find('.accommodation');
			var discount = $(this).parent().parent().find('.discount-banned');
			var thisTextBox = $(this).parent().find('.textbox-class');

			if ($('.unit').is(':checked') && $(this).val() == 1){
				uptextBox.removeAttr('disabled');

				phtextBox.attr('disabled','disabled');
			}else{
				phtextBox.removeAttr('disabled');

				uptextBox.attr('disabled','disabled');
			}

			if ($(this).is(':checked')){
				thisTextBox.removeAttr('disabled');
			}else{
				thisTextBox.attr('disabled','disabled');
			}
		});

		var travelTime = $('.travel-time');
		var travelDistance = $('.travel-distance');
		var km = $('.km-class');
		var time =$('.time-class');
		travelTime.keyup(function(e){
			var thisTotal = 0;
			if($(this).val() != 0){
				thisTotal = $(this).val() / 80;
			}
			time.html(thisTotal +' hr');

		});
		travelDistance.keyup(function(e){
			km.html($(this).val() +' km');
		});
		disableTextInput();
	});
</script>
<style>
	.span-data{
		text-decoration: underline;
	}
	.quatationTable{
		width: 100%;
	}
	.quatationTable tr td{
		padding: 5px;
		vertical-align: top;
	}
	.textbox-class{
		padding: 3px;
		width: 150px;
		float: right;
	}
	.check-box{
		width: 20px;
	}
</style>
<div class="quotationDiv" style="font-size: 12px;width: 800px">
	<?php
	echo form_open('');
	?>
	<table class="quatationTable">
		<tr style="border-bottom: 1px solid #d2d2d2;">
			<td>
				<strong>Date: </strong>
				<span class="span-data"><?php echo date('j F Y');?></span>
			</td>
			<td>
				<strong>Client: </strong>
				<span class="span-data"><?php echo $clientInfo;?></span>
			</td>
			<td>
				<strong>Equipment: </strong>
				<?php
				if(count($equipment)>0){
					foreach($equipment as $v){
						?>
						<span class="span-data"><?php echo $v;?></span><br/>
					<?php
					}
				}
				?>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<input type="hidden" name="trackerID" value="<?php echo $trackID;?>">
			</td>
		</tr>
		<tr style="white-space: nowrap;">
			<td style="text-align: left;">
				<input type="radio" name="price" class="check-box unit" value="1">
				<strong>Per Unit Price:</strong>
				<input type="text" name="pup" class="textbox-class unit-price">
				<!--<input type="hidden" name="pupHidden" class="hidden-class unit-price-class">-->
			</td>
			<td style="text-align: left;">
				<input type="radio" name="price" class="check-box unit" value="2">
				<strong>Per Hour:</strong>
				<input type="text" name="ph" class="textbox-class per-hour">
				<!--<input type="hidden" name="phHidden" class="hidden-class per-hour-class">-->
			</td>
		</tr>
		<tr style="white-space: nowrap;">
			<td>
				<input type="checkbox" name="travel" class="check-box travel" value="1">
				<strong>Travel Time:</strong>
				<input type="text" name="travelTime" class="textbox-class travel-time">
				<!--<input type="hidden" name="travelTimeHidden" class="hidden-class travel-time-class">-->
			</td>
			<td>
				<input type="checkbox" name="travel" class="check-box travel" value="2">
				<strong>Travel Distance:</strong>
				<input type="text" name="travelDistance" class="textbox-class travel-distance">
				<!--<input type="hidden" name="travelDistanceHidden" class="hidden-class travel-distance-class">-->
			</td>
			<td>
				<strong>Km:</strong>
				<span class="km-class">0 km</span>
				<strong>Time:</strong>
				<span class="time-class">0 hr</span>
			</td>
		</tr>
		<tr style="white-space: nowrap;">
			<td>
				<input type="checkbox" name="flight" class="check-box flight-radio" value="1">
				<strong>Flight Time:</strong>
				<input type="text" name="flightTime" class="textbox-class flight-time">
				<!--<input type="hidden" name="flightTimeHidden" class="hidden-class flight-time-class">-->
			</td>
			<td>
				<input type="checkbox" name="flight" class="check-box flight-radio" value="2">
				<strong>Flight $:</strong>
				<input type="text" name="flightCost" class="textbox-class flight-textbox">
				<!--<input type="hidden" name="flightCostHidden" class="hidden-class flight-cost-class">-->
			</td>
		</tr>
		<tr style="white-space: nowrap;">
			<td>
				<input type="checkbox" name="accommodation" class="check-box accommodation-radio" value="1">
				<strong>Accommodation Cost:</strong>
				<input type="text" name="accomCost" class="textbox-class accommodation">
				<!--<input type="hidden" name="accomCostHidden" class="hidden-class accom-class">-->
			</td>
			<td>
				<input type="checkbox" name="accommodation" class="check-box accommodation-radio" value="2">
				<strong>Discount Banned:</strong>
				<!--<input type="text" name="discount" class="textbox-class discount-banned">-->
				<?php echo form_dropdown('discount',$discount,'','class="textbox-class discount-banned"')?>
				<!--<input type="hidden" name="discountHidden" class="hidden-class discount-class">-->
			</td>
		</tr>
		<tr style="border-top: 1px solid #d2d2d2;">
			<td colspan="3" style="text-align: right;">
				<input type="submit" name="submit" class="m-btn green" style="width: 100px;padding: 5px 10px;">
			</td>
		</tr>
	</table>
	<?php
	echo form_close();
	?>
</div>