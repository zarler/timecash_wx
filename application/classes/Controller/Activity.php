<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 活动页面
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_Activity extends Home
{
    protected $_activity = null;
    protected $_signPackage = null;
    //构造方法  如果已登录  直接跳转到用户页面
    public function before()
    {
        parent::before();
        $this->_activity = Model::factory('Activity');
        $this->_signPackage = $this->signPackage();
    }
    //二期
    //发送模板到注册页面
    public function action_Turntable2()
    {
        $view = View::factory('Activity/turntable2');
        if(Valid::not_empty(Gv::$user_id)){
            $info = $this->_activity->get_activity_info(2,Gv::$user_id);
            if(!Valid::not_empty($info)){
                //创建用户信息
                $inter_arr = array(
                    'user_id'=>Gv::$user_id,
                    'time'=>0,
                    'create_time'=>time()
                );
                $insert_id = $this->_activity->insert_user_info($inter_arr,2);
                if($insert_id){
                    $count = 0;
                }else{
                    echo "<script>alert('数据出错！')</script>";
                    die;
                }
            }else{
                $count =  $info['time'];
            }
            $view->count = $count;
            //注册过
            $view->register = 1;
        }else{
            //未注册
            $view->register = 0;
        }
        $view->type = isset(Gv::$type)?Gv::$type:1;
        if($view->type == 1){
            $view->signPackage = $this->_signPackage;
        }
        $view->title = Kohana::$config->load('url.title.login');
        $this->response->body($view);
    }
    //抽奖
    //二期
    public function action_Lottery2(){

        if(!isset(Gv::$user_id) or !Valid::not_empty(Gv::$user_id)){
            echo json_encode(array('status'=>false,'msg'=>'未登录~！'));
            die;
        }
        $info = $this->_activity->get_activity_info(2,Gv::$user_id);
        if(empty($info)){
            //创建用户信息
            $inter_arr = array(
                'user_id'=>Gv::$user_id,
                'time'=>0,
                'create_time'=>time()
            );
            $insert_id = $this->_activity->get_activity_info($inter_arr,2);
            if($insert_id){
                $count = 0;
            }else{
                echo json_encode(array('status'=>false,'msg'=>'数据出错！'));
                die;
            }
        }else{
            $count =  $info['time'];
        }
        if($count<=2){
            switch($count){
                //随便转
                case 0:
                    $prize_arr = array(
                        '0' => array('id'=>1,'tem_id'=>1,'min'=>1,'max'=>89,'msg'=>'￥50减息券','prize'=>50,'v'=>30),
                        '1' => array('id'=>2,'tem_id'=>0,'min'=>90,'max'=>179,'msg'=>'再转一次','prize'=>0,'v'=>10),
                        '2' => array('id'=>3,'tem_id'=>3,'min'=>180,'max'=>269,'msg'=>'￥20减息券','prize'=>20,'v'=>50),
                        '3' => array('id'=>4,'tem_id'=>4,'min'=>270,'max'=>360,'msg'=>'￥10减息券','prize'=>10,'v'=>10),
                    );
                    foreach ($prize_arr as $key => $val) {
                        $arr[$val['id']] = $val['v'];
                    }
                    $rid = $this->getRand($arr); //根据概率获取奖项id
                    $res = $prize_arr[$rid-1]; //中奖项
                    $min = $res['min'];
                    $max = $res['max'];
                    $result['angle'] = mt_rand($min,$max); //随机生成一个角度
                    $result['status'] = true;
                    $result['msg'] = $res['msg'];
                    $result['prize'] = $res['prize'];
                    $result['id'] = $rid-1;
                    //抽中
                    if($res['tem_id']){
                        $this->AddCoupon($res['tem_id']);
                    }
                    break;
                case 1:
                    if($info['template_id']){
                        $prize_arr = array(
                            '0' => array('id'=>1,'tem_id'=>1,'min'=>1,'max'=>89,'msg'=>'￥50减息券','prize'=>50,'v'=>0),
                            '1' => array('id'=>2,'tem_id'=>0,'min'=>90,'max'=>179,'msg'=>'再转一次','prize'=>0,'v'=>1),
                            '2' => array('id'=>3,'tem_id'=>3,'min'=>180,'max'=>269,'msg'=>'￥20减息券','prize'=>20,'v'=>0),
                            '3' => array('id'=>4,'tem_id'=>4,'min'=>270,'max'=>360,'msg'=>'￥10减息券','prize'=>10,'v'=>0),
                        );
                        $rid = 2;
                    }else{
                        $prize_arr = array(
                            '0' => array('id'=>1,'tem_id'=>1,'min'=>1,'max'=>89,'msg'=>'￥50减息券','prize'=>50,'v'=>30),
                            '1' => array('id'=>2,'tem_id'=>0,'min'=>90,'max'=>179,'msg'=>'再转一次','prize'=>0,'v'=>10),
                            '2' => array('id'=>3,'tem_id'=>3,'min'=>180,'max'=>269,'msg'=>'￥20减息券','prize'=>20,'v'=>50),
                            '3' => array('id'=>4,'tem_id'=>4,'min'=>270,'max'=>360,'msg'=>'￥10减息券','prize'=>10,'v'=>10),
                        );
                        foreach ($prize_arr as $key => $val) {
                            $arr[$val['id']] = $val['v'];
                        }
                        $rid = $this->getRand($arr); //根据概率获取奖项id
                    }

                    $res = $prize_arr[$rid-1]; //中奖项

                    $min = $res['min'];
                    $max = $res['max'];
                    $result['angle'] = mt_rand($min,$max); //随机生成一个角度
                    $result['status'] = true;
                    $result['msg'] = $res['msg'];
                    $result['prize'] = $res['prize'];
                    $result['id'] = $rid-1;
                    //抽中
                    if($res['tem_id']){
                        $this->AddCoupon($res['tem_id']);
                    }
                    break;
                case 2:
                    if($info['template_id']){
                        $prize_arr = array(
                            '0' => array('id'=>1,'tem_id'=>1,'min'=>1,'max'=>89,'msg'=>'￥50减息券','prize'=>50,'v'=>0),
                            '1' => array('id'=>2,'tem_id'=>0,'min'=>90,'max'=>179,'msg'=>'再转一次','prize'=>0,'v'=>1),
                            '2' => array('id'=>3,'tem_id'=>3,'min'=>180,'max'=>269,'msg'=>'￥20减息券','prize'=>20,'v'=>0),
                            '3' => array('id'=>4,'tem_id'=>4,'min'=>270,'max'=>360,'msg'=>'￥10减息券','prize'=>10,'v'=>0),
                        );
                        $rid = 2; //根据概率获取奖项id
                    }else{
                        $prize_arr = array(
                            '0' => array('id'=>1,'tem_id'=>1,'min'=>1,'max'=>89,'msg'=>'￥50减息券','prize'=>50,'v'=>30),
                            '1' => array('id'=>2,'tem_id'=>0,'min'=>90,'max'=>179,'msg'=>'再转一次','prize'=>0,'v'=>10),
                            '2' => array('id'=>3,'tem_id'=>3,'min'=>180,'max'=>269,'msg'=>'￥20减息券','prize'=>20,'v'=>50),
                            '3' => array('id'=>4,'tem_id'=>4,'min'=>270,'max'=>360,'msg'=>'￥10减息券','prize'=>10,'v'=>10),
                        );
                        foreach ($prize_arr as $key => $val) {
                            $arr[$val['id']] = $val['v'];
                        }
                        $rid = $this->getRand($arr); //根据概率获取奖项id
                        //三次还是转到再来一次
                        if($rid==2){
                            $rid = 4;
                        }
                    }
                    $res = $prize_arr[$rid-1]; //中奖项
                    $min = $res['min'];
                    $max = $res['max'];
                    $result['angle'] = mt_rand($min,$max); //随机生成一个角度
                    $result['status'] = true;
                    $result['msg'] = $res['msg'];
                    $result['prize'] = $res['prize'];
                    $result['id'] = $rid-1;
                    //抽中
                    if($res['tem_id']){
                        $this->AddCoupon($res['tem_id']);
                    }else{
                        $result['msg'] = '抽奖结束';
                    }
                    break;
                default:
                    break;
            }
            $this->_activity->update_time_1(2,Gv::$user_id);
            //数据库加1
            echo json_encode($result);
        }else{
            echo json_encode(array('status'=>false,'msg'=>'您的3次机会已用完，下次活动再来吧~'));
        }
    }
    //获取随机奖项id
    function getRand($proArr) {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
        return $result;
    }
    //添加优惠券
    protected  function AddCoupon($template_id){
        if(Gv::$type == 2){
            $app = $this->getappapp(Gv::$app_token);
        }elseif(Gv::$type == 1){
            $app = $this->getapp();
        }else{
            //验证失败
            exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','validation_failure'))));
        }
        $variable = array(
            "user_id"=>Gv::$user_id,
            "template_id"=>$template_id,
            "app"=>$app
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('Coupon','Add','',array('json'=>$json_info));
        if(isset($result) && $result['code']==1000){
            //添加优惠钱id
            $this->_activity->update_info_field(array('template_id'=>$template_id),Gv::$user_id,2);
            //exit(json_encode(array('status' =>true,'msg'=>$result['message'])));
        }else{
            if(isset($result['code'])){
                exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
            }else{
                //系统繁忙，请联系客服！
                exit(json_encdode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
            }
        }
    }

    //大嘴唇活动
    public function action_ReceiveCoupon(){
        $view = View::factory('Activity/receivecoupon');
        if(!isset(Gv::$user_id) || !Valid::not_empty(Gv::$user_id)){
            $view->Login = false;
        }else{
            $view->Login = true;
        }
        $view->type = isset(Gv::$type)?Gv::$type:1;
        if($view->type == 1){
            $view->signPackage = $this->_signPackage;
        }
        $wx = $this->wxconfig();
        $view->title = Kohana::$config->load('url.title.login');
        $this->response->body($view);
    }

    //分享活动
    public function action_shareInvitation(){
        $view = View::factory('Activity/shareInvitation');
        if(!isset(Gv::$user_id) || !Valid::not_empty(Gv::$user_id)){
            $view->Login = false;
        }else{
            $view->Login = true;
        }
        $view->type = isset(Gv::$type)?Gv::$type:1;
        if($view->type == 1){
            $view->signPackage = $this->signPackage;
        }
        $user_id = isset($_GET['user_id'])?$_GET['user_id']:null;
        if(empty($user_id)){
            $activity_userid = $this->session->sessionGet('activity_userid');
            $user_id = empty($activity_userid)?null:$activity_userid;
        }
        //通过user_id来获取openid
        if(!empty($user_id)){
            $openid = $this->user->get_userinfo_arr('openid',array('user_id'=>$user_id))['openid'];
        }else{
            $openid = null;
        }
        //浏览统计
        $this->browseStatistics(1,'look','else',$view);
        $view->imgUrl = $this->wxconfig()->img2weima($user_id);
        if(empty($view->imgUrl)){
            $view->imgUrl = "/static/images/activity/share/icon–4.png";
        }
        //判断是否是微信
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            $view->is_weixin =  true;
            $view->signPackage = $this->_signPackage;
            $view->sharetitle = "给你推荐一款极速借款神器!";
            $view->text = "快金-极速贷，0担保，3秒审核，1分钟放款，还不快来！";
            $view->img_url = Kohana::$config->load('url.communic_url.timecash_m')."static/images/activity/extension_1/512x.png";
            $view->url = Kohana::$config->load('url.communic_url.timecash_m')."Activity/shareInvitation?user_id=".$user_id;
        }else{
            $view->is_weixin =  false;
        }
        $view->title = '关注快金';
        $this->response->body($view);
    }

    //分享入口页面
    public function action_inviteFriend(){


        if(isset($_POST)&&!empty($_POST)){
            $_GET['d'] = isset($_POST['uniqueid'])?$_POST['uniqueid']:null;
            //点击统计
            $this->browseStatistics($_POST['activity_id'],'click',$_POST['reg_app']);
            exit(json_encode(array('status' =>true)));
        }
        $view = View::factory($this->_vv.'Activity/InviteFriend');
        //判断是否是微信
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            $view->is_weixin =  true;
            $view->signPackage = $this->signPackage;
        }else{
            $view->is_weixin =  false;
        }
        //判断是Android还是ios
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
                $view->client = "else";
            }else{
                $view->client = "ios";
            }
            //$view->url = 'http://mp.weixin.qq.com/mp/redirect?url='.urlencode('https://itunes.apple.com/cn/app/kuai-jin/id1130326523?mt=8');
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
                $view->client = "else";
            }else{
                $view->client = "android";
            }
        }else{
            $view->client = "else";
        }
        //浏览统计
        $this->browseStatistics(1,'look',$view->client,$view);
        //判断用户是否登录
        if(!isset(Gv::$user_id) or !Valid::not_empty(Gv::$user_id)){
            $view->login = false;
        }else{
            $view->login = true;
            //获取活动主题、内容、图片地址、活动链接等
            $view->sharetitle = "给你推荐一款极速借款神器!";
            $view->text = "快金-极速贷，0担保，3秒审核，1分钟放款，还不快来！";
            $view->img_url = Kohana::$config->load('url.communic_url.timecash_m')."static/images/activity/extension_1/512x.png";
            $view->url = Kohana::$config->load('url.communic_url.timecash_m')."Activity/shareInvitation?user_id=".Gv::$user_id;
        }
        $view->title = "邀请好友送提额";
        $this->response->body($view);
    }

    //浏览量统计
    protected  function browseStatistics($activity_id=null,$event=null,$client='else',$view=null){
        //exit(json_encode(array('status' =>false,'msg'=>$this->request->method())));
        if(empty($activity_id)||empty($event)){
            return false;
        }
        if(isset(Gv::$type)&&Gv::$type==1){
            $unique = $this->_session->sessionGet('wx')['openid'];
            $unique = empty($unique)?null:$unique;
        }else{
            $unique = (isset($_GET['d'])&&!empty($_GET['d']))?$_GET['d']:null;
        }
        $browseTotal = array(
            'user_id'=>(isset(Gv::$user_id)&&!empty(Gv::$user_id))?Gv::$user_id:0,
            'pagetype'=>'/'.$this->_controller.'/'.$this->_action,
            'uniqueid'=>$unique,
            'reg_app'=>($client=='else')?'wechat':$client,
            'event'=>$event,
            'create_time'=>time(),
            'activity_id'=>$activity_id
        );
        //exit(json_encode(array('status' =>false,'msg'=>json_encode($browseTotal))));
        if(!empty($view)){
            $view->browseTotal = $browseTotal;
        }
        if(empty($unique)&&empty(Gv::$user_id)){
            return false;
        }else{
            $info = $this->_activity->get_browse_info(array('pagetype'=>$browseTotal['pagetype'],'activity_id'=>$activity_id,'event'=>$event),array('user_id'=>Gv::$user_id,'uniqueid'=>$unique,));

            //存在更改,没有插入
            if(empty($info)){
                $this->_activity->insert_browse_info($browseTotal);
            }
        }
    }

    //一周年庆祝
    public function action_festival(){
        $view = View::factory($this->_vv.'Activity/Festival');
        $this->response->body($view);
    }
    //授信活动
    public function action_creditAc(){
//        parent::ip_limit();
//        echo '<a href="javascript:location.href=location.href">刷新当前页</a> ';
//        echo '<a href="/?jump=no">跳出</a> ';
//        Tool::factory('Debug')->D($_SERVER);
        //切除app版本号
        //判断是Android还是ios

        //版本2.2.0  判断
        if(isset($_SERVER['HTTP_APP_VERSION'])&&strstr($_SERVER['HTTP_APP_VERSION'],"2.2.0")){
            //新
            $version = true;
        }else{
            //旧
            $version = false;
        }
        $view = View::factory($this->_vv.'Activity/CreditAc');
        if(!isset(Gv::$user_id) || !Valid::not_empty(Gv::$user_id)){
            $view->Login = false;
            //去登录
            if($version){
//                $view->url = 'javascript:noLogin(\'/Login?jump=no\',\'尚未登录,请前往个人中心登录后参与活动!\');showmsgMobileRem()';
                $view->url = '/Login?jump=BannerUserLogin';
            }else{
                $view->url = 'javascript:noLogin(\'/Login?jump=no\',\'尚未登录,请前往个人中心登录后参与活动!\');showmsgMobileRem()';
            }
        }else{
            //基础授信判断
            if (Gv::$type == 1) {
                $credit = (isset(Gv::$credited) && !empty(Gv::$credited)) ? Gv::$credited : false;
                if(in_array($credit, Model_Home::BASIC_CREDIT_FINISH)) {
                    $view->url = 'javascript:clickOk(\'您已完成基础授信\');changeShowRem();';
                }else {
                    $view->url = 'javascript:commonUtil.showmsgMobileRem(\'请先下载APP完成基础授信\',\'下载APP\',\'/Promotion\');showmsgMobileRem()';
                }
            } elseif (Gv::$type == 2) {
                $credit = (isset($this->_app_session['credit_auth']) && !empty($this->_app_session['credit_auth'])) ? $this->_app_session['credit_auth'] : false;
                if (!in_array($credit, Model_Home::BASIC_CREDIT_FINISH)) {
                    //去授信
                    if($version){
                        $view->url = '/Login?jump=BannerCreditManage';
                    }else{
                        $view->url = 'javascript:noLogin(\'/Login?jump=no\',\'请前往个人中心-授信管理完成基础授信,完成即送优惠券!\');showmsgMobileRem()';
                    }
                } else {
                    //去借钱
                    $view->url = 'javascript:clickOk(\'您已完成基础授信\');changeShowRem();';
                }
            }else {
                $this->error(Kohana::message('wx', 'validation_failure'));
                die;
            }
        }
        $view->type = Gv::$type;
        $this->response->body($view);
    }
    //愚人节活动
    public function action_FoolsDay(){
        //ip限制
//        parent::ip_limit();
        $view = View::factory($this->_vv.'Activity/FoolsDay');
        //时间限制 20170410 一天  1490976000 1491012000<1491062399
        $acStatus = Tool::factory('AcTool')->TimeLimit(1491012000,1491062399,'活动将于4月1日上午10点准时开始,敬请期待。','活动已结束');
        $arr_ac = json_decode($acStatus,true);
        //微信埋点
        //判断是否是微信
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            $this->_session->sessionSet('activity_11',1);
        }
        if($arr_ac['status']){
            if(empty(Gv::$user_id)) {//未登录
                $view->carousel = '<ul>
                                        <li><a href="#" target="_blank">130****5782用户 成功借款2000.00元</a></li>
                                        <li><a href="#" target="_blank">152****3125用户 成功借款2000.00元</a></li>
                                        <li><a href="#" target="_blank">136****7685用户 成功借款2000.00元</a></li>
                                       </ul>';
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
                $resultList = $this->_api->getApiArrays('AC_TCOA002','List','',array('json'=>$json_info));
                if(isset($resultList['code']) && $resultList['code']==1000){
                    if(isset($resultList['result'])&&is_array($resultList['result'])&&!empty($resultList['result'])){
                        $view->carousel = '<ul>';
                        foreach ($resultList['result'] as $value){
                            $view->carousel .= '<li><a href="#" target="_blank">'.$value['mobile'].'用户 成功借款'.$value['loan_amount'].'元</a></li>';
                        }
                        $view->carousel .= '</ul>';
                    }else{
                        $view->carousel = '<ul>
                                        <li><a href="#" target="_blank">130****5782用户 成功借款2000.00元</a></li>
                                        <li><a href="#" target="_blank">152****3125用户 成功借款2000.00元</a></li>
                                        <li><a href="#" target="_blank">136****7685用户 成功借款2000.00元</a></li>
                                       </ul>';
                    }
                }else{

                    if(isset($resultList['code'])){
                        $this->error($resultList['message']);
                        die;
                    }else{
                        //系统繁忙，请联系客服！
                        $this->error(Kohana::message('wx','system_busy'));
                        die;
                    }
                }
            }
            if(empty(Gv::$user_id)){//未登录
                $view->url = "javascript:commonUtil.showpublic('登录后才可以参加活动,赶快去个人中心登录吧!','确定','/Login?jump=no');commonUtil.revisecss();";
            }else{
                //查看授权情况
                if(!empty(self::$arr_step)){
                    //用faceid是否通过来判断基础授信情况
                    if(isset(self::$arr_step['faceid'])&&self::$arr_step['faceid']!=2){
                        //基础授信未过
                        if(Gv::$type == 1){
                            $view->url = "javascript:commonUtil.showpublic('您尚未完成基础授信,请下载APP完善资料。','下载APP','/Promotion');commonUtil.revisecss();";
                        }elseif(Gv::$type == 2){
                            $view->url = "javascript:commonUtil.showpublic('您尚未完成基础授信,请前往个人中心-授信管理完善资料。','确定','/Promotion?jump=no');commonUtil.revisecss();";
                        }else{
                            $this->error('获取信息失败!');
                        }
                    }elseif(isset(self::$arr_step['faceid'])&&self::$arr_step['faceid']==2){
                        //判断是否添加银行卡(只有app判断)
                        if(Gv::$type == 1){
                            //web直接走流程(借款埋点)
                            $view->url = "javascript:layer.load(2, {shade: false});location.href = '/Borrowmoney/extremeBorrow'";
                        }elseif(Gv::$type == 2){
                            //app判断是否有银行卡
                            $variable = array(
                                "app"=>$this->getappapp($this->_app_session['token'])
                            );
                            $json_info = json_encode($variable);
                            $resultBank = $this->_api->getApiArrays('BankCard','List','',array('json'=>$json_info));
                            if(isset($resultBank) && $resultBank['code']==1000){
                                if(count($resultBank['result']['bank_card_list'])>0){
                                    //由于Android广告页面不能连环跳H5页面,需要进行判断
                                    if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
                                        $view->url = "javascript:commonUtil.showpublic('壕贷2000元，立即前往极速贷借款！','确定','/?jump=yes');commonUtil.revisecss();";
                                    }else{
                                        $view->url = "javascript:layer.load(2, {shade: false});location.href = '/SpeedH5Process/extremeBorrow'";
                                    }
                                }else{
                                    //没有银行卡
                                    $view->url = "javascript:commonUtil.showpublic('您尚未添加银行卡,请前往个人中心-银行卡管理添加银行卡。','确定','/?jump=no');commonUtil.revisecss();";
                                }
                            }else{
                                if(isset($resultBank['code'])){
                                    if($resultBank['code'] == 2020){
                                        if(Gv::$type == 1){
                                            //快速登录
                                            $view->url = "javascript:commonUtil.showpublic('请授权登录后才可以参加活动,赶快去微信页面登录吧!','确定','/?jump=no');commonUtil.revisecss();";
                                        }elseif(Gv::$type == 2){
                                            $view->url = "javascript:commonUtil.showpublic('登录后才可以参加活动,赶快去个人中心登录吧!','确定','/?jump=no');commonUtil.revisecss();";
                                        }else{
                                            $this->error('获取信息失败!');
                                        }
                                    }else{
                                        $this->error($resultBank['message']);
                                        die;
                                    }
                                }else{
                                    //系统繁忙，请联系客服！
                                    $this->error(Kohana::message('wx','system_busy'));
                                    die;
                                }
                            }
                        }else{
                            $this->error('获取信息失败!');
                        }
                        //判断当前订单情况
                        if(Gv::$type == 1){
                            $app = $this->getapp();
                        }elseif(Gv::$type == 2){
                            $app = $this->getappapp($this->_app_session['token']);
                        }else{
                            $this->error('获取信息失败!');
                        }
                        $variable = array(
                            "user_id"=>Gv::$user_id,
                            "app"=>$app
                        );

                        $json_info = json_encode($variable);
                        $resultCurrent = $this->_api->getApiArrays('Order','Current','',array('json'=>$json_info));

                        if(isset($resultCurrent['code'])&&$resultCurrent['code']==1000){
                            if(isset($resultCurrent['result']['order']['status'])&&in_array($resultCurrent['result']['order']['status'],array(
                                    Model_Home::PAGE_TO_INIT,
                                    Model_Home::PAGE_TO_READY,
                                    Model_Home::PAGE_TO_PASS,
                                    Model_Home::PAGE_TO_PAY_IN,
                                    Model_Home::PAGE_TO_PAID,
                                    Model_Home::PAGE_TO_ACTREPAY_IN,
                                    Model_Home::PAGE_TO_ACTREPAY_FAIL,
                                    Model_Home::PAGE_TO_DEDUCT_SUCC,
                                    Model_Home::PAGE_TO_DEDUCT_FAIL,
                                    Model_Home::PAGE_TO_REPAY_IN,
                                    Model_Home::PAGE_TO_REPAY_FAIL,
                                    Model_Home::PAGE_TO_PAY_SUCC,
                                    Model_Home::PAGE_TO_PREAUTH_SUCC,
                                    Model_Home::PAGE_TO_PREAUTH_FAIL,
                                    Model_Home::PAGE_TO_PREAUTH_IN,
                                    Model_Home::PAGE_TO_OVERDUE_IN,
                                    Model_Home::PAGE_TO_OVERDUE_SUCC,
                                    Model_Home::PAGE_TO_OVERDUE_ACTREPAY_IN,
                                    Model_Home::PAGE_TO_OVERDUE_ACTREPAY_FAIL,
                                    Model_Home::PAGE_TO_OVERDUE_DEDUCT_SUCC,
                                    Model_Home::PAGE_TO_OVERDUE_DEDUCT_RUNNING
                                ))){
                                $view->url = "javascript:commonUtil.showpublic('您存在未完成订单,不能借款。','确定','/?jump=no');commonUtil.revisecss();";
                            }
                        }else{
                            if(isset($resultCurrent['code'])){
                                if($resultCurrent['code'] == 2020){
                                    if(Gv::$type == 1){
                                        //快速登录
                                        $view->url = "javascript:commonUtil.showpublic('请授权登录后才可以参加活动,赶快去微信页面登录吧!','确定','/?jump=no');commonUtil.revisecss();";
                                    }elseif(Gv::$type == 2){
                                        $view->url = "javascript:commonUtil.showpublic('登录后才可以参加活动,赶快去个人中心登录吧!','确定','/?jump=no');commonUtil.revisecss();";
                                    }else{
                                        $this->error('获取信息失败!');
                                    }
                                }else{
                                    $this->error($resultCurrent['message']);
                                    die;
                                }
                            }else{
                                //系统繁忙，请联系客服！
                                $this->error(Kohana::message('wx','system_busy'));
                                die;
                            }
                        }
                    }else{
                        $this->error('获取信息失败!');
                    }
                }else{
                    $this->error('获取信息失败!');
                }
            }
        }else{
            $view->url = "javascript:commonUtil.showmsg('{$arr_ac['msg']}');commonUtil.revisecss();";
            $view->carousel = "<div class='apple'><span>{$arr_ac['msg']}</span></div>";
        }


        $this->response->body($view);
    }
    //愚人节活动(线上测试)
    public function action_FoolsDayCeshi(){
        //ip限制
        parent::ip_limit();
        $view = View::factory($this->_vv.'Activity/FoolsDay');
        //时间限制 20170410 一天  1490976000 1491012000<1491062399
        $acStatus = Tool::factory('AcTool')->TimeLimit(1490666400,1491062399,'活动将于4月1日上午10点准时开始,敬请期待。','活动已结束');
        $arr_ac = json_decode($acStatus,true);
        //微信埋点
        //判断是否是微信
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            $this->_session->sessionSet('activity_11',1);
        }
        if($arr_ac['status']){
            if(empty(Gv::$user_id)) {//未登录
                $view->carousel = '<ul>
                                        <li><a href="#" target="_blank">130****5782用户 成功借款2000.00元</a></li>
                                        <li><a href="#" target="_blank">152****3125用户 成功借款2000.00元</a></li>
                                        <li><a href="#" target="_blank">136****7685用户 成功借款2000.00元</a></li>
                                       </ul>';
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
                $resultList = $this->_api->getApiArrays('AC_TCOA002','List','',array('json'=>$json_info));
                if(isset($resultList['code']) && $resultList['code']==1000){
                    if(isset($resultList['result'])&&is_array($resultList['result'])&&!empty($resultList['result'])){
                        $view->carousel = '<ul>';
                        foreach ($resultList['result'] as $value){
                            $view->carousel .= '<li><a href="#" target="_blank">'.$value['mobile'].'用户 成功借款'.$value['loan_amount'].'元</a></li>';
                        }
                        $view->carousel .= '</ul>';
                    }else{
                        $view->carousel = '<ul>
                                        <li><a href="#" target="_blank">130****5782用户 成功借款2000.00元</a></li>
                                        <li><a href="#" target="_blank">152****3125用户 成功借款2000.00元</a></li>
                                        <li><a href="#" target="_blank">136****7685用户 成功借款2000.00元</a></li>
                                       </ul>';
                    }
                }else{

                    if(isset($resultList['code'])){
                        $this->error($resultList['message']);
                        die;
                    }else{
                        //系统繁忙，请联系客服！
                        $this->error(Kohana::message('wx','system_busy'));
                        die;
                    }
                }
            }

            if(empty(Gv::$user_id)){//未登录
                $view->url = "javascript:commonUtil.showpublic('登录后才可以参加活动,赶快去个人中心登录吧!','确定','/Login?jump=no');commonUtil.revisecss();";
            }else{
                //查看授权情况
                if(!empty(self::$arr_step)){
                    //用faceid是否通过来判断基础授信情况
                    if(isset(self::$arr_step['faceid'])&&self::$arr_step['faceid']!=2){
                        //基础授信未过
                        if(Gv::$type == 1){
                            $view->url = "javascript:commonUtil.showpublic('您尚未完成基础授信,请下载APP完善资料。','下载APP','/Promotion');commonUtil.revisecss();";
                        }elseif(Gv::$type == 2){
                            $view->url = "javascript:commonUtil.showpublic('您尚未完成基础授信,请前往个人中心-授信管理完善资料。','确定','/Promotion?jump=no');commonUtil.revisecss();";
                        }else{
                            $this->error('获取信息失败!');
                        }
                    }elseif(isset(self::$arr_step['faceid'])&&self::$arr_step['faceid']==2){
                        //判断是否添加银行卡(只有app判断)
                        if(Gv::$type == 1){
                            //web直接走流程(借款埋点)
                            $view->url = "javascript:layer.load(2, {shade: false});location.href = '/Borrowmoney/extremeBorrow'";
                        }elseif(Gv::$type == 2){
                            //app判断是否有银行卡
                            $variable = array(
                                "app"=>$this->getappapp($this->_app_session['token'])
                            );
                            $json_info = json_encode($variable);
                            $resultBank = $this->_api->getApiArrays('BankCard','List','',array('json'=>$json_info));
                            if(isset($resultBank) && $resultBank['code']==1000){
                                if(count($resultBank['result']['bank_card_list'])>0){
                                    //由于Android广告页面不能连环跳H5页面,需要进行判断
                                    if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
                                        $view->url = "javascript:commonUtil.showpublic('壕贷2000元，立即前往极速贷借款！','确定','/?jump=yes');commonUtil.revisecss();";
                                    }else{
                                        $view->url = "javascript:layer.load(2, {shade: false});location.href = '/SpeedH5Process/extremeBorrow'";
                                    }
                                }else{
                                    //没有银行卡
                                    $view->url = "javascript:commonUtil.showpublic('您尚未添加银行卡,请前往个人中心-银行卡管理添加银行卡。','确定','/?jump=no');commonUtil.revisecss();";
                                }
                            }else{
                                if(isset($resultBank['code'])){
                                    if($resultBank['code'] == 2020){
                                        if(Gv::$type == 1){
                                            //快速登录
                                            $view->url = "javascript:commonUtil.showpublic('请授权登录后才可以参加活动,赶快去微信页面登录吧!','确定','/?jump=no');commonUtil.revisecss();";
                                        }elseif(Gv::$type == 2){
                                            $view->url = "javascript:commonUtil.showpublic('登录后才可以参加活动,赶快去个人中心登录吧!','确定','/?jump=no');commonUtil.revisecss();";
                                        }else{
                                            $this->error('获取信息失败!');
                                        }
                                    }else{
                                        $this->error($resultBank['message']);
                                        die;
                                    }
                                }else{
                                    //系统繁忙，请联系客服！
                                    $this->error(Kohana::message('wx','system_busy'));
                                    die;
                                }
                            }
                        }else{
                            $this->error('获取信息失败!');
                        }
                        //判断当前订单情况
                        if(Gv::$type == 1){
                            $app = $this->getapp();
                        }elseif(Gv::$type == 2){
                            $app = $this->getappapp($this->_app_session['token']);
                        }else{
                            $this->error('获取信息失败!');
                        }
                        $variable = array(
                            "user_id"=>Gv::$user_id,
                            "app"=>$app
                        );

                        $json_info = json_encode($variable);
                        $resultCurrent = $this->_api->getApiArrays('Order','Current','',array('json'=>$json_info));

                        if(isset($resultCurrent['code'])&&$resultCurrent['code']==1000){
                            if(isset($resultCurrent['result']['order']['status'])&&in_array($resultCurrent['result']['order']['status'],array(
                                    Model_Home::PAGE_TO_INIT,
                                    Model_Home::PAGE_TO_READY,
                                    Model_Home::PAGE_TO_PASS,
                                    Model_Home::PAGE_TO_PAY_IN,
                                    Model_Home::PAGE_TO_PAID,
                                    Model_Home::PAGE_TO_ACTREPAY_IN,
                                    Model_Home::PAGE_TO_ACTREPAY_FAIL,
                                    Model_Home::PAGE_TO_DEDUCT_SUCC,
                                    Model_Home::PAGE_TO_DEDUCT_FAIL,
                                    Model_Home::PAGE_TO_REPAY_IN,
                                    Model_Home::PAGE_TO_REPAY_FAIL,
                                    Model_Home::PAGE_TO_PAY_SUCC,
                                    Model_Home::PAGE_TO_PREAUTH_SUCC,
                                    Model_Home::PAGE_TO_PREAUTH_FAIL,
                                    Model_Home::PAGE_TO_PREAUTH_IN,
                                    Model_Home::PAGE_TO_OVERDUE_IN,
                                    Model_Home::PAGE_TO_OVERDUE_SUCC,
                                    Model_Home::PAGE_TO_OVERDUE_ACTREPAY_IN,
                                    Model_Home::PAGE_TO_OVERDUE_ACTREPAY_FAIL,
                                    Model_Home::PAGE_TO_OVERDUE_DEDUCT_SUCC,
                                    Model_Home::PAGE_TO_OVERDUE_DEDUCT_RUNNING
                                ))){
                                $view->url = "javascript:commonUtil.showpublic('您存在未完成订单,不能借款。','确定','/?jump=no');commonUtil.revisecss();";
                            }
                        }else{
                            if(isset($resultCurrent['code'])){
                                if($resultCurrent['code'] == 2020){
                                    if(Gv::$type == 1){
                                        //快速登录
                                        $view->url = "javascript:commonUtil.showpublic('登录后才可以参加活动,赶快去个人中心登录吧!','确定','/?jump=no');commonUtil.revisecss();";
                                    }elseif(Gv::$type == 2){
                                        $view->url = "javascript:commonUtil.showpublic('登录后才可以参加活动,赶快去个人中心登录吧!','确定','/?jump=no');commonUtil.revisecss();";
                                    }else{
                                        $this->error('获取信息失败!');
                                    }
                                }else{
                                    $this->error($resultCurrent['message']);
                                    die;
                                }
                            }else{
                                //系统繁忙，请联系客服！
                                $this->error(Kohana::message('wx','system_busy'));
                                die;
                            }
                        }
                    }else{
                        $this->error('获取信息失败!');
                    }
                }else{
                    $this->error('获取信息失败!');
                }
            }
        }else{
            $view->url = "javascript:commonUtil.showmsg('{$arr_ac['msg']}');commonUtil.revisecss();";
            $view->carousel = "<div class='apple'><span>{$arr_ac['msg']}</span></div>";
        }

        $this->response->body($view);
    }

    //母亲节活动
    public function action_MotherDay(){
        //ip限制
//        parent::ip_limit();
        $view = View::factory($this->_vv.'Activity/MotherDay');
        //时间限制 20170410 一天  1490976000 1491012000<1491062399
        $acStatus = Tool::factory('AcTool')->TimeLimit(1495072800,1495209540,'活动将于5月18日上午10点准时开始,敬请期待。','活动已结束');
//        $acStatus = Tool::factory('AcTool')->TimeLimit(1491072800,1495209540,'活动将于5月18日上午10点准时开始,敬请期待。','活动已结束');
        $arr_ac = json_decode($acStatus,true);
        //微信埋点
        //判断是否是微信
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            $this->_session->sessionSet('activity_11',1);
        }
        if($arr_ac['status']){
            if(empty(Gv::$user_id)) {//未登录
                $view->carousel = '<ul>
                                        <li><a href="#" target="_blank">130****5782用户 成功借款2000.00元</a></li>
                                        <li><a href="#" target="_blank">152****3125用户 成功借款2000.00元</a></li>
                                        <li><a href="#" target="_blank">136****7685用户 成功借款2000.00元</a></li>
                                       </ul>';
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
                $resultList = $this->_api->getApiArrays('AC_TCOA009','List','',array('json'=>$json_info));
                if(isset($resultList['code']) && $resultList['code']==1000){
                    if(isset($resultList['result'])&&is_array($resultList['result'])&&!empty($resultList['result'])){
                        $view->carousel = '<ul>';
                        foreach ($resultList['result'] as $value){
                            $view->carousel .= '<li><a href="#" target="_blank">'.$value['mobile'].'用户 成功借款'.$value['loan_amount'].'元</a></li>';
                        }
                        $view->carousel .= '</ul>';
                    }else{
                        $view->carousel = '<ul>
                                        <li><a href="#" target="_blank">130****5782用户 成功借款2000.00元</a></li>
                                        <li><a href="#" target="_blank">152****3125用户 成功借款2000.00元</a></li>
                                        <li><a href="#" target="_blank">136****7685用户 成功借款2000.00元</a></li>
                                       </ul>';
                    }
                }else{

                    if(isset($resultList['code'])){
                        $this->error($resultList['message']);
                        die;
                    }else{
                        //系统繁忙，请联系客服！
                        $this->error(Kohana::message('wx','system_busy'));
                        die;
                    }
                }
            }
            if(empty(Gv::$user_id)){//未登录
                $this->_session->sessionSet('activity','/'.$this->_controller.'/'.$this->_action);
                $view->url = "javascript:showTip('登录后才可以参加活动,赶快去个人中心登录吧!','/Login?jump=BannerUserLogin');changeCssPromptMsg();";
            }else{
                //查看授权情况
                if(Gv::$type==1){
                    $credit = (isset(Gv::$credited)&&!empty(Gv::$credited))?Gv::$credited:false;
                }elseif(Gv::$type==2){
                    $credit = (isset($this->_app_session['credit_auth'])&&!empty($this->_app_session['credit_auth']))?$this->_app_session['credit_auth']:false;
                }else{
                    $this->error(Kohana::message('wx','validation_failure'));
                    die;
                }
                if(!in_array($credit,Model_Home::BASIC_CREDIT_FINISH)){
                    //基础授信未过
                    if(Gv::$type == 1){
                        $view->url = "javascript:showTip('您尚未完成基础授信,请下载APP完善资料。','/Promotion');changeCssPromptMsg();";
                    }elseif(Gv::$type == 2){
                        $view->url = "javascript:showTip('您尚未完成基础授信,请前往个人中心-授信管理完善资料。','/Promotion?jump=no');changeCssPromptMsg();";
                    }else{
                        $this->error('获取信息失败!');
                    }
                }else{
                    //判断当前订单情况
                    if(Gv::$type == 1){
                        $app = $this->getapp();
                    }elseif(Gv::$type == 2){
                        $app = $this->getappapp($this->_app_session['token']);
                    }else{
                        $this->error('获取信息失败!');
                    }
                    $variable = array(
                        "user_id"=>Gv::$user_id,
                        "app"=>$app
                    );

                    $json_info = json_encode($variable);
                    $resultCurrent = $this->_api->getApiArrays('Order','Current','',array('json'=>$json_info));

                    if(isset($resultCurrent['code'])&&$resultCurrent['code']==1000){
                        if(isset($resultCurrent['result']['order']['status'])&&in_array($resultCurrent['result']['order']['status'],array(
                                Model_Home::PAGE_TO_INIT,
                                Model_Home::PAGE_TO_READY,
                                Model_Home::PAGE_TO_PASS,
                                Model_Home::PAGE_TO_PAY_IN,
                                Model_Home::PAGE_TO_PAID,
                                Model_Home::PAGE_TO_ACTREPAY_IN,
                                Model_Home::PAGE_TO_ACTREPAY_FAIL,
                                Model_Home::PAGE_TO_DEDUCT_SUCC,
                                Model_Home::PAGE_TO_DEDUCT_FAIL,
                                Model_Home::PAGE_TO_REPAY_IN,
                                Model_Home::PAGE_TO_REPAY_FAIL,
                                Model_Home::PAGE_TO_PAY_SUCC,
                                Model_Home::PAGE_TO_PREAUTH_SUCC,
                                Model_Home::PAGE_TO_PREAUTH_FAIL,
                                Model_Home::PAGE_TO_PREAUTH_IN,
                                Model_Home::PAGE_TO_OVERDUE_IN,
                                Model_Home::PAGE_TO_OVERDUE_SUCC,
                                Model_Home::PAGE_TO_OVERDUE_ACTREPAY_IN,
                                Model_Home::PAGE_TO_OVERDUE_ACTREPAY_FAIL,
                                Model_Home::PAGE_TO_OVERDUE_DEDUCT_SUCC,
                                Model_Home::PAGE_TO_OVERDUE_DEDUCT_RUNNING
                            ))){
                            $view->url = "javascript:layerMobile.showlayer('您存在未完成订单,不能借款。');layerMobile.changeCssMsg();";
                        }else{
                            $view->url = "javascript:statisticsBorrow();location.href = '/Borrowmoney/extremeBorrow?jump=BannerFastLoan'";
                        }
                    }else{
                        if(isset($resultCurrent['code'])){
                            if($resultCurrent['code'] == 2020){
                                if(Gv::$type == 1){
                                    //快速登录
                                    $view->url = "javascript:showTip('请授权登录后才可以参加活动,赶快去微信页面登录吧!','/Login?jump=no');changeCssPromptMsg();";
                                }elseif(Gv::$type == 2){
                                    $view->url = "javascript:showTip('登录后才可以参加活动,赶快去个人中心登录吧!','/?jump=no');changeCssPromptMsg();";
                                }else{
                                    $this->error('获取信息失败!');
                                }
                            }else{
                                $this->error($resultCurrent['message']);
                                die;
                            }
                        }else{
                            //系统繁忙，请联系客服！
                            $this->error(Kohana::message('wx','system_busy'));
                            die;
                        }
                    }
                }
            }
        }else{
            $view->url = "javascript:layerMobile.showlayer('{$arr_ac['msg']}');layerMobile.changeCssMsg();";
            $view->carousel = "<div class='apple'><span>{$arr_ac['msg']}</span></div>";
        }
        $this->response->body($view);
    }


    //428整点抢活动
    public function action_WholePointGo(){
        //ip限制
//        parent::ip_limit();
        //版本2.2.0  判断
        if(isset($_SERVER['HTTP_APP_VERSION'])&&strstr($_SERVER['HTTP_APP_VERSION'],"2.2.0")){
            //新
            $version = true;
        }else{
            //旧
            $version = false;
        }
        $view = View::factory($this->_vv.'Activity/WholePointGo');
        $view->type = Gv::$type;
        $view->sharetitle = "免单优惠来袭,我比你手快!猛戳~";
        $view->text = "428整点抢免单,早10点到晚9点惊喜抢不停！";
        $view->img_url = Kohana::$config->load('url.communic_url.timecash_m')."static/images/promotion/icon_logo.png";
        $view->url = Kohana::$config->load('url.communic_url.timecash_m')."Activity/WholePointGo?user_id=";
        //判断是否是微信
        if($view->type == 1){
            $view->signPackage = $this->_signPackage;
            $view->client = "else";
        }elseif($view->type == 2){
            //判断是Android还是ios
            if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
                 $view->client = "ios";
            }elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
                 $view->client = "android";
            }else{
                 $view->client = "else";
            }
        }else{
            //系统繁忙，请联系客服！
            $this->error('获取信息失败!');
            die;
        }
        $acStatus = Tool::factory('AcTool')->TimeLimit(1493344800,1493395140,'活动将于4月28日上午10点准时开始,敬请期待。','该活动已结束');
        $arr_ac = json_decode($acStatus,true);
        if($arr_ac['status']){
            //显示轮播控制
            $acStatus = Tool::factory('AcTool')->TimeLimit(1493355600,1493395140,'此阶段获奖名单将于13点公布，敬请期待。','该活动已结束');
            $arr_ac = json_decode($acStatus,true);
            if($arr_ac['status']){
                //获取轮播
                //获取获奖用户信息
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
                $resultList = $this->_api->getApiArrays('AC_TCOA006','List','',array('json'=>$json_info));
                if(isset($resultList['code'])&&$resultList['code']==1000){
                    if(isset($resultList['result'])&&Valid::not_empty($resultList['result'])){
                        if (isset($resultList['result']['list'])&&is_array($resultList['result']['list'])&&!empty($resultList['result']['list'])){
                            $view->lunbo = '<ul style="margin-top: 0px;">';
                            foreach ($resultList['result']['list'] as $key=>$val){
                                $view->lunbo .= '<li><a href="#" target="_blank">'.$val['mobile'].'&nbsp;借款'.$val['loan_amount'].'元&nbsp;'.$val['discount_amount'].'&nbsp;'.$resultList['result']['time_type'].'点幸运用户</a></li>';
                            }
                            $view->lunbo .= '</ul>';
                        }else{
                            $view->lunbo = '<a>此阶段获奖名单将于13点公布，敬请期待</a>';
                        }
                    }else{
                        $view->lunbo = '<a>此阶段获奖名单将于13点公布，敬请期待</a>';
                    }
                }else{
                    if(isset($resultList['code'])){
                        if($resultList['code'] == 2020){
                            if($version){
                                //                $view->url = 'javascript:noLogin(\'/Login?jump=no\',\'尚未登录,请前往个人中心登录后参与活动!\');showmsgMobileRem()';
                                $view->url_guarantee = $view->url_rapidly = '/Login/?jump=BannerUserLogin';
                            }else{
                                $view->url_guarantee = $view->url_rapidly = 'javascript:noLogin(\'/Login?jump=no\',\'尚未登录,请前往个人中心登录后参与活动!\');showmsgMobileRem()';
                            }
                        }else{
                            $this->error($resultList['message']);
                            die;
                        }
                    }else{
                        //系统繁忙，请联系客服！
                        $this->error(Kohana::message('wx','system_busy'));
                        die;
                    }
                }
            }else{
                //活动未开始或结束
                $view->lunbo = '<a>'.$arr_ac['msg'].'</a>';
            }

//        Tool::factory('Debug')->D(array(Gv::$credited,Gv::$status));
        //是否登录
            if(empty(Gv::$user_id)){//未登录
                if($version){
    //                $view->url = 'javascript:noLogin(\'/Login?jump=no\',\'尚未登录,请前往个人中心登录后参与活动!\');showmsgMobileRem()';
                    $view->url_guarantee = $view->url_rapidly = '/Login/?jump=BannerUserLogin';
                }else{
                    $view->url_guarantee = $view->url_rapidly = 'javascript:noLogin(\'/Login?jump=no\',\'尚未登录,请前往个人中心登录后参与活动!\');showmsgMobileRem()';
                }
            }else{
                //判断是否有未完成订单
                //判断当前订单情况
                if(Gv::$type == 1){
                    $app = $this->getapp();
                }elseif(Gv::$type == 2){
                    $app = $this->getappapp($this->_app_session['token']);
                }else{
                    $this->error('获取信息失败!');
                }
                $variable = array(
                    "user_id"=>Gv::$user_id,
                    "app"=>$app
                );
                $json_info = json_encode($variable);
                $resultCurrent = $this->_api->getApiArrays('Order','Current','',array('json'=>$json_info));
                if(isset($resultCurrent['code'])&&$resultCurrent['code']==1000){
                    //订单限制
                    if(isset($resultCurrent['result']['order']['status'])&&in_array($resultCurrent['result']['order']['status'],array(
                            Model_Home::PAGE_TO_INIT,
                            Model_Home::PAGE_TO_READY,
                            Model_Home::PAGE_TO_PASS,
                            Model_Home::PAGE_TO_PAY_IN,
                            Model_Home::PAGE_TO_PAID,
                            Model_Home::PAGE_TO_ACTREPAY_IN,
                            Model_Home::PAGE_TO_ACTREPAY_FAIL,
                            Model_Home::PAGE_TO_DEDUCT_SUCC,
                            Model_Home::PAGE_TO_DEDUCT_FAIL,
                            Model_Home::PAGE_TO_REPAY_IN,
                            Model_Home::PAGE_TO_REPAY_FAIL,
                            Model_Home::PAGE_TO_PAY_SUCC,
                            Model_Home::PAGE_TO_PREAUTH_SUCC,
                            Model_Home::PAGE_TO_PREAUTH_FAIL,
                            Model_Home::PAGE_TO_PREAUTH_IN,
                            Model_Home::PAGE_TO_OVERDUE_IN,
                            Model_Home::PAGE_TO_OVERDUE_SUCC,
                            Model_Home::PAGE_TO_OVERDUE_ACTREPAY_IN,
                            Model_Home::PAGE_TO_OVERDUE_ACTREPAY_FAIL,
                            Model_Home::PAGE_TO_OVERDUE_DEDUCT_SUCC,
                            Model_Home::PAGE_TO_OVERDUE_DEDUCT_RUNNING
                        ))){
                        $view->url_guarantee = $view->url_rapidly = 'javascript:noLogin(\'/?jump=no\',\'您有未完成的借款订单,请还款后参与活动!\');showmsgMobileRem()';
                    }else{
                        if($version ||($version==false&&Gv::$type==1)){
                            $view->url_guarantee = "javascript:borrowType(1);location.href = '/Borrowmoney/borrow/?jump=BannerEnsureLoan'";
                            $view->url_rapidly  = "javascript:borrowType(2);location.href = '/Borrowmoney/extremeBorrow/?jump=BannerFastLoan'";
                        }else{
                            $view->url_guarantee = $view->url_rapidly = '/?jump=no';
                        }
                    }
                }else{
                    if(isset($resultCurrent['code'])){
                        if($resultCurrent['code'] == 2020){
                            if($version){
                                //                $view->url = 'javascript:noLogin(\'/Login?jump=no\',\'尚未登录,请前往个人中心登录后参与活动!\');showmsgMobileRem()';
                                $view->url_guarantee = $view->url_rapidly = '/Login/?jump=BannerUserLogin';
                            }else{
                                $view->url_guarantee = $view->url_rapidly = 'javascript:noLogin(\'/Login?jump=no\',\'尚未登录,请前往个人中心登录后参与活动!\');showmsgMobileRem()';
                            }
                        }else{
                            $this->error($resultCurrent['message']);
                            die;
                        }
                    }else{
                        //系统繁忙，请联系客服！
                        $this->error(Kohana::message('wx','system_busy'));
                        die;
                    }
                }
                //基础授信
                $credited = Gv::$type == 1?Gv::$credited:(Gv::$type == 2?(isset($this->_app_session['credit_auth'])?$this->_app_session['credit_auth']:null):null);
                if(!in_array($credited, Model_Home::BASIC_CREDIT_FINISH)){
                    if($version){
                        $view->url_guarantee = $view->url_rapidly = 'javascript:noLogin(\'/Account/Promote?jump=BannerCreditManage\',\'请先下载APP完成基础授信!\');showmsgMobileRem()';
                    }else{
                        $view->url_guarantee = $view->url_rapidly = 'javascript:noLogin(\'/Account/Promote?jump=no\',\'请先下载APP完成基础授信!\');showmsgMobileRem()';
                    }
                }
            }
        }else{
            //活动未开始或结束
            $view->url_guarantee = $view->url_rapidly = "javascript:showmsgCancel('{$arr_ac['msg']}');showmsgMobileRem();";
            $view->lunbo = '<a>'.$arr_ac['msg'].'</a>';
        }
        //区分是否显示分享浮标
        if($view->client != 'else' && $version==false){
            $view->showbuoy = false;
        }else{
            $view->showbuoy = true;
        }
//        Tool::factory('Debug')->D($view->lunbo);
        $this->response->body($view);
    }

    //打卡广告
    public function action_AdPunchClock(){
      
        $view = View::factory($this->_vv.'Activity/AdSign');
        $this->response->body($view);
    }

    //人拉人
    public function action_PeoplePull(){

        $view = View::factory($this->_vv.'Activity/AdSign');
        $this->response->body($view);
    }

}