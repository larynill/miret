<?php

class Items_To_Action_Controller extends CI_Controller{

    public $all_items = true;
    public $whatVal;
    public $whatFld;

    function getItems(){
        $data = array();
        $whatVal = '';
        $whatFld = '';

        if(!$this->all_items){
            if($this->whatVal && $this->whatFld){
                $whatVal = $this->whatVal;
                $whatFld = $this->whatVal;
            }
        }

<<<<<<< HEAD
=======
        $this->main_model->setJoin(array(
            'table' => array('tbl_user'),
            'join_field' => array('id'),
            'source_field' => array('tbl_job_registration.inspector_id'),
            'type' => 'left'
        ));
        $this->main_model->setSelectFields('tbl_job_registration.*','CONCAT(tbl_user.FName, " ", tbl_user.LName) as name');
>>>>>>> bc5a9c34235720fb38564f8e2f90d6a0ee326246
        $_job_data = $this->merit_model->getInfo('tbl_job_registration',$whatVal,$whatFld);

        if(count($_job_data) > 0){
            foreach($_job_data as $val){
<<<<<<< HEAD
                $str = '<strong>#' . str_pad($val->id,5,'0',STR_PAD_LEFT) . ':</strong> ' . $val->project_name;
                $datetime_str = '0000-00-00 00:00:00';
                if(!$val->inspector_id){
                    $str .= ' assign an Inspector.';
                    $data[] = $str;
                }
                else if($val->inspection_time == $datetime_str){
                    $str .= ' Inspection Date to organize.';
=======
                $str = '<strong>#' . str_pad($val->id,5,'0',STR_PAD_LEFT) . ':</strong> <u>' . $val->project_name .':</u>';
                $datetime_str = '0000-00-00 00:00:00';

                $this->merit_model->setShift();
                $report = (Object)$this->merit_model->getInfo('tbl_site_inspection_report',$val->id,'job_id');
                if(!$val->inspector_id){
                    $str .= ' waiting to be assigned to Inspector.';
                    $data[] = $str;
                }
                else if($val->inspection_time == $datetime_str){
                    $str .= ' waiting for Inspection Date to organize.';
>>>>>>> bc5a9c34235720fb38564f8e2f90d6a0ee326246
                    $data[] = $str;
                }
                else if(date('Y-m-d',strtotime($val->inspection_time)) > date('Y-m-d')){
                    $str .= ' Inspection Visit set at ' . date('l d/m/Y g:i A',strtotime($val->inspection_time));
                    $data[] = $str;
                }
                else if(date('Y-m-d',strtotime($val->inspection_time)) == date('Y-m-d')){
<<<<<<< HEAD
                    $str .= ' Inspection set today at ' . date('g:i A',strtotime($val->inspection_time));
                    $data[] = $str;
                }
                else if(date('Y-m-d',strtotime($val->inspection_time)) < date('Y-m-d')){
                    $str .= ' Inspection Report to be created';
=======
                    $str .= ' Inspection set today at ' . date('g:i A',strtotime($val->inspection_time)) . ' with ' . $val->name;
                    $data[] = $str;
                }
                else if(!array_key_exists('job_id',$report) && date('Y-m-d',strtotime($val->inspection_time)) < date('Y-m-d')){
                    $str .= " inspection completed and waiting for Inspection notes & photo's to be logged";
                    $data[] = $str;
                }
                else if(array_key_exists('job_id',$report) && !$report->is_generated && date('Y-m-d',strtotime($val->inspection_time)) < date('Y-m-d')){
                    $str .= " waiting for report to be generated";
                    $data[] = $str;
                }
                else if(array_key_exists('is_generated',$report) && $report->is_generated && !$report->is_sent){
                    $str .= " inspection report generated waiting for checking";
                    $data[] = $str;
                }
                else if(array_key_exists('is_sent',$report) && $report->is_generated && $report->is_sent){
                    $str .= " inspection report sent and waiting for invoice to be generated";
>>>>>>> bc5a9c34235720fb38564f8e2f90d6a0ee326246
                    $data[] = $str;
                }
            }
        }
        return $data;
    }

}