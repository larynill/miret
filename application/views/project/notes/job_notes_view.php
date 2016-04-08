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
            <div class="notes-container">
                <div class="div-content added-history"></div>
                <?php
                if(count($notes) > 0){
                    foreach($notes as $val){
                        $_id++;
                        ?>
                        <div class="div-content">
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    Date: <?php echo date('d-m-Y h:i A',strtotime($val->date_time))?>
                                    <input type="hidden" name="history_date[<?php echo $val->id;?>]" value="<?php echo date('Y-m-d H:i:s',strtotime($val->date_time))?>">
                                    <span class="author">[<?php echo $val->author_name;?>]</span>
                                    <!--<a href="#" id="<?php /*echo $val->id;*/?>" class="delete-history"><i class="glyphicon glyphicon-trash"></i></a>-->
                                </label>
                                <textarea class="form-control input-sm" name="history[<?php echo $val->id;?>]" rows="5"><?php echo $val->history?></textarea>
                            </div>
                        </div>
                    <?php
                    }
                }
                else{
                    ?>
                    <div class="div-content">
                        <div class="form-group">
                            <label for="exampleInputEmail1">
                                Date: <?php echo date('d-m-Y h:i A')?>
                                <input type="hidden" name="history_date[<?php echo $_id;?>]" value="<?php echo date('Y-m-d H:i:s')?>">
                                <span class="author">[<?php echo $accountName;?>]</span>
                                <!--<a href="#" id="<?php /*echo $_id;*/?>" class="delete-history"><i class="glyphicon glyphicon-trash"></i></a>-->
                            </label>
                            <textarea class="form-control input-sm" name="history[<?php echo $_id;?>]" rows="5"></textarea>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-primary add-history pull-left notes-btn" <?php echo count($notes) > 0 ? '' : 'disabled'?> ><i class="glyphicon glyphicon-plus"></i> Add Note</button>
    <button type="button" name="submit" class="btn btn-sm btn-success show-job-form" style="margin: auto 130px!important;">Show Job Form</button>
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
    <input type="hidden" name="update" value="1">
    <button type="submit" name="submit" class="btn btn-primary btn-sm update-btn" style="display: none;">Submit</button>
</div>
<?php
echo form_close();
?>
<style>
    .notes-container{
        max-height: 300px;
        overflow-x: auto;
    }
    .notes-container .div-content{
        margin: 0 auto;
    }
    .author{
        color: #3692e1;
    }
</style>
<script>
    $(function(){
        var last_id = <?php echo $_id;?>;
        var df_author = '<span class="author">[<?php echo $accountName;?>]</span>';
        var job_id = <?php echo $this->uri->segment(2);?>;
        var form = $('.form');
        var _page_url = form.attr('action');
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

        $('.notes-btn').click(function(e){
            if($(this).hasClass('add-history')){
                $(this)
                    .removeAttr('disabled')
                    .removeClass('btn-primary add-history')
                    .addClass('btn-success save-notes')
                    .html('<i class="glyphicon glyphicon-ok"></i> Save New Note');
                var date = $.now();
                var time = $.format.date(date,'dd-MM-yyyy hh:mm a');
                var time_ = $.format.date(date,'yyyy-MM-dd HH:mm');
                var n = $('.added-form').length;
                var element =
                    '<div class="form-group">' +
                    '<label for="exampleInputEmail1">' +
                    'Date:' + time +
                    '<input type="hidden" name="history_date[' + (last_id ? last_id + n : '') + ']" value="' + time_ + '"> ' +
                    df_author +
                        /*'<a href="#" class="delete-history"><i class="glyphicon glyphicon-trash"></i></a>' +*/
                    '</label>' +
                    '<textarea class="form-control input-sm" name="history[' + (last_id ? last_id + n : '') + ']" rows="5"></textarea>' +
                    '</div>';
                $('<div class="df-history-form added-form">' + element + '</div>').prependTo('.added-history');
                var _id = last_id ? last_id + n : 0;
                $('textarea[name="history[' + _id + ']"]').focus();
                //$('.added-history').append($('<div class="df-history-form added-form">' + element + '</div>'))
            }
            else if($(this).hasClass('save-notes')){
                var form = $('.form');
                form.attr('action',_page_url);
                var data = form.serializeArray();
                data.push({name:'submit',value:1});

                $(this)
                    .removeAttr('disabled')
                    .removeClass('btn-success save-notes')
                    .addClass('btn-primary add-history')
                    .html('<i class="glyphicon glyphicon-plus"></i> Add Note');

                $.post(_page_url,data,function(data){});
            }
            else{

            }
        });

        var data_value = form.serializeArray();
        $( "body" ).on({
            click: function(){
                data_value = $('.form').serializeArray();
            },
            focusout: function() {
                var char_len = $(this).val().length;
                var template =
                    '<div class="popover" role="tooltip" style="width: 700px">' +
                        '<div class="arrow"></div>' +
                        '<div class="popover-content" style="font-size: 12px!important;"></div>' +
                    '</div>';
                if($(this).val() && char_len < 10){
                    $(this)
                        .popover({
                            template: template,
                            placement: 'right',
                            content: 'Should be minimum 10 of characters.'
                        })
                        .popover('show')
                        .css({
                            'border': '1px solid #ff0000'
                        });
                }
                else{
                    $(this)
                        .popover('hide')
                        .removeAttr('style');

                }
            },
            focusin: function(){
                $(this).popover('hide');
            },
            keyup: function(){
                var char_len = $(this).val().length;
                var notes_btn = $('.notes-btn');
                if(parseInt(char_len) >= 10){
                    display_update_btn(data_value);
                }
            }
        },'.form-control,textarea');

        var display_update_btn = function(data){
            var new_data_value = $('.form').serializeArray();
            var notes_btn = $('.notes-btn');
            //notes_btn.attr('disabled','disabled');
            $.each(new_data_value,function(key,val){
                $.each(data,function(k,v){
                    if(((val.name == v.name) && (val.value != v.value))){
                        //notes_btn.removeAttr('disabled');
                        notes_btn
                            .removeAttr('disabled')
                            .removeClass('btn-primary add-history')
                            .addClass('btn-success save-notes')
                            .html('<i class="glyphicon glyphicon-ok"></i> Save New Note');
                    }
                });
            });
        };

        var has_changes = function(data){
            var new_data_value = $('.form').serializeArray();
            var _n = $('.added-form').length;
            var _id = last_id ? last_id + _n : 0;
            var new_text_area = $('textarea[name="history[' + _id + ']"]');

            var _return = false;
            var i = new_data_value.length;
            var n = data.length;
            $.each(new_data_value,function(key,val){
                $.each(data,function(k,v){
                    if((val.name == v.name && val.value != v.value)){
                        _return = true;
                    }
                });
            });
            if(i != n && new_text_area.val()){
                _return = true;
            }

            return _return;
        };

        $('.close').click(function(){
            if(has_changes(data_value) === true){
                $(this).removeAttr('data-dismiss');

                var ele =
                    'Do you want to exit and lose the newly typed notes?<br/>';

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
            if(has_changes(data_value) === true){
                $(this).removeAttr('data-dismiss');

                var ele =
                    'Do you want to save this <strong>Note</strong> before opening <strong>Job Form</strong>?<br/>';

                $(this).newForm.formDeleteQuery({
                    title: 'Saving Note',
                    msg: ele
                });

                $('body')
                    .on('click','.yesBtn',function(){
                        $(this).newForm.forceClose();
                        $('.form').attr('action',_page_url + '?is_form=1');
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