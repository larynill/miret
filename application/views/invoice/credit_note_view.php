<link type="text/css" href="<?php echo base_url(); ?>plugins/js/ui/ui-lightness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
<link href="<?php echo base_url();?>plugins/css/addForm.css" rel="stylesheet"/>

<script src="<?php echo base_url() ?>plugins/js/ui/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>plugins/js/ui/jquery-ui-1.8.18.custom.min.js"></script>
<script src="<?php echo base_url();?>plugins/js/addForm.js" language="JavaScript"></script>
<script src='<?php echo base_url(); ?>plugins/js/number.js' language="JavaScript"></script>
<style>
    .ui-datepicker-trigger{
        width: 18px;
        margin: -2px 20px;
        position: absolute;
    }
    .statement-header,.statement-content{
        width: 98%;
        margin: 10px auto;
        font-size: 12px;
    }
    .statement-header > tbody > tr > td{
        padding: 5px;
    }
    .bold-text{
        font-weight: bold;
    }
    .title-text{
        background: #c4c4c4;
        padding: 5px 15px;
        text-transform: uppercase;
        font-weight: bold;
        font-size: 18px;
    }
    .statement-content > thead > tr > th{
        background: #d0d0d0;
        padding: 5px;
        border: 2px solid #000000;
    }
    .statement-content > tbody > tr > td{
        border-left: 2px solid #000000;
        padding: 3px 15px;
        text-align: center;
        font-weight: bold;
    }
    .statement-content > tbody > tr > td:last-child{
        border-right: 2px solid #000000;
    }
    .statement-content > tbody > tr:last-child > td{
        border-bottom: 2px solid #000000;
    }
    .credits{
        color: #000000;
    }
    .credits:hover{
        text-decoration: underline;
    }
    .disableAdd{
        pointer-events:none;
        background: #808080!important;
    }
    .disableArchive{
        pointer-events:none;
        background: #808080!important;
    }
</style>
<table class="statement-header">
    <tbody>
    <tr>
        <td>
            <div class="bold-text">
                <?php
                if(count($client_info)>0){
                    foreach($client_info as $cv){
                        echo '<span style="text-transform:uppercase;">'.$cv->CompanyName.'</span><br/><br/>';
                        echo $cv->PostalAdress.'<br/>';
                    }
                }
                ?>
            </div>
        </td>
        <td style="width: 28%">
            <img src="<?php echo base_url().'plugins/img/sample-logo.png';?>" width="250">
            <div class="bold-text">
                <?php
                if(count($invoice_info)>0){
                    foreach($invoice_info as $v){
                        echo '<span style="text-transform:uppercase;">'.$v->company_name.'</span><br/>';
                        echo $v->address.'<br/>';
                        echo '<span style="font-weight:normal;white-space:nowrap;">Email: </span>'.$v->email.'<br/>';
                    }
                }
                ?>
            </div>
            <div style="white-space: nowrap">
                Date: <span class="date"><?php echo date('j F Y');?></span>
                <input type="hidden" name="date" class="date-picker" value="<?php echo date('j F Y');?>">
            </div>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;" colspan="2">
            <span class="title-text">Credit Note <?php echo $credit_ref;?></span>
        </td>
    </tr>
    </tbody>
