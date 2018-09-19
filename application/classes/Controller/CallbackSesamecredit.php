<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
    class Controller_CallbackSesamecredit extends Home {
		protected $api = null;
		public function before(){
			parent::before();
			$this->api = Tool::factory('API');
		}
		public function action_Sesamecredit(){
			if(Gv::$type==2){
				$app = $this->getappapp(Gv::$app_token);
			}else{
				$app = $this->getapp();
			}
			$_GET['app'] = $app;
			$_GET['user_id'] = Gv::$user_id;
			$json_info = json_encode($_GET);
			$result = $this->api->getApiArraysVersion('ZhiMaCredit_Api','callback','',array('json'=>$json_info));
			if(isset($result) && $result['code']==1000){
				$this->redirect('/Account/Promote?#jump=yes');
				die;
				//exit(json_encode(array('status' =>true,'msg'=>$result['message'])));
			}else{
				if(isset($result['code'])){
					$this->error($result['message']);
					die;
				}else{
					$this->error(Kohana::message('wx','system_busy'));
					die;
				}
			}
		}
}