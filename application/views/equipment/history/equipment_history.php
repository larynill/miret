<style>
	.inputText{
		padding: 5px;
	}
	.dataTable{
		border-collapse: collapse;
		width: 60%;
	}
	.dataTable tr td,.dataTable tr th{
		border: 1px solid #d2d2d2;
		padding: 2px;
	}
	.dataTable tr th{
		background: #545454;
		color: #ffffff;
		font-weight: normal;
	}
	.green{
		width: 50px;
		padding: 5px 0;
	}
</style>
<div style="margin: 10px 0;" class="box">
	<div style="padding: 20px 0;" class="toggle-forms">
		Search: <input type="text" name="Search" class="inputText" style="width: 200px;">
		<input type="submit" name="submit" value="Go" class="m-btn green">
	</div>
	<table class="dataTable">
		<tr>
			<th>Date</th>
			<th>Quote Number</th>
		</tr>
		<?php
		if(count($quote)>0){
			foreach($quote as $k=>$v){
				?>
				<tr>
					<td>
						<?php
						echo $v->Date;
						?>
					</td>
					<td style="text-align: center;">
						<?php
						echo $v->Number;
						?>
					</td>
				</tr>
			<?php }
		}
		?>
	</table>
</div>