<?php
include('merit.php');

class On_Site_Controller extends Merit{
    function __construct(){
        parent::__construct();
        if($this->session->userdata('isLogged') == false){
            redirect('login');
        }
    }

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
        $id = $this->uri->segment(2) ? $this->uri->segment(2) : '';
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
        $this->merit_model->setNormalized('instruction_received','id');
        $instruction_received = $this->merit_model->getInfo($site . '.tbl_instruction_received');
        $this->data['instruction_received'] = $instruction_received;

        $this->merit_model->setSelectFields(array('id', 'property_status'));
        $instruction_received = $this->merit_model->getInfo($site . '.tbl_property_status');
        $this->data['property_status'] = $instruction_received;

        $this->merit_model->setSelectFields(array('id', 'inspection_type'));
        $inspection_type = $this->merit_model->getInfo($site . '.tbl_inspection_type');
        $this->data['inspection_type'] = $inspection_type;

        $whatVal = '';
        $whatFld = '';
        if($this->uri->segment(2)){
            $whatVal = $this->uri->segment(2);
            $whatFld = 'job_id';
        }
        $defects = $this->merit_model->getInfo($site . '.tbl_defects',$whatVal,$whatFld);
        $rooms = array();
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
                if($v->room_id){
                    $rooms[] =  $v->room_id;
                }
            }
        }
        $this->data['defects'] = $defects;
        $this->data['rooms'] = $rooms;
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
            $job = $this->merit_model->getInfo('tbl_job_registration',$job_id);

            echo json_encode((Object)$job);
        }
        else{
            /*$this->data['_pageLoad'] = 'on_site/on_site_view';
            $this->load->view('main_view', $this->data);*/
            $this->load->view('on_site/on_site_view', $this->data);
        }
    }

    //region Upload Area
    public function jobDefects(){
        $site = $this->db->site;
        $r = array();
        $return = array();
        if (!empty($_FILES)) {
            $menu_id = isset($_POST['menu_id']) ? $_POST['menu_id'] : NULL;
            $room_id = isset($_POST['room_id']) ? $_POST['room_id'] : NULL;
            $post = array(
                'date' => date('Y-m-d H:i:s'),
                'menu_id' => $menu_id,
                'job_id' => $this->uri->segment(2),
                'room_id' => $room_id,
                'field_id' => $room_id,
                'title' => isset($_POST['title']) ? $_POST['title'] : '',
                'description' => isset($_POST['description']) ? nl2br($_POST['description']) : ''
            );
            $return = $post;
            if(isset($_POST['exterior_category_id'])){
                $post['exterior_category_id'] = $_POST['exterior_category_id'];
            }
            $defect_id = $this->merit_model->insert($site.'.tbl_defects',$post);

            $path = realpath(APPPATH.'../defects');
            $dir = $path . '/' . $defect_id . '/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, TRUE);
            }

            $success_upload = array();
            if (isset($_FILES['jobDefects'])) {
                foreach($_FILES['jobDefects']['name'] as $k=>$v){
                    $file = $dir . basename($v);
                    if (move_uploaded_file($_FILES['jobDefects']['tmp_name'][$k], $file)) {
                        $success_upload[] = basename($v);
                    }
                    else{
                        $r['error'] = 1;
                    }
                }
            }

            if(count($success_upload) > 0){
                $post = array(
                    'dir' => json_encode($success_upload)
                );

                $this->merit_model->update($site . '.tbl_defects',$post,$defect_id,'id',false);

                $r['success'] = 1;
            }
        }
        if($r['success'] == 1){
            redirect('onSiteVisit/' . $return['job_id'] . '?menu_id=' . $return['menu_id'] . '&field_id=' . $return['field_id']
                . ($return['room_id'] ? '&room_id=' . $return['room_id'] : ''));
        }
        else{
            redirect('onSiteVisit/' . $this->uri->segment(2));
        }
        //echo json_encode($r);
    }

    public function jobDefectsDelete(){
        $site = $this->db->site;
        $this->load->helper('directory');
        if(isset($_POST['id'])){
            $defect_id = $_POST['id'];
            $this->merit_model->delete($site.'.tbl_defects',$defect_id);
            $path = realpath(APPPATH.'../defects');
            $directory = $path . '/' . $defect_id . '/';
            if(file_exists($directory)){
                $f = directory_map($directory);
                foreach ($f as $file){
                    unlink($file);
                }
            }
            rmdir($directory);
        }
    }
    //endregion

    //region Upload Area
    public function jobUploadsView(){
        $id = $this->uri->segment(2);
        $this->data['id'] = $id;
        $this->data['page'] = 'jobUpload';
        $this->data['pageHeader'] = 'View Jobs Uploads';

        $path = realpath(APPPATH.'../uploads');

        $directory = $path . '/' . $id;
        $job_uploads = $this->merit_model->getInfo('tbl_job_uploads',$id,'job_id');
        if(count($job_uploads) > 0){
            foreach ($job_uploads as $v) {
                $dir = json_decode($v->dir);
                $files = array();
                if(count($dir) > 0){
                    foreach ($dir as $file) {
                        $files[] = $directory . "/" . $v->id . "/" . $file;
                    }
                }
                $v->dir = $files;
            }
        }
        $this->data['job_uploads'] = $job_uploads;


    }

    public function jobUploadsSubmit($id){
        $r = array();
        if (!empty($_FILES)) {
            $post = array(
                'job_id' => $id,
                'details' => nl2br($_POST['details'])
            );

            $upload_id = \DB::table('tbl_job_uploads')
                ->insertGetId($post);
            $dir = 'uploads/' . $id . '/' . $upload_id . '/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, TRUE);
            }

            $success_upload = array();
            if (isset($_FILES['jobUpload'])) {
                foreach($_FILES['jobUpload']['name'] as $k=>$v){
                    $file = $dir . basename($v);
                    if (move_uploaded_file($_FILES['jobUpload']['tmp_name'][$k], $file)) {
                        $success_upload[] = basename($v);
                    }
                    else{
                        $r['error'] = 1;
                    }
                }
            }

            if(count($success_upload) > 0){
                $post = array(
                    'dir' => json_encode($success_upload)
                );

                \DB::table('tbl_job_uploads')
                    ->where('id', '=', $upload_id)
                    ->update($post);

                $r['success'] = 1;
            }
        }

        return response()->json($r);
    }

    public function jobUploadDelete($id){
        if(isset($_POST['_token'])){
            $upload_id = $_POST['id'];
            \DB::table('tbl_job_uploads')
                ->where('id', '=', $upload_id)
                ->delete();

            $directory = 'uploads/' . $id . '/' . $upload_id . '/';
            if(file_exists($directory)){
                $f = \File::allFiles($directory);
                foreach ($f as $file){
                    unlink($file);
                }
            }
            rmdir($directory);
        }
    }
    //endregion

    public function jobCalculate($id){
        $this->data['id'] = $id;
        $this->data['page'] = 'jobCalculate';
        $this->data['pageHeader'] = 'View Jobs Calculation';

        if(isset($_POST['_token'])) {
            $url = 'jobCalculate/' . $id;

            unset($_POST['_token']);
            unset($_POST['submit']);

            $post = $_POST;
            $post['job_id'] = $id;
            $it_exist = \DB::table('tbl_job_calculation')
                ->where('job_id', '=', $id)
                ->pluck('id');
            if($it_exist){
                \DB::table('tbl_job_calculation')
                    ->where('job_id', '=', $id)
                    ->update($post);
            }
            else{
                \DB::table('tbl_job_calculation')
                    ->insert($post);
            }

            return \Redirect::to($url);
        }

        $g = \DB::table('tbl_gib')
            ->get();
        $gib = array();
        if(count($g) > 0){
            foreach($g as $v){
                $gib[$v->id] = $v->gib;
            }
        }
        $this->data['gib'] = $gib;

        $gr = \DB::table('tbl_gib_book_rate')
            ->get();
        $gib_rate = array();
        if(count($gr) > 0){
            foreach($gr as $v){
                $gib_rate[$v->id] = number_format($v->rate, 2, '.', '');
            }
        }
        $this->data['gib_rate'] = $gib_rate;

        $i = \DB::table('tbl_interior')
            ->join('tbl_option', 'tbl_interior.interior_room_id', '=', 'tbl_option.id')
            ->where('tbl_interior.job_id', $id)
            ->select(array(
                'tbl_interior.interior_room_id',
                'tbl_interior.interior_width',
                'tbl_interior.interior_length',
                'tbl_interior.interior_floor_covering',
                'tbl_interior.interior_window',
                'tbl_interior.interior_entry_door',
                'tbl_option.value as room_name'
            ))
            ->get();
        $openings = array();
        $floor_covering = array();
        if(count($i) > 0){
            foreach($i as $v){
                $windows = json_decode($v->interior_window);
                if(count($windows) > 0){
                    foreach($windows as $type=>$w){
                        if(array_key_exists('_option', $w)){
                            if(count($w->_option) > 0){
                                foreach($w->_option as $key=>$value){
                                    $thisTotal = (float)number_format((($w->_height[$key]/1000) * ($w->_width[$key]/1000)) * $w->_count[$key], 2, '.', '');
                                    if(array_key_exists($value, $openings)){
                                        $openings[$value] += $thisTotal;
                                    }
                                    else{
                                        $openings[$value] = $thisTotal;
                                    }
                                }
                            }
                        }
                    }
                }
                $entry_doors = json_decode($v->interior_entry_door);
                if(count($entry_doors) > 0){
                    foreach($entry_doors as $type=>$w){
                        if(array_key_exists('_option', $w)){
                            if(count($w->_option) > 0){
                                foreach($w->_option as $key=>$value){
                                    $thisTotal = (float)number_format((($w->_height[$key]/1000) * ($w->_width[$key]/1000)) * $w->_count[$key], 2, '.', '');
                                    if(array_key_exists($value, $openings)){
                                        $openings[$value] += $thisTotal;
                                    }
                                    else{
                                        $openings[$value] = $thisTotal;
                                    }
                                }
                            }
                        }
                    }
                }

                if($v->interior_floor_covering) {
                    $floor_covering_txt = $i = \DB::table('tbl_option')
                        ->where('id', '=', $v->interior_floor_covering)
                        ->pluck('value');
                    $floor_covering[$v->interior_floor_covering]['txt'] = $floor_covering_txt;
                    $floor_covering[$v->interior_floor_covering]['values'][$v->interior_room_id] = array(
                        'rooms_name' => $v->room_name,
                        'width' => $v->interior_width,
                        'length' => $v->interior_length,
                        'total' => number_format((($v->interior_width / 1000) * ($v->interior_length / 1000)), 2, '.', '')
                    );
                }
            }
        }

        $this->data['openings'] = $openings;
        $this->data['floor_covering'] = $floor_covering;

        $calculation = \DB::table('tbl_job_calculation')
            ->where('job_id', '=', $id)
            ->get();
        $this->data['calculation'] = last($calculation);



        return view('main', $this->data);
    }

    //region Job Report
    public function jobReport($id){
        $this->data['page'] = 'jobReport';
        $this->data['pageHeader'] = 'Report';

        if(isset($_POST['_token'])){
            if(isset($_POST['conclusion']) || isset($_POST['inspection'])){
                $post = array(
                    'job_id' => $id,
                    'conclusion' => json_encode($_POST['conclusion']),
                    'inspection' => json_encode($_POST['inspection'])
                );

                $itExist = count(\DB::table('tbl_job_report')->where('job_id', '=', $id)->get()) > 0;
                if($itExist){
                    \DB::table('tbl_job_report')
                        ->where('job_id', '=', $id)
                        ->update($post);
                }
                else{
                    \DB::table('tbl_job_report')
                        ->insert($post);
                }
            }

            if(isset($_POST['site_inspection'])){
                if(count($_POST['site_inspection']) > 0){
                    foreach ($_POST['site_inspection'] as $k=>$v) {
                        if($v['comment'] == "" && !isset($v['default'])){
                            continue;
                        }

                        $post = array(
                            'job_id' => $id,
                            'type' => $k,
                            'default_txt' => isset($v['default']) ? $v['default'] : '',
                            'comment' => $v['comment']
                        );
                        $itExist = count(\DB::table('tbl_job_site_inspection_photo')
                                ->where('job_id', '=', $id)
                                ->where('type', '=', $k)
                                ->get()) > 0;
                        if($itExist){
                            \DB::table('tbl_job_site_inspection_photo')
                                ->where('job_id', '=', $id)
                                ->where('type', '=', $k)
                                ->update($post);
                        }
                        else{
                            \DB::table('tbl_job_site_inspection_photo')
                                ->insert($post);
                        }
                    }
                }
            }

            $thisUrl = 'jobReport/' . $id;

            \Redirect::to($thisUrl);
        }

        $clients = \DB::table('tbl_job_clients')
            ->where('job_id', '=', $id)
            ->first();
        $this->data['clients'] = $clients;

        $fieldName = arrayWalk(\Schema::getColumnListing('tbl_job_detail'), 'tbl_job_detail.');
        $fieldName[] = 'tbl_inspection_type.inspection_type as inspection_type';
        $fieldName[] = 'CONCAT(tbl_user.first_name, " ", tbl_user.last_name) as assigned_to';
        $fieldName[] = 'tbl_report_orientation.orientation as property_orientation';

        $job = \DB::table('tbl_job_detail')
            ->join('tbl_inspection_type', 'tbl_inspection_type.id', '=', 'tbl_job_detail.type_inspection')
            ->join('tbl_user', 'tbl_user.id', '=', 'tbl_job_detail.assigned_to')
            ->join('tbl_report_orientation', 'tbl_report_orientation.id', '=', 'tbl_job_detail.property_orientation')
            ->select(\DB::raw(implode(", ", $fieldName)))
            ->where('tbl_job_detail.id', '=', $id)
            ->first();
        $this->data['job'] = $job;

        $job_report = \DB::table('tbl_job_report')
            ->where('job_id', '=', $id)
            ->first();
        $this->data['job_report'] = $job_report;

        $o = \DB::table('tbl_report_orientation')
            ->select(array('id', 'orientation'))
            ->get();
        $orientation = array();
        if(count($o) > 0){
            foreach ($o as $v) {
                $orientation[$v->id] = $v->orientation;
            }
        }
        $this->data['orientation'] = $orientation;

        $t = \DB::table('tbl_job_tags')
            ->orderBy('text', 'ASC')
            ->get();
        $job_tags = array();
        if(count($t) > 0){
            foreach ($t as $v) {
                $job_tags[$v->id] = $v->text;
            }
        }
        $this->data['job_tags'] = $job_tags;

        $s = \DB::table('tbl_job_site_inspection_photo')
            ->where('job_id', '=', $id)
            ->get();
        $site_inspection = array();
        if(count($s) > 0){
            foreach ($s as $v) {
                $site_inspection[$v->type] = $v;
            }
        }
        $this->data['site_inspection'] = $site_inspection;

        $op = \DB::table('tbl_option')
            ->where('type_id', '=', 12)
            ->get();
        $heating_types = array();
        if(count($op) > 0){
            foreach ($op as $v) {
                $heating_types[$v->id] = $v->value;
            }
        }

        $fieldName = arrayWalk(\Schema::getColumnListing('tbl_general'), 'tbl_general.');
        $general = \DB::table('tbl_general')
            ->select(\DB::raw(implode(", ", $fieldName)))
            ->where('tbl_general.job_id', '=', $id)
            ->first();
        $this->data['general'] = $general;

        $fieldName = array(
            'tbl_interior.interior_room_id',
            'a.value as interior_wall_covering',
            'b.value as interior_ceiling_design',
            'c.value as interior_ceiling_lining',
            'd.value as interior_ceiling_finish',
            'e.value as interior_floor_covering',
            'f.value as interior_cooktop',
            'g.value as interior_oven',
            'h.value as interior_kitchen_sink',
            'i.value as interior_kitchen_bench_finish',
            'j.value as interior_kitchen_cupboard_finish   '
        );
        $i = \DB::table('tbl_interior')
            ->leftJoin('tbl_option as a', 'a.id', '=', 'tbl_interior.interior_wall_covering')
            ->leftJoin('tbl_option as b', 'b.id', '=', 'tbl_interior.interior_ceiling_design')
            ->leftJoin('tbl_option as c', 'c.id', '=', 'tbl_interior.interior_ceiling_lining')
            ->leftJoin('tbl_option as d', 'd.id', '=', 'tbl_interior.interior_ceiling_finish')
            ->leftJoin('tbl_option as e', 'e.id', '=', 'tbl_interior.interior_floor_covering')
            ->leftJoin('tbl_option as f', 'f.id', '=', 'tbl_interior.interior_cooktop')
            ->leftJoin('tbl_option as g', 'g.id', '=', 'tbl_interior.interior_oven')
            ->leftJoin('tbl_option as h', 'h.id', '=', 'tbl_interior.interior_kitchen_sink')
            ->leftJoin('tbl_option as i', 'i.id', '=', 'tbl_interior.interior_kitchen_bench_finish')
            ->leftJoin('tbl_option as j', 'j.id', '=', 'tbl_interior.interior_kitchen_cupboard_finish')
            ->select(\DB::raw(implode(", ", $fieldName)))
            ->where('tbl_interior.job_id', '=', $id)
            ->get();
        $interior = array();
        if(count($i) > 0){
            $general_heating_room_id = $general->general_heating_room_id ? json_decode($general->general_heating_room_id) : array();
            $general_heating = $general->general_heating ? json_decode($general->general_heating) : array();

            foreach ($i as $v) {
                $interior_ceiling = array(
                    $v->interior_ceiling_design,
                    $v->interior_ceiling_lining,
                    $v->interior_ceiling_finish,
                );
                $v->interior_ceiling = array_filter($interior_ceiling);

                $interior_cooktop_oven = array(
                    $v->interior_cooktop,
                    $v->interior_oven
                );
                $v->interior_cooktop_oven = array_unique(array_filter($interior_cooktop_oven));

                $interior_bench_cupboard = array(
                    $v->interior_kitchen_bench_finish,
                    $v->interior_kitchen_cupboard_finish
                );
                $v->interior_bench_cupboard = array_filter($interior_bench_cupboard);

                $v->heating = '';
                if(in_array($v->interior_room_id, $general_heating_room_id)){
                    $room_heating_key = array_search($v->interior_room_id, $general_heating_room_id);
                    $heating_key = $general_heating[$room_heating_key];
                    $v->heating = $heating_types[$heating_key];
                }

                $interior[$v->interior_room_id] = $v;
            }
        }
        $this->data['interior'] = $interior;

        $fieldName = array(
            'a.value as exterior_roof_cladding',
            'b.value as exterior_entry_doors',
            'c.value as exterior_glazing'
        );
        $exterior = \DB::table('tbl_exterior')
            ->leftJoin('tbl_option as a', 'a.id', '=', 'tbl_exterior.exterior_roof_cladding')
            ->leftJoin('tbl_option as b', 'b.id', '=', 'tbl_exterior.exterior_entry_doors')
            ->leftJoin('tbl_option as c', 'c.id', '=', 'tbl_exterior.exterior_glazing')
            ->select(\DB::raw(implode(", ", $fieldName)))
            ->where('tbl_exterior.job_id', '=', $id)
            ->first();
        $this->data['exterior'] = $exterior;

        $fieldName = array(
            'a.value as outdoors_drive_type',
            'b.value as outdoors_stairs',
        );
        $outdoors = \DB::table('tbl_outdoors')
            ->leftJoin('tbl_option as a', 'a.id', '=', 'tbl_outdoors.outdoors_drive_type')
            ->leftJoin('tbl_option as b', 'b.id', '=', 'tbl_outdoors.outdoors_stairs')
            ->select(\DB::raw(implode(", ", $fieldName)))
            ->where('tbl_outdoors.job_id', '=', $id)
            ->first();
        $this->data['outdoors'] = $outdoors;

        $site_inspection_info = array(
            'SITE &amp; FEATURES' => array(
                'grounds' => array(
                    'label' => 'Grounds'
                ),
                'driveway' => array(
                    'label' => 'Driveway',
                    'default' => $outdoors->outdoors_drive_type
                ),
                'patios_concrete' => array(
                    'label' => 'Patios &amp; Concrete'
                ),
                'external_lighting' => array(
                    'label' => 'External Lighting'
                ),
                'external_taps' => array(
                    'label' => 'External Taps'
                ),
                'external_stairs' => array(
                    'label' => 'External Stairs',
                    'default' => $outdoors->outdoors_stairs
                ),
                'front_fence' => array(
                    'label' => 'Front Fence',
                    'has_input' => 1
                ),
                'boundary_fences' => array(
                    'label' => 'Boundary Fences'
                ),
                'gates' => array(
                    'label' => 'Gates'
                )
            ),
            'OUT BUILDINGS' => array(
                'garage' => array(
                    'label' => 'Garage'
                )
            ),
            'ROOF EXTEROR' => array(
                'roof_cladding' => array(
                    'label' => 'Roof Cladding',
                    'default' => $exterior->exterior_roof_cladding
                ),
                'chimneys_flues' => array(
                    'label' => 'Chimneys &amp; Flues'
                ),
                'flashings' => array(
                    'label' => 'Flashings'
                ),
                'internal_gutters' => array(
                    'label' => 'Internal Gutters'
                ),
                'penetrations' => array(
                    'label' => 'Penetrations'
                )
            ),
            'FASCIA &amp; SPOUTING' => array(
                'spouting' => array(
                    'label' => 'Spouting'
                ),
                'downpipes' => array(
                    'label' => 'Downpipes'
                )
            ),
            'FASCIA &amp; SOFFITS' => array(
                'fascia' => array(
                    'label' => 'Fascia'
                ),
                'soffit_lining' => array(
                    'label' => 'Soffit Lining'
                )
            ),
            'EXTERIOR WALLS' => array(
                'exterior_walls_construction_type' => array(
                    'label' => 'Construction Type',
                    'has_input' => 1
                ),
                'cladding' => array(
                    'label' => 'Cladding'
                ),
                'exterior_walls_alterations' => array(
                    'label' => 'Alterations',
                    'has_input' => 1
                )
            ),
            'EXTERIOR WINDOWS &amp; DOORS' => array(
                'frames' => array(
                    'label' => 'Frames',
                    'default' => $exterior->exterior_entry_doors
                ),
                'glazing' => array(
                    'label' => 'Glazing',
                    'default' => $exterior->exterior_glazing
                )
            ),
            'PERIMETER FOUNDATION' => array(
                'perimeter_foundation_construction_type' => array(
                    'label' => 'Construction Type',
                    'has_input' => 1
                ),
                'perimeter_foundation_alterations' => array(
                    'label' => 'Alterations',
                    'has_input' => 1
                )
            ),
            'FLOOR LEVELS' => array(
                'levels_total' => array(
                    'label' => 'Levels taken in total'
                ),
                'lowest_point' => array(
                    'label' => 'Lowest point'
                ),
                'highest_point' => array(
                    'label' => 'Highest point'
                ),
                'maximum_difference' => array(
                    'label' => 'Maximum Difference'
                ),
                'slopes_5' => array(
                    'label' => 'Slopes <5%'
                ),
            ),
            'GARAGE' => array(
                'garage_walls' => array(
                    'label' => 'Walls',
                    'default' => isset($interior[25]) ? $interior[25]->interior_wall_covering : ''
                ),
                'garage_ceiling' => array(
                    'label' => 'Ceiling',
                    'default' => isset($interior[25]) ? implode(', ', $interior[25]->interior_ceiling) : ''
                ),
                'garage_windows_hardware' => array(
                    'label' => 'Windows &amp; Hardware'
                ),
                'garage_doors_hardware' => array(
                    'label' => 'Doors &amp; Hardware'
                ),
                'garage_floor_coverings' => array(
                    'label' => 'Floor Coverings',
                    'default' => isset($interior[25]) ? $interior[25]->interior_floor_covering : ''
                ),
                'garage_door' => array(
                    'label' => 'Garage Door'
                ),
                'garage_auto_door_opener' => array(
                    'label' => 'Auto Door Opener'
                ),
                'garage_electrical_faceplates_fixtures' => array(
                    'label' => 'Electrical Faceplates & Fixtures'
                ),
                'garage_alterations' => array(
                    'label' => 'Alterations',
                    'has_input' => 1
                ),
            ),
            'CONSERVATORY' => array(
                'conservatory_walls' => array(
                    'label' => 'Walls',
                    'has_input' => 1
                ),
                'conservatory_ceiling' => array(
                    'label' => 'Ceiling',
                    'has_input' => 1
                ),
                'conservatory_windows_hardware' => array(
                    'label' => 'Windows &amp; Hardware'
                ),
                'conservatory_doors_hardware' => array(
                    'label' => 'Doors &amp; Hardware'
                ),
                'conservatory_floor_coverings' => array(
                    'label' => 'Floor Coverings',
                    'has_input' => 1
                ),
                'conservatory_heating' => array(
                    'label' => 'Heating'
                ),
                'conservatory_electrical_faceplates_fixtures' => array(
                    'label' => 'Electrical Faceplates & Fixtures'
                ),
                'conservatory_alterations' => array(
                    'label' => 'Alterations',
                    'has_input' => 1
                ),
            ),
            'HALLWAY' => array(
                'hallway_walls' => array(
                    'label' => 'Walls',
                    'default' => isset($interior[5]) ? $interior[5]->interior_wall_covering : ''
                ),
                'hallway_ceiling' => array(
                    'label' => 'Ceiling',
                    'default' => isset($interior[5]) ? implode(', ', $interior[5]->interior_ceiling) : ''
                ),
                'hallway_windows_hardware' => array(
                    'label' => 'Windows &amp; Hardware'
                ),
                'hallway_doors_hardware' => array(
                    'label' => 'Doors &amp; Hardware'
                ),
                'hallway_floor_coverings' => array(
                    'label' => 'Floor Coverings',
                    'default' => isset($interior[5]) ? $interior[5]->interior_floor_covering : ''
                ),
                'hallway_stairs' => array(
                    'label' => 'Stairs'
                ),
                'hallway_handrails_balustrades' => array(
                    'label' => 'Handrails & Balustrades'
                ),
                'hallway_electrical_faceplates_fixtures' => array(
                    'label' => 'Electrical Faceplates & Fixtures'
                ),
                'hallway_alterations' => array(
                    'label' => 'Alterations',
                    'has_input' => 1
                ),
            ),
            'LOUNGE' => array(
                'lounge_walls' => array(
                    'label' => 'Walls',
                    'default' => isset($interior[10]) ? $interior[10]->interior_wall_covering : ''
                ),
                'lounge_ceiling' => array(
                    'label' => 'Ceiling',
                    'default' => isset($interior[10]) ? implode(', ', $interior[10]->interior_ceiling) : ''
                ),
                'lounge_windows_hardware' => array(
                    'label' => 'Windows &amp; Hardware'
                ),
                'lounge_doors_hardware' => array(
                    'label' => 'Doors &amp; Hardware'
                ),
                'lounge_floor_coverings' => array(
                    'label' => 'Floor Coverings',
                    'default' => isset($interior[10]) ? $interior[10]->interior_floor_covering : ''
                ),
                'lounge_heating' => array(
                    'label' => 'Heating',
                    'default' => isset($interior[10]) ? $interior[10]->heating : ''
                ),
                'lounge_electrical_faceplates_fixtures' => array(
                    'label' => 'Electrical Faceplates & Fixtures'
                ),
                'lounge_alterations' => array(
                    'label' => 'Alterations',
                    'has_input' => 1
                ),
            ),
            'DINNING' => array(
                'dinning_walls' => array(
                    'label' => 'Walls',
                    'default' => isset($interior[7]) ? $interior[7]->interior_wall_covering : ''
                ),
                'dinning_ceiling' => array(
                    'label' => 'Ceiling',
                    'default' => isset($interior[7]) ? implode(', ', $interior[7]->interior_ceiling) : ''
                ),
                'dinning_windows_hardware' => array(
                    'label' => 'Windows &amp; Hardware'
                ),
                'dinning_doors_hardware' => array(
                    'label' => 'Doors &amp; Hardware'
                ),
                'dinning_floor_coverings' => array(
                    'label' => 'Floor Coverings',
                    'default' => isset($interior[7]) ? $interior[7]->interior_floor_covering : ''
                ),
                'dinning_heating' => array(
                    'label' => 'Heating',
                    'default' => isset($interior[7]) ? $interior[7]->heating : ''
                ),
                'dinning_electrical_faceplates_fixtures' => array(
                    'label' => 'Electrical Faceplates & Fixtures'
                ),
                'dinning_alterations' => array(
                    'label' => 'Alterations',
                    'has_input' => 1
                ),
            ),
            'KITCHEN' => array(
                'kitchen_walls' => array(
                    'label' => 'Walls',
                    'default' => isset($interior[6]) ? $interior[6]->interior_wall_covering : ''
                ),
                'kitchen_ceiling' => array(
                    'label' => 'Ceiling',
                    'default' => isset($interior[6]) ? implode(', ', $interior[6]->interior_ceiling) : ''
                ),
                'kitchen_windows_hardware' => array(
                    'label' => 'Windows &amp; Hardware'
                ),
                'kitchen_doors_hardware' => array(
                    'label' => 'Doors &amp; Hardware'
                ),
                'kitchen_floor_coverings' => array(
                    'label' => 'Floor Coverings',
                    'default' => isset($interior[6]) ? $interior[6]->interior_floor_covering : ''
                ),
                'kitchen_heating' => array(
                    'label' => 'Heating',
                    'default' => isset($interior[6]) ? $interior[6]->heating : ''
                ),
                'kitchen_electrical_faceplates_fixtures' => array(
                    'label' => 'Electrical Faceplates & Fixtures'
                ),
                'kitchen_alterations' => array(
                    'label' => 'Alterations',
                    'has_input' => 1
                ),
                'kitchen_bench_top_cupboards' => array(
                    'label' => 'Bench Top & Cupboards',
                    'default' => isset($interior[6]) ? implode(', ', $interior[6]->interior_bench_cupboard) : ''
                ),
                'kitchen_sink_taps' => array(
                    'label' => 'Sink & Taps',
                    'default' => isset($interior[6]) ? $interior[6]->interior_kitchen_sink : ''
                ),
                'kitchen_cooktop_oven' => array(
                    'label' => 'Oven & Cooktop',
                    'default' => isset($interior[6]) ? implode(', ', $interior[6]->interior_cooktop_oven) : ''
                ),
                'kitchen_range_hood' => array(
                    'label' => 'Range hood'
                ),
                'kitchen_waste_disposal' => array(
                    'label' => 'Waste Disposal'
                ),
                'kitchen_dishwasher' => array(
                    'label' => 'Dishwasher'
                ),
            ),
            'LAUNDRY' => array(
                'laundry_walls' => array(
                    'label' => 'Walls',
                    'default' => isset($interior[23]) ? $interior[23]->interior_wall_covering : ''
                ),
                'laundry_ceiling' => array(
                    'label' => 'Ceiling',
                    'default' => isset($interior[23]) ? implode(', ', $interior[23]->interior_ceiling) : ''
                ),
                'laundry_windows_hardware' => array(
                    'label' => 'Windows &amp; Hardware'
                ),
                'laundry_doors_hardware' => array(
                    'label' => 'Doors &amp; Hardware'
                ),
                'laundry_floor_coverings' => array(
                    'label' => 'Floor Coverings',
                    'default' => isset($interior[23]) ? $interior[23]->interior_floor_covering : ''
                ),
                'laundry_electrical_faceplates_fixtures' => array(
                    'label' => 'Electrical Faceplates & Fixtures'
                ),
                'laundry_tub_taps' => array(
                    'label' => 'Laundry tub &amp; taps'
                ),
                'laundry_water_temp' => array(
                    'label' => 'Water Temperature(48deg)',
                ),
                'laundry_water_pressure' => array(
                    'label' => 'Water Pressure'
                ),
                'laundry_dryer_ventilation' => array(
                    'label' => 'Dryer Ventilation'
                ),
            ),
            'BEDROOM 1' => array(
                'bedroom_1_walls' => array(
                    'label' => 'Walls',
                    'default' => isset($interior[11]) ? $interior[11]->interior_wall_covering : ''
                ),
                'bedroom_1_ceiling' => array(
                    'label' => 'Ceiling',
                    'default' => isset($interior[11]) ? implode(', ', $interior[11]->interior_ceiling) : ''
                ),
                'bedroom_1_windows_hardware' => array(
                    'label' => 'Windows &amp; Hardware'
                ),
                'bedroom_1_doors_hardware' => array(
                    'label' => 'Doors &amp; Hardware'
                ),
                'bedroom_1_floor_coverings' => array(
                    'label' => 'Floor Coverings',
                    'default' => isset($interior[11]) ? $interior[11]->interior_floor_covering : ''
                ),
                'bedroom_1_heating' => array(
                    'label' => 'Heating',
                    'default' => isset($interior[11]) ? $interior[11]->heating : ''
                ),
                'bedroom_1_electrical_faceplates_fixtures' => array(
                    'label' => 'Electrical Faceplates & Fixtures'
                )
            ),
            'BEDROOM 2' => array(
                'bedroom_2_walls' => array(
                    'label' => 'Walls',
                    'default' => isset($interior[11]) ? $interior[11]->interior_wall_covering : ''
                ),
                'bedroom_2_ceiling' => array(
                    'label' => 'Ceiling',
                    'default' => isset($interior[11]) ? implode(', ', $interior[11]->interior_ceiling) : ''
                ),
                'bedroom_2_windows_hardware' => array(
                    'label' => 'Windows &amp; Hardware'
                ),
                'bedroom_2_doors_hardware' => array(
                    'label' => 'Doors &amp; Hardware'
                ),
                'bedroom_2_floor_coverings' => array(
                    'label' => 'Floor Coverings',
                    'default' => isset($interior[11]) ? $interior[11]->interior_floor_covering : ''
                ),
                'bedroom_2_heating' => array(
                    'label' => 'Heating',
                    'default' => isset($interior[11]) ? $interior[11]->heating : ''
                ),
                'bedroom_2_electrical_faceplates_fixtures' => array(
                    'label' => 'Electrical Faceplates & Fixtures'
                ),
                'bedroom_2_alterations' => array(
                    'label' => 'Alterations',
                    'has_input' => 1
                )
            ),
            'BEDROOM 3' => array(
                'bedroom_3_walls' => array(
                    'label' => 'Walls',
                    'default' => isset($interior[11]) ? $interior[11]->interior_wall_covering : ''
                ),
                'bedroom_3_ceiling' => array(
                    'label' => 'Ceiling',
                    'default' => isset($interior[11]) ? implode(', ', $interior[11]->interior_ceiling) : ''
                ),
                'bedroom_3_windows_hardware' => array(
                    'label' => 'Windows &amp; Hardware'
                ),
                'bedroom_3_doors_hardware' => array(
                    'label' => 'Doors &amp; Hardware'
                ),
                'bedroom_3_floor_coverings' => array(
                    'label' => 'Floor Coverings',
                    'default' => isset($interior[11]) ? $interior[11]->interior_floor_covering : ''
                ),
                'bedroom_3_heating' => array(
                    'label' => 'Heating',
                    'default' => isset($interior[11]) ? $interior[11]->heating : ''
                ),
                'bedroom_3_electrical_faceplates_fixtures' => array(
                    'label' => 'Electrical Faceplates & Fixtures'
                ),
                'bedroom_3_alterations' => array(
                    'label' => 'Alterations',
                    'has_input' => 1
                )
            ),
            'BATHROOM' => array(
                'bathroom_walls' => array(
                    'label' => 'Walls',
                    'default' => isset($interior[11]) ? $interior[11]->interior_wall_covering : ''
                ),
                'bathroom_ceiling' => array(
                    'label' => 'Ceiling',
                    'default' => isset($interior[11]) ? implode(', ', $interior[11]->interior_ceiling) : ''
                ),
                'bathroom_windows_hardware' => array(
                    'label' => 'Windows &amp; Hardware'
                ),
                'bathroom_doors_hardware' => array(
                    'label' => 'Doors &amp; Hardware'
                ),
                'bathroom_floor_coverings' => array(
                    'label' => 'Floor Coverings',
                    'default' => isset($interior[11]) ? $interior[11]->interior_floor_covering : ''
                ),
                'bathroom_heating' => array(
                    'label' => 'Heating',
                    'default' => isset($interior[11]) ? $interior[11]->heating : ''
                ),
                'bathroom_electrical_faceplates_fixtures' => array(
                    'label' => 'Electrical Faceplates & Fixtures'
                ),
                'bathroom_bath_taps' => array(
                    'label' => 'Bath &amp; Taps'
                ),
                'bathroom_basin_taps' => array(
                    'label' => 'Basin &amp; Taps'
                ),
                'bathroom_shower' => array(
                    'label' => 'Shower',
                    'has_input' => 1
                ),
                'bathroom_water' => array(
                    'label' => 'Water'
                ),
                'bathroom_water_temp' => array(
                    'label' => 'Water Temperature (48deg)'
                ),
                'bathroom_water_pressure' => array(
                    'label' => 'Water Pressure'
                ),
                'bathroom_toilet_pan_cistern' => array(
                    'label' => 'Toilet Pan & Cistern'
                ),
                'bathroom_ventilation' => array(
                    'label' => 'Ventilation'
                )
            ),
            'ENSUITE' => array(
                'ensuite_walls' => array(
                    'label' => 'Walls',
                    'default' => isset($interior[11]) ? $interior[11]->interior_wall_covering : ''
                ),
                'ensuite_ceiling' => array(
                    'label' => 'Ceiling',
                    'default' => isset($interior[11]) ? implode(', ', $interior[11]->interior_ceiling) : ''
                ),
                'ensuite_windows_hardware' => array(
                    'label' => 'Windows &amp; Hardware'
                ),
                'ensuite_doors_hardware' => array(
                    'label' => 'Doors &amp; Hardware'
                ),
                'ensuite_floor_coverings' => array(
                    'label' => 'Floor Coverings',
                    'default' => isset($interior[11]) ? $interior[11]->interior_floor_covering : ''
                ),
                'ensuite_electrical_faceplates_fixtures' => array(
                    'label' => 'Electrical Faceplates & Fixtures'
                ),
                'ensuite_basin_taps' => array(
                    'label' => 'Basin &amp; Taps'
                ),
                'ensuite_shower' => array(
                    'label' => 'Shower',
                    'has_input' => 1
                ),
                'ensuite_water' => array(
                    'label' => 'Water'
                ),
                'ensuite_water_temp' => array(
                    'label' => 'Water Temperature (48deg)'
                ),
                'ensuite_water_pressure' => array(
                    'label' => 'Water Pressure'
                ),
                'ensuite_toilet_pan_cistern' => array(
                    'label' => 'Toilet Pan & Cistern'
                ),
                'ensuite_ventilation' => array(
                    'label' => 'Ventilation'
                )
            ),
            'ROOF SPACE' => array(
                'roof_access' => array(
                    'label' => 'Access',
                    'has_input' => 1
                ),
                'roof_underside_cladding' => array(
                    'label' => 'Underside of Cladding'
                ),
                'roof_roofing_underlay' => array(
                    'label' => 'Roofing Underlay'
                ),
                'roof_framing' => array(
                    'label' => 'Framing'
                ),
                'roof_trusses' => array(
                    'label' => 'Trusses'
                ),
                'roof_insulation' => array(
                    'label' => 'Insulation'
                ),
                'roof_electrical' => array(
                    'label' => 'Electrical '
                ),
                'roof_plumbing' => array(
                    'label' => 'Plumbing'
                ),
                'roof_ducting_fixtures' => array(
                    'label' => 'Ducting & Fixtures'
                ),
                'roof_alterations' => array(
                    'label' => 'Alterations',
                    'has_input' => 1
                ),
            ),
            'HOT WATER SUPPLY' => array(
                'hot_water_location' => array(
                    'label' => 'Location',
                    'has_input' => 1
                ),
                'hot_water_outer_liner' => array(
                    'label' => 'Outer liner'
                ),
                'hot_water_size' => array(
                    'label' => 'Size'
                ),
                'hot_water_stop_valve' => array(
                    'label' => 'Stop Valve'
                ),
                'hot_water_wet_back' => array(
                    'label' => 'Wet Back Connection'
                ),
                'hot_water_tempering_valve' => array(
                    'label' => 'Tempering Valve'
                ),
                'hot_water_water_supply' => array(
                    'label' => 'Water Supply '
                ),
                'hot_water_insulation' => array(
                    'label' => 'Insulation'
                ),
                'hot_water_electrical ' => array(
                    'label' => 'Electrical '
                ),
                'hot_water_plumbing' => array(
                    'label' => 'Plumbing'
                ),
                'hot_water_ducting_fixtures' => array(
                    'label' => 'Ducting & Fixtures'
                ),
            ),
            'SUB FLOOR' => array(
                'sub_floor_access' => array(
                    'label' => 'Access',
                    'has_input' => 1
                ),
                'sub_floor_foundation_type' => array(
                    'label' => 'Foundation Type',
                    'has_input' => 1
                ),
                'sub_floor_floor_type' => array(
                    'label' => 'Floor Type',
                    'has_input' => 1
                ),
                'sub_floor_ground_condition' => array(
                    'label' => 'Ground Condition'
                ),
                'sub_floor_vapour_barrier ' => array(
                    'label' => 'Vapour Barrier '
                ),
                'sub_floor_ventilation' => array(
                    'label' => 'Ventilation'
                ),
                'sub_floor_piles' => array(
                    'label' => 'Piles',
                    'has_input' => 1
                ),
                'sub_floor_plumbing' => array(
                    'label' => 'Plumbing'
                ),
                'sub_floor_ducting_fixtures ' => array(
                    'label' => 'Ducting & Fixtures '
                ),
                'sub_floor_electrical ' => array(
                    'label' => 'Electrical '
                ),
                'sub_floor_drainage' => array(
                    'label' => 'Drainage'
                ),
                'sub_floor_timber_framing' => array(
                    'label' => 'Timber Framing and Bracing'
                ),
                'sub_floor_fire_warning' => array(
                    'label' => 'Fire Warning System',
                    'has_input' => 1
                ),
                'sub_floor_water_supply' => array(
                    'label' => 'Water Supply'
                ),
                'sub_floor_drainage_system' => array(
                    'label' => 'Drainage System'
                ),
                'sub_floor_storm_water_system' => array(
                    'label' => 'Storm Water System'
                ),
                'sub_floor_sewer_system' => array(
                    'label' => 'Sewer System'
                ),
                'sub_floor_electrical_services' => array(
                    'label' => 'Electrical Services'
                )
            ),
        );
        $this->data['site_inspection_info'] = $site_inspection_info;

        $isPdf = isset($_GET['isPdf']) ? $_GET['isPdf'] : 0;
        if($isPdf){
            return view('pages/jobReportPdf', $this->data);
        }
        else{
            return view('main', $this->data);
        }
    }
    public function jobReportSiteInspection(){
        $id = $this->uri->segment(2);
        $r = array();
        if (!empty($_FILES)) {
            $dir = 'inspection_photo/' . $id . '/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, TRUE);
            }
            $success_upload = array();
            if (isset($_FILES['site_inspection_photo'])) {
                $file = $_POST['type'] . '_' . $id . '.' . substr(strrchr($_FILES['site_inspection_photo']['name'], '.'), 1);
                if (move_uploaded_file($_FILES['site_inspection_photo']['tmp_name'], $dir . $file)) {
                    $post = array(
                        'job_id' => $id,
                        'type' => $_POST['type'],
                        'dir' => $file
                    );

                    $itExist = count(\DB::table('tbl_job_site_inspection_photo')
                            ->where('job_id', '=', $id)
                            ->where('type', '=', $_POST['type'])
                            ->get()) > 0;
                    if($itExist){
                        \DB::table('tbl_job_site_inspection_photo')
                            ->where('job_id', '=', $id)
                            ->where('type', '=', $_POST['type'])
                            ->update($post);
                    }
                    else{
                        \DB::table('tbl_job_site_inspection_photo')
                            ->insert($post);
                    }

                    $r['success'] = 1;
                }
                else{
                    $r['error'] = 1;
                }
            }
        }

        echo json_encode($r);
    }
    public function jobReportOrientation($id){
        $r = array();
        if (!empty($_FILES)) {
            $dir = 'report/' . $id . '/';
            if(file_exists($dir)){
                $f = \File::allFiles($dir);
                foreach ($f as $file){
                    unlink($file);
                }
            }

            if (!is_dir($dir)) {
                mkdir($dir, 0777, TRUE);
            }

            $success_upload = array();
            if (isset($_FILES['property_image'])) {
                $file = $id . '.' . substr(strrchr($_FILES['property_image']['name'], '.'), 1);
                if (move_uploaded_file($_FILES['property_image']['tmp_name'], $dir . $file)) {
                    $post = array(
                        'property_image' => $file
                    );
                    \DB::table('tbl_job_detail')
                        ->where('id', '=', $id)
                        ->update($post);

                    $r['success'] = 1;
                }
                else{
                    $r['error'] = 1;
                }
            }
        }

        return response()->json($r);
    }

    //endregion

}
