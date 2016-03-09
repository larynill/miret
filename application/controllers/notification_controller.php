<?php
include('merit.php');

class Notification_Controller extends Merit{

    function __construct(){
        parent::__construct();

        if($this->session->userdata('isLogged') == false){
            redirect('login');
        }
    }

    function notificationCount(){
        $isMini = isset($_GET['isMini']) ? $_GET['isMini'] : 0;
        $this->data['isMini'] = $isMini;

        $count = array(
            'warning' => count($this->notificationGetData('warning')),
            'message' => count($this->notificationGetData('message')),
            'query' => count($this->notificationGetData('query'))
        );

        ini_set("memory_limit","1024M");
        set_time_limit(900000000000);
        header("Content-type: application/json");
        echo json_encode($count);
    }

    function notificationView(){
        $_pageLoad = 'notification/';

        $viewBy = isset($_GET['viewBy']) ? $_GET['viewBy'] : '';
        $isMini = isset($_GET['isMini']) ? $_GET['isMini'] : 0;
        $isPrint = isset($_GET['isPrint']) ? $_GET['isPrint'] : 0;
        $pageNumber = isset($_GET['per_page']) ? $_GET['per_page'] : 0;
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 50;
        $this->data['toPage'] = isset($_GET['toPage']) ? $_GET['toPage'] : '';
        $this->data['isMini'] = $isMini;

        $filter = array(
            'searchDefault' => isset($_POST['search']) ? $_POST['search'] : (isset($_GET['search']) ? $_GET['search'] : '')
        );
        $notification = $this->notificationGetData($viewBy, $pageNumber, $limit, $filter, true);

        $this->data['notification'] = $notification;
        $this->data['isNotificationPage'] = $isMini;

        $view = 'default_view';
        switch($viewBy){
            case 'warning':
                $view = 'warning_view';

                break;
            case 'message':
                $view = $isMini ? 'messages_mini_view' : 'messages_view';
                if(!$isMini){
                    $this->data['current_page'] = $pageNumber;

                    $thisUrl = base_url() . "notificationView?viewBy=" . $viewBy;
                    $thisUrl .= isset($_GET['toPage']) ? "&toPage=" . $_GET['toPage'] : "";

                    $this->data['mainLink'] = $thisUrl;

                    $thisUrl .= array_key_exists('searchDefault', $filter) ? ($filter['searchDefault'] ? '&search=' . $filter['searchDefault'] : '') : '';
                    $thisUrl .= array_key_exists('qsDefault', $filter) ? ($filter['qsDefault'] ? '&qsList=' . $filter['qsDefault'] : '') : '';

                    $config['base_url'] = $thisUrl;
                    $config['total_rows'] = count($this->notificationGetData($viewBy, 0, 0, $filter, true));
                    $config['per_page'] = $limit;
                    $config['enable_query_strings'] = TRUE;
                    $config['page_query_string'] = TRUE;
                    $config['num_links'] = 10;
                    $config['first_link'] = '<<';
                    $config['last_link'] = '>>';
                    $this->pagination->initialize($config);
                    $this->data['links'] = $this->pagination->create_links();

                    //region QS
                    $this->data['qsList'] = array('' => 'All QS');

                    $fields = array(
                        'tbl_user.id',
                        'CONCAT(tbl_user.FName, " ", tbl_user.FName) as name',
                        'tbl_user.isActive as is_active'
                    );

                    $this->main_model->setSelectFields($fields);
                    $qs = $this->main_model->getInfo('tbl_user');
                    if(count($qs) > 0){
                        foreach($qs as $v){
                            $isOk = true;
                            if(!$v->is_active){
                                $isOk = count($this->main_model->getInfo('tbl_notification', $v->id, 'author_id')) > 0;
                            }

                            if($isOk){
                                $this->data['qsList'][$v->id] = $v->name;
                            }
                        }
                    }
                    //endregion

                    $this->data['filterDefault'] = $filter;
                }

                break;
        }

        if($view){
            if($isMini){
                $this->load->view($_pageLoad . $view, $this->data);
            }
            else{
                if($isPrint){
                    $this->load->view($_pageLoad . 'messages_view_print', $this->data);
                }
                else{
                    $this->data['_pageLoad'] = $_pageLoad . $view;

                    $this->load->view('main_view', $this->data);
                }
            }
        }
    }

