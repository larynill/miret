<?php
include('merit.php');

class Inspector_Controller extends Merit{
	function __construct(){
		parent::__construct();
		$this->load->helper('text');
	}
    function dashboard(){
        $this->Restrictions($this->session->userdata('userID'));

        $userID = $this->session->userdata('userID');
        $userData = $this->GetUserInfo($userID);
		$dashboardHeader = '';
		$assignData = array();

        $this->data['assignData'] = $assignData;
        $this->data['dashboardHeader'] = $dashboardHeader;
        $this->data['_userDataTable'] = $userData;
        $this->data['_pageLoad'] = 'inspector/dashboard_view';
        $this->load->view('main_view', $this->data);
    }

    function myDiary(){
        $this->Restrictions($this->session->userdata('userID'));

        $userID = $this->session->userdata('userID');
        $userData = $this->GetUserInfo($userID);
        $userJobData = $this->GetUserJob($userID);

		$this->main_model->setJoin(array(
			'table' => array('tbl_tracker','tbl_client','tbl_distance_from','tbl_distance_from_value'),
			'join_field' => array('ID','ID','ID','ID'),
			'source_field' => array('tbl_user_assignment.TrackID','tbl_tracker.ClientID','tbl_client.Distance',
									'tbl_client.DistanceFrom'),
			'type' => 'left'
		));

		$this->main_model->setSelectFields(array(
			'tbl_user_assignment.ID','tbl_client.CompanyName',
			'tbl_user_assignment.TrackID','tbl_user_assignment.ClientSchedule',
			'tbl_user_assignment.InspectionIsSet', 'tbl_user_assignment.InspectionDate',
			'tbl_user_assignment.UserID','tbl_tracker.EquipID','tbl_user_assignment.InspectionTime',
			'tbl_client.KmDistance','tbl_distance_from.FromName', 'tbl_distance_from_value.FromName as distance'
		),false);

		$whatField = array('tbl_user_assignment.UserID', 'tbl_user_assignment.InspectionIsSet !=');
		$whatVal = array($this->session->userdata('userID'), 1);

		//save the config
		//$config = $this->main_model->config;

		$thisAssign = $this->main_model->getinfo('tbl_user_assignment',$whatVal,$whatField);

		$this->data['_assign'] = $thisAssign;

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
        if(isset($_POST['dropToDate'])){ //get post for date change in the calendar
            $equipID = $_POST['ID'];
            $postData = array(
                'InspectionDate' => $_POST['InspectionDate']
            );
            $this->main_model->update('tbl_client_equipment', $postData, $equipID);
        }
		
        $this->data['_schedules'] = json_encode($schedules);
        $this->data['_userDataTable'] = $userData;
        $this->data['_clientData'] = $clientData;
        $this->data['_equipData'] = $equipData;

		//get all the Jobs Assigned to the Inspector

		$whatField = array('tbl_user_assignment.UserID', 'tbl_user_assignment.InspectionIsSet !=');
		$whatVal = array($this->session->userdata('userID'),0);
		//$this->main_model->config = $config;
        $this->main_model->setJoin(array(
            'table' => array('tbl_tracker','tbl_client','tbl_distance_from','tbl_distance_from_value'),
            'join_field' => array('ID','ID','ID','ID'),
            'source_field' => array('tbl_user_assignment.TrackID','tbl_tracker.ClientID','tbl_client.Distance',
                'tbl_client.DistanceFrom'),
            'type' => 'left'
        ));

        $this->main_model->setSelectFields(array(
            'tbl_user_assignment.ID','tbl_client.CompanyName',
            'tbl_user_assignment.TrackID','tbl_user_assignment.ClientSchedule',
            'tbl_user_assignment.InspectionIsSet', 'tbl_user_assignment.InspectionDate',
            'tbl_user_assignment.UserID','tbl_tracker.EquipID','tbl_user_assignment.InspectionTime',
            'tbl_client.KmDistance','tbl_distance_from.FromName', 'tbl_distance_from_value.FromName as distance'
        ),false);

		$this->main_model->setSelectFields(
			array(
				'tbl_user_assignment.ID as id','tbl_user_assignment.TrackID',
				'tbl_client.CompanyName as title','tbl_user_assignment.InspectionTime',
				'DATE_FORMAT(tbl_user_assignment.InspectionDate, "%Y %c %d") AS start', 'tbl_user_assignment.IsDone',
				'tbl_client.KmDistance','tbl_distance_from.FromName', 'tbl_distance_from_value.FromName as distance',
				'tbl_user_assignment.InspectionTimeEnd'
			)
		);
		$_assign_json = $this->main_model->getinfo('tbl_user_assignment', $whatVal, $whatField);
		if(count($_assign_json)>0){
			foreach($_assign_json as $k=>$v){
				$this->main_model->setLastId('EquipID');
				$equipmentID = $this->main_model->getinfo('tbl_tracker',$v->TrackID);

				$v->end = $v->start.' '.$v->InspectionTimeEnd;
				$v->start = $v->start.' '.$v->InspectionTime;
				$v->job = '('.count(json_decode($equipmentID)).') '.$v->title;
				$v->change_color_class =  $v->IsDone ? true : '';
				$v->title = word_limiter($v->job, 2,'...');
				$v->distance = $v->FromName.' to '.$v->distance.' ('.$v->KmDistance.' km)';
				$v->equipment = array();
				$v->allDay = false;
				$thisEquip = json_decode($equipmentID);
				if(count($thisEquip)>0){
					foreach($thisEquip as $ek=>$ev){
						$whatEquipment = $this->main_model->getinfo('tbl_client_equipment',$ev);
						if(count($whatEquipment)>0){
							foreach($whatEquipment as $wk=>$wv){
								$v->equipment[] = count($v->equipment) + 1 .'. ' .$wv->PlantDescription.'<br/>';
							}
						}
					}
				}
			}
		}
		$this->data['_assign_json'] = json_encode($_assign_json);
        $this->data['_pageLoad'] = 'inspector/mydiary_view';
        $this->load->view('main_view', $this->data);
    }

