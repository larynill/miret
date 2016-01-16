<script>
	$(function(e){
		var jobName = $('.job-name');
		var equipName = $('.equip-name-table');
		jobName.hover(
			function(e){
				equipName.each(function(e){
					$(this).css({
						'display':'none'
					});
				});
				$('#form_' + this.id).css({
					'display':'inline'
				});
			},
			function(e){
				equipName.each(function(e){
					$(this).css({
						'display':'none'
					});
				});
			}
		)
	});
</script>
<style>
	.job-done-table{
		width: 95%;
		border-collapse: collapse;
		ma
	}
	.job-done-table>tbody>tr>td{
		padding: 5px;
	}
	.job-data-table>thead>tr>th{
		background: #484b4a;
		font-weight: normal;
		padding: 5px;
		color: white;
		border: 1px solid #d2d2d2;
	}
	.job-data-table>tbody>tr>td{
		padding: 5px;
		border: 1px solid #d2d2d2;
		text-align: center;
	}
	.dropdown{
		padding: 5px;
	}
	.job-data-table{
		width: 80%;
	}
	.equip-name-table{
		white-space: nowrap;
		position: absolute;
		width: 20%;
		background: #b7b7b7;
		margin: -5px 0 0 20px;
		display: none;
	}
	.job-name{
		cursor: pointer;
	}
</style>
<?php
echo form_open('');
?>
<table class="job-done-table">
	<tr>
		<td>
			<?php
			echo '<span style="padding-right:5px">'.form_dropdown('year', $year, date('Y'),'style="width:10%" class="dropdown year"').'</span>';
			echo '<span style="padding-right:5px">'.form_dropdown('month', $months, date('m'),'style="width:10%" class="dropdown month"').'</span>';
			?>
			<input type="submit" name="search" value="Go" class="m-btn green submit" style="width: 3%;padding: 7px;margin: -1px 0;">
		</td>
	</tr>
	<tr>
		<td>
			<table class="job-data-table">
				<thead>
					<tr>
						<th style="width: 40%">Job Name</th>
						<th style="width: 15%">Job No.</th>
						<th style="width: 15%">Completed Date</th>
						<th style="width: 15%">Inspector</th>
					</tr>
				</thead>
				<tbody>
				<?php
				if(count($job_done)>0){
					foreach($job_done as $k=>$v){
						?>
						<tr>
							<td style="text-align: left!important;white-space: nowrap;" class="job-name" id="<?php echo $v->ID;?>">
								<?php echo $v->CompanyName?>
								<table class="equip-name-table" id="form_<?php echo $v->ID;?>">
									<tr>
										<td style="background: #000000;color: white;padding: 2px;">Equipment</td>
									</tr>
									<?php
									if(count($v->Equipment)>0){
										foreach($v->Equipment as $ek=>$ev){
											?>
											<tr>
												<td>
													<?php echo $ek+1 .'. '.$ev->PlantDescription;?>
												</td>
											</tr>
										<?php }
									}
									?>
								</table>
							</td>
							<td><?php echo $v->JobNumber?></td>
							<td><?php echo date('j F Y',strtotime($v->InspectionDate))?></td>
							<td><?php echo $v->Inspector?></td>
						</tr>
					<?php }
				}else{ ?>
					<tr>
						<td colspan="4">No Data</td>
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
		</td>
	</tr>
</table>
<?php
echo form_close();
?>