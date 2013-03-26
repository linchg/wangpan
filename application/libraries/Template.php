<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
		var $template_data = array();
			
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
		
		function load($template = '', $return = FALSE) {
			$this->CI =& get_instance();
			return $this->CI->load->view($template, $this->template_data, $return);
		}

		function load_view($template = '', $view = '' , $view_data = array(), $return = FALSE) {
			$this->CI =& get_instance();
			$this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
			return $this->CI->load->view($template, $this->template_data, $return);
		}
}
