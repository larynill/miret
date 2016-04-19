<?php
include('merit.php');

class On_Site_Controller extends Merit{

    function onSiteVisit(){
        $site = $this->db->site;
        $this->data['id'] = isset($_GET['job_id']) ? $_GET['job_id'] : '';
        $this->data['menu_id'] = isset($_GET['menu_id']) ? $_GET['menu_id'] : '';
        $this->data['room_id'] = isset($_GET['room_id']) ? $_GET['room_id'] : '';

        $this->merit_model->setOrder('order','ASC');
        $menu = $this->merit_model->getInfo($site . '.tbl_menu');
        $m = array();
        if(count($menu) > 0){
            foreach($menu as $v){
                $m[$v->id] = $site . '.tbl_' . strtolower($v->menu);
            }
        }
        $this->data['menu'] = $menu;

        $this->merit_model->setOrder('order','ASC');
        $f = $this->merit_model->getInfo($site . '.tbl_field');
        $fields = array();
        $fName = array();
        if(count($f) > 0){
            foreach($f as $v){
                $fields[$v->menu_id][] = $v;
                if($v->option_id) {
                    $fName[$v->menu_id][] = $v->field_name;
                }
                if($v->field_dynamic && !$v->per_option){
                    $field_dynamic = json_decode($v->field_dynamic);
                    if(count($field_dynamic) > 0){
                        foreach($field_dynamic as $key=>$val){
                            $fn = $v->field_name . $key;
                            $fName[$v->menu_id][] = $fn;
                        }
                    }
                }
            }
        }
        $this->data['fields'] = $fields;
        $id = '';
        if(isset($_POST['submit'])){
            unset($_POST['submit']);

            $job_detail_post = $_POST['job_details'];
            $post = array(
                'date_receive' => date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $job_detail_post['date_receive']))),
                'job_name' => isset($job_detail_post['job_name']) ? $job_detail_post['job_name'] : '',
                'job_id' => isset($job_detail_post['job_id']) ? $job_detail_post['job_id'] : '',
                'ref' => $job_detail_post['ref'],
                'instruction_received' => isset($job_detail_post['instruction_received']) ? $job_detail_post['instruction_received'] : '',

                'property_owner' => $job_detail_post['property_owner'],
                'lot_number' => $job_detail_post['lot_number'],
                'dp_number' => $job_detail_post['dp_number'],
                'property_unit' => $job_detail_post['property_unit'],
                'property_street_number' => $job_detail_post['property_street_number'],
                'property_street_name' => $job_detail_post['property_street_name'],
                'property_suburb' => $job_detail_post['property_suburb'],
                'property_city' => $job_detail_post['property_city'],
                'property_postal' => $job_detail_post['property_postal'],
                'property_phone_area' => isset($job_detail_post['property_phone_area']) ? $job_detail_post['property_phone_area'] : '',
                'property_phone_number' => $job_detail_post['property_phone_number'],
                'property_mobile' => $job_detail_post['property_mobile'],
                'property_email' => $job_detail_post['property_email'],
                'property_status' => isset($job_detail_post['property_status']) ? $job_detail_post['property_status'] : '',
                'property_status_other' => isset($job_detail_post['property_status_other']) ? $job_detail_post['property_status_other'] : '',
                'pets' => $job_detail_post['pets'],
                'electricity' => $job_detail_post['electricity'],
                'water' => $job_detail_post['water'],
                'details_property' => nl2br($job_detail_post['details_property']),
                'property_orientation' => $job_detail_post['property_orientation'],

                'occupier_name' => $job_detail_post['occupier_name'],
                'occupier_phone_area' => isset($job_detail_post['occupier_phone_area']) ? $job_detail_post['occupier_phone_area'] : '',
                'occupier_phone_number' => $job_detail_post['occupier_phone_number'],
                'occupier_mobile' => $job_detail_post['occupier_mobile'],
                'occupier_email' => $job_detail_post['occupier_email'],

