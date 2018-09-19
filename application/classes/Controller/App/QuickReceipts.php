<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 普付宝对接
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_App_QuickReceipts extends AppHome
{
    protected $_activity = null;
    protected $_signPackage = null;

    //构造方法  如果已登录  直接跳转到用户页面
    public function before()
    {
        parent::before();
        //$this->_activity = Model::factory('Activity');
        //$this->_signPackage = $this->signPackage();
    }

    /*******************************************************
     * 跳转到该页面
     *******************************************************/
    public function action_Index(){
        echo '<div class="t-mask-loading" style="display: block"><img style="width:160px;margin: 530px auto 1000px auto;display: -webkit-box;" src="/static/images/v2/loading.gif"></div>';
        $variable = array(
            "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
        );
        $json_info = json_encode($variable);
        //判断是否有注册银行卡
        $resultBank = $this->_api->getApiArrays('BankCard','List','',array('json'=>$json_info));
        if(isset($resultBank['code']) && $resultBank['code']==1000){
            if(count($resultBank['result']['bank_card_list'])>0){
                //有银行卡（请求普付宝）
                $result = $this->_api->getApiArrays('PuFuBao_QuickReceipts','Go','',array('json'=>$json_info));
                if(isset($result['code']) && $result['code']==1000){
                    if(isset($result['result']['pufubao_url']) && Valid::not_empty($result['result']['pufubao_url'])){
                        $this->redirect($result['result']['pufubao_url']);
                    }else{
                        //系统繁忙，请联系客服！
                        $this->error('异常错误','',1);
                        die;
                    }
                }else{
                    if(isset($result['code'])){
                        $this->error($result['message'],'',1);
                        die;
                    }else{
                        //系统繁忙，请联系客服！
                        $this->error(Kohana::message('wx','system_busy'),'',1);
                        die;
                    }
                }
            }else{
                //无银行卡跳转(添加银行卡)
                $this->redirect('/app/QuickReceipts/addbank');
            }
        }else{
            if(isset($resultBank['code'])){
                $this->error($resultBank['message'],'',1);
                die;
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'),'',1);
                die;
            }
        }
    }

    /*******************************************************
     * 添加银行卡
     *******************************************************/
    public function action_addbank(){
        $variable = array(
            "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
        );
        $json_info = json_encode($variable);
        //获取所有银行
        $bank = $this->_api->getApiArrays('Settings','Index','',array('json'=>$json_info));
        if(isset($bank['code']) && $bank['code']==1000){
            //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
            parent::$_VArray['bank'] = $bank['result']['bank'];
        }else{
            if(isset($bank['code'])){
                $this->error($bank['message']);
                die;
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
                die;
            }
        }
        //借钱最大额度 真名 写入session
        parent::$_VArray['userinfo'] = Gv::$_userInfo;
        parent::$_VArray['title'] = Kohana::$config->load('url.title.bankinfo');
        parent::$_VArray['requestUrl'] = "/app/Functions/addbank";

        parent::$_VArray['entrance'] = "/app/QuickReceipts";

        parent::$_VArray['backurl'] = '/?#jump=no';
        parent::$_VArray['prompt'] = '良好的信用，从按时还款开始。<br /><br />恶意逾期将影响您的征信。';
        $view = View::factory($this->_vv.'Borrowmoney/bank');
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);
    }


    
}