<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['default_class'] = 'on';
$config['default_menu'] = array(
	'index' => array(
		'title' => '首页',
		'style' => '',
	),	
	'index/money' => array(
		'title' => '网盘赚钱',
		'style' => '',
	),
	'index/shop' => array(
		'title' => '积分兑换',
		'style' => '',
	),
	'index/faq' => array(
		'title' => '常见问题',
		'style' => '',
	),
	'index/about' => array(
		'title' => '关于兴趣盘',
		'style' => '',
	),
);

$config['user_class'] = 'active';
$config['user_menu'] = array(
	'user' => array(
		'title' => '文件管理',
		'id' =>'file-manage',
		'style' => 'ico ico-file-manage',
	),
	'index/shop' => array(
		'title' => '提取我赚到的佣金',
		'id' =>'share-manage',
		'style' => 'ico ico-share',
	),
	'index/faq' => array(
		'title' => '积分兑换商城',
		'id' => 'link-manage',
		'style' => 'ico ico-olink',
	),
	'index/about' => array(
		'title' => '网站公告',
		'id' => 'recycle-manage',
		'style' => 'ico ico-trash',
	),

);

$config['user_top_class'] = '';
$config['user_top_menu'] = array(
	'user' => array(
		'title' => '每日签到',
		'id' =>'mrqd',
		'style' => 'checkin imitate-ico imitate-checkin dib hoverlink',
		'target' => '',
	),
	'index/shop' => array(
		'title' => '我的主页',
		'id' =>'share-manage',
		'style' => 'hoverlink',
		'target' => '_blank',
	),
	'index/faq' => array(
		'title' => '空间公告',
		'id' => '',
		'style' => 'hoverlink',
		'target' => '_parent'
	),
	'index/about' => array(
		'title' => '我的下线',
		'id' => '',
		'style' => 'hoverlink blue',
		'target' => '_parent'
	),
	'index/about' => array(
		'title' => '建议反馈',
		'id' => '',
		'style' => 'gray feedbacklink hoverlink',
		'target' => '_blank'
	),
	'index/about' => array(
		'title' => '退出',
		'id' => '',
		'style' => 'hoverlink',
		'target' => '_parent'
	),

);





$config['admin_class'] = 'on';
$config['admin_menu'] = array(
	
);
