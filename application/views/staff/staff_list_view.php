<script>
	$(function(e){
		var content = $('.content-loader');
		var staffTable = $('.staff-table-content');
		var bu = '<?php echo base_url();?>';
		var staffBtn = $('.add-staff');
		staffBtn.click(function(e){
            $(this).modifiedModal({
                title: 'Add Staff',
                url: bu + 'addStaff'
            });
		});

		$('.editStaff').click(function(e){
			var thisId = this.id;
            $(this).modifiedModal({
                title: 'Edit Staff',
                url: bu + 'editStaff/' + thisId
            });
		});

		$('.deleteStaff').click(function(e){
			var thisId = this.id;
			$(this).newForm.formDeleteQuery();
			$('.yesBtn').unbind().on('click', function(e){
				$.post(
					bu + 'deleteWageType',
					{
						id: thisId
					},
					function(e){
						location.reload();
					}
				);
			});
			$('.noBtn').unbind().on('click', function(e){
				$(this).newForm.forceClose();
			});
		});

		var tempValueKs = "";
		$('#has_kiwisave').unbind().on('click',function(e){
			var kp = $('#kiwisave_percentage');
			if(kp.val()){
				tempValueKs = kp.val();
			}

			if($('#has_kiwisave').is(':checked')){
				kp
					.removeAttr('disabled').
					addClass('required')
					.val(tempValueKs);
			}else{
				kp
					.attr('disabled','disabled')
					.removeClass('required')
					.val('');
			}
		});

		var tempValue = "";
		var tempTax = "";
		$('.triggerFixed').unbind().on('click',function(e){
			var fr = $('#fixed_rate');
			var fr_t = $('#fixed_rate, #tax');
			var t = $('#tax');
			if(fr.val()){
				tempValue = fr.val();
			}
			if(t.val()){
				tempTax = t.val();
			}

			fr_t
				.attr('disabled','disabled')
				.removeClass('required')
				.css({
					'border':'1px solid #CCC'
				})
				.val('');

			if($(this).val() != 3){
				fr
					.removeAttr('disabled')
					.addClass('required')
					.val(tempValue);
			}

			if($(this).val() == 1){
				t
					.removeAttr('disabled')
					.addClass('required')
					.val(tempTax);
			}
		});
		$('.a').click(function() {
         var trid = $(this).closest('td').attr('id');
         // alert(trid);
         // $(trid).show();
         $('#a'+ trid).toggle();
        });
	});
</script>
<div class="row">
    <div class="form-group">
        <div class="col-sm-12">
            <a href="#" class="btn btn-sm btn-primary add-staff btn-class pull-right">Add Staff</a>
        </div>
    </div>
</div><br/>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-colored-header">
            <thead>
            <tr>
                <th style="white-space: nowrap;width: 20%">Name</th>
                <th style="width: 25%;" class="data-column">Email</th>
                <th>IRD</th>
                <th>Account No.</th>
                <th>Wage Type</th>
                <th class="data-column">Position</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(count($staffList)>0){
                foreach($staffList as $k=>$v){
                    ?>
                    <tr>
                        <td style="text-align: left;white-space: nowrap;cursor: pointer;" class="a" id="<?php echo $v->ID?>">
                            <?php echo $v->FName.' '.$v->LName;?>
                        </td>
                        <td style="white-space: nowrap;text-align: left;" class="data-column">
                            <?php echo $v->EmailAddress;?>
                        </td>
                        <td>
                            <?php echo $v->IRD;?>
                        </td>
                        <td>
                            <?php echo $v->AccountNumber;?>
                        </td>
                        <td>
                            <?php echo $v->description;?>
                        </td>
                        <td class="data-column">
                            <?php echo $v->AccountName;?>
                        </td>
                        <td style="white-space: nowrap;">
                            <a href="#" class="editStaff" id="<?php echo $v->ID?>">edit</a>
                        </td>
                    </tr>
                    <tr>
                    	<td style="text-align: left"  class="columnHide" id="a<?php echo $v->ID;?>" >
                    		<strong>Email: </strong><?php echo $v->EmailAddress;?><br><br>
                    		<strong>Position: </strong><?php echo $v->AccountName;?><br><br>
                    	</td>
                    </tr>
                <?php
                }
            }
            else{
                ?>
                <tr>
                    <td colspan="5">No data was found.</td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>