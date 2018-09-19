<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 功能controller(和FunctionsH5作用一样,以免和起发生冲突,添加)
 * */
    class Controller_H5_FunctionsAct  extends Common
    {
        //如果已登录  直接跳转到用户页面
        public function before()
        {
            parent::before();
        }

        /************************************************************************************************************************************
         * 026 人拉人活动
         ************************************************************************************************************************************/
//        抽奖
    public function action_026LuckDraw()
    {
        if ($this->request->is_ajax() && $_POST) {
//                exit(json_encode(array('status' =>true,'msg'=>array('id'=>20,'prize'=>'20元免息券','deg'=>180))));
            $tokenArr = Cookie::get("tokenArr");
            $tokenArr = json_decode($tokenArr, true);
            if (isset($tokenArr['token']) && Valid::not_empty($tokenArr['token'])) {
                $variable = array(
                    "app" => $this->getH5Info($tokenArr['token'])
                );
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('AC_TCOA026', 'GetPrize', '', array('json' => $json_info), 'v');
                if (isset($result) && $result['code'] == 1000) {
                    if (isset($result['result']) && Valid::not_empty($result['result'])) {
                        switch ($result['result']['prize_id']) {
                            case 1:
                                $result['result']['deg'] = 300;
                                break;
                            case 3:
                                $result['result']['deg'] = 120;
                                break;
                            case 8:
                                $result['result']['deg'] = 240;
                                break;
                            case 88:
                                $result['result']['deg'] = 60;
                                break;
                            case 20:
                                //免息
                                $result['result']['deg'] = 180;
                                break;
                            default:
                                break;
                        }
                        exit(json_encode(array('status' => true, 'msg' => $result['result'])));
                    } else {
                        exit(json_encode(array('status' => false, 'msg' => Kohana::message('wx', 'system_busy'))));
                    }
                } else {
                    if (isset($result['code'])) {
                        exit(json_encode(array('status' => false, 'code' => $result['code'], 'msg' => $result['message'])));
                    } else {
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' => false, 'msg' => Kohana::message('wx', 'system_busy'))));
                    }
                }
            } else {
                //异常错误！
                exit(json_encode(array('status' => false, 'msg' => Kohana::message('wx', 'abnormal_error'))));
            }
//                exit(json_encode(array('status' => true,'msg'=>60)));
        } else {
            //异常错误！
            exit(json_encode(array('status' => false, 'msg' => Kohana::message('wx', 'abnormal_error'))));
        }
    }

    //领券
    public function action_026Coupons()
    {
        if ($this->request->is_ajax() && $_POST) {
            $tokenArr = Cookie::get("tokenArr");
            $tokenArr = json_decode($tokenArr, true);

            if (isset($tokenArr['token']) && Valid::not_empty($tokenArr['token'])) {
                $variable = array(
                    "app" => $this->getH5Info($tokenArr['token'])
                );
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('AC_TCOA026', 'GetCoupon', '', array('json' => $json_info), 'v');

                if (isset($result) && $result['code'] == 1000) {
                        if(isset($result['result'])&&Valid::not_empty($result['result'])){
                            exit(json_encode(array('status' => true)));
                        }else{
                            exit(json_encode(array('status' => false, 'msg' => Kohana::message('wx', 'system_busy'))));
                        }
                } else {
                    if (isset($result['code'])) {
                        exit(json_encode(array('status' => false, 'msg' => $result['message'])));
                    } else {
                        //系统繁忙，请联系客服！
                        exit(json_encode(array('status' => false, 'msg' => Kohana::message('wx', 'system_busy'))));
                    }
                }
            } else {
                //异常错误！
                exit(json_encode(array('status' => false, 'msg' => Kohana::message('wx', 'abnormal_error'))));
            }
        } else {
            //异常错误！
            exit(json_encode(array('status' => false, 'msg' => Kohana::message('wx', 'abnormal_error'))));
        }
    }
    /************************************************************************************************************************************
     * 验证码
     ************************************************************************************************************************************/
        //验证码
        public function action_VerificationCode(){
            if ($this->request->is_ajax() && $_POST) {

                if(!isset($_POST['phone'])||!Valid::not_empty($_POST['phone'])){
                    exit(json_encode(array('status' => false,'msg'=>'数据异常')));
                }
                $tokenArr = Cookie::get("tokenArr");
                $tokenArr = json_decode($tokenArr,true);
                if(isset($tokenArr['token'])&&Valid::not_empty($tokenArr['token'])){
                    $variable = array(
                        "mobile"=>$_POST['phone'],
                        "app"=>$this->getH5Info($tokenArr['token'])
                    );
                    $json_info = json_encode($variable);
                    $result = $this->_api->getApiArrays('User','RegisterVerifySMS','',array('json'=>$json_info),'v');
                    if(isset($result) && $result['code']==1000){
                        exit(json_encode(array('status' =>true)));
                    }else{
                        if(isset($result['code'])){
                            exit(json_encode(array('status' =>false,'code'=>$result['code'],'msg'=>$result['message'])));
                        }else{
                            //系统繁忙，请联系客服！
                            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                        }
                    }
                }else{
                    //异常错误！
                    exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
                }
            } else {
                //异常错误！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
            }
        }
    /************************************************************************************************************************************
     * 注册
     ************************************************************************************************************************************/
        public function action_Register(){
            if ($this->request->is_ajax() && $_POST) {
                $tokenArr = Cookie::get("tokenArr");
                $tokenArr = json_decode($tokenArr,true);
                if(isset($tokenArr['token'])&&Valid::not_empty($tokenArr['token'])){
                    if(!isset($_POST['phone'])||!Valid::not_empty($_POST['phone'])||!Valid::not_empty($_POST['code'])||!Valid::digit($_POST['code'])||!isset($_POST['password'])||!Valid::not_empty($_POST['password'])){
                        exit(json_encode(array('status' => false,'msg'=>'数据异常')));
                    }
                    $variable = array(
                        "inviter_user_id"=>isset($_POST['inviterUserId'])?$_POST['inviterUserId']:null,
                        "mobile"=>$_POST['phone'],
                        'verify_code'=>$_POST['code'],
                        'agent_code'=>isset($_POST['agent_code'])?$_POST['agent_code']:null,   //代理id,写死
                        'password'=>Libs::factory('AES126')->encrypt($_POST['password'],$this->_api_config['app_h5']['app_key']),   //代理id,写死
                        "app"=>$this->getH5Info($tokenArr['token'])
                    );
                    $json_info = json_encode($variable);
                    $result = $this->_api->getApiArrays('User','RegisterMobile','',array('json'=>$json_info));
                    if(isset($result) && $result['code']==1000){
                        if(isset($result['result']['user_id'])&&Valid::not_empty($result['result']['user_id'])){
                            Cookie::set("userId",$result['result']['user_id']);
                        }
                        exit(json_encode(array('status' =>true)));
                    }else{
                        if(isset($result['code'])){
                            exit(json_encode(array('status' =>false,'code'=>$result['code'],'msg'=>$result['message'])));
                        }else{
                            //系统繁忙，请联系客服！
                            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                        }
                    }

                }else{
                    //异常错误！
                    exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
                }
            } else {
                //异常错误！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
            }
        }

}