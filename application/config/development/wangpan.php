<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//验证码
$config['captcha_w']   = 100;   //验证码图片宽度
$config['captcha_h']   = 30;    //验证码图片高度
$config['captcha_len'] = 5;     //验证码字符长度
$config['captcha_s'] = 20;     //验证码字符长度

<<<<<<< HEAD
//报错设置
=======
$config['user_pass_prefix'] = 'abc';     //用户的密码md5前缀

>>>>>>> 6efc35c876911bff052a43ea30ad98a9e03f6e90
require('error.php');

//服务返回常量
require_once('service_number.php');

