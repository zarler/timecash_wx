<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
    class Controller_Callback extends Controller {
		protected $api = null;
		
		public function before(){
			parent::before();
			$this->api = Tool::factory('API');
		}
		public function action_Index(){
			$post = $this->request->post();
//			Tool::factory('Debug')->array2file($post, APPPATH.'../static/liu_test.php');
			if($post){
//				Tool::factory('Debug')->array2file($post, APPPATH.'../static/liu_test.php');
				$result = $this->api->getApiArrays('Notify_PreAuth_UnionPay_Notify','Index','',$post);
//				Tool::factory('Debug')->array2file($result, APPPATH.'../static/liu_test.php');
				$this->redirect('User/index?#jump=describe');
//				if($result=='��ǩ�ɹ�'){
//
//				}else{
//					$this->error('Ԥ��Ȩ����ʧ��');
//				}
			}else{
				$this->error('验证失败');
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