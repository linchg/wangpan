<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login
{
  	private $CI;
    public function __construct() {
        $this->CI =& get_instance();
    }	
	
	public function is_login()
	{
		return true;
	} 

	public function get_user()
	{
		return array('username' => 'test');
	}
	public function login_out()
	{
		return true;
	}
}

