<script>
	$(function(e){

	});
</script>
<style>
	#inspectionContent{
		border: 1px solid #d2d2d2;
		width: 96%;
		padding: 10px;
		margin: 10px 0;
	}
	.inspectionTable,.inspection-certificate-table{
		width: 100%;
	}
	.inspectionTable tr .inspectionHeader{
		text-transform: uppercase;
		text-align: right;
	}
	.inspectionTable tr .inspectionBorder,
	.inspection-certificate-table tr .inspectionBorder{
		border: 1px solid #d2d2d2;
	}
	.inspection-certificate-table>tbody>tr>td{
		padding: 5px;
	}
	.inspectionTable>tbody>tr>td:nth-child(2){
		width: 30%;
	}
	.inspectionTable>tbody>tr>td:nth-child(1){
		width: 10%;
	}
	.inspectionTable>tbody>tr>td:nth-child(3){
		width: 7%;
	}
	.static-name{
		text-transform: uppercase;
		width: 20%;
	}
	.inspectionHeader ul{
		margin: 5px -10px;
	}
	.inspectionHeader ul li{
		list-style: none;
		display: inline;
		margin: 5px;
		vertical-align: top;
	}
	.inspectionHeader ul li a{
		background: #4b8df8;
		padding: 5px 10px;
		color: #ffffff;
	}
	.archive-btn{
		background: #4b8df8;
		padding: 7px 10px;
		color: #ffffff;
		width: 135px;
		border: none;
		margin: -5px 0;
		text-transform: uppercase;
	}
	.inspectionHeader ul li .is-active{
		background: #2da5db;
	}
	td .data-table tr td:nth-child(4){
		width: 65%!important;
	}
	td .data-table tr td:nth-child(3){
		width: 4%;
	}
	input[type=text]{
		border: none;
	}
	.inspectionHeader ul li a:hover,.archive-btn:hover{
		background: #2f8bb6;
	}
	.dropdown{
		width: 20%;
	}
	.inspection-footer{
		width: 100%;
	}
	.inspection-footer>tbody>tr>td{
		padding: 0;
	}
	.inspection-footer tr td:nth-child(even){
		border-bottom: 1px solid #000000;
		padding-left: 10px;
		font-weight: bold;
		width: 20%;
	}
	.inspection-footer tr td:nth-child(3){
		padding: 0 30px;
	}
	.disableButton{
		pointer-events: none;
		background: #a7a7a7!important;
	}
</style>
<?php
$page = $this->uri->segment(2);
echo form_open('');
?>
<div style="padding: 10px 0;">
	Equipment for Inspection:
	<?php
	echo $page == 'report' ? form_dropdown('equipment',$equip,'','class="dropdown"') :
		 form_dropdown('equipment',$issueEquip,'','class="dropdown"');
	?>
	<input type="hidden" name="EquipID" value="<?php echo $EquipID;?>">
	<input type="submit" name="search" value="Go" class="m-btn green" style="width: 30px;padding: 5px 10px;">
</div>

