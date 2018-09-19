<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 功能controller
 * */
    class Controller_FunctionsApp  extends Home {
        //如果已登录  直接跳转到用户页面
        public function before(){
            parent::before();
            $this->_model['AES26'] = Libs::factory('AES126');

        }
        /*-------------------------------------授信功能-----------------------------------------------------*/
        //公司邮箱验证码
        public function action_docompanycode(){
            if ($this->request->is_ajax() && $_POST) {
                $codesession = $this->_session->sessionGet('companycode');
                if(empty($codesession) || time() - $codesession['time'] > $codesession['next_send']){
                    $open_id = $this->_session->sessionGet('wx')['openid'];
                    $id = Model::factory('Home')->dbfind($open_id,'openid','user_wechat','user_id');
                    $variable = array(
                        "user_id"=>$id['user_id'],
                        "company_email"=>$_POST['email'],
                        "app"=>$this->getapp()
                    );
                    $json_info = json_encode($variable);
                    $result = $this->_api->getApiArrays('CreditInfo','WorkVerifyEmail','',array('json'=>$json_info));
                    if(isset($result) && $result['code']==1000){
                        $result['result']['time'] = time();
                        $this->_session->sessionSet('companycode',$result['result']);
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
                    if($codesession['send_count']>=$codesession['max_count']){
                        //今日申请次数太多
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','apply_frequently'))));
                    }else{
                        //操作繁忙
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','busy_operation'))));
                    }
                }
            }else{
                //非法请求
                exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
            }
        }
        //公司资料信息
        public function action_docompanyinfo(){
            if($this->request->method()==='POST'){
                $valid = Validation::factory($_POST)
                    ->rule('comname', 'not_empty')
                    ->rule('comaddress', 'not_empty')
                    ->rule('comdetailaddre', 'not_empty')
                    ->rule('comtell', 'not_empty')
                    ->rule('comtell', 'regex', array(':value', '/(\d{12})|(\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$/'));
//                    ->rule('email', 'not_empty')
//                    ->rule('email', 'regex', array(':value', '/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/'))
//                    ->rule('email', 'not_empty')
//                    ->rule('authcode', 'not_empty')
//                    ->rule('authcode', 'exact_length', array(':value', 4))
//                    ->rule('address', 'not_empty')
//                    ->rule('detailaddress', 'not_empty');
                if ($valid->check()) {
                    list($company_province,$company_city,$company_county) = explode(',',$_POST['comaddress']);
                    if($company_city=="市辖区"){
                        $company_city = $company_county;
                    }
//                    list($home_province,$home_city,$home_county) = explode(',',$_POST['address']);
//                    if($company_city=="市辖区"){
//                        $home_city = $home_county;
//                    }
                    if(!Valid::regex($_POST['comname'],'/[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{4,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{3,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{1,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{2,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{2,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{1,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{3,}[a-zA-Z0-9]*/u')
                        ||!Valid::regex($_POST['comdetailaddre'],'/[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{2,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{1,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{1,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{0,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{2,}[a-zA-Z0-9]*/u')
                        //||!Valid::regex($_POST['detailaddress'],'/[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{2,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{1,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{1,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{0,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{2,}[a-zA-Z0-9]*/u')
                    ){
                        //基本信息验证错误
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','basic_information_error'))));
                    }
//                    if(Valid::not_empty($_POST['numbertell'])){
//                        if(!Valid::alpha_numeric($_POST['numbertell'])){
//                            //电话号码格式错误
//                            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','tell_error'))));
//                        }
//                    }
                    if(Gv::$type == 1){
                        $app = $this->getapp();
                    }elseif(Gv::$type == 2){
                        $app = $this->getappapp(Gv::$app_token);
                    }
                    $variable = array(
                        "company_name"=>addslashes($_POST['comname']),
                        "company_province"=>addslashes($company_province),
                        "company_city"=>addslashes($company_city),
                        "company_county"=>addslashes($company_county),
                        "company_address"=>addslashes($_POST['comdetailaddre']),
                        "company_tel"=>addslashes($_POST['comtell']),
//                        "home_province"=>addslashes($home_province),
//                        "home_city"=>addslashes($home_city),
//                        "home_county"=>addslashes($home_county),
//                        "home_address"=>addslashes($_POST['detailaddress']),
//                        "home_tel"=>addslashes($_POST['numbertell']),
                        "app"=>$app
                    );
                    $json_info = json_encode($variable);
                    $result = $this->_api->getApiArrays('CreditInfo','WorkInfo','',array('json'=>$json_info));
                    if(isset($result) && $result['code']==1000){
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
                //非法请求
                exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
            }
        }
        //紧急联系人
        public function action_docontacts(){

            if ($this->request->is_ajax() && $_POST) {
               if(!isset($_POST['conname1'])||!Valid::not_empty($_POST['conname1'])
                   ||!isset($_POST['contact1'])||!Valid::not_empty($_POST['contact1'] )
                   ||!isset($_POST['ccomtell1'])||!Valid::not_empty($_POST['ccomtell1'])
                   ||!isset($_POST['conname2'])||!Valid::not_empty($_POST['conname2'])
                   ||!isset($_POST['contact2'])||!Valid::not_empty($_POST['contact2'])
                   ||!isset($_POST['ccomtell2'])||!Valid::not_empty($_POST['ccomtell2'])
               ){
                   exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','missing_parameter'))));
                }
                if(!Valid::regex($_POST['ccomtell1'],'/^(13\d|14[57]|15[012356789]|18\d|17[013678])\d{8}$/')
                    ||!Valid::regex($_POST['ccomtell2'],'/^(13\d|14[57]|15[012356789]|18\d|17[01678])\d{8}$/')
                ){
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','phone_verification'))));
                }
                if(!Valid::regex($_POST['conname1'],'/[\x{4e00}-\x{9fa5}]{2,}/u')
                    ||!Valid::regex($_POST['conname2'],'/[\x{4e00}-\x{9fa5}]{2,}/u')
                ){
                    //基本信息验证错误
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','basic_information_error'))));
                }
                $contact[] = array('name'=>trim(addslashes($_POST['conname1'])),'relation'=>trim(addslashes($_POST['contact1'])),'mobile'=>trim($_POST['ccomtell1']));
                $contact[] = array('name'=>trim(addslashes($_POST['conname2'])),'relation'=>trim(addslashes($_POST['contact2'])),'mobile'=>trim($_POST['ccomtell2']));
                if(Gv::$type == 2){
                    $variable = array(
                        "contact"=>$contact,
                        "app"=>$this->getappapp(Gv::$app_token)
                    );

                }elseif(Gv::$type == 1){
                    $variable = array(
                        "contact"=>$contact,
                        "app"=>$this->getapp()
                    );
                }else{
                    //验证失败
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','validation_failure'))));
                }

                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('CreditInfo','Contact','',array('json'=>$json_info));
                if(isset($result) && $result['code']==1000){
                    //修改本地step里面的work_info信息
                    Model::factory('User')->set_user_step_info(array('contact'=>2),Gv::$user_id);
                    exit(json_encode(array('status' =>true,'msg'=>$result['message'])));
                }else{
                    if(isset($result['code'])){
                        exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            } else{
                //非法请求
                exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
            }
        }
        //淘宝，京东授，手机运营商授信
        public function action_dotbjdcredit(){
            //非法请求
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
            //异常错误
            if ($this->request->is_ajax() && $_POST) {
                //查是否是移动并之前提交过
//                if($_POST['type']=='sj'){
//                    $mobile = $this->user->get_userinfo_touid(Gv::$user_id)['mobile'];
//                    if(preg_match('/^(13[4-9]\d{8})|(15(0|1|2|7|8|9)\d{8})|(18(2|3|4|7|8)\d{8})|((147)\d{8})|((178)\d{8})$/', $mobile)){
//                        if(Valid::not_empty($this->session->sessionGet('sendtime'))){
//                            //异常错误
//                            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','abnormal_error'))));
//                        }
//                    };
//                }
                //如果是手机
                if(isset($_POST['phone'])
                    &&Valid::not_empty($_POST['phone'])
                    &&isset($_POST['passphone'])
                    &&Valid::not_empty($_POST['passphone'])
                 ){
                    if(!Valid::not_empty(Gv::$user_id)){
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','missing_parameter'))));
                    }else{
                        if(Gv::$type == 2){
                            $_POST['usernamec'] = Gv::$mobile;
                        }elseif(Gv::$type == 1){
                            $_POST['usernamec'] = $this->user->get_userinfo_touid(Gv::$user_id)['mobile'];
                        }
                        $_POST['password'] = $_POST['passphone'];
                    }
                }
                if(!isset($_POST['usernamec'])||!Valid::not_empty($_POST['usernamec'])
                    ||!isset($_POST['password'])||!Valid::not_empty($_POST['password'])
                    ||!isset($_POST['type'])||!Valid::not_empty($_POST['type'])
                ){
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','missing_parameter'))));
                }
               // Tool::factory('Debug')->array2file(array(Valid::regex('123456','/^[0-9]*$/'),$_POST), APPPATH.'../static/liu_test.php');
                //验证动态验证码
                if(isset($_POST['dynamiccode'])&&!empty($_POST['dynamiccode'])&&!Valid::regex($_POST['dynamiccode'],'/^[0-9A-Za-z]{1,10}$/')){
                    //基本验证失败
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','basic_information_error'))));
                }
                //查询密码
                if(isset($_POST['search_password'])&&!empty($_POST['search_password'])&&!Valid::regex($_POST['search_password'],'/[0-9A-Za-z]*/')){
                    //基本验证失败
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','basic_information_error'))));
                }
                
                if($_POST['type']=='sj'){
                    $account = $_POST['usernamec'];
                }else{
                    $account = $this->model['AES26']->encrypt($_POST['usernamec'],$this->api_config['app_key']);
                }

                if($_POST['type']=='sj'){
                    if(Gv::$type == 2){
                        $variable = array(
                            "mobile"=>$account,
                            "service_password"=>$this->model['AES26']->encrypt($_POST['password'],$this->api_config['app_key']),
                            "dynamic_code"=>isset($_POST['dynamiccode'])?(Valid::not_empty($_POST['dynamiccode'])?$_POST['dynamiccode']:null):null,
                            "query_password"=>isset($_POST['search_password'])?(Valid::not_empty($_POST['search_password'])?$this->model['AES26']->encrypt($_POST['search_password'],$this->api_config['app_key']):null):null,
                            "app"=>$this->getappapp(Gv::$app_token)
                        );
                    }elseif(Gv::$type == 1){
                        $variable = array(
                            "mobile"=>$account,
                            "service_password"=>$this->model['AES26']->encrypt($_POST['password'],$this->api_config['app_key']),
                            "dynamic_code"=>isset($_POST['dynamiccode'])?(Valid::not_empty($_POST['dynamiccode'])?$_POST['dynamiccode']:null):null,
                            "query_password"=>isset($_POST['search_password'])?(Valid::not_empty($_POST['search_password'])?$this->model['AES26']->encrypt($_POST['search_password'],$this->api_config['app_key']):null):null,
                            "app"=>$this->getapp()
                        );
                    }else{
                        //验证失败
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','validation_failure'))));
                    }
                }else{
                    if(Gv::$type == 2){
                        $variable = array(
                            'user_id'=>Gv::$user_id,
                            "account"=>$account,
                            //动态验证吗
                            "dynamic_code"=>isset($_POST['dynamiccode'])?(Valid::not_empty($_POST['dynamiccode'])?$_POST['dynamiccode']:null):null,
                            "password"=>$this->model['AES26']->encrypt($_POST['password'],$this->api_config['app_key']),
                            "app"=>$this->getappapp(Gv::$app_token)
                        );
                    }elseif(Gv::$type == 1){
                        $variable = array(
                            'user_id'=>Gv::$user_id,
                            "account"=>$account,
                            "dynamic_code"=>isset($_POST['dynamiccode'])?(Valid::not_empty($_POST['dynamiccode'])?$_POST['dynamiccode']:null):null,
                            "password"=>$this->model['AES26']->encrypt($_POST['password'],$this->api_config['app_key']),
                            "app"=>$this->getapp()
                        );
                    }else{
                        //验证失败
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','validation_failure'))));
                    }
                }
                $json_info = json_encode($variable);
                if($_POST['type']=='tb'){
                    $result = $this->api->getApiArrays('CreditInfo','ECAccountTaoBao','',array('json'=>$json_info));
                }elseif($_POST['type']=='jd'){
                    $result = $this->api->getApiArrays('CreditInfo','ECAccountJingDong','',array('json'=>$json_info));
                }elseif($_POST['type']=='sj'){
                    $result = $this->api->getApiArrays('CreditInfo','MNO','',array('json'=>$json_info));
                }else{
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','missing_parameter'))));
                }
                if(isset($result) && $result['code']==1000){
                    //区分是否是移动
//                    if($_POST['type']=='sj'){
//                        $mobile = $this->user->get_userinfo_touid(Gv::$user_id)['mobile'];
//                        if(preg_match('/^(13[4-9]\d{8})|(15(0|1|2|7|8|9)\d{8})|(18(2|3|4|7|8)\d{8})|((147)\d{8})|((178)\d{8})$/', $mobile)){
//                            $this->session->sessionSet('sendtime',1);
//                        };
//                    }
                    exit(json_encode(array('status' =>true,'msg'=>$result['message'])));
                }else{
                    if(isset($result['code'])){
                        exit(json_encode(array('status' =>false,'code'=>$result['code'],'msg'=>$result['message'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
            }else{
                //非法请求
                exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
            }
        }
        //授信运营商服务(第二次发验证)
        public function action_doDynamicSend(){
            //非法请求
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
            if ($this->request->is_ajax() && $_POST) {
                if(!isset($_POST['mobile'])
                    ||!Valid::not_empty($_POST['mobile'])
                    ||!isset($_POST['passphone'])
                    ||!Valid::not_empty($_POST['passphone']))
                {
                    //缺少参数
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','missing_parameter'))));
                }
                $mobile = $this->user->get_userinfo_touid(Gv::$user_id)['mobile'];
                //if(preg_match('/^(13[4-9]\d{8})|(15(0|1|2|7|8|9)\d{8})|(18(2|3|4|7|8)\d{8})|((147)\d{8})|((178)\d{8})$/', $mobile)){
                if(Gv::$type == 2){
                    $app =$this->getappapp(Gv::$app_token);
                }elseif(Gv::$type == 1){
                    $app =$this->getapp(Gv::$app_token);
                }else{
                    //验证失败
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','validation_failure'))));
                }
                //查询密码
                if(isset($_POST['search_password'])&&!empty($_POST['search_password'])&&!Valid::regex($_POST['search_password'],'/[0-9A-Za-z]*/')){
                    //基本验证失败
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','basic_information_error'))));
                }
                $variable = array(
                        "mobile"=>$mobile,
                        "service_password"=>$this->model['AES26']->encrypt($_POST['passphone'],$this->api_config['app_key']),
                        "query_password"=>isset($_POST['search_password'])?(Valid::not_empty($_POST['search_password'])?$this->model['AES26']->encrypt($_POST['search_password'],$this->api_config['app_key']):null):null,
                        "app"=>$app
                );
                $json_info = json_encode($variable);
                $result = $this->api->getApiArrays('CreditInfo','MNODynamicSend','',array('json'=>$json_info));
                if(isset($result) && $result['code']==1000){
                    exit(json_encode(array('status' =>true,'msg'=>$result['message'])));
                }else{
                    if(isset($result['code'])){
                        exit(json_encode(array('status' =>false,'msg'=>$result['message'],'code'=>$result['code'])));
                    }else{
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                    }
                }
//                }else{
//                    //异常错误
//                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','abnormal_error'))));
//                };
            }else{
                //非法请求
                exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
            }
        }
        //运营商需要动态验证码的时候表单提交()
        public function action_doDynamicVerify(){
            //非法请求
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
            if ($this->request->is_ajax() && $_POST) {
                if(!isset($_POST['passphone'])
                    ||!Valid::not_empty($_POST['passphone'])
                    ||!isset($_POST['dynamiccode'])
                    ||!Valid::not_empty($_POST['dynamiccode']))
                {
                    //缺少参数
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','missing_parameter'))));
                }
                if(Gv::$type==2){
                    $mobile = Gv::$mobile;
                }elseif(Gv::$type==1){
                    $mobile = $this->user->get_userinfo_touid(Gv::$user_id)['mobile'];
                }else{
                    //异常错误
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','abnormal_error'))));
                }
               // if(preg_match('/^(13[4-9]\d{8})|(15(0|1|2|7|8|9)\d{8})|(18(2|3|4|7|8)\d{8})|((147)\d{8})|((178)\d{8})$/', $mobile)){
                    if(Gv::$type == 2){
                        $app =$this->getappapp(Gv::$app_token);
                    }elseif(Gv::$type == 1){
                        $app =$this->getapp(Gv::$app_token);
                    }else{
                        //验证失败
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','validation_failure'))));
                    }
                    $variable = array(
                        "mobile"=>$mobile,
                        "service_password"=>$this->model['AES26']->encrypt($_POST['passphone'],$this->api_config['app_key']),
                        "dynamic_code"=>$this->model['AES26']->encrypt($_POST['dynamiccode'],$this->api_config['app_key']),
                        "search_password"=>isset($_POST['search_password'])?(Valid::not_empty($_POST['search_password'])?$_POST['search_password']:null):null,
                        "app"=>$app
                    );
                    $json_info = json_encode($variable);
                    $result = $this->api->getApiArrays('CreditInfo','MNODynamicVerify','',array('json'=>$json_info));
                    if(isset($result) && $result['code']==1000){
                        exit(json_encode(array('status' =>true,'msg'=>$result['message'])));
                    }else{
                        if(isset($result['code'])){
                            exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                        }else{
                            //系统繁忙，请联系客服！
                            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                        }
                    }
//                }else{
//                    //异常错误
//                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','abnormal_error'))));
//                };

            }else{
                //非法请求
                exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
            }
        }

       
        
        /*---------------活动统计------------------------*/
        //统计年庆活动浏览点击
        public function action_statisticsCelebrate(){
            if ($this->request->is_ajax() && $_POST) {
                if(!in_array($_POST['action'],array('look','click'))){
                    return false;
                }
                $activity = Model::factory('Activity');
                $ip = $_SERVER["REMOTE_ADDR"];
                if($activity->get_celebrate_info(array('ip'=>$ip,'action'=>$_POST['action']))){
                    $activity->insert_celebrate_statistics(array('action'=>$_POST['action'],'ip'=>$_SERVER["REMOTE_ADDR"],'create_time'=>time()));
                }
                exit(json_encode(array('status' =>true)));
            }
        }

        //统计
        public function action_statistics(){
            if ($this->request->is_ajax() && $_POST) {
                if(!in_array($_POST['action'],array('look','click'))){
                    return false;
                }
                if(!isset($_POST['action'])||!isset($_POST['event_name'])){
                    return false;
                }
                $activity = Model::factory('Activity');
                $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
                $ip = explode(",",$ip)[0];
                switch ($_POST['action']){
                    case 'look':
                        $event_name = $_POST['event_name'].'_LOOK';
                        break;
                    case 'click':
                        $event_name = $_POST['event_name'].'_CLCK';
                        break;
                    default:
                        break;
                }
                if($activity->get_statistics(array('ip'=>trim($ip),'action'=>$_POST['action'],'event_name'=>$event_name),'ac_count')){
                    $activity->insert_statistics(array('action'=>$_POST['action'],'ip'=>trim($ip),'create_time'=>time(),'event_name'=>$event_name),'ac_count');
                }

                //有用户id并且基础授信未通过的
                $credited = (Gv::$type==1)?Gv::$credited:$this->_app_session['credit_auth'];
                if(!empty(Gv::$user_id)&&!empty($credited)&&!in_array($credited,Model_Home::BASIC_CREDIT_FINISH)){
                    //进入活动统计
                    if(Gv::$type == 2){
                        $variable = array(
                            "type"=>1,
                            "event_name"=>$event_name,
                            "app"=>$this->getappapp(Gv::$app_token)
                        );

                    }elseif(Gv::$type == 1){
                        $variable = array(
                            "type"=>1,
                            "event_name"=>$event_name,
                            "app"=>$this->getapp()
                        );
                    }else{
                        //验证失败
                        Model::factory('Log')->insert_Log(array('action'=>$this->_action,'controller'=>$this->_controller,'msg'=>$_POST['event_name'].Kohana::message('wx','validation_failure'),'create_time'=>time()));
                        exit(json_encode(array('status' =>true)));
                    }
                    $json_info = json_encode($variable);
                    $result = $this->_api->getApiArrays('EventLog','Index','',array('json'=>$json_info));
                    if(isset($result) && $result['code']==1000){
                        //修改本地step里面的work_info信息
                    }else{
                        if(isset($result['code'])){
                            Model::factory('Log')->insert_Log(array('action'=>$this->_action,'controller'=>$this->_controller,'msg'=>$_POST['event_name'].$result['message'],'create_time'=>time()));
                        }else{
                            //系统繁忙，请联系客服！
                            Model::factory('Log')->insert_Log(array('action'=>$this->_action,'controller'=>$this->_controller,'msg'=>$_POST['event_name'].Kohana::message('wx','system_busy'),'create_time'=>time()));
                        }
                    }
                }
                exit(json_encode(array('status' =>true)));
            }
        }

        //统计
        public function action_statisticsWx(){
            if ($this->request->is_ajax() && $_POST) {
                //统计
                if(isset($_POST['event_name'])&&(time()<'1493395140'||$_POST['event_name']!='TCOA_006')) {
                    if(!in_array($_POST['action'],array('look','click'))){
                        return false;
                    }
                    if(!isset($_POST['action'])||!isset($_POST['event_name'])){
                        return false;
                    }
                    $activity = Model::factory('Activity');
                    $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
                    $ip = explode(",",$ip)[0];
                    switch ($_POST['action']){
                        case 'look':
                            $event_name = $_POST['event_name'].'_LOOK';
                            break;
                        case 'click':
                            $event_name = $_POST['event_name'].'_CLCK';
                            break;
                        default:
                            break;
                    }
                    if($activity->get_statistics(array('ip'=>trim($ip),'action'=>$_POST['action'],'event_name'=>$event_name),'ac_count')){
                        $activity->insert_statistics(array('action'=>$_POST['action'],'ip'=>trim($ip),'create_time'=>time(),'event_name'=>$event_name),'ac_count');
                    }
                }

                exit(json_encode(array('status' =>true)));
            }
        }
        //分享统计,只限微信统计(app统计用微盟后台)
        public function action_shareWx(){
            if ($this->request->is_ajax() && $_POST) {
                //只统计微信端
                if(Gv::$type==1){
                    $openid = $this->_session->sessionGet('wx')['openid'];
                    if(!empty($openid)){
                        //$_POST['time']为0表示无限制记录
                        if(isset($_POST['event_name'])&&(isset($_POST['time'])&&(time()<$_POST['time']||$_POST['time']==0))){
                            $activity = Model::factory('Activity');
                            if($activity->get_share_info(array('uniqueid'=>$openid,'event_name'=>$_POST['event_name'].'_SHARE'))){
                                $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
                                $ip = explode(",",$ip)[0];
                                $pagetype = '/'.$this->_controller.'/'.$this->_action;
                                $activity->insert_browse_info(array('uniqueid'=>$openid,'pagetype'=>$pagetype,'reg_app'=>'wechat','user_id'=>(isset(Gv::$user_id)&&!empty(Gv::$user_id))?Gv::$user_id:0,'event'=>$_POST['action'],'ip'=>trim($ip),'create_time'=>time(),'event_name'=>$_POST['event_name'].'_SHARE'));
                            }
                        }
                    }
                }
            }
            exit(json_encode(array('status' =>true)));
        }
        //企图借款用户统计
        public function action_statisticsBorrow(){
            if ($this->request->is_ajax() && $_POST) {
                $activity = Model::factory('Activity');
                if(Gv::$type==1){
                    $reg_app = 'wechat';
                }elseif(Gv::$type==2){
                    $reg_app = 'app';
                }
                if(!empty(Gv::$user_id)){//未登录
                    if($activity->get_info(array('user_id'=>Gv::$user_id,'event_name'=>$_POST['event_name'].'_BORROW'),'loan_type_count')){
                        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
                        $ip = explode(",",$ip)[0];
                        $activity->insert_statistics(array('user_id'=>Gv::$user_id,'event_name'=>$_POST['event_name'].'_BORROW','reg_app'=>isset($reg_app)?$reg_app:null,'type'=>isset($_POST['type'])?$_POST['type']:0,'ip'=>trim($ip),'create_time'=>time()),'loan_type_count');
                    }
                }
            }
            exit(json_encode(array('status' =>true)));
        }
        //优惠券立即借款点击统计
        public function action_statisticsCouponOk(){
            if ($this->request->is_ajax() && $_POST) {
                if(Valid::not_empty(Gv::$user_id)){
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
        
        //全部统计
        public function action_statisticsAllIp(){
            if ($this->request->is_ajax() && $_POST) {
                //统计
                if(isset($_POST['event_name'])&&isset($_POST['time'])&&time()<$_POST['time']) {
                    if(!in_array($_POST['action'],array('look','click'))){
                        return false;
                    }
                    if(!isset($_POST['action'])||!isset($_POST['event_name'])){
                        return false;
                    }
                    $activity = Model::factory('Activity');
                    $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
                    $ip = explode(",",$ip)[0];
                    switch ($_POST['action']){
                        case 'look':
                            $event_name = $_POST['event_name'].'_LOOK';
                            break;
                        case 'click':
                            $event_name = $_POST['event_name'].'_CLCK';
                            break;
                        default:
                            break;
                    }
                    if($activity->get_statistics(array('ip'=>trim($ip),'action'=>$_POST['action'],'event_name'=>$event_name),'ac_count')){
                     $activity->insert_statistics(array('action'=>$_POST['action'],'ip'=>trim($ip),'create_time'=>time(),'event_name'=>$event_name),'ac_count');
                   }
                }

                exit(json_encode(array('status' =>true)));
            }
        }
        
        //统计按钮点击(登录用户和非登录用户同时统计)
        public function action_statisticsUserIdIp(){
            if ($this->request->is_ajax() && $_POST) {
                //统计
                $activity = Model::factory('Activity');
                if(!in_array($_POST['action'],array('look','click'))){
                    return false;
                }
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
                        break;
                }


                //判断是否是微信
                if(Gv::$type == 1){
                    $reg_app = 'wechat';
                }elseif(Gv::$type == 2){
                    $reg_app = 'app';
                }else{
                    //系统繁忙，请联系客服！
                    $this->error('获取信息失败!');
                    die;
                }

                $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
                $ip = explode(",",$ip)[0];
                if(Valid::not_empty(Gv::$user_id)){
                    if($activity->get_statistics(array('action'=>$_POST['action'],'user_id'=>Gv::$user_id,'event_name'=>$event_name),'ac_userid_count')){
                        $activity->insert_statistics(array('action'=>$_POST['action'],'user_id'=>Gv::$user_id,'ip'=>trim($ip),'create_time'=>time(),'event_name'=>$event_name,'reg_app'=>$reg_app),'ac_userid_count');
                    }
                }else{
                    //只统计ip
                    if($activity->get_statistics(array('ip'=>trim($ip),'action'=>$_POST['action'],'event_name'=>$event_name),'ac_count')){
                        $activity->insert_statistics(array('action'=>$_POST['action'],'ip'=>trim($ip),'create_time'=>time(),'event_name'=>$event_name,'reg_app'=>$reg_app),'ac_count');
                    }
                }
                exit(json_encode(array('status' =>true)));
            }
        }



        /*---------------end活动统计------------------------*/
        //打卡
        public function action_PunchClock(){

            if($this->request->is_ajax() && $_POST) {
                if(empty(Gv::$user_id)){//未登录
                    exit(json_encode(array('status' =>false,'msg'=>'未登录')));
                }else{
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
                    $result = $this->_api->getApiArrays('CheckIn','check_in','',array('json'=>$json_info));
                    if(isset($result['code']) && $result['code']==1000){
                        if(isset($result['result']['num'])&&$result['result']['num']>1){
                            exit(json_encode(array('status' =>true,'msg'=>$result['message'])));
                        }else{
                            exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                        }
                    }else{
                        if(isset($resultList['code'])){
                            exit(json_encode(array('status' =>false,'msg'=>$resultList['message'])));
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
                if(empty(Gv::$user_id)){//未登录
                    exit(json_encode(array('status' =>false,'msg'=>'未登录')));
                }else{
                    if(!isset($_POST['templateId'])||empty($_POST['templateId'])){
                        //非法请求
                        exit(json_encode(array('status' =>false,'msg'=>'参数为空'))); 
                    }
                    if(Gv::$type == 1){
                        $app = $this->getapp();
                    }elseif(Gv::$type == 2){
                        $app = $this->getappapp($this->_app_session['token']);
                    }else{
                        $this->error('获取信息失败!');
                    }
                    $variable = array(
                        'template_id'=>$_POST['templateId'],
                        "app"=>$app
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
        
/*-----------------------------注册流程------------------------------------------*/
        
        //注册验证码
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
        //加载更多
        public function action_PeoplePullMoreList(){

            if ($this->request->is_ajax() && $this->request->post('last_id')) {
                //获得验证码,防止重复申请验证码
                if(Gv::$type == 1){
                    $app = $this->getapp();
                }elseif(Gv::$type == 2){
                    $app = $this->getappapp($this->_app_session['token']);
                }else{
                    $this->error('获取信息失败!');
                }
                $variable = array(
                    'last_id'=>$this->request->post('last_id'),
                    "app"=>$app
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

        //获取更多优惠券
        public function action_GetMoreCoupen(){
            if ($this->request->is_ajax()&&$_GET) {


                if(Gv::$type == 1){
                    $app = $this->getapp();
                }elseif(Gv::$type == 2){
                    $app = $this->getappapp($this->_app_session['token']);
                }else{
                    $this->error('获取信息失败!');
                }
                $variable = array(
                    'user_id'=>Gv::$user_id,
                    'last_id'=>(int)$_GET['last_id'],
                    "limit"=>"5",
                    "app"=>$app
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
}