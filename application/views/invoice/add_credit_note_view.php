<style>
    .credit-note{
        width: 250px;
    }
    .credit-note table tr td{
        padding: 5px;
    }
    .credit-note table tr td:first-child{
        width: 30%;
    }
</style>
<?php
echo form_open('addCreditNote?cID='.$_GET['cID']);
?>
<div class="credit-note">
    <table>
        <tr>
            <td>Job No.</td>
            <td>
                <?php
                echo form_dropdown('job_id',$trackID,'','class="required"');
                ?>
            </td>
        </tr>
        <tr>
            <td>Units:</td>
            <td>
                <input type="text" name="units" class="required">
            </td>
        </tr>
        <tr>
            <td>Hours:</td>
            <td>
                <input type="text" name="hours" class="required">
            </td>
        </tr>
        <tr>
            <td>Km:</td>
            <td>
                <input type="text" name="km" class="required">
            </td>
        </tr>
        <tr>
            <td>Extra:</td>
            <td>
                <input type="text" name="extra" class="required">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;">
                <input type="submit" name="submit" value="Add" class="m-btn green addBtn" style="width: 25%;">
                <input type="submit" name="cancel" value="Cancel" class="m-btn green cancelBtn" style="width: 30%;">
            </td>
        </tr>
    </table>
</div>
<?php
echo form_close();
?>
<script>
    $(function(e){
        var addBtn = $('.addBtn');
        var cancelBtn = $('.cancelBtn');
        $('.required').numberOnly();
        addBtn.click(function(e){
            var isEmpty = false;
            $('.required').each(function(e){
                if(!$(this).val()){
                    isEmpty = true;
                    $(this).css({
                        border: '1px solid #ff0000'
                    });

                }
            });
            if(isEmpty == true){
                e.preventDefault();
            }
        });
        cancelBtn.click(function(e){
           $(this).newForm.forceClose();
        });
    });
</script>