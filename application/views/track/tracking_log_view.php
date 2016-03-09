<table class="table table-responsive table-colored-header">
    <thead>
    <tr>
        <th>Date Received</th>
        <th>Policy No.</th>
        <th>Client Ref.</th>
        <th>Our Ref.</th>
        <th style="width: 25%;">Job Name</th>
        <th>Status</th>
        <th>Job Type</th>
        <th>Inspector</th>
        <th>Inspector<br/>to visit</th>
        <th>Report Sent</th>
        <th style="width: 12%">Notes</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(count($tracking) > 0){
        foreach($tracking as $k=>$v){
            $words = $v->inspector_name ? explode(" ", $v->inspector_name) : array();
            $acronym = "";
            if(count($words) > 0){
                foreach ($words as $w) {
                    $acronym .= $w[0];
                }
            }
            ?>
            <tr>
                <td><?php echo $v->date_entered;?></td>
                <td><?php echo $v->policy_number;?></td>
                <td class="white-space"><?php echo $v->client_ref;?></td>
                <td class="white-space"><?php echo $v->job_ref;?></td>
                <td class="white-space job-name" id="<?php echo $v->id;?>">
                    <?php echo $v->project_name;?>
                    <div class="job-details" id="form_<?php echo $v->id;?>">
                        <table class="table-details" style="width: 100%;">
                            <tr>
                                <th colspan="4" class="text-center">Job Details</th>
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
                            <tr>
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
                                <td>Property Status:</td>
                                <td><?php echo $v->property_status;?></td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td>
                    <strong data-toggle="tooltip" data-placement="right" title="<?php echo $v->job_status;?>"><?php echo $v->job_status_code;?></strong>
                </td>
                <td>
                    <strong data-toggle="tooltip" data-placement="right" title="<?php echo $v->job_type;?>"><?php echo $v->job_type_code;?></strong>
                </td>
                <td>
                    <strong data-toggle="tooltip" data-placement="right" title="<?php echo $v->inspector_name;?>"><?php echo $acronym;?></strong>
                </td>
                <td class="white-space"><?php echo $v->inspection_time;?></td>
                <td class="white-space"><?php echo $v->date_completed;?></td>
                <td class="notes">
                    <?php
                    echo '<a href="#" class="btn-review btn btn-sm btn-primary" id="' . $v->id . '" data-title="' . $v->project_name . '" style="padding: 2px 10px;;">Review/Add</a>&nbsp;';
                    ?>
                </td>
                <td><a href="<?php echo base_url('jobRegistration?id=' . $v->id)?>">edit</a></td>
            </tr>
        <?php
        }
    }
    else{
        ?>
        <tr>
            <td colspan="12">No data was found.</td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>

<style>
    .table-colored-header tr td.job-name,
    .table-colored-header tr td.notes {
        cursor: pointer;
    }
    .job-details,.notes-div{
        display: none;
        position: absolute;
        border: 2px solid #000000;
        background: #fffddf;
    }
    .job-details{
        margin: -80px 0 0 80px;
    }
    .notes-div{
        margin: -50px 0 0 -200px;
        width: 200px!important;
        text-align: left!important;
        padding: 5px;
    }
    .job-details > table.table-details{
        background: #fffddf;
        border: none!important;
    }
    table.table-details tr td,table.table-details tr th{
        padding: 5px;
        white-space: nowrap;
        vertical-align: middle;
    }
    table.table-details tr td:nth-child(odd){
        font-weight: bold;
        text-align: right;
    }
    table.table-details tr td:nth-child(even){
        color: #0000ff;
        text-align: left;
    }
</style>
<script>
    $(function(e){
        $('[data-toggle="tooltip"]').tooltip();
        $('.job-name').hover(
            function(){
                $('.job-details').css({'display':'none'});
                $('#form_' + this.id).css({'display':'inline'});
            },
            function(){
                $('.job-details').css({'display':'none'});
            }
        );
        $('.btn-review').click(function(){
            $(this).modifiedModal({
                url: bu + 'jobNotes/' + this.id + '?is_review=1',
                title: 'Notes for <strong>' + $(this).attr('data-title') + '</strong>'
            });
        });
        $('.btn-add').click(function(){
            $(this).modifiedModal({
                url: bu + 'jobNotes/' + this.id,
                title: 'Add Notes for <strong>' + $(this).attr('data-title') + '</strong>'
            });
        });
    })
</script>