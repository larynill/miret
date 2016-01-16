<div class="add-equipment-div">
    <?php
     echo form_open('')
    ?>
        <div class="sixteen_column section">
            <div class="eight column">
                <div class="column_content">
                    <label>Plant Description: </label>
                    <input type="text"  id="PlantDescription" name="PlantDescription" class="required" title="Plant Description"/>
                </div>
            </div>
            <div class="eight column">
                <div class="column_content">
                    <label>Equipment Number: </label>
                    <input type="text"  name="EquipmentNumber" class="required number-input"/>
                </div>
            </div>
        </div>
        <div class="sixteen_column section">
            <div class="eight column">
                <div class="column_content">
                    <label>Certificate Number: </label>
                    <input type="text" id="" name="CertificateNumber" class="number-input"/>
                </div>
            </div>
            <div class="eight column">
                <div class="column_content">
                    <label>Type Of Equipment: </label>
                    <input type="text" class="" name="TypeEquipment" class="required"/>
                </div>
            </div>
        </div>
        <div class="sixteen_column section">
            <div class="eight column">
                <div class="column_content">
                    <label>Manufacturer: </label>
                    <input type="text" id="" name="Manufacturer" class=""/>
                </div>
            </div>
            <div class="eight column">
                <div class="column_content">
                    <label>Inspection Date: </label>
                    <input type="text" id="date_inspection" name="InspectionDate" class="required datepicker inspection" title="Inspection Date"/>
                </div>
            </div>
        </div>
        <div class="sixteen_column section">
            <div class="eight column">
                <div class="column_content">
                    <label>Expectation Date: </label>
                    <input type="text" class="datepicker required expiration" id="expiry-date" name="ExpectationDate" title="Expectation Date"/>
                </div>
            </div>
            <div class="eight column">
                <div class="column_content">
                    <label>Frequency Of Inspection:  </label>
                    <input type="text" class="frequency" id="date_frequency" name="" class=""/>
                </div>
            </div>
        </div>

        <div class="sixteen_column section">
            <div class="eight column">
                <div class="column_content">
                    <label>Last Report Number: </label>
                    <input type="text" id="firstName" name="LastReportNumber" class=""/>
                </div>
            </div>
            <div class="eight column">
                <div class="column_content">
                    <label>Has Equipment/IQP`s:  </label>
                    <input type="text" class="" name="IQP" class=""/>
                </div>
            </div>
        </div>
        <div class="sixteen_column section">
            <div class="eight column">
                <div class="column_content">
                    <label>Sold/Out Of Service: </label>
                    <input type="text" id="firstName" name="Sold" class=""/>
                </div>
            </div>
            <div class="eight column">
                <div class="column_content">
                    <label>SWL:  </label>
                    <input type="text" class="" name="SWL" class=""/>
                </div>
            </div>
        </div>
        <div class="sixteen_column section">
            <div class="sixteen column">
                <div class="column_content" style="text-align: right;">
                    <input type="submit" name="submit" value="Submit" class="m-btn green save_edit" id="addEquipSave" style="width: 20%">
                    <input type="button" name="cancel" value="Cancel" class="m-btn green cancelBtn" id="addEquipSave" style="width: 20%">
                </div>
            </div>
        </div>
    <?php
    echo form_close();
    ?>
</div>
<style>
    .add-equipment-div{
        width: 500px;
    }
    .column_content{
        text-align: left;
    }
    .column_content > label{
        font-weight: bold;
    }
</style>
<script>
    $(function(e){
        var inspect = $('.inspection');
        var frequency = $('.frequency');
        $('.cancelBtn').click(function(e){
            $(this).newForm.forceClose();
        });
        $('.datepicker').datepicker({
            dateFormat:'dd MM yy'
        });
        $('.number-input').numberOnly();
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
                $('.expiration').attr(
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
                b = inspect.datepicker('getDate').getTime(),
                c = 24*60*60*1000,
                diffDays = Math.round(Math.abs((a - b)/(c)));

            return diffDays;

        }
        $('.save_edit').click(function(e){
            var isEmpty = false;
            var hasEmpty = false;
            $('.required').each(function(e){
                $(this).css({
                    border: '1px solid #CCC'
                });
                if(!$(this).val()){
                    $(this).css({
                        border: '1px solid #FF624C'
                    });
                    hasEmpty = true;
                }
                isEmpty = true;
            });

            if(hasEmpty){
                e.preventDefault();
            }
        });
    });
</script>