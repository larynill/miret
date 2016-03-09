<?php
echo form_open('','class="form"');
$_id = 0;
if(count($notes) > 0) {
    foreach ($notes as $val) {
        $_id = $val->id + 1;
    }
}

?>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="div-content added-history"></div>
            <div class="div-content">
                <div class="form-group">
                    <label for="exampleInputEmail1">
                        Date: <?php echo date('d-m-Y h:i:s A')?>
                        <input type="hidden" name="history_date[<?php echo $_id;?>]" value="<?php echo date('Y-m-d H:i:s')?>">
                        <a href="#" id="<?php echo $_id;?>" class="delete-history"><i class="glyphicon glyphicon-trash"></i></a>
                    </label>
                    <textarea class="form-control input-sm" name="history[<?php echo $_id;?>]" ></textarea>
                </div>
            </div>
            <?php
            if(count($notes) > 0){
                foreach($notes as $val){
                    $_id++;
                    ?>
                    <div class="div-content">
                        <div class="form-group">
                            <label for="exampleInputEmail1">
                                Date: <?php echo date('d-m-Y h:i:s A',strtotime($val->date_time))?>
                                <input type="hidden" name="history_date[<?php echo $val->id;?>]" value="<?php echo date('Y-m-d H:i:s',strtotime($val->date_time))?>">
                                <a href="#" id="<?php echo $val->id;?>" class="delete-history"><i class="glyphicon glyphicon-trash"></i></a>
                            </label>
                            <textarea class="form-control input-sm" name="history[<?php echo $val->id;?>]" readonly ><?php echo $val->history?></textarea>
                        </div>
                    </div>
                <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-primary add-history pull-left" disabled><i class="glyphicon glyphicon-plus"></i> Add Note</button>
    <button type="button" name="submit" class="btn btn-sm btn-success show-job-form" style="margin: auto 130px!important;">Show Job Form</button>
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
    <input type="hidden" name="update" value="1">
    <button type="submit" name="submit" class="btn btn-primary btn-sm update-btn" style="display: none;">Submit</button>
</div>
<?php
echo form_close();
?>
<script>
    $(function(){
        var last_id = <?php echo $_id;?>;
        var job_id = <?php echo $this->uri->segment(2);?>;
        var _page_url = $('.form').attr('action');
        $('.form-control')
            .click(function(){
                $(this).removeAttr('readonly');
                $('.update-btn').removeAttr('disabled');
            });

        $('.div-content')
            .on('click','.delete-history',function(e){
                if(this.id){
                    $.post(bu + 'jobRegistration?type=del&h_id=' + this.id,{submit:1},function(data){});
                    $(this).parent().parent().parent().remove();
                }
                else{
                    $(this).parent().parent().parent().remove();
                }
        });

        $('.add-history').click(function(e){
            var date = $.now();
            var time = $.format.date(date,'dd-MM-yyyy hh:mm:ss a');
            var time_ = $.format.date(date,'yyyy-MM-dd HH:mm:ss');
            var n = $('.added-form').length;
            var element =
                '<div class="form-group">' +
                    '<label for="exampleInputEmail1">' +
                        'Date:' + time +
                        '<input type="hidden" name="history_date[' + (last_id ? last_id + n : '') + ']" value="' + time_ + '">' +
                        '<a href="#" class="delete-history"><i class="glyphicon glyphicon-trash"></i></a>' +
                    '</label>' +
                    '<textarea class="form-control input-sm" name="history[' + (last_id ? last_id + n : '') + ']"></textarea>' +
                '</div>';
            $('<div class="df-history-form added-form">' + element + '</div>').prependTo('.added-history');
            //$('.added-history').append($('<div class="df-history-form added-form">' + element + '</div>'))
        });

        var data_value = [];
        $( ".form-control,textarea" ).on({
            click: function(){
                data_value = $('.form').serializeArray();
            },
            focusout: function() {
                display_update_btn(data_value);
            }
        });

        var display_update_btn = function(data){
            var new_data_value = $('.form').serializeArray();
            var update_btn = $('.add-history');
            update_btn.attr('disabled','disabled');
            $.each(new_data_value,function(key,val){
                $.each(data,function(k,v){
                    if((val.name == v.name && val.value != v.value)){
                        update_btn.removeAttr('disabled');
                    }
                });
            });
        };

        var has_changes = function(data){
            var new_data_value = $('.form').serializeArray();
            var _return = false;
            $.each(new_data_value,function(key,val){
                $.each(data,function(k,v){
                    if((val.name == v.name && val.value != v.value)){
                        _return = true;
                    }
                });
            });

            return _return;
        };

        $('.close').click(function(){
            if(has_changes(data_value)){
                $(this).removeAttr('data-dismiss');

                var ele =
                    'Save this <strong>Note</strong> before closing?<br/>';

                $(this).newForm.formDeleteQuery({
                    title: 'Saving Note',
                    msg: ele
                });

                $('body')
                    .on('click','.yesBtn',function(){
                        $(this).newForm.forceClose();
                        $('.form').attr('action',_page_url);
                        $('.update-btn').trigger('click');
                    })
                    .on('click','.noBtn',function(){
                        $(this).newForm.forceClose();
                    });
            }
        });

        $('.show-job-form').click(function(){
            if(has_changes(data_value)){
                $(this).removeAttr('data-dismiss');

                var ele =
                    'Save this <strong>Note</strong> before opening <strong>Job Form</strong>?<br/>';

                $(this).newForm.formDeleteQuery({
                    title: 'Saving Note',
                    msg: ele
                });

                $('body')
                    .on('click','.yesBtn',function(){
                        $(this).newForm.forceClose();
                        $('.form').attr('action',_page_url + '?s_form=1');
                        $('.update-btn').trigger('click');
                    })
                    .on('click','.noBtn',function(){
                        window.open(bu + 'jobRegistration?id=' + job_id,'_self');
                    });
            }
            else{
                window.open(bu + 'jobRegistration?id=' + job_id,'_self');
            }
        });
    });
</script>