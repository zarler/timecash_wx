<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 功能ajax请求核心文件
 * */
class Controller_App_FunctionsAct  extends AppHome {
    //如果已登录  直接跳转到用户页面
    public function before(){
        parent::before();
        $this->_model['AES26'] = Libs::factory('AES126');
    }
    /*-------------------------------------------登陆，修改密码----------------------------------------------------------*/
    /******************************************************************************************
     *  016获取优惠券
     ******************************************************************************************/
    public function action_016GetCoupon(){
        if($this->request->method()==='POST'){
            if(isset($_POST['code'])&&Valid::numeric($_POST['code'])){
                $variable = array(
                    'coupon_id'=>$_POST['code'],
                    "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
                );
                $json_info = json_encode($variable);
                $result_info = $this->_api->getApiArrays('Activity_Coupon','Get','',array('json'=>$json_info));
                if(isset($result_info) && $result_info['code']==1000){
                    //保存信息
                    exit(json_encode(array('status' =>true)));
                }else{
                    if(isset($result_info['code'])){
                        exit(json_encode(array('status' =>false,'msg'=>$result_info['message'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            }else{
                //$this->err('非法请求！');
                exit(json_encode(array('status' =>false,'msg'=>'请求数据错误！')));
            }
        }else{
            //$this->err('非法请求！');
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
        }
    }


    //统计按钮点击(登录用户和非登录用户同时统计)
    public function action_statisticsUserIdIp(){
        if ($this->request->is_ajax() && $_POST) {
            //统计
            $activity = Model::factory('Activity');

            if(!isset($_POST['action'])||!isset($_POST['event_name'])){
                return false;
            }
            switch ($_POST['action']){
                case 'look':
                    $event_name = $_POST['event_name'].'_LOOK';
                    break;
                case 'click':
                    $event_name = $_POST['event_name'].'_CLCK';
                    break;
                default:
                    $event_name = $_POST['event_name'];
                    break;
            }
            //判断是否是微信

            if(Valid::not_empty(Gv::$_userInfo['user_id'])){
                if($activity->get_statistics(array('action'=>$_POST['action'],'user_id'=>Gv::$_userInfo['user_id'],'event_name'=>$event_name),'ac_userid_count')){
                    $activity->insert_statistics(array('action'=>$_POST['action'],'user_id'=>Gv::$_userInfo['user_id'],'ip'=>trim($this->_ip),'create_time'=>time(),'event_name'=>$event_name,'reg_app'=>'app'),'ac_userid_count');
                }
            }else{
                //只统计ip
                if($activity->get_statistics(array('ip'=>trim($this->_ip),'action'=>$_POST['action'],'event_name'=>$event_name),'ac_count')){
                    $activity->insert_statistics(array('action'=>$_POST['action'],'ip'=>trim($this->_ip),'create_time'=>time(),'event_name'=>$event_name,'reg_app'=>'app'),'ac_count');
                }
            }
            exit(json_encode(array('status' =>true)));
        }
    }

    //统计按钮点击(登录用户和非登录用户同时统计)
    public function action_statisticsUserIdIpAll(){
        if ($this->request->is_ajax() && $_POST) {
            if(!isset($_POST['action'])||!isset($_POST['event_name'])){
                return false;
            }
            $activity = Model::factory('Activity');
            $activity->insert_statistics(array('action'=>$_POST['action'],'user_id'=>isset(Gv::$_userInfo['user_id'])?Gv::$_userInfo['user_id']:null,'ip'=>trim($this->_ip),'create_time'=>time(),'event_name'=>$_POST['event_name'],'reg_app'=>'app'),'ac_count');
            exit(json_encode(array('status' =>true)));
        }
    }


    /************************************************************************************************************************************
     * 017红包雨，抽奖
     ************************************************************************************************************************************/
    //减次数
    public function action_017DeductTimes(){
        if ($this->request->is_ajax() && $_POST) {
            $variable = array(
                "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
            );
            $json_info = json_encode($variable);
            //减去抽奖次数
            $result = $this->_api->getApiArrays('AC_TCOA017','CountTimes','',array('json'=>$json_info));
            if(isset($result['code']) && $result['code']==1000){
                exit(json_encode(array('status' =>true,'times'=>$result['result']['times'])));
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }
    }


    public function action_017LuckDraw(){
        if ($this->request->is_ajax() && $_POST) {
            $variable = array(
                "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
            );
            $json_info = json_encode($variable);
            //减去抽奖次数
            $result = $this->_api->getApiArrays('AC_TCOA017','GetPrize','',array('json'=>$json_info));
            if(isset($result['code']) && $result['code']==1000){
                if(isset($result['result']['action'])&&$result['result']['action']!='0'){
                    //中奖
                    $result['result']['msg'] = '恭喜您本次红包雨获得'.$result['result']['prize'].'优惠券';
                    $result['result']['prize'] = $result['result']['prize'];
                    if($result['result']['action'] == 'free'){
                        $result['result']['msg'] = '恭喜您在本次红包雨中获得免单';
                        $result['result']['prize'] = '免单';
                    }
                    if($result['result']['action'] == 'increase'){
                        $result['result']['msg'] = '恭喜您在本次红包雨中获得提额500元';
                        $result['result']['prize'] = '提额';
                    }
                    if($result['result']['action'] == '310'){
                        $result['result']['msg'] = '恭喜您在本次红包雨中获得免息';
                        $result['result']['prize'] = '免息';
                    }
                    exit(json_encode(array('status' =>true,'msg'=>$result['result'])));
                }else{
                    //没中
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }
    }


    //重新获取剩余抽奖次数
    public function action_017GetTimes(){
        if ($this->request->is_ajax() && $_POST) {
            $variable = array(
                "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
            );
            $json_info = json_encode($variable);
            //减去抽奖次数
            $result = $this->_api->getApiArrays('AC_TCOA017','Times','',array('json'=>$json_info));
            if(isset($result['code']) && $result['code']==1000){
                if(isset($result['result']['times'])&&$result['result']['times']>0){
                    exit(json_encode(array('status' =>true)));
                }else{
                    exit(json_encode(array('status' =>false)));
                }
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }
    }
    //获取随机中奖id
    public function action_019LuckDraw(){
        if ($this->request->is_ajax() && $_POST) {
//            $prize = '100';
//            switch ($prize){
//                case '800':
//                    $code = 0;
//                    break;
//                case '500':
//                    $code = 1;
//                    break;
//                case '300':
//                    $code = 2;
//                    break;
//                case '100':
//                    $code = 3;
//                    break;
//                default:
//                    break;
//            }
//
//            exit(json_encode(array('status' =>true,'prize'=>$prize,'code'=>$code)));
            $variable = array(
                "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
            );
            $json_info = json_encode($variable);
            //减去抽奖次数
            $result = $this->_api->getApiArrays('AC_TCOA019','GetPrize','',array('json'=>$json_info));
            if(isset($result['code']) && $result['code']==1000){
                if(isset($result['result']['prize'])&&$result['result']['prize']>0){
                    switch ($result['result']['prize']){
                        case '800':
                            $code = 0;
                            break;
                        case '500':
                            $code = 1;
                            break;
                        case '300':
                            $code = 2;
                            break;
                        case '100':
                            $code = 3;
                            break;
                        default:
                            break;
                    }
                    exit(json_encode(array('status' =>true,'prize'=>$result['result']['prize'],'code'=>$code)));
                }else{
                    exit(json_encode(array('status' =>false)));
                }
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }
    }
    /************************************************************************************************************************************
     * 026 人拉人活动
     ************************************************************************************************************************************/
    public function action_026MyPrice(){
        if ($this->request->is_ajax() && $_POST) {
            if(isset($_POST['id'])&&Valid::not_empty($_POST['id'])){
                $variable = array(
                    'prize_id'=>$_POST['id'],
                    "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
                );
                $json_info = json_encode($variable);
                //减去抽奖次数
                $result = $this->_api->getApiArrays('AC_TCOA026','InviterGetPrize','',array('json'=>$json_info));
                if(isset($result['code']) && $result['code']==1000){
                    exit(json_encode(array('status' =>true,'id'=>$_POST['id'])));
                }else{
                    if(isset($result['code'])){
                        exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            }else{
                //非法请求
                exit(json_encode(array('status' =>false,'msg'=>'异常数据')));
            }

        }else{
            //非法请求
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
        }
    }



}