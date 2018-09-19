<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
class Controller_RegisterApp extends Home
{
    //构造方法  如果已登录  直接跳转到用户页面
    public function before()
    {

//        $this->ip_limit();
        parent::before();
        //获取后排序（不能放在Home里面，要不然Functions不能用）
//        if($this->action=='CreditAccounts' || $this->action=='CreditTaobao' || $this->action=='CreditJD'){
//            //如果是淘宝京东，就判断淘宝京东
//            $this->credit_url($this->action,true);
//        }else{
//            $this->credit_url($this->action);
//        }
    }

    //注册公司信息
    public function action_Company(){

        //通过下面几个字段来判断是否完成基本授信(跳出)
        if(self::$arr_step['phone_book']!=2){
            if(Gv::$type == 2){
                $this->redirect('/Account/Promote?jump=no');
                die;
            }else{
                echo "<script type=\"text/javascript\">history.go(-1)</script>";
                die;
            }
        }
        //跳转
        if(self::$arr_step['work_info']==2){
            $this->redirect('/RegisterApp/ContactsOld');
            die;
        }
        $view = View::factory($this->_vv.'Register/company');
        $view->type = Gv::$type;
        $view->title = Kohana::$config->load("url.title.login_company");
        $this->response->body($view);
    }

    //注册紧急联系人
    public function action_Contacts(){

        if(self::$arr_step['work_info']==2&&self::$arr_step['contact']==2){
            $this->redirect('/Account/Promote?jump=yes');
            die;
        }elseif(self::$arr_step['work_info']==1){
            $this->redirect('/RegisterApp/Company');
            die;
        }
        $view = View::factory($this->_vv.'Register/contactsOld');
        $view->title = Kohana::$config->load("url.title.login_contacts");
        $this->response->body($view);
    }
    //注册公司信息(极速贷进来)
    public function action_CompanyExtreme(){


        //跳转(has_fastloan_order为1则不用添加工作信息)
        if(self::$arr_step['work_info']==2){
            $this->redirect('/RegisterApp/ContactsExtreme');
            die;
        }
//        if(self::$arr_step['work_info']==2||self::$arr_step['has_fastloan_order']==1){
//            $this->redirect('/RegisterApp/ContactsExtreme');
//            die;
//        }

        $view = View::factory($this->_vv.'Register/companyOld');
        //通过下面几个字段来判断是否完成基本授信(跳出)
        if(Gv::$type==1){
            $credit = (isset(Gv::$credited)&&!empty(Gv::$credited))?Gv::$credited:false;
        }elseif(Gv::$type==2){
//            $view->showtitle = true;
            $credit = (isset($this->_app_session['credit_auth'])&&!empty($this->_app_session['credit_auth']))?$this->_app_session['credit_auth']:false;
        }else{
            $this->error(Kohana::message('wx','validation_failure'));
            die;
        }
        //判断是否完成基础授信,允许借款
//        if(!in_array($credit,Model_Home::BASIC_CREDIT_FINISH)){
//            $this->error(Kohana::message('wx','no_right'));
//            die;
//        }
//        Tool::factory('Debug')->D(333333);
        $view->url = "/Borrowmoney/extremeBorrow";
        $view->jumpurl = "/RegisterApp/ContactsExtreme";
        $view->type = Gv::$type;
        $view->title = Kohana::$config->load("url.title.login_company");
        $this->response->body($view);
    }
    //注册紧急联系人(单独限制)(极速贷进来)
    public function action_ContactsExtreme(){
//        echo '<a href="/?jump=no">跳出</a>';
        $view = View::factory($this->_vv.'Register/contactsOld');
        if(Gv::$type==1){
            $credit = (isset(Gv::$credited)&&!empty(Gv::$credited))?Gv::$credited:false;
        }elseif(Gv::$type==2){
//            $view->showtitle = true;
            $credit = (isset($this->_app_session['credit_auth'])&&!empty($this->_app_session['credit_auth']))?$this->_app_session['credit_auth']:false;
        }else{
            $this->error(Kohana::message('wx','validation_failure'));
            die;
        }
        if(self::$arr_step['work_info']==1){
            $this->redirect('/RegisterApp/CompanyExtreme');
            die;
        }

        //判断是否完成基础授信,允许借款
//        if(!in_array($credit,Model_Home::BASIC_CREDIT_FINISH)){
//            $this->error(Kohana::message('wx','no_right'));
//            die;
//        }
        //跳转

        if(self::$arr_step['contact']==2){
            $this->redirect('/Borrowmoney/extremeBorrow?jump=yes');
            die;
        }
        $view->url = "/Borrowmoney/extremeBorrow";
        $view->jumpurl = "/Borrowmoney/extremeBorrow";
        $view->title = Kohana::$config->load("url.title.login_contacts");
        $this->response->body($view);
    }

