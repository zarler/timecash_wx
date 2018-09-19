<?php defined('SYSPATH') or die('No direct script access.');
/*
    账户管理页面输出
*/
    class Controller_Account extends WxHome {
        public function before()
        {
            parent::before();
            //显示部分页面的访问
            //卡用户状态
            if(in_array(Gv::$_userInfo['status'],array(3,4,5))){
                $this->error(Kohana::message('wx','no_right'));
                die;
            }

        }
        
        public function action_index()
        {
            $view = View::factory($this->_vv.'Account/index');
            $view->controller = $this->_controller;
            $view->log = Wxgv::$Log;
            $view->credited = Gv::$_userInfo['credited'];
			$view->title=Kohana::$config->load('url.title.account');
            $this->response->body($view);
        }
        //优惠券
        public function action_coupon(){
            $view = View::factory('Account/coupon');
            $view->title=Kohana::$config->load('url.title.coupon');
            //获取优惠券可用列表
            $variable = array(
                "user_id"=>Gv::$_userInfo['user_id'],
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('Coupon','Available','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                $couponlist = $result['result'];
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
            $view->couponlist = count($couponlist['coupon'])>0?$couponlist['coupon']:null;
            $result = $this->_api->getApiArrays('Coupon','History','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                $couponlastlist = isset($result['result']['coupon'])?(count($result['result']['coupon'])>0?$result['result']['coupon']:null):null;
                $last_id = isset($result['result']['last_id'])?($result['result']['last_id']>0?$result['result']['last_id']:0):0;
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
            $view->controller = $this->_controller;
            $view->couponlastlist = count($couponlastlist)>0?$couponlastlist:null;
            $view->last_id = $last_id?$last_id:null;
            $this->response->body($view);
        }
        //借款记录
        public function action_BorrowingRecords()
        {
            $view = View::factory($this->_vv.'Account/record');
            if(Gv::$_userInfo){
                //获取优惠券可用列表
                $variable = array(
                    "user_id"=>Gv::$_userInfo['user_id'],
                    'last_id'=>0,
                    "app"=>$this->getWxInfo()
                );
                $json_info = json_encode($variable);
                $result = $this->_api->getApiArrays('Order','History','',array('json'=>$json_info));
                if(isset($result) && $result['code']==1000){
                    parent::$_VArray['total'] = isset($result['result']['order'])?count($result['result']['order']):1;
                    parent::$_VArray['last_id'] = isset($result['result']['last_id'])?$result['result']['last_id']:null;
                    parent::$_VArray['order_list'] = isset($result['result']['order'])?(parent::$_VArray['total']>0?$result['result']['order']:null):null;
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
                parent::$_VArray['order_list'] = null;
            }
            parent::$_VArray['title']=Kohana::$config->load('url.title.borrowingrecords');

             $view->_VArray =  parent::$_VArray;
            $this->response->body($view);
        }
        //授信管理
        public function action_Promote(){
            $view = View::factory($this->_vv.'Account/promote');
            $variable = array(
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result_info = $this->_api->getApiArrays('CreditInfo','Step','',array('json'=>$json_info));
            //Tool::factory('Debug')->D($result_info);
            if(isset($result_info['code']) && $result_info['code']==1000){
                $view->step = $result_info['result']['credit_info']['step'];
                $view->reduce_apply = $result_info['result']['reduce_apply'];
            }else{
                if(isset($result_info['code'])){
                    $this->error($result_info['message']);
                    die;
                }else{
                    //系统繁忙，请联系客服！
                    $this->error(Kohana::message('wx','system_busy'));
                    die;
                }
            }
            //通过下面几个字段来判断是否完成基本授信
//            if(isset(Gv::$_userInfo['credited'])&&in_array(Gv::$_userInfo['credited'],array(1,2,3,4,5,6,7,15))){
//                $view->jump = true;
//            }else{
//                $view->jump = false;
//            }
            $view->jump = true;
//            if($view->step['identity']==2 && $view->step['phone_book']==2 && $view->step['faceid']==2){
//                $view->jump = true;
//            }else{
//                $view->jump = false;
//            }
            //是否有信用卡
            $view->have_credit = $this->_have_credit;
//            Tool::factory('Debug')->D(array($view->reduce_apply,$view->have_credit));
            //通过授信来判断显示内容
            if(isset(Gv::$_userInfo['credited'])&&!empty(Gv::$_userInfo['credited'])){
                switch (Gv::$_userInfo['credited']){
                    case 3:
                    case 4:
                        $view->tvtips = '申请审核中';
                        break;
                    case 5:
                        $view->tvtips = '审核已通过';
                        break;
                    case 6:
                        $view->tvtips = '您的申请未通过,请于'.date('Y年m月d日',strtotime($view->reduce_apply['apply_date'])).'后重新申请';
                        break;
                    default:
                        $view->tvtips = '';
                        break;
                }
                $view->credited = Gv::$_userInfo['credited'];
            }else{
                $view->credited = null;
            }
            //测试:
//            $view->reduce_apply['enable'] = 1;  //显示提交按钮
//            $view->reduce_apply['show'] = 1;  //显示显示不显示申请结果
//            $view->have_credit = 1;             //没有信用卡

            $view->ensure_rate = bcmul(Gv::$_userInfo['ensure_rate'],100,0);
            $view->title=Kohana::$config->load('url.title.quota');
            $this->response->body($view);
        }
        //更新银行卡信息
        public function action_bankinfo(){

            $view = View::factory($this->_vv.'Account/bank');
//            $bankinfo = Model::factory('Bankcard')->get_bankcard_info(Gv::$_userInfo['user_id']);
            //获取所有银行
            $variable = array(
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            //获取银行卡信息
            $bankCode = $this->_api->getApiArrays('BankCard','List','',array('json'=>$json_info));
            if(isset($bankCode['code']) && $bankCode['code']==1000){
                //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
                if(isset($bankCode['result']['bank_card_list'])&&!empty($bankCode['result']['bank_card_list'])){
                    $bankinfo = $bankCode['result']['bank_card_list'];
                }else{
                    $bankinfo = null;
                }
            }else{
                if(isset($bankCode['code'])){
                    $this->error($bankCode['message']);
                    die;
                }else{
                    //系统繁忙，请联系客服！
                    $this->error(Kohana::message('wx','system_busy'));
                    die;
                }
            }
            //获取银行
            $bank = $this->_api->getApiArrays('Settings','Index','',array('json'=>$json_info));
            if(isset($bank['code']) && $bank['code']==1000){
                //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
                parent::$_VArray['bank'] = $bank['result']['bank'];
            }else{
                if(isset($bank['code'])){
                    $this->error($bank['message']);
                    die;
                }else{
                    //系统繁忙，请联系客服！
                    $this->error(Kohana::message('wx','system_busy'));
                    die;
                }
            }
            if(empty($bankinfo)){
                //如果有银行卡进入添加银行卡页面
//                $view->new = false;
//                $view->title = Kohana::$config->load('url.title.bankinfo');
//                $view->tip = '添加';
//                $view->ntitle = '添加银行卡';
                //没有借记卡的时候,需要踢出去
                $this->error(Kohana::message('wx','illegal_request'));
                die;
            }else{
                //如果没有进入修改银行卡页面
                parent::$_VArray['new'] = true;
                //借钱最大额度 真名 写入session
                parent::$_VArray['title'] = Kohana::$config->load('url.title.update_bank');
                parent::$_VArray['tip'] = '下一步';
                parent::$_VArray['ntitle'] = '更改银行卡';
            }
            parent::$_VArray['mobile'] = Gv::$_userInfo['mobile'];
            parent::$_VArray['requestUrl'] = "/wx/Functions/uploadbank";
            $view->_VArray =  parent::$_VArray;
            $this->response->body($view);
        }
        //银行卡管理
        public function action_bankCreditList(){
            $this->_model['bank'] = Model::factory('Bankcard');
            $variable = array(
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            //获取银行卡信息
            $resultBank = $this->_api->getApiArrays('BankCard','List','',array('json'=>$json_info));
            if(isset($resultBank) && $resultBank['code']==1000){
                if(isset($resultBank['result']['bank_card_list'])&&!empty($resultBank['result']['bank_card_list'])){
                    parent::$_VArray['bankArr'] = $resultBank['result']['bank_card_list'];
                    foreach (parent::$_VArray['bankArr'] as $key=>&$val){
                        $val['card_no'] =substr($val['card_no'],-4);
                        $val['img'] = '/static/images/v2/bank/'.$val['bank_code'].'.png';
                        //测试写死
//                        $val['is_expire'] = 1;
                    }
                }else{
                    parent::$_VArray['bankArr'] = null;
                }
            }else{
                if(isset($resultBank['code'])){
                    $this->error($resultBank['message']);
                    die;
                }else{
                    //系统繁忙，请联系客服！
                    $this->error(Kohana::message('wx','system_busy'));
                    die;
                }
            }
            //信用卡存在过时删除功能
            $result = $this->_api->getApiArrays('CreditCard','List','',array('json'=>$json_info));
            if(isset($result['result']) && $result['code']==1000){
                if(isset($result['result']['credit_card_list'])&&!empty($result['result']['credit_card_list'])){
                    parent::$_VArray['creditArr'] = $result['result']['credit_card_list'];
                    foreach (parent::$_VArray['creditArr'] as $key=>&$val){
                        $val['card_no'] =substr($val['card_no'],-4);
                        $val['img'] = '/static/images/v2/bank/'.$val['bank_code'].'.png';
                        //测试写死
//                        $val['is_expire'] = 1;
                    }
                }else{
                    parent::$_VArray['creditArr'] = null;
                }
            }else{
                if(isset($result['code'])){
                    //系统繁忙，请联系客服！
                    $this->error($result['message']);
                    die;
                }else{
                    //系统繁忙，请联系客服！
                    $this->error(Kohana::message('wx','system_busy'));
                    die;
                }
            }

            //标记返回页面
            if(isset($_GET['bj'])&&$_GET['bj']=='credit'){
                parent::$_VArray['bj'] = true;
            }else{
                parent::$_VArray['bj'] = false;
            }
            parent::$_VArray['title'] = Kohana::$config->load('url.title.bank_card_manage');
            $view = View::factory($this->_vv.'Account/bankcardmanage');
            $view->_VArray =  parent::$_VArray;
            $this->response->body($view);
        }

}