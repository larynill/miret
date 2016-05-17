<link type="text/css" href="<?php echo base_url(); ?>plugins/js/ui/ui-lightness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
<script src="<?php echo base_url() ?>plugins/js/ui/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>plugins/js/ui/jquery-ui-1.8.18.custom.min.js"></script>
<link href="<?php echo base_url();?>plugins/css/addForm.css" rel="stylesheet"/>
<script src="<?php echo base_url();?>plugins/js/addForm.js" language="JavaScript"></script>
<script src='<?php echo base_url(); ?>plugins/js/number.js' language="JavaScript"></script>
<script>
	$(function(e){        
        var miniCalendarArea = $('#miniCalendarArea');
        miniCalendarArea.datepicker({
        	dateFormat: 'yy-mm-dd',
        	minDate: 0,
        	onSelect: function() {
				var hasEmpty = false;
				var emptyTitle = '';
				var hour = $('.hour');
				var minute = $('.minute');
				var thistime = $('.time-stamp');
				var endHour = $('.end-hour');
				var endMinute = $('.end-minute');
				var endThistime = $('.end-time-stamp');

				$('.required').each(function(e){
					$(this).css({
						border: '1px solid #CCC'
					});

					if(!$(this).val()){
						$(this).css({
							border: '1px solid #FF624C'
						});

						hasEmpty = true;
						emptyTitle = 'Please input the required field!';
					}
				});

				var msg = $('.msg');
				msg.html(emptyTitle);

				if(hasEmpty){
					e.preventDefault();
				}else{
					$.post(
						'<?php echo base_url(); ?>inspector_set_date/<?php echo $assignId; ?>?date=' + $(this).val()
							+ '&start=' + hour.val() +':' + minute.val() +' ' + thistime.val() + '&end=' + endHour.val()
							+':' + endMinute.val() +' ' + endThistime.val()
						,
						function(e){
							location.reload();
						}

					)
				}

		  	}
        });
		var closeBtn = $('.closeBtn');
		var setInspectionArea = $('.setInspectionArea');
		var setInspection = $('.setInspection');
		//var setInspectionArea = $('.setInspectionArea');
		var companyName = $('.companyName');
		closeBtn.on('click',function(e){
			setInspection.removeClass('isactive');
			companyName.removeClass('isactive');
			setInspectionArea.html('');
		});

		var checkButton = $('.checkButton');
		var selectAll = $('input.checkPerEquip');
		var usedTheSame = $('.usedTheSame');
		var editBtn = $('.editBtn');
		var newBtn = $('.newBtn');
		var optionBtn = $('.optionBtn');

		var countChecked = function() {
			var n = $( ".checkPerEquip:checked" ).length;

			if(n == 0){
				optionBtn.addClass('disableBtn');
			}else{
				optionBtn.removeClass('disableBtn');
			}
		};

		checkButton.click(function(e){
			if($('input.checkButton').is(':checked')){
				selectAll.prop('checked', true);
			}else{
				selectAll.prop('checked', false);
			}
			countChecked();
		});

		countChecked();
		selectAll.on( "click", countChecked );


		newBtn.click(function(e){
			e.preventDefault();
			var allVal = [];
			var quote = $(this).data('val');
			var trackID = $(this).data('value');

			selectAll.each(function(e){
				if($(this).is(':checked')){
					allVal.push($(this).val());
				}
			});
			//window.location.href = "<?php echo base_url();?>request/send_quote/"+ quote + "/" + this.id;
			$(this).newForm.addNewForm({
				title: 'Quotation Setup Sheet',
				url: '<?php echo base_url();?>quotationSetUp/' + this.id + '/' + trackID  + '/' + quote,
				toFind:'.quotationDiv',
				data:{
					equipmentID: allVal,
					trackID: trackID
				}
			});
		});

		$('.time').numberOnly({
			"hasMaxChar": true,
			"maxCharLen": 2
		});
	});
</script>
<style>
	.hoverTable{
		border-collapse: collapse;
		width: 100%;
		font-size: 12px;
		background: #ffffff;
	}
	.hoverTable>tbody>tr>td{
		border: 1px solid #000000;
	}
	.tableInfo tr td, .clientEquipment tr td{
		padding: 3px 5px;
	}
	.hoverTable .headerTr td{
		background: #000000;
		color: #ffffff;
		text-align: center;
		padding: 5px 10px;
	}
	.tableInfo tr td:first-child{
		font-weight: bold;
	}
	.closeBtn{
		float: left;
	}
	.disableBtn{
		pointer-events: none;
	}
</style>

