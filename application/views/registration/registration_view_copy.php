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

        var submit = $("#submit");
        submit.click(function(e){
            var isEmpty = false;
            $('.required').each(function(e){

                $(this).css({
                    border: '1px solid #CCC'
                });

                if(!$(this).val()){
                    $(this).css({
                        border: '1px solid #FF624C'
                    });

                    hasEmpty = true;
                    emptyTitle = 'Empty <strong>' + $(this).attr('title') + '</strong> Field!';
                }

                isEmpty = true;
            });

            if(isEmpty){
               // e.preventDefault();
            }
        });

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

        

    });
</script>

<div class="grid_16">
    <div id="tabsOut" style="margin-top: 20px">
        <ul>
            <li><a href="#tabs-1">Client</a></li>
            <li><a href="#tabs-2">Equipment</a></li>
            <li><a href="#tabs-3">Accounting</a></li>
        </ul>

        <div class="block" id="forms">
            <?php echo form_open(''); ?>
        <div id="tabs-1"><?php echo $this->load->view('registration/registration_client_view');?></div>
        <div id="tabs-2"><?php echo $this->load->view('registration/registration_equipment_view');?></div>
        <div id="tabs-3"><?php echo $this->load->view('registration/registration_accounting_view');?></div>
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
                    <input type="submit" value="Save" id="submit" name="submit" />
                </div>
            </div>
        </div>
            <?php echo form_close(); ?>
        </div>
    </div>

</div>
