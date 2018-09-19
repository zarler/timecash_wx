<?php defined('SYSPATH') or die('No direct script access.');
/*
 *我的钱包
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_Wallet extends Home
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

        $view = View::factory($this->_vv.'WalletOld/HomePage');
        if(Gv::$type == 1){
            $app = $this->getapp();
        }elseif(Gv::$type == 2){
            $app = $this->getappapp($this->_app_session['token']);
        }else{
            $this->error('获取信息失败!');
        }
        $variable = array(
            "app"=>$app
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('Coin','Info','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            $view->coin = isset($result['result']['coin'])?$result['result']['coin']:0;
            $view->coupon_num = isset($result['result']['coupon_num'])?$result['result']['coupon_num']:0;
        }else{
            if(isset($result['code'])){
                $this->error($result['message']);
                exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
            }
        }
        $view->title = '我的钱包';
        $this->response->body($view);
    }
    //余额说明(明细)
    public function action_Detailed(){
        $view = View::factory($this->_vv.'WalletOld/Detailed');
        //获取明细
        if(Gv::$type == 1){
            $app = $this->getapp();
        }elseif(Gv::$type == 2){
            $app = $this->getappapp($this->_app_session['token']);
        }else{
            $this->error('获取信息失败!');
        }
        $variable = array(
            "app"=>$app
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('Coin','GainList','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            if(isset($result['result']['list'])&&!empty($result['result']['list'])&&is_array($result['result']['list'])){
                $strList = '';
                foreach ($result['result']['list'] as $key=>$val){
                    $view->gainlastId = $val['id'];
                    $strList .=  '<section class="walletList"><span>'.$val['action'].'</span><br><label class="grepApan">'.$val['create_time'].'</label><strong style="float: right">+'.$val['coin'].'元</strong></section>';
                    $last_id = $val['id'];
                }
                if(count($result['result']['list'])>=20){
                    $view->gainlastId = $last_id;
                }else{
                    $view->gainlastId = 0;
                }
            }else {
                //无数据
                $strList = '';
                $view->gainlastId = 0;
            }
        }else{
            if(isset($resultList['code'])){
                $this->error($result['message']);
                exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
            }
        }
        //使用明细
        $result = $this->_api->getApiArrays('Coin','UseList','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            if(isset($result['result']['list'])&&!empty($result['result']['list'])&&is_array($result['result']['list'])){
                $strUserList = '';
                foreach ($result['result']['list'] as $key=>$val){
                    $view->userlastId = $val['id'];
                    $strUserList .=  '<section class="walletList"><span>'.$val['type'].'</span><br><label class="grepApan">'.$val['create_time'].'</label><strong style="float: right">-'.$val['coin'].'元</strong></section>';
                    $last_id = $val['id'];
                }
                if(count($result['result']['list'])>=20){
                    $view->userlastId = $last_id;
                }else{
                    $view->userlastId = 0;
                }
            }else {
                //无数据
                $strUserList = "";
                $view->userlastId = 0;
            }
        }else{
            if(isset($resultList['code'])){
                $this->error($result['message']);
                exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
            }
        }
        $view->title = '余额明细';
        $view->strList = $strList;
        $view->strUserList = $strUserList;
        $this->response->body($view);
    }
    //余额说明(明细)
    public function action_Explain(){
        $view = View::factory($this->_vv.'WalletOld/Explain');
        $view->title = '余额说明';
        $this->response->body($view);
    }
    
}