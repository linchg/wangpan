<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login
{
  	private $CI;
    public function __construct() {
        $this->CI =& get_instance();
    }	

    public function checkLogin($username, $password){
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

	public function get_user($id,$session=true)
	{
        if($session && $this->CI->session->userdata('id'))
            return $this->CI->session->all_userdata();

        $this->CI->load->model('user');
        return $this->CI->user->get($id);
	}

	public function login_out()
	{
        $domain = config_item('cookie_domain');
        $tmpUid = $this->CI->session->userdata('id');
        $user_data = array(
            'id' => '',
            'email' => '',
            'mobile' => '',
            'username' => ''
        );
        $this->CI->session->unset_userdata($user_data);

        $this->CI->input->set_cookie('uid', '', '', $domain);
        $this->CI->input->set_cookie('token', '', '', $domain);
	}
}

