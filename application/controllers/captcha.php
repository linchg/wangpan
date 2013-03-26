<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Captcha extends MY_Controller {
    function __construct() {
        parent::__construct(false);
    }   
    //验证码生成地址
    function create() {
        $this->load->library('Kcaptcha');
        $this->kcaptcha->newcreate();
    }   
    //验证码验证接口
    function verify() {
        $this->load->library('Kcaptcha');
        $p = array();
        $p['captcha'] = $this->input->get('captcha', true);
        if(!$this->kcaptcha->verify($p['captcha'])) {
			$this->errorOutput();
        }   
		$this->successOutput();
    }   
}
