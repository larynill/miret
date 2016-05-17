<?php
include('merit.php');

class Postal_Code_Controller extends Merit{

    function __construct(){
        parent::__construct();
        if($this->session->userdata('isLogged') == false){
            redirect('login');
        }
    }

    function postalCodes(){
        $selection = $this->session->userdata('selection') ? $this->session->userdata('selection') : array();
        $this->merit_model->setNormalized('name','id');
        $this->merit_model->setSelectFields(array(
            'id',
            'name'
        ));
        $this->data['franchise'] = $this->merit_model->getInfo('tbl_franchise');
        $this->data['franchise'][''] = 'All Franchise';
        ksort($this->data['franchise']);

        $this->data['selection'] = $selection;
        $this->data['_pageLoad'] = 'postal_code/postal_code_view';
        $this->load->view('main_view',$this->data);
    }

    function postalCodesJson(){
        if(isset($_GET['submit'])){
            ini_set('max_execution_time', 0);
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $franchise = isset($_GET['franchise']) ? $_GET['franchise'] : '';
            $road_name = isset($_GET['road_name']) ? $_GET['road_name'] : '';
            $suburb = isset($_GET['suburb']) ? $_GET['suburb'] : '';
            $town_city = isset($_GET['town_city']) ? $_GET['town_city'] : '';
            $postcode = isset($_GET['postcode']) ? $_GET['postcode'] : '';

            $whatVal = $franchise ? 'tbl_postal_codes.franchise_id =' . $franchise  : '';

            $whatVal .= $search && $franchise ? ' AND ' : '';
            if($search){
                $search_list = explode(' ',$search);
                $whatVal .= $road_name
                            || $suburb
                            || $town_city
                            || $postcode ? '(' : '';
                $ref = 1;
                if(count($search_list) > 0){
                    foreach($search_list  as $val){
                        $whatVal .= $ref > 1 ? '' : '(';
                        if($road_name){
                            $whatVal .= $ref > 1 ? ' AND (' : '';
                            $whatVal .= 'tbl_postal_codes.road_name LIKE "%' . $val . '%"';
                        }
                        if($suburb){
                            $whatVal .= $road_name ? ' OR ' : '';
                            $whatVal .= 'tbl_postal_codes.suburb LIKE "%' . $val . '%"';
                        }
                        if($town_city){
                            $whatVal .= $road_name || $suburb ? ' OR ' : '';
                            $whatVal .= 'tbl_postal_codes.town_city LIKE "%' . $val . '%"';
                        }
                        if($postcode){
                            $whatVal .= $road_name || $suburb || $town_city ? ' OR ' : '';
                            $whatVal .= 'tbl_postal_codes.postcode LIKE "%' . $val . '%"';
                        }
                        $whatVal .= $ref > 1 ? ')' : ')';
                        $ref++;
                    }
                }

                $whatVal .= $road_name
                || $suburb
                || $town_city
                || $postcode ? ')' : '';

            }
            $this->merit_model->setOrder('road_name','ASC');
            $this->merit_model->setJoin(array(
                'table' => array('tbl_franchise'),
                'join_field' => array('id'),
                'source_field' => array('tbl_postal_codes.franchise_id'),
                'type' => 'left'
            ));
            $fld = ArrayWalk($this->merit_model->getFields('tbl_postal_codes'),'tbl_postal_codes.');
            $fld[] = 'tbl_franchise.name as franchise';
            $this->merit_model->setSelectFields($fld);
            $this->data['postal_codes'] = $this->merit_model->getInfo('tbl_postal_codes',$whatVal,'');
            if(isset($_GET['export'])){

            }
            else{
                $this->data['save_path'] = realpath(APPPATH.'../pdf/postcode/');
                $this->load->view('postal_code/print_postal_code_view',$this->data);
            }
        }else if(isset($_GET['json'])){
            $fld = ArrayWalk($this->merit_model->getFields('tbl_postal_codes'),'tbl_postal_codes.');
            $fld[] = 'IF(franchise_id IS NOT NULL, franchise_id, 0) as franchise_id';
            $this->merit_model->setSelectFields($fld);
            $postal_codes = $this->merit_model->getInfo('tbl_postal_codes');

            echo json_encode($postal_codes);
        }
        else if(isset($_GET['postal_id'])){
            $postal_id = $_GET['postal_id'];
            $post = array(
                'franchise_id' => $_GET['franchise_id']
            );
            $this->merit_model->update('tbl_postal_codes',$post,$postal_id);
            echo 'success';
        }
        else if(isset($_GET['new'])){
            $this->merit_model->setNormalized('name','id');
            $this->merit_model->setSelectFields(array(
                'id',
                'name'
            ));
            $this->data['franchise'] = $this->merit_model->getInfo('tbl_franchise');
            $this->data['franchise'][''] = 'All Franchise';
            ksort($this->data['franchise']);

            if(isset($_POST['submit'])){
                unset($_POST['submit']);
                $this->merit_model->insert('tbl_postal_codes',$_POST,false);
                redirect('postalCodes');
            }

            $this->load->view('postal_code/manage_postal_code_view',$this->data);
        }
        else if(isset($_GET['delete'])){
            $postal_id = $_POST['postal_id'];
            $this->merit_model->delete('tbl_postal_codes',$postal_id);
            echo 'success';
        }
        else if($this->uri->segment(2)){
            $this->merit_model->setNormalized('name','id');
            $this->merit_model->setSelectFields(array(
                'id',
                'name'
            ));
            $this->data['franchise'] = $this->merit_model->getInfo('tbl_franchise');
            $this->data['franchise'][''] = 'All Franchise';
            ksort($this->data['franchise']);
            $uri = $this->uri->segment(2);

            if(isset($_POST['submit'])){
                unset($_POST['submit']);
                $this->merit_model->update('tbl_postal_codes',$_POST,$uri,'id',false);
                redirect('postalCodes');
            }
            $this->merit_model->setShift();
            $this->data['postal_code'] = (Object)$this->merit_model->getInfo('tbl_postal_codes',$uri);
            $this->load->view('postal_code/manage_postal_code_view',$this->data);
        }
    }

