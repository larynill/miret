<script>
    $(function(e){
        var contentMiniTable = $('.contentMiniTable');
        var notificationMiniTable = $('.notificationMiniTable');
        var wid = contentMiniTable.innerWidth() + 30;

        notificationMiniTable.css({
            width: wid + 'px'
        });
    });
</script>

<style>
    .notificationMiniTable{
        border-collapse: collapse;
        width: 100%;
        background: #ffffff;
        color: #000000;
        text-align: left;
        border: 1px solid #ddd;
        box-shadow: 0 1px 8px rgba(0, 0, 0, 0.1);
    }
    .notificationMiniTable tr td{
        padding: 0;
    }
    .notificationMiniTable tr .title{
        background: #eee;
        padding: 5px;
    }

    .contentMiniNotification{
        overflow: auto;
        max-height: 300px;
        overflow-x: hidden;
    }
    .contentMiniTable{
        border-collapse: collapse;
        width: 100%;
        min-width: 360px;
    }
    .contentMiniTable tr td{
        padding: 3px 5px;
        border: none;
        text-align: left;
    }
    .contentMiniTable tr:hover td{
        background: #eee;
    }
</style>

<table class="notificationMiniTable popArrow">
    <tr>
        <td class="title">
            <?php
            $count = count($notification);
            echo '<strong>Warning:</strong> ' . $count;
            ?>
        </td>
    </tr>
    <?php
    if($notification > 0){
        ?>
        <tr>
            <td>
                <div class="contentMiniNotification">
                    <table class="contentMiniTable">
                        <?php
                        $ref = 1;
                        foreach($notification as $v){
                            ?>
                            <tr style="vertical-align: top;">
                                <td style="width: 10px;padding: 3px;">
                                    <?php
                                    echo $ref;
                                    ?>
                                </td>
                                <td style="font-weight: bold;width: 50px;">
                                    <?php
                                    echo $v->author_name . ':';
                                    ?>
                                </td>
                                <td style="max-width: 300px;word-wrap: break-word;">
                                    <?php
                                    echo $v->notification;
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $ref++;
                        }
                        ?>
                    </table>
                </div>
            </td>
        </tr>
        <?php
    }
    ?>
</table>