<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login
{
  	private $CI;
	private $_session_key = 'user';
	private $_cookie_key = array(
		'uid' => 'uid' , 'token' => 'token' , 'lastuname' => 'username'
	);
    public function __construct() {
        $this->CI =& get_instance();
    }	

	//是否登录
	public function is_login() {
		$uid = get_cookie('uid'); //uid
		$token = get_cookie('token');//token
		$user_info = $this->get_login_user(); 
		if(!empty($user_info['username']) && $token == $user_info['token'] && $uid == $user_info['uid']) {
			//判断用户是否登录超时
			$current_ts = time();
			if(empty($user_info['login_ts'])
					|| $current_ts - $user_info['login_ts'] > $this->CI->wangpan->get('login_expire')) {
				$this->clear_user_login();
				return false;
			}
			$user_info['login_ts'] = $current_ts;
			$this->CI->session->set_userdata($this->_session_key , $user_info);
			return true;
		}
		$this->clear_user_login();
		return false;
	}	

	//清理session与cookie
	public function clear_user_login($destroy = false)
	{
		foreach($this->_cookie_key  as $key => $value)
		{
			delete_cookie($key);
		}
		if ($destroy)
		{
			$this->CI->session->sess_destroy();
			return;
		}
		$this->CI->session->unset_userdata($this->_session_key);
	}

	//验证token
	public function get_sig($loginname , $pwd)
	{
		$fields = array('username' => $loginname , 'password' => $pwd); 
		$sig_token = $this->CI->utility->get_md5_sig($fields);
		return $sig_token;	
	}
	
	//获取当前在线用户
	public function get_login_user()
	{
		return $this->CI->session->userdata($this->_session_key);
	}

	//验证登录用户
	public function validate($loginname , $password , $site_id = '0000')
	{
		log_scribe('trace', 'login', $this->CI->input->ip_address().' ['.current_url().'] LOGIN '.$loginname.', '.$this->CI->utility->mosaic($password).', '.$this->CI->input->ip_address().', '.$site_id);	
       $pwd = $this->CI->utility->get_pwd_md5($pwd);//验证密码
		if ($pwd == false) return false;
		$this->CI->load->library('cache/UserCache');
		$row = $this->CI->userCache->get_user($loginname); 
		if (empty($row)) {
			$this->CI->error->set_error(20121);
			return false;
		} 
		if ($row['password'] != $pwd)
		{
			$this->CI->error->set_error(20122);
			return false;
		}
		$this->update_last_time($row['uid']);
		$this->user_login($row);
		return $row;
	}
	
	//登录设置	
	public function user_login($user)
	{
		if(empty($user))
		{
			$this->CI->error->set_error(20122);
			return false;
		}	
		$token = $this->get_sig($user['username'] , $user['password']);
		$session_data = array(
			'username' => $user['username'],
			'uid' => $user['uid'],
			'token' => $token,
			'nickname' => $user['nickname'],
			'login_ts' => time(),
		);
		$this->CI->session->set_userdata($this->_session_key , $session_data);
		foreach($this->_cookie_key as $key => $value)
		{
			$cookie = array(
					'name'   => $key,
					'value'  => $session_data[$value],
					'expire' => '0',
					);
			set_cookie($cookie);
		}
		unset($cookie , $session_data);
	}
	
	//更新最后登录时间/ip
	public function update_last_time($uid)
	{
		$user_array = array(
            'login_ip' => $this->CI->input->ip_address(),
            'login_time' => time(),
        );
		$this->CI->load->model('user','',true);
        return $this->CI->user->update($user_array, array('id' => $uid));
	}
	
	//用户退出
	public function user_exit()
	{
        $this->clear_user_login(true);	
	}
	
	//验证用户是否在黑名单里面
	public function check_user_black($username)
	{
        $this->CI->load->model('blackuser','',true);
        $user = $this->CI->blackuser->get($username,'username');
        if($user)
        {
            $this->CI->error->set_error('20103');
            return true;
        }
        return false;
	}

    public function check_captcha($captcha){
        if(empty($captcha))
            return false;
        $this->CI->load->library('Kcaptcha');
        if(!$this->CI->kcaptcha->verify(array('captcha'=>$captcha))) 
        {
            $this->CI->error->set_error('20101');
            return false;
        }
        return true;
    }

    public function check_user_exist($userename){
		$this->CI->load->model('user','',true);
        $user = $this->CI->user->get($username,'username');
        return empty($user) ? false : true;
    }

    public function check_email_exist($email){
		$this->CI->load->model('user','',true);
        $user = $this->CI->user->get($email,'email');
        return empty($user) ? false : true;
    }

    //登录出现错误后，退回url
    public function before_login(){
        if (isset($this->CI->input->server('HTTP_REFERER',true))){
            redirect($this->CI->input->server('HTTP_REFERER',true));
        }
        redirect(site_url('/'));
    }

    //登录正确后，进入url
    public function after_login(){
        $login_path = $this->CI->input->post('login_path');
        if(!empty($login_path))
            redirect(site_url($login_path));
        redirect(site_url('user'));
    }
}

