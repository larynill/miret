<<<<<<< HEAD
<div class="col-sm-12" >
    <?php echo $_pageTitle == 'My Diary' && $accountType == 4 ? '<div class="col-sm-5">' : '';?>
        <h2 id="page-heading">
            <?php echo $_pageTitle;
            if($_pageTitle == 'Client Profile Information'){?>
                | <a href="<?php echo base_url().'equipment';?>" style="font-size: 18px;">To Client and Equipment Register</a>
            <?php }
            if($_pageTitle == 'Job Done'){
                echo ' for <span style="color:#1e90ff;">'.$whatMonth.'</span>';
            }
            ?>
        </h2>
    <?php echo $_pageTitle == 'My Diary' && $accountType == 4 ? '</div>' : '';?>
    <?php
    if($_pageTitle == 'My Diary' && $this->session->userdata('userAccountType') == 4){
    ?>
        <div class="form-horizontal">
            <div class="col-sm-7"><br/><br/>
                <div class="form-group text-right">
                    <label class="control-label col-sm-4" for="search-jobs">Search Jobs:</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control input-sm" id="search-jobs" placeholder="Client">
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-success" type="button">Go</button>
                       </span>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
    ?>
=======
<div class="grid_16" >
    <h2 id="page-heading">
		<?php echo $_pageTitle;
			if($_pageTitle == 'Client Profile Information'){?>
				| <a href="<?php echo base_url().'equipment';?>" style="font-size: 18px;">To Client and Equipment Register</a>
			<?php }
			if($_pageTitle == 'My Diary' && $this->session->userdata('userAccountType') == 4){
			?>
				<span style="float: right;font-size: 13px;width: 30%;padding: 10px 0;white-space: nowrap;">
					Search Jobs: <input type="text" name="search" placeholder="Client" style="width: 60%;">
					<input type="submit" name="search" value="Go" class="m-btn green" style="width: 30px;padding: 5px 10px;">
				</span>
			<?php
			}
			if($_pageTitle == 'Job Done'){
				echo ' for <span style="color:#1e90ff;">'.$whatMonth.'</span>';
			}
		?>
	</h2>

>>>>>>> 38adecbc82bdc07c40b0e1f0994baccc4a3c49f9
</div>
<div class="clear"></div>

