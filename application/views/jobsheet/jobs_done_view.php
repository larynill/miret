<script>
	$(function(e){
		var jobName = $('.job-name');
		var equipName = $('.equip-name-table');
		jobName.hover(
			function(e){
				equipName.each(function(e){
					$(this).css({
						'display':'none'
					});
				});
				$('#form_' + this.id).css({
					'display':'inline'
				});
			},
			function(e){
				equipName.each(function(e){
					$(this).css({
						'display':'none'
					});
				});
			}
		)
	});
</script>
<style>
	.equip-name-table{
		white-space: nowrap;
		position: absolute;
		width: 20%;
		background: #b7b7b7;
		margin: -5px 0 0 20px;
		display: none;
	}
	.job-name{
		cursor: pointer;
	}
</style>
<?php
echo form_open('');
?>
<div class="row">
    <div class="form-group">
        <div class="col-sm-2">
            <?php
            echo form_dropdown('year', $year, date('Y'),'class="form-control input-sm year"');
            ?>
        </div>
        <div class="col-sm-2">
            <?php
            echo form_dropdown('month', $months, date('m'),'class="form-control input-sm month"');
            ?>
        </div>
        <div class="col-sm-1">
            <button type="submit" name="search" value="Go" class="btn btn-sm btn-primary submit">Go</button>
        </div>
    </div>
</div><br/>

<table class="table table-colored-header">
    <thead>
        <tr>
            <th style="width: 40%">Job Name</th>
            <th style="width: 15%">Job No.</th>
            <th style="width: 15%">Completed Date</th>
            <th style="width: 15%">Inspector</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if(count($job_done)>0){
        foreach($job_done as $k=>$v){
            ?>
            <tr>
                <td style="text-align: left!important;white-space: nowrap;" class="job-name" id="<?php echo $v->ID;?>">
                    <?php echo $v->CompanyName?>
                    <table class="equip-name-table" id="form_<?php echo $v->ID;?>">
                        <tr>
                            <td style="background: #000000;color: white;padding: 2px;">Equipment</td>
                        </tr>
                        <?php
                        if(count($v->Equipment)>0){
                            foreach($v->Equipment as $ek=>$ev){
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $ek+1 .'. '.$ev->PlantDescription;?>
                                    </td>
                                </tr>
                            <?php }
                        }
                        ?>
                    </table>
                </td>
                <td><?php echo $v->JobNumber?></td>
                <td><?php echo date('j F Y',strtotime($v->InspectionDate))?></td>
                <td><?php echo $v->Inspector?></td>
            </tr>
        <?php }
    }else{ ?>
        <tr>
            <td colspan="4">No data was found.</td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>
<?php
echo form_close();
?>