<link href="<?php echo base_url().'plugins/css/fileinput.min.css';?>" rel="stylesheet">
<script src="<?php echo base_url() . "plugins/js/fileinput.min.js" ?>"></script>
<div class="option-div">
    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-sm btn-primary add-photos"><i class="glyphicon glyphicon-plus"></i> Add Photos</button>
        </div>
    </div>
</div>

<?php
$url = current_url();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$url .= $id ? '?id=' . $id .'' : '';
$url .= '&upload=1';
echo form_open_multipart($url,'class="form-horizontal"')
?>
<div class="file-input-div" style="display: none;">
    <div class="form-group">
        <input id="file" type="file" class="file" name="file_attachment[]" multiple accept="image/*" max-size="10000" data-upload-url="<?php echo $url;?>">
    </div>
</div>
<hr/>
<?php
$arr = array_chunk($job_photos, 2);
if(count($arr) > 0){
    foreach($arr as $data){
    echo '<div class="row">';
        echo '<div class="col-sm-12">';
            echo '<div class="form-group">';
            $ref = 1;
            if(count($data) > 0){
                foreach($data as $key=>$val){
                    ?>
                    <div class="photo-div">
                        <div class="col-sm-2" style="white-space: nowrap!important;">
                            <img src="<?php echo base_url().'uploads/job/'.$val->job_id.'/photos/'.$val->photo_name?>" height="320" class="img-thumbnail">
                        </div>
                        <div class="col-sm-4" style="white-space: nowrap!important;">
                            <div class="row-fluid">
                                <div class="form-group">
                                    <div class="col-sm-11">
                                        <textarea name="comments[<?php echo $val->id;?>]" class="form-control input-sm" rows="4"><?php echo $val->comment;?></textarea>
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="#" id="<?php echo $val->id?>" class="delete-btn"><i class="glyphicon glyphicon-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                $ref++;
                }
            }
            echo '</div>';
        echo '</div>';
    echo '</div>';
    }
}
if(count($job_photos) > 0){
    ?>
    <div class="row-fluid button-option">
        <hr/>
        <div class="col-sm-12">
            <div class="form-group pull-right">
                <a href="<?php echo base_url('trackingLog')?>" class="btn btn-sm btn-default">Cancel</a>
                <button type="submit" name="submit_comments" class="btn btn-sm btn-primary submit-value">Submit</button>
            </div>
        </div>
    </div>
<?php
}
echo form_close();
?>
<script>
    $("#file").fileinput({
        uploadExtraData: {upload: 1},
        allowedFileExtensions : ['jpg', 'png','gif'],
        maxFileSize: 100000,
        maxFilesNum: 30
    }).on('fileuploaded', function(event, data, id, index) {
    });

    $('.add-photos').click(function(e){
        $('.file-input-div').css({'display':'inline'});
        $('.option-div').css({'display':'none'});
    });

    $('.close.fileinput-remove').click(function(){
        $('.file-input-div').css({'display':'none'});
        $('.option-div').css({'display':'inline'});
    });

    $('.delete-btn').click(function(e){
        var id = this.id;
        $.post(bu + 'deleteJobPhoto/' + id,{submit:1},function(e){});
        var photo_div = $(this).parents('.photo-div');
        photo_div.remove();

        count_photos();
    });

    var count_photos = function(){
        if($('.photo-div').length == 0){
            $('.button-option').css({'display':'none'});
        }
    }
</script>