<?php

class Controller_Logger extends CI_Controller{

    function tracking_change_logger($_post, $tbl, $id, $type = 2){
        $old = array();
        $hasDiff = 1;
        if($type != 1){
            $field = ArrayWalk($this->main_model->getFields('tbl_job_registration',array('id')), 'tbl_job_registration.');

            $option = array();
            if($tbl){
                $field = array_merge(ArrayWalk($this->main_model->getFields($tbl, array('id')), $tbl . '.'), $field);
                $option['table'][] = $tbl;
                $option['join_field'][] = 'job_id';
                $option['source_field'][] = 'tbl_job_registration.id';
            }

            if(count($option) > 0){
                $this->main_model->setJoin($option);
            }

            $field[] = 'IF(date_entered,date_entered,"") as date_entered';
            $field[] = 'IF(date_completed,date_completed,"") as date_completed';
            $field[] = 'IF(date_report_printed,date_report_printed,"") as date_report_printed';
            $field[] = 'IF(inspection_time,inspection_time,"") as inspection_time';
            $field[] = 'IF(date_due,date_due,"") as date_due';

            $this->main_model->setSelectFields($field, false);
            $this->main_model->setShift();
            $old = $this->main_model->getInfo('tbl_job_registration', $id, 'tbl_job_registration.id');

            /*if($old['rate_matrix'] == 12){
                $this->main_model->setSelectFields('rate_matrix_id');
                $this->main_model->setNormalized('rate_matrix_id');
                $rate = $this->main_model->getInfo('tbl_job_registration_rate_matrix', $id, 'est_num');
                if(count($rate) > 0){
                    $old['rate_matrix'] = $rate;
                }
            }*/

            $hasDiff = count(array_diff((Array)$_post, (Array)$old)) > 0;
        }

        if($hasDiff){
            $post = array(
                'date' => date('Y-m-d H:i:s'),
                'change_type' => $type,
                'pc_name' => $this->getRealIpAddress(),
                'user_id' => $this->session->userdata('userID'),
                'job_id' => $id,
                'from' => json_encode($old),
                'to' => json_encode($_post),
            );
            $this->main_model->insert('tbl_job_tracking_changes_logger', $post, false);
        }
    }

    private function getRealIpAddress(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP']; // share internet
        }
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; // pass from proxy
        }
        else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return gethostbyaddr($ip);
    }
} 