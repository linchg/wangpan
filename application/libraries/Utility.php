<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Utility
{
	private $CI;
	function __construct() {
        $this->CI =& get_instance();
    }	

	 //判断请求是否是ajax
    function is_ajax_request() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            return true;
        }
        return false;
    }

	//使用密钥获取md5签名
    function get_md5_sign($fields , $site_id = '0000') {
        ksort($fields);
        reset($fields);
        $plaintext = '';
        while(list($key, $val) = each($fields)) {
            $plaintext .= $key."=".$val."&";
        }
        $key = $this->CI->wangpan->get_md5_key($site_id);
        if($key === false) {
            $this->CI->error->set_error('20102');
            return false;
        }
        $plaintext .= 'key='.$key;
        return md5($plaintext);
    }

	//密码加密
	function get_pwd_md5($pwd)
	{
		if (!$this->chk_pwd($pwd)) return false;
		$prefix = $this->CI->wangpan->get('user_pwd_prefix');	
		return md5($prefix.$pwd);	
	}

	//验证密码	
	function chk_pwd($pwd)
	{
		return true;
	}	

	//uid验证
	function chk_uid($uid)
	{
		if ($uid < 0) return false;
		if(!is_numeric($uid)) return false;
		return true;
	}

	//用户名是否正常
	function chk_username($username)
	{
		$username = trim($username);
		if (strlen($username) < 5 || strlen($username) > 15)
		{
			$this->CI->error->set_error('20201');
			return false;
		}
		if(!preg_match('/^\w{5,15}$/', $username)) {		
			$this->CI->error->set_error('20202'); 
			return false;
		}
		return true;
	}
	//是否存在用户名
	function chk_username_exists($username)
	{
		$result = $this->chk_username($username);	
		if (!$result) return true;
		$this->CI->load->library('cache/UserCache');
		$row = $this->CI->usercache->get_user($username); 
		if($row == false) return false;
		$this->CI->error->set_error('20203');
		return true;
	}

    // 不可逆混淆加密文字，如日志中的密码信息
    function mosaic($text) {
        $key = $this->CI->wangpan->get('encryption_key');
        return md5($text.$key);
    }
}
