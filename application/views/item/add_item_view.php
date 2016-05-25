<?php
echo form_open('','class="form-horizontal"');
?>
<div class="modal-body">
    <div class="form-group">
        <label class="control-label col-sm-2" for="item_code">Item Code</label>
        <div class="col-sm-3">
            <input type="text" class="form-control input-sm" name="item_code" id="item_code" value="<?php echo @$items->item_code?>">
        </div>
        <label class="control-label col-sm-1" for="unit">Unit</label>
        <div class="col-sm-2">
            <?php echo form_dropdown('unit_id',$unit_type,@$items->unit_id,'class="form-control input-sm" id="unit"');?>
        </div>
        <label class="control-label col-sm-1" for="default_rate">Rate</label>
        <div class="col-sm-3">
            <input type="text" class="form-control input-sm" name="default_rate" id="default_rate" value="<?php echo @$items->default_rate?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="item_name">Item Name</label>
        <div class="col-sm-8">
            <input type="text" class="form-control input-sm" name="item_name" id="item_name" value="<?php echo @$items->item_name?>">
        </div>
        <div class="col-sm-2" style="padding: 0;">
            <label class="checkbox-inline" style="padding-left: 0!important;">Auto-Item?&nbsp;<input type="checkbox" name="auto_item" value="1" style="margin: 0;" <?php echo @$items->auto_item ? 'checked' : ''?>></label>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="report_text">Report Text</label>
        <div class="col-sm-10">
            <textarea class="form-control input-sm" name="report_text" id="report_text"><?php echo @$items->report_text?></textarea>
        </div>
    </div>
    <div class="tags-content">
        <div class="form-group">
            <label class="control-label col-sm-2" for="tags">Tags</label>
            <div class="col-sm-10">
                <a href="#" class="add-tag"><i class="glyphicon glyphicon-plus-sign"></i> Add Tag</a>
                <textarea class="form-control input-sm" name="tags" id="tags"><?php echo @$items->tags?></textarea>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="additional-tag-content"></div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Cancel</button>
    <button class="btn btn-sm btn-primary" type="submit" name="submit">Submit</button>
</div>
<?php
echo form_close();
?>
<script>
    $(function(){
        $('.add-tag').click(function(e){
            $('.additional-tag-content').load(bu + 'manageItem?tag=1');
            $(this).css({'pointer-events':'none','color':'grey'});
        });
        $('.additional-tag-content')
            .on('click','.submit-tag',function(){
                var text_area = $('textarea[name="tags"]');
                var tags = $('#text');
                var value = text_area.val() + (text_area.val() ? "\n" : "") + tags.val();
                text_area
                    .val(value);
                $('body').find('textarea[name="tags"]').focus();
                $('.add-tag').removeAttr('style');
                $('.additional-tag-content').html('');
            })
            .on('click','.close-tag',function(){
                $('.add-tag').removeAttr('style');
                $('.additional-tag-content').html('');
            });
    })
</script>