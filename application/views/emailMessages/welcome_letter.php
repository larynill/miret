<div style="border: 1px solid #d2d2d2;width: 850px;font-family: Arial,sans-serif;background: #ffffff">
	<table>
		<?php
		if(count($clientInfo)>0){
			foreach($clientInfo as $key=>$val){
				?>
				<tr>
					<td style="padding: 50px 50px 0 50px;">
						<span style="text-transform: uppercase;font-weight: bold;"><?php echo $val->CompanyName;?></span><br/>
						<?php echo $val->postalAddress;?>
					</td>
					<td style="padding: 50px 50px 0 260px;">
						<div style="float: right;">
							<img src="<?php echo base_url();?>plugins/img/sample-logo.png" width="250px"><br/>
							<span style="text-transform: uppercase;font-weight: bold;">Universal Inspectors</span><br/>
							Long Street, Auckland<br/>
							universalinspectors@gmail.com
						</div>
					</td>
				</tr>
				<tr>
					<td style="padding: 50px 50px 0 50px;"><?php echo date('j F Y');?></td>
				</tr>
				<tr>
					<td style="padding: 50px 50px 20px 50px;" colspan="2">
						Dear <?php echo $val->FirstName;?>,<br/><br/>
						<p style="text-align:justify;">Good Day! Welcome as a client of Universal Inspectors. We thank you for the opportunity to service your equipment
							and we assure you our excellence.
						</p>
					</td>
				</tr>
				<tr>
					<td style="padding: 50px">
						Respectfully yours,<br/><br/>
						<span>Tony Howard</span><br/>
						<span style="font-weight: bold;">Manager</span>
					</td>
				</tr>
			<?php }
		}
		?>
	</table>
</div>