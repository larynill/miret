<script>
    $(function(e){
        var printBtn = $('.printBtn');
        var qsList = $('.qsList');
        var search = $('.search');

        printBtn.click(function(e){
            var thisUrl = '<?php echo $mainLink; ?>';
            var pp = '<?php echo isset($_GET['per_page']) ? $_GET['per_page'] : ''; ?>';
            thisUrl += pp ? '&per_page=' + pp : '';
            thisUrl += '&isPrint=1';
            thisUrl += qsList.val() ? '&qsList=' + qsList.val() : '';
            thisUrl += search.val() ? '&search=' + search.val() : '';

            var myWindow = window.open(
                thisUrl,
                'Notification PDF',
                'width=842,height=595;toolbar=no,menubar=no,location=no,titlebar=no'
            );
        });
    });
</script>
<style>
    .notificationTable{
        border-collapse: collapse;
        width: 100%;
        background: #ffffff;
        color: #000000;
        text-align: left;
        border: 1px solid #ddd;
        box-shadow: 0 1px 8px rgba(0, 0, 0, 0.1);
        font-size: 12px;
    }
    .notificationTable tr td{
        padding: 0;
    }
    .notificationTable tr .title{
        background: #eee;
        padding: 5px;
    }

    .contentTable{
        width: 100%;
    }
    .contentTable tr td{
        padding: 3px 5px 8px 5px;
        border: none;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .paginationArea{
        margin: 15px 0 0 0;
        font-size: 12px;
    }
    .paginationArea a{
        background: #eee;
        padding: 5px 8px;
        border: 1px solid #ddd;
        color: #000000;
    }
    .paginationArea a:hover{
        background: #cfcfcf;
        border: 1px solid #9e9e9e;
        color: #000000;
    }
    .paginationArea strong{
        padding: 4px 8px;
        background: #cfcfcf;
        border: 1px solid #9e9e9e;
        color: #000000;
    }

    input[type=text]{
        padding: 5px 10px!important;
    }
</style>

<?php
if(in_array($accountType, array(10))){
    echo form_open($mainLink);
    echo '<input type="text" name="search" value="' .
        (array_key_exists('searchDefault', $filterDefault) ? $filterDefault['searchDefault'] : '') .
        '" placeholder="Job Name, Job Number or Action" class="search" style="width: 200px;" />';
    echo form_dropdown('qsList', $qsList, array_key_exists('qsDefault', $filterDefault) ? $filterDefault['qsDefault'] : '', 'class="qsList"');
    echo '<input type="submit" name="filter" value="Filter" class="pure_black" />';
    echo '<input type="button" name="print" value="Print" class="printBtn pure_black" />';
    echo form_close();
    echo '<br />';
}
?>
<table class="notificationTable popArrow">
    <tr>
        <td class="title">
            <?php
            $count = count($notification);
            echo '<strong>Message:</strong> ' . $count;
            ?>
        </td>
    </tr>
    <?php
    if($notification > 0){
        ?>
        <tr>
            <td>
                <table class="contentTable">
                    <?php
                    $ref = $current_page + 1;
                    foreach($notification as $v){
                        ?>
                        <tr style="vertical-align: top;">
                            <td style="width: 10px;">
                                <?php
                                echo $ref;
                                ?>
                            </td>
                            <td style="font-weight: bold;width: 50px;white-space: nowrap;">
                                <?php
                                echo $v->author_name . ':';
                                ?>
                            </td>
                            <td style="max-width: 250px;word-wrap: break-word;">
                                <?php
                                echo $v->notification;
                                ?>
                            </td>
                            <?php
                            echo in_array($accountType, array(1, 10, 11)) ?
                                '<td style="width: 50px;white-space: nowrap;">to <strong>' . $v->receiver_name . '</strong></td>' : '';
                            ?>
                            <td style="font-size: 10px;font-weight: bold;width: 50px;white-space: nowrap;text-align: right;">
                                <?php
                                echo date('d/m/Y h:i a', strtotime($v->date));
                                ?>
                            </td>
                        </tr>
                        <?php
                        $ref++;
                    }
                    ?>
                </table>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
<div class="paginationArea">
    <?php
    echo $links;
    ?>
</div>