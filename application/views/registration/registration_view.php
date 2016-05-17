<style>
    #tabsOut{
        font: 12px Helvetica, Arial, 'Liberation Sans', FreeSans, sans-serif;
    }
</style>

<script type="text/javascript">
    $(function(){
        var fname = $("#firstName");
        var lname = $("#lastName");
        var cName = $("#clientName");

        var fNameValue = "";
        var lNameValue = "";

        fname.focusout(function(e){
            fNameValue = $(this).val();
        }).blur(function(e){
                cName.attr(
                    'placeholder', fNameValue + ' ' + lNameValue
                );
            });

        lname.focusout(function(e){
            lNameValue = $(this).val();
        }).blur(function(e){
                cName.attr(
                    'placeholder', fNameValue + ' ' + lNameValue
                );
            });

        var num = $(".numberOnly");
        num.numberOnly(
            {
                wholeNumber: true
            }
        );

        var submit = $(".submit");
		submit.click(function(e){
			var hasEmpty = false;
			var emptyTitle = '';
			$('.required').each(function(e){
				$(this).css({
					border: '1px solid #CCC'
				});

				if(!$(this).val()){
					$(this).css({
						border: '1px solid #FF624C'
					});

					hasEmpty = true;
					emptyTitle = 'Please input the required field!';
				}
			});

			var msg = $('.msg');
			msg.html(emptyTitle);

			if(hasEmpty){
				e.preventDefault();
			}
		});


        $('#equipSave').click(function(e){
			$.post(
				'<?php echo base_url() . 'registerClient'; ?>',
				{
					equipmentSave : true
				},
				function(e){
					location.reload();
				}
			);
        });


        $('.date_picker').datepicker();
        var inspect = $('#date_inspection');
        var frequency = $('#date_frequency');
        inspect.datepicker({
            minDate: new Date(),
            inline: true,
            onSelect: function(e){
                var d1 = new Date($(this).val());
                var d2 =  new Date();
                if(d1 < d2){
                    alert('ERROR: Cannot calculate the frequency of a past date');
                    e.preventDefault();
                }

                //get the number of days if less than one month
                if(monthDiff(d2,  d1) <= 0){
                    frequency.attr(
                        'value', days() + ' days'
                    );
                }
                else if(monthDiff(d2,  d1)  == 1){
                    frequency.attr(
                        'value', monthDiff(d2,  d1) + ' month'
                    );
                }
                else {
                    frequency.attr(
                        'value', monthDiff(d2,  d1) + ' months'
                    );
                }

                var expiryDate = d1;
                $('#expiry-date').attr(
                    'value', (expiryDate.getMonth() + 1) +'/' + expiryDate.getDate() + '/' + (expiryDate.getFullYear() + 1)
                );
            }
        });
        function monthDiff(d1, d2) {
            var months;
            months = (d2.getFullYear() - d1.getFullYear()) * 12;
            months -= d1.getMonth() + 1;
            months += d2.getMonth();
            return months + 1;
        }
        function days() {
            var a = new Date(),
                b = $("#date_inspection").datepicker('getDate').getTime(),
                c = 24*60*60*1000,
                diffDays = Math.round(Math.abs((a - b)/(c)));

                return diffDays;

        }
        <?php if($this->session->flashdata('successfulRegistration')) {
        ?>
            $('#modal_reg').bPopup({
                zIndex: 1000,
                modalClose: true,
                modalColor: 'rgba(0, 0, 0, 0.5)',
                onOpen: function(e){ //when open,fire this event.
                    $('.accept').click(function(e){

                    });
                }
            });
        <?php
        }?>
    });
</script>

