<script>
    $(document).ready(function() {
        var uTable = $('#example').dataTable( {
            "sScrollY": 475,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bLengthChange": false
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );

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
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
			//droppable: true, // this allows things to be dropped onto the calendar !!!
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
            events : <?php echo $_assign_json; ?>,

            // if the event is dropped, get the start time to be used in the post.
            eventDrop: function(event, delta){
                var start = $.fullCalendar.formatDate(event.start, 'yyyy-MM-dd');
                var post_data = {
                    dropToDate: true,
                    InspectionDate: start,
                    ID: event.id
                };
                $.post(
                    '',
                    post_data,
                    function(result){
                        console.log(result);
                        //callback function
                    }
                );
            },
            eventMouseover: function(event){
                var tooltip = '<div class="tooltipevent" style="text-align: left;width: 30%;"><span style="font-weight: bold;">'
                    + event.job +'</span><br/><span style="white-space: nowrap">Distance: <strong>'+ event.distance
					+'</strong></span><br/>' + '<span> Equipment:<br/>' +
					'<strong id="appendHere">' +
					$.each(event.equipment, function(key,value){
						//appendhere = '<span>'+ value + '</span>';
						//$('#appendHere').html(appendhere);

					})
					+'</strong>' +

					'</span></div>';
                $("body").append(tooltip);

                $(this).each(function(index){
                    $(this).css(
                        'z-index', 99999
                    );
                    $('.tooltipevent').fadeIn('500');
                    $('.tooltipevent').fadeTo('10', 1.9);

                }).mousemove(function(e) {
                        $('.tooltipevent').css('top', e.pageY - 5);
                        $('.tooltipevent').css('left', e.pageX + 30);
                    });

            },

            eventMouseout: function(event){
                $(this).css(
                    'z-index', 8
                );
                $('.tooltipevent').remove();
            },
			eventClick: function(calEvent, jsEvent, view){
				window.location.href = '<?php echo base_url();?>inspection_report/report/' + calEvent.id;
			},
			eventRender: function (event, element, view) {
				if(event.change_color_class){
					element.find('.fc-event-inner').addClass('change-color');
				}else{
					element.find('.fc-event-inner').removeClass('change-color');
				}
			}
		});

		var setInspection = $('.setInspection');
		var setInspectionArea = $('.setInspectionArea');
		setInspection.click(function(e){
			var thisId = this.id;
			
			var hei = setInspectionArea.innerHeight();
			setInspectionArea
				.load('<?php echo base_url(); ?>client_info_hover/' + thisId)
				css({
					marginTop: '-' + hei + 'px!important'
				}); 
		});
    });
</script>
<style>
	.setInspectionArea{
		position: absolute;
		z-index: 999;
		margin: 90px 210px;
	}
	.change-color{
		background: #2b9b2c!important;
		border: none;
	}
</style>

<div class="setInspectionArea"></div>

<!--popup window-->
<?php
$account = array(4);
if(in_array($this->session->userdata('userAccountType'),$account)):
?>
<div id="modal" class="">
    <div id="heading">
        Inspection Assignment
    </div>
    <div id="modal_content">
        <table id="inspect">
            <?php
            if(count($_inspectors) > 0){
                foreach($_inspectors as $inspector){
                    ?>
                    <tr>
                        <td>
                            <a href="#" class="thumbnail">
                                <img src="<?php echo base_url(); ?>plugins/img/photo_60x60.jpg" width="60" height="60" alt="photo" />
                            </a>
                        </td>
                        <td>
                            <div class="modal_element">
                                <p>
                                    <span class="name-title"><?php echo $inspector->Username?></span><br/>
                                    <span class="name-description">Inspector</span><br/>
                                    Registered since <?php echo date('F d, Y', strtotime($inspector->DateRegistered)); ?>
                                </p>
                            </div>
                        </td>
                        <td class="table-button">
                            <button class="m-btn blue" id="<?php echo $inspector->ID; ?>" >Assign Now</button>
                        </td>
                    </tr>
                <?php
                }
            }
            else{
                ?>
                <div id="error">
                    No Inspectors Available
                </div>
            <?php
            }
            ?>

        </table>
    </div>
</div>
<?php
endif;
?>
<div class="grid_16">
    <br/><br/>
</div>
<!--<div class="grid_4">

</div>-->

<div class="grid_16">
    <div class="sixteen_column section">
        <?php
        $account = array(4);
        if(in_array($this->session->userdata('userAccountType'),$account)):
        ?>
        <div class="one column">
            <div class="column_content">
            	<table class="jobAssignTable">
            		<tr class="headerTr">
        				<td>No Pending Inspection</td>
            		</tr>
					<?php
		            if(count($_assign) > 0){
		                foreach($_assign as $v){
		                    ?>
		                    <tr>
								<td <?php echo $v->InspectionIsSet ? '' : 'class="setInspection"'; ?> style="cursor: pointer;white-space: nowrap;" id="<?php echo $v->ID; ?>">
									<?php 
									echo $v->CompanyName;
									echo $v->InspectionIsSet ? '<br />Inspection Date: <strong>' . date('d/m/Y', strtotime($v->InspectionDate)) . '</strong>' : '';
									?>
								</td>
							</tr>
		                <?php
		                }
		            }else{
		            	?>
		                <tr>
		                    <td style="text-align: center;">
		                    	No Scheduled Inspection
		                 	</td>
		                </tr>
		            	<?php
		            }
		            ?>
	            </table>
            </div>
        </div>
        <?php
        endif;
        ?>
        <div class="fifteen column">
            <div class="column_content">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>

