<div>
	<h3 style="border-bottom: 1px solid #d2d2d2">Actual Quotation</h3><br/>
	<?php
	if(count($actual_quote)>0){
		foreach($actual_quote as $k=>$v){
			?>
			<strong>Your quotation is: </strong><span>$ <?php echo $v->Accommodation;?></span><br/>
			<strong>Inspection: </strong>
			<span> $
				<?php
				if(!$v->UnitPrice){
					echo $v->PerHour;
				}else if(!$v->PerHour){
					echo $v->UnitPrice;
				}else{
					echo $v->UnitPrice;
				}
				?>
			</span><br/>
			<strong>Traveling Time: </strong><span>$ <?php echo $v->TravelTime;?></span><br/>
			<strong>Traveling Distance: </strong><span>$ <?php echo $v->TravelDistance;?></span><br/><br/>
		<?php
		}
	}
	?>
	<div style="padding: 8px 10px; background-color: #35aa47;width: 110px;text-align: center;">
		<a style="text-decoration: none; outline: none; color: #fff; cursor: pointer;border: none;"
		   href="<?php echo base_url() . 'request/quote_accept/' . $trackID;  ?>">
			Quote Response
		</a>
	</div>
</div>