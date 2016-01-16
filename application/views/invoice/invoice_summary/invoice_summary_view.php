<table class="invoice-table">
    <thead>
    <tr>
        <td colspan="6" style="font-size: 18px;">
            <?php
            echo $title;
            ?>
        </td>
    </tr>
    </thead>
    <thead>
    <tr>
        <th>Date</th>
        <th>Client Name</th>
        <th>File Name</th>
        <th>Option</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(count($file)>0){
        foreach($file as $k=>$v){
            ?>
            <tr>
                <td colspan="6" style="text-align: right;font-weight: bold;background: #add8e6">
                    <?php echo $k;?>
                </td>
            </tr>
            <?php
            foreach($v as $val){
            ?>
            <tr>
                <td style="text-align: center">
                    <?php echo $val->date;?>
                </td>
                <td>
                    <?php echo $val->name;?>
                </td>
                <td>
                    <?php echo $val->file_name;?>
                </td>
                <td style="text-align: center;width: 100px;">
                    <a href="<?php echo base_url().'fileDownload/invoice/'.$val->year.'/'.$val->month.'/'.$val->client_id.'/'.$val->file_name?>" class="download">download</a> |
                    <a href="<?php echo base_url().'pdf/invoice/'.$val->year.'/'.$val->month.'/'.$val->client_id.'/'.$val->file_name?>" target="_blank">view</a>
                </td>
            </tr>
        <?php
            }
        }
    }else{?>
        <tr>
            <td colspan="6" style="text-align: center">No Data</td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>
<style>
    .invoice-table{
        margin: 10px 5px;
        font-size: 12px;
        width: 800px;
    }
    .invoice-table > thead > tr > th{
        border: 1px solid #d2d2d2;
        background: #000000;
        color: #ffffff;
        padding: 5px;
    }
    .invoice-table > tbody > tr > td{
        border: 1px solid #d2d2d2;
        padding: 5px;
    }
</style>