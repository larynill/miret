<?php

class old_main_model extends CI_Model{
    var $config;
    var $setting;

    function __construct(){
        parent::__construct();
        $this->resetValue();
    }

    function setSetting($setting){
        $this->setting = array_merge($this->setting, $setting);
    }

    function resetValue(){
        $this->config = array(
            'isSearch' => false,
            'is_enable' => false,
            'start' => 0,
            'per_page' => 10,
            'whatNum' => array('id'),
            'hasOrder' => false,
            'theOrder' => array(
                'what' => 'id',
                'order' => 'DESC'
            ),
            'isRandomized' => false,
            'limitRandomTo' => 1,
            "isDistinct" => false,
            'selectFields' => "",
            'isNoOr' => false,
            'isLastInsert' => false,
            'whatLastInsert' => 'ID',
            'isShift' => false,
            'connectorArray' => array(),
            'hasJoin' => false,
            'theJoin' => array(
                'table' => '',
                'join_field' => 'id',
                'source_field' => 'id',
                'type' => ''
            ),
            'isCount' => false
        );

        $this->setting = array(
            'username' => "root",
            'password' => "",
            'db' => ""
        );
    }

    function newdbcon($hostname = "localhost", $showError = TRUE){
        $config['hostname'] = $hostname;
        $config['username'] = $this->setting['username'];
        $config['password'] = $this->setting['password'];
        $config['database'] = $this->setting['db'];
        $config['dbdriver'] = "mysql";
        $config['dbprefix'] = "";
        $config['pconnect'] = FALSE;
        $config['db_debug'] = $showError;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = "";
        $config['char_set'] = "utf8";
        $config['dbcollat'] = "utf8_general_ci";

        $ps = $this->load->database($config, TRUE);
        return $ps;
    }

    function dataCleaner($data, $toClearData = true){
        $paretType = "";
        if(is_array($data) || is_object($data)){
            if(is_object($data)){
                $paretType = 'obj';
            }
            if(is_array($data)){
                $paretType = 'array';
            }

            if(count($data)>0){
                foreach($data as $k=>$v){
                    $type = "";
                    if(is_object($v)){
                        $type = 'obj';
                    }
                    if(is_array($v)){
                        $type = 'array';
                    }

                    switch($type){
                        case "obj":
                            $data->$k = $this->dataCleaner($v, $toClearData);
                            break;
                        case "array":
                            $data[$k] = $this->dataCleaner($v, $toClearData);
                            break;
                        default:
                            $thisVal = $this->security->xss_clean($v);
                            switch($paretType){
                                case "obj":
                                    $data->$k = $toClearData ? $this->stripHTMLtags($thisVal) : $thisVal;
                                    break;
                                case "array":
                                    $data[$k] = $toClearData ? $this->stripHTMLtags($thisVal) : $thisVal;
                                    break;
                                default:
                                    $data[$k] = $toClearData ? $this->stripHTMLtags($thisVal) : $thisVal;
                                    break;
                            }
                            break;
                    }
                }
            }
        }else{
            $data = addslashes($data);
            $thisVal = $this->security->xss_clean($data);
            $data = $toClearData ? $this->stripHTMLtags($thisVal) : $thisVal;
        }

        return $data;
    }

    function stripHTMLtags($str){
        $t = preg_replace('/<[^<|>]+?>/', '', htmlspecialchars_decode($str));
        $t = htmlentities($t, ENT_QUOTES, "UTF-8");
        return $t;
    }

    function lastid($db, $para = ''){
        if(!$para){
            $para = $this->db;
        }

        $q = $para->get($db);
        if($q->num_rows() > 0){
            foreach ($q->result() as $row){
                $id = $row->id;
            }
            return ($id);
        }
    }

    function insert($db,$data, $toClearData = true, $para = ''){
        $data = $this->dataCleaner($data, $toClearData);

        if(!$para){
            $para = $this->db;
        }
        $para->insert($db,$data);

        return $para->insert_id();
    }

    function insert_batch($db, $data, $para = ''){
        if(!$para){
            $para = $this->db;
        }

        $para->insert_batch($db, $data);
    }

    function update($db,$data,$id,$what = 'id', $toClearData = true, $para = ''){
        if(!$para){
            $para = $this->db;
        }

        $this->whereOptions($id, $what, $para);
        $data = $this->dataCleaner($data, $toClearData);
        $para->update($db, $data);

        return $para->insert_id();
    }

