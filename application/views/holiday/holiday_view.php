<script>
	$(function(e){
		var addBtn = $('.add-btn');
		var editBtn = $('.edit-btn')
		var bu = '<?php echo base_url()?>';
		addBtn.on('click',function(e){
			e.preventDefault();
			/*$.fancybox.open({
				href : bu + 'set_holiday/add',
				type : 'ajax',
				title: 'Add Holiday'
			});*/
            $(this).newForm.addNewForm({
                title:'Add Holiday',
                url: bu + 'set_holiday/add',
                toFind: '.set-holiday-table'

            });
		});
		editBtn.on('click',function(e){
			e.preventDefault();
            $(this).newForm.addNewForm({
                title:'Edit Holiday',
                url: bu + 'set_holiday/edit/' + this.id,
                toFind: '.set-holiday-table'

            });
			/*$.fancybox.open({
				href : bu + 'set_holiday/edit/' + this.id,
				type : 'ajax',
				title: 'Edit Holiday'
			});*/
		});
	});
</script>
<style>
	.holiday-table{
		width: 60%;
	}
	.holiday-table>tbody>tr>th{
		background: #484b4a;
		color: #ffffff;
		font-weight: normal;
		padding: 5px;
	}
	.holiday-table>tbody>tr>td{
		padding: 5px;
		border: 1px solid #d2d2d2;
	}
	.holiday-type-table{
		width: 100%;
	}
	.holiday-table>tbody>tr>td:nth-child(5),
	.holiday-table>tbody>tr>td:nth-child(4){
		width: 10%!important;
		white-space: nowrap;
	}
</style>
<div class="holiday-div">
	<a href="#" class="m-btn green add-btn">Add</a><br/><br/>
	<table class="holiday-type-table">
        <tr>
            <th style="text-transform: uppercase;text-align: left;font-size: 16px">Fixed Holidays</th>
        </tr>
        <tr>
            <td>
                <table class="holiday-table">
                    <tr>
                        <th>&nbsp;</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th colspan="2"></th>
                    </tr>
                    <?php
                    if(count($holidays)>0){
                        foreach($holidays as $v){
                            if($v->TypeID == 1){
                            ?>
                                <tr>
                                    <td><?php echo $v->HolidayName;?></td>
                                    <td style="width: 20%;white-space: nowrap;"><?php echo date('j F Y',strtotime($v->ActualDate))?></td>
                                    <td style="text-align: center;"><a href="#" class="edit-btn" id="<?php echo $v->ID?>">Edit</a></td>
                                    <td style="text-align: center;"><a href="#" class="delete-btn" id="<?php echo $v->ID?>">Delete</a></td>
                                </tr>
                           <?php
                            }
                        }
                    }?>
                </table>
			</td>
		</tr>
        <tr>
            <th style="text-transform: uppercase;text-align: left;font-size: 16px">Variable Holidays</th>
        </tr>
        <tr>
            <td>
                <table class="holiday-table">
                    <tr>
                        <th>&nbsp;</th>
                        <th>Start Date</th>
                        <th colspan="2"></th>
                    </tr>
                    <?php
                    if(count($holidays)>0):
                        foreach($holidays as $v):
                            if($v->TypeID == 2):
                                ?>
                                <tr>
                                    <td><?php echo $v->HolidayName;?></td>
                                    <td style="width: 20%;white-space: nowrap;"><?php echo date('j F Y',strtotime($v->ActualDate))?></td>
                                    <td style="text-align: center;"><a href="#" class="edit-btn" id="<?php echo $v->ID?>">Edit</a></td>
                                    <td style="text-align: center;"><a href="#" class="delete-btn" id="<?php echo $v->ID?>">Delete</a></td>
                                </tr>
                            <?php
                            endif;
                        endforeach;
                    endif;
                    ?>
                </table>
            </td>
        </tr>
        <tr>
            <th style="text-transform: uppercase;text-align: left;font-size: 16px">Long Holidays</th>
        </tr>
        <tr>
            <td>
                <table class="holiday-table">
                    <tr>
                        <th>&nbsp;</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th colspan="2"></th>
                    </tr>
                    <?php
                    if(count($holidays)>0){
                        foreach($holidays as $v){
                            if($v->TypeID == 3){
                                ?>
                                <tr>
                                    <td><?php echo $v->HolidayName;?></td>
                                    <td style="width: 20%;white-space: nowrap;"><?php echo date('j F Y',strtotime($v->ActualDate))?></td>
                                    <td style="width: 20%;white-space: nowrap;"><?php echo date('j F Y',strtotime($v->EndDate))?></td>
                                    <td style="text-align: center;"><a href="#" class="edit-btn" id="<?php echo $v->ID?>">Edit</a></td>
                                    <td style="text-align: center;"><a href="#" class="delete-btn" id="<?php echo $v->ID?>">Delete</a></td>
                                </tr>
                            <?php
                            }
                        }
                    }?>
                </table>
            </td>
        </tr>
	</table>
</div>