<?php

class Points extends CI_Model {

    private $_table_name;

    function __construct()
    {
        parent::__construct();
        
        $this->_table_name = 'points';
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

        if (!isset($values['pid']) ||!isset($values['uid']) )
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
