<?php
include('merit.php');

class Admin_Controller extends Merit{

	function __construct(){
		parent::__construct();
	}

    function diary(){
        $this->Restrictions($this->session->userdata('userID'));
        $userJobData = $this->GetUserJob();
        $equipIDs = array(); $clientIDs = array(); $clientData = array(); $equipData = array();
        if(count($userJobData) > 0){
            foreach($userJobData as $job){  //get jobs assigned
                $equips = json_decode($job->Equipment);
                $clientIDs[] = $job->ClientID;
                foreach($equips as $equipID){ //get the equip id
                    $equipIDs[] = $equipID;
                }
            }
            $clientData = $this->GetClientInfo($clientIDs, $equipIDs);
            $equipData = $this->GetEquipmentInfo($equipIDs);
        }
        $schedules = array();
        if(count($equipData) > 0){ //get all the equipment dates for the calendar
            foreach($equipData as $equip){
                $schedules[] = array(
                    'id' => $equip->ID,
                    'title' => $equip->PlantDescription,
                    'start' => date('Y m d', strtotime($equip->InspectionDate))
                );
            }
        }
        $job_data = $this->merit_model->getInfo('tbl_job_registration');
        $is_date = array(
            'New Job:' => 'date_entered',
            'Completed Job:' => 'date_completed',
            'Report Printed for' => 'date_report_printed',
            'Report Sent for' => 'date_report_sent',
            'Inspection for' => 'inspection_time',
            'Due Date for' => 'date_due'
        );

        $date_color = array(
            'date_entered' => '#bce8f1',
            'date_completed' => '#d6e9c6',
            'date_report_printed' => '#bce8f1',
            'date_report_sent' => '#faebcc',
            'inspection_time' => 'rgba(56, 189, 128, 0.78)',
            'date_due' => '#ebccd1'
        );
        if(count($job_data) > 0){ //get all the equipment dates for the calendar
            foreach($job_data as $key=>$val){
                foreach($is_date as $k=>$v){
                    if($val->$v != '0000-00-00 00:00:00'){
                        $job_num = str_pad($val->id,5,'0',STR_PAD_LEFT);
                        $schedules[] = array(
                            'id' => $val->id,
                            'title' => $k . ' ' . $job_num . ' (' . $val->project_name.')',
                            'bg_color' => $date_color[$v],
                            'start' => date('Y m d H:i:s', strtotime($val->$v))
                        );
                    }
                }
            }
        }
        if(isset($_POST['dropToDate'])){ //get post for date change in the calendar
            $equipID = $_POST['ID'];
            $postData = array(
                'InspectionDate' => $_POST['InspectionDate']
            );
            $this->main_model->update('tbl_client_equipment', $postData, $equipID);
        }
		$this->main_model->setJoin(array(
			'table' => array('tbl_job_registration'),
			'join_field' => array('ID'),
			'source_field' => array('tbl_user_assignment.TrackID'),
			'type' => 'left'
		));
        $fld = ArrayWalk($this->my_model->getFields('tbl_job_registration'),'tbl_job_registration.');
        $fld[] = 'tbl_user_assignment.ID as id';
        $fld[] = 'tbl_user_assignment.TrackID';
        $fld[] = 'tbl_user_assignment.InspectionIsSet';
        $fld[] = 'tbl_user_assignment.DateAccept';

		$this->main_model->setSelectFields($fld);
		$userType = $this->session->userdata('userAccountType');
        $userTypeArr = array(1,2,6);
		$field = in_array($userType,$userTypeArr) ? '' : array('DateAssigned =');
		$value = in_array($userType,$userTypeArr) ? '' : array('0000-00-00');
        $this->main_model->setGroupBy('TrackID');
		$this->data['assignment'] = $this->main_model->getinfo('tbl_user_assignment', $value, $field);
		if(count($this->data['assignment'])>0){
			foreach($this->data['assignment'] as $ak=>$av){
				//$av->equipment = $this->main_model->getinfo('tbl_client_equipment',$av->ClientID,'ClientID');
				$av->inspector = $this->main_model->getinfo('tbl_user',4,'AccountType');
				$av->jobs = 0;
				if(count($av->inspector)>0){
					foreach($av->inspector as $ik=>$iv){
						$av->jobs = count($this->main_model->getinfo('tbl_user_assignment', $iv->ID , 'UserID'));
					}
				}
				$days = floor((strtotime(date('Y-m-d')) - strtotime($av->DateAccept)) / (60 * 60 * 24));
				if($av->InspectionIsSet == false && $days < 6){
					$av->color = '#FFA500';
				}else if($av->InspectionIsSet == false && $days >= 6){
					$av->color = '#ff0000';
				}else{
					$av->color = '#228B22';
				}
			}
		}
		$this->main_model->setJoin(array(
			'table' => array('tbl_tracker','tbl_client'),
			'join_field' => array('ID','ID'),
			'source_field' => array('tbl_client_quotes.TrackID','tbl_tracker.ClientID'),
			'type' => 'left'
		));

		$this->main_model->setSelectFields(array(
			'tbl_client_quotes.ID','tbl_client.MobilePhone',
			'concat(tbl_client.FirstName," ",tbl_client.LastName) as name',
			'tbl_client.CompanyName','tbl_client_quotes.TrackID','tbl_client_quotes.Date',
			'tbl_client_quotes.IsQueue','tbl_client_quotes.UserID'
		));
		$this->main_model->setNoReset(true);
        $this->main_model->setGroupBy('TrackID');
		$this->data['qoutes'] = $this->main_model->getinfo('tbl_client_quotes',1,'tbl_client_quotes.IsQueue !=');
		$this->data['qoutelist'] = $this->main_model->getinfo('tbl_client_quotes');

		if(count($this->data['qoutelist'])>0){
			foreach($this->data['qoutelist'] as $qk=>$qv){
				$days = floor((strtotime(date('Y-m-d')) - strtotime($qv->Date)) / (60 * 60 * 24));
				$qv->notification = '';
				if($qv->IsQueue == false && $days < 6){
					$qv->color = '#FFA500';
				}else if($qv->IsQueue == false && $days >= 6){
					$qv->color = '#ff0000';
					$qv->notification = '<span class="notify">Pending '. $days .' days</span>';
				}else{
					$qv->color = '#228B22';
				}
			}
		}
		if(count($this->data['qoutes'])>0){
			foreach($this->data['qoutes'] as $qk=>$qv){
				$days = floor((strtotime(date('Y-m-d')) - strtotime($qv->Date)) / (60 * 60 * 24));
				$qv->notification = '';
				if($qv->IsQueue == false && $days < 6){
					$qv->color = '#FFA500';
				}else if($qv->IsQueue == false && $days >= 6){
					$qv->CompanyName = $qv->CompanyName .' ('.$days.' days)';
					$qv->color = '#ff0000';
					//$qv->notification = '<span class="notify">Pending</span>';
				}else{
					$qv->color = '#228B22';
				}
			}
		}

        $this->data['_schedules'] = json_encode($schedules);
        $this->data['_clientData'] = $clientData;
        $this->data['_equipData'] = $equipData;

		//get the Scheduled Inspections
		$this->merit_model->setJoin(array(
			'table' => array('tbl_tracker', 'tbl_user','tbl_client'),
			'join_field' => array('ID', 'ID','ID'),
			'source_field' => array('tbl_user_assignment.TrackID', 'tbl_user_assignment.UserID','tbl_tracker.ClientID'),
			'type' => 'left'
		));

		$this->merit_model->setSelectFields(array(
			'tbl_user_assignment.ID','tbl_client.CompanyName','tbl_user_assignment.TrackID',
			'tbl_user_assignment.InspectionIsSet', 'tbl_user_assignment.InspectionDate','tbl_tracker.EquipID',
			'CONCAT(tbl_user.FName, " ", tbl_user.LName) as InspectorName', 'tbl_user_assignment.IsDone'
		), false);

		$whatField = array('tbl_user_assignment.InspectionIsSet');
		$whatVal = array(1);
        $this->merit_model->setGroupBy('TrackID');
		$assign = $this->merit_model->getinfo('tbl_user_assignment', $whatVal, $whatField);
		$_assign_json = array();
		if(count($assign) > 0){ //get all the equipment dates for the calendar
            foreach($assign as $v){
				$title = "(".count(json_decode($v->EquipID)).") "  . $v->CompanyName . "\n  <strong>(" . $v->InspectorName.")</strong>";
                $_assign_json[] = array(
                    'id' => $v->ID,
                    'title' => word_limiter($title,3,'...'),
                    'start' => date('Y m d', strtotime($v->InspectionDate)),
					'change_color' => $v->IsDone ? true : '',
					'job' => $title
                );
            }
        }
		$this->data['_assign_json'] = json_encode($_assign_json);

		if(isset($_POST['submit'])){
			unset($_POST['submit']);
			$AssignId = $_POST['AssignId'];
			unset($_POST['AssignId']);

			$post = array(
				'UserID' => $_POST['UserID'][$AssignId],
				'DateAssigned' => date('Y-m-d')
			);
			$this->main_model->update('tbl_user_assignment', $post, $AssignId);

			$post = array(
				'AssignedToID' => $_POST['UserID'][$AssignId],
				'AssignedToDate' => date('Y-m-d')
			);

			$this->main_model->update('tbl_tracker', $post, $_POST['TrackID']);

			redirect('diary');
		}

        //region Items to Action
        $items_to_action = new Items_To_Action_Controller();
        $this->data['items_to_action'] = $items_to_action->getItems();
        //endregion

        $this->data['_pageLoad'] = 'diary/diary_view';//load the view.
        $this->load->view('main_view', $this->data);
    }

	//this is for the HOVER
	function client_info_hover(){
		/*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/

		$assignId = $this->uri->segment(2);
		$isForQuote = $this->uri->segment(3);
		$this->data['isForQuote'] = $isForQuote ? true : false;
		if(!$assignId){
			exit;
		}

		$this->main_model->setLastId('TrackID');
		$this->data['trackId'] = $this->main_model->getinfo('tbl_user_assignment', $assignId);

		$this->main_model->setLastId('ID');
		$this->data['quote'] = $this->main_model->getinfo('tbl_client_quotes', $assignId,'TrackID');

		$this->main_model->setLastId('TrackID');
		$this->data['thisTrackID'] = $this->main_model->getinfo('tbl_client_quotes', $this->data['quote']);

		$this->main_model->setLastId('ClientID');
		$this->data['clientId'] = $this->main_model->getinfo('tbl_tracker', $this->data['quote']);
		//echo $this->data['clientId'];

		$fields = ArrayWalk($this->main_model->getFields('tbl_client'), 'tbl_client.');
		$fields[] = 'tbl_area_designation.Area as AreaDesignation';
		$fields[] = 'tbl_distance_from.FromName as Distance';
		$fields[] = 'tbl_distance_from_value.FromName as DistanceFrom';

		$this->main_model->setSelectFields($fields, false);
		$this->main_model->setJoin(array(
			'table' => array('tbl_area_designation','tbl_distance_from', 'tbl_distance_from_value'),
			'join_field' => array('ID','ID','ID'),
			'source_field' => array('tbl_client.AreaDesignationID','tbl_client.Distance','tbl_client.DistanceFrom'),
			'type' => 'left'
		));
		//$this->main_model->setShift();
		$this->data['clientInfo'] = $this->main_model->getinfo('tbl_client', $this->data['clientId'], 'tbl_client.ID');

		//DisplayArray($this->data['clientInfo']);
		if(count($this->data['clientInfo'])){
			foreach ($this->data['clientInfo'] as $key => $value) {
				$postal = json_decode($value->PostalAdress);

				$this->main_model->setJoin(array(
					'table' => array('tbl_country'),
					'join_field' => array('id'),
					'source_field' => array('tbl_city.country_id'),
					'type' => 'left'

				));
				$this->main_model->setSelectFields(array(
					'tbl_city.id','tbl_city.Name','tbl_city.country_id','tbl_country.Name as CountryName'
				));

				$postalAddress = (object)$postal;

				$postalAdd = $this->main_model->getinfo('tbl_city',$postalAddress->city_id,'tbl_city.id');

				$value->postalAddress = '';
				if(count($postalAdd)>0){
					foreach($postalAdd as $k=>$v){
						$value->postalAddress = $postalAddress->street.' '.$postalAddress->street_name.', '.$postalAddress->suburb;
						$value->postalAddress .= ', '.$v->Name.', '.$v->CountryName;
					}
				}
			}
		}

		$this->main_model->setSelectFields(array('ID', 'PlantDescription'));

		$date = date('Y-m', strtotime('+1 month'));

		$sql = "SELECT `ID`, `PlantDescription` FROM (`tbl_client_equipment`) WHERE `ClientID` = '".$this->data['clientId']."' AND `InspectionDate` LIKE '%".$date."%'";

		$this->data['clientEquipment'] = $this->main_model->mysqlstring($sql);

		$this->data['isInspector'] = $this->session->userdata('userAccountType') == 4;

		$this->data['assignId'] = $assignId;

		$this->load->view('diary/client_info/client_info_hover_view', $this->data);
	}

	//to insert inspection queue
	function inspection_queue(){
		/*if($this->session->userdata('isLogged') == false && $this->session->userdata('userAccountType') != 2){
            redirect('login');
        }*/

		$clientId = $this->uri->segment(2);
		$trackId = $this->uri->segment(3);
		if(!($clientId && $trackId)){
			exit;
		}

		$post = array(
			'TrackID' => $trackId,
			'Date' => date('Y-m-d')
		);
		$this->main_model->insert('tbl_client_quotes', $post);

		$post = array(
			'ToManager' => 1,
			'ToManagerDate' => date('Y-m-d')
		);

		$this->main_model->update('tbl_tracker', $post, $trackId);

		redirect('track/client/next');
	}

	function equipmentHistory(){
		/*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/
		$clientID = $this->uri->segment(2);
		$this->data['quote'] = $this->main_model->getinfo('tbl_client_quotes',$clientID);
		if(count($this->data['quote'])>0){
			foreach($this->data['quote'] as $qk=>$qv){
				$qv->Date = date('j F Y',strtotime($qv->Date));
				if($qv->ID < 10){
					$qv->Number = 'UI000'.$qv->ID;
				}else if($qv->ID < 100 && $qv->ID >= 10){
					$qv->Number = 'UI00'.$qv->ID;
				}else if($qv->ID < 1000 && $qv->ID >= 100){
					$qv->Number = 'UI0'.$qv->ID;
				}else{
					$qv->Number = 'UI'.$qv->ID;
				}
			}
		}

		$this->data['_pageLoad'] = 'equipment/history/equipment_history';//load the view.
        $this->load->view('main_view', $this->data);
	}

	function equipmentReport(){
		/*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/

		$this->data['_pageLoad'] = 'equipment/report/equipment_report';//load the view.
        $this->load->view('main_view', $this->data);
	}

	function machineDetails(){
		/*if($this->session->userdata('isLogged') == false){
			redirect('login');
		}*/

		$this->data['_pageLoad'] = 'equipment/details/equipment_details';//load the view.
		$this->load->view('main_view', $this->data);
	}

