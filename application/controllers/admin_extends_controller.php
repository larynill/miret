<?php

include('admin_controller.php');

class Admin_Extends_Controller extends Admin_Controller{

    function __construct(){
        parent::__construct();
    }

    function contactList(){
        $id = $this->uri->segment(2) ? $this->uri->segment(2) : '';

        $this->merit_model->setNormalized('contact_name','id');
        $this->merit_model->setSelectFields(array('id','contact_name'));
        $this->data['agent'] = $this->merit_model->getInfo('tbl_contacts',1,'is_branch !=');
        $this->data['agent'][''] = 'Select Agent';

        ksort($this->data['agent']);

        $this->merit_model->setNormalized('name','id');
        $this->merit_model->setSelectFields(array('id','name'));
        $this->data['franchise'] = $this->merit_model->getInfo('tbl_franchise');

        ksort($this->data['franchise']);

        $this->merit_model->setNormalized('branch','id');
        $this->merit_model->setSelectFields(array('id','branch'));
        $this->data['branch'] = $this->merit_model->getInfo('tbl_contact_branch');
        $this->data['branch'][''] = 'Select Branch';

        ksort($this->data['branch']);

        $this->merit_model->setNormalized('branch_name','branch_name');
        $this->merit_model->setSelectFields(array('id','branch_name'));

        $whatVal = isset($_GET['agent_id']) && $_GET['agent_id'] != 0 ? $_GET['agent_id'] : $id;
        $whatFld = 'agent_id';

        $this->data['agent_branch'] = $this->merit_model->getInfo('tbl_contacts',$whatVal,$whatFld);
        $this->data['agent_branch'][''] = 'Select Branch';
        ksort($this->data['agent_branch']);

        $this->merit_model->setNormalized('city','id');
        $this->merit_model->setSelectFields(array('id','city'));
        $this->data['location'] = $this->merit_model->getInfo('tbl_city_',2,'country_id');

        ksort($this->data['location']);

        if(isset($_POST['submit'])){
            unset($_POST['submit']);
            $_POST['location'] = json_encode($_POST['location']);
            $_POST['take_off_agent_cc'] = json_encode($_POST['take_off_agent_cc']);
            if(!$_POST['is_branch']){
                unset($_POST['branch_name']);
                unset($_POST['branch_code']);
                unset($_POST['agent_id']);
            }
            if($id){
                $this->merit_model->update('tbl_contacts',$_POST,$id,'id',false);
            }
            else{
                $_POST['added_by'] = $this->session->userdata('userID');
                $_POST['date_added'] = date('Y-m-d H:i:s');
                $this->merit_model->insert('tbl_contacts',$_POST,false);
            }
            redirect('contactList');
        }

        if(isset($_GET['a']) && $_GET['a'] == 1){
            $contact = array();

            if($id){
                $this->merit_model->setShift();
                $contact = (Object)$this->merit_model->getInfo('tbl_contacts',$id);
            }
            $this->data['contact_list'] = $contact;
            $this->load->view('contact/add_contact_view',$this->data);
        }
        else if(isset($_POST['agent_id'])){
            $agent_id = $_POST['agent_id'];
            $this->merit_model->setNormalized('branch_name','id');
            $this->merit_model->setSelectFields(array('id','branch_name'));
            $branch = $this->merit_model->getInfo('tbl_contacts',$agent_id,'agent_id');
            echo json_encode($branch);
        }
        else{
            $this->merit_model->setJoin(array(
                'table' => array(
                    'tbl_user',
                    'tbl_contact_branch',
                    'tbl_contacts as agent',
                    'tbl_franchise'
                ),
                'join_field' => array('id','id','id','id'),
                'source_field' => array(
                    'tbl_contacts.added_by',
                    'tbl_contacts.branch_id',
                    'tbl_contacts.agent_id',
                    'tbl_contacts.franchise_id'
                ),
                'type' => 'left',
                'join_append' => array(
                    'tbl_user',
                    'tbl_contact_branch',
                    'agent',
                    'tbl_franchise'
                )
            ));
            $fld = ArrayWalk($this->merit_model->getFields('tbl_contacts'),'tbl_contacts.');
            $fld[] = 'CONCAT(tbl_user.FName," ",tbl_user.LName) as added_by';
            $fld[] = 'DATE_FORMAT(tbl_contacts.date_added,"%d-%m-%Y %H:%i %p") as date_added';
            $fld[] = 'tbl_franchise.name as franchise_name';
            $fld[] = 'IF(tbl_contacts.is_branch, agent.contact_name, "") as agent';
            $fld[] = 'IF(tbl_contacts.is_branch, tbl_contacts.agent_id, 0) as agent_id';
            $fld[] = 'tbl_contact_branch.branch';
            $fld[] = 'IF(tbl_contacts.is_branch, tbl_contacts.branch_name, tbl_contacts.contact_name) as name';
            $fld[] = 'IF(tbl_contacts.is_branch, tbl_contacts.branch_code, tbl_contacts.contact_code) as code';

            $this->merit_model->setSelectFields($fld);
            $contacts = $this->merit_model->getInfo('tbl_contacts');
            $this->data['franchise'][''] = 'Select Franchise';
            ksort($this->data['franchise']);
            $contact_info = $this->merit_model->getInfo('tbl_contact_info');
            $this->data['contacts'] = json_encode($contacts);
            $this->data['contact_info'] = json_encode($contact_info);
            $this->data['_pageLoad'] = 'contact/contact_list_view';
            $this->load->view('main_view',$this->data);
        }
    }