<!--popup window style-->
<style>
	.jobAssignTable{
		border-collapse: collapse;
		font-size: 12px;
		width: 200px;
		border: 1px solid #000000;
	}
	.jobAssignTable tr td{
		padding: 5px 10px;
	}
	.jobAssignTable .headerTr td{
		text-align: center;
		background: #000000;
		color: #ffffff;	
	}
	
    #modal {
        display:none;
        width:600px;
        padding:8px;

        background:rgba(0,0,0,.3);
        z-index:101;
    }

    #heading {
        width:600px;
        height:44px;

        background-color: coral;
        border-bottom:1px solid #bababa;

        -webkit-box-shadow:
            inset 0px -1px 0px #fff,
            0px 1px 3px rgba(0,0,0,.08);
        -moz-box-shadow:
            inset 0px -1px 0px #fff,
            0px 1px 3px rgba(0,0,0,.08);
        box-shadow:
            inset 0px -1px 0px #fff,
            0px 1px 3px rgba(0,0,0,.08);

        font-size:18px;
        text-align:center;
        line-height:44px;
        color:#ffffff;

    }

    #modal_content {
        width:600px;
        background:#fcfcfc;

        -webkit-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        -moz-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        box-shadow:0px 1px 3px rgba(0,0,0,.25);
    }


    #modal_content p {
        font-size:14px;
        font-weight:normal;
        line-height:22px;
        color:#555555;
        width:100%;
        margin:0;
    }

</style>

<!--external events style-->
<style>

    #external-event-group {
        /*      float: left;
              width: 150px;
              padding: 0 10px;
              border: 1px solid #ccc;

              text-align: left;
              background-color: orange;*/
    }

    #external-event-group {

    }

    .external-event-title{
        background-color: #428EB4;
        padding: 10px 14px;
        color: #fff;
        text-align: center;
        cursor: pointer;
        font-size: 14px;
    }

    .external-event { /* try to mimick the look of a real event */
        margin: 2px 0;
        /*background: coral;*/
        color: #333333;
        height: auto;
        font-size: 14px;

        cursor: pointer;
    }

    #external-events p {
        margin: 1.5em 0;
        font-size: 12px;
        color: #666;
    }
    .external-event:hover{
        background: #428EB4;
        color: #fff;
    }

    .little-emphasis{
        font-size: 12px;
        font-style: italic;
    }

    #external-events p input {
        margin: 0;
        vertical-align: middle;
    }

    .isAssigned{
        background-color: #35aa47;
        color: #fff;
    }
    .isAssigned:hover{
        background-color: #35aa47;
    }


</style>

<!--tooltip style-->
<style>
    .tooltipevent{
        z-index:10001;
        position:absolute;
        width: 12%;height: auto;
        line-height:20px; padding:10px;
        font-size: 12px;text-align: center;
        color: #222222; background: rgb(255, 255, 255);
        border: 1px solid #c7c7c7; border-radius: 0;
        text-shadow: rgba(0, 0, 0, 0.0980392) 1px 1px 1px;
        box-shadow: rgba(0, 0, 0, 0.0980392) 1px 1px 2px 0px;
    }

    .tooltipevent span:after{
        content : "";
        position : absolute;
        width: 0;
        height: 0;
        border-color: ;
        border-width : 10px;
        border-style : solid;
        border-color : transparent #FFFFFF transparent transparent;
        top : -1px;
        left : -20px;
    }

</style>

<!--popup window table-->
<style>
    #error{
        text-align: center;
        padding: 40px;
    }
    #inspect table{
        width: inherit;
        margin: 0;
    }
    #inspect td{
        padding: 10px 10px;

        width: 33%;
    }
    #inspect td:first-child{
        width: 10%;
    }

    #inspect td.table-button {
        width: 10%;
        padding: 20px 0 0 0;
        text-align: center;
    }
    #inspect td p {
        line-height: 18px;
    }
    #inspect td .name-title{
        font-size: 20px;
        font-weight: bold;

    }
    #inspect td .name-description{
        font-size: 14px;
        /*font-weight: bold;*/
        font-style: italic;

    }
    #inspect tr{
        border-bottom: 1px dashed #DDDDDD;
    }
    #inspect tr:hover{
        background-color: rgba(232, 232, 232, 0.5)
    }
    #inspect tr:last-child{
        border: none;
    }
    #inspect a.thumbnail img{
        padding:4px;
        border:1px solid #bbb;
        background:#fff;
    }

</style>