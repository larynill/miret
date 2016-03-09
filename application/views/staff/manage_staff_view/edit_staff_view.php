
<script>
	$(function(e){
		var bu = '<?php echo base_url();?>';
		var cssUrl = bu + "plugins/css/email.validation.css";
        var isAllowWages = function(){
            var isAllowWages = $('#isAllowWages');
            if(isAllowWages.is(':checked')){
                $('.wages').css({
                    'display' : 'inline'
                });
            }
            else{
                $('.wages').css({
                    'display' : 'none'
                });
            }
        };

        isAllowWages();

        $('#isAllowWages').click(function(e){
            if($(this).is(':checked')){
                var ele =
                    'This is a one-way option due to the Wage Regulations. If you turn this option on and <br/>' +
                    'put through even one Wage transaction for this user, then it cannot be turned off as <br/>' +
                    'wage records must be kept for 10 years. Only proceed if you are certain that you wish <br/>' +
                    'this system to handle this staff members wages or salary.<br/>';

                $(this).newForm.formDeleteQuery({
                    title: 'Allow Wage?',
                    msg: ele
                });

                $('body')
                    .on('click','.yesBtn',function(){
                        $('#isAllowWages').prop('checked',true);
                        $(this).newForm.forceClose();
                        $('.wages').css({
                            'display' : 'inline'
                        });

                    })
                    .on('click','.noBtn',function(){
                        $(this).newForm.forceClose();
                        $('#isAllowWages').prop('checked',false);
                        $('.wages').css({
                            'display' : 'none'
                        });
                    });
            }
            else{
                $('.wages').css({
                    'display' : 'none'
                });
            }
        });


		if($('link[href="' + cssUrl + '"]').length == 0){
			$("<link/>", {
				rel: "stylesheet",
				type: "text/css",
				href: cssUrl
			}).appendTo("head");
		}
		var qsAddBtn = $('.qsAddBtn');
		var cancelBtn = $('.cancelBtn');
		var password = $('#password');
		var conPassword = $('#conPassword');
		var err = $('#errorMsg');

		qsAddBtn.click(function(e){
			var hasEmpty = false;
			var msg = '';

			$('.required').each(function() {
				$(this).css({
					'border': '#CCC 1px solid',
					padding: '5px 8px'
				});

				if(!$(this).val()){
					$(this).css({
						'border': '#F00 1px solid',
						padding: '5px 8px'
					});
					hasEmpty = true;

					msg = "Empty Field(s)!";
				}
			});

			if(hasEmpty){
				err.html(msg);

				e.preventDefault();
			}
		});

		$('#email').checkingMail({
			submit: qsAddBtn,
			checkOption: {
				alias: $(this).val(),
				url: bu + 'checkQsEmail'
			}
		});

		$('#tax, #fixed_rate, #kiwisave_percentage').numberOnly();

	});
</script>

<style>
    .checkbox-class{
        width: 20%;
    }
</style>
<?php
echo form_open('');

