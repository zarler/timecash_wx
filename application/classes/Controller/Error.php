<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
    class Controller_Error extends Common {
		public function before(){
			parent::before();
		}
		public function action_Index(){
			if(isset($_GET['code'])&&!empty($_GET['code'])){
				switch ($_GET['code']){
					case '5103':
					case '5123':
						$error = '您的资料暂不符合要求，未能通过极速贷放款审核，建议您尝试申请担保借款';
						$this->error($error,null);
						break;
					default:
						$error = isset($_GET['code'])?'出错啦！请联系客服（错误代码'.$_GET['code'].'）':'出错啦！请联系客服（错误代码0000）';
						$this->error($error);
						break;

				}
			}
		}
     }