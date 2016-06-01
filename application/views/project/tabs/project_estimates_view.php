
<?php
$url = 'jobRegistration';
$id = isset($_GET['id']) ? $_GET['id'] : '';
$url .= $id ? '?id=' . $id .'' : '';
echo form_open($url,'class="estimate-form"');
$total = 0;
if(count($estimate) > 0){
    foreach($estimate as $val){
        $_cost = $val->cost ? $val->cost : $val->default_rate;
        $total += ($val->quantity * $_cost);
    }
}
?>
<span class="notify" style="display: none;">Changes saved.</span>
<div class="list"></div>
<table class="table table-colored-header">
    <thead>
    <tr>
        <td colspan="5">&nbsp;</td>
        <td class="text-center"><strong>Total</strong></td>
        <td class="bordered text-center"><strong class="over-all-total">$<?php echo number_format($total,2,'.','');?></strong></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Quantity</td>
        <td>Unit</td>
        <td>Cost</td>
        <td>Sub-Total</td>
        <td>&nbsp;</td>
    </tr>
    </thead>
    <tbody class="estimate-content">
        <?php
        $ref = 1;
        if(count($estimate) > 0){
            foreach($estimate as $val){
                $_cost = $val->cost ? $val->cost : $val->default_rate;
                $subtotal = number_format($val->quantity * $_cost,2,'.','');
                $diff = $val->cost ? $val->cost - $val->default_rate : 0;
                $_diff = $diff;

                $_subtotal_diff = $subtotal - number_format($val->quantity * $val->default_rate,2,'.','');
                $input_style =  $diff != 0 ? 'color:#ff0000;' : '';
                $diff = $diff < 0 ? '-$' . abs($diff) : '+$' . $diff;
                $_subtotal_diff = $_subtotal_diff != 0 ?  ($_subtotal_diff < 0 ? '-$' . abs($_subtotal_diff) : '+$' . $_subtotal_diff) : '$0';
                ?>
                <tr class="item-details" id="item-<?php echo $ref?>">
                    <td class="count">
                        <?php echo $ref;?>
                    </td>
                    <td class="text-left">
                        <input class="form-control input-sm item-code"  id="<?php echo $ref;?>" data-toggle="popover" value="<?php echo $val->item_code?>">
                        <input type="hidden" name="_item_id[<?php echo $val->id?>]" class="hidden-item" value="<?php echo $val->item_id;?>">
                    </td>
                    <td class="text-left">
                        <input class="form-control input-sm item-name"  id="<?php echo $ref;?>" value="<?php echo $val->item_name?>">
                    </td>
                    <td style="width: 2%!important;">
                        <input type="text" name="_quantity[<?php echo $val->id?>]" class="quantity" value="<?php echo $val->quantity ? $val->quantity : ''?>">
                    </td>
                    <td><?php echo $val->unit_from?></td>
                    <td class="cost-col">
                        <input type="text" name="_cost[<?php echo $val->id?>]" class="default-rate" data-default="<?php echo $val->default_rate;?>" value="<?php echo $_cost?>" style="display:none;">
                        <span class="cost"><?php echo '$' . $_cost?></span>
                    </td>
                    <td class="total">$<?php echo $val->quantity ? $subtotal : 0?></td>
                    <td rowspan="2" class="no-border">
                        <a href="#" style="color: #000000;" class="delete-estimate" id="<?php echo $ref?>" data-id="<?php echo $val->id?>" tabindex="-1"><i class="glyphicon glyphicon-trash"></i></a>
                    </td>
                </tr>
                <tr class="item-<?php echo $ref?>">
                    <?php
                    if($_diff){
                        ?>
                        <td colspan="4" class="text-left" id="report-item-<?php echo $ref?>">
                            <?php echo $val->report_text?>
                        </td>
                        <td class="text-right danger">Difference:</td>
                        <td class="danger"><span class="df-cost" style="<?php echo $input_style;?>"><?php echo $diff ? $diff : ''?></span></td>
                        <td class="danger"><span class="df-rate" style="<?php echo $input_style;?>"><?php echo $diff ? $_subtotal_diff : ''?></span></td>
                        <?php
                    }
                    else{
                        ?>
                        <td colspan="7" class="text-left" id="report-item-<?php echo $ref?>">
                            <?php echo $val->report_text?>
                        </td>
                        <td class="text-right danger" style="display: none">Difference:</td>
                        <td class="danger" style="display: none"><span class="df-cost"></span></td>
                        <td class="danger" style="display: none"><span class="df-rate"></span></td>
                        <?php
                    }
                    ?>
                </tr>
            <?php
                $ref++;
            }
        }
        else{
            $ref = 1;
            if(count($auto_items) > 0){
                foreach($auto_items as $val){
                    ?>
                    <tr class="item-details" id="item-<?php echo $ref?>">
                        <td class="count">
                            <?php echo $ref;?>
                        </td>
                        <td class="text-left">
                            <input class="form-control input-sm item-code" data-toggle="popover" value="<?php echo $val->item_code?>">
                            <input type="hidden" class="hidden-item" name="item_id[]" value="<?php echo $val->id;?>">
                        </td>
                        <td class="text-left">
                            <input class="form-control input-sm item-name"  value="<?php echo $val->item_name?>">
                        </td>
                        <td style="width: 2%!important;">
                            <input type="text" name="quantity[]" class="quantity">
                        </td>
                        <td><?php echo $val->unit_from?></td>
                        <td class="cost-col">
                            <input type="text" name="cost[]" class="default-rate" data-default="<?php echo $val->default_rate;?>" value="<?php echo $val->default_rate?>" style="display:none;">
                            <span class="cost"><?php echo '$' . $val->default_rate?></span>
                        </td>
                        <td class="total">$0</td>
                        <td rowspan="2" class="no-border">
                            <a href="#" style="color: #000000;" class="delete-estimate" id="<?php echo $ref?>" tabindex="-1"><i class="glyphicon glyphicon-trash"></i></a>
                        </td>
                    </tr>
                    <tr class="item-<?php echo $ref?>">
                        <td colspan="7" class="text-left" id="report-item-<?php echo $ref?>">
                            <?php echo $val->report_text?>
                        </td>
                    </tr>
                <?php
                    $ref++;
                }
            }
        }
        ?>
    </tbody>