<table class="hoverTable">
	<tr class="headerTr">
		<td>
			<a href="#" class="closeBtn">close</a>
			Company Details
		</td>
		<td style="white-space: nowrap;">Lists of Equipment</td>
		<?php
		echo $isInspector ? "<td>Mini Calendar</td>" : "";
		?>
	</tr>
	<tr style="vertical-align: top;">
		<td>
			<table class="tableInfo">
				<?php
				if(count($clientInfo)>0){
					foreach($clientInfo as $key => $val){
						?>
						<tr>
							<td style="white-space: nowrap;">Postal Address:</td>
							<td style="white-space: nowrap;">
								<?php 
								echo $val->postalAddress; 
								?>
							</td>
						</tr>
						<tr>
							<td style="white-space: nowrap;">Person In Charge:</td>
							<td>
								<?php 
								echo $val->PersonInCharge; 
								?>
							</td>
						</tr>
						<tr>
							<td style="white-space: nowrap;">Mobile Phone:</td>
							<td>
								<?php 
								echo $val->MobilePhone; 
								?>
							</td>
						</tr>
						<tr>
							<td style="white-space: nowrap;">Fax Number:</td>
							<td>
								<?php 
								echo $val->FaxNumber; 
								?>
							</td>
						</tr>
						<tr>
							<td>Email:</td>
							<td>
								<?php 
								echo $val->Email; 
								?>
							</td>
						</tr>
						<tr>
							<td style="white-space: nowrap;">Area Designation:</td>
							<td>
								<?php 
								echo $val->AreaDesignation; 
								?>
							</td>
						</tr>
						<tr>
							<td style="white-space: nowrap;">Km Reading:</td>
							<td>
								<?php
								echo 'From <span style="text-decoration: underline;"> '.$val->Distance.'</span> to';
								echo ' <span style="text-decoration: underline;">'.$val->DistanceFrom.'</span> ';
								echo ' ('.$val->KmDistance.' Km)';
								?>
							</td>
						</tr>
					<?php }
				}
				?>
			</table>
		</td>
		
			<td>
			<table class="clientEquipment" style="width: 100%;">
				<?php
				if($isForQuote == true){?>
					<tr style="border-bottom: 1px solid #808080">
						<td>
							<input type="checkbox" name="useSame" style="width: 50px;" class="checkButton selectAll">
						</td>
						<td colspan="2" style="font-weight: bold;white-space:nowrap;border-bottom: 1px solid #808080" class="selectAll">Select All</td>
						<td colspan="3" style="white-space: nowrap;text-align: right;">
							<a href="#" class="usedTheSame optionBtn" id="<?php echo $clientId;?>" data-val="<?php echo $quote;?>">Used the same</a> |
							<a href="#" class="editBtn optionBtn">Edit</a> |
							<a href="#" class="newBtn optionBtn" id="<?php echo $clientId;?>" data-val="<?php echo $quote;?>" data-value="<?php echo $thisTrackID;?>">New</a>
						</td>
					</tr>
				<?php
				}
				?>
				<?php
				if(count($clientEquipment) > 0){
					$ref = 1;
					foreach ($clientEquipment as $v) {

						?>
						<tr>
							<?php
							if($isForQuote == true){
							?>
								<td>
									<input type="checkbox" name="selectEquip[]" class="checkPerEquip" style="width: 50px;" value="<?php echo $v->ID?>">
								</td>
							<?php
							}
							?>
							<td style="width: 20px;text-align: center;">
								<?php
								echo $ref;
								?>
							</td>
							<td style="white-space: nowrap;">
								<?php
								echo $v->PlantDescription;
								?>
							</td>
							<?php
							if($this->session->userdata('userAccountType') == 3){
							?>
								<td style="width: 20px;text-align: center;white-space: nowrap;">
									<a href="<?php echo base_url() . "equipmentHistory/" . $clientId; ?>" target="_blank" >Quote History</a>
								</td>
								<td style="width: 20px;text-align: center;white-space: nowrap;">
									<a href="<?php echo base_url() . "equipmentReport/" . $v->ID; ?>" target="_blank" >Previous Report</a>
								</td>
								<td style="width: 20px;text-align: center;white-space: nowrap;">
									<a href="<?php echo base_url() . "machineDetails/" . $v->ID; ?>" target="_blank" >Machine Detail</a>
								</td>
							<?php }?>
						</tr>
						<?php
						$ref ++;
					}
				}else{
					?>
					<tr>
						<td style="text-align: center;">No Equipment Available</td>
					</tr>
					<?php
				}
				
				//echo $isInspector ? ' &nbsp; ' : '';
				?>
			</table>
		</td>
		<?php
		if($isInspector){
			?>
			<td style="width: 230px;">
				<div style="white-space: nowrap;padding: 5px 10px;">
					Time Start: <input type="text" name="Hour" style="width: 20%;" placeholder="00" class="time hour required">
					<input type="text" name="Minutes" style="width: 20%;" placeholder="00" class="time minute required">
					<?php echo form_dropdown('timeStamp',array('am'=>'am','pm'=>'pm'),'','style="width:25%;" class="time-stamp"')?>
				</div>
				<div style="white-space: nowrap;padding: 5px 12px">
					Time End:<input type="text" name="EndHour" style="width: 20%;" placeholder="00" class="time end-hour required">
					<input type="text" name="EndMinutes" style="width: 20%;" placeholder="00" class="time end-minute required">
					<?php echo form_dropdown('EndTimeStamp',array('am'=>'am','pm'=>'pm'),'','style="width:25%;" class="end-time-stamp"')?>
				</div>
				<div id="miniCalendarArea"></div>
			</td>
			<?php
		}
		?>
	</tr>
</table>