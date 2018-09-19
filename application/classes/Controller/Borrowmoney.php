<?php 
header("Content-type: text/html; charset=utf-8"); 
defined('SYSPATH') or die('No direct script access.');
/*
	借款整个流程
		选择信用借款、担保借款
		确定借款金额、天数
		添加借款借记卡
		添加信用担保卡（可多张）
		选择默认的担保卡
		核对当前借款信息
		点击跳转银行第三方 完成信用卡预售权冻结
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
*/
class Controller_Borrowmoney extends WxHome{
    private $status;//判断用户的借款状态
    private $bankcard = null;//订单id
    private $is_bank = false;  //是否属于允许借款银行

    public function before()
    {
        parent::before();

        //阻止用户借款 贷款额到上线
        $this->_model['order'] = Model::factory('Order');
        $this->_model['bankcard'] = Model::factory('Bankcard');
        //卡用户状态
        parent::powerStatus();
        //做一些放跳过来的授信限制
//        parent::powerCredit();
    }
    /*******************************************************
     *   担保借款  信用借款   选择页面
     *******************************************************/
	public function action_index(){
        $this->error(Kohana::message('wx','no_page'));
        die;
	}

    /*******************************************************
     *  添加贷款银行卡信息
     *******************************************************/
    public function action_bankinfo()
    {
        $variable = array(
            "app"=>$this->getWxInfo()
        );
        $json_info = json_encode($variable);
        //区分进入该页面的入口页面(不明坑)
        if(isset($_GET['entrance'])){
            switch ($_GET['entrance']){
                case 'promote':
                    //授信页面
                    parent::$_VArray['entrance'] = '/Account/Promote';
                    break;
                case 'bankCreditList':
                    //授信页面
                    parent::$_VArray['entrance'] = "/Account/bankCreditList";
                    break;
                default:
                    break;
            }
        }else{
            //查找是否有注册银行卡(从借款流程进来)
            $resultBank = $this->_api->getApiArrays('BankCard','List','',array('json'=>$json_info));
            if(isset($resultBank['code']) && $resultBank['code']==1000){
                if(count($resultBank['result']['bank_card_list'])>0){
                    //补充用户订单证件信息
                    $this->_model['order']->update_order_info_field(array(
                        "bankcard_id"=>$resultBank['result']['bank_card_list'][0]['id'],
                        "bankcard_no"=>$resultBank['result']['bank_card_list'][0]['card_no']),
                        Gv::$_userInfo['user_id']
                    );
                    $this->redirect("/Borrowmoney/guarantee");
                    die;
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
        }
        //获取所有银行
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
        //借钱最大额度 真名 写入session
        parent::$_VArray['userinfo'] = Gv::$_userInfo;
        parent::$_VArray['title'] = Kohana::$config->load('url.title.bankinfo');
        parent::$_VArray['requestUrl'] = "/wx/Functions/docreditorder";
        parent::$_VArray['prompt'] = '请在借款到期前保证卡内有足够余额，到期时会自动划扣卡内余额还款。<br /><br />若出现逾期还款，将从您的信用卡内扣除未还款金额及罚息。';
        $view = View::factory($this->_vv.'Borrowmoney/bank');
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);
    }

    /*******************************************************
     *  选择信用卡(由借记卡页面进来)
     *******************************************************/
    public function action_guarantee()
    {
        //通过订单查找是否有注册银行卡(订单信息)
        $status = $this->_model['order']->get_fieldstatus('type,ensure_amount,creditcard_id,bankcard_id,status,loan_amount,payment_amount,repayment_amount',Gv::$_userInfo['user_id']);

        if($status['status'] != '0'&&!Valid::not_empty($status['bankcard_id'])){
            //如果没有添加银行卡，跳到银行卡添加页面
            $this->redirect("/Borrowmoney/bankinfo");
            die;
        }
        //用type来测试是否是极速贷(3为极速贷),跳订单确定页面
        if(isset($status['type'])&&$status['type']==3){
            //判断
            if(isset($status['creditcard_id'])&&!empty($status['creditcard_id'])){
                //删除订单里面的信用卡信息
                $this->_model['order']->update_order_info_field(array('creditcard_id'=>0,'creditcard_card'=>NULL),Gv::$_userInfo['user_id']);
            }
            $this->redirect("/Borrowmoney/check");
            die;
        }
        //信用卡存在过时删除功能
        $variable = array(
//            "user_id"=>Gv::$_userInfo["user_id"],
            "app"=>$this->getWxInfo()
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('CreditCard','List','',array('json'=>$json_info));
        if(isset($result['result']) && $result['code']==1000){
            if(isset($result['result']['credit_card_list'])&&!empty($result['result']['credit_card_list'])){
                $creditArr = $result['result']['credit_card_list'];
                foreach ($creditArr as $key=>&$val){
                    $val['card_no'] =substr($val['card_no'],-4);
                    $val['img'] = '/static/images/v2/bank/'.$val['bank_code'].'.png';
                    //测试写死
//                  $val['is_expire'] = 1;
                }
            }else{
                $creditArr = null;
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
        //判断是否添加过担保信用卡
        if (empty($creditArr)) {
            if (empty($_GET['ban'])){
                //如果是新来的 直接跳转到添加卡里
                $this->redirect('Borrowmoney/guaranteeadd');
            } else {
                //第N次添加担保卡
                $this->redirect('Borrowmoney/guaranteeadd?ban=1');
            }
        } else {

            //查找订单是否有信用卡
//            $creditcard = $this->order->get_fieldstatus('creditcard_id');;
//            if (!empty($default['id']) && empty($creditcard['creditcard_id'])) {
//                //修改当前订单的担保卡信息
//                $this->order->update_order_info_field(array('creditcard_id' => $default['id']));
//            }
            //获取用到预授权金额
            parent::$_VArray['creditcard_id'] = $status['creditcard_id'];
            parent::$_VArray['amount'] = $status['type']==2?$this->MoneyStrStr($status['ensure_amount']):$this->MoneyStrStr($status['repayment_amount']);
            parent::$_VArray['creditarray'] = $creditArr;//获取到该用户所有的信用担保卡
            parent::$_VArray['title'] = Kohana::$config->load('url.title.borrowmoney');
            parent::$_VArray['requestUrl'] = "/wx/Functions/docreditorder";
            $view = View::factory($this->_vv.'Borrowmoney/guarantee');
            $view->_VArray =  parent::$_VArray;
            $this->response->body($view);
        }
    }

    /*******************************************************
     *  添加担保卡页面(由新手进来或点击添加信用卡入口进来)
     *******************************************************/
    public function action_guaranteeadd()
    {
        $view = View::factory($this->_vv.'Borrowmoney/guaranteeadd');
        if (!empty($_GET['ban'])) {
            parent::$_VArray['ban'] = '1';
        }
        //返跳页面
        if (isset($_GET['entrance'])&&!empty($_GET['entrance'])) {
            switch ($_GET['entrance']){
                case 'promote':
                    //授信页面
                    parent::$_VArray['entrance'] = "/Account/bankCreditList";
                    break;
                case 'bankCreditList':
                    //授信页面
                    parent::$_VArray['entrance'] = "/Account/bankCreditList?bj=credit";
                    break;
                default:
                    break;
            }
        }
        //查找是否有注册银行卡
        $status = $this->_model['order']->get_fieldstatus('type,ensure_amount,bankcard_id,status,loan_amount,repayment_amount',Gv::$_userInfo['user_id']);
        parent::$_VArray['amount'] = $status['type']==2?$this->MoneyStrStr($status['ensure_amount']):$this->MoneyStrStr($status['repayment_amount']);
        parent::$_VArray['mobile'] = Gv::$_userInfo["mobile"];
        parent::$_VArray['title'] = Kohana::$config->load('url.title.credit');
        parent::$_VArray['requestUrl'] = "/wx/Functions/docredit";
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);
    }

    /*******************************************************
     *  确认订单
     *******************************************************/
    public function action_check()
    {


        //在修改状态前 判断一下该有的数据 是否有
        $status_order = $this->_model['order']->get_fieldstatus('bankcard_id,bankcard_no,creditcard_id,creditcard_card,loan_amount,payment_amount,charge,day,name,mobile,charge_management,coupon_amount,coupon_id,ensure_amount,type,ensure_rate,coin',Gv::$_userInfo['user_id']);
        //金钱计算对比（验证）

//        $ensure_rate = bcmul($status_order['loan_amount'],$status_order['ensure_rate'],2);
//        if($ensure_rate!=$status_order['ensure_amount']){
//            $this->error('数据异常！');
//            die;
//        }
        //如果默认的信用卡过期了 返回错误信息
        /* if((date('m',$if['expire_date'])-date('m'))<3 && date('Y',$if['expire_date'])<date('Y')){
            $this->error('默认信用卡已过期');
        } */

        $app  = $this->getWxInfo();
        //极速贷
        if(isset($status_order['type'])&&$status_order['type'] == 3){
            $view = View::factory($this->_vv.'Borrowmoney/checkextreme');
            $variable = array(
                "app"=>$app
            );
            $json_info = json_encode($variable);
            //当日借款统计(极速贷)
            $result = $this->_api->getApiArrays('FastLoan_Loan','Status','',array('json'=>$json_info));
            if(isset($result['code']) && $result['code']==1000){
                //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
                //担保比例（有可能不同步，需要重新返首页获取用心最新信息）
                $nowtime = time();
                //不能进行极速贷请求
                if($result['result']['today_max']<=$result['result']['today_total']||$result['result']['today_end']<=$nowtime||$result['result']['today_start']>=$nowtime||$result['result']['on']!=1){
                    if($result['result']['today_start']<$nowtime &&$result['result']['today_max']<=$result['result']['today_total']&&$result['result']['today_end']>$nowtime){
                        parent::$_VArray['prompt'] = '抱歉，今日极速贷已抢完，明日'.date("H:s",$result['result']['today_start']).'开放抢单';
                    }elseif ($result['result']['on']!=1){
                        parent::$_VArray['prompt'] = '极速贷未开放';
                    }elseif ($result['result']['today_start']>$nowtime){
                        parent::$_VArray['prompt'] = '开放抢单时间为每日'.date("H:s",$result['result']['today_start']).'，等下再来吧~';
                    }elseif($result['result']['today_end']<$nowtime){
                        parent::$_VArray['prompt'] = '抢单时间已过,请明天再来吧~';
                    }else {
                        parent::$_VArray['prompt'] = '极速贷未开放';
                    }
                    parent::$_VArray['startExtreme'] = false;
                }else{
                    parent::$_VArray['startExtreme'] = true;
                }
                parent::$_VArray['faststatus'] = $result['result'];
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
            parent::$_VArray['requestUrl'] = "/wx/Functions/checkSubmit";
        }else{
            $view = View::factory($this->_vv.'Borrowmoney/check');
        }
        //提交订单
        $variable = array(
            'user_id'=>Gv::$_userInfo['user_id'],
            'type'=>$status_order['type'],
            'loan_amount'=>$status_order['loan_amount'],
            'day'=>$status_order['day'],
            'bankcard_id'=>$status_order['bankcard_id'],
            'creditcard_id'=>$status_order['creditcard_id'],
            'coupon_id'=>$status_order['coupon_id'],
            "coin"=>$status_order['coin'],
            "app"=>$app
        );
        $json_info = json_encode($variable);
        //提交订单暂时保存
        if($status_order['type']==1){
            $result = $this->_api->getApiArrays('FullPreAuthLoan_Loan','Confirm','',array('json'=>$json_info));
        }elseif($status_order['type']==2){
            $result = $this->_api->getApiArrays('PreAuthLoan_Loan','Confirm','',array('json'=>$json_info));
        }elseif($status_order['type']==3){
            $result = $this->_api->getApiArrays('FastLoan_Loan','Confirm','',array('json'=>$json_info));
        }else{
            $this->error('异常错误');
            die;
        }

        if(isset($result['app_redirect']['url'])){
            $url = $this->Routing($result['app_redirect']['url'])['url'];
            if(Valid::not_empty($url)){
                $this->error($result['message']);
                die;
            }
        }
        if(isset($result['code'])&&$result['code']==1000){
            $viewshow['loan_amount'] = $this->MoneyStrStr($result['result']['order']['loan_amount']);
            $viewshow['day'] = $result['result']['order']['day'];
            //循环获取手续费
            parent::$_VArray['order_charge_item'] = '';
            if(isset($result['result']['order_charge_item'])&&!empty($result['result']['order_charge_item'])){
                foreach ($result['result']['order_charge_item'] as $val){
                    parent::$_VArray['order_charge_item'] .= '<p class="t-login-center-1 border-bottom check_charge"><span class="form-control float_left">'.$val['name'].'</span><label class="float_right">'.$val['amount'].$val['unit'].'</label></p>';
                }
            }
            //费用扩展
            parent::$_VArray['order_charge_extension'] = '';
            if(isset($result['result']['order_charge_extension'])&&Valid::not_empty($result['result']['order_charge_extension'])){
                foreach ($result['result']['order_charge_extension'] as $value){
                    parent::$_VArray['order_charge_extension']  .= '<p class="t-login-center-1 border-bottom"><span class="form-control float_left">'.$value['name'].'</span><label class="float_right">'.$value['amount'].$value['unit'].'</label></p>';
                }
            }
            if(isset($result['result']['order_charge'][1]['amount'])&&$result['result']['order_charge'][1]['amount']!=0){
                $viewshow['coupon_amount'] = '-'.$this->MoneyStrStr($result['result']['order_charge'][1]['amount']);
            }else{
                $viewshow['coupon_amount'] = 0;
            }
            $viewshow['payment_amount'] = $this->MoneyStrStr($result['result']['order']['payment_amount']);
            $viewshow['charge'] = $this->MoneyStrStr($result['result']['order_charge_total'][0]['amount']).$result['result']['order_charge_total'][0]['unit'];
            $viewshow['charge_name'] = $result['result']['order_charge_total'][0]['name'];
            $viewshow['repayment_amount'] = $this->MoneyStrStr($result['result']['order']['repayment_amount']);
            $viewshow['bankcard_no'] = $result['result']['order']['bankcard_no'];
            $viewshow['ensure_rate'] = bcmul($status_order['ensure_rate'],100,0);
            $viewshow['ensure_amount'] = $status_order['ensure_amount'];
            $viewshow['creditcard_card'] = $status_order['creditcard_card'];
            parent::$_VArray['rateSummary'] = isset($result['result']['foot_html'])?$result['result']['foot_html']:0;
            //其余活动消费扩展
            if(isset($result['result']['order_extension'])&&Valid::not_empty($result['result']['order_extension'])){
                parent::$_VArray['extension'] = $result['result']['order_extension'];
            }else{
                parent::$_VArray['extension'] = null;
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


        $viewshow['type'] = $status_order['type'];
        //查询当前用户的订单信息
        parent::$_VArray['personal'] = $viewshow;
        parent::$_VArray['title'] = Kohana::$config->load('url.title.check');
        parent::$_VArray['name'] = Gv::$_userInfo['nickname'];
        parent::$_VArray['mobile'] = Gv::$_userInfo['mobile'];
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);
    }

    /*******************************************************
     *  跳转到银行第三方页面
     *******************************************************/
    public function action_skip(){
        $status_order = $this->_model['order']->get_fieldstatus('user_id,type,bankcard_id,creditcard_id,loan_amount,day,coupon_id,coin',Gv::$_userInfo['user_id']);

        //做保险coin和优惠券不能同时存在
        if ($status_order['coupon_id']>0&&$status_order['coin']>0) {
            exit(json_encode(array('status' => false,'msg'=>'优惠券和金额只能选择一项!')));
        }

        //如果是极速贷,不进行信用卡验证
        if(isset($status_order)&&$status_order['type']==3){
            $this->error('异常错误');
            die;
        }elseif(isset($status_order)&&($status_order['type']==1 || $status_order['type']==2)){
            if (empty($status_order['creditcard_id'])) {
                $this->error('缺少重要数据');
                die;
            }
            //exit(json_encode(array('status' => false,'msg'=>json_encode($status_order))));
            $app = $this->getWxInfo();
            $status_order['app'] = $app;
            $json_info = json_encode($status_order);
            if($status_order['type']==1){
                $result = $this->_api->getApiArrays('FullPreAuthLoan_Loan','Apply','',array('json'=>$json_info));
            }elseif($status_order['type']==2){
                $result = $this->_api->getApiArrays('PreAuthLoan_Loan','Apply','',array('json'=>$json_info));
            }else{
                $this->error('异常错误');
                die;
            }
            if(isset($result) && $result['code']==1000){
                //注册成功,插入用户id
                $order_dele = $this->_model['order']->delete_order($status_order['user_id']);
                if($order_dele){

                    echo $result['result']['html'];
                }else{
                    //异常错误
                    echo "<script>alert('".Kohana::message('wx','abnormal_error')."');window.location.href='/Borrowmoney/check';</script>";
                    die;
                    // exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','abnormal_error'))));
                }
                die;
            }else{
                if(isset($result['code'])){
                    //连连验证入口
                    if($result['code']==5194){
                        //验证是否需要连连支付
                        $variable = array(
                            "app"=>$app
                        );
                        $json_info = json_encode($variable);
                        //当日借款统计(极速贷)
                        $result = $this->_api->getApiArrays('BankCard','BindCheck','',array('json'=>$json_info));
                        if(isset($result) && $result['code']==1000){
                            if(isset($result['result']['jump'])&&$result['result']['jump']==1){
                                //保存跳出前页面
                                $this->_session->sessionSet('lianlian_jump_url','/Borrowmoney/check');
                                //如果是通过订单程序添加的银行卡
                                echo $result['result']['html'];
                                die;
                            }else{
                                //不需要连连验证,跳过
                                echo "<script>window.location.href='/Borrowmoney/check';</script>";
                                die;
                            }
                        }else{
                            if(isset($result['code'])){
                                echo "<script>alert('".$result['message']."');window.location.href='/Borrowmoney/check';</script>";
                                die;
                            }else{
                                //系统繁忙，请联系客服！
                                echo "<script>alert('".Kohana::message('wx','system_busy')."');window.location.href='/Borrowmoney/check';</script>";
                                die;
                            }
                        }
                    }else{
                        //系统繁忙，请联系客服！
                        echo "<script>alert('".$result['message']."');window.location.href='/Borrowmoney/check';</script>";
                        die;
                        //添加code码,来判断页面跳转页面
//                        exit(json_encode(array('status' =>false,'msg'=>$result['message'],'code'=>$result['code'])));
                    }

                }else{
                    //系统繁忙，请联系客服！
                    echo "<script>alert('".Kohana::message('wx','system_busy')."');window.location.href='/Borrowmoney/check';</script>";
                    die;
                    //exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else{
            $this->error('异常错误!');
            die;
        }
    }

    /*******************************************************
     *  判断预售权走的通道
     *******************************************************/
    private function gallery()
    {
        //请求接口 返回该走哪个信用卡通道（跳转 或 非跳转）
        $url = Kohana::$config->load('url.communic_url.authpass_url');
        $option = json_decode($this->curlopen($url, array('status' => '1')), true);

        if (!empty($option['status']) && $option['status'] === true) {
            return $option['jump'];
        } else { //没有请求到 或 返回错误
            $this->error('不可抗拒错误');
        }
    }


    public function action_isCoupon()
    {
        if ($this->request->is_ajax()) {
            $post = $this->request->post();
            $couponlist = Model::factory('Coupon')->UserCoupon($this->_session->sessionGet("uid"));
            foreach ($couponlist['couponlist'] as $k => $v) {
                switch ($v['type']) {
                    case '1':
                        if ($post['money'] >= $v['min_loan']) {
                            $isStatus[$v['id']] = '1';
                        } else {
                            $isStatus[$v['id']] = '2';
                        }
                        break;
                    case '2':
                        if ($post['money'] >= $v['min_loan'] && $post['day'] >= $v['min_day']) {
                            $isStatus[$v['id']] = '1';
                        } else {
                            $isStatus[$v['id']] = '2';
                        }
                        break;
                    case '3':
                        //利息
                        $poundage = $this->Poundage($post['money'], $post['day']);
                        if ($poundage >= $v['full_cut']) {
                            $isStatus[$v['id']] = '1';
                        } else {
                            $isStatus[$v['id']] = '2';
                        }
                        break;
                }
            }
            echo json_encode($isStatus);
            //file_put_contents('abc.txt',json_encode($isStatus));
        }
    }


    /*******************************************************
     *   发送到借款信息页面
     *******************************************************/
    public function action_borrow(){
        //判断当前的订单状态   如果是没有完成的状态  把之前的信息读取 输出
        parent::$_VArray['poundageinfo'] = null;
        //type区分借款类型(1,2为担保借款)
        $variable = array(
            "app"=>$this->getWxInfo()
        );
        $json_info = json_encode($variable);
        //修改,里面有优惠券和余额信息
        $result = $this->_api->getApiArrays('Preferential','Available','',array('json'=>$json_info));
        if(isset($result) && $result['code']==1000){
            //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
            if(isset($result['result']['coupon'])&&count($result['result']['coupon'])>0){
                parent::$_VArray['couponlist'] = array('couponlist'=>$result['result']['coupon'],'count'=>count($result['result']['coupon']));
            }else{
                parent::$_VArray['couponlist'] = array('couponlist'=>"",'count'=>0);
            }
            //余额
            parent::$_VArray['coin'] = isset($result['result']['coin'])?$result['result']['coin']:"0.00";
            //测试
//            $view->coin = 100;
            //余额比例
            parent::$_VArray['use_ratio'] = isset($result['result']['use_ratio'])?json_encode($result['result']['use_ratio']):100;
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

        $json_info = json_encode($variable);
        //获得手续费列表
        //确定过来的是全担保还是部分担保（FullPreAuthLoan全，PreAuthLoan部分）
        if(isset($_GET['type'])){
            switch ($_GET['type']){
                case 'FullPreAuthLoan':
                    parent::$_VArray['type'] = 1;
                    parent::$_VArray['title'] = '全担保借款';
                    $result = $this->_api->getApiArrays('FullPreAuthLoan_Loan','ChargeMap','',array('json'=>$json_info));
                    break;
                case 'PreAuthLoan':
                    parent::$_VArray['type'] = 2;
                    parent::$_VArray['title'] = '担保借款';
                    $result = $this->_api->getApiArrays('PreAuthLoan_Loan','ChargeMap','',array('json'=>$json_info));
                    break;
                default:
                    $this->error('重要参数错误！');
                    break;
            }
        }else{
            $this->error('缺少重要参数！');
        }

        if(isset($result) && $result['code']==1000){
            //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
            //担保比例（有可能不同步，需要重新返首页获取用心最新信息）

            $result['result']['rule']['ensure_rate'] = bcmul($result['result']['rule']['ensure_rate'],100,0) ;
            parent::$_VArray['rule'] = $result['result']['rule'];
            //当授信金额为0的时候，map为空值
            if(!isset($result['result']['map'])){
                $this->error("授信金额为0");
                die;
            }
            //费率规则
            parent::$_VArray['map'] = json_encode($result['result']['map']);
            //循环控制缴费变量(费用)
            if(isset($result['result']['map'])&&count($result['result']['map'])>0){
                $oneResult = current($result['result']['map']);
                $adminCostStr = '<span class="x-mt poundage"><em>'.$oneResult['total'][0]['amount'].'</em>'.$oneResult['total'][0]['unit'].'</span><label>'.$oneResult['total'][0]['name'].'</label><br><br>';
                if(isset($oneResult['item'])&&!empty($oneResult['item'])){
                    foreach ($oneResult['item'] as $key=>$val){
                        $adminCostStr .= '<p class="cost_'.$key.'">&nbsp;<span class="x-mt"><em>'.$val['amount'].'</em>'.$val['unit'].'</span><label>'.$val['name'].'</label></p>';
                    }
                }
            }else{
                $adminCostStr = null;
            }
            parent::$_VArray['adminCostStr'] = $adminCostStr;
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
        parent::$_VArray['action'] = empty($this->_action)?null:$this->_action;


        parent::$_VArray['requestUrl'] = "/wx/Functions/borrowinfo";
        parent::$_VArray['requestBairong'] = "/wx/Functions/BaiRongCredit";
        parent::$_VArray['signPackage'] = $this->signPackage();
//        parent::$_VArray['poor'] = bcsub(100,$result['result']['rule']['ensure_rate'],0);
//        parent::$_VArray['title']=Kohana::$config->load('url.title.borrowmoney');
        $view = View::factory($this->_vv.'Borrowmoney/borrow');
        $view->_VArray =  parent::$_VArray;
		$this->response->body($view);
    }

    /*******************************************************
     *   极速贷
     *******************************************************/
    public function action_extremeBorrow(){
        //用Gv::$_userInfo['user_id']来判断是否登录了
        //登录状态
        //获取work_info信息(wx库)
//        parent::$_VArray['contact'] = self::$arr_step['contact'];
//        parent::$_VArray['has_fastloan_order'] = self::$arr_step['has_fastloan_order'];
        parent::$_VArray['signPackage'] = $this->signPackage();
        //判断当前的订单状态   如果是没有完成的状态  把之前的信息读取 输出
        parent::$_VArray['poundageinfo'] = null;
        $variable = array(
            "app"=>$this->getWxInfo()
        );
        $json_info = json_encode($variable);
        //修改,里面有优惠券和余额信息
        $result = $this->_api->getApiArrays('Preferential','Available','',array('json'=>$json_info));
        if(isset($result) && $result['code']==1000){
            //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
            if(isset($result['result']['coupon'])&&count($result['result']['coupon'])>0){
                parent::$_VArray['couponlist'] = array('couponlist'=>$result['result']['coupon'],'count'=>count($result['result']['coupon']));
            }else{
                parent::$_VArray['couponlist'] = array('couponlist'=>"",'count'=>0);
            }
            //余额
            parent::$_VArray['coin'] = isset($result['result']['coin'])?$result['result']['coin']:"0.00";
            //余额比例
            parent::$_VArray['use_ratio'] = isset($result['result']['use_ratio'])?json_encode($result['result']['use_ratio']):100;
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
        //税率表
        $result = $this->_api->getApiArrays('FastLoan_Loan','ChargeMap','',array('json'=>$json_info));
        if(isset($result) && $result['code']==1000){
            //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
            //担保比例（有可能不同步，需要重新返首页获取用心最新信息）
            $result['result']['rule']['ensure_rate'] = bcmul(Gv::$_userInfo['ensure_rate'],100,0) ;
            parent::$_VArray['rule'] = $result['result']['rule'];

            //循环控制缴费变量
            if(isset($result['result']['map'])&&count($result['result']['map'])>0){
                $oneResult = current($result['result']['map']);
                $adminCostStr = '<span class="x-mt poundage"><em>'.$oneResult['total'][0]['amount'].'</em>'.$oneResult['total'][0]['unit'].'</span><label>'.$oneResult['total'][0]['name'].'</label><br><br>';
                if(isset($oneResult['item'])&&!empty($oneResult['item'])){
                    foreach ($oneResult['item'] as $key=>$val){
                        $adminCostStr .= '<p class="cost_'.$key.'">&nbsp;<span class="x-mt"><em>'.$val['amount'].'</em>'.$val['unit'].'</span><label>'.$val['name'].'</label></p>';
                    }
                }
            }else{
                $adminCostStr = null;
            }
            //当授信金额为0的时候，map为空值
            if(!isset($result['result']['map'])){
                $this->error("获取极速贷数据出错!");
                die;
            }
            parent::$_VArray['map'] = json_encode($result['result']['map']);
            parent::$_VArray['adminCostStr'] = $adminCostStr;
            parent::$_VArray['amount'] = $result['result']['amount'];
            parent::$_VArray['day'] = $result['result']['day'];

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

        parent::$_VArray['poor'] = bcsub(100,$result['result']['rule']['ensure_rate'],0);
        //获取json
        unset($variable['user_id']);
        $json_info = json_encode($variable);
        //当日借款统计（极速贷）
        $result = $this->_api->getApiArrays('FastLoan_Loan','Status','',array('json'=>$json_info));
        if(isset($result) && $result['code']==1000){
            //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
            //担保比例（有可能不同步，需要重新返首页获取用心最新信息）
            parent::$_VArray['faststatus'] = empty($result['result'])?"":$result['result'];

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
        parent::$_VArray['type'] = 3;
        parent::$_VArray['action'] = empty($this->_action)?null:$this->_action;
        parent::$_VArray['title']=Kohana::$config->load('url.title.borrowmoney');
        parent::$_VArray['requestUrl'] = "/wx/Functions/borrowinfo";
        parent::$_VArray['requestBairong'] = "/wx/Functions/BaiRongCredit";
//        Tool::factory('Debug')->D(parent::$_VArray);
        $view = View::factory($this->_vv.'Borrowmoney/extremeborrow');
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);

    }


}