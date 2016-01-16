<?php
echo form_open('');
?>
<div class="staff-edit-profile">
    <div>
        <?php
        if(count($profile_info)>0):
            foreach($profile_info as $v):
                ?>
                <div class="sixteen_column section">
                    <div class="four column">
                        <div class="column_content">
                            <label>First Name: </label>
                            <input type="text" id="firstName" name="FName" class="required" placeholder="FirstName" value="<?php echo $v->FName;?>"/>
                        </div>
                    </div>
                    <div class="four column">
                        <div class="column_content">
                            <label>Last Name: </label>
                            <input type="text" id="lastName" name="LName" class="required" placeholder="LastName"  value="<?php echo $v->LName;?>" />
                        </div>
                    </div>
                </div>
                <div class="sixteen_column section">
                    <div class="four column">
                        <div class="column_content">
                            <label>Email Address: </label>
                            <input type="text" name="EmailAddress" placeholder="Email Address" class="required" value="<?php echo $v->EmailAddress; ?>"/>
                        </div>
                    </div>
                    <div class="four column">
                        <div class="column_content">
                            <label>Username: </label>
                            <input type="text" class="required" name="Username" class="required" placeholder="Username" value="<?php echo $v->Username;?>"/>
                        </div>
                    </div>
                </div>
                <div class="sixteen_column section">
                    <div class="eight column">
                        <div class="column_content">
                            <label>Address: </label>
                            <input type="text" name="Address" placeholder="Password" class="required" value="<?php echo $v->Address;?>"/>
                        </div>
                    </div>
                </div>
                <div class="sixteen_column section">
                    <div class="four column">
                        <div class="column_content">
                            <label>Password: </label>
                            <input type="password" name="Password" class="required" placeholder="Password" value="<?php echo $v->Password; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="sep-dashed"></div>
                <div style=" padding: 0 10px 10px 0">
                    <div style="text-align: right;">
                        <input type="submit" name="submit" value="Save" class="m-btn green save_edit" style="width: 15%">
                        <input type="button" name="close" value="Close" class="m-btn green closeBtn" style="width: 15%">
                    </div>
                </div>
            <?php
            endforeach;
        endif;
        ?>
    </div>
</div>
<?php
echo form_close();
?>
<style>
    .staff-edit-profile{
        width: 400px;
    }
    .column_content{
        text-align: left!important;
    }
    .column_content > label{
        font-weight: bold;
    }
</style>
<script>
    $(function(e){
        $('.closeBtn').click(function(e){
            $(this).newForm.forceClose();
        });
        $('.save_edit').click(function(e){
            var isEmpty = false;
            $('.required').each(function(){
                if(!$(this).val()){
                    $(this).css({
                       border:'1px solid #ff0000'
                    });
                    isEmpty = true;
                }
            });
            if(isEmpty){
                e.preventDefault();
            }
        });
    });
</script>