<div class="col-sm-12" >
    <?php
    $has_edit_reg = strpos($_pageTitle, 'Job Registration - Edit') !== false ? 1 : 0;
    $has_reg_only = $_pageTitle == 'Job Registration' ? 1 : 0;
    echo $_pageTitle == 'My Diary' && $accountType == 4 ? '<div class="col-sm-5">' : '';
    echo $has_reg_only ? '<div class="row"><div class="col-sm-3">' : ($has_edit_reg ? '<div class="row"><div class="col-sm-9">' : '');
    ?>
        <h2 id="page-heading" style="white-space: nowrap!important;">
            <?php echo $_pageTitle;
            if($_pageTitle == 'Client Profile Information'){?>
                | <a href="<?php echo base_url().'equipment';?>" style="font-size: 18px;">To Client and Equipment Register</a>
            <?php }
            else if($_pageTitle == 'Job Done'){
                echo ' for <span style="color:#1e90ff;">'.$whatMonth.'</span>';
            }
            ?>
        </h2>
    <?php
    echo $has_edit_reg || $has_reg_only ? '</div>' : '';
    if($has_edit_reg || $has_reg_only){
        $_disabled =  $has_edit_reg ? 'disabled="disabled"' : '';
        $_inspection_style = !@$job->job_type_id ? 'style="margin:20px 0 0;"' : 'style="margin:-5px 0 0;"';
        $_job_style = !@$job->job_type_id ? 'style="margin:20px 0 0;"' : 'style="margin:5px 0 0;"';
        ?>
        <div class="col-sm-2">
            <div class="form-horizontal">
                <?php echo form_dropdown('inspection_type_id',$drop_down[12],@$job->inspection_type_id,'class="form-control input-sm required job_type_dp"  '. $_inspection_style .' '. $_disabled);?>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-horizontal">
                <?php echo form_dropdown('job_type_id',$drop_down[10],@$job->job_type_id,'class="form-control input-sm required job_type_dp" '. $_job_style .' '. $_disabled);?>
            </div>
        </div>
        <?php
        if($accountType != 4 && $has_edit_reg){
            ?>
            <div class="col-sm-1" style="margin:-15px 0 0;">
                <input type="button" class="btn btn-sm btn-primary unlock-btn is-lock" style="font-size: 11px;" value="Unlock">
            </div>
            <?php
        }
    }
    echo $_pageTitle == 'Job Registration' ? '</div>' : '';
    echo $_pageTitle == 'My Diary' && $accountType == 4 ? '</div>' : '';
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
</div>
<div class="clear"></div>

