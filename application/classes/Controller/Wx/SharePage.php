<?php defined('SYSPATH') or die('No direct script access.');
/*
 *分享到微信端的页面
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
class Controller_Wx_SharePage extends WxHome {
	public function before()
	{
		parent::before();
	}
	public function action_RegisterPeoplePull()
	{
		//判断是否用户绑定信息
//		if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])){
//			$this->redirect('wx/PeoplePull/HomePage');
//			die;
//		}
		//处理微信授信完跳转问题
//		if(isset($_GET['user_id'])&&!empty($_GET['user_id'])&&Valid::alpha_numeric($_GET['user_id'])){
//			Tool::factory('Debug')->D(11111111);
//			$this->_session->sessionDelete('ACT_GET');
//            parent::$_VArray['userId'] = $_GET['user_id'];
//		}else{
//			//传入分享用户的用户id()
//			$actGet = $this->_session->sessionGet('ACT_GET');
//			if(!empty($actGet)){
//				$actGet = json_decode($actGet,true);
//				if(isset($actGet['user_id'])){
////					$this->_session->sessionDelete('ACT_GET');
//                    parent::$_VArray['userId'] = $actGet['user_id'];
////					Tool::factory('Debug')->D($userId);
//				}else{
//					$this->redirect('wx/PeoplePull/HomePage');
//					die;
//				}
//			}else{
//				$this->redirect('wx/PeoplePull/HomePage');
//				die;
//			}
//		}

//        parent::$_VArray['codeUrl'] = '/wx/Functions/acRegistersendcode';
//        parent::$_VArray['reqUrl'] = '/wx/Functions/peoplePullDoregister';

//        parent::$_VArray['codeUrl'] = '';
//        parent::$_VArray['reqUrl'] = '';

        $view = View::factory($this->_vv.'SharePage/Register');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
	}
	//邀请好友分享页面
	public function action_InvitationShare()
	{
//        parent::$_VArray['sharetitle'] = "我送你一张免息券，猛戳领取!";
//        parent::$_VArray['text'] = "邀请好友  来快金  好友免息  我免单";
//        parent::$_VArray['img_url'] = Kohana::$config->load('url.communic_url.timecash_m')."static/images/promotion/icon_logo.png";
//        $userId = isset(Gv::$_userInfo['user_id'])?Gv::$_userInfo['user_id']:(isset($_GET['user_id'])?$_GET['user_id']:0);
//        parent::$_VArray['url'] =  Kohana::$config->load('url.communic_url.timecash_m')."SharePage/Register?user_id=".$userId;
//        parent::$_VArray['signPackage'] = $this->signPackage();
//		//用传过来的用户id来判断是否能分享出去
//		if($userId>0){
//            parent::$_VArray['islogin'] = true;
//		}else{
//            parent::$_VArray['islogin'] = true;
//		}
//		if(isset($_GET['coupons'])&&$_GET['coupons']==0){
//            parent::$_VArray['showMsg'] = '<strong>您暂不符合领取规则!</strong></br><strong>赶快去借款!</strong>';
//		}else{
//            parent::$_VArray['showMsg'] = '<strong>恭喜!免息优惠券已到账!</strong></br><strong>赶快去借款!</strong>';
//		}
//        parent::$_VArray['imgUrl'] = $this->wxconfig()->img2weima(101,true);
//        parent::$_VArray['title'] = '邀请好友赚现金';
//        parent::$_VArray['urlSubmit'] = 'javascript:bomob_screen.showMask(true)';

        $view = View::factory($this->_vv.'SharePage/InvitationShare');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
	}

}
