<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Index extends MY_Controller {
	public function __construct()
	{
		parent::__construct(false);
	}
	public function index()
	{
		$this->template->set_static(array('static/js/index.js'));  
		$this->template->set_menu();  
		$this->template->load_view('default' , 'index');
	}

	public function reg()
	{
		$this->title = '兴趣盘－注册用户';
		$this->template->load('default' , 'reg');			
	}

	//用户协议
	public function argreement()
	{
		echo '用户协议';	
	}

	//网盘搛钱
	public function money()
	{
		log_scribe('trace', 'login', $this->input->ip_address().' ['.current_url().'] LOGIN ');	
		echo '网盘搛钱';	
	}

	//积分
	public function shop()
	{
		echo '网盘搛钱';	
	}

	//faq
	public function faq()
	{
		echo '网盘搛钱';	
	}

	//about
	public function about()
	{
		echo '网盘搛钱';	
	}
}

