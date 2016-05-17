<?php
$url = current_url();
$url .= !$this->uri->segment(2) ? '?new=1' : '';
echo form_open($url,'class="form-horizontal"');
?>
<div class="modal-body">
    <div class="form-group">
        <label class="col-sm-3 control-label" for="road_name">Road Name:</label>
        <div class="col-sm-9">
            <input type="text" name="road_name" class="form-control input-sm" id="road_name" value="<?php echo @$postal_code->road_name;?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="num_range">No. Range:</label>
        <div class="col-sm-9">
            <input type="text" name="num_range" class="form-control input-sm" id="num_range" value="<?php echo @$postal_code->num_range;?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="suburb">Suburb:</label>
        <div class="col-sm-9">
            <input type="text" name="suburb" class="form-control input-sm" id="suburb" value="<?php echo @$postal_code->suburb;?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="town_city">Town/City:</label>
        <div class="col-sm-9">
            <input type="text" name="town_city" class="form-control input-sm" id="town_city" value="<?php echo @$postal_code->town_city;?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="postcode">Postal Code:</label>
        <div class="col-sm-9">
            <input type="text" name="postcode" class="form-control input-sm" id="postcode" value="<?php echo @$postal_code->postcode;?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label" for="franchise_id">Franchise:</label>
        <div class="col-sm-9">
            <?php echo form_dropdown('franchise_id',$franchise,@$postal_code->franchise_id,'class="form-control input-sm" id="franchise_id"');?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="text-right">
        <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Submit">
        <input type="button" name="cancel" class="btn btn-default btn-sm" value="Cancel" data-dismiss="modal">
    </div>
</div>
<?php
echo form_close();
?>