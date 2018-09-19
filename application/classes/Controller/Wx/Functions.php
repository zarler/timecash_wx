<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 功能ajax请求核心文件
 * */
class Controller_Wx_Functions  extends WxHome {
    //如果已登录  直接跳转到用户页面
    public function before(){
        parent::before();
        $this->_model['AES26'] = Libs::factory('AES126');
    }
    /*-------------------------------------------登陆，修改密码----------------------------------------------------------*/
    /**********************
     *  登陆验证
     **********************/
    public function action_dologin(){
        if($this->request->method()==='POST'){
            $valid = Validation::factory($_POST)
                ->rule('phone', 'not_empty')
                ->rule('phone', 'regex', array(':value', '/^(13\d|14[57]|15[012356789]|18\d|17[031678])\d{8}$/'))
                ->rule('password', 'not_empty')
                ->rule('password', 'min_length', array(':value', 6))
                ->rule('password', 'max_length', array(':value', 16))
                ->rule('password', 'regex', array(':value', '/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i'));
            if ($valid->check()) {
                $variable = array(
                    "mobile"=>addslashes($_POST['phone']),
                    "password"=>$this->_model['AES26']->encrypt($_POST['password'],$this->_api_config['wx']['app_key']),
                    "app"=>$this->getWxInfo()
                );
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('User','Login','',array('json'=>$json_info) );
                if(isset($result['code']) && $result['code']==1000){
                    //保存信息
                    if(empty(Gv::$_Openid)){
                        exit(json_encode(array('status' =>false,'msg'=>'异常错误!')));
                        die;
                    }
                    $this->_User->set_user_wechat_info(array(
                        'user_id'=>$result['result']['user_id'],
                        'mobile'=>$result['result']['mobile'],
                        'nickname'=>$result['result']['name'],
                        'wechat_passport'=>$result['result']['wechat_passport']
                    ),Gv::$_Openid);
                    //删除activity活动
                    $this->_session->sessionDelete('activity');
                    exit(json_encode(array('status' =>true,'msg'=>$result['message'])));
                }else{
                    if(isset($result['code'])){
                        exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            }else {
                //表单提交上来的数据 如果判断失败是键值对 为了拿到一个错误值
                foreach ($valid->errors('errors') as $k) {
                    $call['status'][] = $k;
                }
                echo json_encode(array('status'=>false,'msg' => $call['status'][0]));
            }
        }else{
            //$this->err('非法请求！');
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
        }
    }
    /**********************
     *  退出登陆
     **********************/
    public function action_dooutlogin(){
        $variable = array(
            "app"=>$this->getWxInfo()
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('User','Logout','',array('json'=>$json_info));
        if(isset($result) && $result['code']==1000){
            exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
        }else{
            if(isset($result['code'])){
                exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
            }else{
                //系统繁忙，请联系客服！
                exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
            }
        }
    }
    /**********************
     *  修改密码发送手机验证码
     **********************/
    public function action_sendcode()
    {
        //判断是否是ajax请求  是否存在手机号
        if ($this->request->is_ajax() && $this->request->post('phone')) {
            $codesession = $this->_session->sessionGet('resetcode');
            exit($this->phoneCode($codesession, trim($this->request->post('phone')), 'resetcode'));
        } else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /**********************
     *  找回密码
     **********************/
    public function action_dobackpwd()
    {
        if($this->request->method()==='POST'){
            $valid = Validation::factory($_POST)
                ->rule('phone', 'not_empty')
                ->rule('phone', 'regex', array(':value', '/^(13\d|14[57]|15[012356789]|18\d|17[013678])\d{8}$/'))
                ->rule('authcode', 'not_empty')
                ->rule('authcode', 'exact_length', array(':value', 4));
            if ($valid->check()) {
                $variable = array(
                    "mobile"=>$_POST['phone'],
                    "verify_code"=>$_POST['authcode'],
                    "app"=>$this->getWxInfo()
                );
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('User','ResetPasswordVerify','',array('json'=>$json_info));
                if(isset($result) && $result['code']==1000){
                    //保存信息
                    $this->_session->sessionSet('resetpwd_token',$result['result']['resetpwd_token']);
                    $this->_session->sessionSet('mobile',$_POST['phone']);
                    exit(json_encode(array('status' =>true)));
                }else{
                    if(isset($result['code'])){
                        exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            }else {
                //表单提交上来的数据 如果判断失败是键值对 为了拿到一个错误值
                foreach ($valid->errors('errors') as $k) {
                    $call['status'][] = $k;
                }
                echo json_encode(array('status'=>false,'msg' => $call['status'][0]));
            }
        }else{
            //非法请求
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
        }
    }
    /**********************
     *  重置密码
     **********************/
    public function action_doresetpwd(){

        if ($this->request->is_ajax() && $_POST) {
            if($_POST['password']!=$_POST['passwordrepeat']){
                echo json_encode(array('status'=>false,'msg'=>Kohana::message('wx','password_difference')));
            }
            $valid = Validation::factory($_POST)
                ->rule('password', 'not_empty')
                ->rule('password', 'min_length', array(':value', 6))
                ->rule('password', 'max_length', array(':value', 16))
                ->rule('password', 'regex', array(':value', '/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i'));
            if ($valid->check()) {
                //可以修改成为session（后续修改）
                $id = Model::factory('Home')->dbfind(Gv::$_Openid,'openid','user_wechat','mobile');
                $session_mobile = $this->_session->sessionGet('mobile');
                $mobile = (isset($id['mobile'])&&Valid::not_empty($id['mobile']))?$id['mobile']:(Valid::not_empty($session_mobile)?$session_mobile:null);
                if(Valid::not_empty($mobile)){
                    $resetpwd_token = $this->_session->sessionGet('resetpwd_token');
                    if(isset($resetpwd_token)&&!empty($resetpwd_token)){
                        $variable = array(
                            "mobile"=>$mobile,
                            "new_password"=>$this->_model['AES26']->encrypt($_POST['password'],$this->_api_config['wx']['app_key']),
                            "resetpwd_token"=>$resetpwd_token,
                            "app"=>$this->getWxInfo()
                        );
                        $json_info = json_encode($variable);
                        $result = $this->_api->getApiArrays('User','ResetPassword','',array('json'=>$json_info));
                        if(isset($result) && $result['code']==1000){
                            //删除信息
                            $this->_session->sessionDelete('resetpwd_token');
                            $this->_session->sessionDelete('mobile');
                            if(isset(Gv::$_userInfo['user_id'])&&!empty(Gv::$_userInfo['user_id'])){
                                //删除登录状态
                                unset($variable['mobile']);
                                unset($variable['new_password']);
                                unset($variable['resetpwd_token']);
                                $json_info = json_encode($variable);
                                $result = $this->_api->getApiArrays('User','Logout','',array('json'=>$json_info));
                                if(isset($result) && $result['code']==1000){
                                    //退出成功
                                    //删除微信密码信息
                                    $this->_User->set_user_wechat_info_userid(array('user_id'=>NULL,'wechat_passport'=>NULL,'token'=>NULL),Gv::$_userInfo['user_id']);
                                }else{
                                    if(isset($result['code'])){
                                        exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                                    }else{
                                        //系统繁忙，请联系客服！
                                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                                    }
                                }
                            }
                            exit(json_encode(array('status' =>true)));
                        }else{
                            if(isset($result['code'])){
                                exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                            }else{
                                //系统繁忙，请联系客服！
                                exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                            }
                        }
                    }else{
                        //申请超时（resetpwd_token超时）
                        echo json_encode(array('status'=>false,Kohana::message('wx','application_timeout')));
                    }

                }else{
                    //手机号没有，非法请求页面
                    echo json_encode(array('status'=>false,Kohana::message('wx','illegal_request')));
                }
            }else {
                //表单提交上来的数据 如果判断失败是键值对 为了拿到一个错误值
                foreach ($valid->errors('errors') as $k) {
                    $call['status'][] = $k;
                }
                echo json_encode(array('status'=>false,'msg' => $call['status'][0]));
            }
        }else{
            //非法请求
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
        }
    }
    /*-----------------------------------------------------注册----------------------------------------------------------------------*/
    /**********************
     *  发送手机验证码
     **********************/
    public function action_registersendcode()
    {
        //判断是否是ajax请求  是否存在手机号
        if ($this->request->is_ajax() && $this->request->post('phone')) {
            //获得验证码,防止重复申请验证码
            $codesession = $this->_session->sessionGet('sendcode');
            exit($this->phoneCode($codesession, trim($this->request->post('phone')), 'sendcode'));
        } else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /**********************
     *  获得注册验证码
     *  发送手机验证码(活动)
     **********************/
    public function action_acRegistersendcode()
    {
        //首先判断是否是注册注册用户(如果是就送优惠券)
        if($this->request->is_ajax() && $_POST) {
//            exit(json_encode(array('status' =>true,'code'=>5007,'msg'=>'用户已注册')));
            if(!isset($_POST['phone'])&&!isset($_POST['user_id'])){
                //异常错误！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','数据参数错误'))));
            }
            //获得验证码,防止重复申请验证码
            $codesession = $this->_session->sessionGet('sendcode');
            exit($this->phoneCode($codesession, trim($this->request->post('phone')),'sendcode',$_POST['user_id']));
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }


    /**********************
     *  提交注册表单
     **********************/
    public function action_doregister()
    {


        if(!isset(Gv::$_Openid)||empty(Gv::$_Openid)){
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','wx_verification'))));
        }
        //判断是否重复注册
        $select_result = $this->_User->get_basic_userinfo(Gv::$_Openid);
        if(isset($select_result['user_id'])&&Valid::not_empty($select_result['user_id'])){
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','repeat_register'))));
        }
        if ($this->request->method() === 'POST') {
            $post = $this->request->post();
            if($post['aggreement']!=true){
                //没有同意协议！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','agree'))));
            }
            //对提交上来的字段做基本的验证
            $valid = Validation::factory($post)
                ->rule('authcode', 'not_empty')
                ->rule('authcode', 'exact_length', array(':value', 4))
                ->rule('password', 'not_empty')
                ->rule('password', 'min_length', array(':value', 6))
                ->rule('password', 'max_length', array(':value', 16))
                ->rule('password', 'regex', array(':value', '/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i'))
                ->rule('phone', 'not_empty')
                ->rule('phone', 'regex', array(':value', '/^(13\d|14[57]|15[012356789]|18\d|17[031678])\d{8}$/'));
            if ($valid->check()) {
                //手机验证码 是否过期 默认30分钟
                $sendcode = $this->_session->sessionGet('sendcode');
                //手机号验证是否与发送的一致
                if ($post['phone'] != $sendcode['mobile']) {
                    //手机和验证码不符
                    exit(json_encode(array('status' =>false,'msg' => Kohana::message('wx','modelcode_no'))));
                }
                //邀请码验证
                if(!empty($post['invitecode'])){
                    if(!preg_match('/^[0-9]{0,10}$/',$post['invitecode'])){
                        exit(json_encode(array('status' =>false,'msg' => Kohana::message('wx','invitecode_error'))));
                    }
                }
                $variable = array(
                    "mobile"=>addslashes($post['phone']),
                    "password"=>$this->_model['AES26']->encrypt($post['password'],$this->_api_config['wx']['app_key']),
                    "verify_code"=>$post['authcode'],
                    "agent_code"=>$post['invitecode'],
                    "ip"=>$_SERVER["REMOTE_ADDR"],
                    "app"=>$this->getWxInfo()
                );
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('User','Register','',array('json'=>$json_info));
                if(isset($result) && $result['code']==1000){
                    //注册成功,插入用户id
                    $update_result = $this->_User->set_user_wechat_info(array('user_id'=>$result['result']['user_id'],'mobile'=>$post['phone'],'wechat_passport'=>$result['result']['wechat_passport']),Gv::$_Openid);
                    if($update_result){
                        exit(json_encode(array('status' =>true)));
                    }else{
                        //异常错误
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','abnormal_error'))));
                    }
                }else{
                    if(isset($result['code'])){
                        exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            } else {
                //表单提交上来的数据 如果判断失败是键值对 为了拿到一个错误值
                foreach ($valid->errors('errors') as $k) {
                    $call['status'][] = $k;
                }
                echo json_encode(array('status'=>false,'msg' => $call['status'][0]));
            }

        } else {
            //$this->err('非法请求！');
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }

    /**********************
     *  人拉人注册
     *  提交注册表单
     **********************/
    public function action_peoplePullDoregister()
    {
        if(!isset(Gv::$_Openid)||empty(Gv::$_Openid)){
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','wx_verification'))));
        }
        //判断是否重复注册
        $select_result = $this->_User->get_basic_userinfo(Gv::$_Openid);
        if ($this->request->method() === 'POST') {
            $post = $this->request->post();
            //对提交上来的字段做基本的验证
            $valid = Validation::factory($post)
                ->rule('authcode', 'not_empty')
                ->rule('authcode', 'exact_length', array(':value', 4))
                ->rule('password', 'not_empty')
                ->rule('password', 'min_length', array(':value', 6))
                ->rule('password', 'max_length', array(':value', 16))
                ->rule('password', 'regex', array(':value', '/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i'))
                ->rule('phone', 'not_empty')
                ->rule('phone', 'regex', array(':value', '/^(13\d|14[57]|15[012356789]|18\d|17[031678])\d{8}$/'));

            if ($valid->check()) {
//                Tool::factory('Debug')->array2file(array($post,Valid::alpha_numeric($_POST['user_id'])), APPPATH.'../static/liu_test.php');
                if(isset($post['user_id'])&&Valid::not_empty($post['user_id'])){
                    if(!Valid::alpha_numeric($_POST['user_id'])){
                        //电话号码格式错误
                        $user_id = 0;
                        //exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','tell_error'))));
                    }else{
                        $user_id = $_POST['user_id'];
                    }
                }else{
                    $user_id = 0;
                }
                //手机验证码 是否过期 默认30分钟
                $sendcode = $this->_session->sessionGet('sendcode');
                //手机号验证是否与发送的一致
                if ($post['phone'] != $sendcode['mobile']) {
                    //手机和验证码不符
                    exit(json_encode(array('status' =>false,'msg' => Kohana::message('wx','modelcode_no'))));
                }
                //邀请码验证
                if(!empty($post['invitecode'])){
                    if(!preg_match('/^[0-9]{0,10}$/',$post['invitecode'])){
                        exit(json_encode(array('status' =>false,'msg' => Kohana::message('wx','invitecode_error'))));
                    }
                }
                $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
                $ip = explode(",",$ip)[0];
                $variable = array(
                    "mobile"=>addslashes($post['phone']),
                    "password"=>$this->_model['AES26']->encrypt($post['password'],$this->_api_config['wx']['app_key']),
                    "verify_code"=>$post['authcode'],
                    "inviter_user_id"=>$user_id,
                    "ip"=>$ip,
                    "app"=>$this->getWxInfo()
                );
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('User','Register','',array('json'=>$json_info));
                if(isset($result) && $result['code']==1000){
                    //注册成功,插入用户id
                    //if(!isset($select_result['user_id'])||!Valid::not_empty($select_result['user_id'])){
//                    Tool::factory('Debug')->array2file($result, APPPATH.'../static/liu_test.php');
                    $update_result = $this->_User->set_user_wechat_info(array('user_id'=>$result['result']['user_id'],'mobile'=>$post['phone'],'wechat_passport'=>$result['result']['wechat_passport']),Gv::$_Openid);
//                    Tool::factory('Debug')->array2file($update_result, APPPATH.'../static/liu_test.php');
                    //}
                    //exit(json_encode(array('status' =>true,'msg'=>$result['result']['user_id'])));
                    if($update_result){
                        exit(json_encode(array('status' =>true)));
                    }else{
                        //异常错误
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','abnormal_error'))));
                    }
                }else{
                    if(isset($result['code'])){
                        if($result['code']==5007){
                            exit(json_encode(array('status' =>false,'code'=>5007,'msg'=>$result['message'])));

                        }else{
                            exit(json_encode(array('status' =>false,'msg'=>$result['message'])));

                        }
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            } else {
                //表单提交上来的数据 如果判断失败是键值对 为了拿到一个错误值
                foreach ($valid->errors('errors') as $k) {
                    $call['status'][] = $k;
                }
                echo json_encode(array('status'=>false,'msg' => $call['status'][0]));
            }

        } else {
            //$this->err('非法请求！');
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /**********************
     *  活动老用户提交
     **********************/
    public function action_peoplePullDoregisterOld()
    {
//        exit(json_encode(array('status' =>true)));
        if(!isset(Gv::$_Openid)||empty(Gv::$_Openid)){
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','wx_verification'))));
        }
        //判断是否重复注册
        $select_result = $this->_User->get_basic_userinfo(Gv::$_Openid);
        if ($this->request->method() === 'POST') {
            $post = $this->request->post();
            //对提交上来的字段做基本的验证
            $valid = Validation::factory($post)
                ->rule('authcode', 'not_empty')
                ->rule('authcode', 'exact_length', array(':value', 4))
                ->rule('phone', 'not_empty')
                ->rule('phone', 'regex', array(':value', '/^(13\d|14[57]|15[012356789]|18\d|17[031678])\d{8}$/'));

            if ($valid->check()) {
//                Tool::factory('Debug')->array2file(array($post,Valid::alpha_numeric($_POST['user_id'])), APPPATH.'../static/liu_test.php');
                if(isset($post['user_id'])&&Valid::not_empty($post['user_id'])){
                    if(!Valid::alpha_numeric($_POST['user_id'])){
                        //电话号码格式错误
                        exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
                    }
                }else{
                    exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
                }
                //手机验证码 是否过期 默认30分钟
                $sendcode = $this->_session->sessionGet('sendcode');
                //手机号验证是否与发送的一致
                if ($post['phone'] != $sendcode['mobile']) {
                    //手机和验证码不符
                    exit(json_encode(array('status' =>false,'msg' => Kohana::message('wx','modelcode_no'))));
                }
                //邀请码验证
                if(!empty($post['invitecode'])){
                    if(!preg_match('/^[0-9]{0,10}$/',$post['invitecode'])){
                        exit(json_encode(array('status' =>false,'msg' => Kohana::message('wx','invitecode_error'))));
                    }
                }
                exit(json_encode(array('status' =>true,'user_id'=>$post['user_id'])));

            } else {
                //表单提交上来的数据 如果判断失败是键值对 为了拿到一个错误值
                foreach ($valid->errors('errors') as $k) {
                    $call['status'][] = $k;
                }
                echo json_encode(array('status'=>false,'msg' => $call['status'][0]));
            }

        } else {
            //$this->err('非法请求！');
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }

    /*-----------------------------------------------------立即借款----------------------------------------------------------------------*/

    /*******************************************************
     *  订单信息提交
     *******************************************************/
    public function action_borrowinfo(){


        if ($this->request->is_ajax() && $_POST) {
            //公式计算利息
            if(
                !Valid::not_empty($_POST['money'])
                ||!Valid::numeric($_POST['money'])
                ||!Valid::not_empty($_POST['day'])
                ||!Valid::numeric($_POST['day'])
                ||!Valid::not_empty($_POST['poundage'])
                ||!Valid::numeric($_POST['poundage'])
//                    ||!Valid::not_empty($_POST['ensure_rate_bu'])
//                    ||!Valid::numeric($_POST['ensure_rate_bu'])
//                ||!Valid::not_empty($_POST['latitude'])
//                ||!Valid::numeric($_POST['latitude'])
//                ||!Valid::not_empty($_POST['longitude'])
//                ||!Valid::numeric($_POST['longitude'])
                ||!Valid::numeric($_POST['coin'])
            ){
                //异常错误
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
            }
            //基础请求验证
            $app = $this->getWxInfo();
            /*----------------------------------获取地址取消---------------------------------------*/
            //计算利息
            //$poundage = $this->Poundage($_POST['money'],$_POST['day']);
            //定位用户地址（不是必选项）
            if(isset($_POST['longitude'])&&isset($_POST['latitude'])){
                if(Valid::not_empty($_POST['longitude'])&&Valid::not_empty($_POST['latitude'])){
                    $bdmap = $this->bd_map($_POST['longitude'],$_POST['latitude']);
                    $gps = array('longitude'=>$_POST['longitude'],'latitude'=>$_POST['latitude']);
                    if(!$bdmap || !$gps){
                        //获取地址失败
                        //exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','get_address_error'))));
                    }else{
                        //添加用户当前地址
                        //调接口
                        $variable = array(
                            "user_id"=>Gv::$_userInfo['user_id'],
                            "gps"=>$gps,
                            "baidu_map"=>$bdmap,
                            "app"=>$app
                        );
                        $json_info = json_encode($variable);
                        $this->_api->getApiArrays('Location','Log','',array('json'=>$json_info));
                    }
                }
            }



            /*----------------------------------获取地址取消---------------------------------------*/

            //优惠券
            if(Valid::not_empty($_POST['coupinid'])
                &&Valid::numeric($_POST['coupinid'])
                &&Valid::not_empty($_POST['offset'])
                &&Valid::numeric($_POST['offset'])
            ){
                //手续费小于等于优惠券抵消价格（无用，保存在微信库里面的）
                $coupon_id = $_POST['coupinid'];
                //优惠券金额
                $coupon_amount = $_POST['offset'];
            }else{
                $coupon_id = 0;
                $coupon_amount = 0;
            }

            //对余额和优惠券做保险设置(验证)
//            if($coupon_id>0&&$_POST['coin']>0){
//                exit(json_encode(array('status' =>false,'msg'=>'优惠券和余额优惠只能选择一种!')));
//            }
            //信用担保金额计算
            if($_POST['type'] == 2){
                //超出范围
                if(0>$_POST['ensure_rate_bu'] || $_POST['ensure_rate_bu']>100){
                    //（比例异常）异常错误
                    exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','b_abnormal_error'))));
                }else{
                    $ensure_amount = bcmul($_POST['money'],bcmul($_POST['ensure_rate_bu'],0.01,2),2);
                }
            }


            $variable = array(
                "app"=>$app
            );
            $json_info = json_encode($variable);
            //组装提交订单接口信息
            //获取银行卡信息
            //查找是否有注册银行卡(从借款流程进来)
            $resultBank = $this->_api->getApiArrays('BankCard','List','',array('json'=>$json_info));
            if(isset($resultBank['code']) && $resultBank['code']==1000){
                if(count($resultBank['result']['bank_card_list'])>0){
                    //补充用户订单证件信息
                    $bankcard_id = $resultBank['result']['bank_card_list'][0]['id'];
                    $bankcard_no = $resultBank['result']['bank_card_list'][0]['card_no'];
                }else{
                    $bankcard_id = '';
                    $bankcard_no = '';
                }
            }else{
                if(isset($resultBank['code'])){
                    exit(json_encode(array('status' => false,'msg'=>$resultBank['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
            //请求授信接口
            //提交订单
            $variable = array(
                'user_id'=>Gv::$_userInfo['user_id'],
                'type'=>$_POST['type'],
                'loan_amount'=>$_POST['money'],
                'day'=>$_POST['day'],
                'bankcard_id'=>$bankcard_id,
                'creditcard_id'=>'',
                "app"=>$app
            );
            //优惠券、金钱选其一
            if($coupon_id>0){
                $variable['coupon_id']=$coupon_id;
            }
            if($_POST['coin']>0){
                $variable['coin']=$_POST['coin'];
            }
            $json_info = json_encode($variable);
            if($_POST['type']==1){
                $result = $this->_api->getApiArrays('FullPreAuthLoan_Loan','Confirm','',array('json'=>$json_info));
            }elseif($_POST['type']==2){
                $result = $this->_api->getApiArrays('PreAuthLoan_Loan','Confirm','',array('json'=>$json_info));
            }elseif($_POST['type']==3){
                $result = $this->_api->getApiArrays('FastLoan_Loan','Confirm','',array('json'=>$json_info));
            }else{
                $this->error('异常错误');
                die;
            }

            if(isset($result['app_redirect']['url'])){
                $url = $this->Routing($result['app_redirect']['url'])['url'];
                if(Valid::not_empty($url)){
                    exit(json_encode(array('status' => false,'url'=>$url,'msg'=>$result['message'])));
                }
            }

            //授权情况
            if(isset($result['code'])&&$result['code']==1000){
                $count = $this->_model['order'] ->get_order_count(Gv::$_userInfo['user_id']);
                $array = array(
                    "user_id"=>Gv::$_userInfo['user_id'],
                    "loan_amount"=>$result['result']['order']['loan_amount'],
                    "coupon_id"=>$coupon_id,
                    "coupon_amount"=>$coupon_amount,
                    'bankcard_id'=>$result['result']['order']['bankcard_id'],
                    "day"=>$result['result']['order']['day'],
                    "repayment_amount"=>$result['result']['order']['repayment_amount'],
                    "payment_amount"=>$result['result']['order']['payment_amount'],
                    "charge"=>$result['result']['order']['charge'],
                    "ensure_amount" => isset($result['result']['order']['ensure_amount'])?$result['result']['order']['ensure_amount']:$_POST['money'],
                    "ensure_rate"=>isset($_POST['ensure_rate_bu'])?bcmul($_POST['ensure_rate_bu'],0.01,2):0,
                    "type"=>$_POST['type'],
                    "name"=>Gv::$_userInfo['nickname'],
                    "mobile"=>Gv::$_userInfo['mobile'],
                    'coin'=>isset($result['result']['order']['coin'])?$result['result']['order']['coin']:$_POST['coin']
                );

                //判断是添加订单还是修改订单;
                if($count==0){
                    //插入新数据
                    if($insert_id = $this->_model['order'] ->insert_order($array)){
                        exit(json_encode(array('status' => true)));
                    }else{
                        //异常错误
                        exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
                    };
                }elseif($count===false){
                    //异常错误
                    exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
                }else{
                    if($this->_model['order'] ->update_order_info_field($array,Gv::$_userInfo['user_id'])){
                        exit(json_encode(array('status' => true)));
                    }else{
                        //当没有修改订单信息的时候会走这
                        exit(json_encode(array('status' => true)));
                    };
                }
            }else{
                if(isset($result['code'])&&in_array($result['code'],array(5196,5197,5198))){
                    //权限不过，需要提示下载APP
                    exit(json_encode(array('status' => false,'code'=>true,'msg'=>$result['message'])));
                }else{
                    if(isset($result['code'])){
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' => false,'msg'=>$result['message'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            }
        } else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /*******************************************************
     *  借记卡信息提交(这个有订单的情况下进行添加银行卡)
     *******************************************************/
    public function action_dobank(){
        //检查是否有银行卡信息
        $status = $this->_model['order']->get_fieldstatus('bankcard_id,status,type',Gv::$_userInfo['user_id']);
        //重复注册银行卡信息了($status['bankcard_id']为空)(如果是修改有upload,new为新填,默认为各种情况)
        if ($this->request->is_ajax() && (($status['status'] == '0'&&$status['bankcard_id'] == '0')||(isset($_POST['upload'])&&Valid::not_empty($_POST['upload']))) &&$_POST) {
            if($_POST['aggreement']!=true){
                //没有同意协议！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','agree'))));
            }
            if(!Valid::not_empty($_POST['bank'])&&!Valid::not_empty($_POST['card_no']&&!Valid::not_empty($_POST['name']&&!Valid::not_empty($_POST['identity_code'])))){
                //缺少参数！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','missing_parameter'))));
            }
            //调接口
            $variable = array(
                "card_no"=>$_POST['card_no'],
                "bank_id"=>$_POST['bank'],
                "name"=>isset($_POST['name'])?$_POST['name']:null,
                "mobile"=>Gv::$_userInfo['mobile'],
                "identity"=>isset($_POST['identity_code'])?$this->_model['AES26']->encrypt($_POST['identity_code'],$this->_api_config['wx']['app_key']):null,
                "verify_code"=>isset($_POST['authcode'])?$_POST['authcode']:'',
                "app"=>$this->getWxInfo()
            );
            //通过upload来判断是修改还是添加
            if(isset($_POST['upload'])&&Valid::not_empty($_POST['upload'])){
                unset($variable['name']);
                unset($variable['mobile']);
                unset($variable['identity']);
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('BankCard','Change','',array('json'=>$json_info));
                $jumpType = 'Change';
            }else{
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('BankCard','Add','',array('json'=>$json_info));
                $jumpType = 'Add';
            }
            //exit(json_encode(array('status' => false,'msg'=>$result)));
            if(isset($result) && $result['code']==1000){
                //如果是通过订单程序添加的银行卡
                $jump = isset($result['result']['jump'])?$result['result']['jump']:0;
                $html = isset($result['result']['html'])?$result['result']['html']:null;
                if(isset($_POST['upload'])&&Valid::not_empty($_POST['upload'])){
                    exit(json_encode(array('status' =>true,'jump'=>$jump,'html'=>$html)));
                }elseif(isset($_POST['new'])&&Valid::not_empty($_POST['new'])){
                    exit(json_encode(array('status' =>true,'jump'=>$jump,'html'=>$html)));
                }else{
                    //插入订单信息
                    try{
                        $this->_model['order']->update_order_info_field(array(
                            "bankcard_id"=>$result['result']['bankcard_id'],
                            "bankcard_no"=>$result['result']['card_no']),
                            Gv::$_userInfo['user_id']
                        );
                        //区分跳回方向
                        if($jump==1){
                            if($jumpType=='Change'){
                                //跳修改银行卡页面
                                $this->_session->sessionSet('lianlian_jump_url','/Account/bankCreditList');
                            }else{
                                if($status['type']==3){
                                    //跳核对页面
                                    $this->_session->sessionSet('lianlian_jump_url','/Borrowmoney/check');
                                }else{
                                    //跳信用卡页面
                                    $this->_session->sessionSet('lianlian_jump_url','/Borrowmoney/bankinfo');
                                }
                            }
                        }
                        //有可能会添加插入银行卡微信库(jump为1跳连连)
                        exit(json_encode(array('status' =>true,'jump'=>$jump,'html'=>$html)));
                    } catch (Exception $e) {
                        exit(json_encode(array('status' =>false,'msg'=>$e->getMessage())));
                    }
                }
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else {
            //如果是因为有id引发的需要删除bankid
            if(isset($status['bankcard_id'])&&$status['bankcard_id'] != '0'){
                $this->_model['order']->update_order_info_field(array(
                    "bankcard_id"=>0,
                    "bankcard_no"=>null),
                    Gv::$_userInfo['user_id']
                );
                exit(json_encode(array('status' => false,'msg'=>"异常错误，请重新提交")));
            }
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /*******************************************************
     *  无订单借记卡信息提交
     *******************************************************/
    public function action_addbank(){
        //重复注册银行卡信息了($status['bankcard_id']为空)(如果是修改有upload,new为新填,默认为各种情况)
        if ($this->request->is_ajax()&&$_POST) {
            if($_POST['aggreement']!=true){
                //没有同意协议！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','agree'))));
            }
            if(!Valid::not_empty($_POST['bank'])&&!Valid::not_empty($_POST['card_no']&&!Valid::not_empty($_POST['name']&&!Valid::not_empty($_POST['identity_code'])))){
                //缺少参数！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','missing_parameter'))));
            }
            //调接口
            $variable = array(
                "card_no"=>$_POST['card_no'],
                "bank_id"=>$_POST['bank'],
                "name"=>$_POST['name'],
                "mobile"=>Gv::$_userInfo['mobile'],
                "identity"=>$this->_model['AES26']->encrypt($_POST['identity_code'],$this->_api_config['wx']['app_key']),
                "verify_code"=>isset($_POST['authcode'])?$_POST['authcode']:'',
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('BankCard','Add','',array('json'=>$json_info));

            if(isset($result) && $result['code']==1000){
                //如果是通过订单程序添加的银行卡
                exit(json_encode(array('status' =>true)));
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /*******************************************************
     *  无订单借记卡信息提交
     *******************************************************/

    public function action_uploadbank(){
        //重复注册银行卡信息了($status['bankcard_id']为空)(如果是修改有upload,new为新填,默认为各种情况)
        if ($this->request->is_ajax()&&$_POST) {
            if($_POST['aggreement']!=true){
                //没有同意协议！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','agree'))));
            }
            if(!Valid::not_empty($_POST['bank'])&&!Valid::not_empty($_POST['card_no']&&!Valid::not_empty($_POST['name']&&!Valid::not_empty($_POST['identity_code'])))){
                //缺少参数！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','missing_parameter'))));
            }
            //调接口
            $variable = array(
                "card_no"=>$_POST['card_no'],
                "bank_id"=>$_POST['bank'],
                "verify_code"=>isset($_POST['authcode'])?$_POST['authcode']:'',
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('BankCard','Change','',array('json'=>$json_info));

            //exit(json_encode(array('status' => false,'msg'=>$result)));
            if(isset($result['code']) && $result['code']==1000){
                //如果是通过订单程序添加的银行卡
                $jump = isset($result['result']['jump'])?$result['result']['jump']:0;
                $html = isset($result['result']['html'])?$result['result']['html']:null;
                $this->_session->sessionSet('lianlian_jump_url','/Account/bankCreditList');
                exit(json_encode(array('status' =>true,'jump'=>$jump,'html'=>$html)));
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /*******************************************************
     *  信用卡信息提交
     *******************************************************/

    public function action_docredit(){
        if ($this->request->is_ajax()&&$_POST) {
            $valid = Validation::factory($_POST)
                ->rule('card_no', 'not_empty')
                ->rule('card_no', 'regex', array(':value', '/^\d{16}$/'))
                ->rule('security_code', 'not_empty')
                ->rule('security_code', 'exact_length',array(':value',3))
                ->rule('security_code', 'regex',array(':value','/^\d{3}$/'))
                ->rule('expire_month', 'not_empty')
                ->rule('expire_month', 'exact_length',array(':value',2))
                ->rule('expire_month', 'regex',array(':value','/^0[1-9]|1[0-2]$/'))
                ->rule('expire_yeah', 'not_empty')
                ->rule('expire_yeah', 'exact_length',array(':value',2))
                ->rule('expire_yeah', 'regex',array(':value','/^\d{2}$/'));
            if ($valid->check()){
                //调接口
                $strto =  strtotime("20".$_POST['expire_yeah'].'-'.$_POST['expire_month']);
                $variable = array(
                    "user_id"=>Gv::$_userInfo['user_id'],
                    "expire_date"=>$strto,
                    "security_code"=>$_POST['security_code'],
                    "card_no"=>$_POST['card_no'],
                    "app"=>$this->getWxInfo()
                );
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('CreditCard','Add','',array('json'=>$json_info));
                if(isset($result) && $result['code']==1000){
                    //保存信息（需要修改）
                    //插入订单信息
                    Model::factory('Bankcard')->insert_update_creditcard(array(
                        'user_id'=>Gv::$_userInfo['user_id'],
                        'creditcard_id'=>$result['result']['creditcard_id'],
                        'card_no'=>$result['result']['card_no'],
                        'bank_code'=>$result['result']['bank_code'],
                        'bank_name'=>$result['result']['bank_name']
                    ));
                    exit(json_encode(array('status' =>true)));

                }else{
                    if(isset($result['code'])){
                        exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            } else {
                foreach ($valid->errors('errors') as $k) {
                    $call['status'][] = $k;
                }
                echo json_encode(array('status' =>false, 'msg'=>$call['status'][0]));
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /*******************************************************
     *  添加信用卡信息到订单表
     *******************************************************/
    public function action_docreditorder(){
        if ($this->request->is_ajax()&&$_POST) {
            if(!Valid::not_empty($_POST['id'])&&Valid::alpha_numeric($_POST['id'])){
                //缺少参数！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','missing_parameter'))));
            }
            //通过id获取信用卡信息
//            $result = Model::factory('Bankcard')->get_creditcard_info_arr("creditcard_id,card_no",array("creditcard_id"=>$_POST['id'],"user_id"=>Gv::$_userInfo['user_id'],"status"=>1));
            $variable = array(
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('CreditCard','List','',array('json'=>$json_info));
            if(isset($result['result']) && $result['code']==1000){
                if(isset($result['result']['credit_card_list'])&&!empty($result['result']['credit_card_list'])){
                    foreach ($result['result']['credit_card_list'] as $key=>&$val){
                        if($val['id']==$_POST['id']){
                            try {
                                $this->_model['order']->update_order_info_field(array(
                                    'creditcard_card'=>$val['card_no'],
                                    'creditcard_id'=>$val['id'],
                                ),Gv::$_userInfo['user_id']);
                                exit(json_encode(array('status' =>true)));
                            } catch (Exception $e) {
                                exit(json_encode(array('status' =>false,'msg'=>$e->getMessage())));
                            }
                        }
                    }
                }
            }else{
                if(isset($result['code'])){
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' => false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /*******************************************************
     *  删除信用卡信息
     *******************************************************/
    public function action_doDeleteCredit(){
        if($this->request->is_ajax()&&$_POST) {
            if(!Valid::not_empty($_POST['id'])&&Valid::alpha_numeric($_POST['id'])){
                //缺少参数！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','missing_parameter'))));
            }
            $variable = array(
                "id"=>$_POST['id'],
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('CreditCard','Remove','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                exit(json_encode(array('status' =>true)));
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }


    /*******************************************************
     *  极速贷提交
     *******************************************************/
    public function action_checkSubmit(){
        //添加code码,来判断页面跳转页面
        if ($this->request->is_ajax()&&$_POST) {
            //$session = Session::instance('database');(如果是2修改为loan_amount)
            $status_order = $this->_model['order']->get_fieldstatus('user_id,type,bankcard_id,creditcard_id,loan_amount,day,coupon_id,coin',Gv::$_userInfo['user_id']);
            //做保险coin和优惠券不能同时存在
            if ($status_order['coupon_id']>0&&$status_order['coin']>0) {
                exit(json_encode(array('status' => false,'msg'=>'数据异常!')));
            }


            //如果是极速贷,不进行信用卡验证
            if(isset($status_order)&&$status_order['type']==3){
                $variable = array(
                    "user_id"=>$status_order['user_id'],
                    "type"=>$status_order['type'],
                    "loan_amount"=>$status_order['loan_amount'],
                    "day"=>$status_order['day'],
                    "bankcard_id"=>$status_order['bankcard_id'],
                    "coupon_id"=>$status_order['coupon_id'],
                    "coin"=>$status_order['coin'],
                    "app"=>$this->getWxInfo()
                );
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('FastLoan_Loan','Apply','',array('json'=>$json_info));
                if(isset($result) && $result['code']==1000){
                    //埋点统计
//                    if($this->_session->sessionGet('activity_11')==1){
//                        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
//                        Model::factory('Activity')->insert_order_count(array('order_id'=>$result['result']['order_id'],'user_id'=>Gv::$_userInfo['user_id'],'ip'=>$ip,'create_time'=>time(),'activity_id'=>11,'reg_app'=>'wechat'),'order_count');
//                        $this->_session->sessionDelete('activity_11');
//                    }
                    //插入订单信息
                    $order_dele = $this->_model['order']->delete_order(Gv::$_userInfo['user_id']);
                    if($order_dele){
                        exit(json_encode(array('status' =>true)));
                    }else{
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','abnormal_error'))));
                    }
                }else{
                    if(isset($result['code'])){
                        //连连支付验证:
                        if($result['code']==5194){
                            //验证是否需要连连支付
                            $variable = array(
                                "app"=>$this->getWxInfo()
                            );
                            $json_info = json_encode($variable);
                            //当日借款统计(极速贷)
                            $result = $this->_api->getApiArrays('BankCard','BindCheck','',array('json'=>$json_info));
                            if(isset($result) && $result['code']==1000){
                                if(isset($result['result']['jump'])&&$result['result']['jump']==1){
                                    //保存跳出前页面
                                    $this->_session->sessionSet('lianlian_jump_url','/Borrowmoney/check');
                                    //如果是通过订单程序添加的银行卡
                                    $jump = isset($result['result']['jump'])?$result['result']['jump']:0;
                                    $html = isset($result['result']['html'])?$result['result']['html']:null;
                                    exit(json_encode(array('status' =>true,'jump'=>$jump,'html'=>$html)));
                                }else{
                                    //不需要连连验证,跳过
                                    exit(json_encode(array('status' =>true)));
                                }
                            }else{
                                if(isset($result['code'])){
                                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                                }else{
                                    //系统繁忙，请联系客服！
                                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                                }
                            }
                        }else{
                            //添加code码,来判断页面跳转页面
                            exit(json_encode(array('status' =>false,'msg'=>$result['message'],'code'=>$result['code'])));
                        }
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            }else{
                exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }

    /*----------------------------------------还款------------------------------------------------------------------------*/
    /*******************************************************
     *  还款验证码
     *******************************************************/
    public function action_repayCode(){
        if ($this->request->is_ajax()&&$_POST) {
            $orderid = Libs::factory('AES126')->decrypt($_POST['orderid'],$this->_api_config['wx']['app_key']);
            if(!Valid::not_empty($orderid)){
                //缺少参数
                exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','missing_parameter'))));
                die;
            }

            $variable = array(
                'user_id'=>Gv::$_userInfo['user_id'],
                'order_id'=>$orderid,
                'app'=>$this->getWxInfo(),
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('Order','RepaymentVerifySMS','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                //保存信息
                exit(json_encode(array('status' =>true)));
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }

    /*******************************************************
     *  还款验证
     *******************************************************/

    public function action_doRepay(){
        if ($this->request->is_ajax()&&$_POST) {
            $orderid = Libs::factory('AES126')->decrypt($_POST['orderid'],$this->_api_config['wx']['app_key']);
            if(!Valid::not_empty($orderid)||!Valid::digit($orderid)||!Valid::not_empty($_POST['code'])||!Valid::digit($_POST['code'])){
                //缺少参数
                exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','missing_parameter'))));
            }
            $variable = array(
                'user_id'=>Gv::$_userInfo['user_id'],
                'order_id'=>$orderid,
                'verify_code'=>$_POST['code'],
                'app'=>$this->getWxInfo(),
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('Order','Repayment','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                //保存信息
                exit(json_encode(array('status' =>true)));
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /*******************************************************
     *  获取更多优惠券
     *******************************************************/
    public function action_GetMoreCoupen(){
        if ($this->request->is_ajax()&&$_GET) {
            $variable = array(
                'user_id'=>Gv::$_userInfo['user_id'],
                'last_id'=>(int)$_GET['last_id'],
                "limit"=>"5",
                'app'=>$this->getWxInfo(),
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('Coupon','History','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                if(count($result['result']['coupon'])>=1){
                    foreach ($result['result']['coupon'] as $key=>&$val){
                        switch ($val['status']){
                            case 2:
                                //已经使用
                                $val['img'] = '/static/images/v2/icon-beenused.png';
                                break;
                            default:
                                if($val['expire_time']<time()){
                                    $val['img'] = '/static/images/v2/icon-Overdue.png';
                                }else{
                                    $val['img'] = null;
                                }
                                break;
                        }
                        $val['expire_time'] = date('Y-m-d',$val['expire_time']);
                    }
                }
                //保存信息
                exit(json_encode(array('status' =>true,'data'=>$result['result']['coupon'],'total'=>count($result['result']['coupon']),'last_id'=>$result['result']['last_id'])));
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /*******************************************************
     *  获取更多借款记录
     *******************************************************/
    public function action_GetMoreOrder(){
        if ($this->request->is_ajax()&&$_GET) {
            $variable = array(
                'user_id'=>Gv::$_userInfo['user_id'],
                'last_id'=>(int)$_GET['last_id'],
                "limit"=>"10",
                'app'=>$this->getWxInfo(),
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('Order','History','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                //保存信息
                exit(json_encode(array('status' =>true,'data'=>$result['result']['order'],'total'=>count($result['result']['order']),'last_id'=>$result['result']['last_id'])));
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }


    /*******************************************************
     *  提交授信
     *******************************************************/
    public function action_SubmitReduceApply(){
        if ($this->request->is_ajax()) {
            $variable = array(
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result_info = $this->_api->getApiArrays('CreditInfo','ReduceApply','',array('json'=>$json_info));
            if(isset($result_info) && $result_info['code']==1000){
                //保存信息
                exit(json_encode(array('status' =>true,'msg'=>'提交成功')));
            }else{
                if(isset($result_info['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result_info['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }

    /*******************************************************
     *  余额加载更多
     *******************************************************/

    //获取更多优惠券
    public function action_WalletDetailed(){
        if ($this->request->is_ajax()&&$_POST) {
            $variable = array(
                'last_id'=>$_POST['last_id'],
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            switch ($_POST['type']){
                case 'gain':
                    $coin = '+';
                    $key_type = 'action';
                    $result = $this->_api->getApiArrays('Coin','GainList','',array('json'=>$json_info));
                    break;
                case 'used':
                    $coin = '-';
                    $key_type = 'type';
                    $result = $this->_api->getApiArrays('Coin','UseList','',array('json'=>$json_info));
                    break;
            }
            if(isset($result)){
                if(isset($result['code']) && $result['code']==1000){
                    if(isset($result['result']['list'])&&!empty($result['result']['list'])&&is_array($result['result']['list'])){
                        $strList = null;
                        foreach ($result['result']['list'] as $key=>$val){
                            $strList .= '';
                            $strList .=  '<section class="walletList"><span>'.$val[''.$key_type.''].'</span><br><label class="grepApan">'.$val['create_time'].'</label><strong style="float: right">'.$coin.$val['coin'].'元</strong></section>';
                            $last_id = $val['id'];
                        }
                        if(count($result['result']['list'])>20){
                            exit(json_encode(array('status' =>true,'data'=>json_encode(array('strList'=>$strList,'last_id'=>$last_id)))));
                        }else{
                            exit(json_encode(array('status' =>true,'data'=>json_encode(array('strList'=>$strList,'last_id'=>0)))));
                        }
                    }else{
                        //空数据
                        exit(json_encode(array('status' =>true,'data'=>json_encode(array('last_id'=>0)))));
                    }
                }else{
                    if(isset($result['code'])){
                        exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            }else{
                //异常错误！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }


    /*******************************************************
     *  百融测试
     *******************************************************/
    public function action_BaiRongCredit(){
        if ($this->request->is_ajax()) {
            $variable = array(
                'swift_number'=>$_POST['swift_number'],
                'event'=>$_POST['event'],
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result_info = $this->_api->getApiArrays('AntiFraud_BaiRong','SaveSwiftNumber','',array('json'=>$json_info));
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
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }

    public function action_hehe(){
        exit(json_encode(array('status' => false,'msg'=>1111111)));
    }

    /*******************************************************
     *  同盾设备反欺诈
     *******************************************************/
    public function action_TdAntiFraud(){
        if ($this->request->is_ajax()&&$_POST) {
            $variable = array(
                'black_box'=>$_POST['tokenId'],
                'event_id'=>'loan_professional_web',   //事件写死
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result_info = $this->_api->getApiArrays('AntiFraud_TongDun','SaveBlackBox','',array('json'=>$json_info));
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
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }

    /*******************************************************
     *  合同下载
     *******************************************************/
    public function action_DownloadContract(){
        if ($this->request->is_ajax()&&$_POST) {
            $variable = array(
                'order_id'=>intval($_POST['id']),
//                'order_id'=>200004,
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result_info = $this->_api->getApiArrays('Contract','Download','',array('json'=>$json_info));
            if(isset($result_info) && $result_info['code']==1000){
                //保存信息
                exit(json_encode(array('status' =>true,'url'=>$result_info['result']['download_url'])));
            }else{
                if(isset($result_info['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result_info['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /*******************************************************
     *  请求电话运行商接口
     *******************************************************/
    //基础授信120秒没5秒请求该接口
    public function action_CreditQuery_TakeTurns(){
        if ($this->request->is_ajax()&&$_POST) {
            $variable = array(
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('CreditInfo','MNOQuery','',array('json'=>$json_info));
//                exit(json_encode(array('status' =>false,'msg'=>'异常错误!')));
            if(isset($result['code']) && $result['code']==1000){
                if(isset($result['result']['query_result'])){
                    //------标记mns回调地址,走H5还是走app-----------
//                        Tool::factory('Debug')->array2file($_POST, APPPATH.'../static/liu_test.php');
                    if(isset($_POST['varPost'])&&$_POST['varPost']=='Count'){
                        if(isset($_POST['p'])&&in_array($_POST['p'],array(1,2,3,4))){
                            //进入标记
                            $this->_session->sessionSet('rong360_MNS','1');
                        }
                    }
                    //------------------END------------------------
                    exit(json_encode(array('status' =>true,'msg'=>$result['result']['query_result'])));
                }else{
                    exit(json_encode(array('status' =>false,'msg'=>'异常错误!')));
                }
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else{
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }


    /*******************************************************
     *  购卡短信验证
     *******************************************************/
    public function action_BuyCardVerifySMS(){
        if ($this->request->is_ajax()&&$_POST) {
            if(!isset($_POST['cp_id'])||!Valid::not_empty($_POST['cp_id'])){
                exit(json_encode(array('status' =>false,'msg'=>'参数错误！')));
            }
            $variable = array(
                'cp_id'=>(int)$_POST['cp_id'],
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('SpeedUpCard','BuyVerifySMS','',array('json'=>$json_info));
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
        }else{
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /*******************************************************
     *  购卡提交按钮
     *******************************************************/
    public function action_BuyCardSubmit(){
        if ($this->request->is_ajax()&&$_POST) {


            if(!isset($_POST['cp_id'])||!Valid::not_empty($_POST['cp_id'])){
                exit(json_encode(array('status' =>false,'msg'=>'参数错误！')));
            }

            if(!isset($_POST['code'])||!Valid::not_empty($_POST['code'])){
                exit(json_encode(array('status' =>false,'msg'=>'验证码不能为空！')));
            }

            $variable = array(
                'cp_id'=>(int)$_POST['cp_id'],
                'verify_code'=>(int)$_POST['code'],
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('SpeedUpCard','Buy','',array('json'=>$json_info));
            if(isset($result['code']) && $result['code']==1000){
                exit(json_encode(array('status' =>true)));
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else{
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
    /*******************************************************
     *  卡翻页
     *******************************************************/
    public function action_MayCardMore()
    {
        if ($this->request->is_ajax() && $_POST) {
            if(!isset($_POST['pageIndex'])||!isset($_POST['lastId'])||!Valid::not_empty($_POST['lastId'])){
                exit(json_encode(array('status' =>false,'msg'=>'参数错误！')));
            }
            $variable = array(
                'last_id'=>(int)$_POST['lastId'],
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            if($_POST['pageIndex']==0){
                $result = $this->_api->getApiArrays('SpeedUpCard','MyListAvailable','',array('json'=>$json_info));
            }else if($_POST['pageIndex']==1){
                $result = $this->_api->getApiArrays('SpeedUpCard','MyListHistory','',array('json'=>$json_info));
            }else{
                exit(json_encode(array('status' =>false,'msg'=>'参数错误！')));
            }
            if(isset($result['code']) && $result['code']==1000){
                exit(json_encode(array('status' =>true,'data'=>$result['result']['list'],'id'=>$result['result']['last_id'])));
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        } else {
            //异常错误！
            exit(json_encode(array('status' => false, 'msg' => Kohana::message('wx', 'abnormal_error'))));
        }
    }
    //加载更多
    public function action_PeoplePullMoreList(){

        if ($this->request->is_ajax() && $this->request->post('last_id')) {
            //获得验证码,防止重复申请验证码
            $variable = array(
                'last_id'=>$this->request->post('last_id'),
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('InviterCoin','List','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                if(isset($result['result']['list'])&&!empty($result['result']['list'])){
                    if(is_array($result['result']['list'])){
                        $strUl = '';
                        foreach ($result['result']['list'] as $key=>$val){
                            $strUl .= ' <ul class="ulcss"><li>'.$val['invited_mobile'].'</li><li>'.$val['action'].'</li><li>'.$val['coin'].'元</li></ul>';
                            //最后一个id
                            $last_id = $val['id'];
                        }
                        if(count($result['result']['list'])>=20){
                            $moreSubmit ='<p class="morePeople" style="font-size: .3rem;color: white;text-align: center">点击显示更多</p>';
                        }else{
                            $moreSubmit ='<p style="font-size: .3rem;color: white;text-align: center">没有更多记录</p>';
                            $last_id = 0;
                        }
                    }else{
                        //异常错误！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','abnormal_error'))));
                    }
                }else{
                    $last_id = 0;
                    //空数据
                    $strUl = '';
                    $moreSubmit ='<p style="font-size: .3rem;color: white;text-align: center">没有更多记录</p>';
                }
                exit(json_encode(array('status' =>true,'msg'=>json_encode(array('strUl'=>$strUl,'moreSubmit'=>$moreSubmit,'last_id'=>$last_id)))));
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        } else {
            //异常错误！
            exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
        }
    }
}