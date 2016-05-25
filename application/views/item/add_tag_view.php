<div class="well well-sm">
    <fieldset>
        <legend style="font-size: 15px;margin-bottom: 0!important;font-weight: bold">Select Tags</legend>
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
                    <textarea id="text" class="form-control input-sm" rows="4"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="pull-right">
                        <button type="button" class="btn btn-sm btn-primary submit-tag">Add Tag</button>
                        <button type="button" class="btn btn-sm btn-default close-tag">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</div>

<script>
    $(function(){
        $('#tag').change(function(e){
            e.preventDefault();
            $('#text')
                .val($(this).val())
                .focus();
        });
    });
</script>