if(count($staffInfo)>0) {
    foreach ($staffInfo as $k => $v) {
        ?>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">IRD Number:</label>
                        <input type="text" name="irdnum" id="irdnum" class="form-control input-sm"
                               value="<?php echo $v->IRD;?>"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Account Number:</label>
                        <input type="text" name="account_number" id="account_number" class="form-control input-sm"
                               value="<?php echo $v->AccountNumber;?>"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Tax Code:</label>
                        <?php
                        echo form_dropdown('tax_code', $tax_codes, $v->TaxCode, 'style="width: 200px;" id="tax_code" class="form-control input-sm required"');
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Account Type:</label>
                        <?php
                        echo form_dropdown('account_type', $account_type, $v->AccountType, 'style="width: 200px;" id="tax_code" class="form-control input-sm required"');
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">First Name:</label>
                        <input type="text" name="fname" id="fname" class="form-control input-sm required"
                               value="<?php echo $v->FName;?>"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Last Name:</label>
                        <input type="text" name="lname" id="lname" class="form-control input-sm required"
                               value="<?php echo $v->LName;?>"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Username:</label>
                        <input type="text" name="username" id="lname" class="form-control input-sm required"
                               value="<?php echo $v->Username;?>"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Address:</label>
                        <textarea name="address" id="address" style="height:80px;resize:none;font-size:12px;"
                                  class="form-control input-sm"><?php echo $v->Address;?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email:</label>
                        <input type="text" name="email" id="email" class="form-control input-sm required"
                               value="<?php echo $v->EmailAddress;?>"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Area Designated:</label>
                        <?php
                        echo form_dropdown('franchise_id', $area, $v->AreaDesignated, 'id="franchise_id" class="form-control input-sm"');
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="form-group">
                            <div class="checkbox-inline">
                                <strong>Allow Wages?</strong><input type="checkbox" id="isAllowWages" name="isAllowWages" value="1" <?php echo $v->isAllowWages == 1 ? 'checked' : '';?> class="pull-left checkbox-class" style="margin-left: 47px;"/>
                            </div>
                        </div>
                    </div>
                    <div class="wages">
                        <div class="well well-sm">
                            <h5>Wage Information</h5>
                            <div class="form-group">
                                <label class="control-label">Frequency:</label>
                                <?php
                                echo form_dropdown('frequency', $frequency, $v->Frequency, 'id="frequency" class="form-control input-sm"');
                                ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Wage Type:</label>
                                <?php
                                echo form_dropdown('wage_type', $type, $v->WageType, 'id="wage_type" class="triggerFixed form-control input-sm"');
                                ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Fixed value:</label>
                                <input type="text" id="fixed_rate" name="fixed_rate" class="form-control input-sm"
                                       placeholder="if fixed here..." value="<?php echo $v->FixedValue;?>"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Tax:</label>
                                <input type="text" id="tax" name="tax" class="form-control input-sm"
                                       value="<?php echo $v->Tax;?>"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Tax:</label>
                                <input type="text" id="tax" name="tax" class="form-control input-sm"
                                       value="<?php echo $v->Tax;?>"/>
                            </div>
                            <?php
                            $checked = '';
                            if ($v->STLoan) {
                                $checked = 'checked';
                            }
                            $checkedKiwi = '';
                            if ($v->KiwiSave) {
                                $checkedKiwi = 'checked';
                            }
                            ?>
                            <div class="form-group">
                                <div class="checkbox-inline">
                                    <input type="checkbox" id="has_stloan" name="has_stloan" value="1"
                                           style="width: 20%;" <?php echo $checked;?>/>
                                    ST Loan
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <div class="checkbox-inline">
                                            <input type="checkbox" id="has_kiwisave" name="has_kiwisave" value="1"
                                                   style="width: 20%;" <?php echo $checkedKiwi;?>/>
                                            Kiwi Save %
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php
                                        echo form_dropdown('kiwisave_percentage', $kiwi, $v->KiwiPercent, 'id="kiwisave_percentage" class="form-control input-sm" disabled="disabled"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="checkbox-inline">
                                <strong>Can Add Job?</strong><input type="checkbox" name="isCanAddJob" id="isCanAddJob" class="checkbox-class" value="1" <?php echo $v->isCanAddJob == 1 ? 'checked' : '';?> style="margin-left: 50px;"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-inline">
                                <strong>Qualified Inspector?</strong><input type="checkbox" name="isQualifiedInspector" id="isQualifiedInspector" class="checkbox-class" value="1" <?php echo $v->isQualifiedInspector == 1 ? 'checked' : '';?> style="margin-left: 10px;"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}
?>
<div class="modal-footer">
    <span id="errorMsg" style="color:#F00;font-size:12px;"></span>
    <button type="submit" name="update" class="qsAddBtn btn btn-sm btn-primary" >Update</button>
    <button type="button" name="cancel" class="cancelBtn btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
</div>
<?php
echo form_close();
?>