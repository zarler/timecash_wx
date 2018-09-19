<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 活动页面
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_H5_Activity extends Common
{
    //浏览统计数组
    protected $_RecordVisit = null;

    //互动变量
    public static $_VArray = null;
    //构造方法  如果已登录  直接跳转到用户页面
    public function before()
    {
        parent::before();

    }
    /************************************************************************************************************************************
     * 还款活动(TC0A-020)
     ************************************************************************************************************************************/
    public function action_TC0A020()
    {
        $view = View::factory($this->_vv.'Activity/TC0A_020');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    //列表
    public function action_TC0A020List()
    {
        $view = View::factory($this->_vv.'Activity/TC0A_020_List');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    /************************************************************************************************************************************
     * 分期推广
     ************************************************************************************************************************************/
    public function action_StagingExtension(){
//        parent::$_VArray['resultAtt'] = $resultAtt;
        $view = View::factory($this->_vv.'Activity/StagingExtension');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    /************************************************************************************************************************************
     * 快神卡公告
     ************************************************************************************************************************************/
    public function action_TCOA023(){


//        Tool::factory('Debug')->D(parent::$_VArray);
//        parent::$_VArray['resultAtt'] = $resultAtt;
        $view = View::factory($this->_vv.'Activity/TC0A_023');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    /************************************************************************************************************************************
     * 跳转
     ************************************************************************************************************************************/
    public function action_TCOA024(){
        $this->redirect('');
    }
    /************************************************************************************************************************************
     * 邀请好友，提现金
     ************************************************************************************************************************************/
    public function action_TCOA026(){
        parent::$_VArray['invitedList'] = null;
        $tokenArr = Cookie::get("tokenArr");
        if(Valid::not_empty($tokenArr)){
            $tokenArr = json_decode($tokenArr,true);
            if(isset($tokenArr['token'])&&Valid::not_empty($tokenArr['token'])){
                $variable = array(
                    "app"=>$this->getH5Info($tokenArr['token'])
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
            }else{
                //异常错误！
               // $this->error(Kohana::message('wx','abnormal_error'));
            }
        }else{
            //异常错误！
            //$this->error(Kohana::message('wx','abnormal_error'));
        }
        parent::$_VArray['UrlInvitation'] = ' /Promotion/';
        $view = View::factory($this->_vv.'Activity/TC0A_026_Example');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

    //推广页面
    public function action_TCOA026T(){
        parent::$_VArray['UrlInvitation'] = ' /Promotion/';
        parent::$_VArray['invitedList'] = null;
        $listData = array(
            0=>array(
                'mobile'=>'135****3920','num'=>34
            ),
            1=>array(
                'mobile'=>'152****7642','num'=>33
            ),
            2=>array(
                'mobile'=>'136****7720','num'=>29
            ),
            3=>array(
                'mobile'=>'138****0897','num'=>28
            ),
            4=>array(
                'mobile'=>'136****6531','num'=>28
            ),
            5=>array(
                'mobile'=>'130****0863','num'=>27
            ),
            6=>array(
                'mobile'=>'186****7966','num'=>26
            ),
            7=>array(
                'mobile'=>'152****4721','num'=>24
            ),
            8=>array(
                'mobile'=>'185****9730','num'=>7
            ),
            9=>array(
                'mobile'=>'183****9227','num'=>3
            )

        );
        foreach ($listData as $key=>$val){
            $key++;
            parent::$_VArray['invitedList'] .= '<li><span class="span1">'.$key.'</span><span class="span2">'.$val['mobile'].'</span><span class="span3">'.$val['num'].'人</span></li>';
        }

        $view = View::factory($this->_vv.'Activity/TC0A_026_Example');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }



    //赚钱攻略
    public function action_TCOA026Raiders(){
        //look_r为首页
        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR'])&&$_SERVER['HTTP_X_FORWARDED_FOR']?$_SERVER['HTTP_X_FORWARDED_FOR']:(isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'');
        $_ip = explode(",",$ip)[0];
        //判断是Android还是ios
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
                $client = "wechat";
            }else{
                $client = "ios";
            }
            //$view->url = 'http://mp.weixin.qq.com/mp/redirect?url='.urlencode('https://itunes.apple.com/cn/app/kuai-jin/id1130326523?mt=8');
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
                $client = "wechat";
            }else{
                $client = "android";
            }
        }else{
            $client = "wechat";
        }
        $recordVisit = array('action'=>'look_r', 'event_name'=>'TCOA_026', 'reg_app'=>$client, 'table'=>'ac_count');
        Model::factory('Activity')->insert_statistics(array('action'=>$recordVisit['action'],'ip'=>$_ip,'create_time'=>time(),'event_name'=>$recordVisit['event_name'],'reg_app'=>$recordVisit['reg_app']),$recordVisit['table']);
        $view = View::factory($this->_vv.'Activity/TC0A_026_Raiders');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    //我的奖品
    public function action_TCOA026MyPrize(){
        $view = View::factory($this->_vv.'Activity/TC0A_026_MyPrize');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    //邀请记录
    public function action_TCOA026Record(){
        $view = View::factory($this->_vv.'Activity/TC0A_026_Record');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
    /************************************************************************************************************************************
     * 邀请好友，提现金
     ************************************************************************************************************************************/
    //被邀请页面
    public function action_TCOA026BeInvited(){
//        $this->ip_limit();
//        Cookie::delete("tokenArr");
//        Cookie::delete("inviterUserId");
//        die;
        //申请token
        $tokenArr = Cookie::get("tokenArr");
        $userId = Cookie::get("userId");
        //流量统计(按照ip统计)
        $this->_RecordVisit = array('action'=>'look_i', 'event_name'=>'TCOA_026', 'reg_app'=>'h5', 'table'=>'ac_count');
        Model::factory('Activity')->insert_statistics(array('user_id'=>(Valid::not_empty($userId))?$userId:null,'action'=>$this->_RecordVisit['action'],'ip'=>$this->_ip,'create_time'=>time(),'event_name'=>$this->_RecordVisit['event_name'],'reg_app'=>$this->_RecordVisit['reg_app']),$this->_RecordVisit['table']);

//        Cookie::delete("tokenArr");
        if(Valid::not_empty($tokenArr)){
            $tokenArr = json_decode($tokenArr,true);
            if(isset($tokenArr['expire_in'])&&($tokenArr['expire_in']<time())){
                //token必须也用户同时失效
                Cookie::delete("userId");
                $json = json_encode(array('app'=>$this->getH5Info()));
                $result = Tool::factory('API')->getApiArrays('Token','Create',"",array('json'=>$json));
                if(isset($result['code'])&&$result['code']==1000){
                    $result['result']['expire_in'] = time()+$result['result']['expire_in'];
                    Cookie::set("tokenArr",json_encode($result['result']));
                    $tokenArr = $result['result'];
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
            }
        }else{
            Cookie::delete("userId");
            $json = json_encode(array('app'=>$this->getH5Info()));
            $result = Tool::factory('API')->getApiArrays('Token','Create',"",array('json'=>$json));
            if(isset($result['code'])&&$result['code']==1000){
                $result['result']['expire_in'] = time()+$result['result']['expire_in'];
                Cookie::set("tokenArr",json_encode($result['result']));
                $tokenArr = $result['result'];
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
        }
        parent::$_VArray['have_draw'] = '您有1次抽奖机会';
        //判断是否登录注册
        $userId = Cookie::get("userId");
        if(Valid::not_empty($userId)){
            parent::$_VArray['subMit'] = "alert('异常错误');";
            parent::$_VArray['UrlFree'] = "alert('异常错误');";
            //抽奖
            parent::$_VArray['reqUrl'] = '/h5/FunctionsAct/026LuckDraw';
            //领免息券
            parent::$_VArray['couponsurl'] = '/h5/FunctionsAct/026Coupons';

            $variable = array(
                "app" => $this->getH5Info($tokenArr['token'])
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('AC_TCOA026', 'HaveChance', '', array('json' => $json_info));
//            Tool::factory('Debug')->D(array($variable,$result));

            if (isset($result) && $result['code'] == 1000) {
                if(isset($result['result'])&&Valid::not_empty($result['result'])){
                    if(isset($result['result']['have_draw'])&&$result['result']['have_draw']==0){
                        parent::$_VArray['have_draw'] = '您有1次抽奖机会';
                        parent::$_VArray['subMit'] = "subMit();";
                    }else{
                        parent::$_VArray['have_draw'] = '您有0次抽奖机会';
                        parent::$_VArray['subMit'] = "$('.user').show();";
                    }
                    if(isset($result['result']['have_coupon'])&&$result['result']['have_coupon']==0){
                        parent::$_VArray['have_coupon'] = $result['result']['have_coupon'];
                        parent::$_VArray['UrlFree'] = "Coupons();";
                    }else{
                        parent::$_VArray['have_coupon'] = $result['result']['have_coupon'];
                        parent::$_VArray['UrlFree'] = "$('.user').show();";
                    }

//                    Tool::factory('Debug')->D(array($result,parent::$_VArray));



                }else{
                    $this->error(Kohana::message('wx', 'system_busy'));
                }
            } else {
                if (isset($result['code'])) {
                    $this->error($result['message']);
                } else {
                    //系统繁忙，请联系客服！
                    $this->error(Kohana::message('wx', 'system_busy'));
                }
            }
        }else{
            parent::$_VArray['subMit'] = 'subRegister();';
            //领奖
            parent::$_VArray['UrlFree'] = 'subRegister();';

            //微信刷新函数屏蔽
            parent::$_VArray['homeUrl'] = Kohana::$config->load('url.communic_url.timecash_m').'h5/Activity/TCOA026BeInvited';
        }

        //记录邀请人
        if(isset($_GET['userId'])&&Valid::not_empty($_GET['userId'])){
            Cookie::set("inviter_user_id",$_GET['userId']);
            $inviter_user_id = $_GET['userId'];
        }else{
            $inviter_user_id = Cookie::get("inviter_user_id");
        }

        parent::$_VArray['inviterUserId'] = Valid::not_empty($inviter_user_id)?$inviter_user_id:null;

//        echo Cookie::salt("abc","def");#得到保存到客户端的字符
//        echo Cookie::get("abc");
//        Cookie::set("abc","def");
//        Cookie::delete("abc");

//        Cookie::set("abc","def");
//        echo Cookie::get("abc");
//
//        echo '是不是很惊喜,是不是很意外！';
//        die;
        parent::$_VArray['title'] = '抽奖赢现金 更有iphone等你来';
        //验证码
        parent::$_VArray['codeurl'] = '/h5/FunctionsAct/VerificationCode';
        //注册
        parent::$_VArray['repayurl'] = '/h5/FunctionsAct/Register';
        $view = View::factory($this->_vv.'Activity/TC0A_026_Invitation');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

}