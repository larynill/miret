<script language="javascript">
	$(function(event){
		var cutoffClass = $('.cutoffClass');
		cutoffClass.change(function(e){
			var forOthers = $('.forOthers');
			if($(this).val() == 5){
				forOthers.append($('<label>Others: </label><input type="text" id="" name="Others" class="required"/>'));
			}else{
				forOthers.html('');
			}
		});
	});
</script>
<div class="clear"></div>
<h5 style=" margin-bottom: 10px">
    <?php
    if(isset($_clientName)){
        echo 'Client Name: ' . $_clientName;
    }
    ?>

</h5>
<fieldset>
    <legend>Accounting Information</legend>
    <div class="sixteen_column section">
        <div class="eight column">
            <div class="column_content">
                <label>Contact Person: </label>
                <input type="text" id="" name="ContactPerson" class="required"/>
            </div>
        </div>
        <div class="eight column">
			<div class="two column">
				<div class="column_content">
					<label>Tel. No.: </label>
					<input type="text" name="TelNumber[]" placeholder="number" class="required numberOnly" title="Tel. No."/>
				</div>
			</div>
			<div class="two column">
				<div class="column_content">
					<label>&nbsp </label>
					<input type="text" name="Extension" placeholder="extension " class="required numberOnly" title="Tel. No."/>
				</div>
			</div>
        </div>
    </div>
	<div class="sixteen_column section">
		<div class="two column">
			<div class="column_content">
				<label>Email Address: </label>
				<input type="text" id="" name="Email" class="required"/>
			</div>
		</div>
		<div class="two column">
			<div class="column_content">
				<label>Invoices: </label>
				<input type="text" name="Invoice" class="required"/>
			</div>
		</div>
		<div class="two column">
			<div class="column_content">
				<label>Cut Off Date: </label>
				<?php echo form_dropdown('CutOff',$cutoff,'','class="cutoffClass required"')?>
			</div>
		</div>
		<div class="two column">
			<div class="column_content">
				<span class="forOthers"></span>
			</div>
		</div>
	</div>

    <!--<div class="sixteen_column section">
        <div class="sixteen column">
            <div class="column_content">
                <label>Email Address: </label>
                <input type="text" id="" name="" class="required"/>
            </div>
        </div>
    </div>
    <div class="sixteen_column section">
        <div class="sixteen column">
            <div class="column_content">
                <label>Account Address: </label>
                <input type="text" id="" name="" class="required"/>
            </div>
        </div>
    </div>
    <div class="sixteen_column section">
        <div class="sixteen column">
            <div class="column_content">
                <label>Physical Address: </label>
                <input type="text" id="" name="" class="required"/>
            </div>
        </div>
    </div>
    <div class="sixteen_column section">
        <div class="sixteen column">
            <div class="column_content">
                <label>Postal Address: </label>
                <input type="text" id="" name="" class="required"/>
            </div>
        </div>
    </div>-->
</fieldset>