<script src="<?php echo base_url(); ?>plugins/js/number.js"></script>
<script>
    $(function(e){
        var ignoreId = '<?php echo $tag->id; ?>';
        var trussDetail = $('#trussDetail');
        var submitBtn = $('.submitBtn');
        var closeBtn = $('.closeBtn, .cancelBtn');

        var numberSeqTag = $('.seq, .tag_id');

        submitBtn.click(function(e){
            var hasEmpty = false;

            $('.required').each(function(e){
                if(!$(this).val()){
                    hasEmpty = true;
                    $(this).css({
                        border: '1px solid #F00'
                    });
                }
                else{
                    $(this).css({
                        border: '1px solid #CCC'
                    });
                }
            });

            if(hasEmpty){
                e.preventDefault();
            }
        });
        closeBtn.click(function(e){
            trussDetail.html("");
        });

        $('.number').numberOnly();

        numberSeqTag.focusout(function(e){
            var itExist = false;
            var idVal = $('.tag_id').val();

            if(idVal){
                $.each(tagsGridJson, function(keys, val){
                    if(val.id != ignoreId){
                        if(val.tag_id == idVal){
                            itExist = true;
                        }
                    }
                });
            }

            if(itExist){
                submitBtn.attr('disabled', 'disabled');
            }
            else{
                submitBtn.removeAttr('disabled');
            }
        });
    });
</script>
<style>
    .trussTagArea{
        border: 1px solid #000000;
        width: 100%;
    }
    .trussTagHeader{
        background: #000000;
        color: #ffffff;
        padding: 5px 10px;
    }
    .trussTagForm{
        padding: 3px 5px;
    }
    .closeBtn{
        float: right;
        color: #ffffff;
    }
</style>

<div class="trussTagArea">
    <div class="trussTagHeader">
        Tag Maintenance
        <a href="#" class="closeBtn">x</a>
    </div>
    <div class="trussTagForm">
        <?php
        echo form_open('','class="form-horizontal"');
        ?>
        <!--<div class="form-group">
            <label class="control-label col-sm-3">ID:</label>
            <div class="col-sm-9">
                <input type="text" name="tag_id" class="tag_id form-control input-sm number required" value="<?php /*echo $tag->tag_id; */?>"/>
            </div>
        </div>-->
        <div class="form-group">
            <label class="control-label col-sm-3">Description:</label>
            <div class="col-sm-9">
                <textarea name="description" class="form-control input-sm required" rows="5"><?php echo str_replace("<br />", "", $tag->description);?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Text:</label>
            <div class="col-sm-9">
                <textarea name="text" class="form-control input-sm required" rows="10"><?php echo str_replace("<br />", "", $tag->text);?></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <div class="pull-right">
                    <button type="submit" name="submit" class="submitBtn btn btn-sm btn-primary">Submit</button>
                    <button type="button" name="cancel" class="cancelBtn btn btn-sm btn-default">Cancel</button>
                </div>
            </div>
        </div>
        <?php
        echo form_close();
        ?>
    </div>
</div>