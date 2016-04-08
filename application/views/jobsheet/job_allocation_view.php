<style>
	.pending-msg{
		position: absolute;
		margin: -3px -80px 0;
		border: 2px solid #e2e2e2 !important;
		border-radius: 15px;
		padding: 2px 4px;
		font-size: 12px;
	}
    .allocation-div{
        width: 100%;
    }
    .job-details{
        margin: 0 0 5px 2px;
        font-size: 12px;
    }
    .job-details > tbody > tr > td{
        padding: 5px;
        border: 1px solid #000000;
    }
    .job-details > tbody > tr > td:nth-child(even){
        background: #484848;
        color: #ffffff;
        padding: 5px 10px;
    }
    .table-colored-header > thead > tr > th{
        padding: 5px!important;
    }
</style>
<div class="allocation-div">
    <table class="job-details">
        <tr>
            <td>Jobs Done: </td>
            <td>
                <?php echo $jobDone;?>
            </td>
            <td>Pending Jobs: </td>
            <td>
                <?php echo $pendingJobs;?>
            </td>
        </tr>
    </table>
    <table class="table table-colored-header">
        <thead>
        <tr>
            <th rowspan="2" style="width: 10%;">Date Entered</th>
            <th rowspan="2" style="width: 10%;">Inspection Date</th>
            <th rowspan="2">Client Name</th>
            <th rowspan="2">Job Name</th>
            <th rowspan="2">Job Type</th>
            <th rowspan="2" style="width: 15%;">Inspector</th>
            <th colspan="2" style="width: 25%;">Time</th>
            <th rowspan="2">&nbsp;</th>
        </tr>
        <tr>
            <th>Start</th>
            <th>End</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(count($jobAllocation)>0){
            foreach($jobAllocation as $k=>$v){
                $is_valid_date = ValidateDate($v->InspectionDate,'Y-m-d H:i:s');
                $day = $is_valid_date ? floor((strtotime($v->InspectionDate) - strtotime(date('Y-m-d'))) / (60 * 60 * 24)) : 1;
                $pending = '';
                $color = '';
                if($is_valid_date && !$v->IsDone && $day < 0){
                    $color = '#ff0000';
                    $pending = '<span class="pending-msg" style="background: #ff0000;"> Over Due</span>';
                }else if($is_valid_date && !$v->IsDone && $day > 0){
                    $color = '#FF8B29';
                    $pending = '<span class="pending-msg" style="background: #FF8B29;">'.$day. ( $day > 1 ? ' days' : ' day') . ' left</span>';
                }else if($v->IsDone){
                    $color = '#228B22';
                }
                ?>
                <tr style="<?php echo $color ? 'background:'.$color.';color: #ffffff;' : '';?>;">
                    <td>
                        <?php
                        echo $pending;
                        echo ValidateDate($v->date_entered,'Y-m-d H:i:s') ? date('j M Y',strtotime($v->date_entered)) : '&nbsp;'
                        ?>
                    </td>
                    <td>
                        <?php
                        echo ValidateDate($v->InspectionDate,'Y-m-d H:i:s') ? date('j M Y',strtotime($v->InspectionDate)) : '&nbsp;'
                        ?>
                    </td>
                    <td style="text-align: left;">
                        <?php
                        echo $v->insured_name;
                        ?>
                    </td>
                    <td style="text-align: left;">
                        <?php
                        echo $v->project_name;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $v->job_type_specs;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $v->job_inspector;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $v->InspectionTime;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo $v->InspectionTimeEnd;
                        ?>
                    </td>
                    <td>
                        <?php
                        echo '<a href="#" class="allocate-btn btn btn-sm btn-primary" id="' . $v->id . '" style="padding: 2px 5px;">'. ($v->user_assignment_inspector ? 'Re-Allocate' : 'Allocate') .'</a>';
                        ?>
                    </td>
                </tr>
            <?php
            }
        }else{
            ?>
            <tr>
                <td colspan="8">No data was found.</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>
<script>
    $(function(e){
        $('.allocate-btn').click(function(){
            $(this).modifiedModal({
                url: bu + 'jobsAllocation/' + this.id,
                title: 'Allocate Job'
            });
        });
    });
</script>