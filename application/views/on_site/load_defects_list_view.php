<?php
if(count($defects) > 0){
?>
<div class="row">
    <?php
    foreach($defects as $d){
        echo form_open('jobDefectsUpdate/' . $d->id,'class="form-horizontal" id="form-'. $d->id . '"');
        ?>
        <div class="col-md-6 defect-content" id="defect-data-<?php echo $d->id;?>" style="margin-bottom: 10px;">
            <div class="panel panel-primary">
                <div class="panel-heading form-inline">
                    <div class="row">
                        <div class="col-sm-9" data-toggle="collapse" data-target="#defect_view_<?php echo $d->id ?>">
                            <span class="text-view" style="font-size: 13px;">
                                <?php echo '<span class="title">' . $d->title .'</span>' ?>
                                <?php
                                if(count($dropdown) > 0){
                                    echo '<em>(<span class="drop-down">' . $dropdown['value'][$d->$dropdown['name']] . '</span>)</em>';
                                }
                                ?>
                            </span>
                        </div>
                        <div class="input-view" style="display: none">
                            <div class="<?php echo count($dropdown) > 0 ? 'col-sm-5' : 'col-sm-9'?>">
                                <input type="text" name="title" class="form-control input-sm title-input" value="<?php echo $d->title ?>">
                            </div>
                            <?php
                            if(count($dropdown) > 0){
                                ?>
                                <div class="col-sm-4">
                                    <?php echo form_dropdown(
                                        $dropdown['name'], $dropdown['value'], $d->$dropdown['name'],
                                        'class="jobDefectDropdown form-control input-sm dp-input" id="' . $dropdown['name'] . '" title="'. $dropdown['title'] .'"'
                                    );?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <div class="pull-right">
                                <span class="glyphicon glyphicon-pencil editDefectsBtn" style="font-size: 18px;" id="<?php echo $d->id ?>"></span>&nbsp;
                                <span class="glyphicon glyphicon-trash deleteModalBtn" style="font-size: 18px;" data-toggle="modal" data-target="#deleteDefect" id="<?php echo $d->id ?>" aria-hidden="true"></span>&nbsp;
                                <span class="glyphicon glyphicon-upload uploadModalBtn" style="font-size: 18px;<?php echo count($d->dir) > 0 ? 'display:none' : ''?>" data-toggle="modal" data-target="#uploadImage" id="<?php echo $d->id ?>" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="defect_view_<?php echo $d->id ?>" class="panel-body panel-collapse collapse in">
                    <div class="row">
                        <?php
                        if(count($d->dir) > 0){
                            echo '<div class="col-md-5">';
                            foreach ($d->dir as $key=>$files) {
                                echo '<div class="thumbnail">';
                                $path = realpath(APPPATH.'../');
                                $size = @file_exists($path .'/' . $files);
                                if($size){
                                    echo '<img src="' . base_url($files) . '" />';
                                }
                                else{
                                    echo '<div class="thumbnailNonImage" >' . strtoupper(substr(strrchr($files, '.'), 1)) . '</div>';
                                }
                                echo '<div class="panel-footer" style="text-align: center;padding: 5px!important;">';
                                echo $size ? '<span class="glyphicon glyphicon-eye-open icon showBtn" data-toggle="modal" data-target="#showDefect" style="font-size: 20px;margin-right: 5px;"></span>' : '';
                                echo '<a class="downloadLink icon" href="' . base_url($files) . '" excel_reader="' . basename($files) . '">
                                                            <span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true" style="font-size: 20px;"></span>
                                                        </a>';
                                echo '<a class="uploadImageBtn icon" style="display:none;" href="#" tabindex="5" id="' . $d->id . '" data-toggle="modal" data-target="#changePhoto" aria-hidden="true">
                                                                <span class="glyphicon glyphicon-circle-arrow-up" aria-hidden="true" style="font-size: 20px;"></span>
                                                            </a>';
                                echo '<a class="deleteImage icon pull-right" href="#" id="' . $d->id . '" data-toggle="modal" data-target="#deletePhoto" aria-hidden="true">
                                                                <span class="glyphicon glyphicon-trash" aria-hidden="true" style="font-size: 18px;"></span>
                                                            </a>';
                                echo '</div>';
                                echo '</div>';
                            }
                            echo '</div>';
                        }
                        else{
                            echo '<div class="col-md-5">';
                            echo '<div class="thumbnail">';
                            echo '<div class="thumbnailNonImage">No image</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        echo '<div class="col-md-7">';
                        /*$len = strlen($d->description);
                        $max = 220;
                        echo substr($d->description, 0, $max);
                        if($len > $max){
                            echo '<span id="descriptionReadMore" class="collapse">';
                            echo substr($d->description, $max, $len);
                            echo '</span>';
                            echo ' <a class="descriptionReadMoreBtn">[Read More]</a>';
                        }*/
                        echo '<div class="text-view">';
                        echo '<div style="border: 1px solid #d2d2d2;border-radius: 4px;padding: 10px;height: 130px;">';
                        echo '<span class="description">' . $d->description .'</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="input-view" style="display: none;">';
                        echo form_textarea(['name'=>'description','value'=>$d->description,'rows'=>7,'class'=>'form-control input-sm desc-input']);
                        echo '</div>';
                        echo '</div>';
                        ?>
                    </div>
                </div>
                <div class="input-view" style="display: none">
                    <div class="panel-footer">
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-success">Update</button>
                            <button type="button" class="btn btn-sm btn-danger">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
        echo form_close();
    }
    ?>
</div>
<?php
}
else{
    echo $show_form_input ? ''  : 'No data was found.';
}
?>