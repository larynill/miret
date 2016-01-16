<?php
echo form_open('');
?>
<table id="qsTable">
	<tr style="vertical-align: top;">
		<td>
			<table>
				<tr>
					<td>IRD Number:</td>
					<td>
						<input type="text" name="irdnum" id="irdnum" class="required"/>
					</td>
				</tr>
				<tr>
					<td>Account Number:</td>
					<td>
						<input type="text" name="account_number" id="account_number" class="required"/>
					</td>
				</tr>
				<tr>
					<td>Tax Code:</td>
					<td>
						<?php
						echo form_dropdown('tax_code', $tax_codes, '', 'style="width: 200px;" id="tax_code" class="required"');
						?>
					</td>
				</tr>
				<tr>
					<td>Account Type:</td>
					<td>
						<?php
						echo form_dropdown('account_type', $account_type, '', 'style="width: 200px;" id="tax_code" class="required"');
						?>
					</td>
				</tr>
				<tr>
					<td>First Name:</td>
					<td>
						<input type="text" name="fname" id="fname" class="required"/>
						<input type="hidden" name="qsid" id="qsid" value=""/>
					</td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="lname" id="lname" class="required"/></td>
				</tr>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" id="lname" class="required"/></td>
				</tr>
				<tr valign="top">
					<td>Address:</td>
					<td><textarea name="address" id="address" style="height:80px;resize:none;font-size:12px;" class="required"></textarea></td>
				</tr>
				<tr>
					<td>Email:</td>
					<td><input type="text" name="email" id="email" class="required"/></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password" id="password" class="required" value=""/></td>
				</tr>
				<tr>
					<td>Confirm Password:</td>
					<td><input type="password" name="conpassword" id="conPassword" class="required"/></td>
				</tr>
				<tr>
					<td>Area Designated:</td>
					<td>
						<?php
						echo form_dropdown('franchise_id', $area, '', 'id="franchise_id"');
						?>
					</td>
				</tr>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<td colspan="2" style="text-align:left;"><strong>Wage Information</strong></td>
				</tr>
				<tr>
					<td>Frequency:</td>
					<td>
						<?php
						echo form_dropdown('frequency', $frequency, '', 'id="frequency"');
						?>
					</td>
				</tr>
				<tr>
					<td>Wage Type:</td>
					<td>
						<?php
						echo form_dropdown('wage_type', $type, '', 'id="wage_type" class="triggerFixed"');
						?>
					</td>
				</tr>
				<tr>
					<td>Fixed value:</td>
					<td>
						<input type="text" id="fixed_rate" name="fixed_rate" class="required" placeholder="if fixed here..." />
					</td>
				</tr>
				<tr>
					<td>Tax:</td>
					<td>
						<input type="text" id="tax" name="tax" />
					</td>
				</tr>
				<tr style="vertical-align: middle;">
					<td></td>
					<td style="white-space: nowrap;text-align: left;">
						<input type="checkbox" id="has_stloan" name="has_stloan" value="1" style="width: 20%;"/>
						ST Loan<br />
						<input type="checkbox" id="has_kiwisave" name="has_kiwisave" value="1" style="width: 20%;"/>
						Kiwi Save %<br/><br/>
						<?php
						echo form_dropdown('kiwisave_percentage', $kiwi, '', 'id="kiwisave_percentage" disabled="disabled"');
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align: right;">
			<span id="errorMsg" style="color:#F00;font-size:12px;"></span>
			<input type="submit" name="submit" value="Add" class="qsAddBtn m-btn green" style="width: 15%;"/>
			<input type="button" name="cancel" value="Cancel" class="cancelBtn m-btn green" style="width: 15%;"/>
		</td>
	</tr>
</table>
<?php
echo form_close();
?>
<style>
    #qsTable{
        font-size: 12px;
    }
    #qsTable tr td{
        text-align: left;
        padding: 5px;
    }
    #qsTable tr td:first-child{
        text-align: right;
        font-weight: bold;
        white-space: nowrap;
    }

    input[type=text], input[type=password], textarea, select{
        width: 200px;
        padding: 5px 8px;
    }
</style>
<script>
    $(function(e){
        var bu = '<?php echo base_url();?>';
        var cssUrl = bu + "plugins/css/email.validation.css";
        if($('link[href="' + cssUrl + '"]').length == 0){
            $("<link/>", {
                rel: "stylesheet",
                type: "text/css",
                href: cssUrl
            }).appendTo("head");
        }
        var content = $('.content-loader');
        var staffTable = $('.staff-table-content');
        var staffBtn = $('.add-staff');

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

            if(password.val() && conPassword.val()){
                if(password.val().length < 5 || conPassword.val().length < 5){
                    msg = 'Password should be > 5 character!';

                    hasEmpty = true;
                }else{
                    if(password.val() != conPassword.val()){
                        msg = "Password Doesn't Match!";
                        hasEmpty = true;
                    }
                }
            }else{
                hasEmpty = true;
            }

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
        cancelBtn.click(function(e){
            content.hide('slow');
            staffTable.show('slow');
            staffBtn.show('slow');
            //$(this).newForm.forceClose();
        });

        $('#tax, #fixed_rate, #kiwisave_percentage').numberOnly();
    });
</script>