<?php
echo form_open('');
?>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="div-content added-history"></div>
                <div class="form-group">
                    <a href="#" class="btn btn-sm btn-primary add-history"><i class="glyphicon glyphicon-plus"></i> Add Notes</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
    <input type="hidden" name="update" value="0">
    <button type="submit" name="submit" class="btn btn-primary btn-sm update-btn">Submit</button>
</div>
<?php
echo form_close();
?>

<script>
    $(function(){
        $('.add-history').click(function(e){
            var date = $.now();
            var time = $.format.date(date,'dd-MM-yyyy hh:mm:ss a');
            var n = $('.added-form').length;
            var element =
                '<div class="form-group">' +
                    '<label for="exampleInputEmail1">' +
                        'Date:' + time +
                        '<input type="hidden" name="history_date[]" value="' + time + '">' +
                        '<a href="#" class="delete-history"><i class="glyphicon glyphicon-trash"></i></a>' +
                    '</label>' +
                    '<textarea class="form-control input-sm" name="history[]"></textarea>' +
                '</div>';
            $('.added-history').prepend($('<div class="df-history-form added-form">' + element + '</div>'))
        });

        $('.div-content').on('click','.delete-history',function(e){
            if(this.id){
                $.post(bu + 'jobRegistration?type=del&h_id=' + this.id,{submit:1},function(data){});
                $(this).parent().parent().parent().remove();
            }
            else{
                $(this).parent().parent().parent().remove();
            }
        });
    });
</script>