    function notificationHide(){

        $whatField = array("id");
        $whatVal= array($this->uri->segment(2));
        if(isset($_GET['hideAll'])){
            $whatField = array("receiver_id", 'is_system !=');
            $whatVal = array($this->session->userdata('userID'), 1);
        }

        $post = array(
            'is_new' => 0,
            'is_hide' => 1
        );
        $this->main_model->update('tbl_notification', $post, $whatVal, $whatField);
    }

    function notificationGetData($viewBy, $pageNumber = 0, $limit = 0, $filter = array(), $isView = false){
        $notification = array();

        //region get Warnings
        if($viewBy == 'warning'){
            $this->main_model->setSelectFields('id');
            $this->main_model->setNormalized('id');
            $hasNotification = $this->main_model->getInfo('tbl_routing');

        }
        //endregion
        //region get Message
        else if($viewBy == 'message'){
            $whatField = array('tbl_notification.receiver_id');
            $whatVal = array($this->session->userdata('userID'));

            //QA, SU or SA can see all of the New Messages
            if(in_array($this->data['accountType'], array(1, 2, 3))){
                if($this->data['isMini']){
                    $whatField[] = 'tbl_notification.is_hide !=';
                    $whatVal[] = 1;
                }
            }

            if($this->data['isMini']){
                $whatField[] = 'tbl_notification.is_new';
                $whatVal[] = 1;
            }

            //if QA only
            if(in_array($this->data['accountType'], array(11))){
                $whatField[] = '';
                $whatVal[] = '(tbl_notification.is_personal = 1 AND tbl_notification.receiver_id != ' . $this->session->userdata('userID') . ')';
            }

            if(isset($filter['searchDefault'])){
                if($filter['searchDefault']){
                    $filterSearch = array_filter(explode(" ", $filter['searchDefault']));
                    $thisVal = '(tbl_notification.notification LIKE "%' . implode('%" AND tbl_notification.notification LIKE "%', $filterSearch) . '%")';
                    $whatField[] = '';
                    $whatVal[] = $thisVal;
                }
            }

            if(isset($filter['qsDefault'])){
                if($filter['qsDefault']){
                    $whatField[] = 'tbl_notification.author_id';
                    $whatVal[] = $filter['qsDefault'];
                }
            }

            $field = ArrayWalk($this->main_model->getFields('tbl_notification'), 'tbl_notification.');
            $field[] = 'CONCAT(author.fname, " ", author.lname) AS author_name';
            $field[] = 'CONCAT(receiver.fname, " ", receiver.lname) AS receiver_name';

            $this->main_model->setSelectFields($field, false);
            $this->main_model->setJoin(array(
                'table' => array('tbl_user as author', 'tbl_user as receiver', 'tbl_job_registration'),
                'join_field' => array('id', 'id', 'id'),
                'source_field' => array('tbl_notification.author_id', 'tbl_notification.receiver_id', 'tbl_notification.job_id'),
                'join_append' => array('author', 'receiver', 'tbl_job_registration'),
                'type' => 'left'
            ));
            $this->main_model->setOrder('date', 'DESC');
            if($isView && $limit){
                $this->main_model->setConfig($limit, $pageNumber, true);
            }
            $notification = $this->main_model->getInfo('tbl_notification', $whatVal, $whatField);
        }
        //endregion
        //region get Query
        else if($viewBy == 'query'){

        }
        //endregion

        return $notification;
    }
}