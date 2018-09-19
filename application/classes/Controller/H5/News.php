<?php defined('SYSPATH') or die('No direct script access.');
//入口 触发主体
class Controller_H5_News extends Common {
	public function action_New1()
	{
		$view = View::factory($this->_vv.'News/news1');
		$this->response->body($view);
	}
    public function action_New2()
    {
        $view = View::factory($this->_vv.'News/news2');
        $this->response->body($view);
    }
    public function action_New3()
    {
        $view = View::factory($this->_vv.'News/news3');
        $this->response->body($view);
    }

}
