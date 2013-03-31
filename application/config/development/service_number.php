<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SERVICE_NUMBER
{
	const SUCCESS = 1;//成功
	const ERROR = 0;//失败

	const AJAX_SUCCESS = 0;//成功
	const AJAX_ERROR = 1;//失败

	
	const FILEHEADER = 1; //文件插在头部
	const FILEFOOTER = 0; //文件插在尾部

	const CSSFILE = 2; //css文件
	const JSFILE = 1;//js文件

	const DEFAULT_MENU=1;//网站默认菜单
	const USER_MENU=2;//用户登录菜单
	const USER_TOP_MENU=3;//用户登录顶部菜单
	const ADMIN_MENU = 4;//管理后台菜单
}
