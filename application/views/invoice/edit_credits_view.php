<?php
echo form_open('');
?>
<table class="edit-credits">
    <tr>
        <td>Credits Amount:</td>
        <td>
            <input type="text" name="credits" class="required" value="<?php echo $credits_value;?>">
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right;">
            <input type="submit" name="submit"  value="Update" class="m-btn green">
            <input type="button" name="cancel" value="Cancel" class="m-btn green cancelBtn">
        </td>
    </tr>
</table>
<?php
echo form_close();
?>
<style>
    .edit-credits{
        width: 300px;
    }
    .edit-credits tr td{
        padding: 5px;
    }
    .m-btn{
        width: 30%;
    }
</style>
<script>
    $(function(e){
        $('.cancelBtn').click(function(e){
           $(this).newForm.forceClose();
        });
    });
</script>