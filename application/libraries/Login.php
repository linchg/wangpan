<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login
{
  	private $CI;
    public function __construct() {
        $this->CI =& get_instance();
    }	

    public function checkLogin($username, $password){
		$this->CI->load->database();
		$this->CI->load->model('user');
        $user = $this->CI->user->get($username, "username");
        if(empty($user)){
            return false;
        }
        if($user['password'] === md5(config_item('user_pass_prefix').$password)){
            return $user;
        }else{
            return false;
        }
    }
	
	public function is_login()
	{
        return $this->CI->session->userdata('id') ? true : false;
	} 

	public function get_user()
	{
		return array('username' => 'test');
	}

	public function login_out()
	{
		return true;
	}
}

