<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
    class Controller_Notice extends Controller {
        protected $_site_config= null;
        protected $_vv = null;

        public function before(){
			parent::before();
            $this->_site_config = Kohana::$config->load('site');
            if(isset($this->_site_config['config']['view_version'])&&!empty($this->_site_config['config']['view_version'])){
                $this->_vv = $this->_site_config['config']['view_version'].'/';
            }else{
                $this->_vv = '';
            }
		}
		//html测试(微信二维码关注)
        public function action_Index(){
            $view = View::factory($this->_vv.'Notice/Index01');
            $this->response->body($view);
        }

	}