	//this is to set the Inspection Date by the Inspector
	function inspector_set_date(){
		if($this->session->userdata('isLogged') == false){
            redirect('login');
        }
		
		$assignId = $this->uri->segment(2);
		if(!$assignId){
			exit;
		}
		$post = array(
			'InspectionIsSet' => 1,
			'InspectionDate' => isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'),
			'InspectionTime' => isset($_GET['start']) ? $_GET['start'] : date('H:i g'),
			'InspectionTimeEnd' => isset($_GET['end']) ? $_GET['end'] : date('H:i g')
		);
		$this->main_model->update('tbl_user_assignment', $post, $assignId);
	}

	function inspection_report(){
		if($this->session->userdata('isLogged') == false){
			redirect('login');
		}

		$jobId = $this->uri->segment(3);
		$pageId = $this->uri->segment(2);

		if(!$jobId || !$pageId){
			exit;
		}
		$this->main_model->setLastId('TrackID');
		$trackID = $this->main_model->getinfo('tbl_user_assignment',$jobId);

		$this->main_model->setLastId('InspectionDate');
		$this->data['inspectionDate'] = $this->main_model->getinfo('tbl_user_assignment',$jobId);

		$this->main_model->setLastId('EquipID');
		$equipID = $this->main_model->getinfo('tbl_tracker',$trackID);
		$equipVal = json_decode($equipID);
		$this->data['equip'] = array();
		$this->data['issueEquip'] = array();
		$this->data['disableArchive'] = '';
		$this->data['disableIssue'] = 'disableButton';
		$this->data['printcertificate'] = array();

		if(count($equipVal)>0){
			foreach($equipVal as $ek=>$ev){
				$equip = $this->main_model->getinfo('tbl_client_equipment',$ev);
				if(count($equip)>0){
					foreach($equip as $k=>$v){
						$this->data['equip'][$v->ID] = $v->PlantDescription;
					}
				}
			}
		}
		$this->main_model->setJoin(array(
			'table' => array('tbl_client_equipment'),
			'join_field' => array('ID'),
			'source_field' => array('tbl_inspection_report.EquipID'),
			'type' => 'left'
		));
		$this->main_model->setSelectFields(array(
			'tbl_inspection_report.ID','tbl_inspection_report.EquipID','tbl_inspection_report.TrackID',
			'tbl_client_equipment.PlantDescription','tbl_client_equipment.ClientID','tbl_inspection_report.Pressure',
			'tbl_inspection_report.Temperature','tbl_inspection_report.Contents','tbl_inspection_report.SafetyValve',
			'tbl_inspection_report.Purpose','tbl_inspection_report.Date','tbl_client_equipment.PlantDescription',
			'tbl_client_equipment.Manufacturer','tbl_client_equipment.ExpectationDate','tbl_inspection_report.OfficialNo',
			'tbl_inspection_report.Capacity'
		));
		$this->data['printcertificate'] = $this->main_model->getinfo('tbl_inspection_report',$trackID,'tbl_inspection_report.TrackID');
		$val = str_pad($jobId, 5, '0', STR_PAD_LEFT);
		if(count($this->data['printcertificate'])>0){
			foreach($this->data['printcertificate'] as $k=>$v){
				$client = $this->ClientInfo($v->ClientID);
				if(count($client)>0){
					foreach($client as $ck=>$cv){
						$v->CompanyName = $cv->CompanyName;
						$v->ContactPerson = $cv->ContactPerson;
						$v->PostalAdress = $cv->PostalAdress;
						$v->MobilePhone = $cv->MobilePhone;
						$v->BranchCode = $cv->BranchCode;
					}
				}
				$this->main_model->setLastId('ID');
				$reportID = $this->main_model->getinfo('tbl_inspection_report',$v->ID);
				$id = $v->ID ? $v->ID : $reportID + 1;
				$v->JobNumber = date('my',strtotime($this->data['inspectionDate'])).$v->BranchCode.'-'.$val.'/'.$id;
			}
		}

		$this->main_model->setJoin(array(
			'table' => array('tbl_client_equipment'),
			'join_field' => array('ID'),
			'source_field' => array('tbl_inspection_report.EquipID'),
			'type' => 'left'
		));
		$this->main_model->setSelectFields(array(
			'tbl_inspection_report.ID','tbl_inspection_report.EquipID',
			'tbl_client_equipment.ID as equipmentID','tbl_client_equipment.PlantDescription',
			'tbl_inspection_report.TrackID'
		));
		$reportEquip = $this->main_model->getinfo('tbl_inspection_report',$trackID,'tbl_inspection_report.TrackID');

		if(count($reportEquip)>0){
			foreach($reportEquip as $k=>$v){
				$this->data['issueEquip'][$v->equipmentID] = $v->PlantDescription;
			}
		}
		if($pageId == 'report' || $pageId == 'editreport'){
			reset($this->data['equip']);
			$whatEquip = key($this->data['equip']);
		}else{
			reset($this->data['issueEquip']);
			$whatEquip = key($this->data['issueEquip']);
		}

		if(isset($_POST['search'])){
			$whatEquip = $_POST['equipment'];
		}
		$this->data['EquipID'] = $whatEquip;
		$thisID = '';
		//$this->data['hasArchive'] = '';
		$equipment = $this->main_model->getinfo('tbl_client_equipment',$whatEquip);;
		if(count($equipment)){
			foreach($equipment as $k=>$v){
				$clientInfo = $this->ClientInfo($v->ClientID);
				if(count($clientInfo)>0){
					foreach($clientInfo as $ck=>$cv){
						$v->CompanyName = $cv->CompanyName;
						$v->ContactPerson = $cv->ContactPerson;
						$v->PostalAdress = $cv->PostalAdress;
						$v->MobilePhone = $cv->MobilePhone;
						$v->BranchCode = $cv->BranchCode;
					}
				}

				$this->main_model->setJoin(array(
					'table' => array('tbl_inspection_report'),
					'join_field' => array('ID'),
					'source_field' => array('tbl_inspection_assessment.InspecID'),
					'type' => 'left'
				));

				$inspectionReport = $this->main_model->getinfo('tbl_inspection_assessment',$v->ID,'tbl_inspection_report.EquipID');
				$this->main_model->setNoReset(true);
				$whatField = $this->main_model->getFields('tbl_inspection_assessment',array("ID","InspecID"));
				$v->Pressure = '';
				$v->Temperature = '';
				$v->Contents = '';
				$v->SafetyValve = '';
				$v->OfficialNo = '';
				$v->Capacity = '';
				$v->Purpose = '';
				$v->ReportID = '';

				foreach($whatField as $whatName){
					$v->$whatName = (object)array('acceptable'=>'','comment'=>'');
					$v->$whatName->acceptable = '';
					$v->$whatName->comment = '';
				}
				if(count($inspectionReport)>0){
					foreach($inspectionReport as $ik=>$iv){
						//$this->data['issueequip'][$v->ID] = $v->PlantDescription;
						$v->ReportID = $iv->ID;
						$thisID = $iv->ID;

						$this->data['disableIssue'] = '';
						$this->data['disableArchive'] = 'disableButton';

						$v->Pressure = $iv->Pressure;
						$v->Temperature = $iv->Temperature;
						$v->Contents = $iv->Contents;
						$v->SafetyValve = $iv->SafetyValve;
						$v->Purpose = $iv->Purpose;
						$v->OfficialNo = $iv->OfficialNo;
						$v->Capacity = $iv->Capacity;

						foreach($whatField as $fieldName){
							$v->$fieldName = (object)json_decode($iv->$fieldName);
							if($v->$fieldName->acceptable){
								$v->$fieldName->acceptable = '&#x2713;';
							}else{
								$v->$fieldName->acceptable = '&#x2717;';
							}
							$v->$fieldName->comment = $v->$fieldName->comment ? $v->$fieldName->comment : ' ';
						}
						$v->FirstComment = (object)json_decode($iv->FirstComment);
						$v->SecondComment = (object)json_decode($iv->SecondComment);
					}
				}

				$this->main_model->setLastId('ID');
				$reportID = $this->main_model->getinfo('tbl_inspection_report',$v->ReportID);
				$v->ReportID = $v->ReportID ? $v->ReportID : $reportID + 1;
				$v->JobNumber = date('my',strtotime($this->data['inspectionDate'])).$v->BranchCode.'-'.$val.'/'.$v->ReportID;
			}
		}

		if(isset($_POST['Archive'])){
			$tableFields = $this->main_model->getFields('tbl_inspection_report');
			$reg_post = array();
			$reg_post['EquipID'] = $_POST['EquipID'];
			$reg_post['TrackID'] = $trackID;
			$reg_post['Date'] = date('Y-m-d');
			if(count($_POST)>0){
				foreach($tableFields as $tableField){// get all table fields equal to post fields
					foreach($_POST as $postKey => $postField){
						if($postKey == $tableField){
							$reg_post[$tableField] = $_POST[$tableField];
						}
					}
				}
			}

			if($pageId == 'editreport'){
				$this->main_model->update('tbl_inspection_report',$reg_post,$thisID);
			}else{
				$this->main_model->insert('tbl_inspection_report',$reg_post);
			}

			$Fields = $this->main_model->getFields('tbl_inspection_assessment', array("ID"));
			$_post = array();

			$this->main_model->setLastId('ID');
			$inspecID = (int)$this->main_model->getinfo('tbl_inspection_report');


			if(count($_POST)>0){
				foreach($Fields as $tableFld){
					$data = array(
						'acceptable' => isset($_POST[$tableFld . '_ACCEPT']),
						'comment' => isset($_POST[$tableFld]) ? $_POST[$tableFld] : ''
					);
					$_post[$tableFld] = json_encode($data);
				}
			}
			if(isset($_POST['FirstComment'])){
				foreach($_POST['FirstComment'] as $k=>$v){
					$fields = array('acceptable', 'comment');
					$data = array_combine($fields, $_POST['FirstComment'] );
					$_post['FirstComment'] = json_encode($data);
				}
			}
			if(isset($_POST['SecondComment'])){
				foreach($_POST['SecondComment'] as $k=>$v){
					$fields = array('acceptable', 'comment');
					$data = array_combine($fields, $_POST['SecondComment'] );
					$_post['SecondComment'] = json_encode($data);
				}
			}
			$_post['InspecID'] = $inspecID;
			if($pageId == 'report'){
				$this->main_model->insert('tbl_inspection_assessment',$_post);
			}
			if($pageId == 'editreport'){
				$this->main_model->update('tbl_inspection_assessment',$_post,$thisID);
			}

			redirect('inspection_report/report/'.$jobId);

		}


		$this->data['equipment'] = array();
		$this->data['certificate'] = array();

		if($pageId == 'report' || $pageId == 'editreport'){
			$this->data['equipment'] = $equipment;
		}
		if($pageId == 'issue'){
			$this->data['certificate'] = $equipment;
		}
		if($pageId == 'print'){
			$this->main_model->update('tbl_user_assignment',array('IsDone'=>true),$jobId);
			$this->data['certificate'] = $equipment;
			$this->load->view('inspector/print_certificate',$this->data);
		}

		$this->data['_pageLoad'] = 'inspector/inspection_report_view';
		$this->load->view('main_view', $this->data);
	}