    function franchiseList(){
        $id = $this->uri->segment(2) ? $this->uri->segment(2) : '';

        if(isset($_POST['submit'])){
            unset($_POST['submit']);
            if($id){
                $_POST['is_archive'] = $_POST['is_archive'] ? 1 : 0;
                $this->merit_model->update('tbl_franchise',$_POST,$id,'id',false);
            }
            else{
                $_POST['added_by'] = $this->session->userdata('userID');
                $_POST['date_added'] = date('Y-m-d H:i:s');
                $this->merit_model->insert('tbl_franchise',$_POST,false);
            }
            redirect('franchiseList');
        }

        if(isset($_GET['a']) && $_GET['a'] == 1){
            $franchise_list = array();

            if($id){
                $this->merit_model->setShift();
                $franchise_list = (Object)$this->merit_model->getInfo('tbl_franchise',$id);
            }

            $this->data['franchise_list'] = $franchise_list;
            $this->load->view('franchise/add_franchise_view',$this->data);
        }
        else{
            $this->merit_model->setJoin(array(
                'table' => array(
                    'tbl_user'
                ),
                'join_field' => array('id'),
                'source_field' => array(
                    'tbl_franchise.added_by'
                ),
                'type' => 'left'
            ));
            $fld = ArrayWalk($this->merit_model->getFields('tbl_franchise'),'tbl_franchise.');
            $fld[] = 'CONCAT(tbl_user.FName," ",tbl_user.LName) as added_by';
            $fld[] = 'DATE_FORMAT(tbl_franchise.date_added,"%d-%m-%Y %H:%i %p") as date_added';

            $this->merit_model->setSelectFields($fld);
            $franchise = $this->merit_model->getInfo('tbl_franchise');

            $franchise_info = $this->merit_model->getInfo('tbl_franchise_info');
            $this->data['franchise'] = json_encode($franchise);
            $this->data['franchise_info'] = json_encode($franchise_info);
            $this->data['_pageLoad'] = 'franchise/franchise_list_view';
            $this->load->view('main_view',$this->data);
        }
    }

