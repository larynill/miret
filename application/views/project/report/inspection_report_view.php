<link href="<?php echo base_url().'plugins/css/fileinput.min.css';?>" rel="stylesheet">
<script src="<?php echo base_url() . "plugins/js/fileinput.min.js" ?>"></script>
<?php
echo form_open_multipart('','class="form-horizontal"');
$elevation = array(
    'east' => 'east',
    'west' => 'west',
    'north' => 'north',
    'south' => 'south'
);
ksort($elevation);
$side = array(
    'eastern' => 'eastern',
    'middle' => 'middle',
    'western' => 'western',
    'northern' => 'northern',
    'southern' => 'southern'
);
ksort($side);
$_facing = array(
    'north' => 'north',
    'south' => 'south',
    'east' => 'east',
    'west' => 'west',
    'south-east' => 'south-east',
    'north-east' => 'north-east',
    'south-west' => 'south-west',
    'north-west' => 'north-west',
);

ksort($_facing);
$_located = array(
    'flat' => 'flat',
    'hilly' => 'hilly'
);
ksort($_located);

$exposure = array(
    'high' => 'high',
    'low' => 'low'
);
ksort($exposure);

$condition = array(
    'tidy' => 'tidy',
    'reasonable' => 'reasonable',
    'good' => 'good'
);
ksort($condition);

$property = array(
    'rental' => 'rental',
    'own' => 'own'
);
ksort($property);

$dwelling = array(
    'metal corrugated' => 'metal corrugated'
);
ksort($dwelling);

$finish = array(
    'block & plaster' => 'block & plaster'
);
ksort($finish);

$foundation = array(
    'partially' => 'partially',
    'fully' => 'fully',
    'mixture' => 'mixture'
);
ksort($foundation);

