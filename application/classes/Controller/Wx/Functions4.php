<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 功能ajax请求核心文件（4.0版本通用调取地址）
 *
 * */
class Controller_Wx_Functions4  extends WxHome {
    //如果已登录  直接跳转到用户页面
    public function before(){
        parent::before();
        $this->_model['AES26'] = Libs::factory('AES126');
    }
    /*-------------------------------------------登陆，修改密码----------------------------------------------------------*/
    /**********************
     *  提现
     **********************/
    public function action_Withdrawals(){
        if($this->request->method()==='POST'){
            if(!isset($_POST['money'])||!Valid::numeric($_POST['money'])){
                exit(json_encode(array('status' =>false,'msg'=>'请输入金额！')));
            }

            if($_POST['money']<10){
                exit(json_encode(array('status' =>false,'msg'=>'提现金额不能小于10元！')));
            }


            $variable = array(
                'money'=>$_POST['money'],
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('Wallet','WithdrawApply','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                exit(json_encode(array('status' =>true,'msg'=>'提现成功')));
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else{
            //$this->err('非法请求！');
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','illegal_request'))));
        }
    }

}