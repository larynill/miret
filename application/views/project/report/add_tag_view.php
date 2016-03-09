<div class="modal-body">
    <div class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-sm-2" for="tag">Tags:</label>
            <div class="col-sm-10">
                <?php echo form_dropdown('tag',$tags,'','class="form-control input-sm tag-dp" id="tag"')?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="text">Text:</label>
            <div class="col-sm-10">
                <textarea id="text" class="form-control input-sm" rows="15"></textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-sm btn-primary submit-tag" data-dismiss="modal">Add Tag</button>
    <button class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
</div>
<script>
    $(function(){
        var area_val = '<?php echo $this->uri->segment(2);?>';
        $('#tag').change(function(e){
            e.preventDefault();
            $('#text')
                .val($(this).val())
                .focus();
        });
        $('.submit-tag').click(function(){
            var text_area = $('textarea[name="notes[' + area_val + ']"]');
            var tags = $('#text');
            var value = text_area.val() + (text_area.val() ? "\n" : "") + tags.val();
            text_area
                .val(value);
            $('body').find('textarea[name="notes[' + area_val + ']"]').focus();
            $('body,html').animate({
                scrollTop: text_area.offset().top - 200
            }, 2000);
        })
    });
</script>