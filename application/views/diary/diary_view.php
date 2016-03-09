<script>
    $(function() {
        /*var uTable = $('#example').dataTable( {
         "sScrollY": 475,
         "bJQueryUI": true,
         "sPaginationType": "full_numbers",
         "bLengthChange": false
         } );
         $(window).bind('resize', function () {
         uTable.fnAdjustColumnSizing();
         } );*/

        var viewInspector = $('.viewInspector');
        var hideButton = $('.hideButton');

        viewInspector.click(function(e){
            $('#form_'+$(this).data('val')).slideToggle("slow");
            $(this).fadeOut("slow");
        });

        hideButton.click(function(e){
            $('#form_'+this.id).fadeOut("slow");
            $('#thisButtonView_'+this.id).fadeIn("slow");
        });

        var date = new Date();

        /* initialize the external events
         -----------------------------------------------------------------*/
        var counter = 0;
        $('div.external-event').each(function(e) {
            $('.isAssigned').draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0,  //  original position after the drag
                drag: function(e){

                }
            });

            $('.notAssigned').selectable({
                selected:function(e){
                    var clientID = this.id;
                    $('#modal').bPopup({
                        appendTo: '#calendar',
                        zIndex: 1000,
                        modalColor: 'rgba(0, 0, 0, 0.5)',
                        onOpen: function(e){ //when open,fire this event.
                            $('.m-btn').click(function(e){
                                $.post(
                                    '<?php echo base_url() . 'diary'?>',
                                    {
                                        assign: true,
                                        userID: this.id,
                                        clientID: clientID
                                    },
                                    function(post_data){
                                        //console.log(post_data);
                                        location.reload();
                                    }
                                );
                            });
                        }
                    });
                }
            });

            $('.no-jobs').selectable("disable");

            var eventObject = {
                title: $.trim($(this).text()), // use the element's text as the event title
                id: this.id
            };

            $(this).data('eventObject', eventObject);
        });


        /* initialize the calendar
         -----------------------------------------------------------------*/
        $('.calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            firstDay: 1,
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            renderView : function(view){
                if(view.start <= new Date()){
                    header.disableButton('prev');
                }else{
                    header.enableButton('prev');
                }

            } ,
            drop: function(start, allDay) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                // assign it the date that was reported

                copiedEventObject.start = start;
                copiedEventObject.allDay = allDay;
                $.post(
                    '<?php echo base_url();?>diary',
                    {
                        dropToCalendar: true,
                        id: originalEventObject.id, // the client ID
                        startTime: $.fullCalendar.formatDate(start, 'yyyy-MM-dd'),
                        allDay: copiedEventObject.allDay
                    },
                    function(e){
                        console.log(e);
                        //location.reload();
                    }
                );

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
                $(this).remove();
            },

            events: <?php echo $_schedules; ?>,

            // if the event is dropped, get the start time to be used in the post.
            eventDrop: function(event, delta){
                var start = $.fullCalendar.formatDate(event.start, 'yyyy-MM-dd');
                var post_data = {
                    dropToDate: true,
                    InspectionDate: start,
                    ID: event.id
                };

                $.post(
                    '<?php echo base_url();?>diary',
                    post_data,
                    function(result){
                        console.log(result);
                        //callback function
                    }
                );
            },

            eventMouseover: function(event){

                var el = '<div class="tooltip right" role="tooltip">';
                el += '<div class="tooltip-arrow"></div>';
                el += '<div class="tooltip-inner" style="text-align: left;">';
                el += '<strong>' + event.title + '</strong><br/>';
                //el += event.event_type == 1 || event.event_type == 3 ? event.description : '';
                el +='</div>';
                el += '</div>';
                $("body").append(el);
                $(this).each(function(index){
                    $(this).css(
                        'z-index', 99999
                    );
                    $('.tooltip')
                        .fadeIn('500')
                        .fadeTo('10', 1.9);

                }).mousemove(function(e) {
                    $('.tooltip')
                        .css('top', e.pageY - 40)
                        .css('left', e.pageX + 5);
                });

            },

            eventMouseout: function(event){
                $(this).css(
                    'z-index', 8
                );
                $('.tooltip').remove();
            },
            eventRender: function (event, element) {
                element
                    .css({
                        'background': event.bg_color,
                        'color': '#000000',
                        'border':  event.bg_color
                    })
                    .find('.fc-event-title').html(event.title);

            }

        });

        var setInspection = $('.setInspection');
        //var setInspectionArea = $('.setInspectionArea');
        var companyNameDetailArea = $('.companyNameDetailArea');
        var companyName = $('.companyName');
        var closeBtn = $('.closeBtn');
        var setInspectionArea = $('.setInspectionArea');
        var quoteHover = $('.quote-hover');
        var dataArea = $('.data-area');
        setInspection.click(function(e){
            var thisId = this.id;
            setInspectionArea
                .load(
                '<?php echo base_url(); ?>client_info_hover/' + thisId,
                function(e){
                    var hei = setInspectionArea.innerHeight();
                    /*console.log(hei);
                     setInspectionArea.css({
                     margin: hei + 'px!important'
                     });*/
                    setInspection.css('margin-left', hei + 'px');
                }
            );
            $(this).addClass('isactive');
            companyName.removeClass('isactive');
        });

        /*companyName.click(function(e){
            var thisId = this.id;
            setInspectionArea
                .load('<?php echo base_url(); ?>client_info_hover/' + thisId + '/isquote');
            setInspection.removeClass('isactive');
            $(this).addClass('isactive');
        });*/

        /*quoteHover.hover(
            function(event){
                var thisId = this.id;
                dataArea.each(function(event){
                    $(this).html('');
                });
                $('#form_' + thisId).load('<?php echo base_url(); ?>client_info_hover/' + thisId );
            },
            function(event){
                dataArea.each(function(event){
                    $(this).html('');
                });
            }
        );*/
    });
