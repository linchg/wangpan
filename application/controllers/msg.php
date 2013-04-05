<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Msg extends MY_Controller {

	public function __construct()
	{
		parent::__construct(false);
	}	

	public function index()
	{
		$code = $this->input->get('code',true);
		$code = intval($code);
		if ($code < 30000)
		{
			redirect('/');
		}
		$error_list = $this->wangpan->get_error_list();
		if(!isset($error_list[$code])) {
			redirect('/');
		} else {
			$msg  = $error_list[$code];
		}
		$this->template->set_static(array('static/js/index.js'));  
		$this->template->set_menu();  
		$this->template->load_view('default' , 'msg' , array('msg' => $msg));
	}

}
	
