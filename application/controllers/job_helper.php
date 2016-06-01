<?php

class Job_Helper extends CI_Controller{

    function jobDetails($job_id = '',$inspector_id = '',$group_by = false){
        $this->main_model->setJoin(array(
            'table' => array(
                'tbl_user as account_manager','tbl_user as inspector',
                'tbl_job_type_specs as status','tbl_job_type_specs as job_type',
                'tbl_job_type_specs as property_status','tbl_job_inspection',
                'tbl_site_inspection_report'
            ),
            'join_field' => array(
                'id','id','id','id','id','job_id','job_id'
            ),
            'source_field' => array(
                'tbl_job_registration.account_manager_id','tbl_job_registration.inspector_id',
                'tbl_job_registration.job_status_id','tbl_job_registration.job_type_id',
                'tbl_job_registration.property_status_id','tbl_job_registration.id',
                'tbl_job_registration.id'
            ),
            'join_append' => array(
                'account_manager','inspector','status','job_type','property_status','tbl_job_inspection',
                'tbl_site_inspection_report'
            ),
            'type' => 'left'
        ));
        $inspection = ArrayWalk($this->main_model->getFields('tbl_job_inspection',array('job_id','id')),'tbl_job_inspection.');
        $registration = ArrayWalk($this->main_model->getFields('tbl_job_registration'),'tbl_job_registration.');
        $site_inspection = ArrayWalk($this->main_model->getFields('tbl_site_inspection_report',array('job_id','id')),'tbl_site_inspection_report.');

        $fld = array_merge($inspection,$registration,$site_inspection);
        $fld[] = 'LPAD(tbl_job_registration.id,5,0) as job_ref';
        $fld[] = 'IF(date_entered,DATE_FORMAT(date_entered,"%d/%m/%y"),"") as date_entered';
        $fld[] = 'IF(date_completed,DATE_FORMAT(date_completed,"%d/%m/%y"),"") as date_completed';
        $fld[] = 'IF(date_report_printed,DATE_FORMAT(date_report_printed,"%d/%m/%y"),"") as date_report_printed';
        $fld[] = 'IF(inspection_time,DATE_FORMAT(inspection_time,"%d/%m/%y %h:%i %p"),"") as inspection_time';
        $fld[] = 'IF(date_due,DATE_FORMAT(date_due,"%d/%m/%y"),"") as date_due';
        $fld[] = 'CONCAT(account_manager.FName," ",account_manager.LName) as account_manager_name';
        $fld[] = 'CONCAT(inspector.FName," ",inspector.LName) as inspector_name';
        $fld[] = 'IF(inspector.Tel != "-" OR inspector.Tel != "",inspector.Mobile,inspector.Tel) as inspector_contact';
        $fld[] = 'status.job_type_specs as job_status';
        $fld[] = 'status.job_type_code as job_status_code';
        $fld[] = 'job_type.job_type_specs as job_type';
        $fld[] = 'job_type.job_type_code as job_type_code';
        $fld[] = 'property_status.job_type_specs as property_status';

        $this->main_model->setSelectFields($fld);
        if($group_by){
            $this->main_model->setGroupBy('tbl_job_registration.id');
        }

        $whatVal = '';
        $whatFld = '';
        if($inspector_id){
            $whatVal = $inspector_id;
            $whatFld = 'tbl_job_registration.inspector_id';
        }
        if($job_id){
            $whatVal = $job_id;
            $whatFld = 'tbl_job_registration.id';
        }
        $job = $this->main_model->getinfo('tbl_job_registration',$whatVal,$whatFld);

        $this->main_model->setNormalized('job_type_specs','id');
        $this->main_model->setSelectFields(array('id','job_type_specs'));
        $job_type_specs = $this->main_model->getInfo('tbl_job_type_specs');

        $excluded_fld = array('id','job_id','roof_pitch','roof_age','client_discussions','damage_sighted','repair_strategy','overview','report_conclusion');
        $inspection_fld = $this->main_model->getFields('tbl_job_inspection',$excluded_fld);

        if(count($job) > 0){
            foreach($job as $k=>$v){
                $v->conclusion_[] = $v->conclusion ? json_decode($v->conclusion) : '';
                $v->notes_[] = $v->notes ? json_decode($v->notes) : '';
                $v->job_address = $v->address;
                $v->job_address .= $v->suburb ? ', ' . $v->suburb : '';
                $v->job_address .= $v->city ? ', ' . $v->city : '';
                $v->job_address .= $v->zip_code ? ' ' . $v->zip_code : '';

                $this->main_model->setOrder(array('date_time'),'DESC');
                $_fld = ArrayWalk($this->main_model->getFields('tbl_job_history'),'tbl_job_history.');
                $_fld[] = 'IF(date_time,DATE_FORMAT(date_time,"%d/%m/%y %H:%i %p"),"") as date_time';
                $this->main_model->setSelectFields($_fld);
                $notes = $this->main_model->getinfo('tbl_job_history',$v->id,'job_id');
                $v->notes = $notes;
                foreach($inspection_fld as $_field){
                    $_str = str_replace('_id','',$_field);
                    $v->$_str = array_key_exists($v->$_field,$job_type_specs) ? $job_type_specs[$v->$_field] : '';
                }

                $this->merit_model->setJoin([
                    'table' => ['tbl_items','tbl_unit_conversion'],
                    'join_field' => ['id','id'],
                    'source_field' => ['tbl_job_estimate.item_id','tbl_items.unit_id'],
                    'type' => 'left'
                ]);
                $_fld = ArrayWalk($this->main_model->getFields('tbl_job_estimate'),'tbl_job_estimate.');
                $_fld[] = 'tbl_items.item_name';
                $_fld[] = 'tbl_items.item_code';
                $_fld[] = 'tbl_items.report_text';
                $_fld[] = 'tbl_items.default_rate';
                $_fld[] = 'tbl_unit_conversion.unit_from';
                $this->merit_model->setSelectFields($_fld);
                $v->estimate = $this->merit_model->getInfo('tbl_job_estimate',$v->id,'job_id');

                $v->photos = $this->merit_model->getInfo('tbl_job_photos',$v->id,'job_id');
            }
        }
        return $job;
    }

    function setJobNotification($job_id,$msg){

        $this->main_model->setShift();
        $_fld = ArrayWalk($this->main_model->getFields('tbl_job_registration',array('id')),'tbl_job_registration.');

        $this->main_model->setSelectFields($_fld);
        $job_data = (Object)$this->main_model->getInfo('tbl_job_registration',$job_id);

        $job_num = str_pad($job_id,5,'0',STR_PAD_LEFT);
        $title = 'Job <strong>' . $job_num . '  ' . $job_data->project_name . '</strong> ' . $msg . '.';
        $notification = '<strong>Job:</strong> <a href="' . base_url() . 'jobRegistration?id=' . $job_id . '">' .
        $job_num . '</a>  ' . $job_data->project_name . ' ' . $msg .'<strong>';

        $n = new Notification_Helper();
        $n->createNotificationHelper($job_id, $this->session->userdata('userID'), $title, $notification);
    }
}