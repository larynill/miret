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

</div>
<div class="clear"></div>

