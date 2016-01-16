<?php
echo form_open('');
?>
<div class="client-edit-profile">
    <div>
        <?php
        if(count($client_data)>0):
            foreach($client_data as $v):
            ?>
            <div class="sixteen_column section">
                <div class="four column">
                    <div class="column_content">
                        <label>First Name: </label>
                        <input type="text" id="firstName" name="FirstName" class="required" title="FirstName" value="<?php echo $v->FirstName;?>"/>
                    </div>
                </div>
                <div class="four column">
                    <div class="column_content">
                        <label>Last Name: </label>
                        <input type="text" id="lastName" name="LastName" class="required" title="LastName"  value="<?php echo $v->LastName;?>" />
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Company Name: </label>
                        <input type="text" class="required" name="CompanyName" class="required" title="CompanyName" value="<?php echo $v->CompanyName;?>"/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="two column">
                    <div class="column_content">
                        <label>Physical Address: </label>
                        <input type="text" name="PhysicalAddress[]" placeholder="Street Number" class="" value="<?php echo $v->street; ?>"/>
                    </div>
                </div>
                <div class="four column">
                    <div class="column_content">
                        <label>&nbsp</label>
                        <input type="text" name="PhysicalAddress[]" placeholder="Street Name" class="" value="<?php echo $v->street_name; ?>"/>
                    </div>
                </div>
                <div class="five column">
                    <div class="column_content">
                        <label>&nbsp</label>
                        <input type="text" name="PhysicalAddress[]" placeholder="Suburb" class="" value="<?php echo $v->suburb; ?>"/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="four column">
                    <div class="column_content">
                        <label>City: </label>
                        <?php
                        echo form_dropdown('PhysicalAddress[]', $_city, $v->city_id);
                        ?>
                    </div>
                </div>
                <div class="four column">
                    <div class="column_content">
                        <label>Country: </label>
                        <?php
                        echo form_dropdown('PhysicalAddress[]', $_country, $v->country_id);
                        ?>
                    </div>
                </div>
                <div class="two column">
                    <div class="column_content">
                        <label>ZIP: </label>
                        <input type="text" name="PhysicalAddress[]" value="<?php echo $v->zip_code;?>" class="numberOnly" />
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Postal Address </label>
                        <input type="text" name="PostalAdress" class="" value="<?php echo $v->PostalAdress;?>"/>
                    </div>
                </div>
                <div class="two column">
                    <div class="column_content">
                        <label>Work Phone: </label>
                        <input type="text" name="WorkPhone[]" value="<?php echo $v->area_code;?>" placeholder="area code" class="required numberOnly" title="Work Phone"/>
                    </div>
                </div>
                <div class="two column">
                    <div class="column_content">
                        <label>&nbsp </label>
                        <input type="text" name="WorkPhone[]" value="<?php echo $v->number;?>" placeholder="number" class="required numberOnly" title="Work Phone"/>
                    </div>
                </div>
                <div class="two column">
                    <div class="column_content">
                        <label>&nbsp </label>
                        <input type="text" name="WorkPhone[]"value="<?php echo $v->ext;?>" placeholder="extension " class="required numberOnly" title="Work Phone"/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Email: </label>
                        <input type="text" name="Email" class="" value="<?php echo $v->Email; ?>"/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Mobile Phone: </label>
                        <input type="text" name="MobilePhone" value="<?php echo $v->MobilePhone; ?>" class="required numberOnly" title="Mobile Phone"/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Person In Charge: </label>
                        <input type="text" name="PersonInCharge" value="<?php echo $v->ContactPerson; ?>" class=""/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Fax Number: </label>
                        <input type="text" name="FaxNumber" value="<?php echo $v->FaxNumber; ?>" class="numberOnly "/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Last Update: </label>
                        <input type="text" class="date_picker" value="<?php echo $v->LastUpdate != '0000-00-00' ? date('j F Y',strtotime($v->LastUpdate)) : date('j F Y'); ?>" name="LastUpdate" class="required"/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Our Area Designation: </label>
                        <?php echo form_dropdown('AreaDesignationID', $_designation_area, $v->AreaDesignationID, 'class="required"'); ?>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="sixteen column ">
                    <div class="column_content">
                        <label>Notes: </label>
                        <textarea rows="8" name="Notes" class="" style="height: 50px;"><?php echo $v->Notes; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="sep-dashed"></div>
            <div style=" padding: 0 10px 10px 0">
                <div style="text-align: right;">
                    <input type="submit" name="submit" value="Save" class="m-btn green save_edit" style="width: 7%">
                    <input type="button" name="close" value="Close" class="m-btn green closeBtn" style="width: 7%">
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
    .client-edit-profile{
        width: 800px;
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
       $('.date_picker').datepicker({
           dateFormat:'dd MM yy'
       });
       $('.numberOnly').numberOnly();
    });
</script>