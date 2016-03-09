<?php

include('merit.php');
class User_Controller extends Merit{

    function userList(){

        $this->main_model->setNormalized('AccountType','ID');
        $this->main_model->setSelectFields(array('ID','AccountType'));
        $this->data['account_type'] = $this->main_model->getInfo('tbl_user_type');
        $this->data['account_type'][''] = 'All Account Type';

        ksort($this->data['account_type']);

        $this->data['status'][''] = 'Show All';
        $this->data['status']['1'] = 'Active';
        $this->data['status']['0'] = 'InActive';

        ksort($this->data['status']);

        $this->main_model->setSelectFields(
            array(
                'tbl_user.ID as id',
                'CONCAT(tbl_user.FName," ",tbl_user.LName) as name',
                'tbl_user.Username as username',
                'tbl_user.EmailAddress as email',
                'IF(tbl_user.DateRegistered != "0000-00-00",DATE_FORMAT(tbl_user.DateRegistered,"%d-%m-%Y"),"") as date_registered',
                'IF(tbl_user.isActive, "Yes", "No") as active',
                'tbl_user.isActive as is_active',
                'tbl_user.AccountType as account_type_id',
                'tbl_user.Alias as alias',
                'tbl_user_type.AccountType as account_type'
            )
        );
        $this->main_model->setJoin(array(
            'table' => array('tbl_user_type'),
            'join_field' => array('ID'),
            'source_field' => array('tbl_user.AccountType'),
            'type' => 'left'
        ));

        $users = $this->main_model->getInfo('tbl_user');
        
        $this->data['users'] = json_encode($users);
        
        $this->data['_pageLoad'] = 'user/user_management_view';
        $this->load->view('main_view',$this->data);
    }

    function manageUser(){

        $page = $this->uri->segment(2);

        if(!$page){
            exit;
        }

        $this->main_model->setNormalized('AccountType','ID');
        $this->main_model->setSelectFields(array('ID','AccountType'));
        $this->data['account_type'] = $this->main_model->getInfo('tbl_user_type');

        ksort($this->data['account_type']);

        switch($page){
            case 'add':
                if(isset($_POST['submit'])){
                    unset($_POST['submit']);

                    $_POST['DateRegistered'] = date('Y-m-d');
                    $_POST['Password'] = $this->encrypt->encode($_POST['Password']);

                    $this->main_model->insert('tbl_user',$_POST);

                    redirect('userList');
                }

                $this->load->view('user/add_user_view',$this->data);
                break;
            case 'edit':
                $id = $this->uri->segment(3);

                if(!$id){
                    exit;
                }

                $this->data['user'] = $this->main_model->getInfo('tbl_user',$id);
                $this->load->view('user/edit_user_view',$this->data);
                if(isset($_POST['submit'])){
                    unset($_POST['submit']);
                    $_POST['isActive'] = isset($_POST['isActive']) ? $_POST['isActive'] : 0;
                    $_POST['isCanAddJob'] = isset($_POST['isCanAddJob']) ? $_POST['isCanAddJob'] : 0;
                    $_POST['Password'] = $this->encrypt->encode($_POST['Password']);

                    $this->main_model->update('tbl_user',$_POST,$id);
                    redirect('userList');
                }
                break;
            case 'delete':
                $id = $this->uri->segment(3);

                if(!$id){
                    exit;
                }

                if(isset($_POST['submit'])){
                    unset($_POST['submit']);
                    $this->main_model->delete('tbl_user',$id);

                    redirect('userList');
                }
                $this->load->view('user/delete_user_view',$this->data);
                break;
            default:
                break;
        }
    }
}