    function delete($db,$id,$what = 'id', $para = ''){
        if(!$para){
            $para = $this->db;
        }

        if(is_array($id)){
            $para->where_in($what, $id);
        }else{
            $para->where($what, $id);
        }

        $para->delete($db);
    }

    function getinfo($db,$id = '',$what = 'id', $para = ''){
        $whatorder = '';
        if(!$para){
            $para = $this->db;
        }

        if($this->config['hasOrder']){
            $whatorder = $this->config['theOrder']['what'];
            $order = $this->config['theOrder']['order'];
        }

        if($whatorder!=''){
            $whatNum = $this->config['whatNum'];
            if(in_array($whatorder,$whatNum)){
                $para->order_by('CAST(`'.$whatorder.'` AS UNSIGNED INTEGER)', $order);
            }else{
                $para->order_by($whatorder, $order);
            }
        }

        if($id!=''){
            if($what==''){
                $para->where($id);
            }else{
                $this->whereOptions($id, $what, $para);
            }
        }

        if($this->config['is_enable'] == true){
            $para->limit($this->config['per_page'], $this->config['start']);
        }

        if($this->config['selectFields']){
            $para->select($this->config['selectFields']);
        }
        if($this->config['isDistinct']){
            $para->distinct();
        }

        $para->from($db);
        if($this->config['hasJoin'] && $this->config['theJoin']['table']){
            if(is_array($this->config['theJoin']['table'])){
                foreach($this->config['theJoin']['table'] as $k=>$table_name){
                    $join_field = is_array($this->config['theJoin']['join_field']) ? $this->config['theJoin']['join_field'][$k] : $this->config['theJoin']['join_field'];
                    $source_field = is_array($this->config['theJoin']['source_field']) ? $this->config['theJoin']['source_field'][$k] : $this->config['theJoin']['source_field'];
                    $type = is_array($this->config['theJoin']['type']) ? $this->config['theJoin']['type'][$k] : $this->config['theJoin']['type'];

                    $join_query = $table_name . "." . $join_field . " = " . $source_field;
                    $para->join($table_name, $join_query, $type);
                }
            }else{
                $join_query = $this->config['theJoin']['table'] . "." . $this->config['theJoin']['join_field'] . " = " . $db . "." . $this->config['theJoin']['source_field'];
                $para->join($this->config['theJoin']['table'], $join_query, $this->config['theJoin']['type']);
            }
        }
        $query = $para->get();

        $data = "";
        if($this->config['isLastInsert']){
            if($query->num_rows() > 0){
                $last = $query->last_row('array');

                if($this->config['whatLastInsert']){
                    if(is_array($this->config['whatLastInsert'])){
                        $temp = array();
                        foreach($this->config['whatLastInsert'] as $k=>$v){
                            $temp[$v] = $last[$v];
                        }
                        $data = $temp;
                    }else{
                        $data = $last[$this->config['whatLastInsert']];
                    }
                }else{
                    $data = $last;
                }
            }
        }else if($this->config['isCount']){
            $data = $para->count_all_results($db);
        }else{
            $data = array();
            if($query->num_rows() > 0){
                if($this->config['isShift']){
                    $data = array_shift($query->result_array());
                }else{
                    foreach ($query->result() as $row){
                        $data[] = $row;
                    }
                }
            }

            $dataCount = count($data);
            if($dataCount>0){
                if($this->config['isRandomized'] && count($data) > $this->config['limitRandomTo']){
                    while(count($data) != $this->config['limitRandomTo']){
                        $randId = rand(0, $dataCount);
                        unset($data[$randId]);
                        sort($data);
                    }
                }
            }
        }
        $this->resetValue();

        return $data;
    }

    function whereOptions($id, $what, $para){
        if(is_array($id) && is_array($what)){
            if(count($what)>0){
                foreach($what as $k=>$v){
                    $isOk = false;
                    if($k!==0 && $this->config['isSearch']){
                        $isOk = true;
                    }

                    if(count($this->config['connectorArray'])>0){
                        $isOk = array_key_exists($k, $this->config['connectorArray']) ? $this->config['connectorArray'][$k] : $isOk;
                    }

                    $this->whereFunc($v,$id[$k],$para,$isOk);
                }
            }
        }else{
            if(is_array($what)){
                if(count($what)>0){
                    foreach($what as $k=>$v){
                        $isOk = false;
                        if($k!==0 && !$this->config['isNoOr']){
                            $isOk = true;
                        }
                        $this->whereFunc($v,$id,$para,$isOk);
                    }
                }
            }else{
                $this->whereFunc($what,$id,$para);
            }
        }
    }

