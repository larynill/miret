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
    .dpTable{
        border-collapse: collapse;
        font-size: 12px;
    }
    .dpTable tr td{
        text-align: left;
		padding: 5px;
    }
    .dpTable tr td:first-child{
        text-align: right;
        font-weight: bold;
    }

    input[type=text], textarea, select{
        width: 200px;
    }
</style>

<?php
echo form_open('');
if(count($default_percentage)>0){
    foreach($default_percentage as $v){
        ?>
        <table class="dpTable">
            <tr>
                <td>Type:</td>
                <td>
                    <?php echo $v->type; ?>
                </td>
            </tr>
            <tr>
                <td>Percentage:</td>
                <td>
                    <input type="text" name="percentage" value="<?php echo $v->percentage; ?>" class="required isMoney" />
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;">
                    <input type="submit" value="Edit" name="submit" class="addBtn pure_black" />
                    <input type="button" value="Cancel" name="cancel" class="cancelBtn pure_black" />
                </td>
            </tr>
        </table>
        <?php
    }
}
echo form_close();