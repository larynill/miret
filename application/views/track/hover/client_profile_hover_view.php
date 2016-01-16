<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'plugins/css/buttons/pattern-buttons.css'; ?>"/>
<script type="text/javascript">
    $(function(e){
        var uTable = $('#example').dataTable( {
            "sScrollY": 200,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bLengthChange": false
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );
        var history = $('#jobs_table').dataTable( {
            "sScrollY": 200,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bLengthChange": false
        } );
        history.fnAdjustColumnSizing();
        $('.add-equipment').click(function(e){
            $('#addModal').bPopup({
                zIndex: 1000,
                modalClose: true,
                closeClass: '.closeModal',
                modalColor: 'rgba(0, 0, 0, 0.5)',
                onOpen: function(e){ //when open,fire this event.
                    var formAddEquipModal = $('#formAddEquipModal');
                    formAddEquipModal.submit(function(e){
                        e.preventDefault();
                    });
                    $('#addEquipSave').click(function(e){
                        var isEmpty = false;
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
                                emptyTitle = 'Empty <strong>' + $(this).attr('title') + '</strong> Field!';
                                $('.errorMessage').html(emptyTitle);
                            }
                            isEmpty = true;
                        });

                        if(hasEmpty){
                            e.preventDefault();
                        }
                        else{
                            $.post(
                                '',
                                formAddEquipModal.serialize(),
                                function(e){
                                    //console.log(e);
                                    location.reload();
                                    uTable.fnDraw();
                                }
                            );
                        }
                    });
                }
            });
        });
        $('.date_picker').datepicker();
        var inspect = $('#date_inspection');
        var frequency = $('#date_frequency');
        inspect.datepicker({
            minDate: new Date(),
            inline: true,
            onSelect: function(e){
                var d1 = new Date($(this).val());
                var d2 =  new Date();
                if(d1 < d2){
                    alert('ERROR: Cannot calculate the frequency of a past date');
                    e.preventDefault();
                }

                //get the number of days if less than one month
                if(monthDiff(d2,  d1) <= 0){
                    frequency.attr(
                        'value', days() + ' days'
                    );
                }
                else if(monthDiff(d2,  d1)  == 1){
                    frequency.attr(
                        'value', monthDiff(d2,  d1) + ' month'
                    );
                }
                else {
                    frequency.attr(
                        'value', monthDiff(d2,  d1) + ' months'
                    );
                }

                var expiryDate = d1;
                $('#expiry-date').attr(
                    'value', (expiryDate.getMonth() + 1) +'/' + expiryDate.getDate() + '/' + (expiryDate.getFullYear() + 1)
                );
            }
        });
        function monthDiff(d1, d2) {
            var months;
            months = (d2.getFullYear() - d1.getFullYear()) * 12;
            months -= d1.getMonth() + 1;
            months += d2.getMonth();
            return months + 1;
        }
        function days() {
            var a = new Date(),
                b = $("#date_inspection").datepicker('getDate').getTime(),
                c = 24*60*60*1000,
                diffDays = Math.round(Math.abs((a - b)/(c)));

            return diffDays;

        }

        $('.edit_profile').click(function(e){
            $('#editModal').bPopup({
                zIndex: 1000,
                closeClass: '.close',
                modalClose: false,
                modalColor: 'rgba(0, 0, 0, 0.5)',
                onOpen: function(e){
                    var editForm = $('#formEditModal');
                    $('.save_edit').click(function(e){
                        editForm.submit(function(e){
                           e.preventDefault();
                        });
                        var selectedID = this.id;
                       $.post(
                            '',
                            editForm.serialize(),
                            function(post){
                                //console.log(post);
                                location.reload();
                            }
                        );
                    });
                }
            });
        });
    });
</script>
<style>
    #example{

    }
    #example .odd{
        background-color: #e9e9e9;
    }
    #example .even{
        background-color: #f3f3f3;
    }
    #addModal{
        width: 650px;
    }
    #editModal{
        width: 850px;
    }

</style>

