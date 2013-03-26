<?php

class Withdraw extends CI_Model {

    private $_table_name;

    function __construct()
    {
        parent::__construct();
        
        $this->_table_name = 'withdraw';
    }

    function setState($id,$state){
        $id = (int)$id;
        if($id <= 0)
            return false;
        $state = (int)$state;
        if($state <= 0)
            return false;
        return $this->update(array('state'=>$state),array('id'=>$id));
    }

    function getCount($where=array()){

        if(!empty($where))
            foreach($where as $k => $v)
                $this->db->where($k,$v);
        $this->db->from($this->_table_name);
        return $this->db->count_all_results();
    }

    function get($where=array(),$order_by=''){

        $query = $this->db->get_where($this->_table_name, $where);
        if(empty($order_by))
            $order_by = 'add_time desc';
        $this->db->order_by($order_by);
        return $query->result_array();
    }

    function create($values){

        if (!isset($values['uid']) ||!isset($values['sum']) )
            return false;
        $this->db->insert($this->_table_name, $values);
        return $this->db->insert_id();
    }

    function update($value_array, $where){

        if (!isset($where['id']))
            return false;

        $this->db->where($where);
        return $this->db->update($this->_table_name, $value_array);
    }

    function delete($where){
        
        if (!isset($where['id']))
            return false;

        $this->db->where($where);
        return $this->db->delete($this->_table_name);
    }
}

/* end of file */
