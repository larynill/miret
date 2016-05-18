<?php
reset($drop_down[10]);
$job_type_id = @$job->job_type_id ? @$job->job_type_id : key($drop_down[10]);
?>
<input type="hidden" name="job_type_id" class="job_type_id" value="<?php echo $job_type_id;?>">
<div class="container-fluid">
    <div class="row" style="font-size: 12px;">
        <div class="col-sm-4 well well-sm" >
            <div class="form-group">
                <label for="exampleInputEmail1">Job Name:</label>
                <input type="text" name="project_name" class="form-control input-sm required" placeholder="Project Name" value="<?php echo @$job->project_name;?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Insured Name:</label>
                <input type="text" name="insured_name" class="form-control input-sm required" placeholder="Insured Name" value="<?php echo @$job->insured_name;?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Policy #:</label>
                <input type="text" name="policy_number" class="form-control input-sm required" placeholder="Policy Number" value="<?php echo @$job->policy_number;?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Client Ref #:</label>
                <input type="text" name="client_ref" class="form-control input-sm required" placeholder="Client Ref #" value="<?php echo @$job->client_ref;?>">
            </div>
            <?php
            if(@$job->id){
                ?>
                <div class="form-group">
                    <label for="exampleInputEmail1">Job Number:</label>
                    <input type="text" class="form-control input-sm" placeholder="Job Number" value="<?php echo @$job_num;?>" readonly>
                </div>
            <?php
            }
            ?>
            <div class="form-group">
                <label for="exampleInputEmail1">Description:</label>
                <input type="text" class="form-control input-sm required" name="job_description" placeholder="Description" value="<?php echo @$job->job_description;?>">
            </div>
            <div class="form-group">
                <label>Inspection Time:</label>
                <div class='input-group date datetimepicker' id='inspection_time'>
                    <input type='text' class="input-sm form-control date-class" name="inspection_time"
                           value="<?php echo @$job->inspection_time ? @$job->inspection_time : ''?>" readonly>
                <span class="input-group-addon open-date-calendar">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                </div>
            </div>
            <div class="form-group">
                <label>Date Due:</label>
                <div class='input-group date datetimepicker' id='date_due'>
                    <input type='text' class="input-sm form-control date-class" name="date_due"
                           value="<?php echo @$job->date_due ? @$job->date_due : ''?>" readonly>
                    <span class="input-group-addon open-date-calendar">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label>Instruction Received</label>
                <?php echo form_dropdown('instruction_received',$instruction_received,'','class="job-details form-control input-sm"');?>
            </div>
            <div class="form-group">
                <label>Provide copies to</label>
                <input type="text" class="form-control input-sm job-details" name="provide_copies_to" value="<?php echo @$job->provide_copies_to ?>" />
            </div>
            <div class="form-group">
                <label class="control-label">Type of Inspection</label>
                <div class="row">
                    <div class="col-md-5">
                        <select class="form-control input-sm inspection_range job-details" name="inspection_range">
                            <option value="1" <?php echo @$job->inspection_range == 1 ? "selected" : "" ?>>Standard</option>
                            <option value="2" <?php echo @$job->inspection_range == 2 ? "selected" : "" ?>>Detailed</option>
                        </select>
                    </div>
                    <div class="col-md-7">
                        <select class="form-control input-sm type_inspection job-details required" data-type="job_type_id" name="type_inspection">
                            <option></option>
                            <?php
                            if(count($inspection_type) > 0){
                                foreach ($inspection_type as $v) {
                                    echo '<option value="' . $v->id . '"' . (@$job->type_inspection == $v->id ? ' selected' : '') . '>' . $v->inspection_type . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Purpose of the inspection</label>
                <textarea name="purpose_inspection" class="form-control job-details input-sm" rows="6" style="resize: none;"><?php echo str_replace("<br />", "", @$job->purpose_inspection) ?></textarea>
            </div>
        </div>
        <div class="col-sm-5 well well-sm">
            <div class="form-group">
                <label for="exampleInputEmail1">Owner:</label>
                <input type="text" class="form-control input-sm required" name="owner" placeholder="Owner" value="<?php echo @$job->owner;?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Owner Email:</label>
                <input type="email" class="form-control input-sm required" name="owner_email" placeholder="Owner Email" value="<?php echo @$job->owner_email;?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Contact Number:</label>
                <div class="form-horizontal">
                    <div class="col-sm-6" style="padding: 5px 0 10px;">
                        <input type="text" class="form-control input-sm" name="owner_phone" placeholder="Landline" value="<?php echo @$job->owner_phone;?>">
                    </div>
                    <div class="col-sm-6" style="padding: 5px 2px 10px;">
                        <input type="text" class="form-control input-sm" name="owner_mobile" placeholder="Mobile" value="<?php echo @$job->owner_mobile;?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-horizontal">
                    <div class="col-sm-6" style="padding: 5px 0 10px;">
                        <label for="exampleInputEmail1">Lot Number</label>
                        <input type="text" class="form-control input-sm job-details" name="lot_number" value="<?php echo @$job->lot_number ?>" />
                    </div>

                    <div class="col-md-6" style="padding: 5px 2px 10px;">
                        <label for="exampleInputEmail1">DP Number</label>
                        <input type="text" class="form-control input-sm job-details" name="dp_number" value="<?php echo @$job->dp_number ?>" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Address:</label>
                <input type="text" class="form-control input-sm" name="address" placeholder="Address" value="<?php echo @$job->address;?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Suburb:</label>
                <input type="text" class="form-control input-sm" name="suburb" placeholder="Suburb" value="<?php echo @$job->suburb;?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">City:</label>
                <div class="form-horizontal">
                    <div class="col-sm-8" style="padding: 5px 0 10px;">
                        <input type="text" class="form-control input-sm" name="city" placeholder="City" value="<?php echo @$job->city;?>">
                    </div>
                    <div class="col-sm-4" style="padding: 5px 2px 10px;">
                        <input type="text" class="form-control input-sm" name="zip_code" placeholder="Code" value="<?php echo @$job->zip_code;?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Property Status:</label>
                <?php echo form_dropdown('property_status_id',$drop_down[9],@$job->property_status_id,'class="form-control input-sm"');?>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Tenant:</label>
                <input type="text" class="form-control input-sm" name="tenant" placeholder="Tenant" value="<?php echo @$job->tenant;?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Tenant Contact Details:</label>
                <textarea class="form-control input-sm" name="tenant_contact_details" placeholder="Tenant"><?php echo @$job->tenant_contact_details;?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Owner Present During Inspection: </label>
                <?php
                $option = array(
                    1 => 'Yes',
                    0 => 'No'
                );
                $ref = 1;
                foreach($option as $k=>$v){
                    $is_checked = @$job->owner_is_present != '' ? (@$job->owner_is_present == $k ? 'checked' : '') : ($ref == 1 ? 'checked' : '');
                    ?>
                    <label class="radio-inline">
                        <input type="radio" name="owner_is_present" <?php echo 'value="' . $k . '" ' . $is_checked;?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $v;?>
                    </label>
                <?php
                    $ref++;
                }
                ?>
            </div>
            <div class="form-group">
                <label>Pets: </label>
                <label class="radio-inline">
                    <input type="radio" name="pets" class="job-details" value="1" <?php echo @$job->pets == 1 ? 'checked' : '' ?>/>&nbsp;Yes
                </label>
                <label class="radio-inline">
                    <input type="radio" name="pets" class="job-details" value="0" <?php echo @$job->pets == 0 ? 'checked' : '' ?>/>&nbsp;No
                </label>
            </div>
            <div class="form-group">
                <label>Electricity:</label>
                <label class="radio-inline">
                    <input type="radio" name="electricity" class="job-details" value="1" <?php echo @$job->electricity == 1 ? 'checked' : '' ?>/>&nbsp;Connected
                </label>
                <label class="radio-inline">
                    <input type="radio" name="electricity" class="job-details" value="0" <?php echo @$job->electricity == 0 ? 'checked' : '' ?>/>&nbsp;Disconnected
                </label>
            </div>
            <div class="form-group">
                <label>Water:</label>
                <label class="radio-inline">
                    <input type="radio" name="water" class="job-details" value="1" <?php echo @$job->water == 1 ? 'checked' : '' ?>/>&nbsp;Connected
                </label>
                <label class="radio-inline">
                    <input type="radio" name="water" class="job-details" value="0" <?php echo @$job->water == 0 ? 'checked' : '' ?>/>&nbsp;Disconnected
                </label>
            </div>
            <div class="form-group">
                <label>Orientation:</label>
                <div class="row">
                    <div class="col-md-5">
                        <?php
                        echo form_dropdown('property_orientation', $orientation, @$job->property_orientation, 'class="form-control input-sm job-details"');
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 well well-sm">
            <div class="form-group">
                <label>Details of Property</label>
                <textarea name="details_property" class="form-control input-sm job-details" rows="6" style="resize: none;"><?php echo str_replace("<br />", "", @$job->details_property) ?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Job Status:</label>
                <?php echo form_dropdown('job_status_id',$drop_down[11],@$job->job_status_id,'class="form-control input-sm required"');?>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Inspector:</label>
                <?php echo form_dropdown('inspector_id',$inspector,@$job->inspector_id,'class="form-control input-sm"');?>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Account Mgr:</label>
                <?php
                echo form_dropdown('account_manager_id',$accounts,@$job->account_manager_id,'class="form-control input-sm required"');
                ?>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Entered:</label>
                <div class='input-group date datetimepicker1' id='entered'>
                    <input type='text' class="input-sm form-control date-class" name="date_entered"
                           value="<?php echo @$job->date_entered ? date('d-m-Y',strtotime(@$job->date_entered)) : date('d-m-Y')?>" readonly>
                    <span class="input-group-addon open-date-calendar">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Completed:</label>
                <div class='input-group date datetimepicker1' id='completed'>
                    <input type='text' class="input-sm form-control date-class" name="date_completed"
                           value="<?php echo @$job->date_completed ? @$job->date_completed : ''?>" readonly>
                    <span class="input-group-addon open-date-calendar">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Report Printed:</label>
                <div class='input-group date datetimepicker1' id='report_printed'>
                    <input type='text' class="input-sm form-control date-class" name="date_report_printed"
                           value="<?php echo @$job->date_report_printed ? @$job->date_report_printed : ''?>" readonly>
                    <span class="input-group-addon open-date-calendar">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Report Sent:</label>
                <div class='input-group date datetimepicker1' id='report_printed'>
                    <input type='text' class="input-sm form-control date-class" name="date_report_sent"
                           value="<?php echo @$job->date_report_sent ? @$job->date_report_sent : ''?>" readonly>
                    <span class="input-group-addon open-date-calendar">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(e){
        var datetimepicker = $('.datetimepicker');
        var date_initial_val = '';
        datetimepicker
            .datetimepicker({
                format: "ddd DD-MM-YYYY hh:mm A",
                useCurrent: false
            })
            .on('dp.show',function(e){
                date_initial_val = $(this).find('.date-class').val();
            })
            .on('dp.change', function(e) {
            var d = new Date(e.date);
                if(!date_initial_val){
                    date_initial_val = d;
                    $(this).data('DateTimePicker').setValue(moment(d.setHours(9, 0)));
                }
        });

        $('.datetimepicker1').datetimepicker({
            format: "DD-MM-YYYY",
            useCurrent: false,
            pickTime: false
        });

        $('.submit-value').click(function(e){
            var is_empty = false;
            var required = $('.required');
            required.removeAttr('style');
            required.each(function(e){
                if(!$(this).val()){
                   is_empty = true;
                   $(this).css({'border':'1px solid red'});
                }
            });

            if(is_empty){
                e.preventDefault();
            }
        });
        <?php
        if($accountType == 4){
        ?>
            $('input,textarea,select').attr('disabled','disabled');
        <?php
        }
        ?>
    });
</script>