<?php
    if(count($_clientData) > 0){
        foreach($_clientData as $client){
            $clientID = $client->ID;
            $clientFName = $client->FirstName;
            $clientLName = $client->LastName;
            $clientName = $client->FirstName . ' ' . $client->LastName;
            $clientCompany = $client->CompanyName;
            $clientDateRegistered = date('F d Y', strtotime($client->DateRegistered));
            $clientPostal = $client->PostalAdress;
            $clientPersonInCharge = $client->PersonInCharge;
            $clientMobilePhone = $client->MobilePhone;
            $clientFaxNumber = $client->FaxNumber;
            $clientEmail = $client->Email;
            $clientLastUpdate =date('d/m/Y', strtotime( $client->LastUpdate));
            $clientNotes = $client->Notes;
            eval($client->PhysicalAddress);
            $clientAddress = $address['address'];
            $clientCity = $address['city_id'];
            $clientCountry = $address['country_id'];
            $clientZip = $address['zip'];
            $designation = $client->AreaDesignationID;
            $workPhone = json_decode($client->WorkPhone);
            $phoneArea = $workPhone->area_code;
            $phoneNumber = $workPhone->number;
            $phoneExt = $workPhone->ext;
            $prohibit = false;
            if( $client->StatusID == 2){
                $prohibit = true;
            }


            foreach($_areaDesignationData as $area){
                if($area->ID == $client->AreaDesignationID){
                    $clientDesignationArea = $area->Area;
                }
            }
            foreach($_status as $status){
                if($client->StatusID == $status->ID){
                     $clientStatus = $status->Status;

                }
            }

            //get equipment data
            foreach($_equipmentData as $e){
                $inspectionDate = date('F d Y', strtotime($e->InspectionDate));
                $certificateNumber = $e->CertificateNumber;
                $plantDescription = $e->PlantDescription;
                $onePiece = $e->OnePiece;
                $moreThanOne = $e->MoreThanOne;
                $sold = $e->Sold;
                $SWL = $e->SWL;
                $typeEquipment = $e->TypeEquipment;
                $manufacturer = $e->Manufacturer;

                $expectationDate = $e->ExpectationDate;
                $lastReportNumber = $e->LastReportNumber;
                $IQP = $e->IQP;
                $notes = $e->Notes;
            }

            //get accounting data
            foreach($_accountingData as $a){
                $accountingName = $a->FirstName . ' ' . $a->LastName;
                $accEmail = $a->Email;
                $accAddress = $a->AccountAddress;
                $accAddress2 = $a->PhysicalAddress;
                $accPostalAddress = $a->PostalAddress;
            }
        }
    }
