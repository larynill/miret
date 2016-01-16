<?php
class Test_Controller extends CI_Controller{

    function index(){
        echo'asdasd';
    }

    function test(){
        $insertData = array(
            'equipment_id' => 2,
            'client_id' => 2,
            'status_id' => 8 //set to Inspection Reminder Sent
        );
        $this->main_model->insert('tbl_status_equipment', $insertData);

    }
}