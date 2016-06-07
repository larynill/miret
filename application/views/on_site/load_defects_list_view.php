<?php
if(count($defects) > 0){
?>
<div class="row">
    <?php
    foreach($defects as $d){
        ?>
        <div class="col-md-6" id="defect-data-<?php echo $d->id;?>" style="margin-bottom: 10px;">
            <div class="panel panel-primary">
                <div class="panel-heading form-inline" data-toggle="collapse" data-target="#defect_view_<?php echo $d->id ?>">
                    <span style="font-size: 13px">
                        <?php echo $d->title ?>
                        <?php
                        if(count($dropdown) > 0){
                            echo '<em>(' . $dropdown['value'][$d->$dropdown['name']] . ')</em>';
                        }
                        ?>
                    </span>
                    <span class="glyphicon glyphicon-trash pull-right deleteModalBtn" data-toggle="modal" data-target="#deleteDefect" id="<?php echo $d->id ?>" aria-hidden="true"></span>
                </div>
                <div id="defect_view_<?php echo $d->id ?>" class="panel-body panel-collapse collapse in">
                    <div class="row">
                        <?php
                        if(count($d->dir) > 0){
                            echo '<div class="col-md-5">';
                            foreach ($d->dir as $key=>$files) {
                                echo '<div class="thumbnail">';
                                $size = @exif_imagetype(base_url($files));
                                if($size){
                                    echo '<img src="' . base_url($files) . '" />';
                                }
                                else{
                                    echo '<div class="thumbnailNonImage">' . strtoupper(substr(strrchr($files, '.'), 1)) . '</div>';
                                }
                                echo '<div class="panel-footer" style="text-align: right;padding: 5px!important;">';
                                echo $size ? '<span class="glyphicon glyphicon-eye-open showBtn" data-toggle="modal" data-target="#showDefect" style="font-size: 20px;margin-right: 5px;"></span>' : '';
                                echo '<a class="downloadLink" href="' . base_url($files) . '" excel_reader="' . basename($files) . '">
                                                            <span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true" style="font-size: 20px;"></span>
                                                        </a>';
                                echo '</div>';
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        echo '<div class="col-md-7" style="text-align: justify;">';
                        $len = strlen($d->description);
                        $max = 220;
                        echo substr($d->description, 0, $max);
                        if($len > $max){
                            echo '<span id="descriptionReadMore" class="collapse">';
                            echo substr($d->description, $max, $len);
                            echo '</span>';
                            echo ' <a class="descriptionReadMoreBtn">[Read More]</a>';
                        }
                        echo '</div>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
<?php
}
else{
    echo $show_form_input ? ''  : 'No data was found.';
}