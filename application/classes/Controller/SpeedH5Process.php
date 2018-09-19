<?php 
header("Content-type: text/html; charset=utf-8"); 
defined('SYSPATH') or die('No direct script access.');
/*
 * app跳转H5极速贷借款流程
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
class Controller_SpeedH5Process extends Home{
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
        if (in_array(Gv::$status, array(3, 4, 5))) {
            $this->error(Kohana::message('wx', 'not_conform'));
            die;
        }
        //做一些放跳过来的授信限制
//        if (!in_array($this->_action, array('bankinfo', 'index', 'borrow', 'extremeBorrow'))) {
//            if (in_array(Wxgv::$userinfo['credited'], array(11, 12, 13, 14, 16, 17))) {
//                $this->error(Kohana::message('wx', 'not_conform'));
//                die;
//            }
//        }
    }
    //确认订单
    public function action_check()
    {
        //在修改状态前 判断一下该有的数据 是否有
        $status_order = $this->_model['order']->get_fieldstatus('bankcard_id,bankcard_no,creditcard_id,creditcard_card,loan_amount,payment_amount,charge,day,name,mobile,charge_management,coupon_amount,ensure_amount,type,ensure_rate',Gv::$user_id);
        //获得用户授信情况
//        $user_info = Model::factory('User')->get_userinfo_arr('credited',array("user_id"=>Gv::$user_id));
        if (empty($status_order['bankcard_id'])) {
            $this->error('缺少银行卡信息');
            die;
        }
        //紧急联系人情况
        //极速贷
        if(isset($status_order['type'])&&$status_order['type'] == 3){
            $view = View::factory($this->_vv.'Borrowmoney/checkextremeH5');
            //获取work_info信息(wx库)
            $contact = $this->_user->get_user_step_info("contact",array('user_id'=>Gv::$user_id))['contact'];
            if($contact != 2){
                $this->error('未添加紧急联系人,请去app上添加!');
                die;
            }
            $variable = array(
                "app"=>$this->getappapp($this->_app_session['token'])
            );
            $json_info = json_encode($variable);
            //当日借款统计(极速贷)
            $result = $this->_api->getApiArrays('Order','FastStatus','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
                //担保比例（有可能不同步，需要重新返首页获取用心最新信息）
                $nowtime = time();
                //不能进行极速贷请求
                if($result['result']['today_max']<=$result['result']['today_total']||$result['result']['today_end']<=$nowtime||$result['result']['today_start']>=$nowtime||$result['result']['on']!=1){
                    if($result['result']['today_start']<$nowtime &&$result['result']['today_max']<=$result['result']['today_total']&&$result['result']['today_end']>$nowtime){
                        $view->prompt = '抱歉，今日极速贷已抢完，明日'.date("H:s",$result['result']['today_start']).'开放抢单';
                    }elseif ($result['result']['on']!=1){
                        $view->prompt = '极速贷未开放';
                    }elseif ($result['result']['today_start']>$nowtime){
                        $view->prompt = '开放抢单时间为每日'.date("H:s",$result['result']['today_start']).'，等下再来吧~';
                    }elseif($result['result']['today_end']<$nowtime){
                        $view->prompt = '抢单时间已过,请明天再来吧~';
                    }else {
                        $view->prompt = '极速贷未开放';
                    }
                    $view->startExtreme = false;
                }else{
                    $view->startExtreme = true;
                }
                $view->faststatus = $result['result'];
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
            $this->error('订单类型错误!');
            die;
        }
        if(!empty($status_order)){
            $status_order['loan_amount'] = $this->MoneyStrStr($status_order['loan_amount']);
            $status_order['payment_amount'] = $this->MoneyStrStr($status_order['payment_amount']);
            $status_order['charge'] = $this->MoneyStrStr($status_order['charge']);
            $status_order['charge_management'] = $this->MoneyStrStr($status_order['charge_management']);
            $status_order['coupon_amount'] = $this->MoneyStrStr($status_order['coupon_amount']);
            $status_order['ensure_amount'] = $this->MoneyStrStr($status_order['ensure_amount']);
            $status_order['ensure_rate'] = $this->MoneyStrStr($status_order['ensure_rate']);
            if($status_order['coupon_amount']!=0){
                $status_order['coupon_amount'] = '-'.$status_order['coupon_amount'];
            }
        }

        //获得利息信息
        $variable = array(
            'type'=>$status_order['type'],
            "app"=>$this->getappapp($this->_app_session['token'])
        );
        $json_info = json_encode($variable);
        $RateSummary = $this->_api->getApiArrays('Order','RateSummary','',array('json'=>$json_info));
        if(isset($RateSummary) && $RateSummary['code']==1000){
            $view->rateSummary = $RateSummary['result']['order_rate_html'];
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

        //查询当前用户的订单信息
        $view->personal = $status_order;
        $view->title = Kohana::$config->load('url.title.check');
        $view->name = $this->_app_session['name'];
        $view->mobile = $this->_app_session['mobile'];;
        $this->response->body($view);
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

    //极速贷
    public function action_extremeBorrow(){
        //用Wxgv::$userinfo['user_id']来判断是否登录了
        if(Gv::$user_id == NULL){
            $this->error('用户未登录!');
            die;
        }
        //登录状态
        $view = View::factory($this->_vv.'Borrowmoney/extremeborrowH5');
        //获取work_info信息(wx库)
        $view->contact = $this->_user->get_user_step_info("contact",array('user_id'=>Gv::$user_id))['contact'];
        //判断当前的订单状态   如果是没有完成的状态  把之前的信息读取 输出
        $view->poundageinfo = null;
        if(Gv::$type != 2){
            $this->error('该渠道暂时不开发');
            die;
        }
        $variable = array(
            "user_id"=>Gv::$user_id,
            "app"=>$this->getappapp($this->_app_session['token'])
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('Coupon','Available','',array('json'=>$json_info));
        if(isset($result) && $result['code']==1000){
            //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
            if(count($result['result'])>0){
                $view->couponlist = array('couponlist'=>$result['result']['coupon'],'count'=>count($result['result']['coupon']));
            }else{
                $view->couponlist = array('couponlist'=>"",'count'=>0);
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
        $result = $this->_api->getApiArrays('ChargeMap','Fast','',array('json'=>$json_info));
        if(isset($result) && $result['code']==1000){
            //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
            //担保比例（有可能不同步，需要重新返首页获取用心最新信息）
           // $result['result']['rule']['ensure_rate'] = bcmul(Wxgv::$userinfo['ensure_rate'],100,0) ;
            $view->rule = $result['result']['rule'];
            //当授信金额为0的时候，map为空值
            if(!isset($result['result']['map'])){
                $this->error("获取极速贷数据出错!");
                die;
            }
            $view->map = json_encode($result['result']['map']);
            $view->amount = $result['result']['amount'];
            $view->day = $result['result']['day'];

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
        //$view->poor = bcsub(100,$result['result']['rule']['ensure_rate'],0);
        //获取json
        unset($variable['user_id']);
        $json_info = json_encode($variable);
        //当日借款统计
        $result = $this->_api->getApiArrays('Order','FastStatus','',array('json'=>$json_info));
        if(isset($result) && $result['code']==1000){
            //修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
            //担保比例（有可能不同步，需要重新返首页获取用心最新信息）
            $view->faststatus = empty($result['result'])?"":$result['result'];
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
//        //标记返回页面
//        if(isset($_GET['jump'])&&$_GET['jump']=='guaranteeadd'){
//            $view->jump = '/Borrowmoney/guaranteeadd?';
//        }else{
//            $view->jump = false;
//        }
        $view->action = empty($this->_action)?null:$this->_action;
        $view->title=Kohana::$config->load('url.title.borrowmoney');
        $this->response->body($view);

    }

    //注册紧急联系人(单独限制)(极速贷进来)
    public function action_ContactsExtreme(){
        if(self::$arr_step['contact']==2){
            $this->redirect('/SpeedH5Process/extremeBorrow?jump=no');
            die;
        }
        $view = View::factory($this->_vv.'Register/contacts');
        $view->url = "/SpeedH5Process/extremeBorrow";
        $view->title = Kohana::$config->load("url.title.login_contacts");
        $view->showtitle = true;
        $this->response->body($view);
    }
    
}