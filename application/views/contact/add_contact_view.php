<?php
echo form_open('','class="form-horizontal"');
$id = $this->uri->segment(2);
$is_branch = $id ? (@$contact_list->is_branch ? 'checked' : '') : '';
$is_agent = $id ? (!@$contact_list->is_branch ? 'checked' : '') : 'checked';
$take_off_cc = @$contact_list->take_off_agent_cc ? json_decode(@$contact_list->take_off_agent_cc) : array();
?>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="col-sm-12">
                    <label class="control-label radio-inline">
                        <input type="radio" name="is_branch" id="inlineRadio2" value="0" style="width: 20%;"  <?php echo $is_agent;?>> <strong>Agent</strong>
                    </label>
                    <label class="control-label radio-inline">
                        <input type="radio" name="is_branch" id="inlineRadio2" value="1" style="width: 20%;" <?php echo $is_branch;?> > <strong>Branch</strong>
                    </label>
                </div>
            </div>
            <hr/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="for-agent-form">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="agent_name">Agent Name:</label>
                    <div class="col-sm-8">
                        <input type="text" name="contact_name" class="form-control input-sm" id="agent_name" value="<?php echo @$contact_list->contact_name?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="contact_code">Agent Code:</label>
                    <div class="col-sm-8">
                        <input type="text" name="contact_code" class="form-control input-sm" id="contact_code" value="<?php echo @$contact_list->contact_code?>">
                    </div>
                </div>
            </div>
            <div class="for-branch-form">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="agent_id">Agent:</label>
                    <div class="col-sm-8">
                        <?php echo form_dropdown('agent_id',$agent,(@!$contact_list->is_branch ? @$contact_list->id : @$contact_list->agent_id),'class="form-control input-sm" id="agent_id" ' . ($id ? 'disabled' : ''));?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="branch_name">Branch Name:</label>
                    <div class="col-sm-8">
                        <?php
                        if($id){
                            ?>
                            <?php echo form_dropdown('branch_name',$agent_branch,@$contact_list->branch_name,'class="form-control input-sm" id="agent_id" ');?>
                        <?php
                        }
                        else{
                            ?>
                            <input type="text" name="branch_name" class="form-control input-sm" id="branch_name" value="<?php echo @$contact_list->branch_name?>">
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="branch_code">Branch Code:</label>
                    <div class="col-sm-8">
                        <input type="text" name="branch_code" class="form-control input-sm" id="branch_code" value="<?php echo @$contact_list->branch_code?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="po_box">P.O. Box:</label>
                <div class="col-sm-8">
                    <input type="text" name="po_box" class="form-control input-sm" id="po_box" value="<?php echo @$contact_list->po_box?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="street_address_1">Street Address (1):</label>
                <div class="col-sm-8">
                    <input type="text" name="street_address_1" class="form-control input-sm" id="street_address_1" value="<?php echo @$contact_list->street_address_1?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="street_address_2">Street Address (2):</label>
                <div class="col-sm-8">
                    <input type="text" name="street_address_2" class="form-control input-sm" id="street_address_2" value="<?php echo @$contact_list->street_address_2?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="suburb">Suburb:</label>
                <div class="col-sm-8">
                    <input type="text" name="suburb" class="form-control input-sm" id="suburb" value="<?php echo @$contact_list->suburb?>">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label col-sm-4" for="postal_code">Postal Code:</label>
                <div class="col-sm-8">
                    <input type="text" name="postal_code" class="form-control input-sm" id="postal_code" value="<?php echo @$contact_list->postal_code?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="town_city">Town/City:</label>
                <div class="col-sm-8">
                    <input type="text" name="town_city" class="form-control input-sm" id="town_city" value="<?php echo @$contact_list->town_city?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="email">Email:</label>
                <div class="col-sm-8">
                    <input type="text" name="email" class="form-control input-sm" id="email" value="<?php echo @$contact_list->email?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="mobile">Mobile:</label>
                <div class="col-sm-8">
                    <input type="text" name="mobile" class="form-control input-sm" id="mobile" value="<?php echo @$contact_list->mobile?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="phone">Tel.:</label>
                <div class="col-sm-8">
                    <input type="text" name="phone" class="form-control input-sm" id="phone" value="<?php echo @$contact_list->phone?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="franchise">Franchise:</label>
                <div class="col-sm-8">
                    <?php echo form_dropdown('franchise_id',$franchise,@$contact_list->franchise_id,'class="form-control input-sm" id="franchise"');?>
                </div>
            </div>
            <div class="for-branch-form">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="location">Location:</label>
                    <div class="col-sm-8">
                        <?php echo form_dropdown('location[]',$location,@json_decode($contact_list->location),'class="form-control input-sm" id="location" multiple="multiple"');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <fieldset>
            <legend>Report Return Details</legend>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="col-sm-3">
                        <label class="inline-checkbox">
                            <input type="checkbox" name="via_stl" value="1" <?php echo @$contact_list->via_stl ? 'checked' : ''?>> STL
                        </label>
                    </div>
                    <div class="col-sm-offset-9">&nbsp;</div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3">
                        <label class="inline-checkbox">
                            <input type="checkbox" name="via_email" value="1" <?php echo @$contact_list->via_email ? 'checked' : ''?>> via Email?
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-3">
                        <input type="text" class="form-control input-sm" name="take_off_agent_name" placeholder="Agent Staff Name" value="<?php echo @$contact_list->take_off_agent_name;?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-3">
                        <input type="text" class="form-control input-sm" name="take_off_agent_email" placeholder="Agent Staff Email Address" value="<?php echo @$contact_list->take_off_agent_email;?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-3">
                        <input type="text" class="form-control input-sm" name="take_off_agent_cc[cc_1_name]" placeholder="Agent CC1 Name" value="<?php echo @$take_off_cc->cc_1_name?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-3">
                        <input type="text" class="form-control input-sm" name="take_off_agent_cc[cc_1_email]" placeholder="Agent CC1 Email Address" value="<?php echo @$take_off_cc->cc_1_email?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-3">
                        <input type="text" class="form-control input-sm" name="take_off_agent_cc[cc_2_name]" placeholder="Agent CC2 Name" value="<?php echo @$take_off_cc->cc_2_name?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-3">
                        <input type="text" class="form-control input-sm" name="take_off_agent_cc[cc_2_email]" placeholder="Agent CC2 Email Address" value="<?php echo @$take_off_cc->cc_2_email?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-3">
                        <input type="text" class="form-control input-sm" name="take_off_franchise_email" placeholder="Copy to Franchise Administrator" value="<?php echo @$contact_list->take_off_franchise_email;?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="return_text">Invoice & Statement Return</label>
                    <textarea class="form-control input-sm" name="return_text" id="return_text" rows="5"><?php echo @$contact_list->return_text;?></textarea>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="staff_name" placeholder="Staff Name" value="<?php echo @$contact_list->staff_name;?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control input-sm" name="staff_email" placeholder="Staff Email" value="<?php echo @$contact_list->staff_name;?>">
                </div>
                <div class="form-group">
                    <label class="inline-checkbox">
                        <input type="checkbox" name="include_job_address" value="1" <?php echo @$contact_list->include_job_address ? 'checked' : ''?>> Include Job Address
                    </label>
                </div>
            </div>
        </fieldset>
    </div>
</div>
<div class="modal-footer">
    <div class="col-sm-12">
        <div class="pull-right">
            <button type="submit" name="submit" class="btn btn-sm btn-primary">Submit</button>
            <button class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
        </div>
    </div>
</div>
<?php
echo form_close();
?>
<script>
    $(function(){
        var is_branch = $('input[name="is_branch"]');
        var branch_form = $('.for-branch-form');
        var agent_form = $('.for-agent-form');

        var check_if_branch = function(_this){
            console.log(_this.val());
            if(_this.val() != 1){
                branch_form.css({
                    'display':'none'
                });
                agent_form.css({
                    'display':'inline'
                });
            }
            else{
                branch_form.css({
                    'display':'inline'
                });
                agent_form.css({
                    'display':'none'
                });
            }
        };
        check_if_branch($('input[name="is_branch"]:checked'));
        is_branch.change(function(){
            check_if_branch($(this));
        });

        $('#location').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            maxHeight: 200,
            buttonClass: 'btn btn-sm btn-default'
        });
    });
</script>