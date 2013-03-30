<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

    private $user_data;

    function __construct()
    {
        parent::__construct(false);
        $this->load->library('form_validation');
    }

    public function index()
    {
		$this->template->set_menu(SERVICE_NUMBER::USER_MENU);
		$this->template->set_menu(SERVICE_NUMBER::USER_TOP_MENU , 'top_menus');
        $this->template->load_view('user/default' , 'user/index');
    }
    
    public function setpass()
    {
        $this->load->model('user');
        $resp = array();
        
        $username = $this->input->get('username');
        $time = $this->input->get('time');
        $sign = $this->input->get('sign');
        
        $resp['username'] = $username;
        $resp['time'] = $time;
        $resp['sign'] = $sign;
        
        if ($username && $time && $sign){
            
            $username_exist = $this->check_user_exist($username);
            if(!$username_exist){
                $resp['message'] = '帐号不存在!';
            }
            
            $timediff = time() - intval($time);
            if($timediff > $this->config->config['sign_timeout']){
                $resp['message'] = '连接超时!';
            }
            
            $new_sign = md5($username . $time . $this->config->config['sign_key']);
            if ($sign !== $new_sign){
                $resp['message'] = '签名校验失败!';
            }
        }else{
            $resp['message'] = '参数不完整!';
        }
        
        if ($this->input->is_post()){
        
            $this->form_validation->set_rules('password', '新密码', 'trim|required|min_length[6]|max_length[20]|alpha_numeric|matches[passconf]');
            $this->form_validation->set_rules('passconf', '确认密码', 'trim|required');
            
            if ($this->form_validation->run() === TRUE){
                $user_array = array( 'password' => md5($this->input->post('password')) );
                
                $this->user->update($user_array, array('id' => $this->user_data['id']));

                // Success!!!
                $resp['success'] = 'success';
            }
        }

        $this->load->view('account/setpass', $resp);
    }
    
    public function changeinfo()
    {
        $this->load->model('user');
        $this->load->helper('string');
        
        $user_data = $this->user->get($this->session->userdata('id'));

        if ($this->input->is_post()){
            $this->form_validation->set_error_delimiters('<div for="%s" class="ui-reg-info ui-reg-info-error ml8"><span><em>','</em></span></div>');
        
            $this->form_validation->set_rules('sex', '性别', 'trim|required|exact_length[1]|numeric');
            $this->form_validation->set_rules('qq', 'QQ', 'trim|min_length[5]|max_length[11]|numeric|xss_clean');
            //$this->form_validation->set_rules('realname', '联系人姓名', 'trim|required|min_length[2]|max_length[20]|xss_clean');
            //$this->form_validation->set_rules('mobile', '手机', 'trim|exact_length[11]|numeric|xss_clean');
            //$this->form_validation->set_rules('msn', 'MSN', 'trim|valid_email|xss_clean');
    
            if ($this->form_validation->run() === TRUE){
                $user_array = array(
                    'sex' => $this->input->post('sex'),
                    'qq' => $this->input->post('qq')
                );
                
                $this->user->update($user_array, array('id' => $this->session->userdata('id')));
                
                $alert_data = array(
                    'currentMenu'=>'changeinfo',
                    'title'=>'修改资料',
                    'info_text'=>'修改资料成功',
                    'info_summary'=>'您已经成功更新您的个人资料信息'
                );
                
                $this->load->view('account/alert', $alert_data);
                return;
            }
        }
        
        $this->load->view('account/changeinfo', $user_data);
    }
    
    public function changepass()
    {
        $this->form_validation->set_error_delimiters('<div for="%s" class="ui-reg-info ui-reg-info-error"><span><em>','</em></span></div>');
        
        if ($this->input->is_post()){
            $this->load->model('user');
        
            $this->form_validation->set_rules('oldpass', '当前密码', 'trim|required|min_length[6]|max_length[20]|callback_check_password');
            $this->form_validation->set_rules('password', '新的密码', 'trim|required|min_length[6]|max_length[20]|alpha_numeric|matches[passconf]');
            $this->form_validation->set_rules('passconf', '确认密码', 'trim|required');
    
            if ($this->form_validation->run() === TRUE){
                $user_array = array( 'password' => md5($this->input->post('password')) );
                
                $this->user->update($user_array, array('id' => $this->user_data['id']));
                
                $alert_data = array(
                    'currentMenu'=>'changepass',
                    'title'=>'修改密码',
                    'info_text'=>'修改密码成功',
                    'info_summary'=>'经常修改密码有助于保障账户安全'
                );
                
                $this->load->view('account/alert', $alert_data);
                return;
            }
        }
        
        $message['message'] = validation_errors();
        $this->load->view('account/changepass', $message);
    }
    
    public function bindmobile($step='')
    {
        $this->load->model('user');
        $this->load->library('sendmobile');

        $this->form_validation->set_error_delimiters('<div for="%s" class="ui-reg-info ui-reg-info-error mt18"><span><em>','</em></span></div>');
        
        switch($step){
            case 'start':
                $this->load->view('account/bindmobile', array('step'=>$step));
                break;
            case 'sendmobile':
                if ($this->input->is_post()){
                    $this->form_validation->set_rules('mobile', 'mobile', 'trim|required|numeric|exact_length[11]');
                    if ($this->form_validation->run() === TRUE){
                        if ($this->session->userdata('mobile_checkcode')){
                            $tmpRandomCode = $this->session->userdata('mobile_checkcode');
                        }else{
                            $tmpRandomCode = mt_rand(1000, 9999);
                        }

                        $this->session->set_userdata(array('mobile' => $this->input->post('mobile'), 'mobile_checkcode' => $tmpRandomCode));

                        $tmpRe = $this->sendmobile->doSendSMS($this->input->post('mobile'), '您的短信验证码为：'.$tmpRandomCode.' [XY游戏 http://www.xy.com]');

                        echo $tmpRe;
                    }
                }
                break;
            case 'checkcode':
                if ($this->input->is_post()){
                    $this->form_validation->set_rules('checkcode', '验证码', 'trim|required|callback_check_mobile_checkcode');
                    if ($this->form_validation->run() === TRUE){
                        
                        $this->load->model('user');
                        $user_array = array( 'mobile' => $this->session->userdata('mobile') );
                        $this->user->update($user_array, array('id' => $this->session->userdata('id')));
                        $this->session->set_userdata($user_array);
                        
                        exit('true');
                    }
                }

                exit('false');
                break;
            case 'done':
                $alert_data = array(
                    'currentMenu'=>'bindmobile',
                    'title'=>'手机绑定',
                    'info_text'=>'手机绑定成功',
                    'info_summary'=>'找回密码、帐号安全认证的最重要途径。'
                );
                
                $this->load->view('account/alert', $alert_data);
                break;
            default:
                $this->load->helper('string');
                $user_data = $this->user->get($this->session->userdata('id'));
                $user_data['step'] = '';
                $this->load->view('account/bindmobile', $user_data);
        }
    }
    
    public function bindemail($step='')
    {
        $this->load->helpers('date');
        $this->load->model('user');
        $this->form_validation->set_error_delimiters('<div for="%s" class="ui-reg-info ui-reg-info-error mt18"><span><em>','</em></span></div>');
        
        switch($step){
            case 'start':
                $this->load->view('account/bindemail', array('step'=>$step));
                break;
            case 'sendmail':
                if ($this->input->is_post()){
                    $this->form_validation->set_rules('email', '邮箱地址', 'trim|required|valid_email');
                    if ($this->form_validation->run() === TRUE){
                        $tmpRandomCode = mt_rand(1000, 9999);
                        $email = $this->input->post('email');

                        $this->session->set_userdata(array( 'email_temp' => $email ));
                
                        $user_array = array( 'email' => $tmpRandomCode );
                        $this->user->update($user_array, array('id' => $this->session->userdata('id')));

                        $title = 'XY游戏 —— 绑定邮箱验证';
                        $content = '
                            <b>亲爱的XY游戏用户：</b><br />
                            &nbsp;&nbsp;&nbsp;&nbsp;您好！<br />
                            &nbsp;&nbsp;&nbsp;&nbsp;感谢您使用XY游戏平台邮箱验证，本次邮箱绑定验证码为：<font color=red>'.$tmpRandomCode.'</font>。请在验证码输入框中输入验证码以完成验证。<br />
                            &nbsp;&nbsp;&nbsp;&nbsp;如非本人操作，可能是有用户误输入您的邮箱地址，您可以忽略此邮件，由此给您带来的不便敬请谅解！<br />
                            <br />
                            XY游戏平台<br />
                            '.mdate('%Y年%m月%d日').'<br />
                        ';
                        
                        $email_web = 'http://mail.'.substr($email, strpos($email,'@')+1);
                        $this->_send_email($email, $title, $content);
                        $this->load->view('account/bindemail', array('step'=>'checkcode', 'email'=>$email, 'email_web'=>$email_web));
                    }else{
                        $this->load->view('account/bindemail', array('step'=>'start'));
                    }
                }else{
                    $this->load->view('account/bindemail', array('step'=>'start'));
                }
                break;
            case 'checkcode':
                if ($this->input->is_post()){
                    $this->form_validation->set_rules('checkcode', '验证码', 'trim|required|callback_check_email_checkcode');
                    if ($this->form_validation->run() === TRUE){
                        
                        $this->load->model('user');
                        $user_array = array( 'email' => $this->session->userdata('email_temp') );
                        $this->user->update($user_array, array('id' => $this->session->userdata('id')));
                        $this->session->set_userdata($user_array);
                        
                        $alert_data = array(
                            'currentMenu'=>'bindemail',
                            'title'=>'邮箱绑定',
                            'info_text'=>'您已设置安全邮箱成功！',
                            'info_summary'=>'邮箱绑定可以找密码、以及帐号的资料的修改'
                        );
                        
                        $this->load->view('account/alert', $alert_data);
                        
                        return;
                    }
                    
                    $email = $this->session->userdata('email');
                    $email_web = 'http://mail.'.substr($email, strpos($email,'@')+1);
                    $this->load->view('account/bindemail', array('step'=>'checkcode', 'email'=>$email, 'email_web'=>$email_web));
                }else{
                    $this->load->view('account/bindemail', array('step'=>'start'));
                }
                break;
            default:
                $this->load->helper('string');
                $user_data = $this->user->get($this->session->userdata('id'));
                $user_data['step'] = '';
                $this->load->view('account/bindemail', $user_data);
        }
    }

}

/* End of file  */
