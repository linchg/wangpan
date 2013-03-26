<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
报错列表
从左到右 
第1位代表服务级别 1代表系统级错误 2代表服务级别错误
第2-3位代表服务模块代码 01代表注册/登录模块
第3-4位代表具体错误代码
*/
$config['error_list'] = array(
	'10000' => '系统错误!',
	'20101' => '登录验证码错误!'
);
