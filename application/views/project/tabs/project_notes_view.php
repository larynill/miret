<?php
$_id = 0;
if(count(@$notes) > 0) {
    foreach (@$notes as $val) {
        $_id = $val->id + 1;
    }
}
?>
<form class="form-horizontal">
    <div class="container-fluid">
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
                        <textarea class="form-control input-sm" name="history[<?php echo $_id;?>]" rows="5"></textarea>
                    </div>
                </div>
                <?php
                if(count(@$notes) > 0){
                    foreach(@$notes as $val){
                        $_id++;
                        ?>
                        <div class="div-content">
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    Date: <?php echo date('d-m-Y h:i:s A',strtotime($val->date_time))?>
                                    <input type="hidden" name="history_date[<?php echo $val->id;?>]" value="<?php echo date('Y-m-d H:i:s',strtotime($val->date_time))?>">
                                    <a href="#" id="<?php echo $val->id;?>" class="delete-history"><i class="glyphicon glyphicon-trash"></i></a>
                                </label>
                                <textarea class="form-control input-sm" name="history[<?php echo $val->id;?>]" readonly rows="5" ><?php echo $val->history?></textarea>
                            </div>
                        </div>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <button type="button" class="btn btn-sm btn-primary add-history pull-left" disabled><i class="glyphicon glyphicon-plus"></i> Add Note</button>
                </div>
            </div>
        </div><br/>
    </div>
</form>
<script>
    $(function(){
        var last_id = <?php echo $_id;?>;
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
                    '<textarea class="form-control input-sm" name="history[' + (last_id ? last_id + n : '') + ']" rows="5"></textarea>' +
                '</div>';
            $('<div class="df-history-form added-form">' + element + '</div>').prependTo('.added-history');
            //$('.added-history').append($('<div class="df-history-form added-form">' + element + '</div>'))
        });

        var data_value = $('.form-horizontal').serializeArray();

        $( ".form-control,textarea" ).on({
            focusout: function() {
                display_update_btn();
            }, change: function() {
                display_update_btn();
            }
        });

        var display_update_btn = function(){
            var new_data_value = $('.form-horizontal').serializeArray();
            var update_btn = $('.add-history');
            update_btn.attr('disabled','disabled');
            $.each(new_data_value,function(key,val){
                $.each(data_value,function(k,v){
                    if((val.name == v.name && val.value != v.value)){
                        update_btn.removeAttr('disabled');
                    }
                });
            });
        };

    });
</script>