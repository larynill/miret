<!--<script src="<?php /*echo base_url();*/?>plugins/js/email.validation.js"></script>
<script language="javascript" src="<?php /*echo base_url();*/?>plugins/js/number.js"></script>

<link href='<?php /*echo base_url();*/?>plugins/css/addForm.css' rel='stylesheet' />
<script src='<?php /*echo base_url();*/?>plugins/js/addForm.js'></script>-->

<script language="JavaScript">
	$(function(e){
		var content = $('.content-loader');
		var staffTable = $('.staff-table-content');
		var bu = '<?php echo base_url();?>';
		var staffBtn = $('.add-staff');
		staffBtn.click(function(e){
			content.show('slow');
			content.load(bu + 'addStaff',function(e){
				staffTable.hide('slow');
				staffBtn.hide('slow');
			});
		});

		$('.editStaff').click(function(e){
			var thisId = this.id;
            $(this).newForm.addNewForm({
                title: 'Edit Staff',
                url:bu + 'editStaff/' + thisId,
                toFind:'#qsTable'
            });
			/*$.fancybox.open({
				href : bu + 'editStaff/' + thisId,
				type : 'ajax',
				height: 800,
				title: 'Add Staff'
			});*/
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
		$('#has_kiwisave').unbind().live('click',function(e){
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
		$('.triggerFixed').unbind().live('click',function(e){
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
	});
</script>
<style>
	.btn-class{
		float: right;
		font-size: 13px;
	}
	.main-table{
		width: 95%;
		font-size: 13px;
        margin: 0 auto;
	}
	.main-table>tbody>tr>td{
		padding: 5px;
	}
	.staff-list-table{
		width: 100%;
	}
	.staff-list-table>tbody>tr>th{
		background: #484b4a;
		color: #ffffff;
		font-weight: normal;
		padding: 5px;
	}
	.staff-list-table>tbody>tr>td{
		border: 1px solid #d2d2d2;
		text-align: center;
		padding: 5px 10px;
	}
</style>
<table class="main-table">
	<tr>
		<td>
			<a href="#" class="m-btn green add-staff btn-class">Add Staff</a>
		</td>
	</tr>
	<tr>
		<td class="content-loader"></td>
	</tr>
	<tr>
		<td class="staff-table-content">
			<table class="staff-list-table">
				<tr>
					<th style="white-space: nowrap;width: 20%">Name</th>
					<th style="width: 25%;">Email</th>
					<!--<th>Status</th>
					<th style="width: 8%">Job Queue</th>-->
					<th>Wage Type</th>
					<th>Position</th>
					<th></th>
				</tr>
				<?php
				if(count($staffList)>0){
					foreach($staffList as $k=>$v){
						?>
						<tr>
							<td style="text-align: left;white-space: nowrap;">
                                <?php echo $v->FName.' '.$v->LName;?>
                            </td>
							<td style="white-space: nowrap;text-align: left;">
                                <?php echo $v->EmailAddress;?>
                            </td>
							<!--<td>
                                <?php /*echo $v->AccountType == 4 ? 'free' : '';*/?>
                            </td>
							<td>
                                <?php /*echo 0;*/?>
                            </td>-->
							<td>
                                <?php echo $v->description;?>
                            </td>
							<td>
                                <?php echo $v->AccountName;?>
                            </td>
							<td style="white-space: nowrap;">
                                <a href="#" class="editStaff" id="<?php echo $v->ID?>">edit</a>
                            </td>
						</tr>
					<?php
					}
				}
				?>
			</table>
		</td>
	</tr>
</table>