	function staff_profile(){
		if($this->session->userdata('isLogged') != true){
			redirect('login');
		}
		$userId = $this->session->userdata('userID');

		$this->data['userInfo'] = $this->GetUserInfo($userId);

		$this->main_model->setJoin(array(
			'table' => array('tbl_tracker','tbl_client'),
			'join_field' => array('ID','ID'),
			'source_field' => array('tbl_user_assignment.TrackID','tbl_tracker.ClientID'),
			'type' => 'left'
		));

		$this->main_model->setSelectFields(array(
			'tbl_user_assignment.ID','tbl_user_assignment.TrackID','tbl_user_assignment.UserID',
			'tbl_user_assignment.IsDone','tbl_client.CompanyName'
		));
		$this->data['jobInfo'] = $this->main_model->getinfo('tbl_user_assignment',$userId,'UserID');
		$whatVal = array($userId,false);
		$whatFld = array('UserID','IsDone');

		$this->data['jobNumber'] = count($this->main_model->getinfo('tbl_user_assignment',$userId,'UserID'));
		$this->data['activeJob'] = count($this->main_model->getinfo('tbl_user_assignment',$whatVal,$whatFld));

		$this->data['_pageLoad'] = 'inspector/staff_profile';
		$this->load->view('main_view',$this->data);
	}

