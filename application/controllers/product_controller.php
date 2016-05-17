<?php

include('merit.php');

class Product_Controller extends Merit{

    function __construct(){
        parent::__construct();
        if($this->session->userdata('isLogged') == false){
            redirect('login');
        }
    }

    function itemList(){
        $this->data['_pageLoad'] = 'item/item_list_view';
        $this->main_model->setNormalized('unit_from','id');
        $this->main_model->setSelectFields(array('id','unit_from'));
        $unit = $this->main_model->getinfo('tbl_unit_conversion');
        $unit[''] = '-';

        ksort($unit);

        $this->main_model->setJoin(array(
            'table' => array('tbl_unit_conversion'),
            'join_field' => array('id'),
            'source_field' => array('tbl_items.unit_id'),
            'type' => 'left'
        ));
        $fld = ArrayWalk($this->main_model->getFields('tbl_items'),'tbl_items.');
        $fld[] = 'tbl_unit_conversion.unit_from';

        $this->main_model->setSelectFields($fld);
        $items_list = $this->main_model->getInfo('tbl_items');
        $this->data['items_list'] = json_encode($items_list);
        $this->data['unit'] = $unit;

        $this->load->view('main_view',$this->data);
    }

    function manageItem(){
        $option = $this->uri->segment(2);
        if(!$option){
            exit;
        }

        $this->main_model->setNormalized('unit_from','id');
        $this->main_model->setSelectFields(array('id','unit_from'));
        $unit_type = $this->main_model->getinfo('tbl_unit_conversion');
        $unit_type[''] = '-';

        $this->data['unit_type'] = $unit_type;

        switch($option){
            case 'add':
                $this->load->view('item/add_item_view',$this->data);
                break;
            case 'update':
                break;
            case 'delete':
                break;
            default:
                break;
        }
    }
}