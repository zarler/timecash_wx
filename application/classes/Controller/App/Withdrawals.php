<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 提现页面
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_App_Withdrawals extends AppHome
{
    protected $_activity = null;
    protected $_signPackage = null;
    //构造方法  如果已登录  直接跳转到用户页面
    public function before()
    {
        parent::before();
    }

    /************************************************************************************************************************************
     *  提现首页
     ************************************************************************************************************************************/
    public function action_HomePage(){
        $this->Load();
        $variable = array(
            "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('Wallet','Withdraw','',array('json'=>$json_info));
//        Tool::factory('Debug')->D($result);
        if(isset($result['code']) && $result['code']==1000){
            if(isset($result['result'])&&Valid::not_empty($result['result'])){
                parent::$_VArray['data'] = $result['result'];
                //点击按钮
                parent::$_VArray['submit'] = 'javascript:submit()';
            }else{
                $this->error(Kohana::message('wx','system_busy'));
                die;
            }
        }else{
            if(isset($result['code'])){
                $this->error($result['message']);
                die;
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
                die;
            }
        }
        parent::$_VArray['title'] = '现金提现';
        //提现请求
        parent::$_VArray['reqUrl'] = '/app/Functions4/Withdrawals';
        parent::$_VArray['jumpUrl'] = '/app/Withdrawals/Static';
        $view = View::factory($this->_vv.'Withdrawals/HomePage');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    //  提现成功
    public function action_Static(){
        $this->Load();
        parent::$_VArray['title'] = '提现成功';
        parent::$_VArray['gobackUrl'] = '/?#jump=BannerAppHome';
        $view = View::factory($this->_vv.'Withdrawals/Static');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
}