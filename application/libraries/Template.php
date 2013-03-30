<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
		var $template_data = array();
		private $_static_url = array(
			'js_header' ,  'js_footer' , 'css_footer' , 'css_header'
		);			
		function __construct()
		{	
			$this->CI =& get_instance();
		}

		function set($name, $value) {
			$this->template_data[$name] = $value;
		}
		
		function get_data() {
			return $this->template_data;
		}

		function set_chunk($name , $view , $view_data=array())
		{
			$trunk = $this->CI->load->view($view, $view_data, TRUE);
			$this->set($name , $trunk);	
		}
		
		function load($template = '',$return = FALSE) {
			return $this->CI->load->view($template, $this->template_data, $return);
		}

		function load_view($template = '', $view = '' , $view_data = array(), $return = FALSE) {
			$this->set('content', $this->CI->load->view($view, array_merge($this->template_data , $view_data), TRUE));
			return $this->CI->load->view($template, $this->template_data, $return);
		}
		
		function set_static($include = array() , $type = SERVICE_NUMBER::JSFILE ,  $position = SERVICE_NUMBER::FILEFOOTER)
		{
			$n = $type ^ $position;	
			if (isset($this->_static_url[$n]))
			{
				$name = $this->_static_url[$n];
				$this->set($name , $this->CI->wangpan->static_url($include ,  $type));
			}
		}  

		function set_menu($type = SERVICE_NUMBER::DEFAULT_MENU , $name = 'content_menus')
		{
			$router = $this->CI->uri->uri_string();
			if (empty($router)) $router = 'index';
			$menu = $this->CI->wangpan->menu($type , $router);
			if (empty($name)) return false;
			$this->set($name , $menu);	
		}
}	