</script>
<!--popup window-->


<div class="row">
    <div class="col-sm-4">
        <?php
        $account_type = array(3);
        if(in_array($this->session->userdata('userAccountType'),$account_type)){
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">Quotes</div>
                <div class="panel-body">
                    <table style="width: 100%;">
                        <?php
                        if(count($qoutes)>0){
                            foreach($qoutes as $qk=>$qv){?>
                                <tr style="border-bottom: 1px solid #d2d2d2;" class="companyName" id="<?php echo $qv->TrackID;?>">
                                    <td style="padding: 5px;text-align:center;cursor: pointer;background: <?php echo $qv->color;?>" title="Click to view details">
                                        <?php
                                        echo $qv->CompanyName;
                                        echo $qv->notification;
                                        ?>
                                    </td>
                                </tr>
                            <?php }
                        }else{?>
                            <tr>
                                <td>
                                    No data was found.
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">Jobs to Assign</div>
                <div class="panel-body">
                    <table style="width: 100%!important;">
                        <?php
                        if(count($assignment)>0){
                            foreach($assignment as $ek=>$ev){?>
                                <tr>
                                    <th style="text-align: center;font-weight:normal;background:<?php echo $ev->color;?>;padding: 5px;cursor: pointer;" class="setInspection"  id="<?php echo $ev->TrackID;?>">
                                        <?php echo $ev->project_name;?>
                                    </th>
                                </tr>
                                <tr>
                                    <td style="padding: 5px 0;">
                                        <input type="hidden" name="TrackID" value="<?php echo $ev->TrackID;?>">
                                        <input type="button" name="inspector" value="Assign" class="m-btn green viewInspector" title="Click to Add Inspector" style="padding: 5px!important;width: 100px;" id="thisButtonView_<?php echo $ev->id;?>" data-val="<?php echo $ev->id;?>">
                                    </td>
                                </tr>
                                <tr class="toggleThis" id="form_<?php echo $ev->id;?>" style="display: none;">
                                    <td style="width: 100%;">
                                        <table style="width: 100%;border-collapse: collapse;">
                                            <?php
                                            if(count($ev->inspector)>0){
                                                $ref = 0;
                                                foreach($ev->inspector as $ik=>$iv){
                                                    ?>
                                                    <tr style="border-bottom: 1px solid #d2d2d2">
                                                        <td style="text-align: center!important;">
                                                            <input type="hidden" name="AssignId" value="<?php echo $ev->id; ?>" />
                                                            <input type="radio" name="UserID[<?php echo $ev->id;?>]" value="<?php echo $iv->ID;?>" style="width: 20px;" <?php echo $ref == 0 ? 'checked="checked"' : ''; ?>>
                                                        </td>
                                                        <td>
                                                            <?php echo $iv->FName.' '.$iv->LName.' (<strong>'.$ev->jobs.' jobs</strong>)';?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $ref++;
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="2">
                                                    <input type="submit" name="submit" value="Submit" class="m-btn green hideButton" style="padding: 5px!important;width: 100px;">
                                                    <input type="button" name="inspector" value="Close" class="m-btn green hideButton" style="padding: 5px!important;width: 100px;" id="<?php echo $ev->id;?>">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            <?php }
                            $ref = 0;
                        }else{?>
                            <tr>
                                <td colspan="2">
                                    No data was found.
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </table>
                </div>
            </div>
        <?php
        }
        $account = array(1,2,6);
        if(in_array($this->session->userdata('userAccountType'),$account)){
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">Quotes Request List</div>
                <div class="panel-body">
                    <table style="width: 100%">
                        <?php
                        if(count($qoutelist)>0){
                            foreach($qoutelist as $qk=>$qv){
                                ?>
                                <tr>
                                    <td style="padding: 2px;text-align:center;background: <?php echo $qv->color;?>;" class="quote-class">
                            <span style="color: #ffffff;"  class="quote-hover" id="<?php echo $qv->ID;?>">
                                <?php
                                echo $qv->CompanyName;
                                ?>
                            </span>
                                        <?php
                                        echo $qv->notification;
                                        ?>
                                        <span class="data-area" id="form_<?php echo $qv->ID;?>"></span>
                                    </td>
                                </tr>
                            <?php }
                        }else{?>
                            <tr>
                                <td>
                                    No data was found.
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </table>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">Job Request List</div>
                <div class="panel-body">
                    <table style="width: 100%">
                        <?php
                        if(count($assignment)>0){
                            foreach($assignment as $ak=>$av){
                                ?>
                                <tr>
                                    <td style="padding: 2px;text-align:center;background:<?php echo $av->color;?>;" class="quote-class">
                            <span style="color: #ffffff;" id="<?php echo $av->id;?>" class="quote-hover">
                                <?php echo $av->project_name;?>
                            </span>
                                        <span class="data-area" id="form_<?php echo $av->id;?>"></span>
                                    </td>
                                </tr>
                            <?php }
                        }else{?>
                            <tr>
                                <td>
                                    No data was found.
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </table>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading">Items to Action</div>
            <div class="panel-body">
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="calendar"></div>
    </div>
</div>
<!--popup window style-->
<style>
	.panel{
        font-size: 12px;
    }
</style>