<div class="grid_16">
	<?php
	if(isset($_registration_page)){
	switch($_registration_page){
	case "client":
		?>
		<div id="tabsOut" style="margin-top: 20px; font: 14px 'Segoe UI',Helvetica,Arial,sans-serif;">
			<ul>
				<li><a href="#tabs-1">Client</a></li>
			</ul>
			<div class="block" id="forms">
				<?php echo form_open(''); ?>
				<div id="tabs-1"><?php echo $this->load->view('registration/registration_client_view');?></div>

				<div class="sixteen_column section">
					<div class="thirteen column">
						<div class="column_content">
							<div class="ui-widget">
								<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
									<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
										<strong>Alert:</strong> The input fields are not yet validated due to some test purposes.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="three column">
						<div class="column_content">
							<input type="submit" value="Save" id="clientSubmit" class="m-btn green submit" name="clientSubmit" />
						</div>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
		<?php
		break;
	case "equipment":
	?>
	<div id="tabsOut" style="margin-top: 20px; font: 14px 'Segoe UI',Helvetica,Arial,sans-serif;">
		<ul>
			<li><a href="#tabs-1">Equipment</a></li>
		</ul>
		<div class="block" id="forms">
			<?php echo form_open(''); ?>
			<?php
			$data = '';
			if(isset($_equipData)){
				$data = $_equipData;
			}
			?>
			<div id="tabs-1"><?php echo $this->load->view('registration/registration_equipment_view', $data);?></div>

			<div class="sixteen_column section">
				<div class="thirteen column">
					<div class="column_content">
						<div class="ui-widget">
							<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
								<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
								<div class="errorTag">
									<strong>Alert:</strong> The input fields are not yet validated due to some test purposes.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="three column">
				<div class="column_content">
					<input type="submit" value="Save" class="m-btn green submit" id="equipSave" name="submit" />
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<?php
break;

case "accounting":

	?>
	<div id="tabsOut" style="margin-top: 20px; font: 14px 'Segoe UI',Helvetica,Arial,sans-serif;">
		<ul>
			<li><a href="#tabs-1">Accounting</a></li>
		</ul>
		<div class="block" id="forms">
			<?php echo form_open(''); ?>
			<div id="tabs-1"><?php echo $this->load->view('registration/registration_accounting_view');?></div>
			<div class="sixteen_column section">
				<div class="thirteen column">
					<div class="column_content">
						<div class="ui-widget">
							<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
								<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
									<strong>Alert:</strong> The input fields are not yet validated due to some test purposes.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="three column">
					<div class="column_content">
						<input type="submit" value="Save" class="m-btn green submit" id="accountingSubmit" name="accountingSubmit" />
					</div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	<?php
	break;
	}
}
?>
</div>




<!--popup window-->
<div id="modal_reg" class="reg-modal">
	<div id="heading">
		Successful Registration
	</div>
	<div id="modal_content">
		<p style="text-align: center; padding: 20px">You have successfully registered a client.</p>

	</div>
</div>


<!--popup window style-->
<style>

    #modal_reg {
        display:none;
        width:600px;
        padding:8px;

        background:rgba(0,0,0,.3);
        z-index:101;
    }

    #modal_reg #heading {
        width:600px;
        height:44px;

        background-color: coral;
        border-bottom:1px solid #bababa;

        -webkit-box-shadow:
            inset 0px -1px 0px #fff,
            0px 1px 3px rgba(0,0,0,.08);
        -moz-box-shadow:
            inset 0px -1px 0px #fff,
            0px 1px 3px rgba(0,0,0,.08);
        box-shadow:
            inset 0px -1px 0px #fff,
            0px 1px 3px rgba(0,0,0,.08);

        font-size:18px;
        text-align:center;
        line-height:44px;
        color:#ffffff;

    }

    #modal_reg #modal_content {
        width:600px;
        background:#fcfcfc;

        -webkit-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        -moz-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        box-shadow:0px 1px 3px rgba(0,0,0,.25);
    }


    #modal_reg #modal_content p {
        font-size:14px;
        font-weight:normal;
        line-height:22px;
        color:#555555;
        width:100%;
        margin:0;
    }
	.disableButton{
		pointer-events: none !important;
		cursor: default;
		background:Gray!important;
	}
</style>
