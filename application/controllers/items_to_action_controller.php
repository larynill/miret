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

        $_job_data = $this->merit_model->getInfo('tbl_job_registration',$whatVal,$whatFld);

        if(count($_job_data) > 0){
            foreach($_job_data as $val){
                $str = '<strong>#' . str_pad($val->id,5,'0',STR_PAD_LEFT) . ':</strong> ' . $val->project_name;
                $datetime_str = '0000-00-00 00:00:00';
                if(!$val->inspector_id){
                    $str .= ' assign an Inspector.';
                    $data[] = $str;
                }
                else if($val->inspection_time == $datetime_str){
                    $str .= ' Inspection Date to organize.';
                    $data[] = $str;
                }
                else if(date('Y-m-d',strtotime($val->inspection_time)) > date('Y-m-d')){
                    $str .= ' Inspection Visit set at ' . date('l d/m/Y g:i A',strtotime($val->inspection_time));
                    $data[] = $str;
                }
                else if(date('Y-m-d',strtotime($val->inspection_time)) == date('Y-m-d')){
                    $str .= ' Inspection set today at ' . date('g:i A',strtotime($val->inspection_time));
                    $data[] = $str;
                }
                else if(date('Y-m-d',strtotime($val->inspection_time)) < date('Y-m-d')){
                    $str .= ' Inspection Report to be created';
                    $data[] = $str;
                }
            }
        }
        return $data;
    }

}