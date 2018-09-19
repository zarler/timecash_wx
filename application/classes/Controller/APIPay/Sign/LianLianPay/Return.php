<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
    class Controller_APIPay_Sign_LianLianPay_Return extends Controller {
		protected $api = null;
		protected $_vv = null;
		protected $_site_config= null;
		public function before(){
			parent::before();
			$this->api = Tool::factory('API');
			$this->_site_config = Kohana::$config->load('site');
			if(isset($this->_site_config['config']['view_version'])&&!empty($this->_site_config['config']['view_version'])){
				$this->_vv = $this->_site_config['config']['view_version'].'/';
			}else{
				$this->_vv = '';
			}
		}
		public function action_Index(){
			$view = View::factory($this->_vv.'APIPay/LianLianPay_Return');
//			$post = $this->request->requ();
			$jumpUrl = Model::factory('Session')->sessionGet('lianlian_jump_url');
			$jumpUrlBack = Valid::not_empty($jumpUrl)?$jumpUrl:"";
			$view->url = $jumpUrlBack.'/?#jump=no';
			$view->title = '签约绑卡成功';
//			$result = $this->api->getApiArraysOld('APIPay_Sign_LianLianPay_Return', 'Index', $_GET, $_POST);
			$view->request = isset($_REQUEST)?json_encode($_REQUEST):'';
//			$view->request = '{"agreeno":"2017070607087983","oid_partner":"201701111001412099","sign":"iEK5eWEJoAq5A4ZiTZ888wOYdkgagQR1rahkwJQxWMyLdFmDMybaRVQyYRbgv9WnhvCSTLrN2EvjLC5g4ja9UlsZ/zoOOPDYaorNXl6rCIDe/K3gtdG5+pWR8XHUSljKZKwT8fPzHDJfAXCLBipoCVpRYP+FLAEurzf6p5XxL2Q=","sign_type":"RSA","user_id":"a59e2849a17a980a390268a656713a69"}';
			//Tool::factory('Debug')->array2file(array($view->request,$_REQUEST), APPPATH.'../static/liu_test.php');
			$this->response->body($view);
//			}
		}
		//等5秒才能请求该回调接口
		public function action_Reture(){
//			Tool::factory('Debug')->array2file(array($_REQUEST), APPPATH.'../static/liu_test.php');
			
			$result = $this->api->getApiArraysOld('APIPay_Sign_LianLianPay_Return', 'Index', $_GET, $_POST,'v');
//			Tool::factory('Debug')->array2file(array($result,$_REQUEST), APPPATH.'../static/liu_test.php');
			if(isset($result['code']) && $result['code']==1000){
				exit(json_encode(array('status' =>true,'msg'=>$result['message'])));
			}else{
				if(isset($result['code'])){
					exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
				}else{
					//系统繁忙，请联系客服！
					exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
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