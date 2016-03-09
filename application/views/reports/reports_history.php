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
?>
<div class="row">
    <div class="form-group">
        <div class="col-sm-8">
            <div class="col-sm-3">
                <?php
                echo form_dropdown('declaration',$declaration,1,'class="form-control input-sm dropdown type-class"');
                ?>
            </div>
            <div class="col-sm-3">
                <?php
                echo form_dropdown('month',$month,date('m'),'class="form-control input-sm dropdown month-class"');
                ?>
            </div>
            <div class="col-sm-3">
                <?php
                echo form_dropdown('year',$year,date('Y'),'class="form-control input-sm dropdown year-class"');
                ?>
            </div>
            <div class="col-sm-2">
                <button type="submit" name="submit" class="btn-sm btn btn-primary">Go</button>
            </div>
        </div>
    </div>
</div><br/>
<table class="table table-colored-header">
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
            <td colspan="6">No data was found.</td>
        </tr>
    <?php
    endif;
    ?>
    </tbody>
</table>
<?php
echo form_close();
?>