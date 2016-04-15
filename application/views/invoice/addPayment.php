<style>
    .payment{
        width: 250px;
    }
    .payment table{
        border-collapse: collapse;
    }
    .payment table tr td{
        padding: 5px;
    }
</style>
<?php
echo form_open('addPayment?cID='.$_GET['cID']);
?>
<div class="payment">
    <table>
        <tr>
            <td>Date</td>
            <td>
                <span class="date-class"><?php echo date('j F Y')?></span>
                <input type="hidden" name="date" class="date-picker" value="<?php echo date('j F Y')?>">
            </td>
        </tr>
        <tr>
            <td>Invoice Ref.</td>
            <td>
                <?php echo form_dropdown('invoice_ref',$unpayed_invoice,'','class="required"')?>
            </td>
        </tr>
        <tr>
            <td>Amount</td>
            <td>
                <input type="text" name="amount" class="amount required">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right">
                <input type="submit" name="submit" value="Pay" class="m-btn green payBtn" style="width: 30%;">
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
        var datepicker = $('.date-picker');
        var date_class = $('.date-class');
        var cancel = $('.cancelBtn');
        var payBtn = $('.payBtn');
        datepicker.datepicker({
            showOn:'button',
            buttonImage:"plugins/img/calendar-add.png",
            buttonImageOnly:true,
            dateFormat: "d MM yy",
            onSelect: function(){
                date_class.html($(this).val());
            }
        });
        cancel.click(function(e){
           $(this).newForm.forceClose();
        });
        $('.amount').numberOnly();
        payBtn.click(function(e){
            var isEmpty = false;
            //var emptyTitle = '';
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
    });
</script>