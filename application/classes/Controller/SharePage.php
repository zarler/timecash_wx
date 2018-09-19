<?php defined('SYSPATH') or die('No direct script access.');
/*
 *分享到微信端的页面
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
class Controller_SharePage extends WxHome {
	public function before()
	{
		parent::before();
	}
	//邀请进入注册页面
	public function action_Register()
	{
		$view = View::factory($this->_vv.'SharePage/Register');
		$view->type = Gv::$type;

		//判断是否用户绑定信息
		if(isset(Wxgv::$userinfo['user_id'])&&!empty(Wxgv::$userinfo['user_id'])){
			$this->redirect('PeoplePull/HomePage');
			die;
		}
		//处理微信授信完跳转问题
		if(isset($_GET['user_id'])&&!empty($_GET['user_id'])&&Valid::alpha_numeric($_GET['user_id'])){
//			Tool::factory('Debug')->D(11111111);
			$this->_session->sessionDelete('ACT_GET');
			$userId = $_GET['user_id'];
		}else{
			//传入分享用户的用户id()
			$actGet = $this->_session->sessionGet('ACT_GET');
			if(!empty($actGet)){
				$actGet = json_decode($actGet,true);
				if(isset($actGet['user_id'])){
//					$this->_session->sessionDelete('ACT_GET');
					$userId = $actGet['user_id'];
//					Tool::factory('Debug')->D($userId);

				}else{
					$this->redirect('PeoplePull/HomePage');
					die;
				}
			}else{
				$this->redirect('PeoplePull/HomePage');
				die;
			}

		}
//		Tool::factory('Debug')->D($userId);
		$view->userId = $userId;
//		Tool::factory('Debug')->D(Wxgv::$userinfo);
		$this->response->body($view);
	}
	//邀请好友分享页面
	public function action_InvitationShare()
	{
		$view = View::factory($this->_vv.'SharePage/InvitationShare');
		$view->type = Gv::$type;
		$view->sharetitle = "我送你一张免息券，猛戳领取!";
		$view->text = "邀请好友  来快金  好友免息  我免单";
		$view->img_url = Kohana::$config->load('url.communic_url.timecash_m')."static/images/promotion/icon_logo.png";
		$userId = isset(Wxgv::$userinfo['user_id'])?Wxgv::$userinfo['user_id']:(isset($_GET['user_id'])?$_GET['user_id']:0);
		$view->url = Kohana::$config->load('url.communic_url.timecash_m')."SharePage/Register?user_id=".$userId;
		$view->signPackage = $this->signPackage();
		//用传过来的用户id来判断是否能分享出去
		if($userId>0){
			$view->islogin = true;
		}else{
			$view->islogin = false;
		}

		if(isset($_GET['coupons'])&&$_GET['coupons']==0){
			$view->showMsg = '<strong>您暂不符合领取规则!</strong></br><strong>赶快去借款!</strong>';
		}else{
			$view->showMsg = '<strong>恭喜!免息优惠券已到账!</strong></br><strong>赶快去借款!</strong>';
		}

		$view->imgUrl = $this->wxconfig()->img2weima(101,true);;
		$view->title = '邀请好友赚现金';
		$view->urlSubmit = 'javascript:bomob_screen.showMask(true)';
		$this->response->body($view);
	}

}
