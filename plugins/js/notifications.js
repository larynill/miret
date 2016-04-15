$(function(e){
    var getNewNotification;
    var notificationArea = $('.notificationArea, .notificationMiniTable');
    var announcementBtn = $('.icon-announcement');
    var alertBtn = $('.icon-alert');
    var messageBtn = $('.msg-btn');
    var alertCount = 0;
    var messageCount = 0;
    var announcementCount = 0;
    var stillActive = 1;
    var initialInterval = 1000;

    var loading =
        '<ul class="dropdown-menu extended notification popArrow" style="width: 100%;">' +
            '<li style="text-align: left;vertical-align: top;padding: 7px 15px;font-size: 14px;">' +
                'Please wait... <img src="' + bu + 'plugins/img/ajax-loader.gif" width="16" style="float: right;" />' +
            '</li>' +
        '</ul>';

    // This part addresses an IE bug.  without it, IE will only load the first number and will never refresh
    $.ajaxSetup({ cache: false });

    if(notificationArea.length != -1){
        getNewNotification = notificationCount();
        var allowClose = false;

        $('html').click(function(e){
            if(allowClose){
                //this is to disable hiding
                //in case if class is noNotificationHide
                if($(e.target).is(":not(.noNotificationHide)")){
                    allowClose = false;

                    notificationArea.html('');
                }
            }
        });

        announcementBtn.click(function(e){
            e.stopPropagation();

            if(announcementCount){
                notificationArea
                    .css({
                        'margin': '12px -300px'
                    })
                    .html(loading)
                    .load(
                        bu + 'announcementsView?isMini=1',
                        function(e){
                            allowClose = true;
                            var wid = notificationArea.innerWidth();
                            notificationArea.css({
                                'margin': '12px -' + wid + 'px'
                            });
                        }
                    );
            }
        });

        alertBtn.click(function(e){
            e.stopPropagation();

            if(alertCount){
                notificationArea
                    .css({
                        'margin': '12px -330px'
                    })
                    .html(loading)
                    .load(
                        bu + 'notificationView?isMini=1&viewBy=warning',
                        function(e){
                            getNotificationCount();

                            allowClose = true;
                            var wid = notificationArea.innerWidth() + 30;
                            notificationArea.css({
                                'margin': '12px -' + wid + 'px'
                            });
                        }
                    );
            }
        });

        messageBtn.click(function(e){
            //e.stopPropagation();

            notificationArea
                .css({
                    'margin': '12px -365px'
                })
                .html(loading)
                .load(
                    bu + 'notificationView?isMini=1&viewBy=message&toPage=' + page_uri,
                    function(e){
                        getNotificationCount();

                        allowClose = true;
                        var wid = notificationArea.innerWidth() + 65;
                        notificationArea.css({
                            'margin': '12px -' + wid + 'px'
                        });
                    }
                );
        });

        //initiate that the user is Active
        setUserLocationStatus(1);

        //trace if User is Idle for 3 minutes
        $(document).idleTimer(30000);
        $( document ).on( "active.idleTimer", function(){
            if(stillActive == 0){
                setUserLocationStatus(1);
            }
        });
        $(document).on( "idle.idleTimer", function(){
            stillActive = 0;
            setUserLocationStatus(0);
        });
        $(document).ready(function(){
            //on Event if Browser has been CLOSED
            $(window).on('beforeunload', function(){
                stillActive = 0;
                setUserLocationStatus(0);
            });
        });

        getNewNotification = notificationCount();

    }

    function notificationCount(){
        return setTimeout(function() {
            getNotificationCount();
        }, initialInterval);
    }

    function getNotificationCount(){
        //disable the interval
        clearTimeout(getNewNotification);
        $.ajax({
            dataType: "json",
            url: bu + 'notificationCount?isMini=1',
            success: function(c){
                announcementCount = parseInt(announcementBtn.find('.badge').html());
                alertCount = parseInt(c.warning);
                messageCount = parseInt(c.message);

                alertBtn.html(alertCount > 0 ? '<span class="badge" style="right: 46px;">' + alertCount + '</span>' : '');
                messageBtn.html(messageCount > 0
                    ? '<i class="fa fa-envelope fa-fw"></i><span class="badge" style="margin: -5px;position: absolute">' + messageCount + '</span>'
                    : '<i class="fa fa-envelope fa-fw"></i>');
                //enable again
                initialInterval = 60000;
                getNewNotification = notificationCount();
            }
        });
    }

    function setUserLocationStatus(is_active){
        $.ajax({
            type: 'POST',
            cache: false,
            url: bu + 'setUserLocationStatus',
            data: {
                is_active: is_active,
                location: window.location.toString()
            }
        });
    }
});

jQuery.getNotificationCountFunction = function() {
    var alertBtn = $('.icon-alert');
    var messageBtn = $('.icon-message');

    $.ajax({
        dataType: "json",
        url: bu + 'notificationCount?isMini=1',
        success: function(c){
            var alertCount = parseInt(c.warning);
            var messageCount = parseInt(c.message);

            alertBtn.html(alertCount > 0 ? '<span class="badge" style="right: 46px;">' + alertCount + '</span>' : '');
            messageBtn.html(messageCount > 0
                ? '<i class="fa fa-envelope fa-fw"></i><span class="badge" style="position: absolute">' + messageCount + '</span>'
                : '<i class="fa fa-envelope fa-fw"></i>');
        }
    });
};