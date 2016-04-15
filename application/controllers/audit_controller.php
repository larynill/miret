<?php

include('merit.php');
class Audit_Controller extends Merit{

    function __construct(){
        parent::__construct();
        if($this->session->userdata('isLogged') == false){
            redirect('login');
        }
    }

    //region Change Log Area
    function jobAuditLog(){
        if($this->session->userdata('isLogged') != true){
            redirect('');
        }

        //$this->data['_pageLoad'] = 'audit/job_audit_log_view';
        $this->data['_pageLoad'] = 'audit/job_changes_log';

        if(isset($_POST['submit'])){
            if(count($_POST['email']) > 0){
                foreach($_POST['email'] as $k=>$v){
                    $post = array(
                        'email' => $v,
                        'alias' => $_POST['alias'][$k],
                        'franchise_id' => isset($_POST['franchise_' . $k]) ? json_encode($_POST['franchise_' . $k]) : ""
                    );
                    $this->main_model->insert('tbl_job_tracking_changes_logger_email', $post, false);
                }
            }

            if(count($_POST['id_edit']) > 0){
                foreach($_POST['id_edit'] as $k=>$v){
                    $post = array(
                        'email' => $_POST['email_edit'][$k],
                        'alias' => $_POST['alias_edit'][$k],
                        'franchise_id' => isset($_POST['franchise_edit_' . $k]) ? json_encode($_POST['franchise_edit_' . $k]) : ""
                    );
                    $this->main_model->update('tbl_job_tracking_changes_logger_email', $post, $v, 'id', false);
                }
            }

            redirect('jobChangeLog');
        }

        if(isset($_POST['del'])){
            $id = isset($_POST['id']) ? $_POST['id'] : '';
            if($id){
                $this->main_model->delete('tbl_job_tracking_changes_logger_email', $id);
                echo 1;
            }
            exit;
        }

        $this->jobChangeLogGet('');

        $this->load->view('main_view', $this->data);
    }

    function jobChangeLogCron(){
        $this->main_model->setSelectFields('id');
        $this->main_model->setNormalized('id');
        $allFIds = $this->main_model->getInfo('tbl_franchise');

        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $emails = $this->main_model->getInfo('tbl_job_tracking_changes_logger_email', $id, 'id');
        if(count($emails) > 0){
            foreach($emails as $v){
                $fIds = $allFIds;
                $thisFId = $v->franchise_id ? json_decode($v->franchise_id) : array();
                if(count($thisFId) > 0){
                    $this->main_model->setSelectFields('id');
                    $this->main_model->setNormalized('id');
                    $fIds = $this->main_model->getInfo('tbl_franchise', $thisFId, 'group_by');
                }
                $this->jobChangeLogGet($fIds, 1);
                if(count($this->data['logs']) > 0) {
                    ksort($this->data['logs']);
                    $this->data['fMultiple'] = count($fIds) > 1;
                    $msg = $this->load->view('parttwo/jobs/log/job_changes_log_email', $this->data, TRUE);
                    $sendMailSetting = array(
                        'to' => $v->email,
                        'to_alias' => $v->alias,
                        'from' => 'noreply@theestimator.co.nz',
                        'subject' => 'EOTL Daily Job Log - ' . (isset($_GET['date']) ? date('d/m/Y', strtotime($_GET['date'])) : date('d/m/Y')),
                        'debug_type' => 2,
                        'debug' => true
                    );
                    $debugResult = $this->sendmail(
                        $msg,
                        $sendMailSetting
                    );
                    DisplayArray($debugResult);
                }
            }
        }
    }

