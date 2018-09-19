<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 功能ajax请求核心文件
 * */
class Controller_Wx_FunctionsAct  extends WxHome {
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
                    "app"=>$this->getWxInfo()
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

    /******************************************************************************************
     *  活动统一统计
     ******************************************************************************************/

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
                    $activity->insert_statistics(array('action'=>$_POST['action'],'user_id'=>Gv::$_userInfo['user_id'],'ip'=>$this->_ip,'create_time'=>time(),'event_name'=>$event_name,'reg_app'=>'wechat'),'ac_userid_count');
                }
            }else{
                //只统计ip
                if($activity->get_statistics(array('ip'=>$this->_ip,'action'=>$_POST['action'],'event_name'=>$event_name),'ac_count')){
                    $activity->insert_statistics(array('action'=>$_POST['action'],'ip'=>$this->_ip,'create_time'=>time(),'event_name'=>$event_name,'reg_app'=>'wechat'),'ac_count');
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
            $activity->insert_statistics(array('action'=>$_POST['action'],'user_id'=>isset(Gv::$_userInfo['user_id'])?Gv::$_userInfo['user_id']:null,'ip'=>trim($this->_ip),'create_time'=>time(),'event_name'=>$_POST['event_name'],'reg_app'=>'wechat'),'ac_count');
            exit(json_encode(array('status' =>true)));
        }
    }
    /*---------------end活动统计------------------------*/
    //打卡
    public function action_PunchClock(){

        if($this->request->is_ajax() && $_POST) {
            if(empty(Gv::$_userInfo['user_id'])){//未登录
                exit(json_encode(array('status' =>false,'msg'=>'未登录')));
            }else{
                $variable = array(
                    "app"=>$this->getWxInfo()
                );
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('CheckIn','check_in','',array('json'=>$json_info));
                if(isset($result['code']) && $result['code']==1000){
                    if(isset($result['result']['num'])&&$result['result']['num']>1){
                        exit(json_encode(array('status' =>true,'msg'=>$result['message'])));
                    }else{
                        exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                    }
                }else{
                    if(isset($resultList['code'])){
                        exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            }
        }else{
            //非法请求
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
        }
    }
    //打卡兑换优惠券
    public function action_ExchangeCoupon(){
//            exit(json_encode(array('status' =>true,'msg'=>'兑换成功')));
        if($this->request->is_ajax() && $_POST) {
            if(empty(Gv::$_userInfo['user_id'])){//未登录
                exit(json_encode(array('status' =>false,'msg'=>'未登录')));
            }else{
                if(!isset($_POST['templateId'])||empty($_POST['templateId'])){
                    //非法请求
                    exit(json_encode(array('status' =>false,'msg'=>'参数为空')));
                }
                $variable = array(
                    'template_id'=>$_POST['templateId'],
                    "app"=>$this->getWxInfo()
                );
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('CheckIn','exchange','',array('json'=>$json_info));
                if(isset($result['code']) && $result['code']==1000){
                    exit(json_encode(array('status' =>true,'msg'=>$result['message'])));
                }else{
                    if(isset($result['code'])){
                        exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            }
        }else{
            //非法请求
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
        }
    }


    //分享统计,只限微信统计(app统计用微盟后台)
    public function action_shareWx(){
        if ($this->request->is_ajax() && $_POST) {
            //只统计微信端
                $openid = Gv::$_Openid;
                if(!empty($openid)){
                    //$_POST['time']为0表示无限制记录
                    if(isset($_POST['event_name'])&&(isset($_POST['time'])&&(time()<$_POST['time']||$_POST['time']==0))){
                        $activity = Model::factory('Activity');
                        if($activity->get_share_info(array('uniqueid'=>$openid,'event_name'=>$_POST['event_name'].'_SHARE'))){
                            $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
                            $ip = explode(",",$ip)[0];
                            $pagetype = '/'.$this->_controller.'/'.$this->_action;
                            $activity->insert_browse_info(array('uniqueid'=>$openid,'pagetype'=>$pagetype,'reg_app'=>'wechat','user_id'=>(isset(Gv::$_userInfo['user_id'])&&!empty(Gv::$_userInfo['user_id']))?Gv::$_userInfo['user_id']:0,'event'=>$_POST['action'],'ip'=>trim($ip),'create_time'=>time(),'event_name'=>$_POST['event_name'].'_SHARE'));
                        }
                    }
                }
        }
        exit(json_encode(array('status' =>true)));
    }
    //分享统计,只限微信统计(app统计用微盟后台)
    public function action_shareWxAll(){
        if ($this->request->is_ajax() && $_POST) {
            //只统计微信端
            $openid = Gv::$_Openid;
            if(!empty($openid)){
                //$_POST['time']为0表示无限制记录
                    $activity = Model::factory('Activity');
                    $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
                    $ip = explode(",",$ip)[0];
                    $pagetype = '/'.$this->_controller.'/'.$this->_action;
                    $activity->insert_browse_info(array('uniqueid'=>$openid,'pagetype'=>$pagetype,'reg_app'=>'wechat','user_id'=>(isset(Gv::$_userInfo['user_id'])&&!empty(Gv::$_userInfo['user_id']))?Gv::$_userInfo['user_id']:0,'event'=>$_POST['action'],'ip'=>trim($ip),'create_time'=>time(),'event_name'=>$_POST['event_name']));
                }
        }
        exit(json_encode(array('status' =>true)));
    }

    //优惠券立即借款点击统计
    public function action_statisticsCouponOk(){
        if ($this->request->is_ajax() && $_POST) {
            if(Valid::not_empty(Gv::$_userInfo['user_id'])){
                $activity = Model::factory('Activity');
                //用户uv统计
                //if($activity->select_userid_day(array('user_id'=>Gv::$user_id,'action'=>'click','event_name'=>'TCOA_008_CLICK'),'ac_count',false)){
                //插入
                $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR'])&&$_SERVER['HTTP_X_FORWARDED_FOR']?$_SERVER['HTTP_X_FORWARDED_FOR']:(isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'');
                $ip = explode(",",$ip)[0];
                $activity->insert_userid_day(array('user_id'=>Gv::$user_id,'event_name'=>'TCOA_008_CLICK','ip'=>$ip,'action'=>'click','create_time'=>time()),'ac_count');
                //}
            }
        }
        exit(json_encode(array('status' =>true)));
    }

    /************************************************************************************************************************************
     * 017红包雨，扣除抽奖次数
     ************************************************************************************************************************************/
    public function action_017DeductTimes(){
        if ($this->request->is_ajax() && $_POST) {
            $variable = array(
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            //减去抽奖次数
            $result = $this->_api->getApiArrays('AC_TCOA017','CountTimes','',array('json'=>$json_info));
            if(isset($result['code']) && $result['code']==1000){
                exit(json_encode(array('status' =>true,'times'=>$result['result']['times'])));
//                exit(json_encode(array('status' =>true,'times'=>$result['result']['times'])));
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
    //017红包雨，抽奖
    public function action_017LuckDraw(){
        if ($this->request->is_ajax() && $_POST) {
            $variable = array(
                "app"=>$this->getWxInfo()
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

    public function action_017LuckZan(){
        if ($this->request->is_ajax() && $_POST) {
            if(!isset($_POST['userId'])||!Valid::not_empty($_POST['userId'])){
                exit(json_encode(array('status' =>false,'msg'=>'参数错误！')));
            }
            $variable = array(
                'user_id' => $_POST['userId'],
                'open_id' => Gv::$_Openid,
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            //减去抽奖次数
            $result = $this->_api->getApiArrays('AC_TCOA017','Fllow','',array('json'=>$json_info));
            if(isset($result['code']) && $result['code']==1000){
                exit(json_encode(array('status' =>true,'msg'=>$result)));
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
                "app"=>$this->getWxInfo()
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
//            exit(json_encode(array('status' =>true,'prize'=>$prize,'code'=>$code)));
            $variable = array(
                "app"=>$this->getWxInfo()
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
                    "app"=>$this->getWxInfo()
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
    //转盘
    public function action_026Turntable(){
        if ($this->request->is_ajax() && $_POST) {


        }else{
            //非法请求
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
        }
    }
}