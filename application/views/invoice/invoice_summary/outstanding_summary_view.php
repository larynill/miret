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
            <th>File Name</th>
            <th>Option</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(count($file)>0){
            foreach($file as $v){
                ?>
                <tr>
                    <td style="text-align: center">
                        <?php echo $v->date;?>
                    </td>
                    <td>
                        <?php echo $v->file_name;?>
                    </td>
                    <td style="text-align: center;width: 100px;">
                        <a href="<?php echo base_url().'fileDownload/credit/'.$v->year.'/'.$v->month.'/'.$v->client_id.'/'.$v->file_name?>" class="download">download</a> |
                        <a href="<?php echo base_url().'pdf/credit/'.$v->year.'/'.$v->month.'/'.$v->client_id.'/'.$v->file_name?>" target="_blank">view</a>
                    </td>
                </tr>
            <?php
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