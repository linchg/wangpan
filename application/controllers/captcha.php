<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Captcha extends MY_Controller {
    function __construct() {
        parent::__construct(false);
    }   
    //验证码生成地址
    function create() {
        $this->load->library('Kcaptcha');
        $this->kcaptcha->create();
    }   
    //验证码验证接口
    function verify() {
        $this->load->library('Kcaptcha');
        $p = array();
        $p['captcha'] = $this->input->get('captcha', true);
    
        if(!$this->kcaptcha->verify($p['captcha'])) {
            $this->json->output(array('r' => 'error', 'm' => $this->error->error_msg()));
        }   
        $this->json->output(array('r' => 'success'));
    }   
}
