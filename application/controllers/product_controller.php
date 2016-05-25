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

        asort($unit);

        $this->main_model->setJoin(array(
            'table' => array('tbl_unit_conversion'),
            'join_field' => array('id'),
            'source_field' => array('tbl_items.unit_id'),
            'type' => 'left'
        ));
        $fld = ArrayWalk($this->main_model->getFields('tbl_items'),'tbl_items.');
        $fld[] = 'tbl_unit_conversion.unit_from';
        $fld[] = 'IF(tbl_items.auto_item, "Yes","") as auto_item_status';

        $this->main_model->setSelectFields($fld);
        $this->main_model->setOrder('item_code','asc');
        $items_list = $this->main_model->getInfo('tbl_items');

        $this->data['items_list'] = json_encode($items_list);
        $this->data['unit'] = $unit;

        $this->load->view('main_view',$this->data);
    }

    function itemsJson(){
        header('Content-Type: application/json');
        $query = isset($_POST['q']) ? $_POST['q'] : '';
        $search_column = isset($_GET['s']) ? $_GET['s'] : '';

        $this->main_model->setJoin(array(
            'table' => array('tbl_unit_conversion'),
            'join_field' => array('id'),
            'source_field' => array('tbl_items.unit_id'),
            'type' => 'left'
        ));
        $fld = ArrayWalk($this->main_model->getFields('tbl_items'),'tbl_items.');
        $fld[] = 'tbl_unit_conversion.unit_from';
        $fld[] = $search_column == 'item_code' ? 'tbl_items.item_code as value' : 'tbl_items.item_name as value';
        $fld[] = $search_column == 'item_code' ? 'tbl_items.item_code as label' : 'tbl_items.item_name as label';
        $fld[] = 'IF(tbl_items.auto_item, "Yes","") as auto_item_status';

        $this->main_model->setSelectFields($fld);
        $items_list = $this->main_model->getInfo('tbl_items',$query,$search_column);

        echo json_encode($items_list);
    }

    function manageItem(){
        $option = $this->uri->segment(2);
        $id = $this->uri->segment(3);

        $this->main_model->setNormalized('unit_from','id');
        $this->main_model->setSelectFields(array('id','unit_from'));
        $unit_type = $this->main_model->getinfo('tbl_unit_conversion');
        $unit_type[''] = '-';

        asort($unit_type);

        $this->data['unit_type'] = $unit_type;

        if(isset($_GET['tag'])){
            $this->main_model->setNormalized('description','text');
            $this->main_model->setSelectFields(array('description',"REPLACE(text,'\"',\"'\") as text"));
            $this->data['tags'] = $this->main_model->getInfo('tbl_tags');
            $this->data['tags'][''] = '-';
            ksort($this->data['tags']);
            $this->load->view('item/add_tag_view',$this->data);
        } else{
            switch($option){
                case 'add':
                    $this->load->view('item/add_item_view',$this->data);
                    break;
                case 'edit':
                    $this->merit_model->setShift();
                    $this->data['items'] = (object)$this->merit_model->getInfo('tbl_items',$id);
                    $this->load->view('item/add_item_view',$this->data);
                    break;
                case 'delete':
                    $this->merit_model->delete('tbl_items',$id);
                    break;
                default:
                    break;
            }
        }

        if(isset($_POST['submit'])){
            unset($_POST['submit']);
            $_POST['auto_item'] = isset($_POST['auto_item']) ? $_POST['auto_item'] : 0;
            if($id){
                $this->merit_model->update('tbl_items',$_POST,$id);
            }
            else{
                $this->merit_model->insert('tbl_items',$_POST,false);
            }

            redirect('itemList');

        }
    }
}