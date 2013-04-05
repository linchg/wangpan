<?php

class Directory extends CI_Model {

    private $_table_name;

    function __construct()
    {
        parent::__construct();
        
        $this->_table_name = 'directory';
    }

    //获取一个目录的所有子目录
    public function get_children_dirs($uid,$id){
        $id = intval($id);
        if($id <= 0)
            return array(); 
        $where = array('fid'=>$id,'uid'=>$uid);
        $query = $this->db->get_where($this->_table_name,$where);
        return $query->result_array();
    }

    //获得一个用户所创建的所有目录
   public function getCount($uid,$where=array()){
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

    //获取一个用户目录的信息
    public function get($uid,$where=array(),$order_by=''){
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

    //获取一个目录的具体信息
    public function get_directory($id){
        $id = (int)$id;
        if($id <= 0)
            return array(); 
        $where = array('id' => $id);
        $query = $this->db->get_where($this->_table_name, $where);
        return $query->row_array();
    }

    //判断当前目录下还能否建立子目录
    //$id 当前目录id
    //$max_depth 运行的最多层数
    public function can_create($id,$max_depth){
        for($i = 1; $i < $max_depth; $i++)
        {
            $row = $this->get_directory($id);
            if(empty($row))
                return false;
            if($row['fid'] == 0) 
                return true;
            $id = $row['fid'];
        }
        return false; 
    }

    //创建一个目录
    public function create($values){

        if (!isset($values['uid']) || !isset($values['fid']))
            return false;
        $this->db->insert($this->_table_name, $values);
        return $this->db->insert_id();
    }

    //修改一个目录
    public function update($value_array, $where){

        if (!isset($where['uid']) && !isset($where['id']))
            return false;
        if(isset($where['uid']) && !isset($where['did']))
            return false;

        $this->db->where($where);
        return $this->db->update($this->_table_name, $value_array);
    }

    //删除一个目录
    public function delete($where){
        
        if (!isset($where['id']) )
            return false;

        $this->db->where($where);
        return $this->db->delete($this->_table_name);
    }

    function set($up_array, $where){
        if (!isset($where['id']))
            return false;

        $this->db->where($where);
        foreach($up_array as $k => $v)
            $this->db->set($k,$v,false);
        return $this->db->update($this->_table_name);
    }
}

/* end of file */
