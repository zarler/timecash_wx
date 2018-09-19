<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 活动页面
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_App_Activity extends AppHome
//class Controller_App_Activity extends Common
{
    protected $_activity = null;
    protected $_signPackage = null;
    //构造方法  如果已登录  直接跳转到用户页面
    //浏览统计数组
    protected $_RecordVisit = null;


    public function before()
    {

        parent::before();
        $this->_activity = Model::factory('Activity');
    }
    /************************************************************************************************************************************
     *  领券活动(TC0A-016)
     ************************************************************************************************************************************/
    public function action_TC0A016(){


        if(isset($_GET['showtitle'])){
            parent::$_VArray['showtitle'] = true;
            parent::$_VArray['urlHome'] = 'javascript:history.go(-1);';
        }

        //浏览统计
        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        $ip = explode(",",$ip)[0];
        if($this->_activity->get_statistics(array('ip'=>trim($ip),'action'=>'look','event_name'=>'TCOA_016_LOOK'),'ac_count')){
            $this->_activity->insert_statistics(array('action'=>'look','ip'=>trim($ip),'create_time'=>time(),'event_name'=>'TCOA_016_LOOK','reg_app'=>'app'),'ac_count');
        }

        $variable = array(
            "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('Activity_Coupon','List','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            if(Valid::not_empty($result['result'])){
                foreach ($result['result'] as $key=>&$val){
                    $key++;
                    //半圆显示比例
                    $val['percent'.$key] = $val['proportion']/100;
                    //判断是否领取过
                    if($val['have_get']==0){
                        //未领取过
                        $idbutton = 'button'.$key;
                        $val['button'.$key] = "<a href='javascript:clickSubmit();getCoupon(\"{$idbutton}\");' id='{$idbutton}' data-code='{$val['coupon_id']}' class='coupon-btn'>点击领取</a>";
                    }else{
                        //领取过
//                        $val['button'.$key] = "<a href='javascript:layerMobile.submitOk(\"您已经领取过啦，机会留给别人吧\");layerMobile.changeCssPromptMsgAtc();' class='coupon-btn'>马上使用</a>";
                        $val['button'.$key] = "<a href='/?#jump=BannerAppHome' class='coupon-btn'>马上使用</a>";
                    }
                    //0-100（100位抢完）
                    // $val['proportion'] = 100;
                }
                parent::$_VArray['couponList'] = $result['result'];
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
        if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])){
            parent::$_VArray['app'] = true;
            parent::$_VArray['sharetitle'] = "领券下单享立减，快金就是要你省!";
            parent::$_VArray['text'] = "我刚从快金领取了50元优惠券，借款立减，一起来领吧！";
            parent::$_VArray['img_url'] = Kohana::$config->load('url.communic_url.timecash_m')."static/images/promotion/icon_logo.png";
            parent::$_VArray['url'] = Kohana::$config->load('url.communic_url.timecash_m')."wx/Activity/TC0A016";
        }else{
            //未登录优先
            $Gol = true;
            //登录未登录
            $url = Kohana::$config->load('url')['communic_url']['timecash_m'].'/app/Activity/TC0A016?target_token={target_token}&d={device_id}#jump=BannerUserLogin';
            $result['result'][0]['button1'] = '<a href="javascript:clickSubmit();layerMobile.submitUrl(\'亲，登陆后可以领券哦\',\''.$url.'\');layerMobile.changeCssPromptMsgAtc();" data-code="100" class="coupon-btn">点击领取</a>';
            $result['result'][1]['button2'] = '<a href="javascript:clickSubmit();layerMobile.submitUrl(\'亲，登陆后可以领券哦\',\''.$url.'\');layerMobile.changeCssPromptMsgAtc();" data-code="100" class="coupon-btn">点击领取</a>';
            $result['result'][2]['button3'] = '<a href="javascript:clickSubmit();layerMobile.submitUrl(\'亲，登陆后可以领券哦\',\''.$url.'\');layerMobile.changeCssPromptMsgAtc();" data-code="100" class="coupon-btn">点击领取</a>';
        }


        if(!isset($Gol)||!$Gol){
            //开始时间
            $now = date('H:i');
            if($now > '00:00' && $now < '10:00'){
                //未开始
                foreach ($result['result'] as $key=>&$val){
                    $key++;
                    $val['proportion'] = 0;
                    $val['button'.$key] = '<a href="javascript:clickSubmit();layerMobile.showlayer(\'亲，活动每天10点开始！\');layerMobile.changeCssMsg();" data-code="100" class="coupon-btn">点击领取</a>';
                }
            }
        }

        parent::$_VArray['requestUrl'] = "/app/FunctionsAct/016GetCoupon";
        parent::$_VArray['couponList'] = $result['result'];
        parent::$_VArray['shareButton'] = 'javascript:shareWx();';
        //点击统计
        parent::$_VArray['clickButtonUrl'] = '/app/FunctionsAct/statisticsUserIdIp';
        //分享统计
        parent::$_VArray['shareUrl'] = '';

        $view = View::factory($this->_vv.'Activity/TC0A_016');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }


    /************************************************************************************************************************************
     * js互动全
     ************************************************************************************************************************************/

    //人拉人
    public function action_TestJs(){
        $view = View::factory($this->_vv.'Activity/jsHtml');
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            parent::$_VArray['client'] = "ios";
        }elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            parent::$_VArray['client'] = "android";
        }else{
            parent::$_VArray['client'] = "else";
        }

        if(Valid::not_empty(Gv::$_userInfo['user_id'])){
            parent::$_VArray['html'] = '<a href="javascript:alert('.Gv::$_userInfo['user_id'].');" style="display:block;width: 500px;height: 150px;">去登录</a>';
        }else{
            parent::$_VArray['html'] = '<a href="http://test33.m.timecash.cn/app/Activity/TestJs?target_token={target_token}#jump=BannerUserLogin" style="display:block;width: 500px;height: 150px;">去登录</a>';
        }


        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }



    /************************************************************************************************************************************
     * 红包雨 017
     ************************************************************************************************************************************/
    //首页
    public function action_TC0A017Home(){

        $acStatus = Tool::factory('AcTool')->TimeLimit(1511366400,1511625600,'活动未开始。','端午节活动已结束');
        $arr_ac = json_decode($acStatus,true);
        //只有26号活动开始才会走这个
        if(!$arr_ac['status']){
            echo '活动已经结束！';
            die;
        }

        //浏览统计
        if($this->_activity->get_statistics(array('ip'=>$this->_ip,'action'=>'look_h','event_name'=>'TCOA_017_LOOK'),'ac_count')){
            $this->_activity->insert_statistics(array('action'=>'look_h','ip'=>$this->_ip,'create_time'=>time(),'event_name'=>'TCOA_017_LOOK','reg_app'=>'app'),'ac_count');
        }

        //Tool::factory('Debug')->D(Kohana::$config->load('url')['communic_url']['timecash_m']);

        $variable = array(
            "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
        );
        $json_info = json_encode($variable);
        //滚动列表
        $result = $this->_api->getApiArrays('AC_TCOA017','List','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            parent::$_VArray['listStr'] = null;
            if(isset($result['result'])&&Valid::not_empty($result['result'])){
                foreach ($result['result'] as $key =>$val){
                    parent::$_VArray['listStr'].= "<li>恭喜{$val['mobile']}获得{$val['prize']}红包</li>";
                }
            }else{
                parent::$_VArray['listStr'] = '<p style="text-align: center">暂无信息</p>';
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

        $variableRed = array_merge($variable,array('limit'=>5));
        $json_infoRed = json_encode($variableRed);
        //红包记录
        $result = $this->_api->getApiArrays('AC_TCOA017','MyPrizeLimit','',array('json'=>$json_infoRed));
        if(isset($result['code']) && $result['code']==1000){
            parent::$_VArray['listRed'] = null;
            parent::$_VArray['listRedMore'] = '';
            if(isset($result['result'])&&Valid::not_empty($result['result'])){
                foreach ($result['result'] as $key =>$val){
                    $val['create_time'] = date('Y-m-d',$val['create_time']);
                    parent::$_VArray['listRed'].= "<li><span>{$val['prize']}</span><span>{$val['create_time']}</span></li>";
                    if($key>=4){
                        //显示更多
                        parent::$_VArray['listRedMore'] = "<a href='/app/Activity/TC0A017List'>显示所有</a>";
                    }
                }
            }else{
                parent::$_VArray['listRed'] = '<p style="text-align: center;font-size: .4rem;margin-top: 2rem">暂无信息</p>';
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
        if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])){
            //判断是否符合进入抢红包页面
            //剩余次数
            $result = $this->_api->getApiArrays('AC_TCOA017','Times','',array('json'=>$json_info));
            if(isset($result['code']) && $result['code']==1000){
                parent::$_VArray['LoanButton'] = '<a href="/app/Activity/TC0A017Redrain" class="redrain-btn">马上抢红包</a>';
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
            //未登录优先
//            $Gol = true;
            $url = Kohana::$config->load('url')['communic_url']['timecash_m'].'/app/Activity/TC0A017Home?target_token={target_token}&d={device_id}#jump=BannerUserLogin';
            parent::$_VArray['LoanButton'] = '<a href="javascript:layerMobile.submitUrl(\'亲，需要先登录后才可抓红包哦\',\''.$url.'\');layerMobile.changeCssPromptMsgAtc();" class="redrain-btn">马上抢红包</a>';
        }
        parent::$_VArray['jumpList'] = "/app/FunctionsAct/017GetTimes";
        $view = View::factory($this->_vv.'Activity/TC0A_017_Home');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

    //红包雨
    public function action_TC0A017Redrain(){

        $acStatus = Tool::factory('AcTool')->TimeLimit(1511366400,1511625600,'活动未开始。','端午节活动已结束');
        $arr_ac = json_decode($acStatus,true);
        //只有26号活动开始才会走这个
        if(!$arr_ac['status']){
            echo '活动已经结束！';
            die;
        }


        //浏览统计
        if($this->_activity->get_statistics(array('ip'=>$this->_ip,'action'=>'look_r','event_name'=>'TCOA_017_LOOK'),'ac_count')){
            $this->_activity->insert_statistics(array('action'=>'look_r','ip'=>$this->_ip,'create_time'=>time(),'event_name'=>'TCOA_017_LOOK','reg_app'=>'app'),'ac_count');
        }

        //进行一次抽奖记录
        $variable = array(
            "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
        );
        $json_info = json_encode($variable);
        //抽奖次数
        $result = $this->_api->getApiArrays('AC_TCOA017','Times','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            if(isset($result['result']['times'])&&$result['result']['times']>0){
                parent::$_VArray['times'] = $result['result']['times'];
                //max 为1的时候有6次机会，
            }
            parent::$_VArray['max'] = isset($result['result']['max'])?$result['result']['max']:0;
        }


        //获奖轮播
        $result = $this->_api->getApiArrays('AC_TCOA017','List','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            parent::$_VArray['listStr'] = null;
            if(isset($result['result'])&&Valid::not_empty($result['result'])){
                foreach ($result['result'] as $key =>$val){
                    parent::$_VArray['listStr'].= "<li>恭喜{$val['mobile']}获得{$val['prize']}红包</li>";
                }
            }else{
                parent::$_VArray['listStr'] = '<p style="text-align: center">暂无获奖信息</p>';
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


        if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])){
            //判断是否符合进入抢红包页面
            parent::$_VArray['app'] = true;
            parent::$_VArray['sharetitle'] = "我想在快金抽免单，快来帮我实现吧!";
            parent::$_VArray['text'] = "亲，小手动一动，帮您的好友点亮下方小图标，好友就有就会得快金免单红包！";
            parent::$_VArray['img_url'] = Kohana::$config->load('url.communic_url.timecash_m')."static/images/promotion/icon_logo.png";
            parent::$_VArray['url'] = Kohana::$config->load('url.communic_url.timecash_m')."wx/Activity/TC0A017Zan?userId=".Gv::$_userInfo['user_id'];

        }else{
            //未登录
            $this->error(Kohana::message('wx','用户未登录！'));
            die;
        }

        //删除抽奖次数
        parent::$_VArray['timeReq'] = '/app/FunctionsAct/017DeductTimes';
        //抽奖请求
        parent::$_VArray['luckDrawReq'] = '/app/FunctionsAct/017LuckDraw';
        parent::$_VArray['timesReqt'] = "/app/Activity/TC0A017List";
        //邀请好友
        parent::$_VArray['invitationUrl'] = "javascript:clickSubmit();shareWx();";
        //点击统计
        parent::$_VArray['clickButtonUrl'] = '/app/FunctionsAct/statisticsUserIdIp';


        $view = View::factory($this->_vv.'Activity/TC0A_017_Redrain');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    //中奖列表
    public function action_TC0A017List(){

        //浏览统计
        if($this->_activity->get_statistics(array('ip'=>$this->_ip,'action'=>'look_l','event_name'=>'TCOA_017_LOOK'),'ac_count')){
            $this->_activity->insert_statistics(array('action'=>'look_l','ip'=>$this->_ip,'create_time'=>time(),'event_name'=>'TCOA_017_LOOK','reg_app'=>'app'),'ac_count');
        }
        //红包记录
        $variable = array(
            "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('AC_TCOA017','MyPrize','',array('json'=>$json_info));

        if(isset($result['code']) && $result['code']==1000){
            parent::$_VArray['listRed'] = null;
            parent::$_VArray['listRedMore'] = '';
            if(isset($result['result'])&&Valid::not_empty($result['result'])){
                foreach ($result['result'] as $key =>$val){
                    $val['create_time'] = date('Y-m-d',$val['create_time']);
                    parent::$_VArray['listRed'].= "<li><span>{$val['prize']}</span><span>{$val['create_time']}</span></li>";
                }
            }else{
                parent::$_VArray['listRed'] = '<p style="text-align: center;font-size: .4rem;margin-top: 2rem">暂无信息</p>';
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
        $view = View::factory($this->_vv.'Activity/TC0A_017_List');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

    /************************************************************************************************************************************
     * 大转盘
     ************************************************************************************************************************************/
    public function action_TC0A019(){
        //浏览统计
        if(isset($_GET['entrance'])){
            switch ($_GET['entrance']){
                case 'tip1':
                    //刚进来就弹提示入口
                    $action = 'look_t1';
                    break;
                case 'tip2':
                    //弹提示入口
                    $action = 'look_t2';
                    break;
                case 'tip3':
                    //弹提示入口
                    $action = 'look_t3';
                    break;
                case 'details':
                    //详情入口
                    $action = 'look_d';
                    break;
                default:
                    //banner
                    $action = 'look_b';
                    break;
            }
        }else{
            $action = 'look_b';
        }

        $this->_RecordVisit = array(
            'action'=>$action,
            'event_name'=>'TCOA_019_LOOK',
            'reg_app'=>'app',
            'table'=>'ac_count'
        );
        $this->VisitRecord();


        //滚动条
        $arr=array('133****2206获得500元提额','134****3254获得300元提额','180****2788获得500元提额','150****3589获得300元提额','138****0710获得100元提额','187****7699获得100元提额','159****2611获得100元提额','182****8007获得500元提额','180****0163获得300元提额','185****3530获得800元提额','158****9271获得500元提额','183****8166获得300元提额','188****6490获得800元提额','恭喜182****1599获得500元提额','136****8685获得100元提额','158****3779获得500元提额','183****0176获得300元提额','186****6671获得800元提额','136****2001获得500元提额','159****0961获得500元提额');
        shuffle($arr);
        $arr = array_slice($arr,0,5);
//        $arr = null;
        if(Valid::not_empty($arr)){
            parent::$_VArray['listStr'] = null;
            foreach ($arr as $key =>$val){
                parent::$_VArray['listStr'].= "<li>{$val}</li>";
            }
        }else{
            parent::$_VArray['listStr'] = '<p style="text-align: center">暂无获奖信息</p>';
        }
//        parent::$_VArray['listStr']
//        Tool::factory('Debug')->D($arr);
        //微信分享
        if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])){
            //判断是否有抽奖机会
            $variable = array(
                "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('AC_TCOA019','HaveChance','',array('json'=>$json_info));
            if(isset($result['code']) && $result['code']==1000){
                if (isset($result['result']['status'])&&$result['result']['status']==1){
                    //可以抽奖
                    parent::$_VArray['buttonStr'] = '<button onclick="clickSubmit(\'click_c\');submit();"  id="lottery-btn">马上抽奖</button>';
                }else{
                    //不能抽奖
                    parent::$_VArray['buttonStr'] = '<button onclick="clickSubmit(\'click_c\');layerMobile.submitOk(\'亲，还款成功后可抽奖，您不符合抽奖资格!\');layerMobile.changeCssPromptMsgAtc();" id="lottery-btn">马上抽奖</button>';
                }
                //需要还款按钮
                if (isset($result['result']['have_repay_order'])&&$result['result']['have_repay_order']==1){
                    //可以还款
//                    parent::$_VArray['buttonRepayStr'] = '<a href="/Account/BorrowingRecords#jump=BannerLoanRecord" class="lottery-pop-share-btn">马上还款</a>';
                    parent::$_VArray['buttonStr'] = '<button onclick="clickSubmit(\'click_c\');layerMobile.submitUrl(\'亲，您有未还清订单，还款成功后可抽奖哦！\',\'/Account/BorrowingRecords#jump=BannerLoanRecord\');layerMobile.changeCssPromptMsgAtc();" id="lottery-btn">马上抽奖</button>';
                }

                //还款审核中的订单
                if (isset($result['result']['have_repay_order'])&&$result['result']['have_repay_order']==2){
                    //可以还款
//                    parent::$_VArray['buttonRepayStr'] = '<a href="/Account/BorrowingRecords#jump=BannerLoanRecord" class="lottery-pop-share-btn">马上还款</a>';
                    parent::$_VArray['buttonStr'] = '<button onclick="clickSubmit(\'click_c\');layerMobile.submitOk(\'亲，还款成功可抽奖，还款状态正在审核中，请耐心等一下哟！\');layerMobile.changeCssPromptMsgAtc();" id="lottery-btn">马上抽奖</button>';
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
            parent::$_VArray = array_merge(parent::$_VArray,array(
                'app'=>true,
                'sharetitle'=>"我在快金还款后，享有800元提额，你也来试试吧!",
                'text'=>"快金幸运大转盘，800元提额转出来！",
                'img_url'=>Kohana::$config->load('url.communic_url.timecash_m')."static/images/promotion/icon_logo.png",
                'url'=>Kohana::$config->load('url.communic_url.timecash_m')."wx/Activity/TC0A019Share"
            ));
            //区分活动页面还是分享页面
            parent::$_VArray['share'] = true;
            //显示弹框类型
            parent::$_VArray['tipShare'] = true;
            //分享统计
            parent::$_VArray['shareUrl'] = '/app/FunctionsAct/shareWx';
            //分享
            parent::$_VArray['invitationUrl'] = "javascript:clickSubmit('click_i');shareWx();";

            //点击统计
            parent::$_VArray['clickButtonUrl'] = '/app/FunctionsAct/statisticsUserIdIp';

        }else{
            //登录未登录
            //区分活动页面还是分享页面
            parent::$_VArray['share'] = false;
            //显示弹框类型
            parent::$_VArray['tipShare'] = true;
            $url = Kohana::$config->load('url')['communic_url']['timecash_m'].'/app/Activity/TC0A019?target_token={target_token}&d={device_id}#jump=BannerUserLogin';
            parent::$_VArray['buttonStr'] = '<button onclick="layerMobile.submitUrl(\'亲，需要先登录后才可抓红包哦\',\''.$url.'\');layerMobile.changeCssPromptMsgAtc();" id="lottery-btn">马上抽奖</a>';
        }

        parent::$_VArray['019LuckDraw'] = '/app/FunctionsAct/019LuckDraw';

        $view = View::factory($this->_vv.'Activity/TC0A_019');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }


    /************************************************************************************************************************************
     * 020圣诞节
     ************************************************************************************************************************************/
    public function action_TC0A020(){


        //浏览统计
        if(isset($_GET['entrance'])){
            switch ($_GET['entrance']){
                case 'tip1':
                    //刚进来就弹提示入口
                    $action = 'look_t1';
                    break;
                case 'tip2':
                    //弹提示入口
                    $action = 'look_t2';
                    break;
                case 'tip3':
                    //弹提示入口
                    $action = 'look_t3';
                    break;
                case 'details':
                    //详情入口
                    $action = 'look_d';
                    break;
                default:
                    //banner
                    $action = 'look_b';
                    break;
            }
        }else{
            $action = 'look_b';
        }

        $this->_RecordVisit = array(
            'action'=>$action,
            'event_name'=>'TCOA_020_LOOK',
            'reg_app'=>'app',
            'table'=>'ac_count'
        );
        $this->VisitRecord();


        $firstDay =
            '<li><span>恭喜185****8721</span><span style="text-align: left">获得OPPOR11S手机一部</span></li>
            <li><span>恭喜186****8410</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜136****9380</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜158****6140</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜130****5590</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
           ';
        $secondDay =
            '<li><span>恭喜150****2068</span><span style="text-align: left">获得OPPOR11S手机一部</span></li>
            <li><span>恭喜159****8024</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜135****6803</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜138****3343</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜186****7855</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            ';
        $thirdDay =
            '<li><span>恭喜158****1640</span><span style="text-align: left">获得OPPOR11S手机一部</span></li>
            <li><span>恭喜156****7328</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜138****7592</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜131****0409</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜131****8216</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            ';

//        $time = time()+86400*4;
       $time = time();
//        $time = date('Y-m-d',$strr);
        //2017-12-24 10:00  1514080800
        //2017-12-25 10:00  1514167200
        //2017-12-26 10:00  1514253600

        //24号之前
        if($time<1514080800){
            $resultAtt = null;
            //24-25
        }else if($time>1514080800&&$time<1514167200){
            $resultAtt = array(
                '23'=>$firstDay
            );
            //25-26
        }else if($time>1514167200&&$time<1514253600){
            $resultAtt = array(
                '24'=>$secondDay
            );

        }else{
            $resultAtt = array(
                '25'=>$thirdDay
            );
        }
        parent::$_VArray['resultAtt'] = $resultAtt;
        parent::$_VArray['reqUrl'] = '/app/Activity/TC0A020List';
        $view = View::factory($this->_vv.'Activity/TC0A_020');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

    public function action_TC0A020List(){


        $this->_RecordVisit = array(
            'action'=>'look_l',
            'event_name'=>'TCOA_020_LOOK',
            'reg_app'=>'app',
            'table'=>'ac_count'
        );
        $this->VisitRecord();


        $firstDay =
            '<li><span>恭喜185****8721</span><span style="text-align: left">获得OPPOR11S手机一部</span></li>
            <li><span>恭喜186****8410</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜136****9380</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜158****6140</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜130****5590</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜186****0386</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜134****5219</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜153****2829</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜159****6797</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜152****7082</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>';
        $secondDay =
            '<li><span>恭喜150****2068</span><span style="text-align: left">获得OPPOR11S手机一部</span></li>
            <li><span>恭喜159****8024</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜135****6803</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜138****3343</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜186****7855</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜136****7660</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜184****6188</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜152****6288</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜156****7069</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜183****5558</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>';
        $thirdDay =
            '<li><span>恭喜158****1640</span><span style="text-align: left">获得OPPOR11S手机一部</span></li>
            <li><span>恭喜156****7328</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜138****7592</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜131****0409</span><span style="text-align: left">获得500元京东电子购物卡</span></li>
            <li><span>恭喜131****8216</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜185****7814</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜186****9877</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜139****1688</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜136****7795</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>
            <li><span>恭喜138****0214</span><span style="text-align: left">获得良品铺子干果大礼包</span></li>';


//        $time = time()+86400*4;
         $time = time();
//        $time = date('Y-m-d',$strr);
        //2017-12-24 10:00  1514080800
        //2017-12-25 10:00  1514167200
        //2017-12-26 10:00  1514253600

        //24号之前
        if($time<1514080800){
            $resultAtt = null;
            //24-25
        }else if($time>1514080800&&$time<1514167200){
            $resultAtt = array(
                '23'=>$firstDay
            );
            //25-26
        }else if($time>1514167200&&$time<1514253600){
            $resultAtt = array(
                '23'=>$firstDay,
                '24'=>$secondDay
            );
        }else{
            $resultAtt = array(
                '23'=>$firstDay,
                '24'=>$secondDay,
                '25'=>$thirdDay
            );
        }

        parent::$_VArray['resultAtt'] = $resultAtt;
        $view = View::factory($this->_vv.'Activity/TC0A_020_List');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }


    /************************************************************************************************************************************
     * 021元旦
     ************************************************************************************************************************************/

    public function action_TC0A021(){

        //浏览统计
        if(isset($_GET['entrance'])){
            switch ($_GET['entrance']){
                case 'tip1':
                    //刚进来就弹提示入口
                    $action = 'look_t1';
                    break;
                case 'tip2':
                    //弹提示入口
                    $action = 'look_t2';
                    break;
                case 'tip3':
                    //弹提示入口
                    $action = 'look_t3';
                    break;
                case 'details':
                    //详情入口
                    $action = 'look_d';
                    break;
                default:
                    //banner
                    $action = 'look_b';
                    break;
            }
        }else{
            $action = 'look_b';
        }

        $this->_RecordVisit = array(
            'action'=>$action,
            'event_name'=>'TCOA_021_LOOK',
            'reg_app'=>'app',
            'table'=>'ac_count'
        );
        $this->VisitRecord();

        $firstDay =
            '<li><span style="width:45%">恭喜158****2228</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜151****6624</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜186****6140</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜139****5291</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜131****5331</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
           ';
        $secondDay =
            '<li><span style="width:45%">恭喜138****0465</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜151****6053</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜132****6262</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜135****0116</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜150****9005</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            ';
        $thirdDay =
            '<li><span style="width:45%">恭喜186****0055</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜185****6765</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜186****0311</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜186****5330</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜158****3655</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            ';


//        $time = time()+86400*7;
        $time = time();
//        $time = date('Y-m-d',$strr);
        //2018-1-1 10:00     1514772000
        //2018-1-2 10:00     1514858400
        //2018-1-3 10:00     1514944800
        //2018-1-4 10:00     1515031200

        //30号之前
        if($time<1514858400){
            $resultAtt = null;
            //30-31
        }else if($time>1514858400&&$time<1514944800){
            $resultAtt = array(
                '1'=>$firstDay
            );
            //31-1
        }else if($time>1514944800&&$time<1515031200){
            $resultAtt = array(
                '2'=>$secondDay
            );
        }else{
            $resultAtt = array(
                '3'=>$thirdDay
            );
        }

        parent::$_VArray['resultAtt'] = $resultAtt;
        parent::$_VArray['reqUrl'] = '/app/Activity/TC0A021List';

        $view = View::factory($this->_vv.'Activity/TC0A_021');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    public function action_TC0A021List(){
        $this->_RecordVisit = array(
            'action'=>'look_l',
            'event_name'=>'TCOA_021_LOOK',
            'reg_app'=>'app',
            'table'=>'ac_count'
        );
        $this->VisitRecord();

        $firstDay =
            '<li><span style="width:45%">恭喜158****2228</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜151****6624</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜186****6140</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜139****5291</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜131****5331</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜135****5097</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
           ';
        $secondDay =
            '<li><span style="width:45%">恭喜138****0465</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜151****6053</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜132****6262</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜135****0116</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜150****9005</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜188****2123</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            ';
        $thirdDay =
            '<li><span style="width:45%">恭喜186****0055</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜185****6765</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜186****0311</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜186****5330</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜158****3655</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            <li><span style="width:45%">恭喜157****0021</span><span style="text-align: left;width:55%">获得500元现金大红包</span></li>
            ';

//        $time = time()+86400*7;
        $time = time();
//        $time = date('Y-m-d',$strr);
        //2018-1-1 10:00     1514772000
        //2018-1-2 10:00     1514858400
        //2018-1-3 10:00     1514944800
        //2018-1-4 10:00     1515031200

        //30号之前
        if($time<1514858400){
            $resultAtt = null;
            //30-31
        }else if($time>1514858400&&$time<1514944800){
            $resultAtt = array(
                '1'=>$firstDay
            );
            //31-1
        }else if($time>1514944800&&$time<1515031200){
            $resultAtt = array(
                '1'=>$firstDay,
                '2'=>$secondDay
            );
        }else{
            $resultAtt = array(
                '1'=>$firstDay,
                '2'=>$secondDay,
                '3'=>$thirdDay
            );
        }

        parent::$_VArray['resultAtt'] = $resultAtt;
        $view = View::factory($this->_vv.'Activity/TC0A_021_List');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

    /************************************************************************************************************************************
     * 分期推广
     ************************************************************************************************************************************/
    public function action_StagingExtension(){
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            parent::$_VArray['client'] = "javascript:layerMobile.showlayer('苹果机型暂不支持下载，敬请用户见谅');layerMobile.changeCssMsg();";
        }elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            parent::$_VArray['client'] = "javascript:window.android.JsAppInteraction('web_abroad','http://download-cdn.timecash.cn/android/release/inst/inst_1.0.1.apk')";
            parent::$_VArray['clientType'] = "android";
        }else{
            parent::$_VArray['client'] = "javascript:layerMobile.showlayer('暂不支持下载，敬请用户见谅');layerMobile.changeCssMsg();";
//            parent::$_VArray['client'] = "else";
        }
//        Tool::factory('Debug')->D(parent::$_VArray);
//        parent::$_VArray['resultAtt'] = $resultAtt;
        $view = View::factory($this->_vv.'Activity/StagingExtension');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

    /************************************************************************************************************************************
     * 统计
     ************************************************************************************************************************************/
    //  浏览统计
    public function VisitRecord(){
        if(Valid::not_empty($this->_RecordVisit)){
            if($this->_activity->get_statistics(array('ip'=>$this->_ip,'action'=>$this->_RecordVisit['action'],'event_name'=>$this->_RecordVisit['event_name'],'reg_app'=>$this->_RecordVisit['reg_app']),$this->_RecordVisit['table'])){
                $this->_activity->insert_statistics(array('user_id'=>isset(Gv::$_userInfo['user_id'])?Gv::$_userInfo['user_id']:null,'action'=>$this->_RecordVisit['action'],'ip'=>$this->_ip,'create_time'=>time(),'event_name'=>$this->_RecordVisit['event_name'],'reg_app'=>$this->_RecordVisit['reg_app']),$this->_RecordVisit['table']);
            }
        }
    }


    /************************************************************************************************************************************
     * 普付宝引流活动
     ************************************************************************************************************************************/
    //  浏览统计
    public function action_TCOA025(){
        //流量统计(按照ip统计)
        $this->_RecordVisit = array('action'=>'look', 'event_name'=>'TCOA_025_LOOK', 'reg_app'=>'app', 'table'=>'ac_count');
        $this->VisitRecord();

        if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])){
            $this->_RecordVisit = array('action'=>'look', 'event_name'=>'TCOA_025_LOOK', 'reg_app'=>'app', 'table'=>'ac_count');
            //流量统计(按照用户id统计)
            if($this->_activity->get_statistics(array('user_id'=>Gv::$_userInfo['user_id'],'action'=>'look','event_name'=>'TCOA_025_LOOK','reg_app'=>'app'),'ac_userid_count')){
                $this->_activity->insert_statistics(array('user_id'=>isset(Gv::$_userInfo['user_id'])?Gv::$_userInfo['user_id']:null,'action'=>'look','ip'=>$this->_ip,'create_time'=>time(),'event_name'=>'TCOA_025_LOOK','reg_app'=>'app'),'ac_userid_count');
            }
            parent::$_VArray['buttonStr'] = "javascript:clickSubmit();location.href='/app/QuickReceipts/Index';";
        }else{
            //未登录
            $url = Kohana::$config->load('url')['communic_url']['timecash_m'].'/app/Activity/TCOA025?target_token={target_token}&d={device_id}#jump=BannerUserLogin';
            parent::$_VArray['buttonStr'] = 'javascript:clickSubmit();layerMobile.submitUrl(\'亲，需要您先登录哦！\',\''.$url.'\');layerMobile.changeCssPromptMsgAtc();';
        }
        //点击统计
        parent::$_VArray['clickButtonUrl'] = '/app/FunctionsAct/statisticsUserIdIp';
        $view = View::factory($this->_vv.'Activity/TC0A_025');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

    /************************************************************************************************************************************
     * 邀请好友，提现金
     ************************************************************************************************************************************/
    public function action_TCOA026(){

        //look_h为首页
        //浏览统计
        if(isset($_GET['entrance'])){
            switch ($_GET['entrance']){
                case 'tip1':
                    //首页弹框
                    $action = 'look_h_t1';
                    break;
                case 'tip2':
                    //通知栏弹框
                    $action = 'look_h_t2';
                    break;
                default:
                    //banner
                    $action = 'look_h';
                    break;
            }
        }else{
            $action = 'look_h';
        }
        $this->_RecordVisit = array('action'=>$action, 'event_name'=>'TCOA_026', 'reg_app'=>'app', 'table'=>'ac_count');
        $this->_activity->insert_statistics(array('user_id'=>isset(Gv::$_userInfo['user_id'])?Gv::$_userInfo['user_id']:null,'action'=>$this->_RecordVisit['action'],'ip'=>$this->_ip,'create_time'=>time(),'event_name'=>$this->_RecordVisit['event_name'],'reg_app'=>$this->_RecordVisit['reg_app']),$this->_RecordVisit['table']);


        //文鑫的头锅
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {

            }else{
                if(isset($_GET['d'])){

                }else{
                    parent::$_VArray['showtitle'] = true;
                    parent::$_VArray['urlHome'] = '/?#jump=no';
                }
            }
        }
        //我的奖品
        parent::$_VArray['invitedList'] = null;
        if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])){
            //登录
            parent::$_VArray['Login'] = true;
            //马上邀请好友
            parent::$_VArray['app'] = true;

            $sharetitle = "好友送你88元现金，iPhone X免费拿";
            $text = "急用钱，找快金！送你一张7天免息券！免息用7天，当天可放款！更有iPhoneX免费拿！速戳>！";
            $img_url = Kohana::$config->load('url.communic_url.timecash_m')."static/Activity/TC0A-026/images/ix.png";
            $url = Kohana::$config->load('url.communic_url.timecash_m')."h5/Activity/TCOA026BeInvited?userId=".Gv::$_userInfo['user_id'];
            parent::$_VArray['UrlInvitation'] = "javascript:clickSubmit();\$AppInst.Share({'sharetitle':'{$sharetitle}','text':'{$text}','img_url':'{$img_url}','url':'{$url}','actIc':26});";
            //邀请详情
            parent::$_VArray['Urldetails'] = '/app/Activity/TCOA026Record#';

            //领取请求地址
            parent::$_VArray['requestUrl'] = '/app/FunctionsAct/026MyPrice';

            //提现(在活动期间不能体现)p
//            if(time()>strtotime('2018-04-26')){
//
//            }else{
//                parent::$_VArray['UrlWithdrawals'] = 'javascript:receiveReward(6,1);';
//            }

            parent::$_VArray['UrlWithdrawals'] = '/app/Withdrawals/HomePage';

            //我的奖品
            parent::$_VArray['UrlMyPrize'] = '/app/Activity/TCOA026MyPrize';
            //点击统计
            parent::$_VArray['clickButtonUrl'] = '/app/FunctionsAct/statisticsUserIdIpAll';


            //领取
            parent::$_VArray['UrlReceive'] = 'javascript:receiveReward(5,1);';
            //主页信息
            $variable = array(
                "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('AC_TCOA026','Inviter','',array('json'=>$json_info));
            if(isset($result['code']) && $result['code']==1000){
                if(isset($result['result'])&&Valid::not_empty($result['result'])){
                    //parent::$_VArray['data'] = $result['result'];
                    parent::$_VArray['invited_num'] = $result['result']['invited_num'];
                    parent::$_VArray['award'] = $result['result']['award'];
                    parent::$_VArray['prizeList'] = null;
                    if(isset($result['result']['prize'])&&Valid::not_empty($result['result']['prize'])){
                        foreach ($result['result']['prize'] as $key => $val){
                            //0未达到资格  1可以领取  2已领取
                            switch ($val['get']){
                                case 0:
                                    parent::$_VArray['prizeList'] .= '<div><span class="span-o">'.$val['prize'].'</em></span><span class="span-s">借款人数满'.$val['num'].'人</span><button  onclick="Standard('.$val['num'].')">领取奖品</button></div>';
                                    break;
                                case 1:
                                    parent::$_VArray['prizeList'] .= '<div><span class="span-o">'.$val['prize'].'</span><span class="span-s">借款人数满'.$val['num'].'人</span><button data-code="'.$val['id'].'" onclick="javascript:getPrice(this)">领取奖品</button></div>';
                                    break;
                                case 2:
                                    parent::$_VArray['prizeList'] .= '<div><span class="span-o">'.$val['prize'].'</span><span class="span-s">借款人数满'.$val['num'].'人</span><button class="OA026-5-b" onclick="'.$val['num'].'">已领取</button></div>';
                                    break;
                                default:
                                    parent::$_VArray['prizeList'] .= '<div><span class="span-o">'.$val['prize'].'</span><span class="span-s">借款人数满'.$val['num'].'人</span><button  onclick="Standard('.$val['num'].')">未达标</button></div>';
                                    break;
                            }
                        }
                    }
                    if(isset($result['result']['list'])&&Valid::not_empty($result['result']['list'])){
                        foreach ($result['result']['list'] as $key=>$val){
                            $key++;
                            parent::$_VArray['invitedList'] .= '<li><span class="span1">'.$key.'</span><span class="span2">'.$val['mobile'].'</span><span class="span3">'.$val['num'].'人</span></li>';
                        }
                    }else{
                        //空
                        parent::$_VArray['invitedList'] = ' <div style="height: 3rem;width: 100%;line-height: 3rem;text-align: center">暂无数据</div>';
                    }


                }else{
                    parent::$_VArray['data'] = null;
                    parent::$_VArray['prizeList'] .= '';
                }

                //获奖手机号

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

            //微信分享
            //判断是否符合进入抢红包页面
        }else{
            $variable = array(
                "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('AC_TCOA026','List','',array('json'=>$json_info));
            if(isset($result['code']) && $result['code']==1000){
                if(isset($result['result']['list'])&&Valid::not_empty($result['result']['list'])){
                    foreach ($result['result']['list'] as $key=>$val){
                        $key++;
                        parent::$_VArray['invitedList'] .= '<li><span class="span1">'.$key.'</span><span class="span2">'.$val['mobile'].'</span><span class="span3">'.$val['num'].'人</span></li>';
                    }
                }else{
                    //空
                    parent::$_VArray['invitedList'] = ' <div style="height: 3rem;width: 100%;line-height: 3rem;text-align: center">暂无数据</div>';
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
            parent::$_VArray['invited_num'] = 0;
            parent::$_VArray['award'] = 0;
            //未登录优先
            parent::$_VArray['Login'] = false;
            //分享链接
            parent::$_VArray['UrlShare'] = null;
            //邀请
            $url = Kohana::$config->load('url')['communic_url']['timecash_m'].'/app/Activity/TCOA026?target_token={target_token}&d={device_id}#jump=BannerUserLogin';
            parent::$_VArray['UrlInvitation'] = 'javascript:receiveReward(5,\''.$url.'\')';
            //邀请详情
            parent::$_VArray['Urldetails'] = 'javascript:receiveReward(5,\''.$url.'\')';
            //提现
            parent::$_VArray['UrlWithdrawals'] = 'javascript:receiveReward(5,\''.$url.'\')';

            //我的奖品
            parent::$_VArray['UrlMyPrize'] = 'javascript:receiveReward(5,\''.$url.'\')';

            //领取
            parent::$_VArray['UrlReceive'] = 'javascript:receiveReward(5,\''.$url.'\')';
            parent::$_VArray['data'] = null;
            parent::$_VArray['prizeList'] = '<div><span class="span-o">现金红包<br><span>￥50元</span></span><span class="span-s">借款人数满3人</span><button onclick="'.parent::$_VArray['UrlReceive'].'">领取奖品</button></div><div style="clear: both"><span class="span-o">京东购物卡<br><apan>￥500元</apan></span><span class="span-s">借款人数满20人</span><button onclick="'.parent::$_VArray['UrlReceive'].'">领取奖品</button></div><div style="clear: both"><span class="span-o">足金金元宝<br><span>￥1500元</span></span><span class="span-s">借款人数满50人</span><button onclick="'.parent::$_VArray['UrlReceive'].'">领取奖品</button></div><div style="clear: both"><span class="span-o">IphoneX手机<br><span>￥8388元</span></span><span class="span-s">借款人数满100人</span><button onclick="'.parent::$_VArray['UrlReceive'].'">领取奖品</button></div>';

        }

        $view = View::factory($this->_vv.'Activity/TC0A_026');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    //邀请记录
    public function action_TCOA026Record(){

        parent::$_VArray['invitedList'] = null;
        parent::$_VArray['award'] = 0;
        parent::$_VArray['invited'] = 0;
        parent::$_VArray['urlWithdrawals'] = '/app/Activity/TCOA026';
        //主页信息
        $variable = array(
            "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('AC_TCOA026','Record','',array('json'=>$json_info));
        if(isset($result['code']) && $result['code']==1000){
            parent::$_VArray['award'] = isset($result['result']['award'])?$result['result']['award']:0;
            parent::$_VArray['invited'] = isset($result['result']['invited_num'])?$result['result']['invited_num']:0;
            if($result['result']['list']&&Valid::not_empty($result['result']['list'])){
                foreach ($result['result']['list'] as $key=>$val){
                    if($val['has_order']==1){
                        $hasMsg = '成功借款';
                    }else{
                        $hasMsg = '注册未借款';
                    }
                    parent::$_VArray['invitedList'] .= '<ul><li>'.$val['mobile'].'</li><li>'.$hasMsg.'</li><li>'.$val['award'].'元</li></ul>';
                }
            }else{
                parent::$_VArray['invitedList'] = ' <div style="height: 3rem;width: 100%;line-height: 3rem;text-align: center">暂无数据</div>';
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
        $view = View::factory($this->_vv.'Activity/TC0A_026_Record');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

    //我的奖品
    public function action_TCOA026MyPrize(){
        parent::$_VArray['prizeList'] = null;
        $variable = array(
            "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
        );
        $json_info = json_encode($variable);
        $result = $this->_api->getApiArrays('AC_TCOA026','MyPrize','',array('json'=>$json_info));

        if(isset($result['code']) && $result['code']==1000){
            if(isset($result['result']['prize'])&&Valid::not_empty($result['result']['prize'])){
                foreach ($result['result']['prize'] as $key=>$val){
                    parent::$_VArray['prizeList'] .= '<ul><li><img src="/static/Activity/TC0A-026/images/'.$val['id'].'.png" ></li><li><p>'.$val['prize'].'</p></li><li style="line-height: 1.4rem;">已领取</li></ul>';
                }
            }else{
                //暂无数据
                parent::$_VArray['prizeList'] = '<div style="height: 3rem;width: 100%;line-height: 3rem;text-align: center">暂无数据</div>';
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
        parent::$_VArray['urlWithdrawals'] = '/app/Activity/TCOA026';
        $view = View::factory($this->_vv.'Activity/TC0A_026_MyPrize');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
}