	function staff_leave(){
		if($this->session->userdata('isLogged') != true){
			redirect('login');
		}
		$userId = $this->session->userdata('userID');
		$this->main_model->setJoin(array(
			'table' => array('tbl_leave_type'),
			'join_field' => array('ID'),
			'source_field' => array('tbl_staff_leave.LeaveTypeID'),
			'type' => 'left'
		));

		$this->data['staff_leave'] = $this->main_model->getinfo('tbl_staff_leave',$userId,'StaffID');
		$totalDays = 0;
		$this->data['totalConsume'] = 20;
		if(count($this->data['staff_leave'])>0){
			foreach($this->data['staff_leave'] as $sk=>$sv){
				$sv->days = floor((strtotime($sv->EndDate) - strtotime($sv->StartDate))/(60*60*24));
				$totalDays += $sv->days;
				$this->data['totalConsume'] = 20 - $totalDays;
			}
		}
		$this->data['leave_type'] = array();
		$leave_type = $this->main_model->getinfo('tbl_leave_type');
		if(count($leave_type)>0){
			foreach($leave_type as $k=>$v){
				$this->data['leave_type'][$v->ID] = $v->LeaveType;
			}
		}

		if(isset($_POST['submit'])){
			$data = array(
				'StaffID' => $userId,
				'StartDate' => date('Y-m-d',strtotime($_POST['startDate'])),
				'EndDate' => date('Y-m-d',strtotime($_POST['endDate'])),
				'LeaveTypeID' => $_POST['leaveType'],
				'Reason' => $_POST['reason']
			);

			$this->main_model->insert('tbl_staff_leave',$data);
			redirect('staff_leave');
		}

		$this->data['_pageLoad'] = 'inspector/leave_view';
		$this->load->view('main_view',$this->data);
	}

