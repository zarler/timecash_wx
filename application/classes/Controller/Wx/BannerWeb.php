<?php defined('SYSPATH') or die('No direct script access.');
/*
 * bannerWeb宣传页面
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_Wx_BannerWeb extends WxHome
{
    protected $_activity = null;
    protected $_signPackage = null;
    //构造方法  如果已登录  直接跳转到用户页面
    public function before()
    {
        parent::before();
        $this->_activity = Model::factory('Activity');
    }

    /************************************************************************************************************************************
     *  关注快金咨询号
     ************************************************************************************************************************************/
    public function action_FollowTimecash(){
        $view = View::factory($this->_vv.'BannerWeb/FollowTimecash');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

    public function action_TestJsWxFollow(){
        $view = View::factory($this->_vv.'Error/FocusOnWechat');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }



}