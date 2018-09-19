<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 人拉人
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_PeoplePull extends Home
{
    protected $_activity = null;
    protected $_signPackage = null;
    protected $_morelimit = 10;
    //构造方法  如果已登录  直接跳转到用户页面
    public function before()
    {
        $this->_activity = Model::factory('Activity');
        parent::before();
    }
    //二期
    //发送模板到注册页面
    public function action_HomePage()
    {

        $view = View::factory($this->_vv.'PeoplePull/HomePage');
        $view->type = Gv::$type;
        $view->sharetitle = "我送你一张免息券，猛戳领取!";
        $view->text = "邀请好友  来快金  好友免息  我免单";
//        $view->img_url = "https://test31.m.timecash.cn/static/images/promotion/icon_logo.png";
        $view->img_url = Kohana::$config->load('url.communic_url.timecash_m')."static/images/promotion/icon_logo.png";


        $userId = isset(Gv::$user_id)?Gv::$user_id:0;
//        $view->url = "https://test31.m.timecash.cn/PeoplePullSharePage/Register?user_id=".$userId;
        $view->url = Kohana::$config->load('url.communic_url.timecash_m')."SharePage/Register?user_id=".$userId;

        //判断是否是微信
        if($view->type == 1){
            $view->signPackage = $this->signPackage();
            $view->client = "else";
            $reg_app = 'wechat';
        }elseif($view->type == 2){
            //判断是Android还是ios
            if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
                $view->client = "ios";
            }elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
                $view->client = "android";
            }else{
                $view->client = "else";
            }
            $reg_app = 'app';
        }else{
            //系统繁忙，请联系客服！
            $this->error('获取信息失败!');
            die;
        }


        //浏览统计
        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        $ip = explode(",",$ip)[0];
        if($this->_activity->get_statistics(array('ip'=>trim($ip),'action'=>'look','event_name'=>'TCOA_007_LOOK'),'ac_count')){
            $this->_activity->insert_statistics(array('action'=>'look','ip'=>trim($ip),'create_time'=>time(),'event_name'=>'TCOA_007_LOOK','reg_app'=>$reg_app),'ac_count');
        }


        if(Valid::not_empty(Gv::$user_id)){
            $view->islogin = true;
            if(Gv::$type == 1){
                $view->urlSubmit = 'javascript:clickSubmit();bomob_screen.showMask(true);';
                $app = $this->getapp();
            }elseif(Gv::$type == 2){
                $view->urlSubmit = 'javascript:sendToAndroid();';
                $app = $this->getappapp($this->_app_session['token']);
            }else{
                $this->error('获取信息失败!');
            }
            $variable = array(
                "app"=>$app
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('InviterCoin','Info','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                if(isset($result['result']['invited_num'])&&$result['result']['invited_num']>0){
                    //邀请好友个数
                    $view->inviter = $result['result']['invited_num'];
                    //赚的现金
                    $view->cash = isset($result['result']['total'])?$result['result']['total']:0;
                    if(isset($result['result']['list'])&&!empty($result['result']['list'])){
                        $view->listData = '';
                        foreach ($result['result']['list'] as $key=>$val){
                            $view->listData .= '<ul class="ulcss"><li>'.$val['invited_mobile'].'</li><li>'.$val['action'].'</li><li>'.$val['coin'].'元</li></ul>';
                        }
                        if($result['result']['invited_num']>10){
                            $view->listData .= '<span class="morePeople"><a href="/PeoplePull/MorePeople">显示所有</a></span>';
                        }else{
//                            $view->listData .= '<span><a href="javascript:;" style="color: #20163e">再无更多信息</a></span>';
                            $view->listData .= '<span class="morePeople"><a href="javascript:;"></a></span>';
                        }
                    }else{
                        //基本不走这里
                        //邀请好友个数
                        //赚的现金
                        $view->listData = '<span class="left-span nodate">邀请记录为空呦，赶快去邀请吧！</span>';
                    }
                }else{
                    //邀请好友个数
                    $view->inviter = 0;
                    //赚的现金
                    $view->cash = 0;
                    $view->listData = '<span class="left-span nodate">邀请记录为空呦，赶快去邀请吧！</span>';
                }
            }else{
                if(isset($result['code'])){
                    exit(json_encode(array('status' =>false,'msg'=>$result['message'])));
                }else{
                    //系统繁忙，请联系客服！
                    exit(json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy'))));
                }
            }
        }else{
            //未登录
            //保存登录地点
            $this->_session->sessionSet('activity','/'.$this->_controller.'/'.$this->_action);
            //列表
            $view->listData = '<span class="left-span nodate">邀请记录为空呦，赶快去邀请吧！</span>';
            //邀请好友个数
            $view->inviter = 0;
            //赚的现金
            $view->cash = 0;
            $view->urlSubmit = "javascript:clickSubmit();location.href='/Login?jump=BannerUserLogin'";
//            $view->urlSubmit = "/?jump=BannerUserLogin";
//            $view->urlSubmit = '/Login?jump=no';
            $view->islogin = false;

        }
        $this->response->body($view);
    }

    //查看更多
    public function action_MorePeople()
    {
        $view = View::factory($this->_vv.'PeoplePull/MorePeople');
        if(Valid::not_empty(Gv::$user_id)){
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
            $result = $this->_api->getApiArrays('InviterCoin','List','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                if(isset($result['result']['list'])&&!empty($result['result']['list'])){
                    if(is_array($result['result']['list'])){
                        $view->strUl = '';
                        foreach ($result['result']['list'] as $key=>$val){
                            $view->strUl .= ' <ul class="ulcss"><li>'.$val['invited_mobile'].'</li><li>'.$val['action'].'</li><li>'.$val['coin'].'元</li></ul>';
                            //最后一个id
                            $view->last_id = $val['id'];
                        }
                        if(count($result['result']['list'])>=$this->_morelimit){
                            $view->moreSubmit ='<p class="morePeople" style="font-size: .3rem;color: white;text-align: center">点击显示更多</p>';
                        }else{
                            $view->moreSubmit ='<p style="font-size: .3rem;color: white;text-align: center">没有更多记录</p>';
                        }
                    }else{
                        //异常错误！
                        $this->error(Kohana::message('wx','abnormal_error'));
                        die;
                    }
                }else{
                   //空数据
                    $view->strUl = '<span class="left-span">邀请记录为空呦，赶快去邀请吧！</span>';
                    $view->moreSubmit ='';
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
            //未登录情况下返回邀请页面
            $this->redirect('/PeoplePull/HomePage');
        }
        $this->response->body($view);
    }

}