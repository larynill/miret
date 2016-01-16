<script>
	$(function(e){
		var bu = '<?php echo base_url();?>';
		var dropDown = $('.type-class');
		var checkDropdown = function(){
			if(dropDown.val() == 3){
				$('.tr-class td').css({
					'display' : 'inline'
				});
			}else{
				$('.tr-class td').css({
					'display' : 'none'
				});
			}
		};
		$('.datepicker').datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:'d MM yy',
			showOn: 'button',
			buttonImage: bu + 'plugins/img/calendar-add.png',
			buttonImageOnly: true,
			onSelect: function(){
				var msg = $(this).parent().find('.msg-content');
				msg.html($(this).val());
			}
		});

		dropDown.change(function(e){
			if($(this).val() == 3){
				$('.tr-class td').css({
					'display' : 'inline'
				});
			}else{
				$('.tr-class td').css({
					'display' : 'none'
				});
			}
		});
		checkDropdown();
        $('.cancel').on('click',function(e){
           $(this).newForm.forceClose();
        });
        $('.submit').click(function(){
            var isEmpty = false;
            $('.required').each(function(e){
               if(!$(this).val()){
                   isEmpty = true;
                   $(this).css({
                      border:'1px solid #ff0000'
                   });
               }
            });
            if(isEmpty){
                e.preventDefault();
            }
        });
	});
</script>
<style>
	.ui-datepicker-trigger{
		width: 10%;
		float: right;
	}
	.text-input-value{
		padding: 5px!important;
	}
	.set-holiday-table{
        font-size: 13px!important;
        height: 200px;
		width: 300px;
	}
	.set-holiday-table>tbody>tr>td{
		padding: 5px!important;
		white-space: nowrap;
	}
	.drop-down{
		padding: 5px!important;
		width: 80%;
	}
	.set-holiday-table .tr-class td{
		display: none;
	}
</style>
<?php
echo form_open('');
?>
<?php
if($action == 'add'){
	?>
	<table class="set-holiday-table">
		<tr>
			<td>Holiday</td>
			<td><input type="text" name="holiday" class="text-input-value required"></td>
		</tr>
		<tr>
			<td>Type</td>
			<td><?php echo form_dropdown('type',$type,'','class="drop-down type-class required"')?></td>
		</tr>
		<tr>
			<td>Date</td>
			<td style="white-space: nowrap!important;">
				<span class="msg-content" style="width: 100%;white-space: nowrap;font-weight: bold;">N/A</span>
				<input type="hidden" name="date" class="datepicker"><br/>
			</td>
		</tr>
		<tr class="tr-class">
			<td>End Date</td>
			<td style="white-space: nowrap!important;">
				<span class="msg-content" style="width: 100%;white-space: nowrap;font-weight: bold;">N/A</span>
				<input type="hidden" name="enddate" class="datepicker"><br/>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: right;">
				<input type="submit" name="submit" value="Add" class="m-btn green submit" style="width: 20%;">
                <input type="button" name="cancel" value="Cancel" class="m-btn green cancel" style="width: 25%;">
			</td>
		</tr>
	</table>
<?php
}else{
	?>
	<table class="set-holiday-table">
		<?php
		if(count($holiday)>0){
			foreach($holiday as $k=>$v){
				?>
				<tr>
					<td>Holiday</td>
					<td><input type="text" name="holiday" class="text-input-value required" value="<?php echo $v->HolidayName;?>"></td>
				</tr>
				<tr>
					<td>Type</td>
					<td><?php echo form_dropdown('type',$type,$v->TypeID,'class="drop-down type-class required"')?></td>
				</tr>
				<tr>
					<td>Date</td>
					<td style="white-space: nowrap!important;">
						<span class="msg-content" style="width: 100%;white-space: nowrap;font-weight: bold;">
							<?php echo date('j F Y',strtotime($v->ActualDate))?>
						</span>
						<input type="hidden" name="date" class="datepicker" value="<?php echo date('j F Y',strtotime($v->ActualDate))?>"><br/>
					</td>
				</tr>
				<tr class="tr-class">
					<td>End Date</td>
					<td style="white-space: nowrap!important;">
						<span class="msg-content" style="width: 100%;white-space: nowrap;font-weight: bold;">
							<?php echo date('j F Y',strtotime($v->EndDate))?>
						</span>
						<input type="hidden" name="enddate" class="datepicker" value="<?php echo $v->EndDate ? date('j F Y',strtotime($v->EndDate)): ''?>"><br/>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;">
						<input type="submit" name="update" value="Update" class="m-btn green submit" style="width: 25%;">
                        <input type="button" name="cancel" value="Cancel" class="m-btn green cancel" style="width: 25%;">
					</td>
				</tr>

			<?php
			}
		}
		?>
	</table>
<?php
}
?>

<?php
echo form_close();
?>