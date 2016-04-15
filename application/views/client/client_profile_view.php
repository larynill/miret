<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'plugins/css/buttons/pattern-buttons.css'; ?>"/>

<script>
    $(function(e){
        /*var uTable = $('#example').dataTable( {
			"sScrollY": 300,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bLengthChange": false,
			"bAutoWidth": false,
			"aoColumnDefs": [
				{bSortable: false,aTargets: [ 7 ]},
				{bSortable: false,aTargets: [ 6 ]},
				{bSortable: false,aTargets: [ 2 ]},
				{bSortable: false,aTargets: [ 3 ]},
				{bSortable: false,aTargets: [ 4 ]},
				{bSortable: false,aTargets: [ 5 ]},
				{bSortable: false,aTargets: [ 8 ]}
			]
        } );
        $(window).bind('resize', function (event) {
            uTable.fnAdjustColumnSizing();
        } );
        var history = $('#jobs_table').dataTable( {
            "sScrollY": 200,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "bLengthChange": false
        } );
        history.fnAdjustColumnSizing();*/

        /*$('.add-equipment').click(function(event){
			console.log('is click');
            $('#addModal').bPopup({
                zIndex: 1000,
                modalClose: true,
                closeClass: '.closeModal',
                modalColor: 'rgba(0, 0, 0, 0.5)',
                onOpen: function(event){ //when open,fire this event.
                    var formAddEquipModal = $('#formAddEquipModal');
                    formAddEquipModal.submit(function(event){
						event.preventDefault();
                    });
                    $('.m-btn').click(function(event){
                        var isEmpty = false;
                        var hasEmpty = false;
                        var emptyTitle = '';
                        $('.required').each(function(event){
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
							event.preventDefault();
                        }
                        else{
                            $.post(
                                '',
                                formAddEquipModal.serialize(),
                                function(event){
                                    //console.log(e);
                                    location.reload();
                                    uTable.fnDraw();
                                }
                            );
                        }
                    });
                }
            });
        });*/
        $('.add-equipment').click(function(e){
            $(this).newForm.addNewForm({
                title:'Add Equipment',
                url:'<?php echo base_url().'addEquipment/';?>' + this.id,
                toFind:'.add-equipment-div'
            });
        });
        $('.edit-btn').click(function(e){
            e.preventDefault();
            $(this).newForm.addNewForm({
                title:'Edit Equipment',
                url:'<?php echo base_url().'editEquipment/';?>' + this.id + '/' + $(this).data("value"),
                toFind:'.edit-equipment-div'
            });
        });
        $('.edit_profile').click(function(event){
            $(this).newForm.addNewForm({
                title:'Edit Profile',
                url:'<?php echo base_url();?>updateClientData/' + this.id ,
                toFind:'.client-edit-profile'
            })
        });
        /*$('.edit_profile').click(function(event){
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
        });*/

		$('.equipmentNameSpan').hover(
			function(event){
				$('.hoverTable').each(function(event){
					$(this).css({
						'display':'none'
					});
				});

				$('#form_'+this.id).css({
					'display':'inline'
				});
			},
			function(event){
				$('.hoverTable').each(function(event){
					$(this).css({
						'display':'none'
					});
				});
			}
		);
    });
</script>
<style>
	.equipmentNameSpan{
		cursor: pointer;
	}
    #example{
		margin: 0 auto;
		clear: both;
		border-collapse: collapse;
		word-wrap:break-word;
	}
    #example .odd{
        background-color: #e9e9e9;
    }
    #example .even{
        background-color: #f3f3f3;
    }
	#example tr th{
		background: #464646;
		color: #ffffff;
		font-weight: normal;
		border: 1px solid #ffffff;
		text-align: center;
		padding: 5px;
	}
	#example tr td{
		border: 1px solid #d2d2d2;
	}
	#example tr td:nth-child(2),
	#example tr td:nth-child(5),
	#example tr td:nth-child(6),
	#example tr td:nth-child(7),
	#example tr td:nth-child(8){
		text-align: center;
	}
    #addModal{
        width: 650px;
    }
    #editModal{
        width: 850px;
    }
	#jobs_table tr th{
		border: 1px solid #d2d2d2;
	}
	.hoverTable{
		border: 2px solid #000000;
		position: absolute;
		margin: -20px 50px;
		background: #eeeeee;
	}
	.hoverTable tr td{
		border: none!important;
	}
