<script>
	$(function(e){
		var invoice = $('.invoice-view');
		invoice.click(function(e){
			window.location.href = '<?php echo base_url()?>job_invoice/' + this.id;
		});
	});
</script>
<style>
	.invoice-table{
		width: 98%;
		margin-top: 20px;
	}
	.invoice-table>tbody>tr>th{
		background: #484b4a;
		color: #ffffff;
		font-weight: normal;
		padding: 3px;
		border: 1px solid #d2d2d2;
		font-size: 13px;
	}
	.invoice-table>tbody>tr>td{
		border: 1px solid #d2d2d2;
		padding: 3px;
		font-size: 13px;
	}
	.invoice-table>tbody>tr>td{
		text-align: center;
	}
	.dropdown{
		padding: 5px;
	}
</style>
<?php
echo form_open('');
?>
<table class="invoice-table">
	<tr>
		<td colspan="11" style="border: none!important;white-space: nowrap;text-align: left;">
			<?php
/*			echo '<span style="padding-right:5px">'.form_dropdown('year', $year, date('Y'),'style="width:10%" class="dropdown year"').'</span>';
			echo '<span style="padding-right:5px">'.form_dropdown('month', $months, date('m'),'style="width:10%" class="dropdown month"').'</span>';
			*/?><!--
			<input type="submit" name="search" value="Go" class="m-btn green submit" style="width: 3%;padding: 7px;margin: -1px 0;">-->
		</td>
	</tr>
	<tr>
		<th>Client</th>
		<th style="width: 7%;">Invoice</th>
		<th style="width: 7%;">Invoice Summary</th>
		<th style="width: 7%;">Statement</th>
	</tr>
	<?php
	if(count($clients)>0){
		foreach($clients as $k=>$v){
			?>
			<tr>
				<td style="text-align: left;width: 20%;padding-left: 10px;"><?php echo $v->CompanyName.' <strong>('. $v->invoice_count .')</strong>';?></td>
				<td><a href="#" class="invoice-view" id="<?php echo $v->ID;?>">view</a></td>
				<td><a href="<?php echo base_url().'invoiceSummary/'.$v->ID;?>">view</a></td>
				<td><a href="<?php echo base_url().'statement?cID='.$v->ID.'&pageType=statement';?>">view</a></td>
			</tr>
		<?php }
	}else{
		?>
		<tr>
			<td colspan="12">No Data</td>
		</tr>
	<?php
	}
	?>
</table>
<?php
echo form_close();
?>