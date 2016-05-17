<?php
include('merit.php');
class Request_Controller extends Merit{

	function __construct(){
		parent::__construct();

	}

    function request()
    {
        if($this->uri->segment(2) == 'reminder')
        {
            if($this->uri->segment(3))
            {
                $clientID = $this->uri->segment(3);
                $this->first_reminder($clientID);
            }
        }
        if($this->uri->segment(2) == 'quote')
        {
            $this->request_quote();
        }
        if($this->uri->segment(2) == 'view')
        {
            $this->request_view();
        }
        if($this->uri->segment(2) == 'send_quote')
        {
            if($this->uri->segment(3)){
                if($this->uri->segment(4)){
                    $quoteID = $this->uri->segment(3);
                    $clientID = $this->uri->segment(4);
                    $this->send_quote($quoteID, $clientID);
                }
            }
        }
        if($this->uri->segment(2) == 'quote_accept'){
            if($this->uri->segment(3)){
                $clientID = $this->uri->segment(3);
                $this->quote_accept($clientID);
            }
        }
    }

    //sends a first reminder to client
    private function first_reminder($clientID)
    {
        $field = array('ID');
        $value = array($clientID);
		$insertData = array();
        $clientData = $this->GetMonthlyClient($value, $field, date('Y-m', strtotime('+1 month')));
		$equipment = array();
        if(count($clientData) > 0){
            foreach($clientData as $client){
                $email = $client->Email; //client email
                if(count($client->Equipment) > 0)
                {
                    foreach($client->Equipment as $equip)
                    {
						$equipment[] = $equip->ID;
                        $data['equipData'][$equip->PlantDescription] = date('F d Y', strtotime($equip->InspectionDate));
                        //insert an equipment status


                    }
                }
				$insertData = array(
					'ClientID' => $client->ID,
					'FirstReminder' => 8 ,
					'EquipID' => json_encode($equipment) //set to Inspection Reminder Sent
				);

				$trackID = $this->main_model->insert('tbl_tracker', $insertData,false);

                $data['clientID'] = $clientID;
                $data['trackID'] = $trackID;
				//$this->load->view('emailMessages/reminder/first_reminder_view', $data);
                $emailMessage = $this->load->view('emailMessages/reminder/first_reminder_view', $data,true);
               	$this->sendmail($emailMessage ,$email);

                redirect('track/client/next');
            }
        }
    }


	function first_reminder_send(){
		$client = $this->main_model->getinfo('tbl_client');
		$this->data['client'] = array();
		$this->data['equipment'] = array();

		$next15th = mktime(0, 0, 0, date('n') + (date('j') >= 15), 15);
		$thisDay = date('Y-m-d',strtotime('+1 month'));
		$whatDay = date('Y-m-d', $next15th);

		if($thisDay == $whatDay){
			if(count($client)>0){
				foreach($client as $k=>$v){
					/*$date = date('Y-m', strtotime('+1 month'));

					$sql = "SELECT `ID`, `PlantDescription` FROM (`tbl_client_equipment`) WHERE `ClientID` = '".$v->ID."' AND";
					$sql .= "`InspectionDate` LIKE '%".$date."%'";
					$this->data['client'][$v->ID] = $this->main_model->mysqlstring($sql);*/
					$this->first_reminder($v->ID);

				}
			}
		}

	}

    private function request_quote()
    {
        if($this->uri->segment(3)){
            $trackID = $this->uri->segment(3);
            //update the tracker
            $updateData = array(
                'QuoteRequest' => true, //set to Quote Requested
                'QuoteRequestDate' => date('Y-m-d h:i:s')
            );
            $this->main_model->update('tbl_tracker', $updateData, $trackID);
        }

        $this->data['_pageLoad'] = 'request/quote_request_view';
        $this->load->view('main_view', $this->data);
    }