</table>
<div class="text-left">
    <button type="button" class="btn btn-sm btn-primary add-estimate"><i class="glyphicon glyphicon-plus"></i> Add Estimate</button>
    <button type="submit" class="btn btn-sm btn-success" name="submit_estimate" style="display: none">Save</button>
</div>
<?php
echo form_close();
?>
<style>
    .table-colored-header > thead > tr:nth-child(2) > td{
        text-align: center;
        border: none;
    }
    .count{
        font-weight: bold;
    }
    .table-colored-header > thead > tr:nth-child(2) > td:nth-child(3){
        width: 50%;
    }
    .table-colored-header > thead > tr:nth-child(2) > td:nth-child(2){
        width: 15%;
    }
    .table-colored-header > thead > tr:nth-child(2) > td:nth-child(4){
        width: 5%;
    }
    .table-colored-header > thead > tr:nth-child(2) > td:nth-child(6){
        width: 8%;
    }
    .table-colored-header > thead > tr:nth-child(2) > td:nth-child(7){
        width: 10%;
    }
    .ms-ctn.form-control{
        width: 100%;
    }
    .text-left{
        text-align: left!important;
    }
    .no-border{
        border: none!important;
    }
    .bordered{
        border: 1px solid #d2d2d2!important;
    }
    input[type="text"],select{
        width: 100%;
    }
    .notify{
        position: absolute;
        background: #1caa22;
        padding: 5px;
        color: #ffffff;
    }
    .popover{
        white-space: nowrap;
        max-width: 500px;
    }
    .popover.right > .arrow:after{
        border-right-color: tomato;
    }
    .ui-autocomplete.ui-front.ui-menu.ui-widget.ui-widget-content{
        z-index: 9999999;
    }
