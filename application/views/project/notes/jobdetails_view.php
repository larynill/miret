<?php
echo form_open('','class="form"');
$_id = 0;
if(count($notes) > 0) {
    foreach ($notes as $val) {
        $_id = $val->id + 1;
    }
}

?>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="notes-container">
                    <div class="job-details" id="form_<?php echo $v->id;?>">
                        <table class="table-details" style="width: 100%;">
                            <tr>
                                <th classolspan="4" class="text-center">Job Details</th>
                            </tr>
                            <tr>
                                <td>Owner:</td>
                                <td><?php echo $v->owner;?></td>
                                <td>Owner Email:</td>
                                <td><?php echo $v->owner_email;?></td>
                            </tr>
                            <tr>
                                <td>Mobile:</td>
                                <td><?php echo $v->owner_mobile;?></td>
                                <td>Phone:</td>
                                <td><?php echo $v->owner_phone;?></td>
                            </tr>
                            <tr>\   
                                <td>Insured Name:</td>
                                <td><?php echo $v->insured_name;?></td>
                                <td>Account Mgr:</td>
                                <td><?php echo $v->account_manager_name;?></td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td colspan="3"><?php echo $v->job_address;?></td>
                            </tr>
                            <tr>
                                <td>Tenant<br/>Contact Details:</td>
                                <td colspan="3"><?php echo $v->tenant_contact_details;?></td>
                            </tr>
                            <tr>
                                <td>Tenant:</td>
                                <td><?php echo $v->tenant;?></td>
                                <td >Property Status:</td>
                                <td><?php echo $v->property_status;?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
echo form_close();
?>
