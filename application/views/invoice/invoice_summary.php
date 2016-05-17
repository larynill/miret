<?php echo form_open('');?>
<div class="content-class">
    <?php
    echo '<span style="padding-right:5px">'.form_dropdown('year', $year, date('Y'),'style="width:10%" class="dropdown year"').'</span>';
    echo '<span style="padding-right:5px">'.form_dropdown('month', $month, date('m'),'style="width:10%" class="dropdown month"').'</span>';
    ?>
    <input type="submit" name="search" value="Go" class="m-btn green submit" style="width: 3%;padding: 7px;margin: -1px 0;">
    <a href="<?php echo base_url().'invoices';?>" class="m-btn green" style="padding: 7px;">Back</a>
    <table class="invoice-summary">
        <thead>
        <tr>
            <th>Period to</th>
            <th style="width: 20%;">Invoice Ref.</th>
            <th style="width: 20%;">NETT</th>
            <th style="width: 20%;">GST</th>
            <th style="width: 20%;">Invoice Amount (Incl. GST)</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(count($invoice)>0){
            foreach($invoice as $k=>$v){
                ?>
                <tr>
                    <td colspan="6" style="background: #e6d4a7;text-align: right;"><?php echo $k;?></td>
                </tr>
            <?php
                foreach($v as $val){
                    ?>
                    <tr>
                        <td><?php echo $val->date;?></td>
                        <td><a href="<?php echo base_url().'pdf/invoice/'.$val->year.'/'.$val->month.'/'.$val->client_id.'/'.$val->file_name?>" target="_blank"><?php echo $val->reference;?></a></td>
                        <td><?php echo '$ '.number_format($val->nett,2,'.',',');?></td>
                        <td><?php echo '$ '.number_format($val->gst,2,'.',',');?></td>
                        <td><?php echo '$ '.number_format($val->amount,2,'.',',');?></td>
                    </tr>
                <?php
                }
            }
        }else{
            ?>
            <tr>
                <td colspan="6">No data was found.</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>
<?php echo form_close();?>
<style>
    .content-class{
        margin-top: 10px;
    }
    .dropdown{
        padding: 5px;
    }
    .invoice-summary{
        width: 75%;
        margin-top: 10px;
    }
    .invoice-summary > thead > tr > th{
        background: #484848;
        color: #ffffff;
        padding: 5px;
        font-weight: lighter;
        border: 1px solid #ffffff;
    }
    .invoice-summary > tbody > tr > td{
        border: 1px solid #d2d2d2;
        padding: 5px;
        text-align: center;
    }
</style>