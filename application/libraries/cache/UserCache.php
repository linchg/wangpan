<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//用户登录名做cache
class UserCache
{
  	private $CI;
	private $_key = 'user_';
	private $_time ;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->driver('cache');
        $this->_time = 30 * 24 * 3600;
    }	

    //获取
    public function get_user($username){
        if(empty($username))
            return false;
        $user = $this->CI->cache->memcached->get($this->_key.$username);
        $user['uid'] = $user['id'];
        if(!$user)
        {
            $this->CI->load->model('user','',true);
            $user = $this->CI->user->get($username , 'username');  			
            if(!$user)
                return false;
            $this->CI->cache->memcached->save($this->_key.$username,$user,$this->_time);
        }
        return $user;
    }

    //更新
    public function update_user($username,$updates){
        if(empty($username) || empty($updates))
            return true;
        $this->CI->load->model('user','',true);
        $ret = $this->CI->user->update($updates,array('username'=>$username));
        if($ret)
            $this->CI->cache->memcached->delete($this->_key.$username);
        return $ret;
    }

    //清理cache
    public function delete_user_cache($username){
        return $this->CI->cache->memcached->delete($this->_key.$username);
    }
}
