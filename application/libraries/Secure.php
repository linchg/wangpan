<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Secure 
{
	private $CI;
	public $ipadress = null;
	public $username = null;
	public $route = null;
	public $level = array();
	public $_clevel = '';//当前级别
	public static $all_levels = array();
	public $controller = '';
	public $action = '';
	private $_key = 'se_'; //memcache
	function __construct() {
		$this->CI =& get_instance();
		$this->init();
	}

	//初始化
	function init()
	{
		$this->ipadress = $this->CI->input->ip_address();
        $user_info = $this->CI->login->get_login_user();
		$this->username = $user_info['username'];
		if (empty($this->username))
		{
			$this->username = '';
		}
		$this->controller = $this->CI->uri->segment(1);
		$this->action = $this->CI->uri->segment(2);
		$this->route  = $this->controller .'/'.$this->action;
		$this->level = $this->CI->wangpan->get_secure_level();
		$this->config = $this->CI->wangpan->get_secure_config();
	}

	//1级控制
	function secure_system()
	{
		//黑名单	
	}

	//controller 2级控制函数
	function secure_controller_register($type = SERVICE_NUMBER::SECURE_IP , $step_total, $all_total)
	{
		//$numargs = func_num_args();
		//$arglist = func_get_args();
		$type = intval($type);
		$key = '';
		switch($type)
		{
			case SERVICE_NUMBER::SECURE_IP:
			$key = $this->ipadress;
			break;
			case SERVICE_NUMBER::SECURE_USER:
			$key = $this->username;
			break;
		}
		if (empty($key))
		{
			$this->CI->error->set_error('30301');
			return false;	
		}
        $this->CI->load->driver('cache');
		$key = $this->_key.'_'.$this->controller.'_'.$key;
        $value = $this->CI->cache->memcached->get($key);
		if(empty($value))
		{
			$time = strtotime(date('Ymd235959',time()));
			$v_time = strtotime(date('YmdH5959',time()));
			$v = array('c' => 1 , 't' =>1 , 'e'=>$v_time);
			$this->CI->cache->memcached->save($key , $v , $time); 
			return true;
		}
		$count = $value['c'];
		$total = $value['t'];
		$expire = $value['e'];
		if(intval($total) >= $all_total)
		{
			$this->CI->error->set_error('30302');
			return false;//大于总数设置过期时间为							
		}
		if($count > $step_total && time() <= $expire) // 在一个时间段，并且时间还在范围内
		{
			$this->CI->error->set_error('30303');
			return false;//$value = $value['c'] + 1;处理警告报错						
		}
		if(time() > $expire)
		{
			$value['v'] = 0;	
			$value['e']  = strtotime(date('YmdH5959',time()));
		}
		else
		{
			$value['v'] = $value['v'] + 1;
		}
		$value['t'] =  $value['t'] + 1;
		$this->CI->cache->memcached->save($key , $vaule , $time); 
		return true;
	}
   
    //api 3级控制函数
	function secure_api()
	{
		
	}

	//统一入口函数
	//call 需要调用的函数
	// params 函数参数
	// return 是否返回值
	public function invoke($level , $call = '' , $params = array())
	{
		$config = $this->check($level , $call , $params);	
		if ($config == false) {
			return false;
		}
		list($call , $params , $before_call , $after_call) = $config;
		$result = $this->for_check_all($level , $before_call);	
		if(!empty($result)) array_push($params , $result);
		$result = call_user_func_array(array($this , $call) , $params);
		$this->for_check_all($level , $after_call , $result);	
		if($this->CI->error->error())
		{
			if ($this->CI->utility->is_ajax_request()) 
			{
				$this->CI->errorOutput();
			}
		}
		return true;
	}

	//检测关联安全
	function for_check_all($level , $calls , $params = array())
	{
		if (empty($calls) || !is_array($calls)) return false;
		$result = array();
		foreach($calls as $route)
		{
			$ret = $this->check($level , '' , '' , $route);
			if ($ret == false) continue;
			if(is_array($params)) array_push($ret[1] , $params);
			$result[$route] = call_user_func_array(array($this , $ret[0]) , $ret[1]);
		}
		return $result;
	}

	//统一验证
	private function check($level , $call , $params , $route = '')
	{
		$level = is_numeric($level) ? array_search($level , $this->level) : $level; 
		$before_call = array();//之前关联
		$after_call = array(); //之后关联
		if (empty($level)) {
			return false;
		}
		if (empty($call) || !method_exists($this,$call))
		{
			$route = empty($route) ? $this->route : $route;
			if(!isset($this->config[$level][$route])) return false;
			$config = $this->config[$level][$route];
			if(!isset($config))return false;
			$call = $config['secure_call'];
			$params = !empty($params) ? array_merge($config['secure_params'] , $params) : $config['secure_params'];
			$before_call = isset($config['before_associate'])?$config['before_associate']:$before_call;	
			$after_call = isset($config['after_associate'])?$config['after_associate']:$after_call;	
		}
		return array($call , $params , $before_call , $after_call);
	}

	//获取当前请求所有安全信息
	function get_current_secure($level)
	{

	}
}
