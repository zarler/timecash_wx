<?php defined('SYSPATH') or die('No direct script access.');
/*
 *分享到微信端的页面
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
class Controller_SetUp extends WxHome {
	public function before()
	{
		parent::before();
	}
	//邀请进入注册页面
	public function action_HomePage()
	{
		$view = View::factory($this->_vv.'SetUp/HomePage');
		$view->title = '设置';
		$this->response->body($view);
	}

}