	function payment_detail(){
		if($this->session->userdata('isLogged') != true){
			redirect('login');
		}

		$userID = $this->session->userdata['userID'];
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
		reset($this->data['year']);
		$year = key($this->data['year']);
		reset($this->data['month']);
		$month = key($this->data['month']);


		if(isset($_POST['submit'])){
			$year = $_POST['year'];
			$month = $_POST['month'];
		}

		$this->data['dateArr'] = $this->getWednesdays($year, $month);

		$userInfo = $this->arrayWalk(
			array('ID','Username','FName','LName','EmailAddress','AccountType','WageType'),'tbl_user.'
		);
		$account = $this->arrayWalk(
			array('IRD','AccountNumber','TaxCode','Frequency','FixedValue','Tax','STLoan','KiwiSave'),'tbl_user_account_info.');
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
		$this->data['empArr'] = $this->main_model->getinfo('tbl_user',$userID,'tbl_user.ID');
		/*foreach ($this->getWednesdays($year, $month) as $sunday) {
			echo $sunday->format("l, Y-m-d").'<br/>';
		}*/

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

					if(count($paye_deduction)>0){
						foreach($paye_deduction as $pk=>$pv){
							$v->Paye = $pv->paye;
						}
					}
				}
			}
		}

		//DisplayArray($this->data['empArr']);

		$this->data['_pageLoad'] = 'inspector/payment_detailed';
		$this->load->view('main_view',$this->data);
	}
}

