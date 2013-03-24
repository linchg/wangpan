<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    public $Header = ''; 
    public $Footer= ''; 
    public $title= '欢迎进入兴趣盘';
	public $content = '兴趣盘';
	public $key= '兴趣,网盘';
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

    public function loginVerify() {
        //$siteUrl = $this->passPortUrl();
        if($this->login->is_login() !== true) {
          //  redirect($siteUrl.'auth/login?redurl='.urlencode(current_url().$this->build_request(true)), 'refresh');
        }   
    }   
       
    public function getUser()
    {   
        return $this->login->get_user();    
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
		if (empty($header) && empty($footer))
		{
			$this->globalLayout();
		}
		$html = $this->Header.$this->load->view($view , $vars , true).$this->Footer;
		if ($return) return $html;
		echo $html;
	}

	public function  display_html($view , $vars = array() , $return = false)
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

	public function build_request($question_mark = false) {
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
			$this->login->login_out();
		}
		$redurl = $this->input->get('redurl', true);
		if($redurl != '') {
			redirect($redurl, 'refresh');
		}
		redirect('/', 'refresh');
	}
}
