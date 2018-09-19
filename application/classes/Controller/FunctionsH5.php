<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 功能controller(和FunctionsH5作用一样,以免和起发生冲突,添加)
 * */
    class Controller_FunctionsH5  extends Home {
        //如果已登录  直接跳转到用户页面
        public function before(){
            parent::before();
            $this->_model['AES26'] = Libs::factory('AES126');
            $this->_model['order'] = Model::factory('Order');

        }
        //订单信息(只接受极速贷,目前)
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
                ){
                    //异常错误
                    exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
                }

                //计算利息
                //$poundage = $this->Poundage($_POST['money'],$_POST['day']);
                //优惠券
                if(Valid::not_empty($_POST['coupinid'])
                    &&Valid::numeric($_POST['coupinid'])
                    &&Valid::not_empty($_POST['offset'])
                    &&Valid::numeric($_POST['offset'])
                ){
                    //手续费小于等于优惠券抵消价格
                    if($_POST['poundage']<=$_POST['offset']){
                        $payment_amount = $_POST['money'];
                        $coupon_amount = $_POST['poundage'];
                    }else{
                        $payment_amount = bcadd(bcsub($_POST['money'], $_POST['poundage'], 2),$_POST['offset'],2);
                        $coupon_amount = $_POST['offset'];
                    }
                    $coupon_id = $_POST['coupinid'];

                }else{
                    $payment_amount = bcsub($_POST['money'], $_POST['poundage'], 2);
                    $coupon_id = 0;
                    $coupon_amount = 0;
                }

                //获取type类型
                if(isset($_POST['type'])&&$_POST['type']==3){  //极速贷
                    $type = 3;
                }else{
                    //类型异常
                    exit(json_encode(array('status' => false,'msg'=>'类型异常')));
                }

                $count = $this->_model['order']->get_order_count(Gv::$user_id,3);
                $array = array(
                    "user_id"=>Gv::$user_id,
                    "loan_amount"=>$_POST['money'],
                    "coupon_id"=>$coupon_id,
                    "coupon_amount"=>$coupon_amount,
                    "day"=>$_POST['day'],
                    "payment_amount"=>$payment_amount,
                    "charge"=>$_POST['poundage'],
                    "ensure_amount" => isset($ensure_amount)?$ensure_amount:$_POST['money'],
                    "ensure_rate"=>isset($_POST['ensure_rate_bu'])?bcmul($_POST['ensure_rate_bu'],0.01,2):0,
                    "type"=>$type,
                    "name"=>$this->_app_session['name'],
                    "mobile"=>$this->_app_session['mobile']
                );

                //判断是添加订单还是修改订单;
                if($count==0){
                    //插入新数据
                    if($insert_id = $this->_model['order']->insert_order($array)){
                        $data = array('status' => true);
                    }else{
                        //异常错误
                        $data = array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'));
                    };
                }elseif($count===false){
                    //异常错误
                    $data = array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'));
                }else{
                    if($this->_model['order'] ->update_order_info_field($array,Gv::$user_id)){
//                        exit(json_encode(array('status' => true)));
                    }else{
                        //当没有修改订单信息的时候会走这
//                        exit(json_encode(array('status' => true)));
                    };
                    $data = array('status' => true);
                }
                if($data['status']){
                    //添加银行卡
                    $variable = array(
                        "user_id"=>Gv::$user_id,
                        "app"=>$this->getappapp($this->_app_session['token'])
                    );
                    $json_info = json_encode($variable);
                    $resultBank = $this->_api->getApiArrays('BankCard','List','',array('json'=>$json_info));

                    if(isset($resultBank) && $resultBank['code']==1000){
                        $this->_model['order']->update_order_info_field(array(
                            "bankcard_id"=>isset($resultBank['result']['bank_card_list'][0]['id'])?$resultBank['result']['bank_card_list'][0]['id']:"",
                            "bankcard_no"=>isset($resultBank['result']['bank_card_list'][0]['card_no'])?$resultBank['result']['bank_card_list'][0]['card_no']:""),
                            Gv::$user_id
                        );
                        $data = array('status' => true);
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
                }else{
                    //异常错误
                    $data = array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'));
                }
                exit(json_encode($data));
            } else {
                //异常错误！
                exit(json_encode(array('status' => false,'msg'=>Kohana::message('wx','abnormal_error'))));
            }
        }
        //极速贷提交
        public function action_checkSubmit(){
            //添加code码,来判断页面跳转页面
            if ($this->request->is_ajax()&&$_POST) {
                //$session = Session::instance('database');(如果是2修改为loan_amount)
                $status_order = $this->_model['order']->get_fieldstatus('type,bankcard_id,creditcard_id,loan_amount,day,coupon_id',Gv::$user_id);
                //获得用户授信情况
                if (empty($status_order['bankcard_id'])) {
                    $this->error('缺少银行卡信息');
                    die;
                }
                //是否添加紧急联系人
                $contact = $this->_user->get_user_step_info("contact",array('user_id'=>Gv::$user_id))['contact'];
                if($contact != 2){
                    $this->error('未添加紧急联系人,请去app上添加!');
                    die;
                }
                //如果是极速贷,不进行信用卡验证
                if(isset($status_order)&&$status_order['type']==3){
                    $variable = array(
                        "user_id"=>Gv::$user_id,
                        "type"=>$status_order['type'],
                        "loan_amount"=>$status_order['loan_amount'],
                        "day"=>$status_order['day'],
                        "bankcard_id"=>$status_order['bankcard_id'],
                        "coupon_id"=>$status_order['coupon_id'],
                        "app"=>$this->getappapp($this->_app_session['token'])
                    );
                    $json_info = json_encode($variable);
                    $result = $this->_api->getApiArrays('Loan','Fast','',array('json'=>$json_info));
                    if(isset($result) && $result['code']==1000){
                        //埋点统计(只有app的)
                        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
                        Model::factory('Activity')->insert_order_count(array('order_id'=>$result['result']['order_id'],'user_id'=>$this->_app_session['user_id'],'ip'=>$ip,'create_time'=>time(),'activity_id'=>11,'reg_app'=>'app'),'order_count');
                        //插入订单信息
                        $order_dele = $this->_model['order']->delete_order($this->_app_session['user_id']);
                        if($order_dele){
                            exit(json_encode(array('status' =>true)));
                        }else{
                            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','abnormal_error'))));
                        }
                    }else{
                        if(isset($result['code'])){
                            //添加code码,来判断页面跳转页面
                            exit(json_encode(array('status' =>false,'msg'=>$result['message'],'code'=>$result['code'])));
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
    //统计
    public function action_statisticsCelebrate(){
        if ($this->request->is_ajax() && $_POST) {
            if(!in_array($_POST['action'],array('look','click'))){
                return false;
            }
            $activity = Model::factory('Activity');
            $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
            $ip = explode(",",$ip)[0];
            if($activity->get_statistics(array('ip'=>trim($ip),'action'=>$_POST['action']),'ac_count')){
                $activity->insert_statistics(array('action'=>$_POST['action'],'ip'=>trim($ip),'create_time'=>time(),'activity_id'=>11),'ac_count');
            }
            exit(json_encode(array('status' =>true)));
        }
    }
}