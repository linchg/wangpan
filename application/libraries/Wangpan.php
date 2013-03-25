<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Wangpan{
	private $CI;
	function __construct($config = array()) {
		$this->CI =& get_instance();
	}
	
	function get($item_name) {
		$this->CI->config->load('wangpan', true);
		$item = $this->CI->config->item($item_name, 'wangpan');
		return $item;
	}

	function get_error_list()	
	{
		$error_list = $this->get('error_list');
		return $error_list;
	}
}	