    //manager action
    //sends a quote upon request
    private function send_quote($quoteID, $trackID)
    {
        $field = array('ID');
        $value = array($trackID);
        $clientData = $this->GetMonthlyClient($value, $field, date('Y-m', strtotime('+1 month')));
        if(count($clientData) > 0){
            foreach($clientData as $client){
                $email = $client->Email; //client email
                if(count($client->Equipment) > 0)
                {
                    foreach($client->Equipment as $equip)
                    {
                        $data['equipData'][$equip->PlantDescription] = date('F d Y', strtotime($equip->InspectionDate));

                    }
                }
                //$data['clientID'] = $clientID;
                $data['trackID'] = $trackID;
                $emailMessage = $this->load->view('emailMessages/quote_send_view', $data, true);
                $this->sendmail($emailMessage ,$email);

                //redirect('track/client/next');
            }

        }
		$updateData = array(
			'QuoteSent' => true,
			'QuoteSentDate' =>  date('Y-m-d h:i:s')
		);

		$this->main_model->update('tbl_tracker', $updateData, $trackID);

		$updateData = array(
			'IsQueue' => true
		);
		$this->main_model->update('tbl_client_quotes', $updateData, $quoteID);

        redirect('diary');
    }

	function actual_quote(){
		if($this->session->userdata('isLogged') == false){
			redirect('login');
		}

		$trackID = $this->uri->segment(2);
		$quoteID = $this->uri->segment(3);
		$quotationID = $this->uri->segment(4);

		$this->main_model->setLastId('ClientID');
		$clientID = $this->main_model->getinfo('tbl_tracker',$trackID);

		$this->main_model->setLastId('Email');
		$email = $this->main_model->getinfo('tbl_client',$clientID);

		$data['clientInfo'] = $this->main_model->getinfo('tbl_client',$clientID);

		$data['quotationID'] = $quotationID;
		$data['trackID'] = $trackID;
		$data['quotation'] = $this->main_model->getinfo('tbl_quotation',$quotationID);

		$this->main_model->setLastId('Value');
		$unitRate = $this->main_model->getinfo('tbl_rate',1);

		$this->main_model->setLastId('Value');
		$hourlyRate = $this->main_model->getinfo('tbl_rate',2);

		$this->main_model->setLastId('Value');
		$kmRate = $this->main_model->getinfo('tbl_rate',3);

		$this->main_model->setLastId('ID');
		$quoteNumber = (int)$this->main_model->getinfo('tbl_quotation',$quotationID);

		$data['quoteNumber'] = $quoteNumber ? 'UI'.str_pad($quoteNumber, 4, '0', STR_PAD_LEFT) : '';

		if(count($data['quotation'])>0){
			foreach($data['quotation'] as $v){
				$v->inspection = $v->UnitPrice ? '<strong>'.($v->UnitPrice / $unitRate) .'</strong> units at <strong>$'. $unitRate.'</strong> per unit' : '<strong>'.($v->PerHour / $hourlyRate).' hours</strong> at <strong>$'.$hourlyRate.'</strong> per hour';
				$v->totalUnitPrice = $v->UnitPrice ? '$'.$v->UnitPrice : '$'.$v->PerHour;
				$v->totalInspection = $v->UnitPrice ? $v->UnitPrice : $v->PerHour;

				$v->travelTime = $v->TravelTime ? '<strong>'.($v->TravelTime / $hourlyRate) .' hours</strong> at <strong>$'.$hourlyRate.'</strong> per hour' : '<strong>0 hours</strong> at <strong>$'.$hourlyRate.'</strong> per hour';
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

		$this->load->view('emailMessages/quote/actual_quotation', $data);
		//DisplayArray($data['actual_quote']);
		$updateData = array(
			'QuoteSent' => true,
			'QuoteSentDate' =>  date('Y-m-d h:i:s')
		);

		$this->main_model->update('tbl_tracker', $updateData, $trackID);

		$updateData = array(
			'IsQueue' => true
		);
		$this->main_model->update('tbl_client_quotes', $updateData, $quoteID);

		$emailMessage = $this->load->view('emailMessages/quote/actual_quotation_view_message', $data, true);
		$this->sendmail($emailMessage ,$email);
		redirect('diary');
	}

	function accept_qoute(){
		$trackID = $this->uri->segment(2);
		$quotationID = $this->uri->segment(3);
		if(!$trackID || !$quotationID){
			exit;
		}

		if(isset($_POST['submit'])){
			$this->data['orderNumber'] = $this->main_model->getinfo('tbl_quotation',$_POST['orderNumber'],'OrderNumber');
			$this->data['number'] = $_POST['orderNumber'];
			if(!$_POST['orderNumber'] || count($this->data['orderNumber'])>0){
				$this->load->view('pagecomponents/error_page',$this->data);
			}else{

				$this->main_model->update('tbl_quotation',array('OrderNumber' => $_POST['orderNumber']),$quotationID);

				$insertData = array(
					'TrackID' => $trackID,
					'DateAccept' => date('Y-m-d')
				);
				$this->main_model->insert('tbl_user_assignment', $insertData);

				redirect('diary');
			}
		}
	}

    //client action
    //client accepts the quote requested
    private function quote_accept($trackerID)
    {
        $field = array('ID');
        $value = array($trackerID);
        $clientData = $this->GetMonthlyClient($value, $field, date('Y-m', strtotime('+1 month')));
        if(count($clientData) > 0){
            foreach($clientData as $client){
                if(count($client->Equipment) > 0)
                {
                    foreach($client->Equipment as $equip)
                    {
                        $data['equipData'][$equip->PlantDescription] = date('F d Y', strtotime($equip->InspectionDate));
                    }
                }
            }
            //updates the tracker that the quote has been accepted
            $updateData = array(
                'QuoteAccepted' => true,
                'QuoteAcceptedDate' => date('Y-m-d h:i:s')
            );
            $this->main_model->update('tbl_tracker', $updateData, $trackerID);

            //inserts clientID to user_assignment
            $insertData = array(
                'TrackID' => $trackerID
            );
            $this->main_model->insert('tbl_user_assignment', $insertData);

            redirect('diary');
        }
    }

    function sendRegistration(){
        /*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }*/
        $this->load->view('client/send_registration_view');
    }

	function registration_request(){
        $whatEmail = isset($_GET['mail']) ? $_GET['mail'] : '';
		//$whatId = $this->uri->segment(2);
		if(!$whatEmail){
			exit;
		}
		/*$this->main_model->setLastId('Email');
		$email = $this->main_model->getInfo('tbl_client',$whatId);*/

		$this->data['city'] = array();
		$city = $this->main_model->getinfo('tbl_city',163,'country_id');
		$this->data['cutOff'] = array();
		$cutOff = $this->main_model->getinfo('tbl_accounting_cut_off');
		if(count($city)>0){
			foreach($city as $ck=>$cv){
				$this->data['city'][$cv->id] = $cv->Name;
			}
		}
		if(count($cutOff)>0){
			foreach($cutOff as $k=>$v){
				$this->data['cutOff'][$v->ID] = $v->CutOff;
			}
		}
		//$this->load->view('emailMessages/embed_iframe',$this->data);
		$emailMessage = $this->load->view('emailMessages/embed_iframe',$this->data,true);

		$this->sendmail($emailMessage ,$whatEmail);

        /*$this->session->set_flashdata(
            array(
                '_errorMessage'=>
                '<div class="ui-widget" style="color:#33a344">
                    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
                        <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                            <strong>Confirm:</strong> Email has been sent!</p>
                    </div>
                </div>'
            )
        );*/
        redirect('diary');
        /*if($this->session->userdata('isLogged') == false){
            redirect('login');
        }else{
            redirect('diary');
        }*/
		//$this->load->view('emailMessages/welcome_letter',$this->data);
	}
	
	function registration_success(){
		$ClientId = $this->uri->segment(2);
		
		if(!$ClientId){
			exit;
		}
		$this->data['clientInfo'] = $this->main_model->getinfo('tbl_client',$ClientId);
		$email = '';
		if(count($this->data['clientInfo'])){
			foreach ($this->data['clientInfo'] as $key => $value) {
				$postal = json_decode($value->PostalAdress);
				$email = $value->Email;
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
						$value->postalAddress = $postalAddress->street.' '.$postalAddress->street_name.'<br/>'.$postalAddress->suburb;
						$value->postalAddress .= ' '.$v->Name.'<br/> '.$v->CountryName.' '.$postalAddress->zip;
					}
				}
			}
		}
		//$this->load->view('emailMessages/welcome_letter',$this->data);
		$emailMessage = $this->load->view('emailMessages/welcome_letter',$this->data,true);
		$this->sendmail($emailMessage ,$email);
		redirect('login');
	}

