<?php

class Exchange extends CI_Model {

    private $_table_name;

    function __construct()
    {
        parent::__construct();
        
        $this->_table_name = 'downloads';
    }

    function changeState($id,$state)
    {
        $id = (int)$id;
        if($id <= 0)
            return false;
        $state = (int)$state;
        if($state <= 0)
            return false;

        return $this->update(array('state'=>$state),array('id'=>$id));
    }

    function get($uid,$where=array(),$order_by='',$limit = 10){
        $uid = (int)$uid;
        if($uid <= 0)
            return array(); 
        if(!isset($where['uid']))
            $where['uid']  =$uid;
        if(empty($order_by))
            $order_by = 'add_time desc';
        $this->db->order_by($order_by);
        $this->db->limit($limit);
        $query = $this->db->get_where($this->_table_name, $where);
        return $query->result_array();
    }

    function create($values){

        if (!isset($values['uid']) || !isset($values['item_id']))
            return false;
        $this->db->insert($this->_table_name, $values);
        return $this->db->insert_id();
    }

    function update($value_array, $where){

        if (!isset($where['uid']) && !isset($where['id']))
            return false;
        if(isset($where['uid']) && !isset($where['item_id']))
            return false;

        $this->db->where($where);
        return $this->db->update($this->_table_name, $value_array);
    }

    function delete($where){
        
        if (!isset($where['uid']) && !isset($where['id']))
            return false;
        if(isset($where['uid']) && !isset($where['item_id']))
            return false;

        $this->db->where($where);
        return $this->db->delete($this->_table_name);
    }
}

/* end of file */
