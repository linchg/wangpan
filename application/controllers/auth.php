<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller {

    private $user_data;

    function __construct()
    {
        parent::__construct(false);
        $this->load->library('form_validation');
    }

    public function login()
    {
        $this->form_validation->set_error_delimiters('<span class="login-errorinfo">','</span>');

        if($this->login->is_login()) 
            redirect('user/'); 

        $this->login->setLoginBackUrl();

        if ($this->input->is_post()){

            $this->load->model('user');
            $tmpLoginErrorTimes = intval($this->session->userdata('login_error_times'));

            if ($tmpLoginErrorTimes >= 3){
                $tmpRe = $this->login->checkCaptcha($this->input->post('captcha'));
                if ($tmpRe === FALSE){
                    $this->form_validation->error('captcha','','','验证码 错误');
                }
            }
            $this->form_validation->set_rules('username', '帐号', 'trim|required|min_length[4]|max_length[20]|alpha_numeric|callback_check_user_exist');
            $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[20]|callback_check_password');
            $tmpRe = $this->form_validation->run();

            if ($tmpRe === TRUE){
                $this->login->updateUserLogin($this->user_data['id']);
                $this->login->setUserSession($this->user_data);
                $this->login->setUserCookie($this->user_data,$this->input->post('autologin') == 'yes');
                // Go backurl
                redirect($this->login->getLoginBackUrl());

            }else{
                $this->session->set_userdata('login_error_times', intval($this->session->userdata('login_error_times'))+1);
            }
        }

        $tmpLoginErrorTimes = intval($this->session->userdata('login_error_times'));
        $this->display('user/login', array('LoginErrorTimes'=>$tmpLoginErrorTimes));
    }
    
    public function ajax_login() {

        $username = htmlspecialchars(trim($this->input->get("username")));
        $password = htmlspecialchars(trim($this->input->get('password')));

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
        $this->form_validation->set_error_delimiters('<div for="%s" class="ui-reg-info ui-reg-info-error"><span><em>','</em></span></div>');
        if($this->login->is_login()) 
            redirect('user/'); 
        
        if ($this->input->is_post()){
            $this->load->model('user');

            $this->form_validation->set_rules('pact', '通行证协议', 'trim|callback_check_pact');
            $this->form_validation->set_rules('username', '帐号', 'trim|required|min_length[4]|max_length[20]|alpha_numeric|callback_check_user_register');
            $this->form_validation->set_rules('password', '密码', 'trim|required|min_length[6]|max_length[20]');
            $this->form_validation->set_rules('passconf', '确认密码', 'required|matches[password]');

            if ($this->form_validation->run() === TRUE){
                // for table: user
                $user_array = array(
                    'username' => $this->input->post('username'),
                    'password' => $this->login->getPassword($this->input->post('password')),
                    'create_time' => time(),
                    'create_ip' => $this->input->ip_address(),
                    'login_time' => time(),
                    'login_ip' => $this->input->ip_address(),
                    'email' => '',
                    'mobile' => ''
                );
                $userid = $this->user->create($user_array);
                $user_array['id'] = $userid;
                $this->login->setUserSession($user_array);
                $this->login->setUserCookie($user_array,false);
                redirect($this->login->getLoginBackUrl());

            }
        }
        $this->display('user/register');
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

    // callback
    public function check_user_exist($username){
        $user_data = $this->login->checkUserExist($username);
        if (!$user_data){
            $this->form_validation->set_message('check_user_exist', '%s 不存在.');
            return false;
        }
        $this->user_data = $user_data;
        return true;
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

    //callback
    public function check_user_register($username){
        if ($this->login->checkUserExist($username)){
            $this->form_validation->set_message('check_user_register', '%s 已经存在.');
            return false;
        }
        return true;
    }

    //callback
    public function check_pact($str){
        if ($str !== 'yes'){
            $this->form_validation->set_message('check_pact', '%s 必须勾选.');
            return false;
        }
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
     * ajax validate username
     */
    public function check($type){
        $this->load->model('user');
        switch($type){
            case 'username':
                $username = strip_tags($this->input->get('username'));
                if ($this->input->get('jsoncallback')){
                    if($this->_check_user_exist(strtolower($username))){
                        $this->_doJsonCallback(array('status' => 'error'));
                    }else{
                        $this->_doJsonCallback(array('status' => 'success'));
                    }
                    exit;
                }else{
                    if($this->_check_user_exist(strtolower($username))) die("false"); else die("true");
                }
            case 'email':
                $email = strip_tags($this->input->get('email'));
                if($this->_check_email_exist($email)) die("false"); else die("true");
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
