<table class="table table-responsive table-colored-header">
    <thead>
    <tr>
        <!-- <th class="b"></th> -->
        <th>Date Received</th>
        <th class="data-column">Policy No.</th>
        <th class="data-column">Client Ref.</th>
        <th class="data-column">Our Ref.</th>
        <th style="width: 20%;">Job Name</th>
        <th class="data-column">Status</th>
        <th class="data-column">Job Type</th>
        <th class="data-column">Inspector</th>
        <th class="data-column">Inspector<br/>to visit</th>
        <th class="data-column">Report Sent</th>
        <th style="width: 10%" >Notes</th>
        <th style="width: 3%">Report</th>
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
            <tr id="a">
                <!-- <td style="cursor:pointer" id="<?php echo $v->id;?>" class="a b"> <span class="glyphicon glyphicon-th-list" id="b"></span></td> -->
                <td style="cursor:pointer" id="<?php echo $v->id;?>" class="a"><span class="glyphicon glyphicon-list data-column2" style="padding-right: 10px;"></span><?php echo $v->date_entered;?></td>
                <td style="cursor:pointer" class="a data-column" id="<?php echo $v->id;?>"><?php echo $v->policy_number;?></td>
                <td style="cursor:pointer" class="white-space a data-column" id="<?php echo $v->id;?>"><?php echo $v->client_ref;?></td>
                <td style="cursor:pointer" class="white-space a data-column"><?php echo $v->job_ref;?></td>
                <td class="white-space job-name" id="<?php echo $v->id;?>" data-title="<?php echo $v->project_name;?>">
                    <?php echo $v->project_name;?>
                    <div class="job-details" id="form_<?php echo $v->id;?>">
                        <table class="table-details" style="width: 100%;">
                            <tr>
                                <th colspan="4"><center>Job Details</center></th>
                            </tr>
                            <tr>
                                <td id="contentholder">Owner:</td>
                                <td><?php echo $v->owner;?></td>
                            </tr>
                            <tr>
                                <td>Owner Email:</td>
                                <td><?php echo $v->owner_email;?></td>
                            </tr>
                            <tr>
                                <td>Mobile:</td>
                                <td><?php echo $v->owner_mobile;?></td>
                            </tr>
                            <tr>
                                <td>Phone:</td>
                                <td><?php echo $v->owner_phone;?></td>
                            </tr>
                            <tr>
                                <td>Insured Name:</td>
                                <td><?php echo $v->insured_name;?></td>
                            </tr>
                            <tr>
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
                            </tr>
                            <tr>
                                <td >Property Status:</td>
                                <td><?php echo $v->property_status;?></td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td class="data-column">
                    <strong data-toggle="tooltip" data-placement="right" title="<?php echo $v->job_status;?>" ><?php echo $v->job_status_code;?></strong>
                </td>
                <td class="data-column">
                    <strong data-toggle="tooltip" data-placement="right" title="<?php echo $v->job_type;?>"><?php echo $v->job_type_code;?></strong>
                </td>
                <td class="data-column">
                    <strong data-toggle="tooltip" data-placement="right" title="<?php echo $v->inspector_name;?>"><?php echo $acronym;?></strong>
                </td>
                <td class="white-space data-column"><?php echo $v->inspection_time;?></td>
                <td class="white-space data-column"><?php echo $v->date_completed;?></td>
                <td class="notes">
                    <?php
                    echo '<a href="#" class="btn-review btn btn-sm btn-primary" id="' . $v->id . '" data-title="' . $v->project_name . '" style="padding: 2px 10px;;">Review/Add</a>&nbsp;';
                    ?>
                </td>
                <td>
                    <?php
                    if($v->report_file){
                        ?>
                        <a href="<?php echo base_url('inspectionReport?r=1&id=' . $v->id)?>">view</a>
                        <?php
                    }
                    ?>
                    <td><a href="<?php echo base_url('jobRegistration?id=' . $v->id)?>">edit</a></td>
            </tr>
            <tr >
                <td  id="a<?php echo $v->id;?>" class="columnHide" style="text-align: left">
                    <strong data-toggle="tooltip" data-placement="right" title="<?php echo $v->job_status;?>">Policy Number:<br></strong><?php echo $v->policy_number;?><br><br>
                    <strong data-toggle="tooltip" data-placement="right" title="<?php echo $v->job_status;?>">Client Reference:<br></strong><?php echo $v->client_ref;?><br><br>
                    <strong data-toggle="tooltip" data-placement="right" title="<?php echo $v->job_status;?>">Status:<br><?php echo $v->job_status_code;?></strong><br><br>
                    <strong data-toggle="tooltip" data-placement="right" title="<?php echo $v->job_type;?>">Job type:<br><?php echo $v->job_type;?></strong><br><br>
                    <strong data-toggle="tooltip" data-placement="right" title="<?php echo $v->inspector_name;?>">Inspector:<br><?php echo $v->inspector_name;?></strong><br>
                    <?php echo $v->inspection_time;?>
                </td>
            </tr>
        <?php
        }
    }
    else{
        ?>
        <tr>
            <td colspan="13">No data was found.</td>
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
        )
        .click(
            function(){
                console.log('working');
                var ele = $('.job-details').html();
                $(this).modifiedModal({
                html: ele,
                title: 'Job Details for <strong>' + $(this).attr('data-title') + '</strong>',
                
            });
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
                // url: bu + 'jobNotes/' + this.id,
                title: 'Add Notes for <strong>' + $(this).attr('data-title') + '</strong>'
            });
        });
        $('.a').click(function() {
         var trid = $(this).closest('td').attr('id');
         // alert(trid);
         // $(trid).show();
         $('#a'+ trid).toggle();
        });
    })
</script>   
