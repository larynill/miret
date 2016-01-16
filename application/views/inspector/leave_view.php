<script>
	$(function(e){
		$('.datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:'d MM yy',
			showOn: 'button',
			minDate: new Date(),
			buttonImage: bu + 'plugins/img/calendar-add.png',
			buttonImageOnly: true,
			onSelect: function(){
				var msg = $(this).parent().find('.msg-content');
				msg.html($(this).val());
			}
		});

		var submit = $(".submit");
		submit.click(function(e){
			var hasEmpty = false;
			var emptyTitle = '';
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
			}
		});

	});
</script>
<style>
	.ui-datepicker-trigger{
		width: 20px;
		margin: -5px 0;
	}
	.msg-content{
		margin: -17px 0;
		padding: 0 5px;
	}
	.leave-table{
		width: 98%;
		margin: 20px 0;
		font-size: 14px;
	}
	.leave-table>tbody>tr>td{
		padding: 5px;
		vertical-align: top;
	}
	.leave-form-table>tbody>tr>td{
		padding: 5px;
	}
	.leave-form-table{
		width: 98%;
	}
	.leave-history>tbody>tr>td{
		padding: 5px;
		border: 1px solid #d2d2d2;
	}
	.leave-history>tbody>tr:nth-child(4)>td{
		white-space: nowrap;
		background: #484b4a;
		color: #ffffff;
		text-align: center;
	}
	.dropdown{
		width: 20%;
	}
</style>
<table class="leave-table">
	<tr>
		<td>
			<?php
			echo form_open('');
			?>
			<table class="leave-form-table">
				<tr>
					<th style="border-bottom: 1px solid #000000;text-transform: uppercase;" colspan="5">Leave Form Request</th>
				</tr>
				<tr>
					<td colspan="5">
						Leave Type: <?php echo form_dropdown('leaveType',$leave_type,'','class="dropdown"')?>
					</td>
				</tr>
				<tr>
					<td style="width: 5%;white-space: nowrap">Leave required</td>
					<td style="width: 5%;font-weight: bold">from</td>
					<td style="white-space: nowrap!important;width: 20%">
						<span class="msg-content" style="font-weight: bold;" class="required">____________________</span>
						<input type="hidden" name="startDate" class="datepicker required">
					</td>
					<td style="width: 5%;font-weight: bold;text-align: right;">to</td>
					<td style="white-space: nowrap!important;">
						<span class="msg-content" style="font-weight: bold;" class="required">____________________</span>
						<input type="hidden" name="endDate" class="datepicker required">
					</td>
				</tr>
				<tr>
					<td>your <strong>reason</strong></td>
					<td colspan="5">
						<input type="text" name="reason" class="text-input-class required">
					</td>
				</tr>
				<tr>
					<td colspan="5" style="text-align: right;"><br/>
						<input type="submit" name="submit" value="Request" class="m-btn green submit" style="width: 15%">
					</td>
				</tr>
			</table>
			<?php
			echo form_close();
			?>
		</td>
		<td>
			<table class="leave-history"
				<?php echo count($staff_leave) == 0 ? 'style="min-width: 400px!important;"':'style="width: 100%!important;"'?>
				>
				<tr>
					<th style="border-bottom: 1px solid #000000;text-transform: uppercase;white-space: nowrap" colspan="4">
						Leave Details
					</th>
				</tr>
				<tr>
					<th colspan="3" style="padding: 5px 0;white-space: nowrap;text-align: left;">
						Type of Leave: <?php echo form_dropdown('leaveType',$leave_type,'','class="dropdown" style="width:50%;"');?>
						<input type="submit" name="search" value="Go" class="m-btn green search" style="width: 5%;padding: 5px 0;">
					</th>
				</tr>
				<tr>
					<th colspan="4">
						<span style="text-transform: none;float: right;">Leave Left <strong>(<?php echo $totalConsume;?>)</strong></span>
					</th>
				</tr>
				<tr>
					<td>Type</td>
					<td>Start Date</td>
					<td>End Date</td>
					<td>Reason</td>
				</tr>
				<?php
				if(count($staff_leave)>0){
					foreach($staff_leave as $sk=>$sv){
						?>
						<tr>
							<td style="white-space: nowrap;"><?php echo $sv->LeaveType?></td>
							<td style="white-space: nowrap;"><?php echo date('j F Y',strtotime($sv->StartDate))?></td>
							<td style="white-space: nowrap;"><?php echo date('j F Y',strtotime($sv->EndDate))?></td>
							<td style="width: 80%!important;"><?php echo $sv->Reason?></td>
						</tr>
					<?php
					}
				}else{?>
					<tr>
						<td colspan="4" style="text-align: center;">No Data</td>
					</tr>
				<?php
				}
				?>
			</table>
		</td>
	</tr>
</table>