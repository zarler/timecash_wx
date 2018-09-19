<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 我的卡片
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_Wx_MyCard extends WxHome
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
     * 选卡列表
     *******************************************************/
    public function action_BuyList(){

        $variable = array(
            "app"=>$this->getWxInfo()
        );
        $json_info = json_encode($variable);
        //可用列表
        $result = $this->_api->getApiArrays('SpeedUpCard','BuyList','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            if(isset($result['result']['list']) && Valid::not_empty($result['result']['list'])){
                //有可售卡包
                parent::$_VArray['list'] = $result['result']['list'];
            }else{
                //无可售卡包
                parent::$_VArray['list'] = null;
            }
        }else{
            if(isset($result['code'])){
                $this->error($result['message']);
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
            }
        }

        parent::$_VArray['title'] = '购买快审卡';
        //购卡页面
        parent::$_VArray['jumpUrl'] = '/wx/MyCard/Buy';
        //跳转页面(区分微信和app的)
        //分享
        $view = View::factory($this->_vv.'MyCard/BuyList');
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);
    }

    /*******************************************************
     * 购卡页面
     *******************************************************/
    public function action_Buy(){

        if(!isset($_GET['id'])||!isset($_GET['num'])||!isset($_GET['price'])||!isset($_GET['name'])){
            $this->error('参数错误！');
        }
        //请求当前订单
        $variable = array(
            "app"=>$this->getWxInfo()
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('Order','Current','',array('json'=>$json_info));

        if(isset($result) && $result['code']==1000){
            //注册成功,插入用户id
            $order['repayment_amount'] = bcsub($result['result']['order']['repayment_amount'],$result['result']['order']['refunded_amount'], 2);
            $order['bankcard_no'] = substr($result['result']['order']['bankcard_no'],-4);
            $order['bankcard_name'] = $result['result']['order']['bank_short_name'];
            $order['order_id'] = Libs::factory('AES126')->encrypt($result['result']['order']['id'],$this->_api_config['wx']['app_key']);
            //判断是否允许买卡
            if($result['result']['order']['status'] == Model_Home::PAGE_TO_READY){
                //可以买卡
                parent::$_VArray['codeReq'] = 'codeRep();';
                parent::$_VArray['submitReq'] = 'javascript:submit();';
            }else{
                //不能买卡
                parent::$_VArray['codeReq'] = "commonUtil.cancelShowMsg('您需要先申请一笔借款，再购买审核卡','确定');";
                parent::$_VArray['submitReq'] = "javascript:commonUtil.cancelShowMsg('您需要先申请一笔借款，再购买审核卡','确定');";
            }
            parent::$_VArray['order'] = $order;


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
        parent::$_VArray['title'] = '购买快审卡';
        parent::$_VArray['cardInfo'] = $_GET;
        //发送短信
        parent::$_VArray['codeurl'] = '/wx/Functions/BuyCardVerifySMS';
        //购卡提交接口
        parent::$_VArray['submit'] = '/wx/Functions/BuyCardSubmit';
        //购卡后跳转页面
        parent::$_VArray['jumpUrl'] = '/wx/MyCard/BuyStatus';
        $view = View::factory($this->_vv.'MyCard/Buy');
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);
    }

    /*******************************************************
     * 购卡结果页
     *******************************************************/
    public function action_BuyStatus(){

        parent::$_VArray['url'] = '/wx/MyCard/MyList';


        $view = View::factory($this->_vv.'MyCard/Status');
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);
    }

    /*******************************************************
     * 卡包浏览列表
     *******************************************************/
    public function action_MyList(){

        $variable = array(
            "app"=>$this->getWxInfo()
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('SpeedUpCard','MyListAvailable','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            if(isset($result['result']['list'])&&Valid::not_empty($result['result']['list'])){
                parent::$_VArray['MyListAvailable'] = $result['result']['list'];
                parent::$_VArray['lastIdA'] = $result['result']['last_id'];
                parent::$_VArray['CountA'] = count($result['result']['list']);
            }else{
                parent::$_VArray['MyListAvailable'] = null;
            }
        }else{
            if(isset($result['code'])){
                $this->error($result['message']);
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
            }
        }
        //用卡历史列表
        $result = $this->_api->getApiArrays('SpeedUpCard','MyListHistory','',array('json'=>$json_info));

        if(isset($result['code']) && $result['code']==1000){
            if(isset($result['result']['list'])&&Valid::not_empty($result['result']['list'])){
                foreach ($result['result']['list'] as $key=>&$val){
                    $val['expire_time'] = date('Y-m-d',$val['expire_time']);
                }
                parent::$_VArray['MyListHistory'] = $result['result']['list'];
                parent::$_VArray['lastIdH'] = $result['result']['last_id'];
                parent::$_VArray['CountH'] = count($result['result']['list']);

            }else{
                parent::$_VArray['MyListHistory'] = null;
            }
        }else{
            if(isset($result['code'])){
                $this->error($result['message']);
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
            }
        }
        parent::$_VArray['title'] = '我的快审卡';
        parent::$_VArray['url'] = '/wx/Functions/MayCardMore';
        $view = View::factory($this->_vv.'MyCard/MyList');
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);

    }


    
}