	function quotationSetUp(){
		/*if($this->session->userdata('isLogged') == false){
			redirect('login');
		}*/
		$clientID = $this->uri->segment(2);
		$trackID = $this->uri->segment(3);
		$quoteID = $this->uri->segment(4);


		$this->main_model->setLastId('CompanyName');
		$this->data['clientInfo'] = $this->main_model->getinfo('tbl_client',$clientID);
		$this->data['equipment'] = array();
		$this->data['trackID'] = $_POST['trackID'];

		$discountBanned = $this->main_model->getinfo('tbl_discount_banned');
		$this->data['discount'] = array();
		if(count($discountBanned)>0){
			foreach($discountBanned as $dv){
				$this->data['discount'][$dv->discount] = $dv->discount.' %';
			}
		}

		if(count($_POST['equipmentID'])>0){
			foreach($_POST['equipmentID'] as $v){
				$this->main_model->setLastId('PlantDescription');
				$equipment = $this->main_model->getinfo('tbl_client_equipment',$v);
				$this->data['equipment'][] = $equipment;
			}
		}
		/*$this->main_model->setLastId('Value');
		$unitRate = $this->main_model->getinfo('tbl_rate',1);

		$this->main_model->setLastId('Value');
		$hourlyRate = $this->main_model->getinfo('tbl_rate',2);

		$this->main_model->setLastId('Value');
		$kmRate = $this->main_model->getinfo('tbl_rate',3);*/

		$this->main_model->setLastId('ID');
		$quotationID = (int)$this->main_model->getinfo('tbl_quotation',array($trackID,true),array('TrackID','IsQuoteSend'));
		$quotationID = $quotationID != 0 ? $quotationID + 1: '';

		$this->main_model->setLastId('InvoiceID');
		$invoiceId = (int)$this->main_model->getinfo('tbl_quotation',array($trackID,true),array('TrackID','IsArchive'));
		$invoiceId = $invoiceId != 0 ? $invoiceId + 1 : 1;

		if(isset($_POST['submit'])){
			$perUnitRate = $_POST['pup'];
			$perHour = $_POST['ph'];
			$timeTravel = $_POST['travelTime'];
			$travelDistance = $_POST['travelDistance'];
			$flightTime = $_POST['flightTime'];

			$data = array(
				'Date' => date('Y-m-d H:i:s'),
				'TrackID' => $_POST['trackerID'],
				'UnitPrice' => $perUnitRate,
				'PerHour' => $perHour,
				'TravelTime' => $timeTravel,
				'TravelDistance' => $travelDistance,
				'FlightTime' => $flightTime,
				'FlightCost' => $_POST['flightCost'],
				'Accommodation' => $_POST['accomCost'],
				'DiscountBanned' => $_POST['discount'],
				'IsQuoteSend' => true,
				'InvoiceID' => $invoiceId,
                'ClientID' => $clientID
			);

			if($this->main_model->insert('tbl_quotation',$data)){
				//redirect('actual_quote/' . $trackID . '/' . $quoteID . '/' .$quotationID);
				redirect('to_be_send_quote/' . $trackID . '/' . $quoteID . '/' .$quotationID);
			}
			//redirect('diary');
		}

		$this->load->view('diary/quotation/quotation_setup_view',$this->data);
	}

	function to_be_send_quote(){
		/*if($this->session->userdata('isLogged') == false){
			redirect('login');
		}*/

		$quotationID = $this->uri->segment(4);
		$trackID = $this->uri->segment(2);
		$quoteID = $this->uri->segment(3);
		if(!$quotationID || !$trackID || !$quoteID){
			exit;
		}

		$this->main_model->setLastId('ClientID');
		$clientID = $this->main_model->getinfo('tbl_tracker',$trackID);

		//$this->main_model->setLastId('CompanyName');

		$this->data['clientInfo'] = $this->ClientInfo($clientID);

		//DisplayArray($this->data['clientInfo']);

		$this->data['quotation'] = $this->main_model->getinfo('tbl_quotation',$quotationID);


		$this->main_model->setLastId('Value');
		$unitRate = $this->main_model->getinfo('tbl_rate',1);

		$this->main_model->setLastId('Value');
		$hourlyRate = $this->main_model->getinfo('tbl_rate',2);

		$this->main_model->setLastId('Value');
		$kmRate = $this->main_model->getinfo('tbl_rate',3);

		$this->main_model->setLastId('ID');
		$quoteNumber = (int)$this->main_model->getinfo('tbl_quotation',$quotationID);
		$this->data['quoteNumber'] = '';
		$this->data['quoteNumber'] = 'UI'.str_pad($quoteNumber, 4, '0', STR_PAD_LEFT);


		if(count($this->data['quotation'])>0){
			foreach($this->data['quotation'] as $v){
				$v->inspection = $v->UnitPrice ? '<strong>'.($v->UnitPrice / $unitRate) .'</strong> units at <strong>$'. $unitRate.'</strong> per unit' : '<strong>'.($v->PerHour / $hourlyRate).' hours</strong> at <strong>$'.$hourlyRate.'</strong> per hour';
				$v->totalUnitPrice = $v->UnitPrice ? '$'.$v->UnitPrice : '$'.$v->PerHour;
				$v->totalInspection = $v->UnitPrice ? $v->UnitPrice : $v->PerHour;

				$v->travelTime = $v->TravelTime ? '<strong>'.number_format(($v->TravelTime / $hourlyRate),'2','.',' ') .' hours</strong> at <strong>$'.$hourlyRate.'</strong> per hour' : '<strong>0 hours</strong> at <strong>$'.$hourlyRate.'</strong> per hour';
				$v->TotalTravelTime = '$'.$v->TravelTime;

				$v->travelCost = $v->TravelDistance ? '<strong>'.($v->TravelDistance/ $kmRate).' km</strong> at <strong>$'.$kmRate.'</strong> per km': '<strong>0 km</strong> at <strong>$'.$kmRate.'<strong> per km';
				$v->TotalTravelDistance = '$'.$v->TravelDistance;

				$v->totalflightTime = $v->FlightTime ? '<strong>'.($v->FlightTime / $hourlyRate).' hours</strong> at <strong>$'.$hourlyRate.'</strong> per hour': '<strong>0 hours</strong> at <strong>$'.$hourlyRate.'</strong> per hour';
				$v->TotalFlightTime = '$'.$v->FlightTime;

				$v->TotalFlightCost = '$'.$v->FlightCost;
				$v->TotalAccommodation = '$'.$v->Accommodation;

				$v->subTotal = $v->totalInspection + $v->TravelTime +
							   $v->TravelDistance + $v->FlightTime +
							   $v->FlightCost + $v->Accommodation;
				$v->discountTotal = $v->DiscountBanned ? ($v->subTotal * ($v->DiscountBanned / 100)) : 0 ;
				$v->totalGST = ($v->subTotal - $v->discountTotal) * 0.15;
				$v->total = ($v->subTotal - $v->discountTotal) - $v->totalGST;

			}
		}

		if(isset($_POST['submit'])){
			redirect('actual_quote/' . $trackID . '/' . $quoteID . '/' .$quotationID);
		}

		$this->data['_pageLoad'] = 'diary/quotation/actual_quotation_view';
		$this->load->view('main_view', $this->data);
	}

	function mail_registration(){
		/*$whatId = $this->uri->segment(2);
		if(!$whatId){
			exit;
		}*/

		if(isset($_POST['Submit'])){
			if(isset($_POST['PhysicalAddress'])){ //physical address
				$fields = array('street','street_name','suburb', 'city_id', 'country_id', 'zip');
				$physical = array_combine($fields, $_POST['PhysicalAddress']);
				$_POST['PhysicalAddress'] = json_encode($physical);
			}
			if(isset($_POST['PostalAddress'])){ //postal address
				$fields = array('street','street_name','suburb', 'city_id', 'country_id', 'zip');
				$postal = array_combine($fields, $_POST['PostalAddress']);
				$_POST['PostalAddress'] = json_encode($postal);
			}


			if(isset($_POST['WorkPhone'])){ // work phone
				$fields = array('area_code', 'number', 'ext');
				$workPhone = array_combine($fields, $_POST['WorkPhone']);
				$_POST['WorkPhone'] = json_encode($workPhone);
			}

			if(isset($_POST['TelNo'])){ // work phone
				$thisfields = array('number', 'ext');
				$TelNo = array_combine($thisfields, $_POST['TelNo'] );
				$_POST['TelNo'] = json_encode($TelNo);
			}

			$data = array(
				'FirstName' => $_POST['FirstName'],
				'LastName' => $_POST['LastName'],
				'CompanyName' => $_POST['CompanyName'],
				'PhysicalAddress' => $_POST['PhysicalAddress'],
				'PostalAdress' => $_POST['option'] == 'No' ? $_POST['PostalAddress'] : $_POST['PhysicalAddress'],
				'WorkPhone' => $_POST['WorkPhone'],
				'Email' => $_POST['Email'],
				'PersonInCharge' => $_POST['PersonInCharge'],
				'MobilePhone' => $_POST['MobilePhone'],
				'FaxNumber' => $_POST['FaxNumber'],
				'DateRegistered' => date('Y-m-d'),
				'StatusID' => 2,
				'Notes' => $_POST['Notes']
			);

			$id = $this->main_model->insert('tbl_client',$data,false);

            //$uploaddir = realpath(APPPATH.'../uploads');
            if (!empty($_FILES['uploadFile'])) {
                $direc = 'uploads/equipment/'.date('Y').'/'.date('M').'/';
                if(!is_dir($direc)){
                    mkdir($direc,0755,TRUE);
                }
                $file = str_replace(' ', '_', date('Y m d h i s')) . '_' .basename($_FILES['uploadFile']['name']);

                $destination = $direc . '('.$id.') '.$file;
                if(move_uploaded_file($_FILES['uploadFile']['tmp_name'], $destination)){
                    $post = array(
                        'FileName' => $file,
                        'Date' => date('Y-m-d'),
                        'ClientID' => $id
                    );

                    $this->main_model->insert('tbl_client_equipment_attachment', $post, false);
                }
            }

			$data = array(
				'ClientID' => $id,
				'ContactPerson' => $_POST['AccountContactPerson'],
				'TelNumber' => $_POST['TelNo'],
				'Email' => $_POST['AccountMail'],
				'CutOff_ID' => $_POST['CutOff'],
				'Others' => $_POST['Others']
			);

			$this->main_model->insert('tbl_client_accounting',$data,false);

			redirect('registration_success/'.$id);
		}
	}