</style>
<script>
    $(function(){
        var estimate_content = $('.estimate-content'),
            add_estimate = $('.add-estimate');
        var ele,
            set_blank_element = function(count){
                ele =
                    '<tr class="item-details" id="item-' + count + '">' +
                        '<td class="count">' + count + '</td>' +
                        '<td class="text-left">' +
                            '<input class="form-control input-sm magic-suggest item-code" value="">' +
                            '<input type="hidden" class="hidden-item" name="item_id[]">' +
                            '<div class="popover" role="tooltip">' +
                                '<div class="popover-arrow"></div>' +
                                '<h3 class="popover-title"></h3>' +
                                '<div class="popover-content"></div>' +
                            '</div>' +
                        '</td>' +
                        '<td class="text-left"><input class="form-control input-sm item-name"  value=""></td>' +
                        '<td><input type="text" name="quantity[]" class="quantity"></td>' +
                        '<td class="unit"></td>' +
                        '<td class="cost-col">' +
                            '<input type="text" name="cost[]" class="default-rate" style="display: none;">' +
                            '<span class="cost"></span>' +
                        '</td>' +
                        '<td class="total">$0</td>' +
                        '<td rowspan="2" class="no-border">' +
                            '<a href="#" style="color: #000000;" class="delete-estimate" id="' + count + '" tabindex="-1"><i class="glyphicon glyphicon-trash"></i></a>' +
                        '</td>' +
                    '</tr>' +
                    '<tr class="item-' + count + '">' +
                        '<td colspan="7" class="text-left report-text" id="report-item-' + count + '">&nbsp;</td>' +
                        '<td class="text-right danger" style="display: none">Difference:</td>' +
                        '<td class="danger" style="display: none"><span class="df-cost"></span></td>' +
                        '<td class="danger" style="display: none"><span class="df-rate"></span></td>' +
                    '</tr>';

                return ele;
            };
            var _load_auto_complete = function(url,_class,type,is_action,count_id){
                $.ajax({
                    url: url,
                    dataType: "json",
                    success: function( data ) {
                        _class.autocomplete({
                            minLength: 0,
                            appendTo: '.list',
                            source: data,
                            select: function( event, ui ) {
                                var _id = (is_action ? count_id : this.id);
                                var item_id = $(this).parents('.item-details');
                                var report_text = $('#report-item-' + _id);
                                item_id.find('.default-rate').val(ui.item.default_rate);
                                item_id.find('.cost').html('$' + ui.item.default_rate);
                                item_id.find('.unit').html(ui.item.unit_from);
                                report_text.html(ui.item.report_text);
                                item_id.find('.hidden-item').attr('value',ui.item.id);

                                if(type == 1){
                                    item_id.find('.item-name').val(ui.item.item_name);
                                }
                                else{
                                    item_id.find('.item-code').val(ui.item.item_code);
                                }
                                add_estimate.removeAttr('disabled');
                                $('button[name="submit_estimate"]').trigger('click');
                                $(this).popover('hide');
                            },
                            focus: function(event,ui){
                                event.preventDefault();
                                $(this)
                                    .attr({
                                        'data-toggle':'popover',
                                        'data-placement':'right',
                                        'data-content':ui.item.item_name
                                    })
                                    .popover('show');
                                $('.popover').css({'background':'tomato','color':'#ffffff','top': (event.pageY - 10) + 'px'});
                            },
                            close: function(event,ui){
                                $(this).popover('destroy');
                                $(this).removeAttr('data-toggle data-placement data-content aria-describedby data-original-title');
                            }
                        });
                    }
                });
            };

        var _load_item_code = function(_class,is_action,count_id){
            $.ajax({
                url: bu + 'itemsJson?s=item_code',
                dataType: "json",
                success: function( data ) {
                    _class.on('keyup',function(e){
                        var search_str = $(this).val();
                        var _this = $(this);
                        var _this_id = this.id;
                        $.each(data,function(index,val){
                            if(val.item_code.toLowerCase() == search_str.toLowerCase()){
                                var item_id = _this.parents('.item-details');
                                var _id = (is_action ? count_id : _this_id);
                                var report_text = $('#report-item-' + _id);
                                item_id.find('.default-rate').val(val.default_rate);
                                item_id.find('.cost').html('$' + val.default_rate);
                                item_id.find('.unit').html(val.unit_from);
                                report_text.html(val.report_text);
                                item_id.find('.hidden-item').attr('value',val.id);
                                item_id.find('.item-name').val(val.item_name);
                                _this.val(val.item_code);
                                add_estimate.removeAttr('disabled');
                                $('button[name="submit_estimate"]').trigger('click');
                                _this.on( "autocompleteclose", function( event, ui ) {} );
                                _this.autocomplete( "destroy" );
                            }
                        })
                    });
                }
            });
        };

        var item_code = $('.item-code');
        _load_auto_complete(bu + 'itemsJson?s=item_code',item_code,1);
        _load_auto_complete(bu + 'itemsJson?s=item_name',$('.item-name'),2);
        _load_item_code(item_code);

        add_estimate.click(function(){
            $(this).attr('disabled','disabled');
            estimate_content
                .append(set_blank_element(
                    parseInt(
                        estimate_content.find('.count').last().html()
                            ? estimate_content.find('.count').last().html() : 0
                    ) + 1)
                );

            var item_code_auto_complete = estimate_content.find('.item-code'),
                item_name_auto_complete = estimate_content.find('.item-name'),
                quantity = estimate_content.find('.quantity'),
                count_id = parseInt(estimate_content.find('.count').last().html());

            _load_auto_complete(bu + 'itemsJson?s=item_code',item_code_auto_complete,1,1,count_id);
            _load_auto_complete(bu + 'itemsJson?s=item_name',item_name_auto_complete,2,1,count_id);
            _load_item_code(item_code_auto_complete,1,count_id);

        });
        $('.form-control')
            .popover({
                trigger: 'hover',
                placement: 'right',
                delay: {"show": 1500}
            });
        estimate_content
            .on('keyup','.quantity',function(){
                var details = $(this).parents('.item-details');
                var _item = $('.' + details.attr('id'));
                var _df_rate = details.find('.default-rate').attr('data-default');

                var _total = details.find('.total');
                var _rate = details.find('.default-rate').val();
                var _df_cost = _item.find('.df-rate');
                var _total_cost = _rate ? parseFloat(_rate) * $(this).val() : 0;
                _total.html('$' + (_total_cost ? _total_cost.toFixed(2) : 0));

                /*Subtotal Difference*/
                var subtotal_diff = parseFloat(_total_cost - (parseFloat($(this).val()) * _df_rate));
                var _str_subtotal_diff = subtotal_diff.toString();
                subtotal_diff = subtotal_diff < 0 ? '-$' + _str_subtotal_diff.replace('-','') : '+$' + subtotal_diff;

                var over_all_total = 0;
                $('.total').each(function(e){
                    var _val = $(this).html();
                    over_all_total += parseFloat(_val.replace('$',''));
                });
                $('.over-all-total').html('$' + over_all_total.toFixed(2));
                _df_cost
                    .css({color:'#ff0000'})
                    .html(subtotal_diff);
            })
            .on('focusout','.quantity',function(e){
                $('button[name="submit_estimate"]').trigger('click');
            })
            .on('keyup','.default-rate',function(){
                var details = $(this).parents('.item-details');
                var _item = $('.' + details.attr('id'));
                var _total = $(this).parents('.item-details').find('.total');
                var _quantity = $(this).parents('.item-details').find('.quantity').val();
                _quantity = _quantity ? _quantity : 0;
                var _df_cost = _item.find('.df-cost');
                var _df_rate = _item.find('.df-rate');
                var _total_cost = _quantity ? parseFloat(_quantity) * $(this).val() : 0;
                /*Difference*/
                var diff = parseFloat($(this).val() - $(this).data('default'));
                var _diff = diff;
                var _str_diff = diff.toString();
                diff = diff < 0 ? '-$' + _str_diff.replace('-','') : '+$' + diff;

                /*Subtotal Difference*/
                var subtotal_diff = parseFloat(_total_cost - (parseFloat(_quantity) * $(this).data('default')));
                var _str_subtotal_diff = subtotal_diff ? subtotal_diff.toString() : 0;
                subtotal_diff = subtotal_diff != 0 ? (subtotal_diff < 0 ? '-$' + _str_subtotal_diff.replace('-','') : '+$' + subtotal_diff) : '$0';

                _total.html('$' + (_total_cost ? _total_cost.toFixed(2) : 0));
                var over_all_total = 0;
                $('.total').each(function(e){
                    var _val = $(this).html();
                    over_all_total += parseFloat(_val.replace('$',''));
                });
                _item.find('.danger').css({'display':'none'});
                _item.find('#report-' + details.attr('id')).attr('colspan','7');

                if(_diff != 0){
                    _item.find('.danger').removeAttr('style');
                    _item.find('#report-' + details.attr('id')).attr('colspan','4');
                    _df_cost
                        .html(diff)
                        .css({color:'#ff0000'});
                    _df_rate
                        .html(subtotal_diff)
                        .css({color:'#ff0000'});
                }

                $('.over-all-total').html('$' + over_all_total.toFixed(2));
            })
            .on('dblclick','.cost-col',function(){
                $(this).find('.default-rate').css({display:'inline'}).focus();
                $(this).find('.cost').css({display:'none'});
            })
            .on('focusout','.default-rate',function(e){
                $('button[name="submit_estimate"]').trigger('click');
                $(this).css({'display':'none'});
                $(this).parent().find('.cost').css({display:'inline'});
            })
            .on('click','.delete-estimate',function(){
                var ele =
                    '<div class="modal-body">' +
                        '<div class="row">' +
                            '<div class="col-sm-12">' +
                                'Do you want to continue deleting Item?' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="modal-footer">' +
                        '<button type="button" class="btn btn-success btn-sm yes-btn" data-dismiss="modal">Yes</button>' +
                        '<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">No</button>' +
                    '</div>';
                $(this).modifiedModal({
                    html: ele,
                    title: 'Delete Item',
                    type: 'small'
                });
                var item_id = $('#item-' + this.id + ', .item-' + this.id);
                var data_id = typeof $(this).data('id')  !== "undefined" ? $(this).data('id') : '';
                $('.yes-btn').click(function(e){
                    if(data_id){
                        $.post(bu + 'jobRegistration?id=<?php echo $_GET['id']?>&delete=1',{id:data_id});
                    }
                    item_id.remove();
                    var ref = 1;
                    estimate_content.find('.count').each(function(e){
                        $(this).html(ref);
                        ref++;
                    });
                    add_estimate.removeAttr('disabled');
                })
            });

        $('button[name="submit_estimate"]').click(function(e){
            e.preventDefault();
            var _estimate_form = $('.estimate-form'),
                data = _estimate_form.serializeArray();
                data.push({'name':'submit_estimate',value:1});
            $.post(_estimate_form.attr('action'),data,function(response){
                var data = jQuery.parseJSON(response);
                $('.notify').css({'display':'inline'});
                $('.hidden-item').each(function(e){
                    $(this)
                        .attr('name','_item_id[' + data[e].id +']')
                        .val(data[e].item_id);
                    e++;
                });
                $('.quantity').each(function(e){
                    $(this)
                        .attr('name','_quantity[' + data[e].id +']')
                        .val((parseInt(data[e].quantity) ? data[e].quantity : ''));

                    var _total = $(this).parents('.item-details').find('.total');
                    var _rate = data[e].cost ? data[e].cost : data[e].default_rate;
                    var _quantity = data[e].quantity;
                    var _total_cost = parseFloat(_rate) * parseFloat(_quantity);
                    _total.html('$' + (_total_cost ? _total_cost.toFixed(2) : 0));

                    e++;
                });
                $('.cost').each(function(e){
                    $(this)
                        .html('$' + (parseInt(data[e].cost) ? data[e].cost : data[e].default_rate));

                    e++;
                });
                $('.default-rate').each(function(e){
                    $(this)
                        .attr('name','_cost[' + data[e].id +']')
                        .attr('data-default',data[e].default_rate)
                        .val((parseInt(data[e].cost) ? data[e].cost : data[e].default_rate));

                    var details = $(this).parents('.item-details');
                    var _item = $('.' + details.attr('id'));
                    var _total = details.find('.total');
                    var _df_cost = _item.find('.df-cost');
                    var _df_rate = _item.find('.df-rate');
                    var _rate = data[e].cost ? data[e].cost : data[e].default_rate;
                    var _quantity = data[e].quantity;

                    var _total_cost = parseFloat(_rate) * parseFloat(_quantity);

                    /*Difference*/
                    var diff = (data[e].cost - data[e].default_rate);
                    var _diff = diff;
                    var _str_diff = diff.toString();
                    diff = diff < 0 ? '-$' + _str_diff.replace('-','') : '+$' + diff;

                    /*Subtotal Difference*/
                    var subtotal_diff = parseFloat(_total_cost - (parseFloat(_quantity) * data[e].default_rate));
                    var _str_subtotal_diff = subtotal_diff.toString();
                    subtotal_diff = subtotal_diff != 0 ? (subtotal_diff < 0 ? '-$' + _str_subtotal_diff.replace('-','') : '+$' + subtotal_diff) : '$0';

                    _total.html('$' + (_total_cost ? _total_cost.toFixed(2) : 0));
                    _df_cost.html('');

                    _item.find('.danger').css({'display':'none'});
                    _item.find('#report-' + details.attr('id')).attr('colspan','7');

                    if(_diff != 0){
                        _item.find('.danger').removeAttr('style');
                        _item.find('#report-' + details.attr('id')).attr('colspan','4');
                        _df_cost
                            .html(diff)
                            .css({color:'#ff0000'});
                        _df_rate
                            .html(subtotal_diff)
                            .css({color:'#ff0000'});
                    }
                    e++;
                });
                $('.delete-estimate').each(function(e){
                    $(this)
                        .attr('data-id',data[e].id);
                    e++;
                });
            });

        });
        setInterval(function(){
            $('.notify').css({'display':'none'});
        }, 3000);

    })
</script>