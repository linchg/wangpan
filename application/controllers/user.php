<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends MY_Controller {
	public function __construct()
	{
		parent::__construct(true);
	}
	public function index()
	{
		$this->load->view('user/index');
	}
}
