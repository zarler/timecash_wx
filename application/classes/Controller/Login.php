<?php defined('SYSPATH') or die('No direct script access.');

    class Controller_Login extends WxHome {

        //如果已登录  直接跳转到用户页面
        public function before(){
            parent::before();
            if(isset(Gv::$_userInfo['status'])&&in_array(Gv::$_userInfo['status'],array(3,4,5))){
                $this->error(Kohana::message('wx','no_right'));
                die;
            }
        }
        public function action_index()
        {
            if(!empty(Gv::$_userInfo['user_id'])){
                $this->redirect("/");
                die;
            }
            /*--------------------兼容活动返回活动页面------保存活动的action-----------------*/
            if(isset($_GET['activity'])&&!empty($_GET['activity'])){
                $this->_session->sessionSet('activity','/Activity/'.$_GET['activity']);
            }
            $activity = $this->_session->sessionGet('activity');
            parent::$_VArray['jumpUrl'] = empty($activity)?"/":$activity;
            /*-------------------------------------------*/
            parent::$_VArray['title'] = Kohana::$config->load('url.title.login');
            //标记返回页面
            if(isset($_GET['bj'])&&$_GET['bj']=='register'){
                parent::$_VArray['bj'] = true;
            }else{
                parent::$_VArray['bj'] = false;
            }
            $view = View::factory($this->_vv.'Login/index');
            $view->_VArray =  parent::$_VArray;
            $this->response->body($view);
        }
        //找回密码
        public function action_BackPwd(){
            $view = View::factory($this->_vv.'Login/backpwd');
            //如果是登陆状态下直接显示号码，如果不是，让填写
            if(Valid::not_empty(Gv::$_userInfo['mobile'])){
                parent::$_VArray['mobile'] = Gv::$_userInfo['mobile'];
            }else{
                parent::$_VArray['mobile'] = null;
            }
            parent::$_VArray['title']=Kohana::$config->load('url.title.back_pwd');
            $view->_VArray =  parent::$_VArray;
            $this->response->body($view);
        }
        //设置新密码
        public function action_ResetPwd(){
           // Tool::factory('Debug')->array2file($this->session->sessionGet('resetpwd_token'), APPPATH.'../static/liu_test.php');
            if(!$this->_session->sessionGet('resetpwd_token')){
                $this->redirect('Login/backpwd');
            }
            $view = View::factory($this->_vv.'Login/resetpwd');
            $view->title = Kohana::$config->load('url.title.resetpwd');
            $this->response->body($view);
        }

    }