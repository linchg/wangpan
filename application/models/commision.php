<?php

class Commision extends CI_Model {

    private $_table_name;

    function __construct()
    {
        parent::__construct();
        
        $this->_table_name = 'commision';
    }

    function addIncome($uid,$money)
    {
        $money = (float)$money;
        if($money <= 0 || $uid <= 0 )
            return false;
        return $this->set(array('income'=>'income + ' . $point),array('uid'=>$uid));
    }

    function decIncome($uid,$money)
    {
        $money = (float)$money;
        if($money <= 0 || $uid <= 0 )
            return false;
        return $this->set(array('income'=>'income - ' . $money),array('uid'=>$uid));
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

    function get($uid,$where=array()){
        $uid = (int)$uid;
        if($uid <= 0)
            return array(); 
        if(!isset($where['uid']))
            $where['uid']  =$uid;
        $query = $this->db->get_where($this->_table_name, $where);
        return $query->result_array();
    }

    function create($values){
        $this->db->insert($this->_table_name, $values);
        return $this->db->insert_id();
    }

    function set($value_array, $where){

        if (!isset($where['uid']) && !isset($where['id']))
            return false;

        $this->db->where($where);
        foreach($value_array as $k => $v)
            $this->db->set($k,$v,false);
        return $this->db->update($this->_table_name);
    }

    function update($value_array, $where){

        if (!isset($where['uid']) && !isset($where['id']))
            return false;

        $this->db->where($where);
        return $this->db->update($this->_table_name, $value_array);
    }

    function delete($where){
        
        if (!isset($where['uid']) && !isset($where['id']))
            return false;
        
        $this->db->where($where);
        return $this->db->delete($this->_table_name);
    }
}

/* end of file */
