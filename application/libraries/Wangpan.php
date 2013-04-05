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

	/*
	 * 静态js/css文件 
	 */
	function static_url($include = array() ,  $type = SERVICE_NUMBER::JSFILE)
	{
		$default_version = $type === SERVICE_NUMBER::JSFILE ? $this->get('static_js_version') : $this->get('static_cs_version');
		$files	= $type === SERVICE_NUMBER::JSFILE ? $this->get('js') : $this->get('css');	
		$include = array_fill_keys($include , $default_version);
		$files = array_intersect_key($files, $include);
		return $this->static_file_html($files , $type);	
	}
	
	function static_file_html( $files= array() , $type = SERVICE_NUMBER::JSFILE)
	{
		$files = is_array($files) ? $files : array($files);
		$html = '';
		foreach($files as $file => $v)
		{
			if ($type === SERVICE_NUMBER::JSFILE)	
			{
				$html.='<script type="text/javascript" src="'.static_url($file).'?v='.$v.'"></script>'."\n";	
			}
			else
			{
				$html.='<link href="'.static_url($file).'?v='.$v.'" rel="stylesheet" type="text/css" />'."\n";
			}
		}
		return $html;
	}
	
	/*
	 * 静态文件获取版本
	 */
	public function static_version($file , $type = SERVICE_NUMBER::JSFILE)	
	{
		if(empty($file)) return '';
		$files = $type === SERVICE_NUMBER::JSFILE ? $this->get('js') : $this->get('css');	
		$default_version = $type === SERVICE_NUMBER::JSFILE ? $this->get('static_js_version') : $this->get('static_cs_version');
		$v = isset($files[$file])? $files[$file] : $default_version;
		return static_url($file.'?v='.$v);
	}

	/*
	 * 菜单管理 
	 */
	public function menu($type = SERVICE_NUMBER::DEFAULT_MENU , $select = '')	
	{
		$type = empty($type) ? SERVICE_NUMBER::DEFAULT_MENU:intval($type);
		$select = strval($select); 
		switch ($type)
		{
			case SERVICE_NUMBER::DEFAULT_MENU:
				$menuName = 'default_menu';	
				$menuClass = 'default_class';
				break;
			case SERVICE_NUMBER::USER_MENU:
				$menuName = 'user_menu';	
				$menuClass = 'user_class';
				break;
			case SERVICE_NUMBER::USER_TOP_MENU:
				$menuName = 'user_top_menu';	
				$menuClass = 'user_top_class';
				break;
			case SERVICE_NUMBER::ADMIN_MENU:
				$menuName = 'admin_menu';	
				$menuClass = 'admin_class';
				break;
			default:
				$menuName = 'default_menu';	
				$menuClass = 'default_class';
				break;
		}
		$menu = $this->get($menuName);
		$class = $this->get($menuClass);
		if (empty($class)) return $menu;
		$tmp = array();
		if (isset($menu[$select]))
		{
			if (!empty($menu[$select]['style']))
			{
				$menu[$select]['active_style'] = $class;
			}
			else
			{
				$menu[$select]['style'] = $class;
			}
		}
		return $menu;
	}

	//md5	
	public function get_md5_key($site_id)
	{
		$md5_key = $this->get('md5_key');
		if (isset($md5_key[$site_id]))
		{
			return $md5_key[$site_id];
		}	
		return false;
	}

	//获取安全级别
	public function get_secure_level($level_key = '')
	{
		$level = $this->get('secure_level');
		if (!empty($level_key) && isset($level[$level_key]))
		{
			return $level[$level_key];	
		}
		return $level;
	}

	//获取配置
	public function get_secure_config($level_key = '')
	{
		if(!empty($level_key))
		{
			$config = $this->get('secure_'.$level_key);
			return $config;
		}
		$level = $this->get_secure_level();
		$config = array();
		foreach($level as $key => $value)
		{
			$secure_config = $this->get('secure_'.$key);
			if (!empty($secure_config))
			{
				$config[$key] =  $secure_config;
			}
		}
		return $config;
	}
}	

