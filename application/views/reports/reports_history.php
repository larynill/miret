<script>
	$(function(e){
		var typeValue = $('.type-class');
		var month = $('.month-class');
		var displayDropdown = function(){
			var whatVal = typeValue.val();
			if(whatVal != 1){
				month.css({
					display:'none'
				});
			}else{
				month.css({
					display:'inline'
				});
			}
		};

		displayDropdown();

		typeValue.change(function(e){
			displayDropdown();
		});
	});
</script>
<style>
	.dropdown{
		padding: 3px;
		width: 10%;
		margin: 20px 0;
	}
	.invoice-history-table{
		width: 98%;
	}
	.invoice-history-table > thead > tr > th{
		font-weight: normal;
		color: #ffffff;
		background: #484b4a;
		padding: 5px;
	}
	.invoice-history-table > tbody > tr > td{
		border: 1px solid #d2d2d2;
		text-align: center;
        padding: 5px;
	}
</style>
<?php
echo form_open('');
echo form_dropdown('declaration',$declaration,1,'class="dropdown type-class"').'&nbsp;';
echo form_dropdown('month',$month,date('m'),'class="dropdown month-class"').'&nbsp;';
echo form_dropdown('year',$year,date('Y'),'class="dropdown year-class"').'&nbsp;';
?>
<input type="submit" name="submit" value="Go" class="m-btn green goBtn" style="width: 5%;">
<table class="invoice-history-table">
    <thead>
	<tr>
		<th>Date</th>
		<th>Invoice No.</th>
		<th>Client</th>
		<th>Description</th>
		<th>Payment Method</th>
		<th>Total Received</th>
	</tr>
    </thead>
    <tbody>
    <?php
    if(count($invoice_history)>0):
        foreach($invoice_history as $k=>$v):
            if(is_array($v)):
                foreach($v as $val):
                ?>
                    <tr>
                        <td colspan="6" style="background: #82d8ff;font-style: italic;">
                            <?php
                            echo 'Invoice Report for the '.$k;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            echo $val->date;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $val->reference;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $val->client;
                            ?>
                        </td>
                        <td></td>
                        <td></td>
                        <td style="text-align: left">
                            <?php
                            echo $val->credits;
                            ?>
                        </td>
                    </tr>
                    <?php
                endforeach;
            else:
             ?>
                <tr>
                    <td>
                        <?php
                        echo $v->date;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $v->reference;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $v->client;
                        ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td style="text-align: left">
                        <?php
                        echo $v->credits;
                        ?>
                    </td>
                </tr>
            <?php
            endif;
        endforeach;
    else:
    ?>
        <tr>
            <td colspan="6">No data has been found.</td>
        </tr>
    <?php
    endif;
    ?>
    </tbody>
</table>
<?php
echo form_close();
?>