</table>
<table class="statement-content">
    <thead>
    <tr>
        <th width="120">Date</th>
        <th width="100">Order No.</th>
        <th width="100">Job No.</th>
        <th>Job Name</th>
        <th width="140">No. of Units/Hrs/Km</th>
        <th width="100">Unit Price</th>
        <th width="100">Extra</th>
        <th width="100">Total</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(count($credits)>0){
        foreach($credits as $v){
            ?>
            <tr>
                <td>
                    <?php echo $v->date;?>
                </td>
                <td>
                    <?php echo $v->order_number;?>
                </td>
                <td>
                    <?php echo $v->job_num;?>
                </td>
                <td>
                    <?php echo $v->job_name;?>
                </td>
                <td>
                    <?php echo $v->rate;?>
                </td>
                <td>
                    <?php echo $v->unit_price;?>
                </td>
                <td>
                    <?php echo '$ '.number_format($v->extra,2,'.',',');?>
                </td>
                <td>
                    <?php echo '$ '.number_format($v->subtotal,2,'.',',');?>
                </td>
            </tr>
        <?php
        }
    }
    ?>
    <?php
    $disableAdd = count($credits)>0 ? 'disableAdd' : '';
    $disableArchive = count($credits)==0 ? 'disableArchive' : '';

    $total_row = 20 - count($credits);
    for($i=0;$i<$total_row;$i++){
        echo '<tr>';
        echo '<td>&nbsp;</td>';
        echo '<td>&nbsp;</td>';
        echo '<td>&nbsp;</td>';
        echo '<td>&nbsp;</td>';
        echo '<td>&nbsp;</td>';
        echo '<td>&nbsp;</td>';
        echo '<td>&nbsp;</td>';
        echo '<td>&nbsp;</td>';
        echo '</tr>';
    }
    ?>
    <tr valign="top" style="font-size:13px;border-top: 2px solid #000000">
        <td colspan="5" style="border-right:none;text-align:left;"></td>
        <td colspan="2" align="right" style="border-left:none;text-align: right;" id="subtable">
            <table width="100%">
                <tr>
                    <td style="border:none;text-align:right;">Sub Total</td>
                    <td style="border:none;text-align:right;width: 50%;"><?php echo '$ '.number_format($totalExtra,2,'.',',');?></td>
                </tr>
                <tr>
                    <td style="border:none;">&nbsp;</td>
                    <td style="border:none;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border:none;text-align:right;">GST Rate</td>
                    <td style="border:none;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border:none;text-align:right;">GST Total</td>
                    <td style="border:none;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border:none;text-align:right;"><strong>TOTAL</strong></td>
                    <td style="border:none;">&nbsp;</td>
                </tr>
            </table>
        </td>
        <td id="subtable" align="left" style="font-size: 13px;">
            <table width="100%" align="left">
                <tr>
                    <td align="left" style="border:none;text-align:right;">
                        <?php echo '$ '.number_format($subTotal,2,'.',',');?>
                    </td>
                </tr>
                <tr>
                    <td style="border:none;text-align: right;">
                        <?php
                        echo '$ '.number_format($overAllsubTotal,2,'.',',');
                        ?>
                    </td>
                </tr>
                <tr><td align="left" style="border:none;text-align:right;">15%</td></tr>
                <tr>
                    <td align="left" style="border:none;text-align:right;">
                        <?php
                        echo $overAllsubTotal ? '$ '.number_format(($overAllsubTotal * 0.15),2,'.',',') : '$ 0.00';
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="left" style="border:none;text-align:right;">
                        <strong>
                            <?php
                            echo $overAllsubTotal ? '$ '.number_format(($overAllsubTotal + ($overAllsubTotal * 0.15)),2,'.',',') : '$ 0.00';
                            $overall = ($overAllsubTotal - ($overAllsubTotal * 0.15));
                            ?>
                        </strong>
                    </td>
                </tr>
            </table>
        </td>
    </tbody>
    <thead>
    <tr>
        <th colspan="8" style="border: none;background: none;text-align: left;">
            <a href="#" class="m-btn green addCredit <?php echo $disableAdd;?>" style="font-weight: normal;">Add Credit</a>
            <a href="<?php echo base_url().'statement?cID='.$_GET['cID'].'&pageType=statement'?>" class="m-btn green <?php echo $disableArchive;?> archiveBtn" style="font-weight: normal;">Archive</a>
            <a href="<?php echo base_url().'statement?cID='.$_GET['cID'].'&pageType=statement'?>" class="m-btn green" style="font-weight: normal;">Back</a>
        </th>
    </tr>
    </thead>
</table>
<script>
    $(function(e){
        var datepicker = $('.date-picker');
        var archiveBtn = $('.archiveBtn');
        var date = $('.date');
        var addCredit = $('.addCredit');
        datepicker.datepicker({
            showOn: "button",
            buttonImage:"plugins/img/calendar-add.png",
            buttonImageOnly:true,
            dateFormat: "d MM yy",
            onSelect: function(){
                date.html($(this).val());
            }
        });
        addCredit.click(function(e){
           $(this).newForm.addNewForm({
               title:'Add Credit Note',
               url:'<?php echo base_url().'addCreditNote?cID='.$_GET['cID'];?>',
               toFind:'.credit-note'
           });
        });
        archiveBtn.click(function(e){
            window.open ("<?php echo base_url().'creditNote?cID='.$_GET['cID'].'&page=archive&date='?>" + datepicker.val(),"_blank");
        });
    });
</script>