    function quoteVerify(){
        $msg = '';
        $clientID = '';
        $asd = 'nothing';
        if($this->uri->segment(2)){
            $clientID = $this->encryption->decode($this->uri->segment(2));
            $clientData = $this->GetMonthlyClient($clientID);
            $this->data['_clientData'] = array();
            $jobData = $this->main_model->getinfo('tbl_job_monthly', $clientID, 'ClientID');

            if(count($clientData) > 0){
                foreach($clientData as $client){
                    if(count($jobData) == 0 && $client->StatusID == 4){
                        $this->data['_clientData'] = $clientData;
                    }else if($client->StatusID == 3){
                        $this->data['_errorMessage'] = 'You have already accepted the quote.';
                        $this->session->set_flashdata('quoteAccepted', true);
                        break;
                    }
                    else if(    $client->StatusID == 5){
                        $this->data['_errorMessage'] = 'You have already declined the quote.';
                        break;
                    }
                }
            }
        }

        //confirmation post.
        $this->data['_isAccepted'] = false;
        if(isset($_POST['confirm'])){
            unset($_POST['confirm']);
            $this->main_model->setLastId('JobID');
            $this->main_model->setOrder('JobID', 'ASC');
            $tempID = date('Y') . str_pad('00000', 5, 0, STR_PAD_LEFT);
            $getID = $this->main_model->getinfo('tbl_job_monthly');

            if($getID){
                $withoutStrPad = substr($getID, 4);
                $jobID = date("Y") . $withoutStrPad + 1;
            }
            else{
                $jobID = $tempID;
            }
            $equipment = array();
            if(count($clientData) > 0){
                foreach($clientData as $client){
                    if(count($client->Equipment) > 0){
                        foreach($client->Equipment as $equip){
                            $equipment[] = $equip->ID;
                        }
                    }else{
                        $this->data['_errorMessage'] = "You have no equipment registered";
                        break;
                    }
                }
            }
            $postData = array(
                'StatusID' => 3 //quote accepted
            );
            $postJobData = array(
                'JobID' => $jobID,
                'ClientID' => $clientID,
                'QuoteAccepted' => date('Y-m-d'),
                'Equipment' => json_encode($equipment)
            );
            $this->data['_isAccepted'] = true;
            $this->main_model->insert('tbl_job_monthly', $postJobData, false);
            $this->main_model->update('tbl_client', $postData, $clientID);
        }
        if(isset($_POST['decline'])){
            $postData = array(
                'StatusID' => 5 // job declined
            );
            $this->data['_isAccepted'] = false;
            $this->main_model->update('tbl_client', $postData, $clientID);
        }
        $this->data['_pageLoad'] = 'client/quoteVerify_view';
        $this->load->view('main_view', $this->data);
    }

    private function request_view()
    {
        $this->data['_pageTitle'] = 'List of Request';
        $statusData = $this->main_model->getinfo('tbl_client_equipment');
        if(count($statusData) > 0 )
        {
            $equipIDs = array();
            foreach($statusData as $status)
            {
                $equipIDs[] = $status->ID;
            }
        }

        $clientData = $this->ClientData('', '', $equipIDs, 'ID');
        $this->data['_pageLoad'] = 'request/request_view';
        $this->load->view('main_view', $this->data);
    }
}