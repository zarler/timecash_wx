<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
class Controller_Register extends WxHome
{
    //构造方法  如果已登录  直接跳转到用户页面
    public function before()
    {
        parent::before();
        //$auth = $this->isstatus($openid['openid']);
        //用于注册的身份id
        $validated_identity = $this->session->sessionGet('validated_identity');
        //判断是否上传了身份证
        if ($validated_identity == '1') {
            $this->redirect('User/index');
        }
    }


    //发送模板到注册页面
    public function action_Index()
    {
        //$this->depollute($this->request->post());
        //注册生成新的用户id并插入微信关联表
        $userinfo = Model::factory('Home')->dbselect('user_wechat','user_id',array('openid'=>Wxgv::$wx['openid'],'status'=>1));
        if (Valid::not_empty($userinfo['user_id']))
        {
            $this->redirect('RegisterApp/Company');
        }
        $view = View::factory('Register/index');
        //print_r(Session::instance()->as_array());
        //模板title输出
        $view->title = Kohana::$config->load('url.title.register');
        $this->response->body($view);
    }
    //身份证照片验证
    public function action_identity()
    {
        //
//        $this->credit_url($this->action);
        $view = View::factory('Register/identity');
        //print_r(Session::instance('database')->as_array());
        $view->signPackage = $this->signPackage();
        //$view->sex = $this->user->get_sex();
        $view->sex = array('sex'=>'男');
        $view->title = Kohana::$config->load('url.title.identity');
        $this->response->body($view);
    }




}