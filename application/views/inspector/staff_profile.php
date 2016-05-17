<table class="personal-div">
	<tr>
		<td>
			<table class="personal-table">
				<?php
				if(count($userInfo)>0){
					foreach($userInfo as $k=>$v){
						?>
                        <thead>
						<tr>
							<th colspan="2">Personal Info</th>
						</tr>
                        </thead>
                        <tbody>
						<tr>
							<td>Name:</td>
							<td><?php echo $v->FName.' '.$v->LName;?></td>
						</tr>
						<tr>
							<td>Email Address:</td>
							<td><?php echo $v->EmailAddress;?></td>
						</tr>
						<tr>
							<td>Username:</td>
							<td><?php echo $v->Username;?></td>
						</tr>
                        <tr>
                            <td>Address:</td>
                            <td><?php echo $v->Address;?></td>
                        </tr>
						<tr>
							<td>Date Register:</td>
							<td><?php echo date('j F Y',strtotime($v->DateRegistered));?></td>
						</tr>
						<tr>
							<td colspan="2" style="text-align: right">
								<a href="#" class="m-btn green edit-btn" id="<?php echo $v->ID;?>" style="font-weight: normal">Edit Profile</a>
							</td>
						</tr>
                        </tbody>
					<?php
					}
				}
				?>
			</table>
		</td>
		<td style="text-align: right">
            <?php
            if($this->session->userdata('userAccountType') == 4):
            ?>
                <table class="job-table">
                    <thead>
                    <tr>
                        <th colspan="2">Job Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>No. of Jobs</td>
                        <td>
                            <?php echo $jobNumber;?>
                            ( <a href="<?php echo base_url().'jobsAllocation'?>">View</a> )
                        </td>
                    </tr>
                    <tr>
                        <td>Pending Jobs</td>
                        <td>
                            <?php echo $pendingJobs;?>
                            ( <a href="<?php echo base_url().'jobsAllocation'?>">View</a> )
                        </td>
                    </tr>
                    </tbody>
                </table>
            <?php
            endif
            ?>
		</td>
	</tr>
</table>
<style>
    .personal-table{
        border: 1px solid #000000;
        white-space: nowrap!important;
        width: 500px;
        margin: 20px 0;
    }
    .personal-table > tbody > tr > td{
        font-weight: normal;
        text-align: left;
        padding: 10px;
    }
    .personal-table > thead > tr > th,
    .job-table > thead > tr > th{
        background: #484848;
        border-bottom: 1px solid #000000;
        color: #ffffff;
        text-transform: uppercase;
        padding: 5px;
    }
    .personal-table > tbody > tr > td:first-child,
    .job-table > tbody > tr > td:first-child{
        font-weight: bold;
    }
    .personal-div{
        width: 98%;
    }
    .job-table{
        width: 100%;
        white-space: nowrap;
        margin: 20px 0;
        border: 1px solid #000000;
    }
    .job-table > tbody > tr > td{
        padding: 5px;
        font-weight: normal;
        text-align: left;
    }
</style>
<script>
    $(function(e){
        $('.edit-btn').click(function(e){
            e.preventDefault();
            $(this).newForm.addNewForm({
                title:'Edit Profile',
                url: '<?php echo base_url().'editProfileInfo/'?>' + this.id,
                toFind:'.staff-edit-profile'
            });
        });
    })
</script>