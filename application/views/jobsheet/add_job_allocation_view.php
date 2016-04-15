<?php
echo form_open('','class="form-horizontal" id="form"');
?>
<div class="modal-body">
    <?php
    $inspection_time = ValidateDate($assignment->inspection_time,'Y-m-d H:i:s') ? date('d/m/Y',strtotime($assignment->inspection_time)) : '';
    if(count($current_inspector) > 0){
        ?>
        <div class="form-group">
            <label class="control-label col-sm-4">Current Inspector:</label>
            <div class="col-sm-8">
                <?php echo form_dropdown('current_inspector',$current_inspector,$assignment->inspector_id,'class="form-control input-sm" multiple="multiple"')?>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="form-group">
        <label class="control-label col-sm-4">Inspector:</label>
        <div class="col-sm-8">
            <?php echo form_dropdown('inspector_id',$inspector,'','class="form-control input-sm"')?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-4" for="inspection_time">Requested Inspection Time:</label>
        <div class="col-sm-8">
            <div class='input-group date datetimepicker' id='inspection_time'>
                <input type='text' class="input-sm form-control date-class" id="inspection_time" name="inspection_time" readonly>
                <span class="input-group-addon open-date-calendar">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-sm btn-primary submit-btn" name="submit" data-value="<?php echo $current;?>">Submit</button>
    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
</div>
<?php
echo form_close();
?>
<script>
    $(function(e){
        var has_current = <?php echo count($current_inspector) > 0 ? true : false;?>;
        $('.datetimepicker').datetimepicker({
            format: "DD/MM/YYYY HH:mm A",
            useCurrent: false,
            maxDate: "<?php echo $inspection_time; ?>"
        });
        $('.submit-btn').click(function(e){
            e.preventDefault();
            var form_horizontal = $('#form');
            var url = form_horizontal.attr('action');
            var data = form_horizontal.serializeArray();
            data.push({name:'submit',value:1});

            if(has_current){
                var ele =
                    '<div class="modal-body">' +
                        '<div class="row">' +
                            '<div class="col-sm-12">' +
                            'This Job is already assigned to <strong>' + $(this).data('value') + '</strong>. ' +
                            'Please confirm you wish to transfer this Job To <strong>' + $('select[name="inspector_id"]').find('option:selected').text() + '</strong>. ' +
                            'Once transferred this job will no longer show on <strong>' + $(this).data('value') + '</strong> Job Queue.' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-success btn-sm yes-btn" data-dismiss="modal">Yes</button>' +
                        '<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>' +
                    '</div>';
                $(this).modifiedModal({
                    html:ele,
                    title: 'Incomplete Leave Request'
                });
            }

            $('.yes-btn').click(function(){
                $.post(url,data,function(e){
                    $('.modal').hide();
                   location.reload();
                });
            });
        });
    });
</script>