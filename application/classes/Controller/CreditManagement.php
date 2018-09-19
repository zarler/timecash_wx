<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 活动页面
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_CreditManagement extends Home
{


    //构造方法  如果已登录  直接跳转到用户页面
    public function before()
    {
        parent::before();

    }
    //二期
    //发送模板到注册页面
    public function action_Index()
    {
        $view = View::factory($this->_vv.'Credit/Management');
        $view->title = Kohana::$config->load('url.title.login');
        $this->response->body($view);
    }
   
}