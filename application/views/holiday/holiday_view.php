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
<a href="#" class="btn btn-sm btn-primary add-btn">Add</a><br/><br/>
<div class="row">
    <div class="col-sm-12">
        <table class="table">
            <tr>
                <th style="text-transform: uppercase;text-align: left;font-size: 16px">Fixed Holidays</th>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col-sm-8">
                            <table class="table table-colored-header">
                                <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th colspan="2"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(count($holidays)>0) {
                                    foreach ($holidays as $v) {
                                        if ($v->TypeID == 1) {
                                            ?>
                                            <tr>
                                                <td><?php echo $v->HolidayName;?></td>
                                                <td style="width: 20%;white-space: nowrap;"><?php echo date('j F Y', strtotime($v->ActualDate))?></td>
                                                <td style="text-align: center;">
                                                    <a href="#" class="edit-btn" id="<?php echo $v->ID?>">Edit</a>
                                                </td>
                                                <td style="text-align: center;">
                                                    <a href="#" class="delete-btn" id="<?php echo $v->ID?>">Delete</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                }
                                else{
                                    ?>
                                    <tr>
                                        <td colspan="4">No data was found.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th style="text-transform: uppercase;text-align: left;font-size: 16px">Variable Holidays</th>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col-sm-8">
                            <table class="table table-colored-header">
                                <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Start Date</th>
                                    <th colspan="2"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(count($holidays)>0) {
                                    foreach ($holidays as $v) {
                                        if ($v->TypeID == 2) {
                                            ?>
                                            <tr>
                                                <td><?php echo $v->HolidayName; ?></td>
                                                <td style="width: 20%;white-space: nowrap;"><?php echo date('j F Y', strtotime($v->ActualDate)) ?></td>
                                                <td style="text-align: center;">
                                                    <a href="#" class="edit-btn" id="<?php echo $v->ID ?>">Edit</a>
                                                </td>
                                                <td style="text-align: center;">
                                                    <a href="#" class="delete-btn" id="<?php echo $v->ID ?>">Delete</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                }
                                else{
                                    ?>
                                    <tr>
                                        <td colspan="4">No data was found.</td>
                                    </tr>
                                <?php
                                }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th style="text-transform: uppercase;text-align: left;font-size: 16px">Long Holidays</th>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="col-sm-8">
                            <table class="table table-colored-header">
                                <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th colspan="2"></th>
                                </tr>
                                </thead>
                                <tbody>
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
                                }
                                else{
                                    ?>
                                    <tr>
                                        <td colspan="5">No data was found.</td>
                                    </tr>
                                <?php
                                }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>