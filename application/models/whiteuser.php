<?php

class Whiteuser extends CI_Model {

    private $_table_name;

    function __construct()
    {
        parent::__construct();
        $this->_table_name = 'whiteuser';
    }

    function get($value, $field = 'id'){
        if(!in_array($field,array('id','username')))
            return array(); 

        $where = array($field => $value);
        $query = $this->db->get_where($this->_table_name, $where);
        return $query->row_array();
    }

    function create($user_array){
        $this->db->insert($this->_table_name, $user_array);
        return $this->db->insert_id();
    }

    function update($user_array, $where){

        if (!isset($where['username']) && !isset($where['id']))
            return false;

        $this->db->where($where);
        return $this->db->update($this->_table_name, $user_array);
    }

    function delete($where){
        
        if (!isset($where['username']) && !isset($where['id']))
            return false;
        
        $this->db->where($where);
        return $this->db->delete($this->_table_name);
    }
}

/* end of file */
