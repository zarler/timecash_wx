<?php defined('SYSPATH') or die('No direct script access.');
//入口 触发主体
class Controller_H5_Text extends Common {
    //还款详情
	public function action_Details()
	{
        $this->Load();
		$view = View::factory($this->_vv.'Repaymoney/Details');
		$this->response->body($view);
	}
    public function action_Operation()
    {
        $this->Load();
        $view = View::factory($this->_vv.'Repaymoney/Operation');
        $this->response->body($view);
    }

    public function action_Repaystatus()
    {
        $this->Load();
        $view = View::factory($this->_vv.'Repaymoney/Repaystatus');
        $this->response->body($view);
    }

    //KJJD0420活动
    public function action_KJJD0420()
    {
//        $this->Load();
        $view = View::factory($this->_vv.'Activity2/KJJD0420');
        $this->response->body($view);
    }
    public function action_New3()
    {
        $view = View::factory($this->_vv.'News/news3');
        $this->response->body($view);
    }
    //放弃借款
    public function action_GiveUp()
    {
        $view = View::factory($this->_vv.'Borrowmoney/GiveupReason');
        $this->response->body($view);
    }


}