                'assigned_to' => $job_detail_post['assigned_to'],
                'inspection_date' => date('Y-m-d H:i:s', strtotime(str_replace("/", "-", $job_detail_post['inspection_date']))),
                'provide_copies_to' => $job_detail_post['provide_copies_to'],
                'inspection_range' => $_POST['inspection_range'],
                'type_inspection' => isset($job_detail_post['type_inspection']) ? $job_detail_post['type_inspection'] : '',
                'purpose_inspection' => nl2br($job_detail_post['purpose_inspection'])
            );
            $id = $this->merit_model->insert($site . '.tbl_job_detail',$post,false);

            foreach($_POST['data'] as $key=>$data){
                $tbl = $m[$key];
                $noneExistingFields = $fName[$key];
                foreach($data as $k=>$d){
                    if(!is_array($d)){
                        $data[$k] = $d == 'null' ? NULL : $d;
                    }

                    if(!in_array($key, array(2)) && in_array($k, $noneExistingFields)){
                        $thisKey = array_search($k, $noneExistingFields);
                        unset($noneExistingFields[$thisKey]);
                    }
                }

                if(in_array($key, array(2))){
                    if(isset($_POST['room_id'])){
                        foreach($_POST['room_id'] as $room_id){
                            if(array_key_exists($room_id, $data)){
                                $noneExistingFields = $fName[$key];

                                $it_exist = $this->merit_model->getInfo($tbl,array($id,$room_id),array('job_id','interior_room_id'));
                                foreach($data[$room_id] as $k=>$d){
                                    if(is_array($d)){
                                        $data[$room_id][$k] = json_encode(array_filter($d));
                                    }
                                    else{
                                        $data[$room_id][$k] = $d == 'null' ? NULL : $d;
                                    }
                                    if(in_array($k, $noneExistingFields)){
                                        $thisKey = array_search($k, $noneExistingFields);
                                        unset($noneExistingFields[$thisKey]);
                                    }
                                }

                                $post = $data[$room_id];
                                if(count($noneExistingFields) > 0){
                                    foreach($noneExistingFields as $fld){
                                        $post[$fld] = '';
                                    }
                                }
                                $post['job_id'] = $id;
                                $post['interior_room_id'] = $room_id;

                                if(count($it_exist) > 0){
                                    $this->merit_model->update($tbl,$post,array($id,$room_id),array('job_id','interior_room_id'),false);
                                }
                                else{
                                    $this->merit_model->insert($tbl,$post,false);
                                }
                            }
                        }
                        $this->merit_model->delete($tbl,array($id,$_POST['room_id']),array('job_id','interior_room_id NOT '));
                    }
                    else{
                        $this->merit_model->delete($tbl,$id,'job_id');
                    }
                }
                else{
                    $it_exist = $this->merit_model->getInfo($tbl,$id,'job_id');

                    $post = $data;
                    if(count($noneExistingFields) > 0){
                        foreach($noneExistingFields as $fld){
                            $post[$fld] = null;
                        }
                    }
                    if(count($post) > 0){
                        foreach($post as $postKey=>$postValue){
                            if(is_array($postValue)){
                                $post[$postKey] = json_encode(array_filter($postValue));
                            }
                        }
                    }

                    $post['job_id'] = $id;

                    if(count($it_exist) > 0){
                        $this->merit_model->update($tbl,$post,$id,'job_id',false);
                    }
                    else{
                        $this->merit_model->insert($tbl,$post,false);
                    }
                }
            }

            $post = array(
                'job_id' => $id,
                'time_start' => $_POST['time_start'],
                'time_end' => date('Y-m-d H:i:s')
            );
            $this->merit_model->insert($site . '.tbl_job_timer',$post,false);

            $n = new Job_Helper();
            $n->setJobNotification($job_detail_post['job_id'],'On site visit details added',false);

            redirect('onSiteVisit');
        }

        $fieldName = ArrayWalk($this->merit_model->getFields($site .'.tbl_option'), $site . '.tbl_option.');
        $fieldName[] = $site . '.tbl_option_type.input_type_id';
        $this->merit_model->setJoin(array(
            'table' => array($site . '.tbl_option_type'),
            'join_field' => array('id'),
            'source_field' => array($site . '.tbl_option.type_id'),
            'type' => 'left'
        ));
        $this->merit_model->setSelectFields($fieldName);
        $o = $this->merit_model->getInfo($site . '.tbl_option');

        $option = array();
        if(count($o) > 0){
            foreach($o as $v){
                $option[$v->menu_id][$v->type_id][$v->input_type_id][$v->id] = $v->value;
            }
        }
        $this->data['option'] = $option;

        //region Get Data
        $info = array();
        $interior_selected = array();
        if(count($m) > 0){
            foreach($m as $k=>$tbl){
                $d = $this->merit_model->getInfo($tbl,$id,'job_id');

                if($k == 2){
                    if(count($d) > 0){
                        foreach($d as $v){
                            $interior_selected[] = $v->interior_room_id;
                            $info[$k][$v->interior_room_id] = $v;
                        }
                    }
                }
                else{
                    $info[$k] = $d;
                }
            }
        }
        $this->data['info'] = $info;
        $this->data['interior_selected'] = json_encode($interior_selected);
        //endregion

        $job_detail = $this->merit_model->getInfo($site . '.tbl_job_detail',$id);
        $this->data['job_detail'] = $job_detail;

        $this->merit_model->setSelectFields(array('id', 'instruction_received'));
        $instruction_received = $this->merit_model->getInfo($site . '.tbl_instruction_received');
        $this->data['instruction_received'] = $instruction_received;

        $this->merit_model->setSelectFields(array('id', 'property_status'));
        $instruction_received = $this->merit_model->getInfo($site . '.tbl_property_status');
        $this->data['property_status'] = $instruction_received;

        $this->merit_model->setSelectFields(array('id', 'inspection_type'));
        $inspection_type = $this->merit_model->getInfo($site . '.tbl_inspection_type');
        $this->data['inspection_type'] = $inspection_type;

        $defects = $this->merit_model->getInfo($site . '.tbl_defects');
        if(count($defects) > 0){
            foreach ($defects as $v) {
                $dir = json_decode($v->dir);
                $files = array();
                if(count($dir) > 0){
                    foreach ($dir as $file) {
                        $files[] = "defects/" . $v->id . "/" . $file;
                    }
                }
                $v->dir = $files;
            }
        }
        $this->data['defects'] = $defects;

        $this->merit_model->setSelectFields(array('id', 'orientation'));
        $o = $this->merit_model->getInfo($site . '.tbl_report_orientation');

        $orientation = array();
        if(count($o) > 0){
            foreach ($o as $v) {
                $orientation[$v->id] = $v->orientation;
            }
        }
        $this->data['orientation'] = $orientation;

        $this->main_model->setSelectFields(array('id','CONCAT(FName," ",LName) as name','AccountType','isQualifiedInspector'));
        $accounts = $this->main_model->getinfo('tbl_user');
        $inspector = array();
        $accounts_array = array();

        if(count($accounts) > 0){
            foreach($accounts as $k=>$v){

                @$inspector[''] = '-';

                if($v->AccountType != 4){
                    $accounts_array[''] = '-';
                    $accounts_array[$v->id] = $v->name;
                }
                if($v->AccountType == 4 || $v->isQualifiedInspector){
                    $inspector[$v->id] = $v->name;
                }
            }
        }

        $account_type = $this->data['accountType'];
        $user_id = $this->data['_userID'];
        $inspector_id = $account_type == 4 ? $user_id : '';
        $this->merit_model->setNormalized('project_name','id');
        $this->merit_model->setSelectFields(array('id','project_name'));
        $job_name = $this->merit_model->getInfo('tbl_job_registration',$inspector_id,'inspector_id');
        $job_name[''] = 'Select Job';
        ksort($job_name);

        $this->data['job_name'] = $job_name;
        $this->data['inspector'] = $inspector;
        if(isset($_GET['has_id'])){
            $job_id = isset($_POST['id']) ? $_POST['id'] : 0;
            $this->merit_model->setShift();
            $job = (Object)$this->merit_model->getInfo('tbl_job_registration',$job_id);
            echo json_encode($job);
        }else{
            $this->data['_pageLoad'] = 'on_site/on_site_view';
            $this->load->view('main_view', $this->data);
        }
    }


}
