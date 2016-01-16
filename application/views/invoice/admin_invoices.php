
<style>
	.invoice-table{
		width: 98%;
		margin: 10px auto;
	}
	.invoice-table tr td:last-child{
		width: 25%;
	}
	#invoicetable{
		border-spacing: 0;
		width: 98%;
		margin: 10px auto;
	}
	#invoicetable>tbody>tr>th{
		border:2px #000 solid;
		border-right:none;
		background:#c9c9c9;
		padding:3px 5px;
	}

	#invoicetable>tbody>tr>th:last-child{
		border-right:2px #000 solid;
	}

	#invoicetable tr td{
		border: 2px none #000;
		border-left-style: solid;
		padding:3px 5px;
		text-align:center;
		vertical-align: top;
	}

	#invoicetable tr:last-child td{
		border-top:2px #000 solid;
		border-bottom:2px #000 solid;
	}

	#invoicetable tr td:last-child{
		border-right:2px #000 solid;
	}
    .disable-btn{
        pointer-events:none;
        background: #767676 !important;
    }
	.pagenum:before { content: counter(page); }
</style>
	<table style="margin-bottom: 50px;" class="invoice-table">
		<tr valign="top">
			<td>
				<?php
				$maxLine = 17;
				$totalLine = $maxLine - count($clientInvoice);
                $disable = count($clientInvoice)>0 ? '' : 'disable-btn';
				?>
				<strong style="text-transform: uppercase;font-size: 16px;"><?php echo $companyName;?></strong><br/><br/>
				<strong style="text-transform: capitalize;"><?php echo $address;?></strong>
			</td>
			<td style="font-size:12px;">
				<div style="text-align:left;font-size: 13px;">
					<img src="<?php echo base_url();?>plugins/img/sample-logo.png" width="250" /><br />
                    <?php
                    if(count($invoice_info)>0){
                        foreach($invoice_info as $iv){
                            ?>
                            <strong style="text-transform: uppercase;font-size: 16px;"><?php echo $iv->company_name;?></strong><br/>
                            <strong><?php echo $iv->address;?></strong><br/>
                            Email:  <strong><?php echo $iv->email;?></strong><br />
                            GST No.:  <strong><?php echo $iv->gst_num;?></strong><br />
                        <?php
                        }
                    }
                    ?>
				</div>
			</td>
		</tr>
	</table>
	<table id="invoicetable">
		<tr id="invoiceTitle">
			<td colspan="9" style="border:none;">
				<table width="100%" style="border:none;margin:0 0 -5px -5px;padding:0;">
					<tr>
						<td align="left" style="text-align:left;border:none;">
							<strong>
								<?php echo 'DATE: '?>
								<?php
								echo date('d-F-y');
								?>
								<span style="margin-left:250px;">TAX INVOICE: <strong ><?php echo count($clientInvoice)>0 ? $taxInvoice : '';?></strong></span>
							</strong>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table id="invoicetable" width="770" style="font-size:12px;">
		<tr>
			<th width="80">Date</th>
			<th width="60">Order No.</th>
			<th width="80">Job No.</th>
			<th>Job Name</th>
			<th width="90">No. of Units/Hrs/Km</th>
			<th width="80">Unit Price</th>
			<th width="50">Extra</th>
			<th width="60">Total</th>
		</tr>
		<?php
		if(count($clientInvoice)>0){
			foreach($clientInvoice as $k=>$v){
				?>
				<tr>
					<td style="border-bottom:none;border-top:none;"><?php echo $v->InspectionDate;?></td>
					<td style="border-bottom:none;border-top:none;"><?php echo $v->OrderNumber;?></td>
					<td style="border-bottom:none;border-top:none;white-space: nowrap"><?php echo $v->JobNumber;?></td>
					<td style="border-bottom:none;border-top:none;"><?php echo $v->CompanyName;?></td>
					<td style="border-bottom:none;border-top:none;white-space: nowrap">
						<?php
						echo $v->totalUnitPrice.'/ ';
						echo $v->totalTravelTime.'/ ';
						echo $v->totalTravelCost;
						?>
					</td>
					<td style="border-bottom:none;border-top:none;white-space: nowrap">
						<?php
						echo '$ '.$unitrate.'/ ';
						echo '$ '.$hourrate.'/ ';
						echo '$ '.$kmrate;
						;?>
					</td>
					<td style="border-bottom:none;border-top:none;">
						<?php
						echo '$ '.number_format($v->extra,2,'.',',');
						?>
					</td>
					<td style="border-bottom:none;border-top:none;">
						<?php
						echo '$ '.number_format($v->subTotal,2,'.',',');
						?>
					</td>
				</tr>
			<?php }
		}
		for($i=0;$i<=$totalLine;$i++){?>
			<tr align="center" style="font-size:10px;">
				<td style="border-bottom:none;border-top:none;">&nbsp;</td>
				<td style="border-bottom:none;border-top:none;">&nbsp;</td>
				<td style="border-bottom:none;border-top:none;">&nbsp;</td>
				<td style="border-bottom:none;border-top:none;">&nbsp;</td>
				<td style="border-bottom:none;border-top:none;">&nbsp;</td>
				<td style="border-bottom:none;border-top:none;">&nbsp;</td>
				<td style="border-bottom:none;border-top:none;">&nbsp;</td>
				<td style="border-bottom:none;border-top:none;">&nbsp;</td>
			</tr>
		<?php }
		?>
		<tr valign="top" style="font-size:13px;">
			<td colspan="5" style="border-right:none;text-align:left;"></td>
			<td colspan="2" align="right" style="border-left:none;text-align: right;" id="subtable">
				<table width="100%">
					<tr>
						<td style="border:none;text-align:right;">Sub Total</td>
						<td style="border:none;text-align:right;width: 50%;"><?php echo '$ '.number_format($totalExtra,2,'.',',');?></td>
					</tr>
					<tr>
						<td style="border:none;">&nbsp;</td>
						<td style="border:none;">&nbsp;</td>
					</tr>
					<tr>
						<td style="border:none;text-align:right;">GST Rate</td>
						<td style="border:none;">&nbsp;</td>
					</tr>
					<tr>
						<td style="border:none;text-align:right;">GST Total</td>
						<td style="border:none;">&nbsp;</td>
					</tr>
					<tr>
						<td style="border:none;text-align:right;"><strong>TOTAL</strong></td>
						<td style="border:none;">&nbsp;</td>
					</tr>
				</table>
			</td>
			<td id="subtable" align="left" style="font-size: 13px;">
				<table width="100%" align="left">
					<tr>
						<td align="left" style="border:none;text-align:right;">
							<?php echo '$ '.number_format($subTotal,2,'.',',');?>
						</td>
					</tr>
					<tr>
						<td style="border:none;text-align: right;">
							<?php
							echo '$ '.number_format($overAllsubTotal,2,'.',',');
							?>
						</td>
					</tr>
					<tr><td align="left" style="border:none;text-align:right;">15.00%</td></tr>
					<tr>
						<td align="left" style="border:none;text-align:right;">
							<?php
							echo $overAllsubTotal ? '$ '.number_format(($overAllsubTotal * 0.15),2,'.',',') : '$ 0';
							?>
						</td>
					</tr>
					<tr>
						<td align="left" style="border:none;text-align:right;">
							<strong>
								<?php
								echo $overAllsubTotal ? '$ '.number_format(($overAllsubTotal - ($overAllsubTotal * 0.15)),2,'.',',') : '$ 0';
								$overall = ($overAllsubTotal - ($overAllsubTotal * 0.15));
                                ?>
							</strong>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<div style="width: 98%;margin: 10px;">
	Please enter you payment date and reference.
	Please use your order number as your reference when you make your payment.<br/>
	<span style="white-space: nowrap;float: right">
		<a href="<?php echo base_url().'invoices';?>" class="m-btn green">Back</a>
		<a href="<?php echo base_url().'archiveInvoice/'.$this->uri->segment(2).'?inv_ref='.$taxInvoice.'&total='.$overall;?>"
           class="m-btn green archive <?php echo $disable;?>">Archive</a>
		<a href="<?php echo base_url().'job_invoice/'.$this->uri->segment(2).'/pdf';?>"
           class="m-btn green <?php echo $disable;?>" target="_blank">Print</a>
	</span>
</div>