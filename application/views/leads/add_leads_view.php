<?php echo form_open_multipart('','class="form-horizontal" role="form"'); ?>
<div class="modal-body">
    <div class="container-fluid">
        <div class="row well well-sm">
            <div class="col-sm-6" style="border-right: 1px solid #d2d2d2">
                <div class="form-group">
                    <label for="firstname" class="col-sm-4 control-label">First Name: </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-sm required" id="firstname" name="first_name" title="first name" placeholder="" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-sm-4 control-label">Last Name: </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-sm required" id="lastname" name="last_name" title="last name" placeholder="" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-4 control-label">Title: </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-sm" id="title" name="title" title="title" placeholder="" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="col-sm-4 control-label">Phone: </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-sm required numbers_only" id="title" name="phone" title="phone" placeholder="" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-4 control-label">Email: </label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control input-sm required" id="email" name="email" title="email" placeholder="" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="city" class="col-sm-4 control-label">City: </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-sm required" id="city" name="city" title="city" placeholder="" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="state_province" class="col-sm-4 control-label">State / Province: </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-sm required" id="state_province" name="state_province" title="State / Province" placeholder="" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">Country: </label>
                    <div class="col-sm-8">
                        <?php
                        echo form_dropdown('country',$country,163,'class="form-control input-sm required"');
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="assignedTo" class="col-sm-4 control-label">Assigned to: </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control input-sm" id="assignedTo" name="assigned_to" title="Assigned To" placeholder="" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="comment" class="col-sm-4 control-label">Comments:</label>
                    <div class="col-sm-8">
                        <textarea class="form-control input-sm" id="comment" name="comments" title="Comments" placeholder="" ></textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-5 control-label">Lead Status: </label>
                    <div class="col-sm-6">
                        <?php
                        echo form_dropdown('status_id',$leads_status,'','class="form-control input-sm required"');
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="account_name" class="col-sm-5 control-label">Date last Contacted:</label>
                    <div class="col-sm-6">
                        <div class='input-group date datetimepicker' id='datetimepicker4' data-date-format="DD/MM/YYYY">
                            <input type='text' class="form-control input-sm" name="date_last_contacted" readonly/>
                                <span class="input-group-addon open-date-calendar">
                                    <span class="glyphicon-calendar glyphicon"></span>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes" class="col-sm-5 control-label">Notes:</label>
                    <div class="col-sm-7">
                        <textarea class="form-control input-sm" id="notes" name="notes" title="Notes" placeholder="" rows="7"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
    <input type="submit" name="submitLead" class="btn btn-sm btn-success submit_client">
</div>
<?php echo form_close();?>
<script>
    $(function () {
        $('#datetimepicker4').datetimepicker({
            pickTime: false
        });
    });
</script>