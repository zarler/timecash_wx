<?php defined('SYSPATH') or die('No direct script access.');
//入口 触发主体
class Controller_H5_Index extends Common {
	public function action_Index()
	{
		echo 123;
		die;
//		$view = View::factory('User/index');
//		$view->signPackage = '22222';
//		$this->response->body($view);
	}

}
