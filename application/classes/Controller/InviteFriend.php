<?php 
	defined('SYSPATH') or die ('No direct script access.');


/**
 * Class Controller_InviteFriend
 * 邀请好友送红包页面
 *
 */

	class Controller_InviteFriend extends Controller{
        protected $signPackage = null;
        //构造方法  如果已登录  直接跳转到用户页面
        public function before()
        {
            parent::before();
            $this->activity = Model::factory('Activity');
            //$this->signPackage = $this->signPackage();
        }
        public function action_index(){
            $view = View::factory('Activity/InviteFriend');
           // 判断是否是微信
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
                //判断用户是否登录
                if(!isset(Gv::$user_id) or !Valid::not_empty(Gv::$user_id)){
                    //echo json_encode(array('status'=>false,'msg'=>'未登录~！'));
                    //die;
                }
                $view->is_weixin =  true;
            }else{
                $view->is_weixin =  false;
            }


			//判断是Android还是ios
			if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
				$view->client = "ios";
				//$view->url = 'http://mp.weixin.qq.com/mp/redirect?url='.urlencode('https://itunes.apple.com/cn/app/kuai-jin/id1130326523?mt=8');
			}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
				$view->client = "android";
			}else{
				$view->client = "else";
			}

            //获取活动主题、内容、图片地址、活动链接等
            $view->title = "邀请好友送红包";   //分享标题
            $view->text = "1111111111111111111111111111111";    //分享描述
            $view->img_url = "http://verify.joybill.net/banner/top-banner/1.png";   //分享图片
            $view->url = "http://test22.m.timecash.cn/Activity/shareInvitation";   //分享地址

            //$view->signPackage = $this->signPackage;
            $this->response->body($view);
		}

	}