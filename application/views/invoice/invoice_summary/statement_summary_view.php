<div class="col-sm-8">
    <table class="table table-colored-header">
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
                            <a href="<?php echo base_url().'fileDownload/statement/'.$val->year.'/'.$val->month.'/'.$val->client_id.'/'.$val->file_name?>" class="download">download</a> |
                            <a href="<?php echo base_url().'pdf/statement/'.$val->year.'/'.$val->month.'/'.$val->client_id.'/'.$val->file_name?>" target="_blank">view</a>
                        </td>
                    </tr>
                <?php
                }
            }
        }else{?>
            <tr>
                <td colspan="6" style="text-align: center">No data was found.</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>