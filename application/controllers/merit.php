<?php
include('notification_helper.php');
include('job_helper.php');
include('controller_logger.php');
include('send_email_controller.php');
include('items_to_action_controller.php');

class Merit extends CI_Controller{
    var $data;
    var $utility;
    //var $main_model;
    //var $encrypt;
    //var $session;


    function __construct()
    {
        parent::__construct();

        if($this->session->userdata('isLogged') === false){
            redirect('login');
        }
		//$this->firstReminderSend();
        $this->GetUserInfo();
        $this->Setting(); // the setting of the website.
        //$this->ClientFirstReminderSend('',date('Y-m-d', strtotime('+5 days')));
		header('Content-type: text/html; charset=utf-8');

        //region Prevent Back Button on browser
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        //endregion

		$this->main_model->setLastId('Value');
		$this->data['unitrate'] = $this->main_model->getinfo('tbl_rate',1,'ID');

		$this->main_model->setLastId('Value');
		$this->data['hourrate'] = $this->main_model->getinfo('tbl_rate',2,'ID');

		$this->main_model->setLastId('Value');
		$this->data['kmrate'] = $this->main_model->getinfo('tbl_rate',3,'ID');

		$this->data['IsView'] = true;
		//echo $this->uri->segment(1);

    }

    function index(){
        if($this->session->userdata('isLogged') == true){
            redirect('trackingLog');
        }
        else{
            redirect('login');
        }
    }

    function logout(){
        $this->session->set_userdata(array('isLogged' => false));
        $this->session->sess_destroy();

        redirect('');
    }

    function fileDownload(){
        $file_path = $this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5);
        $file_name = $this->uri->segment(6);
        $uploaddir = realpath(APPPATH . '..'); // change the path to fit your websites document structure
        $fullPath = $uploaddir.'/pdf/'.$file_path.'/'.$file_name;

        if ($fd = fopen ($fullPath, "r")) {

            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);
            //$ext = strtolower($path_parts["extension"]);

            header("Content-type: application/pdf");
            header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
            header("Content-length: $fsize");
            header("Cache-control: private");

            while(!feof($fd)) {
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        }

