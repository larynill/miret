<?php
echo form_open('','class="form-horizontal"');
$id = $this->uri->segment(2);
?>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label col-sm-4" for="franchise_name">Franchise Name:</label>
                <div class="col-sm-8">
                    <input type="text" name="name" class="form-control input-sm" id="franchise_name" value="<?php echo @$franchise_list->name?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="franchise_code">Franchise Code:</label>
                <div class="col-sm-8">
                    <input type="text" name="franchise_code" class="form-control input-sm" id="franchise_code" value="<?php echo @$franchise_list->franchise_code?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="pobox">P.O. Box:</label>
                <div class="col-sm-8">
                    <input type="text" name="pobox" class="form-control input-sm" id="pobox" value="<?php echo @$franchise_list->pobox?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="street_address_one">Street Address (1):</label>
                <div class="col-sm-8">
                    <input type="text" name="street_address_one" class="form-control input-sm" id="street_address_one" value="<?php echo @$franchise_list->street_address_one?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="street_address_2">Street Address (2):</label>
                <div class="col-sm-8">
                    <input type="text" name="street_address_two" class="form-control input-sm" id="street_address_two" value="<?php echo @$franchise_list->street_address_two?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="suburb">Suburb:</label>
                <div class="col-sm-8">
                    <input type="text" name="suburb" class="form-control input-sm" id="suburb" value="<?php echo @$franchise_list->suburb?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="postal_code">Postal Code:</label>
                <div class="col-sm-8">
                    <input type="text" name="postal_code" class="form-control input-sm" id="postal_code" value="<?php echo @$franchise_list->postal_code?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="city">Town/City:</label>
                <div class="col-sm-8">
                    <input type="text" name="city" class="form-control input-sm" id="city" value="<?php echo @$franchise_list->city?>">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label col-sm-4" for="email">Email:</label>
                <div class="col-sm-8">
                    <input type="text" name="email" class="form-control input-sm" id="email" value="<?php echo @$franchise_list->email?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="mobile">Mobile:</label>
                <div class="col-sm-8">
                    <input type="text" name="mobile" class="form-control input-sm" id="mobile" value="<?php echo @$franchise_list->mobile?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="phone">Tel.:</label>
                <div class="col-sm-8">
                    <input type="text" name="phone" class="form-control input-sm" id="phone" value="<?php echo @$franchise_list->phone?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="fax">Fax:</label>
                <div class="col-sm-8">
                    <input type="text" name="fax" class="form-control input-sm" id="fax" value="<?php echo @$franchise_list->fax?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="ird_num">IRD Num.:</label>
                <div class="col-sm-8">
                    <input type="text" name="ird_num" class="form-control input-sm" id="ird_num" value="<?php echo @$franchise_list->ird_num?>">
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <label class="control-label col-sm-4" for="franchise_owner">Franchise Owner:</label>
                <div class="col-sm-8">
                    <input type="text" name="franchise_owner" class="form-control input-sm" id="franchise_owner" value="<?php echo @$franchise_list->franchise_owner?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="franchise_email">Email:</label>
                <div class="col-sm-8">
                    <input type="text" name="franchise_email" class="form-control input-sm" id="franchise_email" value="<?php echo @$franchise_list->franchise_email?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="franchise_phone">Phone:</label>
                <div class="col-sm-8">
                    <input type="text" name="franchise_phone" class="form-control input-sm" id="franchise_phone" value="<?php echo @$franchise_list->franchise_phone?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="franchise_mobile">Mobile:</label>
                <div class="col-sm-8">
                    <input type="text" name="franchise_mobile" class="form-control input-sm" id="franchise_mobile" value="<?php echo @$franchise_list->franchise_mobile?>">
                </div>
            </div>
            <?php
            if($id){
                ?>
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-4">
                        <label class="inline-checkbox">
                            <input type="checkbox" name="is_archive" value="1" <?php echo @$franchise_list->is_archive ? 'checked' : ''?>> Archive?
                        </label>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="col-sm-12">
        <div class="pull-right">
            <button type="submit" name="submit" class="btn btn-sm btn-primary">Submit</button>
            <button class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
        </div>
    </div>
</div>
<?php
echo form_close();
?>
<script>
    $(function(){
        var is_branch = $('input[name="is_branch"]');
        var branch_form = $('.for-branch-form');
        var Franchise_form = $('.for-Franchise-form');
        var check_if_branch = function(_this){
            console.log(_this.val());
            if(_this.val() != 1){
                branch_form.css({
                    'display':'none'
                });
                Franchise_form.css({
                    'display':'inline'
                });
            }
            else{
                branch_form.css({
                    'display':'inline'
                });
                Franchise_form.css({
                    'display':'none'
                });
            }
        };
        check_if_branch($('input[name="is_branch"]:checked'));
        is_branch.change(function(){
            check_if_branch($(this));
        });
    });
</script>