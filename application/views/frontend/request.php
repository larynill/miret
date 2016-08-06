<div class="container" id="request">

    <div class="row center">
        <div class="col-sm-12">
            <p class="v-smash-text-large-2x">
                <span>Request</span>
            </p>
            <div class="horizontal-break"></div>
        </div>
    </div>
    <div class="row">
        <?php echo form_open('')?>
            <input type="hidden" name="status_id" value="1">
            <?php echo $this->session->flashdata('confirmation');?>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-4">
                        <label for="name">First Name <span class="required">*</span></label>
                        <input type="text" maxlength="100" class="form-control require" name="first_name" id="name">
                    </div>
                    <div class="col-sm-4">
                        <label for="lname">Last Name <span class="required">*</span></label>
                        <input type="text" maxlength="100" class="form-control require" name="last_name" id="lname">
                    </div>
                    <div class="col-sm-1">
                        <label for="code">Code</label>
                        <input type="text" maxlength="100" class="form-control" name="code" id="code">
                    </div>
                    <div class="col-sm-3">
                        <label for="phone">Phone Number <span class="required">*</span></label>
                        <input type="text" maxlength="100" class="form-control require" name="phone" id="phone">
                    </div>
                </div>
            </div>
            <fieldset>
                <legend>Property Address to Inspect</legend>
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-1">
                            <label for="flat">Flat/Apt.</label>
                            <input type="text" maxlength="100" class="form-control" name="flat" id="flat">
                        </div>
                        <div class="col-sm-2">
                            <label for="street_num">Street No.</label>
                            <input type="text" maxlength="100" class="form-control" name="street_num" id="street_num">
                        </div>
                        <div class="col-sm-6">
                            <label for="address">Street Name</label>
                            <input type="text" maxlength="100" class="form-control" name="address" id="address">
                        </div>
                        <div class="col-sm-3">
                            <label for="suburb">Suburb</label>
                            <input type="text" maxlength="100" class="form-control" name="state_province" id="suburb">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="city">City/Town</label>
                            <input type="text" maxlength="100" class="form-control" name="city" id="city">
                        </div>
                        <div class="col-sm-3">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" maxlength="100" class="form-control" name="postal_code" id="postal_code">
                        </div>
                        <div class="col-sm-3">
                            <label for="country">Country</label>
                            <?php echo form_dropdown('country',$country,163,'class="form-control" id="country"')?>
                        </div>
                    </div>
                </div>
                <hr/>
            </fieldset>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-3">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="text" maxlength="100" class="form-control require" name="email" id="email">
                    </div>
                    <div class="col-sm-2">
                        <label for="contact_time">Best Time To Contact</label>
                        <div class='input-group date datetimepicker' id='contact_time'>
                            <input type='text' class="input-sm form-control date-class" name="contact_time" value="" readonly>
                            <span class="input-group-addon open-date-calendar">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <label for="Textarea1">Notes</label>
                        <textarea maxlength="5000" rows="5" class="form-control" name="notes" id="Textarea1"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <br />
                    <input name="request" type="submit" id="sendrequest" class="btn v-btn no-three-d" value="Send Request">
                </div>
            </div>
        <?php echo form_close();?>

        <div class="v-spacer col-sm-12 v-height-standard"></div>
    </div>
</div>