    function getFields($db, $except = array(), $para = ''){
        if(!$para){
            $para = $this->db;
        }

        $fields = $para->list_fields($db);
        if(count($fields)>0){
            foreach($fields as $k=>$v){
                if(count($except)>0){
                    if(in_array($v, $except)){
                        unset($fields[$k]);
                    }
                }
            }
        }

        return $fields;
    }

    function whereFunc($what, $id, $para, $isOr = false){
        if($what){
            if(is_array($id)){
                if($isOr){
                    $para->or_where_in($what, $id);
                }else{
                    $para->where_in($what, $id);
                }
            }else if (is_string($id) && $this->config['isSearch'] == true) {
                if($isOr){
                    $para->or_like($what, $id);
                }else{
                    $para->like($what, $id);
                }
            }else{
                if($isOr){
                    $para->or_where($what, $id);
                }else{
                    $para->where($what, $id);
                }
            }
        }
    }

    function setNoOr($isNoOr = false){
        $this->config['isNoOr'] = $isNoOr;
    }

    function setConfig($per_page = 10, $start = 0, $is_enable = false){
        $this->config['is_enable'] = $is_enable;
        $this->config['start'] = $start;
        $this->config['per_page'] = $per_page;
    }

    function setWhatNum($whatNum, $append = true){
        if($append){
            $this->config['whatNum'][] = $whatNum;
        }else{
            $this->config['whatNum'] = $whatNum;
        }
    }

    function setOrder($what = 'id', $order = 'ASC', $isNumber = false){
        $this->config['hasOrder'] = true;
        $this->config['theOrder'] = array(
            'what' => $what,
            'order' => $order
        );

        if($isNumber){
            $this->setWhatNum($what);
        }
    }

    function setSearch($isSearch = false){
        $this->config['isSearch'] = $isSearch;
    }

    function setLastId($whatField, $isLastInsert = true){
        $this->config['isLastInsert'] = $isLastInsert;
        $this->config['whatLastInsert'] = $whatField;
    }

    function setShift($isShift = true){
        $this->config['isShift'] = $isShift;
    }

    function setDistinct($selectFields = "", $isDistinct = true){
        $this->setSelectFields($selectFields);
        $this->config['isDistinct'] = $isDistinct;
    }

    function setSelectFields($selectFields = ""){
        $this->config['selectFields'] = $selectFields;
    }

    function setConnectorArray($connectorArray = array()){
        $this->config['connectorArray'] = $connectorArray;
    }

    function setJoin($join_option = array()){
        $this->config['hasJoin'] = true;
        $this->config['theJoin'] = array_merge($this->config['theJoin'], $join_option);
    }

    function setForCount($isCount = true){
        $this->config['isCount'] = $isCount;
    }

    function mysqlstring($sql, $hasNoReturn = false){
        $query = $this->db->query($sql);

        if(!$hasNoReturn){
            $data = array();
            if($query->num_rows() > 0){
                foreach ($query->result() as $row){
                    $data[] = $row;
                }
            }
            return $data;
        }
    }

    function queryBinding($sql, $bind, $hasNoReturn = false){
        $query = $this->db->query($sql, $bind);

        if(!$hasNoReturn){
            $data = array();
            if($query->num_rows() > 0){
                foreach ($query->result() as $row){
                    $data[] = $row;
                }
            }
            return $data;
        }
    }

    function dataEscape($data){
        if(is_array($data)){
            if(count($data)>0){
                foreach($data as $k=>$v){
                    if(is_array($v)){
                        $v = $this->dataEscape($v);
                    }else{
                        $v = $this->db->escape($v);
                    }
                }
            }
        }else{
            $data = $this->db->escape($data);
        }

        return $data;
    }

    function randomizeReturn($isRandomized = false, $limitRandomTo = 1){
        $this->config['isRandomized'] = $isRandomized;
        $this->config['limitRandomTo'] = $limitRandomTo;
    }
}