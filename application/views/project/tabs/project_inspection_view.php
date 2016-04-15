<div class="container-fluid">
    <div class="row" style="font-size: 12px;">
        <div class="col-sm-4 well well-sm" >
            <div class="form-group">
                <label for="exampleInputEmail1">Roof Type:</label>
                <?php
                echo form_dropdown('roof_type_id',$drop_down[1],@$job_inspection->roof_type_id,'class="form-control input-sm required"');
                ?>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Roof Design:</label>
                <?php echo form_dropdown('roof_design_id',$drop_down[6],@$job_inspection->roof_design_id,'class="form-control input-sm required"');?>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Roof Pitch:</label>
                <input type="text" name="roof_pitch" class="form-control input-sm required" placeholder="Roof Pitch" value="<?php echo @$job_inspection->roof_pitch?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Roof Age:</label>
                <input type="text" name="roof_age" class="form-control input-sm required" placeholder="Roof Age" value="<?php echo @$job_inspection->roof_age?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Roof Cladding Finish:</label>
                <?php echo form_dropdown('roof_cladding_finish_id',$drop_down[2],@$job_inspection->roof_cladding_finish_id,'class="form-control input-sm required"');?>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Roof Cladding Condition:</label>
                <?php echo form_dropdown('roof_cladding_condition_id',$drop_down[7],@$job_inspection->roof_cladding_condition_id,'class="form-control input-sm required"');?>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Fascia Type:</label>
                <?php echo form_dropdown('fascia_type_id',$drop_down[3],@$job_inspection->fascia_type_id,'class="form-control input-sm required"');?>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Flashing Type:</label>
                <?php echo form_dropdown('flashing_type_id',$drop_down[8],@$job_inspection->flashing_type_id,'class="form-control input-sm required"');?>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Spouting Type:</label>
                <?php echo form_dropdown('spouting_type_id',$drop_down[4],@$job_inspection->spouting_type_id,'class="form-control input-sm required"');?>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Insulation:</label>
                <?php echo form_dropdown('insulation_id',$drop_down[5],@$job_inspection->insulation_id,'class="form-control input-sm required"');?>
            </div>
        </div>
        <div class="col-sm-8 well well-sm">
            <div class="form-group">
                <label for="exampleInputEmail1">Client Discussions:</label>
                <textarea class="form-control input-sm required" name="client_discussions" placeholder="Client Discussions" rows="5"><?php echo @$job_inspection->client_discussions?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Damage Sighted:</label>
                <textarea class="form-control input-sm required" name="damage_sighted" placeholder="Damage Sighted" rows="5"><?php echo @$job_inspection->damage_sighted?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Repair Strategy:</label>
                <textarea class="form-control input-sm required" name="repair_strategy" placeholder="Repair Strategy" rows="5"><?php echo @$job_inspection->repair_strategy?></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Overview:</label>
                <textarea class="form-control input-sm required" name="overview" placeholder="Overview" rows="11"><?php echo @$job_inspection->overview?></textarea>
            </div>
        </div>
    </div>
</div>