</style>

<?php
    if(count($_clientData) > 0){
        foreach($_clientData as $client){
            $clientID = $client->ID;
            $clientFName = $client->FirstName ? $client->FirstName : '';
            $clientLName = $client->LastName;
            $clientName = $client->FirstName . ' ' . $client->LastName;
            $clientCompany = $client->CompanyName;
            $clientDateRegistered = date('F d Y', strtotime($client->DateRegistered));
			$clientPostal = json_decode($client->PostalAdress);
			/*$postaladdress = is_object($clientPostal) ?
				$clientPostal->street.' '.$clientPostal->street_name.' '.$clientPostal->suburb.', '.$clientPostal->city_id.', '.$clientPostal->country_id :
				'';*/
			$postaladdress = $client->postalAddress;
			$postalSubUrb = $client->postalAddress;
            $clientPersonInCharge = $client->PersonInCharge;
            $clientMobilePhone = $client->MobilePhone;
            $clientFaxNumber = $client->FaxNumber;
            $clientEmail = $client->Email;
            $clientLastUpdate =date('d/m/Y', strtotime( $client->LastUpdate));
            $clientNotes = $client->Notes;
			$clientPhysical = json_decode($client->PhysicalAddress);
			$physicaladdress = is_object($clientPhysical) ?
				$clientPhysical->street.' '.$clientPhysical->street_name.' '.$clientPhysical->suburb :
				'';
			$clientStreet = '';
			$clientStreetName = '';
			$clientSuburb = '';
			$clientCity = '';
			$clientCountry = '';
			$clientZip = '';
			if(is_object($clientPhysical)){
				$clientCity = $clientPhysical->city_id;
				$clientCountry = $clientPhysical->country_id;
				$clientZip = $clientPhysical->zip;
				$clientStreet = $clientPhysical->street;
				$clientStreetName = $clientPhysical->street_name;
				$clientSuburb = $clientPhysical->suburb;
			}
            //$clientAddress = $address['address'];
            //$clientCity = $address['city_id'];
            //$clientCountry = $address['country_id'];
            //$clientZip = $address['zip'];
            $designation = $client->AreaDesignationID;
            $workPhone = json_decode($client->WorkPhone);
            $phoneArea = $workPhone->area_code;
            $phoneNumber = $workPhone->number;
            $phoneExt = $workPhone->ext;
            $prohibit = false;
            if( $client->StatusID == 2){
                $prohibit = true;
            }

			if(count($_areaDesignationData)>0){
				foreach($_areaDesignationData as $area){
					$clientDesignationArea = '';
					if($area->ID == $client->AreaDesignationID){
						$clientDesignationArea = $area->Area;
					}
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
			if(count($_accountingData)>0){
				foreach($_accountingData as $a){
					$accountingName = $a->ContactPerson;
					$accEmail = $a->Email;
					//$accAddress = $a->AccountAddress;
					//$accAddress2 = $a->PhysicalAddress;
					//$accPostalAddress = $a->PostalAddress;
				}
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
                            <button  style="float: right" class="m-btn edit_profile" id="<?php echo $this->uri->segment(2);?>">Edit Profile</button>
                            <a href="#" class="image">
                                <img src="<?php echo base_url() . 'plugins/img/photo_60x60.jpg'?>" width="60" height="60" alt="photo" />
                            </a>
                            <!--<h3>
                                Contact Person: <a href="#"><?php /*echo $clientName; */?></a>
                            </h3>-->

                            <h4><?php echo $clientCompany; ?></h4>
							<h6>Contact Person: <a href="#"><?php echo $clientName;?></a></h6>
                            <p class="meta">Status: <?php echo $clientStatus; ?>  — Registered since: <?php echo $clientDateRegistered; ?></p>

                        </div>
                    </div>
                </div>
                <div class="sixteen_column section">
                    <div class="two column">
                        <div class="column_content" style="display: inline;">
                            <strong>Postal Address:</strong>
                            <p><?php echo $postaladdress; ?></p><br/>
                            <strong>Person In Charge:</strong>
                            <p><?php echo $clientPersonInCharge; ?></p>
                            <br/>
                            <strong>Mobile Phone</strong>
                            <p><?php echo $clientMobilePhone; ?></p>
                            <br/>
                            <strong>Fax Number</strong>
                            <p><?php echo $clientFaxNumber; ?></p>
                            <br/>
                        </div>
                    </div>
					<div class="two column">
						<div class="column_content" style="display: inline;">
							<strong>Email</strong>
							<p><?php echo $clientEmail; ?></p>
							<br/>
							<strong>Last Updated</strong>
							<p><?php echo $clientLastUpdate; ?></p>
							<br/>
							<strong>Area Designation</strong>
							<p><?php echo $clientDesignationArea; ?></p>
							<br/>
							<strong>Notes</strong>
							<?php echo $clientNotes;?>
							<br/>

						</div>
					</div>
                    <!--<div class="eleven column" id="table_container">
                        <div class="column_content">
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="jobs_table" >
								<tr>
									<th colspan="4" style="text-align: left;font-weight: normal;border: none;">History</th>
								</tr>
                                <tr>
                                    <th>No.</th>
                                    <th>Job Number</th>
                                    <th>Client</th>
                                    <th>Description</th>
                                </tr>
                                <tbody class="table-content">

                                </tbody>
                            </table>
                            <br/><br/>
                        </div>
                    </div>-->
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="box">
        <h2>
            <a href="#" id="toggle-forms">Equipment Information <!--(<strong style="color: #000000;"><?php /*echo $clientCompany; */?></strong>)--></a>
        </h2>
        <div class="block" id="forms">
			<div class="m-btn add-equipment" style="margin-bottom: 10px; float: right" id="<?php echo $this->uri->segment(2);?>">Add Equipment</div>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
					<tr>
						<th>Plant Description</th>
						<th>Equipment Number</th>
						<th>Type of Equipment</th>
						<th>Manufacturer</th>
						<th style="width: 30%!important;">Report Number</th>
						<th>Inspection <br/>Date</th>
						<th>Expiry<br/> Date</th>
						<th>Haz <br/>Equip/IQP's</th>
						<th>Repairs</th>
						<th></th>
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
									$e6 = date('y/m/d', strtotime($equip->InspectionDate));
									$e7 = date('y/m/d', strtotime($equip->ExpectationDate));
									$equipCount++;
									?>

										<tr style="border: 1px solid #d2d2d2">
											<td style="white-space: nowrap;">
												<span id="<?php echo $equip->ID;?>" class="equipmentNameSpan">
													<?php echo $e1 ?>
													<table id="form_<?php echo $equip->ID;?>" class="hoverTable" style="display: none;">
														<tr>
															<td>Sold/ Out of Service:</td>
															<td><strong><?php echo $equip->Sold ? $equip->Sold : 'N/A';?></strong></td>
														</tr>
														<tr>
															<td>SWL:</td>
															<td><strong><?php echo $equip->SWL ? $equip->SWL : 'N/A';?></strong></td>
														</tr>
														<tr>
															<td>Certificate Number:</td>
															<td><strong><?php echo $equip->Sold ? $equip->Sold : 'N/A';?></strong></td>
														</tr>
														<tr>
															<td>Additional Information:</td>
															<td><strong><?php echo $equip->Notes ? $equip->Notes : 'N/A';?></strong></td>
														</tr>
													</table>
												</span>
											</td>
											<td><?php echo $e2 ?></td>
											<td><?php echo $e3 ?></td>
											<td style="white-space: nowrap;"><?php echo $e4; ?></td>
											<td style="width: 30%!important;"><?php echo $e5; ?></td>
											<td><?php echo $e6; ?></td>
											<td><?php echo $e7; ?></td>
											<td><?php echo $equip->IQP;?></td>
											<td style="text-align: center;"><?php echo $equip->Repair ? '&#10004;':'';?></td>
											<td style="width: 5%;text-align: center;white-space: nowrap">
                                                <a href="#" style="padding: 0 5px;" title="Edit" data-value="<?php echo $this->uri->segment(2);?>" class="edit-btn" id="<?php echo $equip->ID;?>">edit</a>
                                            </td>
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
</div>