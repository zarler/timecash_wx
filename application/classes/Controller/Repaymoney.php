<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Repaymoney extends WxHome {
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
		$variable = array(
			"user_id"=>Gv::$_userInfo["user_id"],
			"app"=>$this->getWxInfo()
		);
		$json_info = json_encode($variable);
		$result = $this->_api->getApiArrays('Order','Current','',array('json'=>$json_info));
		if(isset($result) && $result['code']==1000){
			//注册成功,插入用户id
			$order['repayment_amount'] = bcsub($result['result']['order']['repayment_amount'],$result['result']['order']['refunded_amount'], 2);
			$order['bankcard_no'] = substr($result['result']['order']['bankcard_no'],-4);
			$order['bankcard_name'] = $result['result']['order']['bank_short_name'];
			$order['order_id'] = Libs::factory('AES126')->encrypt($result['result']['order']['id'],$this->_api_config['wx']['app_key']);
			$order['status'] = $result['result']['order']['status'];
			$view = View::factory($this->_vv.'Repaymoney/index');
            parent::$_VArray['order'] = $order;
			parent::$_VArray['title']=Kohana::$config->load('url.title.repaymoney');
			 $view->_VArray =  parent::$_VArray;
			$this->response->body($view);

		}else{
			if(isset($result['code'])){
				$this->error($result['message']);
				die;
			}else{
				//系统繁忙，请联系客服！
				$this->error(Kohana::message('wx','system_busy'));
				die;
			}
		}

	}
	public function action_repayStatus(){
		$variable = array(
			"user_id"=>Gv::$_userInfo["user_id"],
			"app"=>$this->getWxInfo()
		);
		$json_info = json_encode($variable);
		$result = $this->_api->getApiArrays('Order','Current','',array('json'=>$json_info));
		if(isset($result) && $result['code']==1000){
			//注册成功,插入用户id
			if($result['result']['order']['status']==Model_Home::PAGE_TO_ACTREPAY_IN || $result['result']['order']['status']==Model_Home::PAGE_TO_OVERDUE_ACTREPAY_IN){
				$view = View::factory($this->_vv.'Repaymoney/repaystatus');
				$view->title=Kohana::$config->load('url.title.repaystatus');
				$this->response->body($view);
			}else{
				$this->error(Kohana::message('wx','no_data'));
				die;
			}
		}else{
			if(isset($result['code'])){
				$this->error($result['message']);
				die;
			}else{
				//系统繁忙，请联系客服！
				$this->error(Kohana::message('wx','system_busy'));
				die;
			}
		}
	}
}
