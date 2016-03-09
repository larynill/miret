<script>
    $(function(e){
        var contentMiniTable = $('.contentMiniTable');
        var notificationMiniTable = $('.notificationMiniTable');
        var wid = contentMiniTable.innerWidth() + 5;

        notificationMiniTable.css({
            width: wid + 'px',
            'margin-left': '90px'
        });

        var hideMessage = $('.hideMessage, .hideAllNotification');
        var messageCountElement = $('.messageCount');
        var loading = 'Please wait... <img src="' + bu + 'plugins/img/ajax-loader.gif" width="16" style="float: right;" />';

        hideMessage.click(function(e){
            var thisId = this.id;

            var element = $('.message_' + thisId);
            var replace = element;
            var url = bu + 'notificationHide/' + thisId;
            var pleaseWait = '<td colspan="2" class="title">' + loading + '</td>';

            var hideAll = $(this).hasClass('hideAllNotification');
            if(hideAll){
                pleaseWait = '<tr><td class="title">' + loading + '</td></tr>';
                element = $('.message');
                replace = $('.contentMiniTable');
                url = bu + 'notificationHide?hideAll=1';

                $('.hideAllNotification').parent('tr').html('');
            }
            replace.html(pleaseWait);
            $.post(
                url,
                function(e){
                    $.getNotificationCountFunction();

                    var msgCount = parseInt(messageCountElement.html()) - parseInt(element.length);

                    messageCountElement.html(msgCount.toString());
                    replace.remove();

                    if(msgCount == 0){
                        $('.notificationArea').html('');
                    }
                }
            );
        });
    });
</script>
<style>
    .notificationMiniTable{
        border-collapse: collapse;
        width: 100%;
        min-width: 360px;
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
        width: 100%;
        max-height: 350px;
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

    .notificationLinkTable{
        width: 100%;
        border-collapse: collapse;
    }
    .notificationLinkTable tr{
        vertical-align: top;
    }
    .notificationLinkTable tr td{
        padding: 3px 5px;
    }
    .notificationLink:hover .notificationLinkTable tr td,
        .hideAllNotification:hover{
        background: #eee;

    }

    .hideAllNotification{
        cursor: pointer;
    }
</style>

<table class="notificationMiniTable popArrow">
    <tr>
        <td class="title">
            <?php
            $count = count($notification);
            echo '<strong>New Message:</strong> <span class="messageCount">' . $count . '</span>';
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
                        foreach($notification as $v){
                            ?>
                            <tr class="message message_<?php echo $v->id; ?>" style="vertical-align: top;">
                                <td style="font-weight: bold;width: 50px;white-space:nowrap!important;text-align: right;">
                                    <?php
                                    echo '<div style="text-align: right;width: 100px;white-space: normal;">' . $v->author_name . '</div>';
                                    echo '<span class="icon-no-data-black hideMessage noNotificationHide" id="' . $v->id . '"></span>';
                                    echo '<span style="font-size: 10px;font-weight: bold;float: right">' . date('d/m/Y h:i a', strtotime($v->date)) . '</span>';
                                    ?>
                                </td>
                                <td style="width: 2px;vertical-align: middle">:</td>
                                <td style="max-width: 400px;word-wrap: break-word;padding: 5px;vertical-align: middle">
                                    <?php
                                    echo $v->notification;
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </td>
        </tr>
        <?php
    }

    if($count > 0){
        ?>
        <tr>
            <td class="hideAllNotification noNotificationHide" style="padding: 3px 5px;">
                Hide all the Messages
            </td>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td>
            <a href="<?php echo base_url() . 'notificationView?viewBy=message&toPage=' . $toPage; ?>" class="notificationLink" style="color: #000000;">
                <table class="notificationLinkTable">
                    <tr>
                        <td>View all the Messages</td>
                        <td>
                            <span class="m-icon-swap-right" style="float: right;top: 0;"></span>
                        </td>
                    </tr>
                </table>
            </a>
        </td>
    </tr>
</table>