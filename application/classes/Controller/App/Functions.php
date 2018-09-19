<?php defined('SYSPATH') or die('No direct script access.');
/*
 * App端使用方法
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 *
 * */
    class Controller_App_Functions  extends AppHome {
        //如果已登录  直接跳转到用户页面
        public function before(){
            parent::before();
            $this->_model['AES26'] = Libs::factory('AES126');
        }
        /************************************************************************************************************************************
         *  公司资料信息
         ************************************************************************************************************************************/

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
                    if(!Valid::regex($_POST['comname'],'/[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{4,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{3,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{1,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{2,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{2,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{1,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{3,}[a-zA-Z0-9]*/u')
                        ||!Valid::regex($_POST['comdetailaddre'],'/[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{2,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{1,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{1,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{0,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{2,}[a-zA-Z0-9]*/u')
                        //||!Valid::regex($_POST['detailaddress'],'/[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{2,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{1,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{1,}[a-zA-Z0-9]*|[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{0,}[a-zA-Z0-9]*[\x{4e00}-\x{9fa5}]{2,}[a-zA-Z0-9]*/u')
                    ){
                        //基本信息验证错误
                        exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','basic_information_error'))));
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
                        "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
                    );
                    $json_info = json_encode($variable);
                    $result = $this->_api->getApiArrays('CreditInfo','WorkInfo','',array('json'=>$json_info),'v');
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
        /************************************************************************************************************************************
         * 紧急联系人
         ************************************************************************************************************************************/
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
//                if(!Valid::regex($_POST['conname1'],'/[\x{4e00}-\x{9fa5}]{2,}/u')
//                    ||!Valid::regex($_POST['conname2'],'/[\x{4e00}-\x{9fa5}]{2,}/u')
//                ){
//                    //基本信息验证错误
//                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','basic_information_error'))));
//                }
                $contact[] = array('name'=>trim(addslashes($_POST['conname1'])),'relation'=>trim(addslashes($_POST['contact1'])),'mobile'=>trim($_POST['ccomtell1']));
                $contact[] = array('name'=>trim(addslashes($_POST['conname2'])),'relation'=>trim(addslashes($_POST['contact2'])),'mobile'=>trim($_POST['ccomtell2']));
                $variable = array(
                    "contact"=>$contact,
                    "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
                );

                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('CreditInfo','Contact','',array('json'=>$json_info),'v');
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

        /************************************************************************************************************************************
         * 获取更多优惠券
         ************************************************************************************************************************************/
        public function action_GetMoreCoupen(){
            if ($this->request->is_ajax()&&$_GET) {
                $variable = array(
                    'user_id'=>Gv::$_userInfo['user_id'],
                    'last_id'=>(int)$_GET['last_id'],
                    "limit"=>"5",
                    "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
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



        /*------------------------------------------------------v3以后用上----------------------------------------------------------------------------*/


        
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
                $variable = array(
                    'last_id'=>$this->request->post('last_id'),
                    "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
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
        public function action_WalletDetailed(){
            if ($this->request->is_ajax()&&$_POST) {
                if(Gv::$type == 1){
                    $app = $this->getapp();
                }elseif(Gv::$type == 2){
                    $app = $this->getappapp($this->_app_session['token']);
                }else{
                    exit(json_encode(array('status' =>false,'msg'=>'获取信息失败')));
                }
                $variable = array(
                    'last_id'=>$_POST['last_id'],
                    "app"=>$app
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

        //基础授信120秒没5秒请求该接口
        public function action_CreditQuery_TakeTurns(){
            if ($this->request->is_ajax()&&$_POST) {

                if(isset($_POST['tc_no'])){
                    //post key值写死
                    $result = $this->_api->getApiArraysOld('API_TCredit_MNO_Return','AppQuery','',array('tc_no'=>$_POST['tc_no']),'v');
                }else if(isset($_POST['outUniqueId'])){
                    $result = $this->_api->getApiArraysOld('API_Rong360_MNO_Return','AppQuery','',array('outUniqueId'=>$_POST['outUniqueId']),'v');
                }else{
                    exit(json_encode(array('status' =>false,'msg'=>'请求错误!')));
                }
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
                    "identity"=>$this->_model['AES26']->encrypt($_POST['identity_code'],$this->_api_config['app_h5']['app_key']),
                    "verify_code"=>isset($_POST['authcode'])?$_POST['authcode']:'',
                    "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
                );

                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('BankCard','Add','',array('json'=>$json_info));
                //exit(json_encode(array('status' => false,'msg'=>$result)));
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
         *  购卡短信验证
         *******************************************************/
        public function action_BuyCardVerifySMS(){
            if ($this->request->is_ajax()&&$_POST) {
                if(!isset($_POST['cp_id'])||!Valid::not_empty($_POST['cp_id'])){
                    exit(json_encode(array('status' =>false,'msg'=>'参数错误！')));
                }
                $variable = array(
                    'cp_id'=>(int)$_POST['cp_id'],
                    "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
                );
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('SpeedUpCard','BuyVerifySMS','',array('json'=>$json_info));
                if(isset($result['code']) && $result['code']=='1000'){
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

//                if(!isset($_POST['bcid'])||!Valid::not_empty($_POST['bcid'])){
//                    exit(json_encode(array('status' =>false,'msg'=>'请选择银行卡！')));
//                }

                $variable = array(
                    'cp_id'=>(int)$_POST['cp_id'],
                    'verify_code'=>(int)$_POST['code'],
                    "app"=>$this->getAppInfo(Gv::$_userInfo['token']),
                    'bankcard_id'=>isset($_POST['bcid'])?$_POST['bcid']:null,
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
         *  卡退款提交按钮
         *******************************************************/
        public function action_RefundCardSubmit(){
            if (!$this->request->is_ajax() || !$_POST) {
                //异常错误！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
            }

            if(!isset($_POST['id']) || !Valid::not_empty($_POST['id'])){
                exit(json_encode(array('status' => false, 'msg' => '参数错误！')));
            }
            if(!isset($_POST['refund_amount']) || !Valid::not_empty($_POST['refund_amount'])){
                exit(json_encode(array('status' => false, 'msg' => '参数错误！')));
            }
            if(!isset($_POST['bankcard_id']) || !Valid::not_empty($_POST['bankcard_id'])){
                exit(json_encode(array('status' => false, 'msg' => '参数错误！')));
            }

            $variable = array(
                'refund_amount' => (int)$_POST['refund_amount'],
                'bankcard_id'   => (int)$_POST['bankcard_id'],
                'id'  => (int)$_POST['id'],
                "app" => $this->getAppInfo(Gv::$_userInfo['token'])
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('SpeedUpCard','RefundApply','',array('json'=>$json_info));

            if(isset($result['code']) && $result['code'] == 1000){
                exit(json_encode(array('status' => true)));

            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' => false, 'msg' => $result['message'])));

                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' => false, 'msg' => Kohana::message('wx','system_busy'))));
                }
            }

        }

}