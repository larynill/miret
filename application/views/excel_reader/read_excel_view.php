<table class="file-table">
    <thead>
    <tr>
        <th>Date</th>
        <th>File Name</th>
        <th>Client Name</th>
        <th>Contact Person</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(count($excel_file)>0):
        foreach($excel_file as $v):
            ?>
            <tr>
                <td>
                    <?php
                    echo $v->Date;
                    ?>
                </td>
                <td>
                    <?php
                    echo $v->FileName;
                    ?>
                </td>
                <td>
                    <?php
                    echo $v->CompanyName;
                    ?>
                </td>
                <td>
                    <?php
                    echo $v->ContactPerson;
                    ?>
                </td>
                <td>
                    <a href="<?php echo base_url().'excelReader/'.$v->ID?>">view</a> |
                    <a href="#">add</a>
                </td>
            </tr>
        <?php
        endforeach;
    else:?>
        <tr>
            <td colspan="5">No data was found.</td>
        </tr>
    <?php
    endif;
    ?>
    </tbody>
</table>
<style>
    .file-table{
        width: 98%;
        margin-top: 20px;
    }
    .file-table > thead > tr > th{
        background: #484848;
        color: #ffffff;
        font-weight: normal;
        padding: 5px;
    }
    .file-table > tbody > tr > td{
        border: 1px solid #d2d2d2;
        padding: 5px;
        text-align: center;
    }
</style>