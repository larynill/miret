<style>
	.payment-table{
		margin: 10px 0;
		border-collapse: collapse;
		width: 60%;
		font-size: 13px;
	}
	/*.slick-header-column{
		background: #484b4a;
		white-space: nowrap;
		color: #ffffff;
		text-align: center;
	}*/
	.payment-table>tbody>tr>th{
		padding: 5px;
		background: #484b4a;
		color: white;
		font-weight: normal;
	}
	.drop-down{
		width: 10%;
		padding: 5px;
	}
	.submit-btn{
		width: 5%;
		padding: 5px 0;
		margin-top: 2px;
	}
	.payment-table>tbody>tr>td{
		border: 1px solid #d2d2d2;
		text-align: center;
		padding: 4px;
	}
	.payment-table>tbody>tr:last-child>td{
		color: #ff0000;
	}
</style>
<?php
echo form_open('');

if(count($empArr)>0){
	foreach($empArr as $k=>$v){

?>
<table class="payment-table">
	<tr>
		<td colspan="7" style="padding: 5px 0;white-space: nowrap;border: none;text-align: left">
			<?php
				echo form_dropdown('month',$month,'','class="drop-down" style="width:16%;"').'&nbsp;';
				echo form_dropdown('year',$year,'','class="drop-down"');
			?>
			<input type="submit" name="submit" class="m-btn green submit-btn" value="Go">
		</td>
	</tr>
	<tr>
		<th>Month</th>
		<th style="width: 15%;">Gross</th>
		<th style="width: 15%;">PAYE</th>
		<th style="width: 10%;">KS</th>
		<th style="width: 13%;">KS Emp.</th>
		<th style="width: 10%;">ST Loan</th>
		<th style="width: 15%;">NETT</th>
	</tr>
	<?php
	$gross = 0;
	$paye = 0;
	$ks = 0;
	$nett = 0;
	if(count($dateArr)>0){
		foreach($dateArr as $sunday){
			$gross += $v->Gross;
			$paye += $v->Paye;
			$ks += $v->KS;
			$nett += ($v->Gross - ($v->Paye + $v->KS));
			?>
			<tr>
				<td><?php echo $sunday->format("M - d");?></td>
				<td><?php echo '$ ' . number_format($v->Gross,2,'.',' ');?></td>
				<td><?php echo '$ ' . number_format($v->Paye,2,'.',' ');?></td>
				<td><?php echo '$ ' . number_format($v->KS,2,'.',' ');?></td>
				<td>$ 0.00</td>
				<td>$ 0.00</td>
				<td><?php echo '$ ' . number_format(($v->Gross - ($v->Paye + $v->KS)),2,'.',' ');?></td>
			</tr>
		<?php
		}
	}
	?>
	<tr>
		<td>&nbsp;</td>
		<td colspan="6"></td>
	</tr>
	<tr>
		<td></td>
		<td><?php echo '$ ' . number_format($gross,2,'.',' ');?></td>
		<td><?php echo '$ ' . number_format($paye,2,'.',' ');?></td>
		<td><?php echo '$ ' . number_format($ks,2,'.',' ');?></td>
		<td>$ 0.00</td>
		<td>$ 0.00</td>
		<td><?php echo '$ ' . number_format($nett,2,'.',' ');?></td>
	</tr>
</table>
<?php
	}
}
echo form_close();
?>