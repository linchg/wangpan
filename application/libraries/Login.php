<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login
{
  	private $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }	

    public function reserveUserName($name){

        if (strtolower($name) === 'admin') 
            return true; 
        return ( preg_match("/^([0-9]{4,6}|(6|8|9){4,20}|(51|5)(8|9){3,8}|1(0){4,10})$/i", $name)) ? TRUE : FALSE;
    }

    public function checkLogin($username,$password){
        $this->CI->load->model('user','',true);
        $user = $this->CI->user->get($username,'username');
        if(empty($user)){
            return false;
        }

        if($user['password'] === md5(config_item('user_pass_prefix').$password))
            return $user;

        return false;
    }

    public function checkPassword($uid,$password,$user_data=array()){

        if(empty($user_data))
        {
            $this->CI->load->model('user','',true);
            $user = $this->CI->user->get($id);
            if(empty($user)){
                return false;
            }
        }
        if($user['password'] === md5(config_item('user_pass_prefix').$password))
            return $user;

        return false;
    }

    public function checkUserExist($username){

		$this->CI->load->model('user','',true);
        $user_data = $this->CI->user->get($username, 'username');
        if (count($user_data) === 0)
            return false; 
        return $user_data;
    }

    public function checkCaptcha($str){
        $capt = strtolower($this->CI->session->userdata('captcha_word'));
        if (strtolower($str) !== $capt){
            $this->form_validation->set_message('check_captcha', '%s 错误.');
            return false;
        }
        
        $this->CI->session->set_userdata('login_error_times', 0);
        return true;
    }

    public function getLoginBackUrl(){

        $tmpBackurl = $this->CI->session->userdata('http_referer');

        if ($tmpBackurl !== FALSE){
            $this->CI->session->unset_userdata('http_referer');
            return $tmpBackurl;
        }
        return '/user';
    }

    public function setLoginBackUrl(){

        if (!$this->CI->input->is_post())
        {
            // Set backurl.
            if (isset($_SERVER['HTTP_REFERER'])){
                $this->CI->session->set_userdata('http_referer', $_SERVER['HTTP_REFERER']);
            }
        }else{
            $tmpReferer = FALSE;
            switch ($this->input->post('login_path')) {
            case 'index':
                $tmpReferer = base_url('/');
                break;
            }

            if( $tmpReferer !== FALSE){
                $this->CI->session->set_userdata('http_referer', $tmpReferer);
            }
        }
    }
	
	public function is_login(){
        return $this->CI->session->userdata('id') ? true : false;
	} 

    public function updateUserLogin($uid){

        $uid = (int)$uid;
        if($uid <= 0)
            return false;

        $user_array = array(
            'login_ip' => $this->CI->input->ip_address(),
            'login_time' => time(),
        );
		$this->CI->load->model('user','',true);
        return $this->CI->user->update($user_array, array('id' => $uid));
    }

    public function unsetUserCookie(){
        $domain = config_item('cookie_domain');
        $this->CI->input->set_cookie('uid', '', '', $domain);
        $this->CI->input->set_cookie('token', '', '', $domain);
        $this->CI->input->set_cookie('lastuname', '', '', $domain);#最后登录用户名
    }

    public function setUserCookie($user_data,$autologin=false){

        $domain = config_item('cookie_domain');
        $sign_key = config_item('sign_key');

        if( $autologin ){
            $this->CI->input->set_cookie('token', md5($user_data['id'].$user_data['password'].$sign_key), 3600*12, $domain);
        }
        $this->CI->input->set_cookie('uid', $user_data['id'], 3600*24*7, $domain);
        $this->CI->input->set_cookie('lastuname', $user_data['username'], 3600*24*7, $domain);#最后登录用户名
    }

    public function unsetUserSession(){

        $user_data = array(
            'id' => '',
            'email' => '',
            'mobile' => '',
            'username' => ''
        );
        return $this->CI->session->unset_userdata($user_data);
    }

    public function setUserSession($user_data) {

        if(!is_array($user_data))
            return false;

        $user_data['login_error_times'] = 0;

        // 处理：日志，活跃用户。
        $this->load->helpers('date');
        $tmpTimeEnd = human_to_unix(mdate('%Y-%m-%d', time()).' 0:0:0');
        $tmpTimeStart = $tmpTimeEnd - 24*3600;

        if ( $user_data['create_time'] >= $tmpTimeStart AND $user_data['create_time'] <= $tmpTimeEnd ){
            $user_data['regtime'] = $user_data['create_time'];
        }

        return $this->CI->session->set_userdata($user_data);
    }

	public function get_user($id,$session=true) {
        if($session && $this->CI->session->userdata('id'))
            return $this->CI->session->all_userdata();

        $this->CI->load->model('user','',true);
        return $this->CI->user->get($id);
	}

	public function login_out() {
        $this->unsetUserCookie();
        $this->unsetUserSession();
        return true;
	}
}