<div id="inspectionContent">
	<table class="inspectionTable">
		<tr>
			<td class="inspectionHeader" colspan="4">
				<?php
				$links = array(
					'inspection_report/issue/'.$this->uri->segment(3) => 'Issue Certificate',
					'invoice' => 'Invoice'
				);
				$archiveBtn = '<input type="submit" name="Archive" class="archive-btn" value="Archive Report">';
				$editBtn = '<a href="'.base_url().'inspection_report/editreport/'.$this->uri->segment(3).'">Edit Report</a>';
				$submitBtn = $disableArchive ? $editBtn : $archiveBtn;
				$linkBtn = $page != 'editreport' ? '<a href="'.base_url().'inspection_report/report/'.$this->uri->segment(3).'">Report</a>'
							:'<input type="submit" name="Archive" value="Update" class="archive-btn" style="width: 7%;">';
				$issue = '<a href="'.base_url().'inspection_report/issue/'.$this->uri->segment(3).'" class="linkClass '.$disableIssue.'">
							Issue Certificate</a>';
				$print = '<a href="'.base_url().'inspection_report/print/'.$this->uri->segment(3).'" target="_blank">Print</a>';
				?>
				<ul>
					<li>
						<?php echo $page == 'report' ? $submitBtn : $linkBtn;?>
					</li>
					<li>
						<?php echo $page == 'report' ? $issue : $print;?>
					</li>
					<li>
						<a href="<?php echo base_url().'invoice'?>" class="linkClass <?php echo $disableIssue;?>">Invoice</a>
					</li>
				</ul>
			</td>
		</tr>
		<?php
		if(count($equipment)>0){
			foreach($equipment as $k=>$v){
			?>
			<tr>
				<td class="static-name" style="text-align: right;padding-right: 5px;">Expiry Date: </td>
				<td><strong><?php echo date('m/d/Y',strtotime($v->ExpectationDate))?></strong></td>
			</tr>
			<tr>
				<td class="inspectionBorder static-name">Job No:</td>
				<td class="inspectionBorder">
					<input type="hidden" name="JobNumber" value="<?php echo $v->JobNumber?>">
					<strong><?php echo $v->JobNumber?></strong>
				</td>
				<td class="inspectionBorder static-name">Inspection Date:</td>
				<td class="inspectionBorder"><strong><?php echo date('m/d/Y',strtotime($inspectionDate))?></strong></td>
			</tr>
			<tr>
				<td class="inspectionBorder static-name">Client Controller:</td>
				<td class="inspectionBorder"><strong><?php echo $v->CompanyName?></strong></td>
				<td class="inspectionBorder static-name">Contact Person:</td>
				<td class="inspectionBorder"><strong><?php echo $v->ContactPerson?></strong></td>
			</tr>
			<tr>
				<td class="inspectionBorder static-name">Address:</td>
				<td class="inspectionBorder"><strong><?php echo $v->PostalAdress?></strong></td>
				<td class="inspectionBorder static-name">Details:</td>
				<td class="inspectionBorder"><strong><?php echo $v->MobilePhone?></strong></td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td class="inspectionBorder static-name">Official No:</td>
				<td class="inspectionBorder">
					<strong>
						<?php
						$official = $v->OfficialNo ? $v->OfficialNo : '<input type="text" name="OfficialNo">';
						echo $page == 'report' ? $official : '<input type="text" name="OfficialNo" value="'.$v->OfficialNo.'">';
						?>
					</strong>
				</td>
				<td class="inspectionBorder static-name">Capacity:</td>
				<td class="inspectionBorder">
					<strong>
						<?php
						$capacity = $v->Capacity ? $v->Capacity : '<input type="text" name="Capacity">';
						echo $page == 'report' ? $capacity : '<input type="text" name="Capacity" value="'.$v->Capacity.'">';
						?>
					</strong>
				</td>
			</tr>
			<tr>
				<td class="inspectionBorder static-name">Client Id:</td>
				<td class="inspectionBorder"><strong><?php echo $v->PlantDescription?></strong></td>
				<td class="inspectionBorder static-name">Manufacturer:</td>
				<td class="inspectionBorder"><strong><?php echo $v->Manufacturer?></strong></td>
			</tr>
			<tr>
				<td class="inspectionBorder" colspan="2"><span style="text-transform: uppercase;">Pressure:</span>
					<?php
					$pressure = $v->Pressure ? '<strong> '.$v->Pressure.' </strong>' : '<input type="text" name="Pressure" style="width: 80%;">';
					$editPressure = '<input type="text" name="Pressure" value="'.$v->Pressure.'" style="width: 80%;float:right;">';
					echo $page == 'report' ? $pressure : $editPressure;
					?>
				</td>
				<td class="inspectionBorder" colspan="2"><span style="text-transform: uppercase;">Temperature:</span>
					<?php
					$temperature = $v->Temperature ? '<strong> '.$v->Temperature.' </strong>' : '<input type="text" name="Temperature" style="width: 70%;">';
					$editTemp = '<input type="text" name="Temperature" value="'.$v->Temperature.'" style="width: 70%;float:right;">';
					echo $page == 'report' ? $temperature : $editTemp;
					?>
				</td>
			</tr>
			<tr>
				<td class="inspectionBorder static-name">Contents:</td>
				<td class="inspectionBorder">
					<?php
					$contents = $v->Contents ? '<strong> '.$v->Contents.' </strong>' : '<input type="text" name="Contents">';
					$editContent = '<input type="text" name="Contents" value="'.$v->Contents.'">';
					echo $page == 'report' ? $contents : $editContent;
					?>
				</td>
				<td class="inspectionBorder static-name">Safety Valve Due:</td>
				<td class="inspectionBorder">
					<strong>
						<input type="hidden" name="SafetyValve" value="<?php echo date('Y-m-d')?>">
						<?php echo date('m/d/Y')?>
					</strong>
				</td>
			</tr>
			<tr>
				<td class="inspectionBorder static-name">Purpose & Location:</td>
				<td class="inspectionBorder" colspan="3">
					<?php
					$purpose = $v->Purpose ? '<strong> '.$v->Purpose.' </strong>' : '<input type="text" name="Purpose">';
					$editPurpose = '<input type="text" name="Purpose" value="'.$v->Purpose.'">';
					echo $page == 'report' ? $purpose : $editPurpose;
					?>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr >
				<td class="static-name" style="white-space: nowrap;">Hazard Assessment Completed:</td>
				<td><input type="checkbox" name="complete" style="width: 10%;margin: 3px 0;"></td>
				<td class="static-name">Comments:</td>
				<td><strong></strong></td>
			</tr>
			<tr>
				<td class="static-name">External:</td>
				<td colspan="3">
					<span class="static-name" style="padding-left: 10px;"><strong>&#x2713;</strong> Acceptable</span>
					<span class="static-name" style="padding-left: 10px;"><strong>&#x2717;</strong> Not Acceptable</span>
					<span class="static-name" style="padding-left: 10px;"><strong>C</strong> Comment Not Applicable</span>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table style="width: 100%;" class="data-table">
						<?php
						$arr = array(
							'Lagging' => 'Lagging',
							'Coating' => 'Coating',
							'Shell' => 'Shell',
							'Heads' => 'Heads',
							'Compensating Pads' => 'Pads',
							'Nozzles' => 'Nozzles',
							'ManWay/Hand Holes' => 'Manway',
							'Flanges' => 'Flanges',
							'Piping & Supports' => 'Piping',
							'Bolting' => 'Bolting',
							'Welds/Rivets' => 'Welds',
							'Valves' => 'Valves',
							'Supports (Fixed, Sliding)' => 'Support',
							'Safety Valve' => 'Safety',
							'Pressure Gauge' => 'Gauge',
							'Earthing' => 'Earthing',
							'Other (Auto Drain Etc)' => 'OtherAutoDrain',
							'Access' => 'Access',
							'Shell (Contents Interface)' => 'ContentInterface',
							'Heads ' => 'HeadsOther',
							'Welds' => 'WeldsOther',
							'Noozles' => 'NoozlesOther',
							'ManWay/Hand Holes ' => 'HandHoles',
							'Fittings' => 'Fittings',
							'Coating ' => 'OtherCoating',
							'Other' => 'Other'
						);
						$ref = 0;
						foreach($arr as $ak=>$av){
							?>
							<tr>
								<td class="inspectionBorder static-name" style="width: 2%;text-align: center;">
									<?php echo $ref+1;?>
								</td>
								<td class="inspectionBorder static-name">
									<?php echo $av;?>
								</td>

								<td class="inspectionBorder" style="text-align: center;">
									<?php
									$editThis = $v->$av->acceptable == '&#x2713;' ? '<input type="checkbox" name="'.$av.'_ACCEPT" value="1" checked style="width: 20px;margin: 3px 0;">' :
												'<input type="checkbox" name="'.$av.'_ACCEPT" value="1" style="width: 20px;margin: 3px 0;">';
									$displayThis = $v->$av->acceptable ? '<strong>'.$v->$av->acceptable.'</strong>' : '<input type="checkbox" name="'.$av.'_ACCEPT" value="1" style="width: 20px;margin: 3px 0;">';
									echo $page == 'report' ? $displayThis : $editThis;
									?>
								</td>
								<td class="inspectionBorder">
									<?php
									$commentVal = '<input type="text" name="'.$av.'" value="'.$v->$av->comment.'">';
									$reportVal = $v->$av->comment ? $v->$av->comment : '<input type="text" name="'.$av.'">';
									echo $page == 'report' ? $reportVal : $commentVal;
									?>
								</td>
							</tr>
							<?php
							if($ref == 16){
							?>
								<tr>
									<td class="inspectionBorder"></td>
									<td class="inspectionBorder static-name">Internal</td>
									<td class="inspectionBorder"></td>
									<td class="inspectionBorder static-name" style="font-weight: bold;">Due Date: No Internal Piping</td>
								</tr>
							<?php
							}
							$ref++;
						}
						?>
					</table>
				</td>
			</tr>
			<tr>
				<td class="static-name" colspan="4">
					Extra Comments/Report (Use Back Of This Report Or "Comments Extra Sheet" for Additional Comments)
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<table style="width: 100%;">
						<tr>
							<td class="inspectionBorder" style="width: 10%;">
								<?php
								echo $v->FirstComment->acceptable ? $v->FirstComment->acceptable : '<input type="text" name="FirstComment[]">';
								?>
							</td>
							<td class="inspectionBorder">
								<?php
								echo $v->FirstComment->comment ? $v->FirstComment->comment : '<input type="text" name="FirstComment[]">';
								?>
							</td>
						</tr>
						<tr>
							<td class="inspectionBorder" style="width: 10%;">
								<?php
								echo $v->SecondComment->acceptable ? $v->SecondComment->acceptable : '<input type="text" name="SecondComment[]">';
								?>
							</td>
							<td class="inspectionBorder">
								<?php
								echo $v->SecondComment->comment ? $v->SecondComment->comment : '<input type="text" name="SecondComment[]">';
								?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					This item has been inspected in accordance with the relevance codes and standards and is being recommended for certification.
				</td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="4">
					<table class="inspection-footer">
						<tr>
							<td style="width: 5%;white-space: nowrap;">
								Equipment Inspector:
							</td>
							<td>
								<?php echo $accountName;?>
							</td>
							<td style="width: 20%;white-space: nowrap;text-align: right">
								Reviewed By:
							</td>
							<td>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<?php }
		}
		?>
	</table>
	<?php
	if(count($certificate)>0){
		foreach($certificate as $ck=>$cv){
			?>
			<table class="inspection-certificate-table">
				<tr>
					<td style="text-align: right;font-style: italic;padding: 10px 0;border-top:1px solid #d2d2d2;" colspan="4">
						Accredited by International Accreditation New Zealand
					</td>
				</tr>
				<tr>
					<th style="text-transform: uppercase;font-size: 24px;padding: 10px;" colspan="4">
						Pressure Vessel<br/>
						<span style="font-size: 20px;">Certification</span>
					</th>
				</tr>
				<tr>
					<td class="inspectionBorder static-name">Job No:</td>
					<td class="inspectionBorder"><strong><?php echo $cv->JobNumber?></strong></td>
					<td class="inspectionBorder static-name">Expiry Date:</td>
					<td class="inspectionBorder">
						<strong><?php echo date('m/d/Y',strtotime($cv->ExpectationDate))?></strong>
					</td>
				</tr>
				<tr>
					<td class="inspectionBorder static-name">Client/Controller:</td>
					<td class="inspectionBorder">
						<strong><?php echo $cv->CompanyName?></strong>
					</td>
					<td class="inspectionBorder static-name">Contact Person:</td>
					<td class="inspectionBorder">
						<strong><?php echo $cv->ContactPerson?></strong>
					</td>
				</tr>
				<tr>
					<td class="inspectionBorder static-name">Address:</td>
					<td class="inspectionBorder" colspan="3">
						<strong><?php echo $cv->PostalAdress?></strong>
					</td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td class="inspectionBorder static-name">Official No:</td>
					<td class="inspectionBorder"><strong><?php echo $cv->OfficialNo?></strong></td>
					<td class="inspectionBorder static-name">Capacity:</td>
					<td class="inspectionBorder"><strong><?php echo $cv->Capacity?></strong></td>
				</tr>
				<tr>
					<td class="inspectionBorder static-name">Client Id:</td>
					<td class="inspectionBorder">
						<strong><?php echo $cv->PlantDescription?></strong>
					</td>
					<td class="inspectionBorder static-name">Manufacturer:</td>
					<td class="inspectionBorder">
						<strong><?php echo $cv->Manufacturer?></strong>
					</td>
				</tr>
				<tr>
					<td class="inspectionBorder">
						<span style="text-transform: uppercase;">Pressure:</span>
					</td>
					<td class="inspectionBorder">
						<?php
						echo $cv->Pressure;
						?>
					</td>
					<td class="inspectionBorder">
						<span style="text-transform: uppercase;">Temperature:</span>
					</td>
					<td class="inspectionBorder">
						<?php
						echo $cv->Temperature;
						?>
					</td>
				</tr>
				<tr>
					<td class="inspectionBorder static-name">Contents:</td>
					<td class="inspectionBorder">
						<?php
						echo $cv->Contents;
						?>
					</td>
					<td class="inspectionBorder static-name">Inspection Date:</td>
					<td class="inspectionBorder">
						<strong>
							<?php echo date('m/d/Y',strtotime($inspectionDate))?>
						</strong>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td class="inspectionBorder static-name">Purpose and Location:</td>
					<td class="inspectionBorder" colspan="3">
						<?php
						echo $cv->Purpose;
						?>
					</td>
				</tr>
				<tr>
					<td colspan="4" style="font-style: italic;">
						On Inspection, the equipment was found in safe condition, and subject to normal operation and ongoing
						maintenance by the controller, may remain in use, for the period specified in this certificate.
					</td>
				</tr>
				<tr>
					<td style="font-size: 18px;">Equipment Inspector:</td>
					<td colspan="3" style="font-size: 18px;font-weight: bold;font-style: italic;"><?php echo $accountName;?></td>
				</tr>
				<tr>
					<td colspan="2" style="font-size: 10px;">Copyright - All Rights Reserved</td>
					<td colspan="2" style="font-size: 10px;">STAT Pressure Vessel Cert - Rev 3</td>
				</tr>
			</table>
		<?php }
	}
	?>
</div>
<?php
echo form_close();
?>