$constructed = array(
    'concrete slab' => 'concrete slab',
    'wooden floor' => 'wooden floor',
    'timber pile' => 'timber pile',
    'concrete slab and concrete pile' => 'concrete slab and concrete pile',
    'concrete slab and timber pile' => 'concrete slab and timber pile',
    'wooden floor and wooden pile' => 'wooden floor and wooden pile',
    'wooden floor and concrete pile' => 'wooden floor and concrete pile',
);
$accepted = array(
    'acceptable' => 'acceptable',
    'unacceptable' => 'unacceptable',
);
ksort($accepted);
$url = current_url();
?>
    <fieldset>
        <div class="col-sm-6">
            <div class="alert-msg">
                <div class="alert alert-info" style="padding: 7px!important;">
                    Please select a <strong>Job</strong> before making changes.
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Job Number:</label>
                <div class="col-sm-8">
                    <?php
                    echo form_dropdown('job_id',$job_number,'','class="form-control input-sm"');
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="report">Report:</label>
                <div class="col-sm-8">
                    <input type="text" class="text conclusion form-control input-sm" name="report" id="report" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="report">Photo:</label>
                <div class="col-sm-8">
                    <input id="file" type="file" class="file" name="photo" accept="image/*" max-size="10000">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="elevation">House Elevation:</label>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('elevation',$elevation,'','class="form-control input-sm text" id="elevation"')?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="elevation">&nbsp;</label>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[side]',$side,'','class="text conclusion form-control input-sm" id="side"')?>
                </div>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[facing]',$_facing,'','class="text conclusion form-control input-sm" id="facing"')?>
                </div>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[located]',$_located,'','class="text conclusion form-control input-sm" id="located"')?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="elevation">&nbsp;</label>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[exposure]',$exposure,'','class="text conclusion form-control input-sm" id="exposure"')?>
                </div>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[constructed]',$constructed,'','class="text conclusion form-control input-sm" id="constructed"')?>
                </div>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[foundation]',$foundation,'','class="text conclusion form-control input-sm" id="foundation"')?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="elevation">&nbsp;</label>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[house_condition]',$condition,'','class="text conclusion form-control input-sm" id="house_condition"')?>
                </div>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[finish]',$finish,'','class="text conclusion form-control input-sm" id="finish"')?>
                </div>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[general_condition]',$condition,'','class="text conclusion form-control input-sm" id="general_condition"')?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="elevation">&nbsp;</label>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[dwelling]',$dwelling,'','class="text conclusion form-control input-sm" id="dwelling"')?>
                </div>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[appears]',$condition,'','class="text conclusion form-control input-sm" id="appears"')?>
                </div>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[level]',$exposure,'','class="text conclusion form-control input-sm" id="level"')?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="elevation">&nbsp;</label>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[floor_level]',$accepted,'','class="text conclusion form-control input-sm" id="floor_level"')?>
                </div>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[evidence]',$accepted,'','class="text conclusion form-control input-sm" id="evidence"')?>
                </div>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[condition]',$condition,'','class="text conclusion form-control input-sm" id="condition"')?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[landscape]',$condition,'','class="text conclusion form-control input-sm" id="landscape"')?>
                </div>
                <div class="col-sm-3 dp-div">
                    <?php echo form_dropdown('conclusion[property]',$property,'','class="text conclusion form-control input-sm" id="property"')?>
                </div>
            </div>
            <div style="text-align: center"><label class="control-label" style="font-size: 14px;">Additional Notes for Area's Inspected</label></div>

            <div class="additional-notes" style="padding:5px 25px;max-height: 300px;overflow-y: auto;overflow-x: hidden;border: 1px solid #000000;">
                <?php
                if(count($area_inspected) > 0){
                    foreach($area_inspected as $val){
                        ?>
                        <div class="form-group">
                            <label class="control-label" for="<?php echo $val->name;?>">
                                <?php
                                echo $val->area_inspected;
                                echo ' | <a href="#" class="add-tag" id="' . $val->id . '" data-value="' . $val->name . '" title="' . $val->area_inspected . '">Add Tag</a>';
                                ?>
                            </label>
                            <textarea class="form-control input-sm text conclusion" name="notes[<?php echo $val->name;?>]" id="<?php echo $val->name;?>" rows="5"></textarea>
                        </div>
                    <?php
                    }
                }
                ?>
            </div>
            <label class="control-label" style="font-size: 14px;">Area Inspected</label>
            <table class="table table-colored-header" style="border-top: 1px solid #000000">
                <tbody>
                <tr>
                    <th style="width: 70%;border: none">&nbsp;</th>
                    <th style="border: none">Yes</th>
                    <th style="border: none">No</th>
                    <th colspan="2" style="text-align: left; width:5%;border: none">Limited<br/>Inspection</th>
                </tr>
                <?php
                if(count($area_inspected) > 0){
                    foreach($area_inspected as $val){
                        ?>
                        <tr>
                            <td style="text-align: left;"><?php echo $val->area_inspected;?></td>
                            <td><input type="radio" name="<?php echo $val->name?>" id="<?php echo $val->name;?>" class="text" value="1"></td>
                            <td><input type="radio" name="<?php echo $val->name?>" id="<?php echo $val->name;?>" class="text" value="0"></td>
                            <td><input type="radio" name="<?php echo $val->name?>" id="<?php echo $val->name;?>" class="text" value="2"></td>
                        </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <div>
                <h4>Conclusion <span class="pull-right is-show toggle-btn" data-toggle="popover">Hide</span></h4>
            </div>
            <p style="text-align: justify">
                <span class="placeholder-text">Site</span><span class="break"><br/></span>
                
                The house is located in the <span class="dp-text text selected-text" id="side">&nbsp;</span> side of <span class="text" id="address" style="padding: 0;margin: 0;">the property</span> and is oriented on the section so that the living areas are
                facing generally <span class="dp-text text selected-text" id="facing">&nbsp;</span>.

                The site is located on a <span class="dp-text text selected-text" id="located">&nbsp;</span> suburban section that has
                <span class="dp-text text selected-text" id="exposure">&nbsp;</span> exposure to the prevailing winds.
                <span class="dp-text text area-text" id="site"></span><br/><br/>

                The age of the house was taken into consideration when the inspection and reporting was carried out. The survey of
                the condition of the building elements and components were carried out on the basis of ‘the expected condition of
                the materials’ considering their use, location and age.<br/><br/>

                <span class="placeholder-text">Subfloor</span><span class="break"><br/></span>

                The house is constructed on a
                <span class="dp-text text selected-text" id="constructed">&nbsp;</span> <span class="dp-text text selected-text" id="foundation">&nbsp;</span>. At the time of inspection the foundation to the
                dwelling appeared in <span class="dp-text text selected-text" id="house_condition">&nbsp;</span> condition.
                <span class="dp-text text area-text" id="subfloor"></span><br/><br/>

                <span class="placeholder-text">Exterior</span><span class="break"><br/></span>

                The majority of the building is clad with <span class="dp-text text selected-text" id="finish">&nbsp;</span> finish, which appears structurally sound and generally
                in <span class="dp-text text selected-text" id="general_condition">&nbsp;</span> condition.
                <span class="dp-text text area-text" id="exterior"></span><br/><br/>

                <span class="placeholder-text">Roof exterior</span><span class="break"><br/></span>

                The roof to the dwelling consists of <span class="dp-text text selected-text" id="dwelling">&nbsp;</span> roof,
                which appears in <span class="dp-text text selected-text" id="appears">&nbsp;</span> condition for its age and will
                require a <span class="dp-text text selected-text" id="level">&nbsp;</span> level of maintenance over the coming years.<br/><br/>

                The floor levels in our opinion are at <span class="dp-text text selected-text" id="floor_level">&nbsp;</span> tolerances. No evidence of
                <span class="dp-text text selected-text" id="evidence">&nbsp;</span> settlement has been identified.
                <span class="dp-text text area-text" id="roof_exterior"></span><br/><br/>

                <span class="placeholder-text">Roof space</span><span class="break"><br/></span>

                No access was available to view the roof space, we sighted a blocked access to the hallway cupboard but this fixed
                shut.<br/><br/>

                Internally the house appears in good condition. Overall, the house appears structurally sound.<br/><br/>

                Normal maintenance and repairs will be required over the coming years. The more significant items are detailed
                throughout the report.
                <span class="dp-text text area-text" id="roof_space"></span><br/><br/>

                <span class="placeholder-text">Interior</span><span class="break"><br/></span>
                <span class="dp-text text area-text" id="interior"></span><span class="dbl-break"><br/></span>

                <span class="placeholder-text">Services</span><span class="break"><br/></span>
                <span class="dp-text text area-text" id="services"></span><span class="dbl-break"><br/></span>

                <span class="placeholder-text">Accessory units, ancillary spaces & buildings</span><span class="break"><br/></span>

                The grounds to the property are generally in a <span class="dp-text text selected-text" id="condition">&nbsp;</span> condition and
                landscaped to a <span class="dp-text text selected-text" id="landscape">&nbsp;</span> condition for an existing
                <span class="dp-text text selected-text" id="property">&nbsp;</span> property. Due to the concrete patios and pathways only a low level of maintenance would be required over the
                years. We noted some debris and old building materials stored down the southern side of the property.
                <span class="dp-text text selected-text" id="ancillary_space"></span><br/><br/>
            </p>
        </div>
    </fieldset>
    <hr/>
    <div class="form-group">
        <div class="col-sm-12">
            <button type="submit" name="generate" class="btn btn-sm btn-primary pull-right generate" disabled><i class="glyphicon glyphicon-print"></i> Generate Report</button>
        </div>
    </div>
<?php
echo form_close();
?>
<style>
    .text{
        margin:5px;
        padding: 3px;
    }
    .dp-text{
        color: #ff4b88;
        padding: 0;
        margin: 0;
    }
    .area-text{
        color: #1c992a !important;
    }
    .number-text,.toggle-btn,.placeholder-text{
        color: #3072ff;
        padding: 5px;
        border: 1px solid #3072ff;
    }
    .toggle-btn{
        font-size: 13px!important;
        cursor: pointer;
    }
    .toggle-btn:hover{
        background: #cacaca;
    }
    .number-text{
        padding: 5px 3px;
        position: absolute;
        margin: 5px -24px;
    }
    .dp-number-text{
        color: #3072ff;
        padding-right: 3px;
        text-decoration: none!important;
    }

    .placeholder-text{
        line-height:3;
    }
</style>
<script>
    $(function(){
        var job_id_ = $('select[name="job_id"]');
        var generate_btn = $('.generate');
        var iframe = $('.iframe-class');

        var has_job_id = function(){
            generate_btn.attr('disabled','disabled');
            if(job_id_.val()){
                generate_btn.removeAttr('disabled');
            }
        };

        var add_hash_number = function(){
            var ref = 1;
            $('.conclusion').each(function(k,v){
                if ($(this).is("select")) {
                    $('<span class="number-text">#' + ref + '</span>').prependTo($(this).parent());
                    $('span#' + this.id)
                        .html('<span class="dp-number-text">#' + ref + '</span>')
                        .attr('data-number',ref);
                    $(this).attr('data-number',ref);
                    ref++;
                }
            });
        };

        var disabled_action = function(job_id){
            $('.text').each(function(k,v){
                $(this).removeAttr('disabled');
                if(!job_id.val()){
                    $(this).attr('disabled','disabled');
                }
            });
        };
        disabled_action(job_id_);
        var alert_msg = function(job_id){
            var alert_ = $('.alert-msg');

            alert_.css({
                display: 'inline'
            });

            if(job_id.val()){
                alert_.css({
                   display: 'none'
                });
            }
        };

        alert_msg(job_id_);
        has_job_id();
        add_hash_number();

        $('.conclusion').on('change keyup',function(){
            var data = $('.form-horizontal').serializeArray();
            var this_id = this.id;
            var val = $(this).val();
            var number = $(this).data('number');
            $('.dp-text').each(function(e){
                if($(this).attr('id') == this_id){
                    var hash = '<span class="dp-number-text">#' + number + '</span>';
                    $(this)
                        .html(hash + val.replace(/\n/g,'<br/>'));
                }
            });

            data.push({name:'generate',value:'1'});
            $.post(bu + 'inspectionReport',data,function(data){});
        });

        var template =
            '<div class="popover" role="tooltip" style="width: 700px">' +
                '<div class="arrow"></div>' +
                '<div class="popover-content" style="font-size: 12px!important;">' +
                '</div>' +
            '</div>';

        $('.toggle-btn')
            .popover({
                trigger: 'hover',
                template: template,
                placement: 'top',
                delay: {"show": 1500},
                content: 'Anything shown in blue inside this letter, '
                + 'will not be included in the report when it is generated. '
                + 'Blue indicates placeholder indication for navigation purpose only. '
                + 'Click to toggle Show/Hide of these placeholders.'
            })
            .click(function(){
                var placeholders = $('.placeholder-text,.number-text,.dp-number-text,.break');
                $(this).html('Show');
                if($(this).hasClass('is-show')){
                    $(this)
                        .removeClass('is-show')
                        .addClass('is-hide')
                        .html('Show');
                    placeholders.css({
                        'display':'none'
                    });
                }
                else{
                    $(this)
                        .removeClass('is-hide')
                        .addClass('is-show')
                        .html('Hide');
                    placeholders.css({
                        'display':'inline'
                    });
                }
            });


        job_id_.change(function(){
            var job_id = $(this).val();

            generate_btn.attr('disabled','disabled');
            alert_msg($(this));
            disabled_action($(this));
            if(job_id){
                generate_btn.removeAttr('disabled');
               $.ajax({
                   url: bu + 'inspectionReport?job=' + job_id,
                   //force to handle it as text
                   dataType: "text",
                   success: function(data) {

                       //data downloaded so we call parseJSON function
                       //and pass downloaded data
                       var json = $.parseJSON(data);
                       //now json variable contains data in json format
                       //let's display a few items
                       $.each(json, function(index, element) {
                           $.each(element, function(key,val){
                               if($.isArray(val)){
                                   $.each(val, function(k,v){
                                       $.each(v, function(_k,_v) {
                                           $('.text').each(function(){
                                               var _id = this.id;
                                               if(_k == _id){
                                                   var number = $(this).data('number');

                                                   if ($(this).is('input[type="text"]')) {
                                                       $(this).val(_v);
                                                       // <input> element.
                                                   }
                                                   else if ($(this).is("select")) {
                                                       $(this).val(_v);
                                                       // <select> element.
                                                   } else if ($(this).is("textarea")) {
                                                       $(this).html(_v);
                                                   }
                                                   else{
                                                       var hash = '';

                                                       if(_v){
                                                           hash = '<span class="dp-number-text">#' + number + '</span>';
                                                           $(this).parent().find('.dbl-break').html('<br/><br/>');
                                                       }

                                                       $(this).html((typeof number === 'undefined' ? '' : hash) + _v);
                                                   }
                                               }
                                           });
                                       });
                                   });
                               }
                               else{
                                   $('.text').each(function(){
                                       var _id = this.id;
                                       var number = $(this).data('number');
                                       if(key == _id){
                                           if ($(this).is('input[type="text"]')) {
                                               $(this).val(val);
                                               // <input> element.
                                           }
                                           else if ($(this).is('input:radio')) {
                                               $("input[name=" + key + "][value=" + val + "]").prop('checked', true);
                                           }
                                           else if ($(this).is("select")) {
                                               $(this).val(val);
                                               // <select> element.
                                           } else if ($(this).is("textarea")) {
                                               $(this).html(val)
                                           }
                                           else{
                                               var hash = '';
                                               if(val){
                                                   hash = '<span class="dp-number-text">#' + number + '</span>';
                                                   $(this).parent().find('.dbl-break').html('<br/><br/>');
                                               }

                                               $(this).html((typeof number === 'undefined' ? '' : hash) + val);
                                           }
                                       }
                                   });
                               }
                           });

                       });
                   }
               });
            }
            if(!job_id){
                $('.text').each(function(){
                    if ($(this).is('input[type="text"]')) {
                        $(this).val('');
                        // <input> element.
                    }
                    else if ($(this).is('input:radio')) {
                        $(this).prop('checked', true);
                    }
                    else if ($(this).is("select")) {
                        $(this).val();
                        // <select> element.
                    } else if ($(this).is("textarea")) {
                        $(this).val('')
                    }
                    else {
                        $(this).html('');
                    }
                });

                initial_value();
            }
       });

        var initial_value = function(){
            $('.conclusion').each(function(){
                var this_id = this.id;
                var val = $(this).val();
                $('.dp-text').each(function(){
                    var _this = this;
                    var _id = _this.id;
                    var this_val = $(this).html();
                    var number = $(this).data('number');
                    var hash = '<span class="dp-number-text">#' + number + '</span>';

                    if(this_id == _id){
                        var len = $(this).find('.dp-number-text').length;
                        $(this).html((!len ? (typeof number === 'undefined' ? '' : hash) : '') + this_val + val);
                    }
                });
            });
        };
        initial_value();
        generate_btn.click(function(e){
            e.preventDefault();
            var data = $('.form-horizontal').serializeArray();
            data.push({'name':'generate','value':1});

            $.post(bu + 'inspectionReport',data,function(data){
                location.reload();
                window.open(
                    bu + 'inspectionReport?is_print=1&job=' + job_id_.val()
                );
            });
        });
        $('.load-pdf').load(bu + 'inspectionReport?is_print=1&job=2');
        $("#file").fileinput({
            uploadExtraData: {upload: 1},
            allowedFileExtensions : ['jpg', 'png','gif'],
            maxFileSize: 100000,
            maxFilesNum: 30,
            showUpload: false
        })
            .on('fileuploaded', function(event, data, id, index) {
        });

        $('.add-tag').click(function(e){
            $(this).modifiedModal({
                url: bu + 'inspectionReport/' + $(this).data('value') + '?tag=1',
                title: 'Add Tag to ' + $(this).attr('title')
            });
        });
    });
</script>