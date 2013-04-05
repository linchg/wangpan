<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error {
	private $CI;
	private $_error_code = null;
	private $_error_msg  = null;
	
	function __construct($config = array()) {
		$this->CI =& get_instance();
	}
	
	//返回错误码
	function get_error() {
		return $this->_error_code;
	}
	
	//设置错误码
	function set_error($error_code) {
		$argv = func_get_args();
		$this->_error_code = $error_code;
		$this->_error_msg  = call_user_func_array(array($this, 'error_msg'), $argv);
	}
	
		
	//展现错误页
	function show_error($error_msg = null) {
		if($error_msg == null) {
			$error_msg = $this->error_msg();
		}
		//ob_start();
		//$this->CI->template->set('main_page', 'hidden');
		//$buffer = $this->CI->template->load('default', 'error/error', array('error_msg' => $error_msg), true);
		//ob_end_clean();
		echo $buffer;
		exit;
	}

 	//返回上次错误
    function error() {
        if(!empty($this->_error_code)) {
            return true;
        }
        return false;
    }

	//获取错误码对应的错误信息
	function error_msg($error_code = null) {
		$argv = func_get_args();
		if($error_code === null) {
			return $this->_error_msg;
		}
		$error_list = $this->CI->wangpan->get_error_list();
		if(!isset($error_list[$error_code])) {
			$argv[0] = '未定义的错误码：['.$error_code.']';
		} else {
			$argv[0] = $error_list[$error_code];
		}
		return call_user_func_array('sprintf', $argv);
	}

}
