<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth extends MY_Controller {

    function __construct()
    {
        parent::__construct(false);
        $this->load->library('form_validation');
    }

    /*
     * 处理登录,get_post请求
     * username,password
     * captcha 3次以上出的水印输入
     * login_path 可选 标识登陆后返回地址
    */
    public function login()
    {
        if($this->login->is_login()) 
            redirect('user/'); 
        $username = $this->input->get_post('username',true);
        if($this->login->check_user_black($username))
            $this->login->before_login();
        $errors = intval($this->session->userdata('login_error_times'));
        if ($errors >= 3){
            if(!$this->login->check_captcha($this->input->get_post('captcha'))){
                $this->login->before_login();
            }
        }

        $this->form_validation->set_rules('username', '帐号', 'trim|required|min_length[4]|max_length[20]|alpha_numeric');
        $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[20]');
        if ($this->form_validation->run()){

            if($this->login->validate($username,$this->input->get_post('password',true)))
                $this->login->after_login();
        }
        //登录错误
        $this->session->set_userdata('login_error_times', intval($this->session->userdata('login_error_times'))+1);
        $this->login->before_login();
    }
    
    public function ajax_login() {

        $username = trim($this->input->get("username"),true);
        $password = trim($this->input->get('password'),true);

        $user = $this->login->checkLogin($username, $password);
        if ($user) {
            $this->login->updateUserLogin($user['id']);
            $this->login->setUserSession($user);
            $this->login->setUserCookie($user,$this->input->get('autologin') == 'yes');

            echo $_GET['callback'] . "(" . json_encode(array('status' => 'success')) . ")";
        } else {
            echo $_GET['callback'] . "(" . json_encode(array('status' => 'error')) . ")";
        }
    }
    
    public function logout()
    {
        $this->userExit();
    }

    public function register()
    {
        $this->title = '兴趣盘－注册用户';
        $this->template->set_static(array('static/js/register.js' , 'static/js/mail.tip.js'));
        $this->template->set_static(array('static/css/index.css') , SERVICE_NUMBER::CSSFILE , SERVICE_NUMBER::FILEHEADER);
        $this->template->set_menu();
        $this->template->load_view('default' , 'register');			
    }
    
    public function do_register()
    {
        if($this->login->is_login()) 
            redirect('user/'); 
        $ret = $this->input->get_post('servitems');
        var_dump($ret);
        exit;

        $this->form_validation->set_rules('username', '帐号', 'trim|required|min_length[5]|max_length[20]|alpha_numeric');
        $this->form_validation->set_rules('petname', '网盘名称', 'trim|required|min_length[5]|max_length[20]|alpha_numeric');
        $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[5]|max_length[20]');
        $this->form_validation->set_rules('passwordconfirm', '确认密码', 'required|matches[password]');
        $this->form_validation->set_rules('email', '电子邮件', 'trim|required|valid_email');

        if ($this->form_validation->run() === TRUE){
            // for table: user
            $user_array = array(
                'username' => $this->input->get_post('username',true),
                'password' => $this->utility->get_pwd_md5($this->input->get_post('password',true)),
                'petname' => $this->input->get_post('petname',true),
                'email' => $this->input->get_post('email',true),
                'nickname' => $this->input->get_post('nickname',true),
                'create_time' => time(),
                'create_ip' => $this->input->ip_address(),
                'login_time' => time(),
                'login_ip' => $this->input->ip_address(),
            );
            $userid = $this->user->create($user_array);
            $user_array['id'] = $userid;
            $this->login->setUserSession($user_array);
            $this->login->setUserCookie($user_array,false);
            redirect($this->login->getLoginBackUrl());
        }
    }

    public function ajax_register() {
        $this->load->model('user');
        $username = htmlspecialchars(trim($this->input->get("username")));
        $password = htmlspecialchars(trim($this->input->get('password')));

        if(strlen($username) < 4 OR strlen($username) > 20){
            $this->_doJsonCallback(array('status' => 'error1'));
            exit;
        }
        
        if(strlen($password) < 6 OR strlen($password) > 20){
            $this->_doJsonCallback(array('status' => 'error2'));
            exit;
        }
        
        if (!$this->form_validation->alpha_numeric($username)){
            $this->_doJsonCallback(array('status' => 'error3'));
            exit;
        }

        if (!$this->check_user_register($username)){
            $this->_doJsonCallback(array('status' => 'error4'));
            exit;
        }
        
        $user_array = array(
            'username' => $username,
            'password' => $this->login->getPassword($password),
            'create_time' => time(),
            'create_ip' => $this->input->ip_address(),
            'login_time' => time(),
            'login_ip' => $this->input->ip_address(),
            'email' => '',
            'mobile' => '',
        );
        $userid = $this->user->create($user_array);
        $user_array['id'] = $userid;
        $this->login->setUserSession($user_array);
        $this->login->setUserCookie($user_array,false);
        
        // Fuck IE!!! By Wangyu.
        $tmpJsonData = array(
            'status'=>'success',
            'uid'=>$userid,
            'token'=>$this->login->getLoginToken($userid,$user_array['password'])
        );
        
        $this->_doJsonCallback($tmpJsonData);
    }


    public function sendmobile()
    {
        $this->load->library('sendmobile');
        if (strlen($this->session->userdata('mobile')) == 11 ){

            if ($this->session->userdata('mobile_checkcode')){
                $tmpRandomCode = $this->session->userdata('mobile_checkcode');
            }else{
                $tmpRandomCode = mt_rand(1000, 9999);
            }

            $this->session->set_userdata(array('mobile_checkcode' => $tmpRandomCode));

            $tmpRe = $this->sendmobile->doSendSMS($this->session->userdata('mobile'), '您的短信验证码为：'.$tmpRandomCode.' [XY游戏 http://www.xy.com]');

            echo $tmpRe;
            exit;
        }
    }

    public function checkcode(){
        if( intval($this->session->userdata('checkcode_error_times')) > 10 ){ echo 'false'; exit; }
            if($this->check_mobile_checkcode($this->input->get('checkcode'))){
                echo 'true';
                $this->session->set_userdata('_forgotpass_mobile_check', 'yes');
            }else{
                echo 'false';
                $this->session->set_userdata('_forgotpass_mobile_check', 'no');
                $this->session->set_userdata('checkcode_error_times', intval($this->session->userdata('checkcode_error_times'))+1);
            }
        exit;
    }

    public function mobilesetpass(){ 

        if( $this->session->userdata('_forgotpass_mobile_check') == 'yes' ){
            $time = time();
            $sign = md5($this->session->userdata('_username') . $time . $this->config->config['sign_key']);
            $url = site_url('auth/resetpass?username='.$this->session->userdata('_username').'&time='.$time.'&sign='.$sign);
            redirect($url);
        }

        redirect('/');
    }

    public function resetpass(){
    }

    public function forgetpass($type=false)
    {
        if($this->login->is_login())
            redirect('account/'); 

        $this->load->model('user');
        $this->load->helper('string');

        $resp = array();
        $step = $this->session->userdata('_step');
        if (!$step){ $step = 1; }

        if ($this->input->is_post()){
            $this->form_validation->set_error_delimiters('<div for="%s" class="ui-reg-info ui-reg-info-error ml8"><span><em>','</em></span></div>');

            $this->form_validation->set_rules('username', '帐号', 'trim|required|min_length[4]|max_length[20]|alpha_numeric|callback_check_user_exist');
            if ($this->form_validation->run() === TRUE){
                $tmpAryData = array(
                    'email' => $this->user_data['email'],
                    'mobile' => $this->user_data['mobile'],
                    '_username' => $this->user_data['username'],
                    '_forgotpass' => 'yes',
                );
                $this->session->set_userdata($tmpAryData);
                $this->session->set_userdata('_step', $step++);
                redirect('auth/forgetpass');
            }else{
                $this->session->unset_userdata('_step');
                redirect('auth/forgetpass');
            }
        }

        if ($type){
            if($this->session->userdata('_forgotpass') !== 'yes' ){
                $this->session->unset_userdata('_step');
                redirect('auth/forgetpass');
            }else{
                $step++;
            }
        }

        if($step == 3){
            if ($type=='email'){
                $this->login->sendResetPassMail();
            }elseif($type='mobile'){
                $this->login->sendResetMobile();
            }
            $step++;
        }

        $this->session->set_userdata('_step',$step);
        $this->display('auth/forgetpass', $resp);
    }

    //callback
    public function check_password($password){
        $uid = $this->session->userdata('id');
        $user = $this->login->checkPassword($uid,$password,$this->user_data);
        if(!$user)
        {
            $this->form_validation->set_message('check_password', '%s 错误.');
            return false;
        }
        if (!is_array($this->user_data))
            $this->user_data = $user;
        return true;
    }

    public function check_email_exist($str){
        if (!$this->_check_email_exist($str)){
            $this->form_validation->set_message('check_email_exist', '%s 不存在.');
            return false;
        }
        return true;
    }

    public function check_email_checkcode($str){
        $this->user_data = $this->user->get($this->session->userdata('id'));
        if (count($this->user_data) === 0){ return false; }
        $tmpCheckCode = $this->user_data['email'];
        if ($str !== $tmpCheckCode){
            $this->form_validation->set_message('check_email_checkcode', '%s 校验错误.');
            return false;
        }
        return true;
    }
    
    public function check_mobile_checkcode($str){
        $tmpCheckCode = $this->session->userdata('mobile_checkcode');
        if (intval($str) !== $tmpCheckCode){
            $this->form_validation->set_message('check_mobile_checkcode', '%s 校验错误.');
            return false;
        }
        return true;
    }
    
    /**
     * ajax validate 
     */
    public function check(){
		$secure = $this->secure->invoke(SERVICE_NUMBER::SECURE_CTR);
        $type = $this->input->get_post('type',true);
		$type = intval($type);
        switch($type){
        case 1:
            $username = $this->input->get_post('username',true);
            if(!$this->utility->chk_username_exists($username))
			{
                $this->successOutput(array('username' => $username));
			}
            else
			{
                $this->errorOutput();
			}
            break;
        case 'petname':
            $petname = $this->input->get_post('petname',true);
            if(!$this->login->check_petname_exist($petname))
                $this->ajaxOutput(SERVICE_NUMBER::AJAX_SUCCESS);
            else
                $this->ajaxOutput(SERVICE_NUMBER::AJAX_ERROR);
            break;
        case 'email':
            $email = strip_tags($this->input->get_post('email'));
            if(!$this->login->check_email_exist($email))
                $this->ajaxOutput(SERVICE_NUMBER::AJAX_SUCCESS);
            else
                $this->ajaxOutput(SERVICE_NUMBER::AJAX_ERROR);
            break;
        case 'nemail':
            $email = strip_tags($this->input->get('email'));
            if($this->_check_email_exist($email)) die("true"); else die("false");
        case 'cap':
            $captcha = strip_tags($this->input->get('captcha'));
            $capt = strtolower($this->session->userdata('captcha_word'));
            if($captcha == $capt) die("true"); else die("false");
        case 'nname':
            $username = strip_tags($this->input->get('username'));
            if($this->_check_user_exist(strtolower($username))) die("true"); else die("false");
        case 'cpasswd':
            $password = strip_tags($this->input->get('oldpass'));
            if($this->check_password($password)) die("true"); else die("false");
        case 'ccpasswd':
            $password = strip_tags($this->input->get('oldpass'));
            if($this->check_child_password($password)) die("true"); else die("false");
        }
    }

    
    public function check_username_format($str){
        if ( $this->form_validation->valid_email($str) OR $this->form_validation->alpha_numeric($str) ){ return true; }
        $this->form_validation->set_message('check_username_format', '%s 格式只能是邮箱或英文数字.');
        return false;
    }
    
    
    public function check_email_register($str){
        if ($this->_check_email_exist($str)){
            $this->form_validation->set_message('check_email_register', '%s 已经存在.');
            return false;
        }
        return true;
    }
    
    private function _check_email_exist($str){
        $this->user_data = $this->user->get($str, 'email');
        if (count($this->user_data) === 0){ return false; }
        return true;
    }

    private function _doJsonCallback($strAry){
        echo $_GET['jsoncallback'] . "(" . json_encode($strAry) . ")";
    }
}

/* End of file  */