    //淘宝账号授权
    public function action_CreditTaobao(){
        $this->error_app();
        die;
        $view = View::factory('Register/credittaobao');
        $view->title = Kohana::$config->load("url.title.login_authid");
        $this->response->body($view);
    }

    //淘宝账号授权
    public function action_CreditJD(){
        $this->error_app();
        die;
        if(self::$arr_step['account_mno']==1){
            $this->redirect('/Register/Operator');
            die;
        }
        if(self::$arr_step['account_jingdong']==2 || self::$arr_step['account_jingdong']==8){
            $this->redirect('/Account/Promote?jump=no');
            die;
        }
        $view = View::factory('Register/creditjd');
        $view->title = Kohana::$config->load("url.title.login_authid");
        $this->response->body($view);
    }
    public function action_CreditAccounts(){

        $this->error_app();
        die;

        if((self::$arr_step['account_mno']==2 ||self::$arr_step['account_mno']==8)&&(self::$arr_step['account_jingdong']==2 || self::$arr_step['account_jingdong']==8)){
            $this->redirect('/Account/Promote?jump=no');
            die;
        }
        if(self::$arr_step['account_mno']==1){
            $this->redirect('/Register/Operator');
            die;
        }
        $view = View::factory('Register/creditaccounts');
        if(Gv::$type == 2){
            $app = $this->getappapp(Gv::$app_token);
        }elseif(Gv::$type == 1){
            $app = $this->getapp();
        }else{
            //验证失败
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','validation_failure'))));
        }
        $variable = array(
            "app"=>$app
        );
        $json_info = json_encode($variable);
        $result = $this->api->getApiArrays('CreditInfo','SourceList','',array('json'=>$json_info));
        if(isset($result) && $result['code']==1000){
            $view->jingdong = in_array('jingdong',$result['result'])?Model_Home::CREDIT_NOT_SUBMIT:Model_Home::CREDIT_NOT_OPEN;
            $view->taobao = in_array('taobao',$result['result'])?Model_Home::CREDIT_NOT_SUBMIT:Model_Home::CREDIT_NOT_OPEN;


            if(self::$arr_step['account_taobao'] == Model_Home::CREDIT_NOT_SUBMITED){
                $view->taobao = Model_Home::CREDIT_NOT_SUBMITED;
            }
            if(self::$arr_step['account_jingdong']==Model_Home::CREDIT_NOT_SUBMITED){
                $view->jingdong = Model_Home::CREDIT_NOT_SUBMITED;
            }
            if($view->taobao == 2 || $view->jingdong==2){
                $view->next = true;
            }else{
                $view->next = false;
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
        $view->title = Kohana::$config->load("url.title.login_authid");
        $this->response->body($view);
    }

    //手机运营商
    public function action_Operator(){
        $this->error_app();
        die;
       // Tool::factory('Debug')->D(array(Gv::$mobile,Gv::$type,Gv::$app_token,Gv::$user_id));
        $view = View::factory('Register/operator');
        $view->searchcode = false;
        if(self::$arr_step['account_mno']==2 || self::$arr_step['account_mno']==8){
            $this->redirect('/RegisterApp/CreditAccounts');
            die;
        }
        if(!Valid::not_empty(Gv::$user_id)){
            $this->error('用户未登陆!');
            die;
        }
        if(Gv::$type == 2){
            $mobile = Gv::$mobile;
        }elseif(Gv::$type == 1){
            $mobile = $this->user->get_userinfo_touid(Gv::$user_id)['mobile'];
        }


        if(preg_match('/^(13[4-9]\d{8})|(15(0|1|2|7|8|9)\d{8})|(18(2|3|4|7|8)\d{8})|((147)\d{8})|((178)\d{8})$/', $mobile)){
            $view->Operator = 'yd';
            $view->cellnumber = '10086';
            //判断是否是北京移动(需要查询密码)
            if(Gv::$type == 2){
                $variable_dx = array(
                    "mobile"=>$mobile,
                    "app"=>$this->getappapp(Gv::$app_token)
                );
            }elseif(Gv::$type == 1){
                $variable_dx = array(
                    "mobile"=>$mobile,
                    "app"=>$this->getapp()
                );
            }else{
                //验证失败
                exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','validation_failure'))));
            }
            $json_info_dx = json_encode($variable_dx);
            $result_dx = $this->api->getApiArraysVersion('CreditInfo','MobileLocation','',array('json'=>$json_info_dx));
            if(isset($result_dx) && $result_dx['code']==1000){
                $view->searchcode = $result_dx['result'];
            }else{
                if(isset($result_dx['code'])){
                    //没有拿到openid 网络错误
                    $this->error($result_dx['message']);
                    die;
                }else{
                    //系统繁忙，请联系客服！
                    $this->error(Kohana::message('wx','system_busy'));
                    die;
                }
            }
            //session获取验证码发送次数
        };
//        $sendtime = $this->session->sessionGet('sendtime');
//        $view->sendtime = Valid::not_empty($sendtime)?$sendtime:0;

        if(preg_match('/^(133\d{8})|(153\d{8})|(18(0|1|9)\d{8})|(177\d{8})$/', $mobile)){
            $view->Operator = 'dx';
            $view->cellnumber = '10000';
        };
        if(preg_match('/^(13(0|1|2)\d{8})|(15(5|6)\d{8})|(18(5|6)\d{8})|(145\d{8})|(176\d{8})$/', $mobile)){
            $view->Operator = 'lt';
            $view->cellnumber = '10010';
        };

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            $view->is_weixin =  true;
        }else{
            $view->is_weixin =  false;
        }

        //判断是Android还是ios
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            $view->client = "ios";
            //$view->url = 'http://mp.weixin.qq.com/mp/redirect?url='.urlencode('https://itunes.apple.com/cn/app/kuai-jin/id1130326523?mt=8');
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            $view->client = "android";
        }else{
            $view->client = "else";
        }
        $view->mobile = $mobile;
        $view->title = Kohana::$config->load("url.title.login_operator");
        $this->response->body($view);
    }
    //芝麻信用
    public function action_Sesamecredit(){
        $this->error_app();
        die;

        //$view = View::factory('Register/sesamecredit');
        if(Gv::$type == 2){
            $variable = array(
                "user_id"=>Gv::$user_id,
                "app"=>$this->getappapp(Gv::$app_token)
            );
        }elseif(Gv::$type == 1){
            $variable = array(
                "user_id"=>Gv::$user_id,
                "app"=>$this->getapp()
            );
        }else{
            //验证失败
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','validation_failure'))));
        }
        $json_info = json_encode($variable);
        $result = $this->api->getApiArraysVersion('ZhiMaCredit_Api','auth','',array('json'=>$json_info));
        if(isset($result) && $result['code']==1000){
            //跳出去
            $this->redirect($result['result'].'&jump=zhima');
            //$this->redirect($result['result'].'&jump=zhima');
            die;
            //exit(json_encode(array('status' =>true,'msg'=>$result['message'])));
        }else{
            if(isset($result['code'])){
                //没有拿到openid 网络错误
                $this->error($result['message']);
                die;
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
                die;
            }
        }
//        $view->title = Kohana::$config->load("url.title.login_operator");
//        $this->response->body($view);
    }

}