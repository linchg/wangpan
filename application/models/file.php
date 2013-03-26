<?php

class File extends CI_Model {

    private $_table_name;

    function __construct()
    {
        parent::__construct();
        
        $this->_table_name = 'file';
    }

    function addDownTimes($id,$num=1)
    {
        $num = (int)$num;
        if($num <= 0 || $id <= 0 )
            return false;
        return $this->set(array('down_times'=>'down_times + ' . $num),array('id'=>$id));
    }

    function getCount($uid,$where=array()){
        $uid = (int)$uid;
        if($uid <= 0)
            return false;
        $this->db->where('uid',$uid);
        if(!empty($where))
            foreach($where as $k => $v)
                $this->db->where($k,$v);
        $this->db->from($this->_table_name);
        return $this->db->count_all_results();
    }

    function get($uid,$where=array(),$order_by=''){
        $uid = (int)$uid;
        if($uid <= 0)
            return array(); 
        if(!isset($where['uid']))
            $where['uid']  =$uid;
        $query = $this->db->get_where($this->_table_name, $where);
        if(empty($order_by))
            $order_by = 'add_time desc';
        $this->db->order_by($order_by);
        return $query->result_array();
    }

    function create($values){

        if (!isset($values['uid']) || !isset($values['did']) || !isset($values['name']))
            return false;
        $this->db->insert($this->_table_name, $values);
        return $this->db->insert_id();
    }

    function set($value_array, $where){

        if (!isset($where['id']))
            return false;

        $this->db->where($where);
        foreach($value_array as $k => $v)
            $this->db->set($k,$v,false);
        return $this->db->update($this->_table_name);
    }

    function update($value_array, $where){

        if (!isset($where['uid']) && !isset($where['id']))
            return false;
        if(isset($where['uid']) && !isset($where['name']))
            return false;

        $this->db->where($where);
        return $this->db->update($this->_table_name, $value_array);
    }

    function delete($where){
        
        if (!isset($where['uid']) && !isset($where['id']))
            return false;
        if(isset($where['uid']) && !isset($where['name']))
            return false;

        $this->db->where($where);
        return $this->db->delete($this->_table_name);
    }
}

/* end of file */
