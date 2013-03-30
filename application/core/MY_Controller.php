<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    public $Header = ''; 
    public $Footer= ''; 
    public $title= '欢迎进入兴趣盘';
	public $content = '兴趣盘';
	public $key= '兴趣,网盘';
	public $siteName= '兴趣网盘';
    public $menu= ''; 
    public $sub_menu= ''; 
            
    public function __construct($isLogin = false)
    {   
        parent::__construct();
        if ($isLogin)
        {   
           $this->loginVerify(); 
        }   
        $this->menu     =   $this->uri->segment(1);
        $this->sub_menu =   $this->uri->segment(2);
    }   

	//登录验证
    public function loginVerify() {
        if($this->login->is_login() !== true) {
			if($this->utility->is_ajax_request()) { 
				$this->errorOutput(20123);	
            }	
			if(current_url() != site_url()) {
				redirect('/auth/login?redurl='.urlencode(current_url().$this->buildRequest(true)), 'refresh');
			}
			redirect('/auth/login', 'refresh');
        }
		$this->login->check_user(); 
    }   

       
    public function getUser()
    {   
        return $this->login->get_login_user();    
    }

    protected function globalLayout($data = array() , $header = 'header.php' , $footer = 'footer.php')
    {   
        $header = empty($header) ? 'header.php' : trim($header); 
        $footer = empty($footer) ? 'footer.php' : trim($footer); 
        $this->Header = $this->load->view($header ,$data , true); 
        $this->Footer = $this->load->view($footer , $data , true); 
    }   

	public function display($view, $vars = array(), $return = FALSE)
	{   
		if (!is_array($vars))
		{   
			return $this->display($view , array() , $vars);
		}
        $this->globalLayout();
		$html = $this->Header.$this->load->view($view , $vars , true).$this->Footer;
		if ($return) return $html;
		echo $html;
	}

	public function  displayHtml($view , $vars = array() , $return = false)
	{
		if ($return == false)
		{
			$this->load->view($view ,  $vars , false);
		}
		else
		{
			$this->load->view($view ,  $vars , true);
		}
	}

	public function buildRequest($question_mark = false) {
		$get = $this->input->get();
		if(!$get) {
			return '';
		}
		if($question_mark) {
			return '?'.http_build_query($get);
		}
		return http_build_query($get);
	}

	public function userExit()
	{
		if($this->login->is_login() === true) {
			$this->login->user_exit();
		}
		$redurl = $this->input->get('redurl', true);
		if($redurl != '') {
			redirect($redurl, 'refresh');
		}
		redirect('/', 'refresh');
	}
	
	//成功输出
	public function successOutput($data = array())
	{
        $this->json->output(array('r' => SERVICE_NUMBER::SUCCESS, 'data' => $data));
	}
	
	//错误输出
	public function errorOutput($code = '' , $msg = '' , $req = '')
	{
		if (empty($req)) $req = $this->uri->uri_string();
		if (empty($code)) 
		{
			$code = $this->error->get_error();
		}
		$msg = empty($msg) ? $this->error->error_msg($code):$msg;
        $this->json->output(array('code' => $code , 'msg' => $msg , 'req' => $req));
	}
}
