<?php
echo form_open('','class="form-horizontal"')
?>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">First Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input-sm required" id="name" name="FName">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Last Name</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input-sm required" id="name" name="LName">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel" class="col-sm-4 control-label">Phone</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input-sm " id="tel" name="Tel">
                    </div>
                </div>
                <div class="form-group">
                    <label for="mobile" class="col-sm-4 control-label">Mobile</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input-sm " id="mobile" name="Mobile">
                    </div>
                </div>
                <div class="form-group">
                    <label for="physical_address" class="col-sm-4 control-label">Address</label>
                    <div class="col-sm-6">
                        <textarea name="Address" class="form-control input-sm" id="physical_address" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control input-sm required" id="email" name="EmailAddress">
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input-sm required" id="username" name="Username">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control input-sm required" id="password" name="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="alias" class="col-sm-3 control-label">Alias</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input-sm required" id="alias" name="Alias">
                    </div>
                </div>
                <div class="form-group">
                    <label for="active" class="col-sm-3 control-label">Active</label>
                    <div class="col-sm-8">
                        <div class="checkbox pull-left">
                            <label>
                                <input type="checkbox" name="isActive" id="active" value="1" /> &nbsp;
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="isCanAddJob" class="col-sm-3 control-label">Can Add Job?</label>
                    <div class="col-sm-8">
                        <div class="checkbox pull-left">
                            <label>
                                <input type="checkbox" name="isCanAddJob" id="isCanAddJob" value="1" /> &nbsp;
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="isQualifiedInspector" class="col-sm-3 control-label">Qualified Inspector?</label>
                    <div class="col-sm-8">
                        <div class="checkbox pull-left">
                            <label>
                                <input type="checkbox" name="isQualifiedInspector" id="isQualifiedInspector" value="1"/> &nbsp;
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="acc_type" class="col-sm-3 control-label">Account Type</label>
                    <div class="col-sm-7">
                        <?php
                        echo form_dropdown('AccountType',$account_type,3,'class="form-control input-sm" id="acc_type"');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm submit-btn" name="submit">Save</button>
    </div>
<?php
echo form_close();
?>
<script>
    $(function(e){
        $('.submit-btn').on('click',function(e){
            var hasEmpty = false;
            $('.required').each(function(e){
                if(!$(this).val()){
                    hasEmpty = true;
                    $(this).css({
                        border:'1px solid #a94442'
                    });
                }
            });
            if(hasEmpty){
                e.preventDefault();
            }
        });
    })
</script>