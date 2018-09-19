<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 活动页面
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_App_Follow extends AppHome
{
    protected $_activity = null;
    protected $_signPackage = null;
    //构造方法  如果已登录  直接跳转到用户页面
    public function before()
    {
        parent::before();
    }

    /************************************************************************************************************************************
     *  关于微信
     ************************************************************************************************************************************/
    public function action_WechatQRCode(){
        $view = View::factory($this->_vv.'Follow/WechatQRCode');
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            parent::$_VArray['client'] = "ios";
        }elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            parent::$_VArray['client'] = "android";
        }else{
            parent::$_VArray['client'] = "else";
        }
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

}