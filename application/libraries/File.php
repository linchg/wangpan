<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class File
{
  	private $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }	

    /**
     * 创建一个目录，返回创建好的目录id
     *
     * @param $uid int 用户ID
     * @param $fid int 父目录的ID
     * @param $name string 目录的名字
     *
     * @return id 目录的id，false
     */
    public function create_directory($uid,$fid,$name){

        $this->CI->load->model('directory','',true);
        $max_depth = config_item('directory_depth');
        if(!$this->CI->directory->can_create($fid,$max_depth))
        {
            $this->CI->error->set_error('20301');
            return false;
        }
        $dirs = $this->CI->directory->get_children_dirs($uid,$fid);
        $names = array();
        foreach($dirs as $d)
            $names[] = $d['name'];
        if(in_array($name,$names))
        {
            $this->CI->error->set_error('20302');
            return false;
        }
        $values = array(
            'uid'=>$uid,
            'fid'=>$fid,
            'name'=>$name,
            'file_num'=>0,
            'add_time'=>time()
        );
        return $this->CI->directory->create($values);
    }

    /**
     * 重命名一个目录
     *
     * @param $uid int 用户ID
     * @param $id int 目录ID
     * @param $newname string 目录的新名字
     *
     * @return true/false
     */
    public function mv_directory($uid,$id,$new_name){

        $new_name = trim($new_name);
        $this->CI->load->model('directory','',true);
        $dir = $this->CI->directory->get_directory($id);
        if(empty($dir))
        {
            $this->CI->error->set_error('20303');
            return false;
        }
        if($dir['name'] == $new_name)
            return true;
        $dirs = $this->CI->directory->get_children_dirs($uid,$dir['fid']);
        $names = array();
        foreach($dirs as $d)
            $names[] = $d['name'];
        if(in_array($new_name,$names))
        {
            $this->CI->error->set_error('20302');
            return false;
        }
        return $this->CI->directory->update(array('name'=>$new_name),array('id'=>$id));
    }

    /**
     * 删除一个目录,删除目录，文件和子目录
     *
     * @param $uid int 用户ID
     * @param $id int 目录ID
     *
     * @return true/false
     */
    public function delete_directory($uid,$id){
        if($id == 0)
        {
            $this->CI->error->set_error('20306');
            return false;
        }
        $this->CI->load->model('directory','',true);
        $dir = $this->CI->directory->get_directory($id);
        if(empty($dir))
        {
            $this->CI->error->set_error('20303');
            return false;
        }
        //删除子目录
        $dirs = $this->CI->directory->get_children_dirs($uid,$id);
        foreach($dirs as $d)
            $this->delete_directory($d['id']);
        //删除文件
        $this->CI->load->model('file','',true);
        $this->CI->file->delete_files_by_did($uid,$id);
        //删除自己
        return $this->CI->directory->delete(array('id'=>$id));
    }

    /**
     * 重命名一个文件
     *
     * @param $id int 文件ID
     * @param $newname string 文件的新名字
     *
     * @return true/false
     */
    public function mv_file($id,$new_name){
        $this->CI->load->model('file','',true);
        $file = $this->CI->file->get_file($id);
        if(empty($file))
        {
            $this->CI->error->set_error('20304');
            return false;
        }
        $files = $this->CI->file->get_files_by_did($file['did']);
        $names = array();
        foreach($files as $f)
            $names[] = $f['name'];
        if(in_array($new_name,$names))
        {
            $this->CI->error->set_error('20305');
            return false;
        }
        return $this->CI->file->update(array('name'=>$new_name),array('id'=>$id));
    }

    /**
     * 创建一个文件
     *
     * @param $uid int 用户ID
     * @param $did int 目录ID
     * @param $name string 文件的名字
     * @param $size int 文件的大小
     *
     * @return true/false
     */
    public function create_file($uid,$did,$name,$size){
        $this->CI->load->model('file','',true);
        if($did > 0) //非根目录
        {
            $files = $this->CI->file->get_files_by_did($uid,$did);
            $names = array();
            foreach($files as $f)
                $names[] = $f['name'];
            if(in_array($name,$names))
            {
                $this->CI->error->set_error('20305');
                return false;
            }
        }
        $values = array(
            'uid'=>$uid,
            'did'=>$did,
            'name'=>$name,
            'size'=>$size,
            'add_time'=>time(),
            'add_ip'=>$this->CI->input->ip_address()
        );
        $ret = $this->CI->file->create($values);
        if($ret){
            $this->CI->load->model('directory','',true);
            if($this->CI->directory->set(array('file_num'=>'file_num + 1'),array('id'=>$did)))
                return true;
        }
        $this->CI->error->set_error('10000');
        return false;
    }

    /**
     * 删除一个文件
     *
     * @param $id int 文件ID
     *
     * @return true/false
     */
    public function delete_file($id){
        $this->CI->load->model('file','',true);
        $file = $this->CI->file->get_file($id);
        if(empty($file))
        {
            $this->CI->error->set_error('20304');
            return false;
        }
        $ret = $this->CI->file->delete(array('id'=>$id));
        if($ret)
        {
            $this->CI->load->model('directory','',true);
            if($this->CI->directory->set(array('file_num'=>'file_num - 1'),array('id'=>$id)))
                return true;
        }
        $this->CI->error->set_error('10000');
        return false;
    }
}
