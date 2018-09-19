<?php defined('SYSPATH') or die('No direct script access.');
/*  添加银行卡后,需要补充连连支付
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
    class Controller_APIPay_LianLian extends WxHome {
		protected $api = null;
		protected $_vv = null;
		protected $_site_config= null;
		public function before(){

		}
		public function action_Index(){
			//验证是否需要连连支付
			$variable = array(
				"app"=>$this->getapp()
			);
			$json_info = json_encode($variable);
			//当日借款统计(极速贷)
			$result = $this->_api->getApiArrays('BankCard','BindCheck','',array('json'=>$json_info));
			if(isset($result) && $result['code']==1000){
				if(isset($result['result']['jump'])&&$result['result']['jump']==1){
					echo $result['result']['html'];
					die;
				}else{
					//不需要做连连验证,跳到其他首页
					$this->redirect('/');
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

		protected function error($error){
			$view = View::factory('Error/index');
			$view->error = $error;
			$view->url = '/User/index?#jump=no';
			$out = $view->render();
			exit( $out);
		}


}