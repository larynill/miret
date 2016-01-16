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
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
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

            events: <?php echo $_assign_json; ?>,

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
                var tooltip = '<div class="tooltipevent" style="width: 30%;text-align: left"><span>'
                + event.job +'</span></div>';
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
			eventRender: function (event, element, view) {
				console.log(event.change_color);
			if(event.change_color){
				element.find('.fc-event-inner').addClass('change-color');
			}else{
				element.find('.fc-event-inner').removeClass('change-color');
			}
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

		companyName.click(function(e){
			var thisId = this.id;
			setInspectionArea
				.load('<?php echo base_url(); ?>client_info_hover/' + thisId + '/isquote');
			setInspection.removeClass('isactive');
			$(this).addClass('isactive');
		});
		
		quoteHover.hover(
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
		);
    });
</script>
<style>
	.change-color{
		background: #2b9b2c!important;
		border: none;
	}
	.setInspectionArea{
		position: absolute;
		z-index: 555;
		font-weight: normal!important;
		margin: 30px 0 0 120px;
	}
	.isactive{
		background: #a0a09f !important;
	}
	.setInspection{
		background: #494949;
		color: #ffffff;
	}
	.companyName{
		background: #d67915;
		color: #ffffff;
	}
	.data-area{
		position:absolute;
		margin: -5px 60px;
		z-index: 999;
	}
	.super-content>tbody>tr>td{
		text-align:center!important;
	}
	.super-content>tbody>tr>.quote-class{
		border-bottom: 1px solid #ffffff;
	}
	.notify{
		position: absolute;
		font-size: 11px;
		white-space: nowrap;
		margin: -6px 30;
		z-index: 55;
		background: #d10000;
		padding: 5px;
		border-radius: 10px;
		border: 1px solid #cbcbcb;
		color: #ffffff;
	}
	.notify strong{
		text-transform: uppercase;
	}
</style>
<!--popup window-->
<div id="modal" class="">
    <div id="heading">
        Inspection Assignment
    </div>
    <div id="modal_content">
        <table id="inspect">
            <?php
            if(count($_schedules) > 0){
                foreach($_schedules as $inspector){
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

<div class="grid_16">
    <br/><br/>
</div>
<!--<div class="grid_4">

</div>-->
<?php
$account_type = array(3);
if(in_array($this->session->userdata('userAccountType'),$account_type)){
?>
<div class="setInspectionArea"></div>
<div class="grid_3">
	<div class="content">
		<table style="width: 100%;">
    		<tr>
    			<td colspan="2" style="text-align: center;padding: 5px 10px;font-weight: bold;bold;border-bottom: 1px solid #d2d2d2;">Quotes</td>
    		</tr>
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
						<!--<td>
							<a href="<?php /*echo base_url();*/?>request/send_quote/<?php /*echo $qv->ID.'/'.$qv->TrackID;*/?>" class="m-btn green" style="padding: 5px!important;width: 50px;">Quote</a>
						</td>-->
					</tr>
				<?php }
			}else{?>
				<tr style="border-bottom: 1px solid #d2d2d2;text-align: center;">
					<td>
						No data
					</td>
				</tr>
			<?php
			}
			?>
    		<tr>
    			<td style="text-align: center;padding: 5px 10px;font-weight: bold;border-bottom: 1px solid #d2d2d2;">Jobs to Assign</td>
    		</tr>
    		<tr>
    			<td>
    				<?php
    				echo form_open('');
						?>
	    				<table style="width: 100%!important;">
							<?php
							if(count($assignment)>0){
								foreach($assignment as $ek=>$ev){?>
									<tr>
										<th style="text-align: center;font-weight:normal;background:<?php echo $ev->color;?>;padding: 5px;cursor: pointer;" class="setInspection"  id="<?php echo $ev->TrackID;?>">
											<?php echo $ev->CompanyName;?>
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
								<tr style="border-bottom: 1px solid #d2d2d2;text-align: center;">
									<td colspan="2">
										No data
									</td>
								</tr>
							<?php }
					echo form_close();
					?>
					</table>
    			</td>
    		</tr>
    	</table>
	</div>
</div>
<?php
}
?>
<?php
$account = array(1,2,6);
if(in_array($this->session->userdata('userAccountType'),$account)){
?>
	<div class="grid_3">
		<div class="content">
			<table class="super-content">
				<tr class="super-header">
					<td>Quotes Request List</td>
				</tr>
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
						<td style="border-bottom: 1px solid #d2d2d2">
							No Data
						</td>
					</tr>
				<?php }
				?>
				<tr class="super-header">
					<td>Job Request List</td>
				</tr>
				<?php
				if(count($assignment)>0){
					foreach($assignment as $ak=>$av){
						?>
						<tr>
							<td style="padding: 2px;text-align:center;background:<?php echo $av->color;?>;" class="quote-class">
								<span style="color: #ffffff;" id="<?php echo $av->id;?>" class="quote-hover">
									<?php echo $av->CompanyName?>
								</span>
								<span class="data-area" id="form_<?php echo $av->id;?>"></span>
							</td>
						</tr>
					<?php }
				}else{?>
					<tr>
						<td style="border-bottom: 1px solid #d2d2d2">
							No Data
						</td>
					</tr>
				<?php }
				?>
			</table>
		</div>
	</div>
<?php }
?>

<div class="grid_16" style="width: 90%!important;margin-left: 10%;">
	<div class="sixteen_column section">
		<div class="fifteen column">
			<div class="column_content">
				<?php
				if(in_array($this->session->userdata('userAccountType'),$account)){
				?>
					<div style="padding: 10px; ">
						<strong style="font-size: 20px; text-align: left; ">[Administration Calendar - Current Month Tracking] </strong>
						<a style="text-align: right" class="m-btn green" href="<?php echo base_url(). 'track/client/next'?>">Next Month</a>
					</div>
				<?php
				}
				?>
                <div style="text-align: right"></div>
                <div id='calendar'></div>
			</div>
		</div>
	</div>
</div>


<!--popup window style-->
<style>
	.super-content{
		width: 100%;
	}
	.super-content .super-header td{
		padding: 5px;
		text-align: center;
		border-bottom: 1px solid #d2d2d2;
		font-weight: bold;
	}
	.content{
		background-color: #e9e9e9;
		min-height: 200px;
		width:230px;
		position: absolute;
		margin-left: -10%;
		padding: 5px;
		font-size: 13px;
		border: 1px solid #444444
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