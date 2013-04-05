<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//安全级别
$config['secure_level'] = array(
	'system' => 1, //系统级别
	'controller'  => 2, //控制器级别
	'api' => 3,//接口级别
);

$config['secure_controller'] = array(
	'auth/save' => array(
		'secure_call' => 'secure_controller_register',	
		'secure_params' => array(SERVICE_NUMBER::SECURE_IP , 3 ,  1), //调用函数参数
	),
	'auth/check' =>	array(
		//'before_associate' => array('auth/save'),
		'secure_call' => 'secure_controller_register', //调用安全级别函数
		'secure_params' => array(SERVICE_NUMBER::SECURE_IP , 3 , 1), //调用函数参数
		//'after_associate' => array('auth/save'),
	),
);
