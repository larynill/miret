<script src="<?php echo base_url(); ?>plugins/js/number.js"></script>
<script>
    $(function(e){
        var addBtn = $('.addBtn');
        var cancelBtn = $('.cancelBtn');

        addBtn.click(function(e){
            var hasEmpty = false;

            $('.required').each(function(e){
                $(this).css({
                    border: '1px solid #CCC',
                    padding: '5px 8px'
                });

                if(!$(this).val()){
                    hasEmpty = true;
                    $(this).css({
                        border: '1px solid #F00',
                        padding: '5px 8px'
                    });
                }
            });

            if(hasEmpty){
                e.preventDefault();
            }
        });

        cancelBtn.click(function(e){
            $(this).newForm.forceClose();
        });

        $('.isMoney').numberOnly();
    });
</script>
<style>
    .frequencyTable{
        border-collapse: collapse;
        font-size: 12px;
    }
    .frequencyTable tr td{
        text-align: left;
		padding: 5px;
    }
    .frequencyTable tr td:first-child{
        text-align: right;
        font-weight: bold;
    }

    input[type=text], textarea, select{
        width: 200px;
    }
</style>

<?php
echo form_open('');
    ?>
    <table class="frequencyTable">
        <tr>
            <td>Frequency:</td>
            <td>
                <input type="text" name="frequency" class="required" />
            </td>
        </tr>
		<tr>
			<td>Earning Interval:</td>
			<td>
				<input type="text" name="earning_interval" class="required isMoney" />
			</td>
		</tr>
		<tr>
			<td>Earning Limit:</td>
			<td>
				<input type="text" name="earning_limit" class="required isMoney" />
			</td>
		</tr>
        <tr>
            <td colspan="2" style="white-space: nowrap!important;">
                <div class="col-sm-4">
                    <input type="submit" value="Add" name="submit" class="addBtn btn btn-sm btn-primary" />
                    <input type="button" value="Cancel" name="cancel" class="cancelBtn btn btn-sm btn-default" />
                </div>
            </td>
        </tr>
    </table>
    <?php
echo form_close();