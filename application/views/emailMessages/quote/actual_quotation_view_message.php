<?php
echo form_open('accept_qoute/'.$trackID.'/'.$quotationID);
?>
<div style="border-top: 1px solid #d2d2d2;">
	<div style="padding: 20px 0;">
		<table style="width: 98%;">
			<tr>
				<td style="width: 70%;">
					<?php
					if(count($clientInfo)>0){
						foreach($clientInfo as $ck=>$cv){
							?>
							<span>Company Name: </span><strong><?php echo $cv->CompanyName;?></strong><br/>
							<span>Mobile: </span><strong><?php echo $cv->MobilePhone;?></strong><br/>
							<span>Address: </span>
						<?php }
					}
					?>
				</td>
				<td style="padding: 0 0 0 90px;">
					<img src="<?php echo base_url();?>plugins/img/sample-logo.png" width="250"><br/>
					<strong style="text-transform: uppercase;">Universal Inspector</strong><br/>
					<span>Long Street, Auckland</span><br/>
					<span>New Zealand</span><br/>
					<span>P.O Box </span><br/>
					<span>Email:</span>
				</td>
			</tr>
		</table>

		<!--<span>This is the quotation as requested for the equipment under mention.</span>-->
	</div>
	<div>
		<table style="border-collapse: collapse;width: 98%;">
			<tr>
				<td style="text-align: left;padding: 5px;">
					<strong>Date: </strong><span><?php echo date('j F Y');?></span>
				</td>
				<td colspan="2">
					<strong>Quote #: <span style="text-transform: uppercase;"><?php echo $quoteNumber;?></span></strong>
				</td>
			</tr>
			<tr>
				<th style="background: #484b4a;color: #ffffff;padding: 5px;"></th>
				<th style="background: #484b4a;color: #ffffff;padding: 5px;">Breakdown</th>
				<th style="background: #484b4a;color: #ffffff;padding: 5px;">Total</th>
			</tr>
			<?php
			if(count($quotation)>0){
				foreach($quotation as $k=>$v){
					?>
					<tr style="border-top:1px solid #d2d2d2">
						<td style="padding: 5px;border-left:1px solid #d2d2d2">1. Inspection</td>
						<td style="padding: 5px;border-left:1px solid #d2d2d2"><?php echo $v->inspection;?></td>
						<td style="padding: 5px;border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2"><?php echo $v->totalUnitPrice;?></td>
					</tr>
					<tr>
						<td style="padding: 5px;border-left:1px solid #d2d2d2">2. Traveling Time</td>
						<td style="padding: 5px;border-left:1px solid #d2d2d2"><?php echo $v->travelTime;?></td>
						<td style="padding: 5px;border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2"><?php echo $v->TotalTravelTime;?></td>
					</tr>
					<tr>
						<td style="padding: 5px;border-left:1px solid #d2d2d2">3. Traveling Cost</td>
						<td style="padding: 5px;border-left:1px solid #d2d2d2"><?php echo $v->travelCost;?></td>
						<td style="padding: 5px;border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2"><?php echo $v->TotalTravelDistance;?></td>
					</tr>
					<tr>
						<td style="padding: 5px;border-left:1px solid #d2d2d2">4. Flight Time</td>
						<td style="padding: 5px;border-left:1px solid #d2d2d2"><?php echo $v->totalflightTime;?></td>
						<td style="padding: 5px;border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2"><?php echo $v->TotalFlightTime;?></td>
					</tr>
					<tr>
						<td style="padding: 5px;border-left:1px solid #d2d2d2">5. Flight $</td>
						<td style="padding: 5px;border-left:1px solid #d2d2d2"></td>
						<td style="padding: 5px;border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2"><?php echo $v->TotalFlightCost;?></td>
					</tr>
					<tr style="border-bottom: 1px solid #d2d2d2;">
						<td style="padding: 5px;border-left:1px solid #d2d2d2">6. Accommodation</td>
						<td style="padding: 5px;border-left:1px solid #d2d2d2"></td>
						<td style="padding: 5px;border-left:1px solid #d2d2d2;border-right:1px solid #d2d2d2"><?php echo $v->TotalAccommodation;?></td>
					</tr>
					<tr style="border-left: 1px solid #d2d2d2;border-right: 1px solid #d2d2d2;">
						<td style="padding: 5px 20px 0 0;text-align: right;border-right: 1px solid #d2d2d2;" colspan="2">Sub Total</td>
						<td style="padding: 5px;"><?php echo '$'.number_format($v->subTotal,'2','.',', ');?></td>
					</tr>
					<tr style="border-left: 1px solid #d2d2d2;border-right: 1px solid #d2d2d2;">
						<td style="padding: 5px 20px 0 0;text-align: right;border-right: 1px solid #d2d2d2;" colspan="2">GST Rate</td>
						<td style="padding: 5px;">15%</td>
					</tr>
					<tr style="border-left: 1px solid #d2d2d2;border-right: 1px solid #d2d2d2;">
						<td style="padding: 5px 20px 0 0;text-align: right;border-right: 1px solid #d2d2d2;" colspan="2">GST Total</td>
						<td style="padding: 5px;"><?php echo '$'.number_format($v->totalGST,'2','.',', ');?></td>
					</tr>
					<tr style="border-left: 1px solid #d2d2d2;border-right: 1px solid #d2d2d2;">
						<td style="padding: 5px 20px 0 0;text-align: right;border-right: 1px solid #d2d2d2;" colspan="2">Discount Rate</td>
						<td style="padding: 5px;"><?php echo $v->DiscountBanned.'%';?></td>
					</tr>
					<tr style="border-left: 1px solid #d2d2d2;border-right: 1px solid #d2d2d2;">
						<td style="padding: 5px 20px 0 0;text-align: right;border-right: 1px solid #d2d2d2;" colspan="2">Discount Total</td>
						<td style="padding: 5px;"><?php echo '$'.number_format($v->discountTotal,'2','.',', ');?></td>
					</tr>
					<tr style="border-bottom:1px solid #d2d2d2;border-left: 1px solid #d2d2d2;border-right: 1px solid #d2d2d2;">
						<td style="padding: 5px 20px 0 0;text-align: right;font-weight: bold;border-right: 1px solid #d2d2d2;text-transform: uppercase;" colspan="2">Total</td>
						<td style="padding: 5px;font-weight: bold;"><?php echo '$'.number_format($v->total,'2','.',', ');?></td>
					</tr>
				<?php
				}
			}
			?>
		</table>
	</div><br/><br/>
	<span>Kindly accept quotation and supply us your order number. Thank you.</span><br/><br/>
	<div>
		<strong>Order Number:</strong>
		<span><input type="text" name="orderNumber" style="padding: 5px;"></span>
	</div><br/><br/>
	<div>
		<input type="submit" name="submit" value="Accept" style="padding: 8px 10px;border:none;color:#ffffff;cursor:pointer!important;background-color: #35aa47;width: 110px;text-align: center;">
	</div>
</div>
<?php
echo form_close();
?>