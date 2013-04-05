<?php

class Checkin extends CI_Model {

    private $_table_name;

    function __construct()
    {
        parent::__construct();
        $this->_table_name = 'checkin';
    }

    //获取用户今天签到的唯一记录
    function get($uid){
        $uid = intval($uid);
        if($uid <= 0)
            return array();

        $time = time();
        $today = strtotime(date('Ymd',$time));
        $end = $today + 24 * 3600;
        $where = array('add_time >=' => $today,'add_time <' => $end);
        $query = $this->db->get_where($this->_table_name, $where);
        return $query->row_array();
    }

    //创建用户今天签到
    //$user_array('id'=> 1,'add_ip'=>'127.0.0.1')
    function create($user_array){

        if(!isset($user_array['uid']) && !isset($user_array['add_ip']))
            return false;

        $uid = intval($user_array['uid']);
        if($uid <= 0)
            return false;

        $row = $this->get($uid);
        if(!empty($row))
            return true;

        $user_array['add_time'] = time();
        $this->db->insert($this->_table_name, $user_array);
        return $this->db->insert_id();
    }

    function update($user_array, $where){

        if (!isset($where['uid']))
            return false;

        $this->db->where($where);
        return $this->db->update($this->_table_name, $user_array);
    }

    function delete($where){
        
        if (!isset($where['uid']))
            return false;
        
        $this->db->where($where);
        return $this->db->delete($this->_table_name);
    }
}

/* end of file */
