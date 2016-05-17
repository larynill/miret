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
    });
</script>
<style>
    .addWageTable{
        border-collapse: collapse;
        font-size: 12px;
    }
    .addWageTable>tbody>tr>td{
        text-align: left;
		padding: 5px;
    }
    .addWageTable>tbody>tr>td:first-child{
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
    <table class="addWageTable">
        <tr>
            <td>Description:</td>
            <td>
                <input type="text" name="description" class="required" />
            </td>
        </tr>
        <tr style="vertical-align: top;">
            <td>Details:</td>
            <td>
                <textarea name="details" class="required" style="height: 80px;resize: none;"></textarea>
            </td>
        </tr>
        <tr>
            <td>Frequency:</td>
            <td>
                <?php
                echo form_dropdown('frequency', $salary_feq, '', 'class="required"');
                ?>
            </td>
        </tr>
        <tr>
            <td>Type:</td>
            <td>
                <?php
                echo form_dropdown('type', $salary_type, '', 'class="required"');
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;">
                <input type="submit" value="Add" name="submit" class="addBtn pure_black" />
                <input type="button" value="Cancel" name="cancel" class="cancelBtn pure_black" />
            </td>
        </tr>
    </table>
    <?php
echo form_close();