    private function jobChangeLogGet($fId, $isPdf = 0){
        $email_log = $this->main_model->getInfo('tbl_job_tracking_changes_logger_email');
        $this->data['email_log'] = $email_log;

        //region Get Info List

        //region get QS list
        $this->main_model->setSelectFields(array('tbl_user.id', 'CONCAT(tbl_user.FName, " ", tbl_user.LName) as name'));
        $this->main_model->setNormalized('name', 'id');
        $this->main_model->setJoin(array(
            'table' => array('tbl_user_type'),
            'join_field' => array('id'),
            'source_field' => array('tbl_user.AccountType'),
            'type' => 'left'
        ));
        $user = $this->main_model->getInfo('tbl_user');
        //endregion
        //region Get Job Type Specs Info
        $this->main_model->setSelectFields(array('id', 'job_type_specs'));
        $this->main_model->setNormalized('job_type_specs', 'id');
        $job_type_specs = $this->main_model->getInfo('tbl_job_type_specs');
        //endregion

        /*$whatField = array('tbl_merchant_franchise.franchise_id');
        $whatVal = array($fId);
        $this->main_model->setSelectFields(array('tbl_branch.id', 'CONCAT(tbl_merchant.mname, " ", tbl_branch.bname) as name'));
        $this->main_model->setNormalized('name', 'id');
        $this->main_model->setJoin(array(
            'table' => array('tbl_branch_merchant_franchise', 'tbl_merchant_franchise', 'tbl_merchant'),
            'join_field' => array('branch_id', 'id', 'id'),
            'source_field' => array('tbl_branch.id', 'tbl_branch_merchant_franchise.merchant_franchise_id', 'tbl_merchant_franchise.merchant_id'),
            'type' => 'left',
        ));
        $branches = $this->main_model->getInfo('tbl_branch', $whatVal, $whatField);

        $this->main_model->setSelectFields(array('id', 'name'));
        $this->main_model->setNormalized('name', 'id');
        $rate_matrix = $this->main_model->getInfo('tbl_rate_matrix');
        $this->main_model->setSelectFields(array('id', 'name'));
        $this->main_model->setNormalized('name', 'id');
        $building_type = $this->main_model->getInfo('tbl_building_type');*/

        $this->main_model->setSelectFields(array('id', 'initial'));
        $this->main_model->setNormalized('initial', 'id');
        $update_type = $this->main_model->getInfo('tbl_system_audit_update_type');
        $this->data['update_type'] = array('' => 'Type');
        $this->data['update_type'] += $update_type;

        /*$this->main_model->setSelectFields(array('id', 'tbl_franchise.franchise_code as name'));
        $this->main_model->setGroupBy('group_by');
        $this->main_model->setOrder('tbl_franchise.franchise_code', 'ASC');
        $this->main_model->setNormalized('name', 'id');
        $franchise = $this->main_model->getInfo('tbl_franchise');
        $this->data['franchise'] = array('' => 'Franchise');
        $this->data['franchise'] += $franchise;
        $this->data['fDp'] = $franchise;*/
        //endregion

        $this->main_model->setSelectFields(array('field', 'title'));
        $this->main_model->setNormalized('title', 'field');
        $log_fields = $this->main_model->getInfo('tbl_job_tracking_changes_logger_fields');

        //region Get Log Info
        $whatField = '';
        $whatVal = '';
        /*if($isPdf){
            $whatField[] = 'DATE_FORMAT(tbl_job_tracking_changes_logger.date, "%Y-%m-%d") =';
            $whatVal[] = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        }*/

        $fields = array(
            'tbl_job_tracking_changes_logger.id',
            'tbl_job_tracking_changes_logger.date',
            'DATE_FORMAT(tbl_job_tracking_changes_logger.date, "%e/%c/%Y") as date_only',
            'DATE_FORMAT(tbl_job_tracking_changes_logger.date, "%H:%i") as time',
            'CONCAT(tbl_user.FName, " ", tbl_user.LName) as name',
            'tbl_user.alias',
            'tbl_system_audit_update_type.initial as type',
            'tbl_job_tracking_changes_logger.change_type',
            'tbl_job_tracking_changes_logger.from',
            'tbl_job_tracking_changes_logger.to',
            'tbl_job_tracking_changes_logger.job_id',
            /*'tbl_franchise.group_by as fId',
            'tbl_franchise.franchise_code as fCode'*/
        );

        $this->main_model->setSelectFields($fields);
        if($isPdf){
            //$this->main_model->setOrder(array('tbl_franchise.franchise_code', 'tbl_job_tracking_changes_logger.date'), array('ASC', 'ASC'));
        }
        else{
            $this->main_model->setOrder(array('UNIX_TIMESTAMP(tbl_job_tracking_changes_logger.date)'), array('DESC'));
        }
        $this->main_model->setJoin(array(
            'table' => array(
                'tbl_job_registration',
                'tbl_system_audit_update_type',
                'tbl_user',
                'tbl_job_transfer'
            ),
            'join_field' => array('id', 'id', 'id', 'job_id'),
            'source_field' => array(
                'tbl_job_tracking_changes_logger.job_id',
                'tbl_job_tracking_changes_logger.change_type',
                'tbl_job_tracking_changes_logger.user_id',
                'tbl_job_registration.id'
            ),
            'type' => 'left',
        ));
        $logs = $this->main_model->getInfo('tbl_job_tracking_changes_logger', $whatVal, $whatField);
        $l = array();
        $p = array();
        if(count($logs) > 0){
            foreach($logs as $k=>$v){
                $v->changes = array();
                if($v->change_type == 1){
                    $to = json_decode($v->to);
                    $v->job_num = str_pad($v->job_id,5,'0',STR_PAD_LEFT);
                    $v->ref = @$to->client_ref ? @$to->client_ref : '';
                    $v->client = @$to->owner ? @$to->owner : '';
                    $v->job_name = @$to->project_name ? @$to->project_name : '';

                    if(count($to) > 0){
                        foreach($to as $field=>$value){
                            $arr = array('job_status_id','job_type_id','property_status_id');
                            if(!$value){
                                continue;
                            }

                            if($field == "user_id"){
                                $v->changes[] = "<strong>Inspector:</strong> " . $user[$value] . "<br />";;
                            }
                            if($field == "inspector_id"){
                                $v->changes[] = "<strong>Create Note:</strong> " . $user[$value] . "<br />";;
                            }
                            else if($field == "account_manager_id"){
                                $v->changes[] = "<strong>Account Manager:</strong> " . $user[$value] . "<br />";;
                            }
                            else if(array_key_exists($field, $log_fields)){
                                $v->changes[] = "<strong>" . $log_fields[$field] . ":</strong> ";
                                $v->changes[] .= (in_array($field,$arr) ? $job_type_specs[$value] : ($field == 'owner_is_present' ? ($value == 1 ? 'YES' : 'NO') : $value)) . "<br />";
                            }
                        }
                    }
                }
                else if($v->change_type == 2){
                    $from = json_decode($v->from);
                    $to = json_decode($v->to);

                    $v->job_num = str_pad($v->job_id,5,'0',STR_PAD_LEFT);
                    $v->ref = @$to->client_ref ? @$to->client_ref : @$from->client_ref;
                    $v->client = @$to->owner ? @$to->owner : @$from->owner;
                    $v->job_name = @$to->project_name ? @$to->project_name : @$from->project_name;

                    $diff = array_diff_assoc((Array)$to, (Array)$from);

                    $diff = count($diff) == 0 ? (Array)$to : $diff;
                    if(count($diff) > 0){
                        foreach($diff as $field=>$value){
                            if(!$value){
                                continue;
                            }

                            if($field == "inspector_id"){
                                $v->changes[] = "<strong>Inspector:</strong> => " . @$user[$from->$field] . "  =>  " . @$user[$value] . "<br />";
                            }
                            else if($field == "account_manager_id"){
                                $v->changes[] = "<strong>Account Manager:</strong> => " . @$user[$from->$field] . "  =>  " . @$user[$value] . "<br />";
                            }
                            else if(array_key_exists($field, $log_fields)){
                                $v->changes[] = "<strong>" . @$log_fields[$field] . ":</strong> => " . @$from->$field . "  =>  " . $value . "<br />";
                            }
                        }
                    }
                }

                if(count($v->changes) == 0){
                    continue;
                }

                $p[$v->change_type][$v->job_id][] = $v;
                $l[] = $v;
            }
        }

        $this->data['logs'] = $isPdf ? $p : json_encode($l);
        //endregion
    }

    private function arrayDiff($array1, $array2){
        $from = (Array)$array2;
        $to = (Array)$array1;

        $diff = array();
        $intersection = array_intersect_key($to, $from);
        if(count($intersection) > 0){
            foreach($intersection as $k=>$v){
                if(array_key_exists($k, $from)){
                    if($from[$k] != $v){
                        $diff[$k] = $v;
                    }
                }
            }
        }

        return $diff;
    }
    //endregion
}