    function registerClient(){
        /*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/

        $clientID = '';
        $this->data['_city'] = $this->GetCityData();
        $this->data['_country'] = $this->GetCountryData();
        $this->data['_designation_area'] = $this->GetDesignationArea();
		$distanceFrom = $this->main_model->getinfo('tbl_distance_from');
		$cutoff = $this->main_model->getinfo('tbl_accounting_cut_off');
		$this->data['distanceFrom'] = array();
		$this->data['distanceName'] = array();
		$this->data['cutoff'] = array();

		if(count($distanceFrom)>0){
			foreach($distanceFrom as $dk=>$dv){
				$this->data['distanceFrom'][''] = '';
				$this->data['distanceFrom'][$dv->ID] = $dv->FromName;
			}
		}
		if(count($cutoff)>0){
			foreach($cutoff as $ck=>$cv){
				$this->data['cutoff'][''] = '-';
				$this->data['cutoff'][$cv->ID] = $cv->CutOff;
			}
		}

		$distanceVal = $this->main_model->getinfo('tbl_distance_from_value');
		if(count($distanceVal)>0){
			foreach($distanceVal as $dvk=>$dvv){
				$this->data['distanceName'][$dvv->DistanceID][$dvv->ID] = $dvv->FromName;
			}
		}

		//DisplayArray($this->data['distanceName']);
		//$this->session->unset_userdata(array('registration_page'=>'accounting'));
        if($this->session->userdata('registration_page') == 'equipment'){ //equipment page
            $this->data['_clientName'] = $this->session->userdata('clientName');
            $this->data['_registration_page'] = 'equipment';
        }
        else if($this->session->userdata('registration_page') == 'accounting'){ // accounting page

            $this->data['_clientName'] = $this->session->userdata('clientName');
            $this->data['_registration_page'] = 'accounting';
        }
        else{
            $this->data['_registration_page'] = 'client'; // client page
        }

        if($this->session->userdata('equipment')){
            $this->data['_equipData'] = $this->session->userdata('equipment');
        }

        if(isset($_POST['clientSubmit'])){ //client page submission
            //client registration success
            $this->session->set_userdata('registration_page', 'equipment');
            $this->session->set_userdata('client', $_POST);
            $this->session->set_userdata('clientName', $_POST['FirstName'] . ' ' . $_POST['LastName'] );


            redirect('registerClient');
        }

        if(isset($_POST['EquipmentNumber'])){ //equipment page submission
            $equip = array();
            if($this->session->userdata('equipment')){
                $equip = $this->session->userdata('equipment');
            }
            $equip[] = $_POST;
            $this->session->set_userdata('equipment', $equip);
        }

        if(isset($_POST['equipmentSave'])){ //each equipment submission
            $this->session->set_userdata('registration_page', 'accounting');

        }

        if(isset($_POST['accountingSubmit'])){ // accounting submission
            $this->session->set_userdata('accounting', $_POST);

            $postClient = $this->session->userdata('client');
            $postEquipment = $this->session->userdata('equipment');
            $postAccounting = $this->session->userdata('accounting');

            $tableFields = $this->main_model->getFields('tbl_client');
            $reg_post = array();
            foreach($tableFields as $tableField){// get all table fields equal to post fields
                foreach($postClient as $postKey => $postField){
                    if($postKey == $tableField){
                        $reg_post[$tableField] = $postClient[$tableField];
                    }
                }
            }
            $reg_post['DateRegistered'] = date('Y-m-d'); //date registered
            $reg_post['StatusID'] = 2; //pending status
            if(isset($reg_post['PhysicalAddress'])){ //physical address
                $fields = array('address', 'city_id', 'country_id', 'zip');
                $address_post = '$address = array(';
                foreach($reg_post['PhysicalAddress'] as $k=>$v ){
                    $address_post .=  $k > 0 ? ", " : "";
                    $address_post .= "'". $fields[$k]."' => ";
                    $address_post .= is_numeric($v) ? $v : "'". addslashes($v) ."'";
                }
                $address_post .= ");";
                $reg_post['PhysicalAddress'] = $address_post;
            }
            if(isset($reg_post['WorkPhone'])){ // work phone
                $fields = array('area_code', 'number', 'ext');
                $workPhone = array_combine($fields, $reg_post['WorkPhone'] );
                $reg_post['WorkPhone'] = json_encode($workPhone);
            }
            $clientID = $this->main_model->insert('tbl_client', $reg_post, false); // insert client.
            //---------
            $tableFields = $this->main_model->getFields('tbl_client_equipment');// get all table fields equal to post fields
            if(count($postEquipment)>0){

			}
			foreach($postEquipment as $k => $postArray){ // $postEquipment is nested array.
                $equip_post = array();
                foreach($postArray as $postKey => $postVal){
                    foreach($tableFields as $fieldKey => $fieldVal){
                        if($fieldKey == $postKey ){
                            $equip_post[$postKey] = $postArray[$postKey];
                        }
                    }
                }
                if(isset($equip_post['LastService'])){
                    $equip_post['LastService'] =  date('Y-m-d', strtotime($postArray['LastService']));
                }

                $equip_post['ClientID'] = $clientID;
                $this->main_model->insert('tbl_client_equipment', $equip_post, false); //insert all equipments
            }

            //$this->main_model->insert('tbl_client_accounting', $postAccounting, false); //insert accounting

            $this->session->unset_userdata('registration_page');
            $this->session->unset_userdata('client');
            $this->session->unset_userdata('clientName');//destroy session after fully registered.
            $this->session->unset_userdata('equipment');
            $this->session->unset_userdata('accounting');
            $this->session->set_flashdata('successfulRegistration', true);// flash data for successful registration

            redirect('registerClient');
        }

        $this->data['_pageLoad'] = 'registration/registration_view';
        $this->load->view('main_view', $this->data);
    }

    function joblist(){
        /*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/
        $jobData = $this->main_model->getinfo('tbl_job_monthly');
        $userData = $this->main_model->getinfo('tbl_user');

        $clientData = $this->GetClientInfo();
        $this->data['_clientData'] = array();
        $this->data['_inspectorData'] = array();
        if(count($jobData) > 0){
            foreach($jobData as $job){
                if(count($clientData) > 0){
                    foreach($clientData as $client){ //get the clients in the job table
                        if($client->ID == $job->ClientID){
                            $this->data['_clientData'][] = $client;

                        }
                    }
                }
                /*if(count($userData) > 0){
                    foreach($userData as $user){
                        if($user->AccountType == 4){ //if user is inspector
                            $this->data['_inspectorData'][] = $user;
                        }
                    }
                }*/
            }
        }

        $inspectors = array();
        $counter = 0;
        if(isset($_POST['RequestInspector'])){
            if(count($userData) > 0){
                foreach($userData as $user){
                    if($user->AccountType == 4){ //if user is inspector
                        $counter++;
                        $this->data['_inspectorData'][] = $user;
                        $inspectors[] = array($counter, $user->Username, '<button class="m-btn blue select" id="'.  $user->ID .'" style="padding: 3px 7px; margin: 0;">Assign</button>');
                    }
                }
            }
            header('Content-Type: application/json');
            echo json_encode($inspectors);
            exit;
        }

        $this->data['_status'] = $this->main_model->getinfo('tbl_status');


        $this->data['_pageLoad'] = 'jobsheet/joblist_view';
        $this->load->view('main_view', $this->data);
    }

    function viewClient(){
        /*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/
        $clientID = '';
        if($this->uri->segment(2)){
            $uriDecode = $this->encryption->decode($this->uri->segment(2));
            $clientID = $uriDecode;

            $tbl_client = $this->main_model->getinfo('tbl_client', $clientID, 'ID');
            $tbl_client_equipment = $this->main_model->getinfo('tbl_client_equipment', $clientID, 'ClientID');
            $tbl_client_accounting = $this->main_model->getinfo('tbl_client_accounting', $clientID, 'ClientID');

            if(isset($_POST['accept'])){
                foreach($tbl_client_equipment as $equip){
                    $clientSchedule = date('Y-F', strtotime($equip->InspectionDate));
                    $post = array(
                        'StatusID' => '4', //if admin accepts,

                    );
                    $this->main_model->update('tbl_client', $post, $clientID);
                }
                redirect('schedule/' . $clientSchedule);
            }

			if(count($tbl_client)>0){
				foreach($tbl_client as $tk=>$tv){
					$postalAdd = json_decode($tv->PostalAdress);
					$tv->postalAddress = '';
					if(is_object($postalAdd)){
						$this->main_model->setJoin(array(
							'table' => array('tbl_country'),
							'join_field' => array('id'),
							'source_field' => array('tbl_city.country_id'),
							'type' => 'left'
						));
						$this->main_model->setSelectFields(array(
							'tbl_city.id','tbl_city.country_id', 'tbl_city.Name',  'tbl_country.Name as countryName'
						));
						$address = $this->main_model->getinfo('tbl_city',$postalAdd->city_id,'tbl_city.id');
						$postalCity = '';
						$postalCountry = '';
						if(count($address)>0){
							foreach($address as $ak=>$av){
								$postalCity = $av->Name;
								$postalCountry = $av->countryName;
							}
						}
						$tv->postalAddress = $postalAdd->street.' '.$postalAdd->street_name.', '.$postalAdd->suburb.', '.$postalCity.', '.$postalCountry;
					}
				}
			}

            // pass all the data needed
            $this->data['_clientData'] = $tbl_client;
            $this->data['_equipmentData'] = $tbl_client_equipment;
            $this->data['_accountingData'] = $tbl_client_accounting;
            $this->data['_status'] = $this->main_model->getinfo('tbl_status');
            $this->data['_areaDesignationData'] = $this->main_model->getinfo('tbl_area_designation');
        }
        else{
            // show error
        }

        //new equipment post
        if(isset($_POST['PlantDescription'])){

            $_POST['ClientID'] = $clientID;
            $_POST['InspectionDate'] = date('Y-m-d', strtotime($_POST['InspectionDate']));
            $_POST['ExpectationDate'] = date('Y-m-d', strtotime($_POST['ExpectationDate']));
            $this->main_model->insert('tbl_client_equipment', $_POST);

        }
        if(isset($_POST['CompanyName'])){
            //$_POST['LastUpdate'] = date('Y-m-d', strtotime($_POST['LastUpdate']));
            $tableFields = $this->main_model->getFields('tbl_client');
            $reg_post = array();
            foreach($tableFields as $tableField){// get all table fields equal to post fields
                foreach($_POST as $postKey => $postField){
                    if($postKey == $tableField){
                        $reg_post[$tableField] = $_POST[$tableField];
                    }
                }
            }
            if(isset($reg_post['PhysicalAddress'])){ //physical address
				$fields = array('street','street_name','suburb', 'city_id', 'country_id', 'zip');
				$address_post = array_combine($fields, $reg_post['PhysicalAddress'] );
                $reg_post['PhysicalAddress'] = json_encode($address_post);
            }
            if(isset($reg_post['WorkPhone'])){ // work phone
                $fields = array('area_code', 'number', 'ext');
                $workPhone = array_combine($fields, $reg_post['WorkPhone'] );
                $reg_post['WorkPhone'] = json_encode($workPhone);
            }
            /*$this->utility->displayarray($reg_post);
            exit;*/
            $this->main_model->update('tbl_client', $reg_post, $clientID, 'ID', false);
        }
        unset($_POST);
        $this->data['_city'] = $this->GetCityData();
        $this->data['_country'] = $this->GetCountryData();
        $this->data['_designation_area'] = $this->GetDesignationArea();
        $this->data['_pageLoad'] = 'client/client_profile_view';
        $this->load->view('main_view', $this->data);
    }

    function updateClientData(){
        /*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/

        $client_id = $this->encryption->decode($this->uri->segment(2));
        if(!$client_id){
            exit;
        }

        $this->data['client_data'] = $this->ClientInfo($client_id);

        //DisplayArray($this->data['client_data']);
        $this->data['_city'] = $this->GetCityData();
        $this->data['_country'] = $this->GetCountryData();
        $this->data['_designation_area'] = $this->GetDesignationArea();

        if(isset($_POST['submit'])){
            unset($_POST['submit']);
            $tableFields = $this->main_model->getFields('tbl_client');
            $reg_post = array();
            foreach($tableFields as $tableField){// get all table fields equal to post fields
                foreach($_POST as $postKey => $postField){
                    if($postKey == $tableField){
                        $reg_post[$tableField] = $_POST[$tableField];
                    }
                }
            }
            if(isset($reg_post['PhysicalAddress'])){ //physical address
                $fields = array('street','street_name','suburb', 'city_id', 'country_id', 'zip');
                $address_post = array_combine($fields, $reg_post['PhysicalAddress'] );
                $reg_post['PhysicalAddress'] = json_encode($address_post);
                $reg_post['PostalAdress'] = json_encode($address_post);
            }
            if(isset($reg_post['WorkPhone'])){ // work phone
                $fields = array('area_code', 'number', 'ext');
                $workPhone = array_combine($fields, $reg_post['WorkPhone'] );
                $reg_post['WorkPhone'] = json_encode($workPhone);
            }

            $this->main_model->update('tbl_client', $reg_post, $client_id,'ID',false);

            redirect('viewClient/'.$this->uri->segment(2));
        }

        $this->load->view('client/edit_client_profile',$this->data);
    }

    function addEquipment(){
        /*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/

        $id = $this->encryption->decode($this->uri->segment(2));
        if(!$id){
            exit;
        }

        if(isset($_POST['submit'])){
            unset($_POST['submit']);
            $_POST['ClientID'] = $id;
            $_POST['InspectionDate'] = date('Y-m-d',strtotime($_POST['InspectionDate']));
            $_POST['ExpectationDate'] = date('Y-m-d',strtotime($_POST['ExpectationDate']));

            $this->my_model->insert('tbl_client_equipment',$_POST);
            redirect('viewClient/'.$this->uri->segment(2));
        }
        $this->load->view('equipment/add_equipment',$this->data);
    }

    function editEquipment(){
        /*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/

        $id = $this->uri->segment(2);
        $client_id = $this->uri->segment(3);
        if(!$id && !$client_id){
            exit;
        }
        $this->data['equipment'] = $this->my_model->getinfo('tbl_client_equipment',$id);
        if(isset($_POST['submit'])){
            unset($_POST['submit']);
            $_POST['InspectionDate'] = date('Y-m-d',strtotime($_POST['InspectionDate']));
            $_POST['ExpectationDate'] = date('Y-m-d',strtotime($_POST['ExpectationDate']));

            $this->my_model->update('tbl_client_equipment',$_POST,$id);
            redirect('viewClient/'.$client_id);
        }

        $this->load->view('equipment/edit_equipment',$this->data);
    }

    function idashboard(){
        /*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/
        $this->data['_pageLoad'] = 'dashboard/admin_dashboard';
        $this->load->view('main_view', $this->data);
    }

    function equipment(){
        /*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/
        $clientData = $this->main_model->getinfo('tbl_client');
        $equipData = $this->main_model->getinfo('tbl_client_equipment');
        if(count($clientData) > 0){
            if(count($equipData) > 0){
                foreach($clientData as $client){
                    $client->Equipment = array();
                    foreach($equipData as $equip){
                        if($client->ID == $equip->ClientID){
                            //get the date frequency
                            $dateExpiry = date('Y-m-d', strtotime($equip->ExpectationDate));
                            $dataInspection = date('Y-m-d', strtotime($equip->InspectionDate));
                            $frequencyString = '';
                            if($dataInspection < $dateExpiry)
                            {
                                $yearFreq = CountYears($dataInspection, $dateExpiry);
                                $monthFreq = CountMonths($dataInspection, $dateExpiry);
                                $dayFreq = CountDays($dataInspection, $dateExpiry);
                                if($yearFreq >= 1) //get year
                                {
                                    if($yearFreq == 1)
                                    {
                                        $frequencyString = $yearFreq . ' year';
                                    }
                                    else if($yearFreq > 1)
                                    {
                                        $frequencyString = $yearFreq . ' years';
                                    }
                                }
                                else if($yearFreq <= 0) //get year
                                {
                                    if($monthFreq > 0)
                                    {
                                        if($monthFreq == 1)
                                        {
                                            $frequencyString = $monthFreq . ' month';
                                        }
                                        else{
                                            $frequencyString = $monthFreq . ' months';
                                        }
                                    }
                                    else if($monthFreq <= 0)
                                    {
                                        if($dayFreq == 1)
                                        {
                                            $frequencyString = $dayFreq . ' day';
                                        }
                                        else
                                        {
                                            $frequencyString = $dayFreq . ' days';
                                        }
                                    }
                                }
                            }
                            else
                            {
                                $frequencyString = 'Invalid Frequency';
                            }

                            $equip->InspectionFrequency = $frequencyString;
                            $client->Equipment[] = $equip;
                        }
                    }
                }
            }
        }

        //DisplayArray($clientData);
        $this->data['_clientData'] = $clientData;

        $this->data['_pageLoad'] = 'equipment/equipment_view';
        $this->load->view('main_view', $this->data);
    }

    function monthlyReport(){
        /*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/

        if($this->uri->segment(2) == 'potential')
        {

            $this->data['_monthlyClient'] = $this->GetMonthlyClient();

            $this->data['_monthlyTitle'] =  date('F');
        }else{
            $jobData = $this->main_model->getinfo('tbl_job_monthly');
            $users = $this->main_model->getinfo('tbl_user');
            $inspectors = array();
            $monthlyClient = array();
            if(count($jobData) > 0){
                foreach($jobData as $job){
                    $monthlyClient = array_merge($monthlyClient, $this->GetMonthlyClient($job->ClientID));
                }
            }
            if(count($users) > 0){
                foreach($users as $inspect){
                    if($inspect->AccountType == 4){
                        $inspectors[] = $inspect;
                    }
                }
            }
            $this->data['_monthlyClient'] = $monthlyClient;
            $this->data['_inspectors'] = $inspectors;
            $this->data['_jobData'] = $jobData;
            $this->data['_monthlyTitle'] =  date('F'); // the month
        }
        if(isset($_POST['assigned'])){
            $postJob = array(
                'IsAssigned' => true,
                'IsScheduled' => false,
                'UserID' => $_POST['UserID']
            );
            $postClient = array(
                'StatusID' => 1
            );
            $this->main_model->update('tbl_job_monthly', $postJob, $_POST['ClientID'], 'ClientID');
            $this->main_model->update('tbl_client', $postClient, $_POST['ClientID'], 'ID');
        }

        $this->data['_pageLoad'] = 'jobsheet/monthly_report_view';
        $this->load->view('main_view', $this->data);
    }

    private function GetCityData(){
        //get the city data
        $this->main_model->setOrder('Name', 'ASC'); //set the order
        $cityData = $this->main_model->getinfo('tbl_city',163,'country_id');

        $cities = array();
        foreach($cityData as $ct){
            $cities[$ct->id] = ($ct->Name);
        }
        return $cities;
    }

    private function GetCountryData(){
        //get the country data
        $this->main_model->setOrder('Name', 'ASC');
        $countryData = $this->main_model->getinfo('tbl_country', 163);

        $countries = array();
        foreach($countryData as $cy){
            $countries[$cy->id] = $cy->Name;
        }
        return $countries;
    }

    private function GetDesignationArea(){
        $areas = $this->main_model->getinfo('tbl_area_designation');
        $a = array();
        $ref = 1;
        foreach($areas as $area){
            $a[$ref] = $area->Area;
            $ref++;
        }
        return $a;
    }

	function invoices(){
		if($this->session->userdata('isLogged') == false){
			redirect('login');
		}

		$cutoff = 2010;

		// current year
		$now = date('Y');
		$this->data['year'] = array();
		$this->data['months'] = array();

		// build years menu
		for ($y=$now; $y>=$cutoff; $y--) {
			$this->data['year'][$y] = $y;
		}
		// build months menu
		for ($m=01; $m<=12; $m++) {
			$this->data['months'][$m] = date('F', mktime(0,0,0,$m));
		}
		$whatMonth = date('Y-m');

		if(isset($_POST['search'])){
			$whatMonth = date('Y-m',strtotime($_POST['year'].'-'.$_POST['month']));
		}

        $this->data['clients'] = $this->main_model->getinfo('tbl_client');
        if(count($this->data['clients'])>0){
            foreach($this->data['clients'] as $v){
                $this->main_model->setSearch(true);
                $whatVal = array($v->ID,false);
                $whatFld = array('ClientID','IsArchive');
                $v->invoice_count = count($this->main_model->getinfo('tbl_quotation',$whatVal,$whatFld));
            }
        }

		$this->data['_pageLoad'] = 'invoice/invoices_view';
		$this->load->view('main_view',$this->data);

	}

	function job_invoice(){
		if($this->session->userdata('isLogged') == false){
			redirect('login');
		}

		$clientId = $this->uri->segment(2);
		if(!$clientId){
			exit;
		}
		$this->data['companyName'] = '';
		$this->data['address'] = '';
		$this->data['branchCode'] = '';

		$clientInfo = $this->ClientInfo($clientId,true);
		if(count($clientInfo)>0){
			foreach($clientInfo as $ck=>$cv){
				$this->data['companyName'] = $cv->CompanyName;
				$this->data['address'] = $cv->PostalAdress;
				$this->data['branchCode'] = $cv->BranchCode;
			}
		}

        $this->data['invoice_info'] = $this->main_model->getinfo('tbl_invoice_info');

		$this->main_model->setJoin(array(
			'table' => array('tbl_tracker','tbl_client'),
			'join_field' => array('ID','ID'),
			'source_field' => array('tbl_quotation.TrackID','tbl_tracker.ClientID'),
			'type' => 'left'
		));
		$this->main_model->setSelectFields(array(
			'tbl_quotation.ID','tbl_quotation.TrackID','tbl_quotation.UnitPrice', 'tbl_quotation.PerHour',
			'tbl_quotation.TravelTime','tbl_quotation.TravelDistance','tbl_quotation.FlightTime',
			'tbl_quotation.FlightCost','tbl_quotation.Accommodation','tbl_quotation.DiscountBanned',
			'DATE_FORMAT(tbl_quotation.Date,"%d-%M-%y") as Date','tbl_quotation.IsQuoteSend','tbl_tracker.ClientID',
			'tbl_tracker.EquipID','tbl_quotation.OrderNumber','tbl_client.CompanyName','tbl_quotation.IsArchive',
			'tbl_quotation.InvoiceID'
		));
		$whatVal = array($clientId,false);
		$whatFld = array('tbl_tracker.ClientID','tbl_quotation.IsArchive');
		$this->data['clientInvoice'] = $this->main_model->getinfo('tbl_quotation',$whatVal,$whatFld);

        $letter = date('d') <= 15 ? 'A' : 'B';
        $date = date('my');

		$this->data['taxInvoice'] = $this->data['branchCode'] . $date . $letter;

		$Unit = 0;
		$Travel = 0;
		$Distance = 0;
		$FlightCost = 0;
		$Accommodation = 0;
		if(count($this->data['clientInvoice'])>0){
			foreach($this->data['clientInvoice'] as $k=>$v){
				$jobNumber = $this->main_model->getinfo('tbl_user_assignment',$v->TrackID,'TrackID');
				$v->JobNumber = '';
				$quotation = $v->UnitPrice ? ($v->UnitPrice * $this->data['unitrate']) +
                    ($v->TravelTime * $this->data['hourrate']) + ($v->TravelDistance * $this->data['kmrate']) +
                    ($v->FlightTime * $this->data['hourrate']) + ($v->FlightCost * $this->data['kmrate']) + $v->Accommodation :
                    ($v->PerHour * $this->data['hourrate']) + ($v->TravelTime * $this->data['hourrate']) +
                    ($v->TravelDistance * $this->data['kmrate']) + ($v->FlightTime * $this->data['hourrate']) +
                    ($v->FlightCost * $this->data['kmrate']) + $v->Accommodation;
				$discount = ($quotation * ($v->DiscountBanned/100));

				$v->Quotation = $quotation - $discount - (($quotation - $discount) * 0.15);
				$v->Quotation = '$'.number_format($v->Quotation,2,'.',' ');
				$v->totalUnitPrice = $v->UnitPrice ? $v->UnitPrice.' units' :
									$v->PerHour.' hrs';
				$v->totalTravelTime = $v->TravelTime ? $v->TravelTime .' hrs' : '0 hr';
				$v->totalTravelCost = $v->TravelDistance ? $v->TravelDistance .' km' : '0 km';

				$v->Unit = $v->UnitPrice ? $v->UnitPrice : $v->PerHour;
				$Unit += ($v->Unit * $this->data['unitrate']);
				$Travel += ($v->TravelTime * $this->data['hourrate']);
				$Distance += ($v->TravelDistance * $this->data['kmrate']);
				$FlightCost += ($v->FlightCost * $this->data['kmrate']);
				$Accommodation += ($v->Accommodation * $this->data['hourrate']);
				$v->extra = (($v->Accommodation * $this->data['hourrate']) + ($v->FlightCost * $this->data['kmrate']));
				$v->subTotal = (($v->Unit * $this->data['unitrate']) + ($v->TravelTime * $this->data['hourrate']) + ($v->TravelDistance) * $this->data['kmrate']);

				if(count($jobNumber)>0){
					foreach($jobNumber as $jk=>$jv){
						$v->JobNumber = date('my',strtotime($jv->InspectionDate)).$this->data['branchCode'].' - '.str_pad($jv->ID, 5 ,'0',STR_PAD_LEFT);
						$v->InspectionDate = date('d-F-y',strtotime($jv->InspectionDate));
					}
				}
			}
		}
		$this->data['subTotal'] = $Unit + $Travel + $Distance;
		$this->data['totalExtra'] = $FlightCost + $Accommodation;
		$this->data['overAllsubTotal'] = $this->data['totalExtra'] + $this->data['subTotal'];
		//DisplayArray($this->data['clientInvoice']);
		if($this->uri->segment(3) == 'pdf'){
            $this->data['dir'] = 'pdf/invoice/'.date('Y').'/'.date('F').'/'.$clientId;
            if(!is_dir($this->data['dir'])){
                mkdir($this->data['dir'], 0777, TRUE);
            }
			$this->load->view('invoice/invoices_pdf',$this->data);

            $post = array(
                'client_id' => $clientId,
                'file_type' => 1,
                'reference' => $this->data['taxInvoice'],
                'file_name' => $clientId.'_'.$this->data['taxInvoice'].'_'.date('d-F-y').'.pdf',
                'date' => date('Y-m-d')
            );
            $this->main_model->insert('tbl_uploads_file',$post);
		}else{
			$this->data['_pageLoad'] = 'invoice/admin_invoices';
			$this->load->view('main_view',$this->data);
		}
	}

	function archiveInvoice(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}
		$whatId = $this->uri->segment(2);
		if(!$whatId){
			exit;
		}
        $whatVal = array(false,$whatId);
        $whatFld = array('IsArchive','ClientID');
        $invoice = $this->main_model->getinfo('tbl_quotation',$whatVal,$whatFld);
        if(count($invoice)>0){
            foreach($invoice as $iv){
                $post = array('IsArchive' => true,'InvoiceRef' => $_GET['inv_ref']);
                $this->main_model->update('tbl_quotation',$post,$iv->ID);
            }
        }
        if(isset($_GET['inv_ref'])){
            $post_data = array(
                'client_id' => $whatId,
                'date' => date('Y-m-d'),
                'type' => 1,
                'reference' => $_GET['inv_ref'],
                'debits' => $_GET['total']
            );
            $this->main_model->insert('tbl_statement',$post_data);
        }
		redirect('invoices');
	}

	function jobsDone(){
		if($this->session->userdata('isLogged') == false){
			redirect('login');
		}

		$cutoff = 2010;

		// current year
		$now = date('Y');
		$this->data['year'] = array();
		$this->data['months'] = array();
		$this->data['whatMonth'] = date('F Y');

		// build years menu
		for ($y=$now; $y>=$cutoff; $y--) {
			$this->data['year'][$y] = $y;
		}
		// build months menu
		for ($m=01; $m<=12; $m++) {
			$this->data['months'][$m] = date('F', mktime(0,0,0,$m));
		}
		$whatDate = date('Y-m');
		if(isset($_POST['search'])){
			$date = $_POST['year'].'-'.$_POST['month'];
			$this->data['whatMonth'] = date('F Y',strtotime($date));
			$whatDate = date('Y-m',strtotime($date));
		}

		$this->main_model->setJoin(array(
			'table' => array('tbl_tracker','tbl_user','tbl_client','tbl_area_designation'),
			'join_field' => array('ID','ID','ID','ID'),
			'source_field' => array(
				'tbl_user_assignment.TrackID','tbl_user_assignment.UserID',
				'tbl_tracker.ClientID','tbl_client.AreaDesignationID'
			),
			'type' => 'left'
		));

		$this->main_model->setSelectFields(array(
			'tbl_user_assignment.ID','tbl_user_assignment.TrackID','tbl_user_assignment.UserID','tbl_tracker.ClientID',
			'tbl_user_assignment.InspectionDate','tbl_user_assignment.IsDone','tbl_area_designation.BranchCode',
			'concat(tbl_user.FName," ",tbl_user.LName) as Inspector', 'tbl_client.CompanyName','tbl_tracker.EquipID'
		));

		$whatVal = array(true,$whatDate);
		$whatFld = array('tbl_user_assignment.IsDone','tbl_user_assignment.InspectionDate');

		$this->main_model->setSearch(true);

		$this->data['job_done'] = $this->main_model->getinfo('tbl_user_assignment',$whatVal,$whatFld);

		if(count($this->data['job_done'])>0){
			foreach($this->data['job_done'] as $k=>$v){
				$equipment = json_decode($v->EquipID);
				$jobNumber = date('my',strtotime($v->InspectionDate));
				$v->JobNumber = $jobNumber.$v->BranchCode.'-'.str_pad($v->ID,5,0,STR_PAD_LEFT);
				$v->Equipment = array();
				if(count($equipment)>0){
					foreach($equipment as $ev){
						$v->Equipment = $this->main_model->getinfo('tbl_client_equipment',$ev);
					}
				}
			}
		}
		//DisplayArray($this->data['job_done']);

		$this->data['_pageLoad'] = 'jobsheet/jobs_done_view';
		$this->load->view('main_view', $this->data);
	}

	function set_holiday(){
		$this->data['action'] = $this->uri->segment(2);
		$this->data['type'] = array();
		$this->data['holiday'] = array();
		$type = $this->main_model->getinfo('tbl_holiday_type');

		if(count($type)>0){
			foreach($type as $k=>$v){
				$this->data['type'][$v->ID] = $v->Abbr;
			}
		}
		if($this->data['action'] == 'add'){
			if(isset($_POST['submit'])){
				$data = array(
					'HolidayName' => $_POST['holiday'],
					'ActualDate' => date('Y-m-d',strtotime($_POST['date'])),
					'EndDate' => $_POST['enddate'] != '' ? date('Y-m-d',strtotime($_POST['enddate'])) : '',
					'TypeID' => $_POST['type']
				);

				$this->main_model->insert('tbl_holidays', $data);

				redirect('holidays');
			}
		}
		if($this->data['action'] == 'edit'){
			$id = $this->uri->segment(3);

			if(!$id){
				exit;
			}

			$this->data['holiday'] = $this->main_model->getinfo('tbl_holidays', $id);
			if(isset($_POST['update'])){
				$data = array(
					'HolidayName' => $_POST['holiday'],
					'ActualDate' => date('Y-m-d',strtotime($_POST['date'])),
					'EndDate' => $_POST['enddate'] != '' ? date('Y-m-d',strtotime($_POST['enddate'])) : '',
					'TypeID' => $_POST['type']
				);

				$this->main_model->update('tbl_holidays', $data, $id);

				redirect('holidays');
			}
		}

		$this->load->view('holiday/set_holiday_view',$this->data);
	}

	function holidays(){
		if($this->session->userdata('isLogged') == false){
			redirect('login');
		}

		$this->data['holidays'] = array();

		$this->main_model->setJoin(array(
			'table' => array('tbl_holidays'),
			'join_field' => array('TypeID'),
			'source_field' => array('tbl_holiday_type.ID'),
			'type' => 'left'
		));

		$this->main_model->setSelectFields(array(
			'tbl_holidays.ID','tbl_holidays.HolidayName','tbl_holidays.ActualDate',
			'tbl_holidays.EndDate','tbl_holidays.TypeID','tbl_holiday_type.TypeName'
		),false);
        $config = $this->my_model->model_config;
        $this->data['holidays'] = $this->main_model->getinfo('tbl_holiday_type');
        $this->my_model->model_config = $config;
        $this->data['variable_holidays'] = $this->main_model->getinfo('tbl_holiday_type',2);
        /*DisplayArray($this->data['holidays']);
        DisplayArray($this->data['variable_holidays']);*/

		$this->data['_pageLoad'] = 'holiday/holiday_view';
		$this->load->view('main_view',$this->data);
	}

	function wage_management(){
		if($this->session->userdata('isLogged') == false){
			redirect('login');
		}

		$this->data['_pageLoad'] = 'staff/wage_management_view';


		$wage_type_fields = $this->arrayWalk($this->main_model->getFields('tbl_wage_type', array('frequency', 'type')), 'tbl_wage_type.');
		$wage_type_fields[] = "tbl_salary_freq.frequency";
		$wage_type_fields[] = "tbl_salary_type.type";
		$this->main_model->setJoin(array(
			'table' => array('tbl_salary_freq', 'tbl_salary_type'),
			'join_field' => array('id', 'id'),
			'source_field' => array('tbl_wage_type.frequency', 'tbl_wage_type.type'),
			'type' => 'left'
		));
		$this->main_model->setOrder('tbl_wage_type.id','ASC');
		$this->main_model->setSelectFields($wage_type_fields);
		$this->data['category'] = $this->main_model->getinfo('tbl_wage_type',array(1,2,3,4,5,6),'tbl_wage_type.id');

		$this->main_model->setOrder('min_range', 'ASC', true);
		$this->data['production'] = $this->main_model->getinfo('tbl_production');
		$this->data['salary_frequency'] = $this->main_model->getinfo('tbl_salary_freq');
		$this->data['salary_type'] = $this->main_model->getinfo('tbl_salary_type',array(1,2,3),'id');
		$this->data['tax_codes'] = $this->main_model->getinfo('tbl_tax_codes');
		$this->data['kiwi'] = $this->main_model->getinfo('tbl_kiwi');
		$this->data['default_percentage'] = $this->main_model->getinfo('tbl_paye_default_percentage');

		//DisplayArray($this->data['salary_frequency']);

		$this->load->view('main_view',$this->data);
	}

	function addWageType(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		$this->main_model->setSelectFields(array('frequency', 'id'));
		$this->main_model->setNormalized('frequency', 'id');
		$this->data['salary_feq'] = $this->main_model->getinfo('tbl_salary_freq');

		$this->main_model->setSelectFields(array('type', 'id'));
		$this->main_model->setNormalized('type', 'id');
		$this->data['salary_type'] = $this->main_model->getinfo('tbl_salary_type');

		if(isset($_POST['submit'])){
			unset($_POST['submit']);

			$this->main_model->insert('tbl_wage_type', $_POST);

			redirect('wage_management');
		}

		$this->load->view('staff/manage_view/add_wage_type', $this->data);
	}

	function editWageType(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		$whatId = $this->uri->segment(2);
		if(!$whatId){
			exit;
		}

		$this->main_model->setSelectFields(array('frequency', 'id'));
		$this->main_model->setNormalized('frequency', 'id');
		$this->data['salary_feq'] = $this->main_model->getinfo('tbl_salary_freq');

		$this->main_model->setSelectFields(array('type', 'id'));
		$this->main_model->setNormalized('type', 'id');
		$this->data['salary_type'] = $this->main_model->getinfo('tbl_salary_type');

		$this->data['wageType'] = $this->main_model->getinfo('tbl_wage_type', $whatId);

		if(isset($_POST['submit'])){
			unset($_POST['submit']);

			$this->main_model->update('tbl_wage_type', $_POST, $whatId);

			redirect('wageManage');
		}

		$this->load->view('staff/manage_view/edit_wage_type', $this->data);
	}

	function deleteWageType(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		if(isset($_POST['id'])){
			$this->main_model->delete('tbl_wage_type', $_POST['id']);
		}
	}

	function addFrequency(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		if(isset($_POST['submit'])){
			unset($_POST['submit']);

			$this->main_model->insert('tbl_salary_freq', $_POST);

			redirect('wageManage');
		}

		$this->load->view('staff/manage_view/add_frequency', $this->data);
	}

	function editFrequency(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		$whatId = $this->uri->segment(2);
		if(!$whatId){
			exit;
		}

		$this->data['salary_frequency'] = $this->main_model->getinfo('tbl_salary_freq', $whatId);

		if(isset($_POST['submit'])){
			unset($_POST['submit']);

			$this->main_model->update('tbl_salary_freq', $_POST, $whatId);

			redirect('wageManage');
		}

		$this->load->view('staff/manage_view/edit_frequency', $this->data);
	}

	function deleteFrequency(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		if(isset($_POST['id'])){
			$this->main_model->delete('tbl_salary_freq', $_POST['id']);
		}
	}
	//endregion

	//region Type Area
	function addType(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		if(isset($_POST['submit'])){
			unset($_POST['submit']);
			$_POST['hasfixed'] = isset($_POST['hasfixed']) ? "true" : "false";

			$this->main_model->insert('tbl_salary_type', $_POST);

			redirect('wageManage');
		}

		$this->load->view('staff/manage_view/add_type', $this->data);
	}

	function editType(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		$whatId = $this->uri->segment(2);
		if(!$whatId){
			exit;
		}

		$this->data['salary_type'] = $this->main_model->getinfo('tbl_salary_type', $whatId);

		if(isset($_POST['submit'])){
			unset($_POST['submit']);
			$_POST['hasfixed'] = isset($_POST['hasfixed']) ? "true" : "false";

			$this->main_model->update('tbl_salary_type', $_POST, $whatId);

			redirect('wageManage');
		}

		$this->load->view('staff/manage_view/edit_type', $this->data);
	}

	function deleteType(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		if(isset($_POST['id'])){
			$this->main_model->delete('tbl_salary_type', $_POST['id']);
		}
	}
	//endregion

	//region Tax Code Area
	function addTaxCode(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		if(isset($_POST['submit'])){
			unset($_POST['submit']);

			$this->main_model->insert('tbl_tax_codes', $_POST);

			redirect('wageManage');
		}

		$this->load->view('staff/manage_view/add_tax_code', $this->data);
	}

	function editTaxCode(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		$whatId = $this->uri->segment(2);
		if(!$whatId){
			exit;
		}

		$this->data['tax_codes'] = $this->main_model->getinfo('tbl_tax_codes', $whatId);

		if(isset($_POST['submit'])){
			unset($_POST['submit']);

			$this->main_model->update('tbl_tax_codes', $_POST, $whatId);

			redirect('wageManage');
		}

		$this->load->view('staff/manage_view/edit_tax_code', $this->data);
	}

	function deleteTaxCode(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		if(isset($_POST['id'])){
			$this->main_model->delete('tbl_tax_codes', $_POST['id']);
		}
	}
	//endregion

	//region Kiwi Save Area
	function addKiwi(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		if(isset($_POST['submit'])){
			unset($_POST['submit']);

			$this->main_model->insert('tbl_kiwi', $_POST);

			redirect('wageManage');
		}

		$this->load->view('staff/manage_view/add_kiwi', $this->data);
	}

	function editKiwi(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		$whatId = $this->uri->segment(2);
		if(!$whatId){
			exit;
		}

		$this->data['kiwi'] = $this->main_model->getinfo('tbl_kiwi', $whatId);

		if(isset($_POST['submit'])){
			unset($_POST['submit']);

			$this->main_model->update('tbl_kiwi', $_POST, $whatId);

			redirect('wageManage');
		}

		$this->load->view('staff/manage_view/edit_kiwi', $this->data);
	}

	function deleteKiwi(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		if(isset($_POST['id'])){
			$this->main_model->delete('tbl_kiwi', $_POST['id']);
		}
	}
	//endregion

	function editDefaultPercentage(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		$whatId = $this->uri->segment(2);
		if(!$whatId){
			exit;
		}

		$this->data['default_percentage'] = $this->main_model->getinfo('tbl_paye_default_percentage', $whatId);

		if(isset($_POST['submit'])){
			unset($_POST['submit']);

			$this->main_model->update('tbl_paye_default_percentage', $_POST, $whatId);

			redirect('wageManage');
		}

		$this->load->view('staff/manage_view/edit_dp', $this->data);
	}

	function wage_summary(){
		if($this->session->userdata('isLogged') == false){
			redirect('login');
		}

		$this->data['_pageLoad'] = 'staff/wage_summary_view';

		$cutoff = 2010;

		// current year
		$now = date('Y');
		$thisMonth = date('m');
		$this->data['year'] = array();

		// build years menu
		for ($y=$now; $y>=$cutoff; $y--) {
			$this->data['year'][$y] = $y;
		}

		for ($m=01; $m<=12; $m++) {
			$this->data['month'][$m] = date('F', mktime(0,0,0,$m));
		}
		reset($this->data['year']);
		$year = key($this->data['year']);
		reset($this->data['month']);
		$month = $thisMonth;

		if(isset($_POST['submit'])){
			$year = $_POST['year'];
			$month = $_POST['month'];
		}

		$this->data['dateArr'] = $this->getWednesdays($year, $month);
		$userInfo = $this->arrayWalk(
			array('ID','Username','FName','LName','EmailAddress','AccountType','WageType'),'tbl_user.'
		);
		$account = $this->arrayWalk(
			array('IRD','AccountNumber','TaxCode','Frequency','FixedValue','Tax','STLoan','KiwiSave','KiwiPercent'),'tbl_user_account_info.');
		$account[] = 'tbl_tax_codes.tax_code';
		$account[] = 'tbl_kiwi.kiwi';
		$account[] = 'tbl_tax_codes.sl_starting_gross as gross';

		$this->main_model->setJoin(array(
			'table' => array('tbl_user_account_info','tbl_kiwi','tbl_tax_codes'),
			'join_field' => array('UserID','id','id'),
			'source_field' => array('tbl_user.ID','tbl_user_account_info.KiwiPercent','tbl_user_account_info.Tax'),
			'type' => 'left'
		));
		$this->main_model->setSelectFields(array_merge($userInfo,$account));
		$this->data['empArr'] = $this->main_model->getinfo('tbl_user',array(3,4,5,6),'AccountType');
		$this->data['totalGrossValue'] = 0;
		$this->data['totalKSValue'] = 0;
		$this->data['totalPayeValue'] = 0;
		//DisplayArray($this->data['empArr']);
		if(count($this->data['empArr'])>0){
			foreach($this->data['empArr'] as $k=>$v){
				$v->Paye = 0;
				$v->Gross = 0;
				$v->tax_code = $v->tax_code ? $v->tax_code : '-';
				$v->KS = 0;
				$whatVal = array($v->FixedValue,$v->Frequency);

				$paye_deduction = $this->main_model->getinfo('tbl_paye_deduction',$whatVal,array('earning','frequency_id'));
				if($v->WageType == 1){
					$v->Gross = $v->FixedValue;
					$v->KS = $v->Gross * ($v->kiwi / 100);

					$this->data['totalGrossValue'] += $v->Gross;
					$this->data['totalKSValue'] += $v->KS;

					if(count($paye_deduction)>0){
						foreach($paye_deduction as $pk=>$pv){
							$v->Paye = $pv->paye;
							$this->data['totalPayeValue'] += $v->Paye;
						}
					}
				}
			}
		}
		//echo $this->data['totalGross'];
		$this->load->view('main_view',$this->data);
	}

	function paye(){
		$this->data['_pageLoad'] = 'staff/paye_view';

		$this->main_model->setSelectFields(array('frequency', 'id'));
		$this->main_model->setNormalized('frequency', 'id');
		$this->data['salary_freq'] = $this->main_model->getinfo('tbl_salary_freq');
		$this->data['salary_freq'][0] = 'Secondary Earnings';

		$this->main_model->setSelectFields(array('tax_code', 'id'));
		$this->main_model->setNormalized('tax_code', 'id');
		$this->data['tax_codes'] = $this->main_model->getinfo('tbl_tax_codes');
		$this->load->view('main_view',$this->data);
	}

	function payeJson(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		ini_set("memory_limit","1024M");
		set_time_limit(900000000000);
		header("Content-type: application/json");

		if(!(isset($_POST['frequency_id']) && isset($_POST['tax_code_id']))){
			exit;
		}

		//Get Default Percentage
		$this->main_model->setSelectFields(array('percentage', 'type'));
		$this->main_model->setNormalized('percentage', 'type');
		$default_percentage = (Object)$this->main_model->getinfo('tbl_paye_default_percentage');
		$cec_percentage = ($default_percentage->cec/100);
		$sl_percentage = ($default_percentage->student_loan/100);

		$kiwi_saver = $this->main_model->getinfo('tbl_kiwi');
		$esct = $this->main_model->getinfo('tbl_esct');

		$whatField = "";
		$whatVal = "";
		$possible_post = array('frequency_id', 'tax_code_id', 'earning');
		foreach($possible_post as $post){
			if(isset($_POST[$post])){
				$whatField[] = $post;
				$whatVal[] = $_POST[$post];
			}
		}

		$paye_deduction_fields = $this->arrayWalk(array('id', 'earning', 'paye'),'tbl_paye_deduction.');
		$tax_codes_fields = $this->arrayWalk(array('tax_code'), 'tbl_tax_codes.');
		$fields = array_merge($paye_deduction_fields, $tax_codes_fields);

		//this is to get the Student Loan
		$case = "CASE WHEN tbl_paye_deduction.earning > tbl_tax_codes.sl_starting_gross AND ";
		$case .= "tbl_paye_deduction.earning - tbl_tax_codes.sl_starting_gross > 0 ";
		$case .= "THEN ((tbl_paye_deduction.earning - tbl_tax_codes.sl_starting_gross) * (" . $sl_percentage . ")) ELSE 0 END as sl";
		$fields[] = $case;

		if(count($kiwi_saver)>0){
			foreach($kiwi_saver as $val){
				$kiwi_percentage = $val->kiwi/100;
				$kiwi_field = str_replace('.', '_', $kiwi_percentage);

				//this is to get the Student Loan
				$case = "format(tbl_paye_deduction.earning * " . $kiwi_percentage . ", 2) as kiwi_save_" . $kiwi_field;
				$fields[] = $case;
			}
		}

		if(count($esct)>0){
			foreach($esct as $val){
				$esct_percentage = $val->esct/100;

				$esct_field = str_replace('.', '_', $esct_percentage);
				$case_cec = "CASE WHEN tbl_paye_deduction.earning > tbl_tax_codes.cec_starting_gross ";
				$case_cec .= "THEN ";
				$case_cec .= "ROUND(";
				$case_cec .= "(tbl_paye_deduction.earning * " . $cec_percentage . ") - ";
				$case_cec .= "TRUNCATE(TRUNCATE(tbl_paye_deduction.earning * " . $cec_percentage . ", 0) * " . $esct_percentage . ", 2) ";
				$case_cec .= ", 2)";
				$case_cec .= "ELSE ";
				$case_cec .= "ROUND(";
				$case_cec .= "tbl_paye_deduction.earning * " . $cec_percentage . "";
				$case_cec .= ", 2)";
				$case_cec .= " END as cec_" . $esct_field;

				$case_esct = "CASE WHEN tbl_paye_deduction.earning > tbl_tax_codes.cec_starting_gross";
				$case_esct .= " THEN TRUNCATE(TRUNCATE(tbl_paye_deduction.earning * " . $cec_percentage . ", 0) * " . $esct_percentage . ", 2)";
				$case_esct .= " ELSE 0 END as esct_" . $esct_field;

				$fields[] = $case_cec;
				$fields[] = $case_esct;
			}
		}

		$this->main_model->setJoin(array(
			'table' => array('tbl_tax_codes'),
			'source_field' => array('tax_code_id'),
			'type' => 'left'
		));
		$this->main_model->setSelectFields($fields, false);
		$paye_deduction = $this->main_model->getinfo('tbl_paye_deduction', $whatVal, $whatField);

		echo json_encode($paye_deduction);
	}

	function staff_list(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		$this->data['_pageLoad'] = 'staff/staff_list_view';
		$staffList = $this->arrayWalk($this->main_model->getFields('tbl_user'),'tbl_user.');
        $staffInfo = $this->arrayWalk($this->main_model->getFields('tbl_user_account_info',array('ID')),'tbl_user_account_info.');

        $fld = array_merge($staffList,$staffInfo);
        $fld[] = "tbl_wage_type.description";
        $fld[] = "tbl_user_type.AccountType as AccountName";

		$this->main_model->setJoin(array(
			'table' => array('tbl_wage_type','tbl_user_type','tbl_user_account_info'),
			'join_field' => array('id','ID','UserID'),
			'source_field' => array('tbl_user.WageType','tbl_user.AccountType','tbl_user.ID'),
			'type' => 'left'
		));
		$this->main_model->setSelectFields($fld);
		$this->data['staffList'] = $this->main_model->getinfo('tbl_user');
		//DisplayArray($this->data['staffList']);
		$this->load->view('main_view',$this->data);
	}

	function addStaff(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}
		$area = $this->main_model->getinfo('tbl_area_designation');
		$this->data['area'] = array();
		if(count($area)>0){
			foreach($area as $k=>$v){
                $this->data['area'][''] = '-';
				$this->data['area'][$v->ID] = $v->Area;
			}
		}

		$account_type = $this->main_model->getinfo('tbl_user_type',array(4,5,6));
		$this->data['account_type'] = array();
		if(count($account_type)>0){
			foreach($account_type as $k=>$v){
                $this->data['account_type'][''] = '-';
				$this->data['account_type'][$v->ID] = $v->AccountType;
			}
		}

		$this->data['tax_codes'] = array('-' => '');
		$this->main_model->setSelectFields(array('id', 'tax_code'));
		$this->main_model->setNormalized('tax_code', 'id');
		$tax_codes = $this->main_model->getinfo('tbl_tax_codes');
		$this->data['tax_codes'] += $tax_codes;

		$this->data['kiwi'] = array('' => '');
		$this->main_model->setSelectFields(array('id', 'kiwi'));
		$this->main_model->setNormalized('kiwi', 'id');
		$kiwi = $this->main_model->getinfo('tbl_kiwi');
		$this->data['kiwi'] += $kiwi;

		$table = array(
			'frequency' => 'tbl_salary_freq',
			'type' => 'tbl_salary_type'
		);
		foreach($table as $k=>$v){
			$data = $this->main_model->getinfo($v);
			$this->data[$k] = array();
			if(count($data)>0){
				foreach($data as $dk=>$dv){
					$this->data[$k][$dv->id] = $dv->$k;
                    $this->data[$k][''] = '-';
				}
			}
		}
		if(isset($_POST['submit'])){
			unset($_POST['submit']);

			$data = array(
				'Username' => $_POST['username'],
				//'Password' => $this->encrypt->encode($_POST['password']),
				'FName' => $_POST['fname'],
				'LName' => $_POST['lname'],
				'EmailAddress' => $_POST['email'],
				'Address' => $_POST['address'],
				'AccountType' => $_POST['account_type'],
				'WageType' => $_POST['wage_type'],
				'isCanAddJob' => $_POST['isCanAddJob'],
				'DateRegistered' => date('Y-m-d')
			);

			$userID = $this->main_model->insert('tbl_user',$data);

			$accountInfo = array(
				'UserID' => $userID,
				'IRD' => $_POST['irdnum'],
				'AccountNumber' => $_POST['account_number'],
				'TaxCode' => $_POST['tax_code'] == '-' ? '' : $_POST['tax_code'],
				'AreaDesignated' => $_POST['franchise_id'],
				'Frequency' => $_POST['frequency'],
				'FixedValue' => $_POST['fixed_rate'],
				'Tax' => $_POST['tax'],
				'STLoan' => $_POST['has_stloan'] == '' ? 0 : 1,
				'KiwiSave' => $_POST['has_kiwisave'] == '' ? 0 : 1,
				'KiwiPercent' => $_POST['kiwisave_percentage'] == '' ? '' : $_POST['kiwisave_percentage']
			);
			$this->main_model->insert('tbl_user_account_info',$accountInfo);
			redirect('staff_list');
		}

		$this->load->view('staff/manage_staff_view/add_staff_view',$this->data);
	}

	function editStaff(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		$whatId = $this->uri->segment(2);
		if(!$whatId){
			exit;
		}

		$area = $this->main_model->getinfo('tbl_area_designation');
		$this->data['area'] = array();
		if(count($area)>0){
			foreach($area as $k=>$v){
				$this->data['area'][$v->ID] = $v->Area;
			}
		}

		$account_type = $this->main_model->getinfo('tbl_user_type');
		$this->data['account_type'] = array();
		if(count($account_type)>0){
			foreach($account_type as $k=>$v){
				$this->data['account_type'][$v->ID] = $v->AccountType;
			}
		}

		$this->data['tax_codes'] = array('-' => '');
		$this->main_model->setSelectFields(array('id', 'tax_code'));
		$this->main_model->setNormalized('tax_code', 'id');
		$tax_codes = $this->main_model->getinfo('tbl_tax_codes');
		$this->data['tax_codes'] += $tax_codes;

		$this->data['kiwi'] = array('' => '');
		$this->main_model->setSelectFields(array('id', 'kiwi'));
		$this->main_model->setNormalized('kiwi', 'id');
		$kiwi = $this->main_model->getinfo('tbl_kiwi');
		$this->data['kiwi'] += $kiwi;

		$table = array(
			'frequency' => 'tbl_salary_freq',
			'type' => 'tbl_salary_type'
		);
		foreach($table as $k=>$v){
			$data = $this->main_model->getinfo($v);
			$this->data[$k] = array();
			if(count($data)>0){
				foreach($data as $dk=>$dv){
					$this->data[$k][$dv->id] = $dv->$k;
					$this->data[$k][''] = '-';
				}
			}
            ksort($this->data[$k]);
		}

		$this->main_model->setJoin(array(
			'table' => array('tbl_user_account_info'),
			'join_field' => array('UserID'),
			'source_field' => array('tbl_user.ID'),
			'type' => 'left'
		));

		$this->main_model->setSelectFields(array(
			'tbl_user.ID','tbl_user_account_info.IRD','tbl_user_account_info.KiwiPercent',
			'tbl_user_account_info.AccountNumber','tbl_user_account_info.TaxCode',
			'tbl_user_account_info.AreaDesignated','tbl_user_account_info.Frequency', 'tbl_user.WageType',
			'tbl_user_account_info.FixedValue','tbl_user_account_info.Tax','tbl_user_account_info.STLoan',
			'tbl_user_account_info.KiwiSave','tbl_user.Username','tbl_user.Password','tbl_user.FName',
			'tbl_user.LName','tbl_user.EmailAddress','tbl_user.AccountType','tbl_user.AccountType','tbl_user.Address',
            'tbl_user.isCanAddJob',
            'tbl_user.isAllowWages',
            'tbl_user.isQualifiedInspector'
		));
		$this->data['staffInfo'] = $this->main_model->getinfo('tbl_user',$whatId,'tbl_user.ID');
		//DisplayArray($this->data['staffInfo']);
		if(isset($_POST['update'])){
			unset($_POST['update']);

			$data = array(
				'Username' => $_POST['username'],
				//'Password' => $this->encrypt->encode($_POST['password']),
				'FName' => $_POST['fname'],
				'LName' => $_POST['lname'],
				'EmailAddress' => $_POST['email'],
				'Address' => $_POST['address'],
				'AccountType' => $_POST['account_type'],
                'isCanAddJob' => $_POST['isCanAddJob'],
                'isQualifiedInspector' => $_POST['isQualifiedInspector'],
                'isAllowWages' => $_POST['isAllowWages'],
				'WageType' => $_POST['wage_type']
			);

			$this->main_model->update('tbl_user',$data,$whatId);

			$accountInfo = array(
				'UserID' => $whatId,
				'IRD' => $_POST['irdnum'],
				'AccountNumber' => $_POST['account_number'],
				'TaxCode' => $_POST['tax_code'] == '-' ? '' : $_POST['tax_code'],
				'AreaDesignated' => $_POST['franchise_id'],
				'Frequency' => $_POST['frequency'],
				'FixedValue' => $_POST['fixed_rate'],
				'Tax' => $_POST['tax'],
				'STLoan' => $_POST['has_stloan'] == '' ? 0 : 1,
				'KiwiSave' => $_POST['has_kiwisave'] == '' ? 0 : 1,
				'KiwiPercent' => $_POST['kiwisave_percentage'] == '' ? '' : $_POST['kiwisave_percentage']
			);
			if($this->main_model->getinfo('tbl_user_account_info',$whatId,'UserID')){
				$this->main_model->update('tbl_user_account_info',$accountInfo,$whatId,'UserID');
			}else{
				$this->main_model->insert('tbl_user_account_info',$accountInfo);
			}


			redirect('staff_list');
		}

		$this->load->view('staff/manage_staff_view/edit_staff_view',$this->data);
	}

	function deleteStaff(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		if(isset($_POST['id'])){
			$this->main_model->delete('tbl_user', $_POST['id']);
			$this->main_model->delete('tbl_user_account_info', $_POST['id'],'UserID');
		}
	}

	function jobsAllocation(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		$selectedFields = ArrayWalk($this->merit_model->getFields('tbl_job_registration'),'tbl_job_registration.');
		$selectedFields[] = 'tbl_job_registration.insured_name';
		$selectedFields[] = 'concat(user_assignment.FName," ",user_assignment.LName) as user_assignment_inspector';
		$selectedFields[] = 'concat(job_registration.FName," ",job_registration.LName) as job_inspector';
		$selectedFields[] = 'tbl_user_assignment.UserID';
		$selectedFields[] = 'tbl_user_assignment.InspectionDate';
		$selectedFields[] = 'tbl_user_assignment.InspectionTime';
		$selectedFields[] = 'tbl_user_assignment.InspectionTimeEnd';
		$selectedFields[] = 'tbl_user_assignment.IsDone';
		$selectedFields[] = 'tbl_job_type_specs.job_type_specs';

		$this->merit_model->setJoin(array(
			'table' => array(
                'tbl_user_assignment',
                'tbl_user as user_assignment',
                'tbl_user as job_registration',
                'tbl_job_type_specs'
            ),
			'join_field' => array('TrackID','ID','ID','id'),
			'source_field' => array(
                'tbl_job_registration.id',
                'tbl_user_assignment.UserID',
                'tbl_job_registration.inspector_id',
                'tbl_job_registration.job_type_id'
            ),
            'type' => 'left',
            'join_append' => array(
                'tbl_user_assignment',
                'user_assignment',
                'job_registration',
                'tbl_job_type_specs'
            )
		));

		$this->merit_model->setSelectFields($selectedFields);
		$this->merit_model->setOrder('InspectionDate','DESC');
        $this->merit_model->setGroupBy(array('tbl_job_registration.id','TrackID'));
        if($this->session->userdata('userAccountType') == 4){
            $userID = $this->session->userdata('userID');
            $this->data['jobAllocation'] = $this->merit_model->getinfo('tbl_job_registration',$userID,'inspector_id');
            $this->data['jobDone'] = count($this->merit_model->getinfo('tbl_user_assignment',array($userID,true),array('UserID','IsDone')));

            $whatFld = '';
            $whatVal = 'InspectionDate > "'.date('Y-m-d').'" AND IsDone = false AND UserID = "'.$userID.'"';
            $this->data['pendingJobs'] = count($this->merit_model->getinfo('tbl_user_assignment',$whatVal,$whatFld));
        }else{
            $this->data['jobAllocation'] = $this->merit_model->getinfo('tbl_job_registration');
            $this->data['jobDone'] = count($this->merit_model->getinfo('tbl_user_assignment',true,'IsDone'));

            $whatFld = '';
            $whatVal = 'InspectionDate > "'.date('Y-m-d').'" AND IsDone = false';
            $this->data['pendingJobs'] = count($this->merit_model->getinfo('tbl_user_assignment',$whatVal,$whatFld));
        }

        $job_id = $this->uri->segment(2);

        if($job_id){

            $this->merit_model->setSelectFields(array('id','CONCAT(FName," ",LName) as name','AccountType','isQualifiedInspector'));
            $accounts = $this->merit_model->getinfo('tbl_user');
            $inspector = array();

            if(count($accounts) > 0){
                foreach($accounts as $k=>$v){

                    @$inspector[''] = '-';
                    if($v->AccountType == 4 || $v->isQualifiedInspector){
                        $inspector[$v->id] = $v->name;
                    }
                }
            }


            $this->merit_model->setJoin(array(
                'table' => array('tbl_user'),
                'join_field' => array('ID'),
                'source_field' => array('tbl_user_assignment.UserID'),
                'type' => 'left'
            ));
            $this->merit_model->setNormalized('name','ID');
            $this->merit_model->setSelectFields(array('tbl_user.ID','CONCAT(tbl_user.FName, " ", tbl_user.LName) as name'));
            $this->data['current_inspector'] = $this->merit_model->getInfo('tbl_user_assignment',$job_id,'TrackID');

            $this->merit_model->setJoin(array(
                'table' => array('tbl_user'),
                'join_field' => array('ID'),
                'source_field' => array('tbl_job_registration.inspector_id'),
                'type' => 'left'
            ));
            $this->merit_model->setNormalized('name','ID');
            $this->merit_model->setSelectFields(array('tbl_user.ID','CONCAT(tbl_user.FName, " ", tbl_user.LName) as name'));
            $this->data['current_inspector'] += $this->merit_model->getInfo('tbl_job_registration',$job_id,'tbl_job_registration.id');
            $this->data['current'] = end($this->data['current_inspector']);

            $array_diff = count(@$inspector) > 0 && count($this->data['current_inspector']) > 0 ?
                array_diff_key(@$inspector,$this->data['current_inspector']) : array('' => '-');

            $this->data['inspector'] = $array_diff;
            $this->merit_model->setShift();
            $this->data['assignment'] = (Object)$this->merit_model->getInfo('tbl_job_registration',$job_id);
            if(isset($_POST['submit'])){
                $whatFld = array('UserID','TrackID');
                $whatVal = array($_POST['inspector_id'],$job_id);
                $user_assignment = $this->merit_model->getinfo('tbl_user_assignment',$whatVal,$whatFld);

                if(count($user_assignment) > 0){
                    foreach($user_assignment as $val){
                        $post = array(
                            'InspectionIsSet' => 1,
                            'TrackID' => $job_id,
                            'InspectionDate' => date('Y-m-d H:i:s',strtotime($_POST['inspection_time'])),
                            'InspectionTime' => date('h:i A',strtotime($_POST['inspection_time']))
                        );
                        if($_POST['inspector_id']){
                            $post['UserID'] = $_POST['inspector_id'];
                        }
                        $this->merit_model->update('tbl_user_assignment',$post,$val->id,'id',false);
                    }
                }
                else{
                    $post = array(
                        'TrackID' => $job_id,
                        'InspectionIsSet' => 1,
                        'ClientSchedule' => date('Y-m-d'),
                        'DateAssigned' => date('Y-m-d'),
                        'InspectionDate' => date('Y-m-d H:i:s',strtotime($_POST['inspection_time'])),
                        'InspectionTime' => date('h:i A',strtotime($_POST['inspection_time']))
                    );
                    if($_POST['inspector_id']){
                        $post['UserID'] = $_POST['inspector_id'];
                    }
                    $this->merit_model->insert('tbl_user_assignment',$post);
                }

                $post = array(
                    'inspector_id' => $_POST['inspector_id'],
                    'inspection_time' => date('Y-m-d H:i:s',strtotime($_POST['inspection_time']))
                );
                if($_POST['inspector_id']){
                    $post['inspector_id'] = $_POST['inspector_id'];
                }

                $this->merit_model->update('tbl_job_registration',$post,$job_id);
                redirect('jobsAllocation');
            }

            $this->load->view('jobsheet/add_job_allocation_view', $this->data);
        }
        else{
            $this->data['_pageLoad'] = 'jobsheet/job_allocation_view';
            $this->load->view('main_view', $this->data);
        }
	}

	function historyReports(){
		if($this->session->userdata('isLogged') != true){
			redirect('');
		}

		$cutoff = 2010;

		// current year
		$now = date('Y');
		$this->data['year'] = array();

		// build years menu
		for ($y=$now; $y>=$cutoff; $y--) {
			$this->data['year'][$y] = $y;
		}

		for ($m=01; $m<=12; $m++) {
			$this->data['month'][$m] = date('F', mktime(0,0,0,$m));
		}

		$this->data['declaration'][1] = 'Monthly';
		$this->data['declaration'][2] = 'Yearly';

        $this->data['invoice_history'] = array();

        $declare = 1;
        if(isset($_POST['declaration'])){
            $declare = $_POST['declaration'];
        }

        switch($declare){
            case 1:
                $date = date('Y-m');
                if(isset($_POST['month'])){
                    $what_date = $_POST['year'].'-'.$_POST['month'];
                    $date = date('Y-m',strtotime($what_date));
                }
                $whatField = '';
                $whatValue = 'tbl_statement.type = "2" AND tbl_statement.date LIKE "%'.$date.'%"';
                $this->my_model->setJoin(array(
                    'table' => array('tbl_client'),
                    'join_field' => array('id'),
                    'source_field' => array('tbl_statement.client_id')
                ));
                $fields = array(
                    'tbl_statement.id','tbl_client.CompanyName as client',
                    'tbl_statement.reference','tbl_statement.credits',
                    'DATE_FORMAT(tbl_statement.date,"%d %M %Y") as date',
                    'CONCAT("$ ",FORMAT(tbl_statement.credits,2)) as credits'
                );
                $this->my_model->setSelectFields($fields,false);
                $this->data['invoice_history'] = $this->my_model->getinfo('tbl_statement',$whatValue,$whatField);

                break;
            case 2:
                $date = date('Y');
                if(isset($_POST['year'])){
                    $date = date('Y',strtotime($_POST['year']));
                }
                $whatField = '';
                $whatValue = 'tbl_statement.type = "2" AND tbl_statement.date LIKE "%'.$date.'%"';

                $this->my_model->setJoin(array(
                    'table' => array('tbl_client'),
                    'join_field' => array('id'),
                    'source_field' => array('tbl_statement.client_id')
                ));
                $fields = array(
                    'tbl_statement.id','tbl_client.CompanyName as client',
                    'tbl_statement.reference','tbl_statement.credits',
                    'DATE_FORMAT(tbl_statement.date,"%d %M %Y") as date',
                    'CONCAT("$ ",FORMAT(tbl_statement.credits,2)) as credits'
                );
                $this->my_model->setSelectFields($fields,false);
                $invoice_history = $this->my_model->getinfo('tbl_statement',$whatValue,$whatField);
                if(count($invoice_history)>0){
                    foreach($invoice_history as $v){
                        $month = date('F Y',strtotime($v->date));
                        $this->data['invoice_history'][$month][] = (Object)array(
                            'id' => $v->id,
                            'client' => $v->client,
                            'reference' => $v->reference,
                            'credits' => $v->credits,
                            'date' => $v->date
                        );
                    }
                }

                break;
        }

        //DisplayArray($this->data['invoice_history']);

		$this->data['_pageLoad'] = 'reports/reports_history';
		$this->load->view('main_view',$this->data);
	}

    function outstandingBalance(){
        if($this->session->userdata('isLogged') != true){
            redirect('');
        }
        $this->data['client'] = $this->main_model->getinfo('tbl_client');
        $this->data['total_balance'] = 0;
        $this->data['total_nett'] = 0;
        $this->data['total_gst'] = 0;
        $this->data['total_gross'] = 0;
        if(count($this->data['client'])>0){
            foreach($this->data['client'] as $v){
                $fields = array('max(date) as date','(sum(debits) - sum(credits)) as outstanding');
                $this->my_model->setSelectFields($fields,false);
                $balance = $this->my_model->getinfo('tbl_statement',$v->ID,'client_id');
                $v->max_date = '';
                $v->balance = '$ 0.00';
                $v->gst = '$ 0.00';
                $v->nett = '$ 0.00';
                $v->gross = '$ 0.00';

                if(count($balance)>0){
                    foreach($balance as $val){
                        $this->data['total_balance'] += $val->outstanding;
                        $this->data['total_nett'] += $val->outstanding;
                        $this->data['total_gst'] += ($val->outstanding * 0.015);
                        $this->data['total_gross'] += ($val->outstanding + ($val->outstanding * 0.015));

                        $v->max_date = strtotime('j F Y',strtotime($val->date));
                        $v->balance = '$ '. number_format($val->outstanding,2,'.',',');
                        $v->gst = '$ '. number_format(($val->outstanding * 0.015),2,'.',',');
                        $v->nett = '$ '. number_format($val->outstanding,2,'.',',');
                        $v->gross = '$ '. number_format(($val->outstanding + ($val->outstanding * 0.015)),2,'.',',');
                    }
                }
            }
        }
        $this->data['_pageLoad'] = 'invoice/outstanding_balance_view';
        $this->load->view('main_view',$this->data);
    }

    function invoiceSummary(){
        if($this->session->userdata('isLogged') != true){
            redirect('');
        }
        //$cID = isset($_GET['id']) ? $_GET['id'] : exit;
        $cID = $this->uri->segment(2);
        if(!$cID){
            exit;
        }
        $cutoff = 2010;

        // current year
        $now = date('Y');
        $this->data['year'] = array();

        // build years menu
        for ($y=$now; $y>=$cutoff; $y--) {
            $this->data['year'][$y] = $y;
        }

        for ($m=01; $m<=12; $m++) {
            $this->data['month'][$m] = date('F', mktime(0,0,0,$m));
        }

        $date = date('Y-m');

        if(isset($_POST['search'])){
            $this_date = $_POST['year'] .'-'. $_POST['month'];
            $date = date('Y-m',strtotime($this_date));
        }
        $whatVal = 'tbl_statement.client_id = "'. $cID .'" AND tbl_statement.type = "1" AND tbl_statement.date LIKE "%'.$date.'%"';
        $whatFld = '';

        $this->my_model->setSearch(true);
        $this->my_model->setJoin(array(
            'table' => array('tbl_uploads_file'),
            'join_field' => array('reference'),
            'source_field' => array('tbl_statement.reference'),
            'type' => 'left'
        ));
        $this->my_model->setSelectFields(array(
            'tbl_statement.id','tbl_statement.date','tbl_statement.reference',
            'tbl_statement.debits','tbl_uploads_file.file_name',
            'DATE_FORMAT(tbl_uploads_file.date,"%M") as month',
            'DATE_FORMAT(tbl_uploads_file.date,"%Y") as year',
            'tbl_statement.client_id'
        ),false);
        $invoice = $this->my_model->getinfo('tbl_statement',$whatVal,$whatFld);

        $this->data['invoice']  = array();
        if(count($invoice)>0){
            foreach($invoice as $v){
                $whatDate = date('d-m',strtotime($v->date));
                if($whatDate <= 15){
                    $first = date('01 F Y',strtotime($v->date));
                    $date_ref = date('j F Y',strtotime('+14 days '.$first));
                }else{
                    $date_ref = date('t F Y',strtotime($v->date));
                }
                $value = (object)array(
                    'year' => $v->year,
                    'month' => $v->month,
                    'client_id' => $v->client_id,
                    'file_name' => $v->file_name,
                    'date' => date('j F Y',strtotime($v->date)),
                    'reference' => $v->reference,
                    'nett' => $v->debits,
                    'gst' => $v->debits * 0.15,
                    'amount' => $v->debits + ($v->debits * 0.15)
                );
                $this->data['invoice'][$date_ref][] = $value;
            }
        }
        $this->data['_pageLoad'] = 'invoice/invoice_summary';
        $this->load->view('main_view',$this->data);
    }

    function statement(){
        if($this->session->userdata('isLogged') == false){
            redirect('');
        }

        $cID = isset($_GET['cID']) ? $_GET['cID'] : '';
        $pageType = isset($_GET['pageType']) ? $_GET['pageType'] : '';

        if(!$cID && !$pageType){
            exit;
        }

        $this->data['invoice_info'] = $this->main_model->getinfo('tbl_invoice_info');
        $this->data['client_info'] = $this->ClientInfo($cID,true);
        $this->data['statement'] = array();

        $this->my_model->setJoin(array(
            'table' => array('tbl_invoice_type'),
            'join_field' => array('id'),
            'source_field' => array('tbl_statement.type'),
            'type' => 'left'
        ));
        $fields = array(
            'tbl_statement.id',
            'tbl_invoice_type.type',
            'tbl_statement.reference',
            'DATE_FORMAT(tbl_statement.date,"%d-%b-%Y") as date',
            'tbl_statement.debits',
            'tbl_statement.credits'
        );
        $this->my_model->setSelectFields($fields,false);
        $statement = $this->my_model->getinfo('tbl_statement',array($cID,false),array('tbl_statement.client_id','tbl_statement.is_archive'));

        $this->my_model->setSelectFields(array('max(date) as date', '(sum(debits) - sum(credits)) as outstanding','id'),false);
        $archive_statement = $this->my_model->getinfo('tbl_statement',array($cID,true),array('client_id','is_archive'));
        $balance = 0;

        if(count($archive_statement)>0){
            foreach($archive_statement as $av){
                $this->data['statement'][] = (object)array(
                    'id' => $av->id,
                    'date' => $av->date ? $av->date : date('d-M-Y'),
                    'type' => 'Opening Balance',
                    'debits' => '',
                    'credits' => '',
                    'balance' => $av->outstanding ? '$ '.number_format($av->outstanding,2,'.',',') : '$ 0.00'
                );

                $balance += $av->outstanding;
            }
        }
        if(count($statement)>0){
            foreach($statement as $v){
                $balance += $v->debits;
                $balance -= $v->credits;
                $value = (object)array(
                    'id' => $v->id,
                    'date' => $v->date,
                    'type' => $v->type.' '.$v->reference,
                    'debits' => $v->debits ? '$ '.number_format($v->debits,2,'.',',') : '',
                    'credits' => $v->credits ? '$ '.number_format($v->credits,2,'.',','): '',
                    'balance' => '$ '.number_format($balance,2,'.',',')
                );
                $this->data['statement'][] = $value;
            }
        }
        if($pageType == 'statement'){
            $this->data['_pageLoad'] = 'invoice/statement_view';
            $this->load->view('main_view',$this->data);
        }else{
            $this->data['dir'] = 'pdf/statement/'.date('Y').'/'.date('F').'/'.$_GET['cID'];
            if(!is_dir($this->data['dir'])){
                mkdir($this->data['dir'], 0777, TRUE);
            }
            $this->load->view('invoice/statement_print_view',$this->data);

            $post = array(
                'client_id' => $_GET['cID'],
                'file_type' => 4,
                'file_name' => $_GET['cID'].'_'.date('d-F-y').'.pdf',
                'date' => date('Y-m-d')
            );
            $this->main_model->insert('tbl_uploads_file',$post);
        }
    }

    function archiveStatement(){
        if($this->session->userdata('isLogged') == false){
            redirect('');
        }

        $cID = isset($_GET['cID']) ? $_GET['cID'] : '';
        if(!$cID){
            exit;
        }

        $statement = $this->my_model->getinfo('tbl_statement');
        if(count($statement)>0){
            foreach($statement as $v){
                $post = array(
                    'is_archive' => true
                );
                $this->my_model->update('tbl_statement',$post,$v->id);
            }
        }
        redirect('statement?cID='.$cID);
    }

    function addPayment(){
        if($this->session->userdata('isLogged') == false){
            redirect('');
        }

        $cID = isset($_GET['cID']) ? $_GET['cID'] : '';

        if(!$cID){
            exit;
        }
        $this->data['unpayed_invoice'] = array();
        $unpayed_invoice = $this->my_model->getinfo('tbl_statement',array(false,$cID),array('is_payed','client_id'));

        if(count($unpayed_invoice)>0){
            foreach($unpayed_invoice as $v){
                $this->data['unpayed_invoice'][''] = '-';
                $this->data['unpayed_invoice'][$v->id] = $v->reference;
            }
        }

        if(isset($_POST['submit'])){
            $this->my_model->setLastId('reference');
            $reference = $this->my_model->getinfo('tbl_statement',$_POST['invoice_ref']);
            $post = array(
                'client_id' => $cID,
                'date' => date('Y-m-d',$_POST['date']),
                'type' => 2,
                'credits' => $_POST['amount'],
                'reference' => $reference
            );

            $this->my_model->insert('tbl_statement',$post);
            $this->my_model->update('tbl_statement',array('is_payed' => true),$_POST['invoice_ref']);

            redirect('statement?cID='.$cID.'&pageType=statement');
        }

        $this->load->view('invoice/addPayment',$this->data);
    }

    function creditNote(){
        if($this->session->userdata('isLogged') == false){
            redirect('');
        }

        $cID = isset($_GET['cID']) ? $_GET['cID'] : '';
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        if(!$cID){
            exit;
        }

        $this->data['client_info'] = $this->ClientInfo($cID,true);
        $this->data['invoice_info'] = $this->my_model->getinfo('tbl_invoice_info');

        $this->my_model->setConfig(1, 0, 1);
        $this->my_model->setShift();
        $creditRef = (Object)$this->my_model->getInfo('tbl_credit_note');
        $creditCount = $this->my_model->getInfo('tbl_credit_note');
        $credit_ref = count($creditCount)>0 ? $creditRef->id + (!$creditRef->is_archived ? 0 : 1) : 1;
        $this->data['credit_ref'] = str_pad($credit_ref,4,'0',STR_PAD_LEFT);

        $this->my_model->setJoin(array(
            'table' => array('tbl_quotation','tbl_client','tbl_tracker','tbl_area_designation'),
            'join_field' => array('TrackID','ID','ID','ID'),
            'source_field' => array(
                'tbl_credit_note.job_id',
                'tbl_credit_note.client_id',
                'tbl_credit_note.job_id',
                'tbl_client.AreaDesignationID'
            ),
            'type' => 'left'
        ));

        $fields = array(
            'tbl_credit_note.id',
            'DATE_FORMAT(tbl_credit_note.date,"%d-%M-%Y") as date',
            'tbl_quotation.OrderNumber as order_number',
            'CONCAT(DATE_FORMAT(tbl_quotation.Date,"%m%y"),tbl_area_designation.BranchCode,"-",
                LPAD(tbl_credit_note.job_id, 4, "0")) as job_num',
            'tbl_client.CompanyName as job_name',
            'CONCAT(tbl_credit_note.units," units/ ",tbl_credit_note.hours," hours/ ",tbl_credit_note.km," km") as rate',
            'tbl_credit_note.extra',
            'tbl_credit_note.units',
            'tbl_credit_note.hours',
            'tbl_credit_note.km'
        );
        $this->my_model->setSelectFields($fields,false);
        $this->data['credits'] = $this->my_model->getInfo('tbl_credit_note',array($cID,false),array('client_id','is_archived'));

        $unit = $this->data['unitrate'];
        $km = $this->data['kmrate'];
        $hour = $this->data['hourrate'];
        $this->data['subTotal'] = 0;
        $this->data['overAllsubTotal'] = 0;
        $this->data['totalExtra'] = 0;
        $total = 0;
        if(count($this->data['credits'])>0){
            foreach($this->data['credits'] as $v){
                $v->unit_price = '$'.$unit.'/ '.'$'.$hour.'/ '.
                                 '$'.$km;
                $v->subtotal = $v->extra + ($v->units * $unit) +  ($v->km * $km) + ($v->hours * $hour);
                $this->data['subTotal'] = $v->subtotal;
                $this->data['overAllsubTotal'] = $v->subtotal + $v->extra;
                $this->data['totalExtra'] = $v->extra;
                $total = $this->data['overAllsubTotal'] + ($this->data['overAllsubTotal'] * 0.15);
            }
        }
        if($page != 'archive'){
            $this->data['_pageLoad'] = 'invoice/credit_note_view';
            $this->load->view('main_view',$this->data);
        }else{
            $this->data['dir'] = 'pdf/credit/'.date('Y').'/'.date('F').'/'.$_GET['cID'];
            if(!is_dir($this->data['dir'])){
                mkdir($this->data['dir'], 0777, TRUE);
            }
            $post = array(
                'type' => 3,
                'client_id' => $_GET['cID'],
                'date' => date('Y-m-d'),
                'credits' =>$total,
                'reference' => $this->data['credit_ref']
            );
            $this->main_model->insert('tbl_statement',$post);
            $this->load->view('invoice/credit_note_print_view',$this->data);
            $this->main_model->update('tbl_credit_note',array('is_archived' => true),$credit_ref);
            $post = array(
                'client_id' => $_GET['cID'],
                'file_type' => 3,
                'file_name' => $_GET['cID'].'_'.$this->data['credit_ref'].'_'.date('d-F-y').'.pdf',
                'date' => date('Y-m-d')
            );
            $this->main_model->insert('tbl_uploads_file',$post);
        }
    }

    function addCreditNote(){
        if($this->session->userdata('isLogged') == false){
            redirect('');
        }

        $cID = isset($_GET['cID']) ? $_GET['cID'] : '';

        if(!$cID){
            exit;
        }
        $credit = $this->main_model->getinfo('tbl_quotation',$cID,'ClientID');
        $this->data['trackID'] = array();
        if(count($credit)>0){
            foreach($credit as $v){
                $this->data['trackID'][''] = '-';
                $this->data['trackID'][$v->TrackID] = str_pad($v->TrackID,4,'0',STR_PAD_LEFT);
            }
        }

        if(isset($_POST['submit'])){
            unset($_POST['submit']);
            $_POST['client_id'] = $cID;
            $_POST['date'] = date('Y-m-d');
            $this->main_model->insert('tbl_credit_note',$_POST);
            redirect('creditNote?cID='.$cID);
        }
        $this->load->view('invoice/add_credit_note_view',$this->data);
    }

    function editCredits(){
        if($this->session->userdata('isLogged') == false){
            redirect('');
        }

        $id = $this->uri->segment(3);
        $cID = $this->uri->segment(2);
        if(!$id && !$cID){
            exit;
        }

        $this->main_model->setLastId('credits');
        $this->data['credits_value'] = $this->main_model->getinfo('tbl_statement',$id);

        if(isset($_POST['submit'])){
            unset($_POST['submit']);
            $this->main_model->update('tbl_statement',$_POST,$id);
            redirect('statement?cID='.$cID.'&pageType=statement');
        }

        $this->load->view('invoice/edit_credits_view',$this->data);
    }

    function pdfSummary(){
        if($this->session->userdata('isLogged') == false){
            redirect('');
        }

        $whatPage = $this->uri->segment(2);

        if(!$whatPage){
            exit;
        }

        switch($whatPage){

            case 'invoice':

                $this->data['_pageLoad'] = 'invoice/invoice_summary/invoice_summary_view';

                $this->main_model->setJoin(array(
                    'table' => array('tbl_client'),
                    'join_field' => array('ID'),
                    'source_field' => array('tbl_uploads_file.client_id'),
                    'type' => 'left'
                ));
                $this->main_model->setSelectFields(array(
                    'tbl_uploads_file.id','tbl_client.CompanyName as name','DATE_FORMAT(tbl_uploads_file.date,"%d-%M-%Y") as date',
                    'tbl_uploads_file.file_name','tbl_uploads_file.client_id','DATE_FORMAT(tbl_uploads_file.date,"%M") as month',
                    'DATE_FORMAT(tbl_uploads_file.date,"%Y") as year'
                ),false);
                $file = $this->main_model->getinfo('tbl_uploads_file',1,'file_type');
                $this->data['file'] = array();

                if(count($file)>0){
                    foreach($file as $v){
                        $whatDate = date('d-m',strtotime($v->date));
                        if($whatDate <= 15){
                            $first = date('01 F Y',strtotime($v->date));
                            $date_ref = date('j F Y',strtotime('+14 days '.$first));
                        }else{
                            $date_ref = date('t F Y',strtotime($v->date));
                        }
                        $val = (Object)array(
                            'id' => $v->id,
                            'name' => $v->name,
                            'date' => $v->date,
                            'file_name' => $v->file_name,
                            'client_id' => $v->client_id,
                            'month' => $v->month,
                            'year' => $v->year
                        );

                        $this->data['file'][$date_ref][] = $val;
                    }
                }

                $this->main_model->setLastId('type');
                $this->data['title'] = $this->main_model->getinfo('tbl_invoice_type',1);

                $this->load->view('main_view',$this->data);
                break;

            case 'credit':

                $this->data['_pageLoad'] = 'invoice/invoice_summary/credit_summary_view';
                $this->main_model->setJoin(array(
                    'table' => array('tbl_client'),
                    'join_field' => array('ID'),
                    'source_field' => array('tbl_uploads_file.client_id'),
                    'type' => 'left'
                ));
                $this->main_model->setSelectFields(array(
                    'tbl_uploads_file.id','tbl_client.CompanyName as name','DATE_FORMAT(tbl_uploads_file.date,"%d-%M-%Y") as date',
                    'tbl_uploads_file.file_name','tbl_uploads_file.client_id','DATE_FORMAT(tbl_uploads_file.date,"%M") as month',
                    'DATE_FORMAT(tbl_uploads_file.date,"%Y") as year'
                ),false);

                $this->data['file'] = $this->main_model->getinfo('tbl_uploads_file',3,'file_type');
                $this->main_model->setLastId('type');
                $this->data['title'] = $this->main_model->getinfo('tbl_invoice_type',3);

                $this->load->view('main_view',$this->data);
                break;

            case 'outstanding':

                $this->data['_pageLoad'] = 'invoice/invoice_summary/outstanding_summary_view';

                $this->main_model->setSelectFields(array(
                    'tbl_uploads_file.id','DATE_FORMAT(tbl_uploads_file.date,"%d-%M-%Y") as date',
                    'tbl_uploads_file.file_name','tbl_uploads_file.client_id','DATE_FORMAT(tbl_uploads_file.date,"%M") as month',
                    'DATE_FORMAT(tbl_uploads_file.date,"%Y") as year'
                ),false);

                $this->data['file'] = $this->main_model->getinfo('tbl_uploads_file',5,'file_type');
                $this->main_model->setLastId('type');
                $this->data['title'] = $this->main_model->getinfo('tbl_invoice_type',5);

                $this->load->view('main_view',$this->data);
                break;

            case 'statement':

                $this->data['_pageLoad'] = 'invoice/invoice_summary/statement_summary_view';

                $this->main_model->setJoin(array(
                    'table' => array('tbl_client'),
                    'join_field' => array('ID'),
                    'source_field' => array('tbl_uploads_file.client_id'),
                    'type' => 'left'
                ));
                $this->main_model->setSelectFields(array(
                    'tbl_uploads_file.id','tbl_client.CompanyName as name','DATE_FORMAT(tbl_uploads_file.date,"%d-%M-%Y") as date',
                    'tbl_uploads_file.file_name','tbl_uploads_file.client_id','DATE_FORMAT(tbl_uploads_file.date,"%M") as month',
                    'DATE_FORMAT(tbl_uploads_file.date,"%Y") as year'
                ),false);
                $file = $this->main_model->getinfo('tbl_uploads_file',4,'file_type');
                $this->data['file'] = array();

                if(count($file)>0){
                    foreach($file as $v){
                        $whatDate = date('d-m',strtotime($v->date));
                        if($whatDate <= 15){
                            $first = date('01 F Y',strtotime($v->date));
                            $date_ref = date('j F Y',strtotime('+14 days '.$first));
                        }else{
                            $date_ref = date('t F Y',strtotime($v->date));
                        }
                        $val = (Object)array(
                            'id' => $v->id,
                            'name' => $v->name,
                            'date' => $v->date,
                            'file_name' => $v->file_name,
                            'client_id' => $v->client_id,
                            'month' => $v->month,
                            'year' => $v->year
                        );

                        $this->data['file'][$date_ref][] = $val;
                    }
                }

                $this->main_model->setLastId('type');
                $this->data['title'] = $this->main_model->getinfo('tbl_invoice_type',4);

                $this->load->view('main_view',$this->data);

                break;
        }
    }

    function equipmentExcelFileList(){
        if($this->session->userdata('isLogged') === false){
            redirect('login');
        }

        $this->main_model->setJoin(array(
            'table' => array('tbl_client'),
            'join_field' => array('ID'),
            'source_field' => array('tbl_client_equipment_attachment.ClientID'),
            'type' => 'left'
        ));

        $fields = array(
            'tbl_client_equipment_attachment.ID',
            'DATE_FORMAT(tbl_client_equipment_attachment.Date,"%d %M %Y") as Date',
            'tbl_client_equipment_attachment.FileName','tbl_client.CompanyName',
            'CONCAT(tbl_client.FirstName," ",tbl_client.LastName) as ContactPerson'
        );
        $this->main_model->setSelectFields($fields,false);
        $this->data['excel_file'] = $this->main_model->getinfo('tbl_client_equipment_attachment',false,'is_added');

        $this->data['_pageLoad'] = 'excel_reader/read_excel_view';
        $this->load->view('main_view',$this->data);
    }

    /*Read Excel File*/

    function excelReader(){
        if($this->session->userdata('isLogged') === false){
            redirect('login');
        }

        $file_id = $this->uri->segment(2);

        if(!$file_id){
            exit;
        }

        $filename = $this->my_model->getinfo('tbl_client_equipment_attachment',$file_id);
        $uploaddir = realpath(APPPATH.'../uploads');
        $this->data['filename'] = '';
        //$file = '';
        if(count($filename)>0){
            foreach($filename as $v){
                $dir = $uploaddir.'/equipment/'.date('Y',strtotime($v->Date)).'/'.date('M',strtotime($v->Date)).'/';
                $this->data['filename'] = $dir.'/('.$v->ClientID.') '.$v->FileName;
                //$getfilename = str_replace('.xls','',$v->FileName);
                //$file = $getfilename;
            }
        }

        $this->load->view('excel_reader/excel_view',$this->data);
    }
}