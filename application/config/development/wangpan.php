<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//验证码
$config['captcha_w']   = 100;   //验证码图片宽度
$config['captcha_h']   = 30;    //验证码图片高度
$config['captcha_len'] = 5;     //验证码字符长度
$config['captcha_s'] = 20;     //验证码字符长度
$config['captcha_time_limit'] = 60*60*5;     //验证码字符长度

$config['login_expire'] = 3600;//登录过期时间

$config['encryption_key'] = 'd520a6bd4519f51b09d4c30b0da5f5b0'; //日志加密密码

$config['user_pwd_prefix'] = 'abc'; //用户密码加密


//md5
$config['md5_key'] = array(
	'0000' => 'abc', //用户的密码md5前缀
);

//报错设置
require('error.php');

//js/css文件版本控制
require('static_file_version.php');

//菜单
require('menu.php');



//服务返回常量
require_once('service_number.php');

