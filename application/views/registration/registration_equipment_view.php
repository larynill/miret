<style>
    .my-button{
        float: right;
        margin-bottom: 8px
    }
</style>
<script type="text/javascript">
    $(function(){
        var uTable = $('#example').dataTable( {
            "sScrollY": 300,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "aLengthMenu" : ["All"],
            "iDisplayLength" : -1
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );

        $('.my-button').click(function(e){
            var selectedID = this.id;
            $('.my-modal').bPopup({
                zIndex: 1000,
                modalClose: true,
                modalColor: 'rgba(0, 0, 0, 0.5)',
                onOpen: function(e){ //when open,fire this event.

                }
            });
        });

        $('.save').click(function(e){
			var hasEmpty = false;

			var emptyTitle = '';
			$('.required').each(function(e){
				$(this).css({
					border: '1px solid #CCC'
				});

				if(!$(this).val()){
					$(this).css({
						border: '1px solid #FF624C'
					});

					hasEmpty = true;
					emptyTitle = 'Please input the required field!';
				}
			});

			var msg = $('.msg');
			msg.html(emptyTitle);

			if(!hasEmpty){
				$.post(
					'<?php echo base_url() . 'registerClient'; ?>',
					$('input').serialize(),
					function(e){
						location.reload();
					}
				);
			}else{
				e.preventDefault();
			}
        });

		var colCount = 0;
		var submitbutton = $('#equipSave');
		$('.gradeX').each(function () {
			colCount++;
			//submitbutton.removeClass('disableButton');
		});
		if(colCount == 0){
			submitbutton.addClass('disableButton');
		}
    });
</script>

<h5 style="float:left; margin-top: 20px">
    <?php
    if(isset($_clientName)){
        echo 'Client Name: ' . $_clientName;
    }
    ?>

</h5>
<div class="m-btn my-button"  style="cursor: pointer">Add Equipment</div>
<!--<button class="m-btn green my-button" style="margin-bottom: 8px">Add Equipment</button>-->
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
    <tr>
        <th>Plant Description</th>
        <th>Equipment Number</th>
        <th>Type of Equipment</th>
        <th>Manufacturer</th>
        <th>Report Number</th>
        <th>Inspection Date</th>
        <th>Expiry Date</th>
    </tr>
    </thead>
    <tbody>
        <?php if(isset($_equipData)){
            if(count($_equipData) > 0){
                foreach($_equipData as $key => $value){
                ?>
                    <tr class="odd gradeX">
                        <td><?php echo $value['PlantDescription'];?></td>
                        <td><?php echo $value['EquipmentNumber'];?></td>
                        <td><?php echo $value['TypeEquipment'];?></td>
                        <td><?php echo $value['Manufacturer'];?></td>
                        <td><?php echo $value['LastReportNumber'];?></td>
                        <td><?php echo $value['InspectionDate'];?></td>
                        <td><?php echo $value['ExpectationDate'];?></td>
                    </tr>
                <?php
                }
            }
        }?>
    </tbody>
</table>
<!--<button class="m-btn green my-button">Add Equipment</button>-->
<div class="m-btn my-button"  style="cursor: pointer">Add Equipment</div>
<!--popup window-->
<div id="modal" class="my-modal">
    <div id="heading">
        Add Equipment
    </div>
    <div id="modal_content">
        <form >
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Plant Description: </label>
                        <input type="text"  id="PlantDescription" name="PlantDescription" class="required"/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Equipment Number: </label>
                        <input type="text"  name="EquipmentNumber" class="required"/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Certificate Number: </label>
                        <input type="text" id="" name="CertificateNumber" class="required"/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Type Of Equipment: </label>
                        <input type="text" class="" name="TypeEquipment" class="required"/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Manufacturer: </label>
                        <input type="text" id="" name="Manufacturer" class="required"/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Inspection Date: </label>
                        <input type="text" class="" id="date_inspection" name="InspectionDate" class="required"/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Expectation Date: </label>
                        <input type="text" class="date_picker" id="expiry-date" name="ExpectationDate" class="required"/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Frequency Of Inspection:  </label>
                        <input type="text" class="" id="date_frequency" name="" class="required"/>
                    </div>
                </div>
            </div>

            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Last Report Number: </label>
                        <input type="text" id="firstName" name="LastReportNumber" class="required"/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Has Equipment/IQP`s:  </label>
                        <input type="text" class="required" name="IQP" class="required"/>
                    </div>
                </div>
            </div>

            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Sold/Out Of Service: </label>
                        <input type="text" id="firstName" name="Sold" class="required"/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>SWL:  </label>
                        <input type="text" class="required" name="SWL" class="required"/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="sixteen column">
                    <div class="column_content">
                        <input type="submit" class="m-btn green save submit" value="Submit" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!--popup window style-->
<style>

    .my-modal {
        display:none;
        width:650px;
        padding:8px;

        background:rgba(0,0,0,.3);
        z-index:101;
    }

    .my-modal #heading {
       /* width:650px;*/
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

    .my-modal #modal_content {

        background:#fcfcfc;
        padding:10px 14px;
        -webkit-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        -moz-box-shadow:0px 1px 3px rgba(0,0,0,.25);
        box-shadow:0px 1px 3px rgba(0,0,0,.25);
    }

    .my-modal #modal_content p {
        font-size:14px;
        font-weight:normal;
        line-height:22px;
        color:#555555;
        width:100%;
        margin:0;
    }
</style>