    function addPostalCode($_file_name){
        ini_set('max_execution_time', 0);
        $this->load->library('excel_reader');
        error_reporting(E_ALL ^ E_NOTICE);
        $uploadDir = realpath(APPPATH.'../excel');
        $file = fopen($uploadDir . '/' . $_file_name, 'r');
        $header = array('Road Name','No. Range','Suburb','Town/City','Postcode');
        $fields = $this->merit_model->getFields('tbl_postal_codes',array('id'));
        while (($line = fgetcsv($file)) !== FALSE) {
            //$line is an array of the csv elements
            $ref = 1;
            $temp = array();
            foreach($line as $key=>$value){
                if(!in_array($value,$header)){
                    $temp[$fields[$ref]] = $value;
                    $ref++;
                }
            }
            if(count($temp) > 0){
                $whatVal = array(
                    $temp['road_name'],
                    $temp['num_range'],
                    $temp['suburb'],
                    $temp['town_city'],
                    $temp['postcode']
                );
                $whatFld = array(
                    'road_name','num_range','suburb','town_city','postcode'
                );
                $has_exist = $this->merit_model->getInfo('tbl_postal_codes',$whatVal,$whatFld);

                if(count($has_exist) > 0){
                    foreach($has_exist as $row){
                        $this->merit_model->update('tbl_postal_codes',$temp,$row->id);
                    }
                }else{
                    $this->merit_model->insert('tbl_postal_codes',$temp,false);
                }
            }
        }
        fclose($file);
    }

    function postCheckboxSession(){
        if(isset($_POST['submit'])){
            unset($_POST['submit']);
            $this->session->set_userdata(array('selection' => $_POST));
            echo 'success';
        }
    }
}