    function emailLog(){

        $this->data['_pageLoad'] = 'emailMessages/log/export_email_log';

        $fields = ArrayWalk($this->my_model->getFields('tbl_email_log', array('date', 'debug')), 'tbl_email_log.');
        $fields[] = 'DATE_FORMAT(tbl_email_log.date, "%Y%m%d %H%i") as date';
        $fields[] = 'IF(tbl_email_log.type = 1, "Success", IF(tbl_email_log.type = 2, "Review",
                        IF(tbl_email_log.type = 3,"Cancel","Failed"))) as status';
        $fields[] = 'CONCAT(tbl_user.FName," ",tbl_user.LName) as user';
        $fields[] = 'tbl_pdf_archive.file_name';
        $fields[] = 'tbl_pdf_archive.date as pay_period_date';
        $fields[] = 'tbl_job_registration.project_name as client_name';
        $fields[] = 'tbl_email_type.email_type';

        $this->my_model->setSelectFields($fields, false);
        $this->my_model->setJoin(array(
            'table' => array(
                'tbl_user','tbl_pdf_archive','tbl_job_registration','tbl_email_type'
            ),
            'join_field' => array(
                'id','id','id','id'
            ),
            'source_field' => array(
                'tbl_email_log.user_id',
                'tbl_email_log.report_id',
                'tbl_email_log.client_id',
                'tbl_email_log.email_type_id'
            ),
            'type' => 'left'
        ));
        $this->my_model->setOrder(array('tbl_email_log.date','tbl_email_log.email_type_id'), 'DESC');
        $log = $this->my_model->getInfo('tbl_email_log');
        if(count($log) > 0){
            foreach($log as $v){
                $file_name = explode(' ',$v->file_name);
                $v->message = json_decode($v->message);
                if($v->type){
                    if(array_key_exists('file_names',$v->message)){
                        $file_names = $v->message->file_names;
                        if(is_array($file_names)){
                            if(count($file_names) > 0){
                                foreach($file_names as $file){
                                    $dir               = realpath(APPPATH . '../pdf');
                                    $pdf_path = $v->email_type_id == 1 ? 'pay period' : 'payslip';
                                    $path              = $pdf_path . '/' . date('Y/F', strtotime($v->pay_period));
                                    $full_path = $dir . '/' . $path . '/' . $file->file_name;
                                    $file->has_attachment = file_exists($full_path) && $file->file_name ? 'Yes' : 'No';
                                    $v->link = file_exists($full_path) && $file->file_name ? base_url($pdf_path . date('Y/F', strtotime($v->pay_period)).'/'.$file->file_name) : '';
                                }
                            }
                        }else{
                            $dir               = realpath(APPPATH . '../pdf');
                            $pdf_path = $v->email_type_id == 1 ? 'pay period' : 'payslip';
                            $path              = $pdf_path . '/' . date('Y/F', strtotime($v->pay_period));
                            $full_path = $dir . '/' . $path . '/' . $file_names;
                            $v->has_attachment = file_exists($full_path) && $file_names ? 'Yes' : 'No';
                            $v->link = file_exists($full_path) && $file_names ? base_url('pdf/' . $pdf_path . '/' . date('Y/F', strtotime($v->pay_period)).'/'.$file_names) : '';
                        }
                    }
                }
                $v->export_setting = $v->export_setting ? json_decode($v->export_setting) : '[]';
                $v->job = $v->email_type_id ?  'Week ' . $v->week_number . '-' . date('Y',strtotime($v->date)): $file_name[0];

            }
        }
        $this->my_model->setNormalized('email_type','id');
        $this->my_model->setSelectFields(array('id','email_type'));
        $this->data['email_type'] = $this->my_model->getInfo('tbl_email_type');
        $this->data['email_type'][''] = 'All';
        ksort($this->data['email_type']);
        $this->data['log'] = json_encode($log);
        $this->load->view('main_view',$this->data);
    }

    function resendEmailLog(){
        if (isset($_POST['send'])) {

            $email_log = $this->my_model->getInfo('tbl_email_log',$_POST['id']);
            if(count($email_log) > 0){
                foreach($email_log as $data){

                    if(!$data->client_id) {
                        $msg = 'Good day. <br/>Here is the attach file for Inspection Report.';

                        $result = array();

                        $post = array(
                            'user_id' => $this->session->userdata('user_id'),
                            'message' => json_encode($result['mail_settings']),
                            'email_type_id' => $result['is_send'] ? 1 : 8,
                            'type' => $result['result']->type,
                            'debug' => $result['result']->debug,
                            'date' => date('Y-m-d H:i:s')
                        );

                        $this->my_model->update('tbl_email_log', $post, $data->id, 'id', false);

                    }
                    redirect('emailLog');
                }
            }
        }
        if(isset($_POST['cancel'])){
            $this->my_model->update('tbl_email_log',array('type'=>3),$_POST['id']);
        }
    }

    function leads(){

        $action = $this->uri->segment(2);

        if(isset($_POST['submitLead'])){
            unset($_POST['submitLead']);
            $_POST['user_id'] = $this->session->userdata('user_id');
            $this->my_model->insert('tbl_leads',$_POST);
            redirect('leads');
        }

        if($action == 'add_lead'){

            $this->my_model->setNormalized('leads_status','id');
            $this->my_model->setSelectFields(array('id','leads_status'));
            $this->data['leads_status'] = $this->my_model->getInfo('tbl_leads_status');

            $this->my_model->setNormalized('Name','id');
            $this->my_model->setSelectFields(array('id','Name'));
            $this->data['country'] = $this->my_model->getInfo('tbl_country');

            $this->load->view('leads/add_leads_view',$this->data);
        } else {

            $this->my_model->setJoin(
                array(
                    'table' => array('tbl_country','tbl_leads_status'),
                    'join_field' => array('id','id'),
                    'source_field' => array('tbl_leads.country','tbl_leads.status_id'),
                    'type' => 'left'
                )
            );
            $fields = $this->arrayWalk(
                array('id','first_name','last_name','title','phone','email','city','state_province')
                ,'tbl_leads.'
            );
            $fields[] = 'tbl_country.Name as country_name';
            $fields[] = 'tbl_leads_status.leads_status';
            $this->my_model->setSelectFields($fields);
            $this->data['leads'] = $this->my_model->getInfo('tbl_leads',$this->session->userdata('user_id'),'tbl_leads.user_id');

            $this->data['_pageLoad'] = 'leads/leads_view';
            $this->load->view('main_view',$this->data);
        }
    }

    function postalCodes(){
        $this->data['_pageLoad'] = 'postal_code/postal_code_view';
        $this->load->view('main_view',$this->data);
    }
}