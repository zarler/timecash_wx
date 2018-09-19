<?php defined('SYSPATH') or die('No direct script access.');

class Controller_App_Repaymoney extends AppHome {
	private $order = null;//订单id
	public function before()
	{
		parent::before();
		if(!isset($this->order) || empty($this->order)){
			$this->order = Model::factory('Order');
		}
	}

	public function action_index()
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

}