?>
<div class="grid_16">
    <div class="box">
        <h2>
            <a href="#" id="toggle-articles">Profile Information</a>
        </h2>
        <div class="block" id="articles">
            <div class="first article">
                <div class="sixteen_column section">
                    <div class="fourteen column">
                        <div class="column_content">
                            <button  style="float: right" class="m-btn edit_profile">Edit Profile</button>
                            <a href="#" class="image">
                                <img src="<?php echo base_url() . 'plugins/img/photo_60x60.jpg'?>" width="60" height="60" alt="photo" />
                            </a>
                            <h3>
                                <a href="#"><?php echo $clientName; ?></a>
                            </h3>

                            <h4><?php echo $clientCompany; ?></h4>
                            <p class="meta">Status: <?php echo $clientStatus; ?>  — Registered since: <?php echo $clientDateRegistered; ?></p>

                        </div>
                    </div>
                </div>
                <div class="sixteen_column section">
                    <div class="five column">
                        <div class="column_content">
                            <strong>Postal Address</strong><br/>
                            <p><?php echo $clientPostal; ?></p>
                            <strong>Person In Charge</strong><br/>
                            <p><?php echo $clientPersonInCharge; ?></p>
                            <br/>
                            <strong>Mobile Phone</strong><br/>
                            <p><?php echo $clientMobilePhone; ?></p>
                            <br/>
                            <strong>Fax Number</strong><br/>
                            <p><?php echo $clientFaxNumber; ?></p>
                            <br/>
                            <strong>Email</strong><br/>
                            <p><?php echo $clientEmail; ?></p>
                            <br/>
                            <strong>Last Update</strong><br/>
                            <p><?php echo $clientLastUpdate; ?></p>
                            <br/>
                            <strong>Area Designation</strong><br/>
                            <p><?php echo $clientDesignationArea; ?></p>
                            <br/>
                            <strong>Notes</strong><br/>
                            <?php echo $clientNotes;?>
                            <br/><br/>

                        </div>
                    </div>
                    <div class="eleven column" id="table_container">
                        <div class="column_content">
                            History
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="jobs_table" >
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Job Number</th>
                                    <th>Client</th>
                                    <th>Description</th>
                                </tr>
                                </thead>
                                <tbody class="table-content">

                                </tbody>
                            </table>
                            <br/><br/>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="box">
        <h2>
            <a href="#" id="toggle-forms">Equipment Information</a>
        </h2>
        <div class="block" id="forms">
            <button class="m-btn add-equipment" style="margin-bottom: 10px; float: right">Add Equipment</button>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th>Plant Description</th>
                    <th>Equipment Number</th>
                    <th>Type of Equipment</th>
                    <th>Manufacturer</th>
                    <th>Report Number</th>
                    <th>Inspection Date</th>
                    <th>Expectation Date</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    if(count($_clientData) > 0){
                        foreach($_clientData as $client){
                            $equipCount = 0;
                            $equipment = array();
                            if(count($_equipmentData) > 0){
                                foreach($_equipmentData as $equip){
                                    if($equip->ClientID == $client->ID){
                                        $e1 = $equip->PlantDescription;
                                        $e2 = $equip->EquipmentNumber;
                                        $e3 = $equip->TypeEquipment;
                                        $e4 = $equip->Manufacturer;
                                        $e5 = $equip->LastReportNumber;
                                        $e6 = date('F d, Y', strtotime($equip->InspectionDate));
                                        $e7 = date('F d, Y', strtotime($equip->ExpectationDate));
                                        $equipCount++;
                                        ?>
                                        <tr>
                                            <td><?php echo $e1 ?></td>
                                            <td><?php echo $e2 ?></td>
                                            <td><?php echo $e3 ?></td>
                                            <td><?php echo $e4; ?></td>
                                            <td><?php echo $e5; ?></td>
                                            <td><?php echo $e6; ?></td>
                                            <td><?php echo $e7; ?></td>

                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="sixteen_column section">
        <div class="eight column">
            <div class="column_content">

            </div>
        </div>
        <div class="eight column" >
        </div>
    </div>
</div>



<!--popup window-->
<div class="modal" id="addModal">
    <div id="heading">
        Add Equipment
    </div>
    <div id="modal_content">
        <form id="formAddEquipModal">
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Plant Description: </label>
                        <input type="text"  id="PlantDescription" name="PlantDescription" class="required" title="Plant Description"/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Equipment Number: </label>
                        <input type="text"  name="EquipmentNumber" class=""/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Certificate Number: </label>
                        <input type="text" id="" name="CertificateNumber" class=""/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Type Of Equipment: </label>
                        <input type="text" class="" name="TypeEquipment" class=""/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Manufacturer: </label>
                        <input type="text" id="" name="Manufacturer" class=""/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Inspection Date: </label>
                        <input type="text" class="" id="date_inspection" name="InspectionDate" class="required" title="Inspection Date"/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Expectation Date: </label>
                        <input type="text" class="date_picker" id="expiry-date" name="ExpectationDate" class="required" title="Expectation Date"/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Frequency Of Inspection:  </label>
                        <input type="text" class="" id="date_frequency" name="" class=""/>
                    </div>
                </div>
            </div>

            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Last Report Number: </label>
                        <input type="text" id="firstName" name="LastReportNumber" class=""/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Has Equipment/IQP`s:  </label>
                        <input type="text" class="" name="IQP" class=""/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Sold/Out Of Service: </label>
                        <input type="text" id="firstName" name="Sold" class=""/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>SWL:  </label>
                        <input type="text" class="" name="SWL" class=""/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="sixteen column">
                    <div class="column_content">
                        <button class="m-btn green" id="addEquipSave" style="width: 100%">Submit</button>
                        <div class="errorMessage"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<!--popup window-->
<div id="editModal" class="modal">
    <div id="heading">
        Quote for Inspection
    </div>
    <div id="modal_content">
        <form id="formEditModal">
            <div class="sixteen_column section">
                <div class="four column">
                    <div class="column_content">
                        <label>First Name: </label>
                        <input type="text" id="firstName" name="FirstName" class="required" title="FirstName" value="<?php echo $clientFName;?>"/>
                    </div>
                </div>
                <div class="four column">
                    <div class="column_content">
                        <label>Last Name: </label>
                        <input type="text" id="lastName" name="LastName" class="required" title="LastName"  value="<?php echo $clientLName;?>" />
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Company Name: </label>
                        <input type="text" class="required" name="CompanyName" class="required" title="CompanyName" value="<?php echo $clientCompany;?>"/>
                    </div>
                </div>
            </div>

            <div class="sixteen_column section">
                <div class="six column">
                    <div class="column_content">
                        <label>Physical Address: </label>
                        <input type="text" name="PhysicalAddress[]" placeholder="Street Number, Suburban" class="" value="<?php echo $clientAddress; ?>"/>
                    </div>
                </div>
                <div class="four column">
                    <div class="column_content">
                        <label>City: </label>
                        <?php
                        echo form_dropdown('PhysicalAddress[]', $_city, $clientCity, "class='', value='". $clientCity ."'");
                        ?>
                    </div>
                </div>
                <div class="four column">
                    <div class="column_content">
                        <label>Country: </label>
                        <?php
                        echo form_dropdown('PhysicalAddress[]', $_country, $clientCountry, "class='', value='". $clientCountry ."' " );
                        ?>
                    </div>
                </div>
                <div class="two column">
                    <div class="column_content">
                        <label>ZIP: </label>
                        <input type="text" name="PhysicalAddress[]" value="<?php echo $clientZip; ?>" class="numberOnly" />
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Postal Address </label>
                        <input type="text" name="PostalAdress" class="" value="<?php echo $clientPostal; ?>"/>
                    </div>
                </div>
                <div class="two column">
                    <div class="column_content">
                        <label>Work Phone: </label>
                        <input type="text" name="WorkPhone[]" value="<?php echo $phoneArea; ?>" placeholder="area code" class="required numberOnly" title="Work Phone"/>
                    </div>
                </div>
                <div class="two column">
                    <div class="column_content">
                        <label>&nbsp </label>
                        <input type="text" name="WorkPhone[]" value="<?php echo $phoneNumber; ?>" placeholder="number" class="required numberOnly" title="Work Phone"/>
                    </div>
                </div>
                <div class="two column">
                    <div class="column_content">
                        <label>&nbsp </label>
                        <input type="text" name="WorkPhone[]"value="<?php echo $phoneExt; ?>" placeholder="extension " class="required numberOnly" title="Work Phone"/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Email: </label>
                        <input type="text" name="Email" class="" value="<?php echo $clientEmail; ?>"/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Mobile Phone: </label>
                        <input type="text" name="MobilePhone" value="<?php echo $clientMobilePhone; ?>" class="required numberOnly" title="Mobile Phone"/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Person In Charge: </label>
                        <input type="text" name="PersonInCharge" value="<?php echo $clientPersonInCharge; ?>" class=""/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Fax Number: </label>
                        <input type="text" name="FaxNumber" value="<?php echo $clientFaxNumber; ?>" class="numberOnly "/>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="eight column">
                    <div class="column_content">
                        <label>Last Update: </label>
                        <input type="text" class="date_picker" value="<?php echo $clientLastUpdate; ?>" name="LastUpdate" class=""/>
                    </div>
                </div>
                <div class="eight column">
                    <div class="column_content">
                        <label>Our Area Designation: </label>
                        <?php echo form_dropdown('AreaDesignationID', $_designation_area, $designation, 'class="required"'); ?>
                    </div>
                </div>
            </div>
            <div class="sixteen_column section">
                <div class="sixteen column ">
                    <div class="column_content">
                        <lable>Notes: </lable>
                        <textarea rows="8" name="Notes" class="" value="<?php echo $clientNotes; ?>"></textarea>
                    </div>
                </div>
            </div>
            <div class="sep-dashed"></div>
            <div style=" padding: 0 10px 10px 0">
                <div style="text-align: right;">
                    <button class="m-btn green save_edit" id="<?php echo $clientID; ?>" name="editSave">Save</button>
                    <button class="m-btn green close" >Close</button>
                </div>
            </div>
        </form>
    </div>
</div>