        fclose ($fd);
        exit;
    }

    function pageConstruction(){
        $this->load->view('pagecomponents/under_construction_view');
    }

    //restrict the page to any user except for the user being defined.
    function Restrictions($userID){
        $userData = $this->main_model->getinfo('tbl_user', $userID);
        if($this->session->userdata('isLogged') == false){
            redirect('login');
        }
        switch($this->session->userdata('userAccountType')){
            case 4: //inspector
                $exceptions = array(
                    'diary',
                    'registerClient',
                    'viewClient',
                    'clients'
                );
                if(in_array($this->uri->segment(1), $exceptions)){
                    redirect('dashboard');
                }
                break;
            case 1: //super admin
                $exceptions = array(
                    'dashboard'
                );

                if(in_array($this->uri->segment(1), $exceptions)){
                    redirect('trackingLog');
                }
                break;
        }
    }

    function GetUserInfo($userID = ''){
        $this->data['_userID']  = '';
        $this->data['_userData'] = array();

        if($this->session->userdata('isLogged')){
            $this->data['_userID'] = $this->session->userdata('userID');
			$this->main_model->setJoin(array(
				'table' => array('tbl_user_type'),
				'join_field' => array('ID'),
				'source_field' => array('tbl_user.AccountType'),
				'type' => 'left'
			));
            $fld = ArrayWalk($this->main_model->getFields('tbl_user'),'tbl_user.');
            $fld[] = 'tbl_user_type.AccountType as accountName';
			$this->main_model->setSelectFields($fld);

            $this->data['_userData'] = $this->main_model->getinfo('tbl_user', $this->data['_userID'],'tbl_user.ID');

			if(count($this->data['_userData'])>0){
				foreach($this->data['_userData'] as $k=>$v){
					$this->data['accountName'] = $v->FName.' '.$v->LName;
                    $this->data['accountType'] = $v->AccountType;
				}
			}

            $this->data['notification_dp'] = array(
                '1' => 'New',
                '2' => 'Active',
                '3' => 'Archived'
            );

            $this->data['notification'] = array();//$notification->getInvoiceNotification(1);
            $this->data['count_msg'] = count($this->data['notification']);

        }
		$this->data['time'] = array();

		for($i = 1;$i <=24 ;$i++){
			$ref = 0;
			$data = $i >= 13 ? $i - 12 : $i;
			$this->data['time'][] = $data;
		}
		$this->main_model->setLastId('title');
		$this->data['page_title'] = $this->main_model->getinfo('tbl_routing',$this->uri->segment(1),'link');

        $userData = $this->main_model->getinfo('tbl_user', $userID);
		//DisplayArray($this->data['time']);
        return $userData;
    }

    function GetUserJob($userID = ''){
        $availableJobs = array();
        $userData = $this->GetUserInfo($userID);
        $jobData = $this->main_model->getinfo('tbl_job_monthly');
        if(count($userData) > 0){
            foreach($userData as $user){
                if(count($jobData) > 0){
                    foreach($jobData as $job){
                        if($user->ID == $job->UserID){
                            $availableJobs[] = $job;
                        }
                    }
                }
            }
        }

        return $availableJobs;
    }

    //returns the monthly clients
    function GetMonthlyClient($value = '', $field='', $theMonth = ''){
        if(!$theMonth)
        {
            $theMonth = date('Y-m');
        }
        $monthlyClient = array();
        if(!$field)
        {
            $field = 'ID';
        }
        //$value = $value;
        $clientData = $this->ClientData($field, $value);

        if(count($clientData) > 0){
            foreach($clientData as $client){
				$client->Equipment = $this->main_model->getinfo('tbl_client_equipment',$client->ID,'ClientID');
				$monthlyEquip = array();
                if(count($client->Equipment) > 0){
                    foreach($client->Equipment as $equip)
                    {
                        $equipDateMonth = date("Y-m", strtotime($equip->InspectionDate));

                        if($equipDateMonth == $theMonth )
                        {
                            $monthlyEquip[] =  $equip;
                            if(!in_array($client, $monthlyClient))
                            {
                                $client->Equipment = $monthlyEquip;
                                $monthlyClient[] = $client;
                            }
                        }
                    }
                }
                $client->Equipment = $monthlyEquip;
            }
        }

        return $monthlyClient;
    }

    //returns the monthly equipment inspections
    function GetMonthlyInspection($value='', $field='', $theMonth = '')
    {
        if(!$theMonth){
            $theMonth = date('Y-m');
        }
        $monthlyEquip = array();
        $this->main_model->setJoin(
            array(
                'table' => 'tbl_client',
                'join_field' => 'ID',
                'source_field' => 'ClientID',
                'join_append' => '',
                'type' => ''
            )
        );
        $equipData = $this->main_model->getinfo('tbl_client_equipment', $value, $field);
        if(count($equipData) > 0){
            foreach($equipData as $equip){
                $equipDateMonth = date("Y-m", strtotime($equip->InspectionDate));

                if($equipDateMonth == $theMonth )
                {
                    $monthlyEquip[] =  $equip;
                }
            }
        }

        return $monthlyEquip;
    }

    function GetClientInfo($id = '', $equipment = ''){
        $clientData = array();
        $tbl_client = $this->main_model->getinfo('tbl_client', $id, 'ID');
        $tbl_equip = $this->main_model->getinfo('tbl_client_equipment', $equipment, 'ID');
        if(count($tbl_client) > 0){
            foreach($tbl_client as $client){
                if($client->StatusID != 6){ // client validation
                    if(count($tbl_equip) > 0){
                        foreach($tbl_equip as $equip){
                            if($client->ID == $equip->ClientID){
                                $client->Equipment[] = $equip ;
                            }
                        }
                    }
                    $clientData[] = $client;
                }
            }
        }
        return $clientData;
    }

    //returns the client data with their equipments
    function ClientData($field = '', $value = '', $equipValue="",$equipField="")
    {
        $clientData = array();

        $tbl_client = $this->main_model->getinfo('tbl_client', $value, $field);
        $tbl_equip = $this->main_model->getinfo('tbl_client_equipment', $equipValue, $equipField);
        if(count($tbl_client) > 0){
            foreach($tbl_client as $client){
                if(count($tbl_equip) > 0){
                    foreach($tbl_equip as $equip){
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

                            $equip->InspectionFrequency = $frequencyString; // get the equipment frequency
                            $client->Equipment[] = $equip ; // get the equipment
                        }
                    }
                }
                $clientData[] = $client;
            }
        }

        return $clientData;
    }

    function GetEquipmentInfo($equipID= ''){
        $equipData = $this->main_model->getinfo('tbl_client_equipment', $equipID);
        return $equipData;
    }

    function GetPostEqualField($post, $tablename){
        $tableFields = $this->main_model->getFields($tablename);
        $postKeys = array();
        foreach( $post as $postKey => $postVal){
            foreach($tableFields as $fields){
                if($fields == $postKey){
                    $postKeys[$fields] = $postVal;
                }
            }
        }
        return $postKeys;
    }

    protected function ClientFirstReminderSend($client = '', $datePrior = '')
    {

        $dateForQuatationSending = $datePrior;

        $this->main_model->setSelectFields(array('ID', 'FirstName','LastName', 'Email'));

        if($client != '')
        {
            $field = "ID";
            $value = $client;
            $clientData = $this->ClientData($field, $value);
        }
        else
        {
            $clientData = $this->ClientData();
        }
        //DisplayArray($clientData);
        if(count($clientData) > 0)
        {
            foreach($clientData as $client)
            {
                if(count($client->Equipment) > 0)
                {
                    foreach($client->Equipment as $equip)
                    {
                        $dateInspection = date('Y-m-d', strtotime($equip->InspectionDate));
                        if($dateForQuatationSending != '')
                        {
                            if($dateInspection <= $dateForQuatationSending)
                            {
                                $data['equipName'] = $equip->PlantDescription;
                                $data['equipInspectionDate'] = date('F d Y', strtotime($equip->InspectionDate));
                                $emailMessage = $this->load->view('emailMessages/reminder/first_reminder_view', $data,true);
                                //$this->sendmail($emailMessage, $client->Email);
                            }
                        }
                        else
                        {
                            if($dateInspection <= $dateForQuatationSending)
                            {

                            }
                            $data['equipName'] = $equip->PlantDescription;
                            $data['equipInspectionDate'] = date('F d Y', strtotime($equip->InspectionDate));
                            $emailMessage = $this->load->view('emailMessages/reminder/first_reminder_view', $data,true);

                            $this->sendmail($emailMessage, $client->Email);
                        }

                    }
                }
            }
        }
    }

    private function Setting(){
        //get page titles
        $routingDataTable = $this->main_model->getinfo('tbl_routing');
        foreach($routingDataTable as $route){
            if($route->link == $this->uri->segment(1)){
                $this->data['_pageTitle'] = $route->title;
            }
        }
    }

	public function ClientInfo($clientID = '',$forInvoice = false){
		$this->main_model->setJoin(array(
			'table' => array('tbl_area_designation'),
			'join_field' => array('ID'),
			'source_field' => array('tbl_client.AreaDesignationID'),
			'type' => 'left'
		));
		$getData = $this->main_model->getinfo('tbl_client',$clientID,'tbl_client.ID');
		//DisplayArray($getData);
		if(count($getData)>0){
			foreach($getData as $v){
				$postal = json_decode($v->PostalAdress);
				$postalAddress = (object)$postal;
                $work_phone = json_decode($v->WorkPhone);
                $tel = (object)$work_phone;

                $v->street = $postalAddress->street;
                $v->street_name = $postalAddress->street_name;
                $v->suburb = $postalAddress->suburb;
                $v->city_id = $postalAddress->city_id;
                $v->country_id = $postalAddress->country_id;
                $v->zip_code = $postalAddress->zip;
                $v->area_code = $tel->area_code;
                $v->number = $tel->number;
                $v->ext = $tel->ext;

				$this->main_model->setJoin(array(
					'table' => array('tbl_country'),
					'join_field' => array('id'),
					'source_field' => array('tbl_city.country_id'),
					'type' => 'left'
				));

				$this->main_model->setSelectFields(array(
					'tbl_city.id','tbl_city.Name as city','tbl_city.country_id','tbl_country.Name as country'
				));
				$city = $this->main_model->getinfo('tbl_city',$postalAddress->city_id,'tbl_city.id');
				$cityVal = '';
				if(count($city)>0){
					foreach($city as $city_val){
						$cityVal = $city_val->city.', '.$city_val->country;
					}
				}
                if(!$forInvoice){
                    $v->PostalAdress = $v->PostalAdress ? $postalAddress->street.' '.$postalAddress->street_name.' '.$postalAddress->suburb.
                        ', '.$cityVal: '';
                }else{
                    $v->PostalAdress = $v->PostalAdress ? $postalAddress->street.' '.$postalAddress->street_name.' '.$postalAddress->suburb.
                        ', <br/>'.$cityVal: '';
                }

				$v->ContactPerson = $v->FirstName && $v->LastName ? $v->FirstName.' '.$v->LastName : '';
			}
		}
		//DisplayArray($getData);
		return $getData;

	}

    function sendmail($message,
                      $to = 'dummymailthedraftingzone@gmail.com',
                      $from = 'tony@pressurevessel.com',
                      $cc = '',
                      $name = 'Tony Program',
                      $subject = 'Notification from the Tony Program',
                      $url = '')
    {
        //$to = 'noreply@thedraftingzone.net'
        //NOTE:
        /*
        If using XAMPP as your localhost things to do:
            In php.ini file
            1. smtp = 'ssl://stmp.googlemail.com'
            2. smtp_port= '465'
            3. enable/add extension=php_openssl.dll (the most import that thing to send email via localhost)
        */

        //compatible with justhost.com or sitehost
        //$config['protocol'] = 'mail';
        /*$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';*/

        //localhost or godaddy.com
        $config['protocol'] = 'smtp';
        $config['smtp_port'] = 465;
        $config['mailtype'] = 'html';

        $config['smtp_host'] = 'ssl://smtp.googlemail.com';
        //$config['smtp_host'] = 'ssl://onlineenglishcampus.com';
        //$config['smtp_user'] = 'admin@onlineenglishcampus.com';
        //$config['smtp_pass'] = 'apple1';

        $config['smtp_user'] = 'dummymailthedraftingzone@gmail.com';
        $config['smtp_pass'] = 'dummypassword';

        //$config['smtp_user'] = 'mail.sender.ioec@gmail.com';
        //$config['smtp_pass'] = 'internationalonlineenglishcampus';

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->initialize($config);

        $this->email->clear(TRUE);

        $this->email->from($from,$name);
        $this->email->to($to);
        $this->email->cc($cc);
        $this->email->bcc('');

        $this->email->subject($subject);
        $this->email->message($message);

        if($url){
            if(is_dir($url)){
                if ($prints = opendir($url)) {
                    while (false !== ($est = readdir($prints))) {
                        if($est !== "." && $est !== ".."){
                            $this->email->attach($url.$est);
                        }
                    }
                }
            }

            if(is_file($url)){
                $this->email->attach($url);
            }
        }

        $this->email->send();
        //echo $this->email->print_debugger();
    }

	function arrayWalk($array, $append, $type = 'front', $as = ''){
		$ar = array();
		if(count($array)>0){
			foreach($array as $k=>$v){
				switch($type){
					case 'back':
						$ar[$k] = $v . $append;
						break;
					case 'as':
						$ar[$k] = $append . $v . ' as ' . $as . $v;
						break;
					default:
						$ar[$k] = $append . $v;
				}
			}
		}

		return $ar;
	}

	function arrayHtmlEncode($data, $isObject = true) {
		if (is_array($data)) {
			return array_map(array($this,'arrayHtmlEncode'), $data);
		}

		if (is_object($data)) {
			$tmp = clone $data; // avoid modifying original object
			foreach ($data as $k => $var){
				$tmp->{$k} = $this->arrayHtmlEncode($var, $isObject);
			}

			$tmp = $isObject ? $tmp : (array)$tmp;

			return $tmp;
		}

		return htmlentities($data, ENT_QUOTES, "UTF-8");
	}

	function arrayHtmlDecode($data, $isObject = true) {
		if (is_array($data)) {
			return array_map(array($this,'arrayHtmlDecode'), $data);
		}

		if (is_object($data)) {
			$tmp = clone $data; // avoid modifying original object
			foreach ( $data as $k => $var ){
				$tmp->{$k} = $this->arrayHtmlDecode($var, $isObject);
			}

			$tmp = $isObject ? $tmp : (array)$tmp;

			return $tmp;
		}

		return html_entity_decode($data, ENT_QUOTES, "UTF-8");
	}

	function arraySort (&$array, $key, $isAsc = true){
		$sorter = array();
		$ret = array();
		reset($array);
		foreach ($array as $ii=>$va) {
			$sorter[$ii] = $va->$key;
		}

		if($isAsc){
			uasort($sorter, array($this,'arraySortCompareAsc'));
			//asort($sorter);
		}else{
			uasort($sorter, array($this,'arraySortCompareDesc'));
			//arsort($sorter);
		}

		foreach ($sorter as $ii=>$va) {
			$ret[] = $array[$ii];
		}

		$array = $ret;
	}

	function arraySortCompareAsc($a, $b){
		return $a == $b ? 0 : ($a < $b ? -1 : 1);
	}

	function arraySortCompareDesc($a, $b){
		return $a == $b ? 0 : ($a > $b ? -1 : 1);
	}

	function getWednesdays($y, $m)
	{
		return new DatePeriod(
			new DateTime("first sunday of $y-$m"),
			DateInterval::createFromDateString('next sunday'),
			new DateTime("last day of $y-$m")
		);
	}

    function sendEmail($job_id,$franchise_id,$date,$msg,$send = true){
        $has_pay_setup = $this->my_model->getInfo('tbl_contacts',$franchise_id);

        $debugResult = array();

        if(count($has_pay_setup) > 0){
            foreach($has_pay_setup as $pay_setup){
                $date = date('Y-m-d',strtotime($date));

                $this->my_model->setShift();
                $whatVal = array($job_id,$date);
                $whatFld = array('client_id','date');
                $pdf_file = (Object)$this->my_model->getInfo('tbl_pdf_archive',$whatVal,$whatFld);

                $cc = array(
                    $pay_setup->take_off_agent_email,
                    $pay_setup->staff_email
                );
                $cc_alias = array(
                    $pay_setup->take_off_agent_name,
                    $pay_setup->staff_name
                );
                $dir = realpath(APPPATH.'../pdf');;
                $url = $dir.'/inspection_report/'.$job_id.'/'.$pdf_file->file_name;

                $date_ = new DateTime($date);
                $week = $date_->format('W');
                $sendMailSetting = array(
                    'to' => $pay_setup->accountant_email,
                    'to_alias' => $pay_setup->accountant_name,
                    'cc' => $cc,
                    'cc_alias' => $cc_alias,
                    'from' => 'no-reply@subbiesolutions.co.nz',
                    'name' => 'Synergy Administrator',
                    'subject' => 'Pay Period Summary Report for Week ' . $week . ' from ' . date('j F Y',strtotime($date)) .' to '.date('j F Y',strtotime('+6 days '.$date)),
                    'url' => $url,
                    'file_names' => $pdf_file->file_name,
                    'debug_type' => 2,
                    'debug' => true
                );

                if($send){
                    $email_send = new Send_Email_Controller();
                    $debugResult['result'] = $email_send->sendingEmail(
                        $msg,
                        $sendMailSetting
                    );
                }else{
                    $debugResult['result'] = (Object)array(
                        'type' => 2,
                        'debug' => 'Email needs to be review before sending'
                    );
                }
                $debugResult['is_send'] = $send;
                $debugResult['mail_settings'] = $sendMailSetting;
            }
        }

        return $debugResult;
    }
}