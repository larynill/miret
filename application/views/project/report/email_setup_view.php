<?php
echo form_open('','class="form-horizontal"')
?>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" class="form-control input-sm" name="take_off_agent_name" placeholder="Agent Staff Name" value="<?php echo @$contact_list->take_off_agent_name;?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" class="form-control input-sm" name="take_off_agent_email" placeholder="Agent Staff Email Address" value="<?php echo @$contact_list->take_off_agent_email;?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" class="form-control input-sm" name="take_off_agent_cc[cc_1_name]" placeholder="Agent CC1 Name" value="<?php echo @$take_off_cc->cc_1_name?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" class="form-control input-sm" name="take_off_agent_cc[cc_1_email]" placeholder="Agent CC1 Email Address" value="<?php echo @$take_off_cc->cc_1_email?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" class="form-control input-sm" name="take_off_agent_cc[cc_2_name]" placeholder="Agent CC2 Name" value="<?php echo @$take_off_cc->cc_2_name?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" class="form-control input-sm" name="take_off_agent_cc[cc_2_email]" placeholder="Agent CC2 Email Address" value="<?php echo @$take_off_cc->cc_2_email?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="text" class="form-control input-sm" name="take_off_franchise_email" placeholder="Copy to Franchise Administrator" value="<?php echo @$contact_list->take_off_franchise_email;?>">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="pull-right">
        <button class="btn btn-primary btn-sm" type="submit">Submit</button>
        <button class="btn btn-default btn-sm" type="button" data-dismiss="modal">Cancel</button>
    </div>
</div>
<?php
echo form_close();
?>