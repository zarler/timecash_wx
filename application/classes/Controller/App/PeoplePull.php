<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 人拉人
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_App_PeoplePull extends AppHome
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

        echo '活动已下线';
        die;


        //判断是Android还是ios
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            parent::$_VArray['client'] = "ios";
        }elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            parent::$_VArray['client'] = "android";
        }else{
            parent::$_VArray['client'] = "app";
        }
        //浏览统计
        if($this->_activity->get_statistics(array('ip'=>trim($this->_ip),'action'=>'look','event_name'=>'TCOA_007_LOOK'),'ac_count')){
            $this->_activity->insert_statistics(array('action'=>'look','ip'=>trim($this->_ip),'create_time'=>time(),'event_name'=>'TCOA_007_LOOK','reg_app'=>parent::$_VArray['client']),'ac_count');
        }
        if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])){
            parent::$_VArray['sharetitle'] = "我送你一张免息券，猛戳领取!";
            parent::$_VArray['text'] = "邀请好友  来快金  好友免息  我免单";
            parent::$_VArray['img_url'] = Kohana::$config->load('url.communic_url.timecash_m')."static/images/promotion/icon_logo.png";
            parent::$_VArray['url'] = Kohana::$config->load('url.communic_url.timecash_m')."wx/SharePage/RegisterPeoplePull?user_id=".Gv::$_userInfo['user_id'];
            parent::$_VArray['urlSubmit'] = 'javascript:sendToAndroid();';

            parent::$_VArray['islogin']= true;
            $variable = array(
                "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('InviterCoin','Info','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                if(isset($result['result']['invited_num'])&&$result['result']['invited_num']>0){
                    //邀请好友个数
                    parent::$_VArray['inviter'] = $result['result']['invited_num'];
                    //赚的现金
                    parent::$_VArray['cash'] = isset($result['result']['total'])?$result['result']['total']:0;
                    if(isset($result['result']['list'])&&!empty($result['result']['list'])){
                        parent::$_VArray['listData'] = '';
                        foreach ($result['result']['list'] as $key=>$val){
                            parent::$_VArray['listData']  .= '<ul class="ulcss"><li>'.$val['invited_mobile'].'</li><li>'.$val['action'].'</li><li>'.$val['coin'].'元</li></ul>';
                        }
                        if($result['result']['invited_num']>10){
                            parent::$_VArray['listData']  .= '<span class="morePeople"><a href="/app/PeoplePull/MorePeople">显示所有</a></span>';
                        }else{
                            parent::$_VArray['listData']  .= '<span class="morePeople"><a href="javascript:;"></a></span>';
                        }
                    }else{
                        //基本不走这里
                        //邀请好友个数
                        //赚的现金
                        parent::$_VArray['listData']  = '<span class="left-span nodate">邀请记录为空呦，赶快去邀请吧！</span>';
                    }
                }else{
                    //邀请好友个数
                    parent::$_VArray['inviter']  = 0;
                    //赚的现金
                    parent::$_VArray['cash']  = 0;
                    parent::$_VArray['listData']  = '<span class="left-span nodate">邀请记录为空呦，赶快去邀请吧！</span>';
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
            parent::$_VArray['listData']  = '<span class="left-span nodate">邀请记录为空呦，赶快去邀请吧！</span>';
            //邀请好友个数
            parent::$_VArray['inviter']  = 0;
            //赚的现金
            parent::$_VArray['cash']  = 0;
            parent::$_VArray['urlSubmit']  = "javascript:clickSubmit();location.href='/Login?jump=BannerUserLogin'";
            parent::$_VArray['urlSubmit'] =false;
        }
        parent::$_VArray['reqUrls'] = '/app/FunctionsAct/statisticsUserIdIp';
        $view = View::factory($this->_vv.'PeoplePull/HomePage');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

    //查看更多
    public function action_MorePeople()
    {
        if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])){
            $variable = array(
                "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('InviterCoin','List','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                if(isset($result['result']['list'])&&!empty($result['result']['list'])){
                    if(is_array($result['result']['list'])){
                        parent::$_VArray['strUl'] = '';
                        foreach ($result['result']['list'] as $key=>$val){
                            parent::$_VArray['strUl'] = ' <ul class="ulcss"><li>'.$val['invited_mobile'].'</li><li>'.$val['action'].'</li><li>'.$val['coin'].'元</li></ul>';
                            //最后一个id
                            parent::$_VArray['last_id'] = $val['id'];
                        }
                        if(count($result['result']['list'])>=$this->_morelimit){
                            parent::$_VArray['moreSubmit'] = '<p class="morePeople" style="font-size: .3rem;color: white;text-align: center">点击显示更多</p>';;
                        }else{
                            parent::$_VArray['moreSubmit'] = '<p style="font-size: .3rem;color: white;text-align: center">没有更多记录</p>';
                        }
                    }else{
                        //异常错误！
                        $this->error(Kohana::message('wx','abnormal_error'));
                        die;
                    }
                }else{
                   //空数据
                    parent::$_VArray['strUl'] ='<span class="left-span">邀请记录为空呦，赶快去邀请吧！</span>';
                    parent::$_VArray['moreSubmit'] ='';
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
            //未登录情况下返回邀请页
            $this->redirect('/app/PeoplePull/HomePage');
        }
        $view = View::factory($this->_vv.'PeoplePull/MorePeople');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }

}