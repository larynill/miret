<table class="add-email">
    <tr style="vertical-align: top">
        <td>Email:</td>
        <td>
            <input type="text" name="email" class="email" style="padding: 5px;">
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right;">
            <input type="submit" name="send" value="Send" class="m-btn green send-btn">
            <input type="submit" name="cancel" value="Cancel" class="m-btn green cancel-btn">
        </td>
    </tr>
</table>
<style>
    .send-btn,.cancel-btn{
        width: 30%;
    }
    .add-email{
        width: 300px;
    }
    .add-email tr td{
        padding: 5px;
    }
    .email{
        width: 100%;
        font-size: 12px;
    }
</style>
<script>
    $(function(e){
        var emailTextBox = $('.email');
        $('.cancel-btn').click(function(e){
            e.preventDefault();
            $(this).newForm.forceClose();
        });
        $('.send-btn').click(function(e){
            var isEmpty = false;
            if(!emailTextBox.val()){
                isEmpty = true;
                emailTextBox.css({
                   border: '1px solid #ff0000'
                });
            }
            if(isEmpty){
                e.preventDefault();
            }else{
                window.location.href = "<?php echo base_url()?>registration_request?mail=" + emailTextBox.val();
            }
        });
        //emailTextBox.checkingMail();
    });
</script>