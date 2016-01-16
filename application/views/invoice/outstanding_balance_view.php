<style>
    .table-class{
        margin-top: 10px;
        width: 98%;
    }
    .table-class > thead > tr > th{
        background: #484848;
        color: #ffffff;
        padding: 5px;
        border: 1px solid #ffffff;
    }
    .table-class > tbody > tr > td{
        border: 1px solid #d2d2d2;
        padding: 5px;
        text-align: center;
    }
</style>
<table class="table-class">
    <thead>
    <tr>
        <th>Client</th>
        <th style="width: 15%">Date</th>
        <th style="width: 12%">Balance</th>
        <th style="width: 12%">NETT</th>
        <th style="width: 12%">GST</th>
        <th style="width: 12%">Gross</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(count($client)>0){
        foreach($client as $k=>$v){
            ?>
            <tr>
                <td style="text-align: left">
                    <?php echo $v->CompanyName;?>
                </td>
                <td>
                    <?php echo $v->max_date?>
                </td>
                <td>
                    <?php echo $v->balance?>
                </td>
                <td>
                    <?php echo $v->gst?>
                </td>
                <td>
                    <?php echo $v->nett?>
                </td>
                <td>
                    <?php echo $v->gross?>
                </td>
            </tr>
        <?php
        }
    }
    ?>
    <tr style="font-weight: bold">
        <td colspan="2" style="text-align: right;">Total</td>
        <td>
            <?php
            echo '$ '.number_format($total_balance,2,'.',',');
            ?>
        </td>
        <td>
            <?php
            echo '$ '.number_format($total_gst,2,'.',',');
            ?>
        </td>
        <td>
            <?php
            echo '$ '.number_format($total_nett,2,'.',',');
            ?>
        </td>
        <td>
            <?php
            echo '$ '.number_format($total_gross,2,'.',',');
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="6" style="text-align: left;border: none;">
            <a href="#" class="print-btn m-btn green">Print PDF</a>
        </td>
    </tr>
    </tbody>
</table>