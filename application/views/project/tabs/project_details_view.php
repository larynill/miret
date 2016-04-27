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
                <label for="exampleInputEmail1">Owner:</label>
                <input type="text" class="form-control input-sm required" name="owner" placeholder="Owner" value="<?php echo @$job->owner;?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Owner Email:</label>
                <input type="email" class="form-control input-sm required" name="owner_email" placeholder="Owner Email" value="<?php echo @$job->owner_email;?>">
            </div>
        </div>
        <div class="col-sm-5 well well-sm">
            <div class="form-group">
                <label for="exampleInputEmail1">Contact Number:</label>
                <div class="form-horizontal">
                    <div class="col-sm-6" style="padding: 5px 0 10px;">
                        <input type="text" class="form-control input-sm" name="owner_phone" placeholder="Phone" value="<?php echo @$job->owner_phone;?>">
                    </div>
                    <div class="col-sm-6" style="padding: 5px 2px 10px;">
                        <input type="text" class="form-control input-sm" name="owner_mobile" placeholder="Mobile" value="<?php echo @$job->owner_mobile;?>">
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
                <label for="exampleInputEmail1">Owner Present During Inspection:</label>
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
        </div>
        <div class="col-sm-3 well well-sm">
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
        $('.datetimepicker').datetimepicker({
            format: "DD-MM-YYYY HH:mm A",
            useCurrent: false
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
    });
</script>