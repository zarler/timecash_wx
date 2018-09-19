<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  V3分离开--->我的钱包---->微信专用
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_Wx_MyWallet extends WxHome
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


    //端午节整点抢活动
    public function action_HomePage(){

        $variable = array(
            "app"=>$this->getWxInfo()
        );
        $json_info = json_encode($variable);
//        $result = $this->_api->getApiArrays('Coin','Info','',array('json'=>$json_info));
        $result = $this->_api->getApiArrays('Wallet','Info','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            parent::$_VArray['coin'] = isset($result['result']['money'])?$result['result']['money']:0;
            parent::$_VArray['coupon_num'] = isset($result['result']['coupon_num'])?$result['result']['coupon_num']:0;
        }else{
            if(isset($result['code'])){
                $this->error($result['message']);
                exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
            }
        }
        parent::$_VArray['title'] = '我的钱包';
        //跳转页面(区分微信和app的)
        parent::$_VArray['urlCoin'] = '/wx/MyWallet/Detailed';
        parent::$_VArray['urlCoupon'] = '/wx/CouponList/coupon';
        parent::$_VArray['urlDailyCoupons'] = '/wx/Activity/TC0A016';
        //提现地址
        parent::$_VArray['urlWithdrawals'] = '/wx/Withdrawals/HomePage';
        //分享
        parent::$_VArray['shareButton'] = 'javascript:bomob_screen.showMask(true);';

        $view = View::factory($this->_vv.'Wallet/HomePage');
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);
    }
    //余额说明(明细)
    public function action_Detailed(){
        //获取明细
        $variable = array(
            "app"=>$this->getWxInfo()
        );
        $json_info = json_encode($variable);
//        $result = $this->_api->getApiArrays('Coin','GainList','',array('json'=>$json_info));
        $result = $this->_api->getApiArrays('Wallet','GainList','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            if(isset($result['result']['list'])&&!empty($result['result']['list'])&&is_array($result['result']['list'])){
                $strList = '';
                foreach ($result['result']['list'] as $key=>$val){
                    parent::$_VArray['gainlastId'] = $val['id'];
                    $strList .=  '<section class="walletList"><span>'.$val['msg'].'</span><br><label class="grepApan">'.date('Y-m-d h:m:s',$val['create_time']).'</label><strong style="float: right">+'.$val['money'].'元</strong></section>';
                    $last_id = $val['id'];
                }
                if(count($result['result']['list'])>=20){
                    parent::$_VArray['gainlastId'] = $last_id;
                }else{
                    parent::$_VArray['gainlastId'] = 0;
                }
            }else {
                //无数据
                $strList = '';
                parent::$_VArray['gainlastId'] = 0;
            }
        }else{
            if(isset($result['code'])){
                $this->error($result['message']);
                exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
            }
        }
        //使用明细
//        $result = $this->_api->getApiArrays('Coin','UseList','',array('json'=>$json_info));
        $result = $this->_api->getApiArrays('Wallet','UseList','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            if(isset($result['result']['list'])&&!empty($result['result']['list'])&&is_array($result['result']['list'])){
                $strUserList = '';
                foreach ($result['result']['list'] as $key=>$val){
                    parent::$_VArray['userlastId'] = $val['id'];
                    $strUserList .=  '<section class="walletList"><span>'.$val['msg'].'</span><br><label class="grepApan">'.date('Y-m-d h:m:s',$val['create_time']).'</label><strong style="float: right">-'.$val['money'].'元</strong></section>';
                    $last_id = $val['id'];
                }
                if(count($result['result']['list'])>=20){
                    parent::$_VArray['userlastId'] = $last_id;
                }else{
                    parent::$_VArray['userlastId'] = 0;
                }
            }else {
                //无数据
                $strUserList = "";
                parent::$_VArray['userlastId'] = 0;
            }
        }else{
            if(isset($result['code'])){
                $this->error($result['message']);
                exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
            }
        }
        parent::$_VArray['title'] = '余额明细';
        parent::$_VArray['strList'] = $strList;
        parent::$_VArray['strUserList'] = $strUserList;
        //加载更多
        parent::$_VArray['apiUrl'] = '/app/Functions/WalletDetailed';

        //跳转页面(区分微信和app的)
        parent::$_VArray['urlHome'] = '/wx/MyWallet/HomePage';
        parent::$_VArray['urlExplain'] = '/wx/MyWallet/Explain';
        parent::$_VArray['urlPeoplePull'] = '/v3/PeoplePull/HomePage';

        $view = View::factory($this->_vv.'Wallet/Detailed');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    //余额说明(明细)
    public function action_Explain(){
        parent::$_VArray['title'] = '余额说明';
        parent::$_VArray['urlHome'] = 'javascript:history.go(-1);';
        $view = View::factory($this->_vv.'Wallet/Explain');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    
}