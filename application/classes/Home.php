<?php defined('SYSPATH') or die('No direct script access.');
	/*
	登录验证的通用类
	还包括了几个登录后的通用方法
 *
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($card_no, APPPATH.'../static/liu_test.php');
 *
 * 
	*/
    class Home extends Common {
        //重写构造方法
		protected $_log_enable = FALSE;
		protected $_log=NULL;
		protected $site_config = NULL;
		protected static $arr_step = NULL;
		protected  $_app_session = null;
		protected  $_app_session_sign = 0;
		
        public function before(){
			parent::before();
			$this->_model['user'] = Model::factory('User');
			//自定义session不可更改(定制,独立于其他session)
			$this->_model['session'] = Libs::factory('Session');
			$this->_model['credit'] = Model::factory('Credit');
			//消除上个账号的缓存(说明第一次进来)
			if(isset($_GET['target_token'])&&Valid::not_empty($_GET['target_token'])&&$_GET['target_token']!='{target_token}'){
				$this->_model['session']->sessionDelete('session_id');
			}else{
				//如果是微信banner进来的,删除后面的get后缀(解决banner页面进来,ios不能分享的问题)
				if(isset($_GET['target_token'])&&$_GET['target_token']=='{target_token}'){
					$this->redirect('/'.$this->_controller.'/'.$this->_action);
					die;
				}
			}
			//微信上测试app交互
			//$_GET['target_token'] = 'TO20170324173119BtypClZaRYnmdZAjMPebrCSOFOJsEliHUeMRRCjpaHUBakik';
			//微信授权 拿到Pid 到数据库查询  如果存在就跳转到用户中心  不存在到注册页面 保存着过来用户的基本信息
			$this->_app_session = $this->_model['session']->get('session_id');
			//$_GET['target_token'] = 'TO20170324122856SqUBVldKBJBFzvuMHpUglKQovnQuIIzwRaZgibBoqADiSIdY';
			//如果存在用户信息直接调取（app不是第一次进来）
			if(Valid::not_empty($this->_app_session['token'])&&Valid::not_empty($this->_app_session['user_id'])){
//			if(Valid::not_empty($this->_app_session['token'])&&Valid::not_empty($this->_app_session['user_id']&&!isset($_GET['target_token']))){
				//更新授信信息
				$variable = array(
					"app"=>$this->getappapp($this->_app_session['token'])
				);
				$json_info = json_encode($variable);
				$result_info = $this->_api->getApiArrays('CreditInfo','Step','',array('json'=>$json_info));
				if(isset($result_info) && $result_info['code']==1000){
					try{
						//开启事务
						Database::instance()->begin();
						//保存授信情况
						$result_info['result']['credit_info']['step']['user_id'] = $this->_app_session['user_id'];
						$result_info['result']['credit_info']['step']['has_fastloan_order'] = $result_info['result']['has_fastloan_order'];
						Model::factory('Credit')->insert_update_creditStep($result_info['result']['credit_info']['step']);
						//由于没有定制session里面(status)直接加入Gv里面
						Gv::init(array('app_token' => $this->_app_session['token'], 'status'=>$result_info['result']['user']['status'],'user_id' => $this->_app_session['user_id'], 'mobile' => $this->_app_session['mobile'], 'type' => 2));
						Database::instance()->commit();
					}catch(Exception $e){
						Database::instance()->rollback();
						exit($e->getMessage());
					}
					Gv::$Log = true;
				}else{
					if(isset($result_info['code'])){
						if($result_info['code'] == 2020){
							//未登陆
						}else{
							$this->error($result_info['message']);
							die;
						}
//						$this->error($result_info['message']);
//						die;
					}else{
						//系统繁忙，请联系客服！
						$this->error(Kohana::message('wx','system_busy'));
						die;
					}
				}
			}else{
				if(isset($_GET['target_token'])&&Valid::not_empty($_GET['target_token'])&&$_GET['target_token']!='{target_token}'){
					//app第一次来到H5页面
//					$this->_model['session']->sessionDelete('session_id');

					$this->get_apptoken($_GET['target_token']);
				}else{
					//兼容未登录下app用户
					//通过是否是微信浏览器来判断是否
					if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
						//微信暂时不进行授信管理
	//					$this->error(Kohana::message('wx','cannot_credit'));
	//					die;
						//微信第一次来（活动进来没有api_token，需要去申请接口获取）
						$api_token = $this->_session->sessionGet('api_token');
						$openid = $this->_session->sessionGet('wx')['openid'];
						//					$this->session->Delete();
	//					die;
						//正常微信进入授权页面（暂时作废，微信不进行授权）
						if(Valid::not_empty($api_token) && Valid::not_empty($openid)){
							$userInfo = $this->_model['user']->get_basic_userinfo_field('user_id,nickname,headimgurl,wechat_passport,status,credited',$openid);
							if(!isset($userInfo['user_id'])||empty($userInfo['user_id'])){
								//如果手动删除微信表里的数据
								$this->_session->sessionDelete('api_token');
								$api_token = null;
//								$this->redirect('/'.$this->_controller.'/'.$this->_action.'?target_token={target_token}&d={device_id}');
//								die;
							}else{
								//获取用户授权信息
								$variable = array(
									"app"=>$this->getapp()
								);
								$json_info_step = json_encode($variable);

								$result = $this->_api->getApiArrays('CreditInfo','Step','',array('json'=>$json_info_step));


								if(isset($result['code']) && $result['code']==1000){
									//修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
									try {
										//开启事务
										Database::instance()->begin();
										$result['result']['credit_info']['step']['user_id'] = $userInfo['user_id'];
										$result['result']['credit_info']['step']['has_fastloan_order'] = $result['result']['has_fastloan_order'];
										Model::factory('Credit')->insert_update_creditStep($result['result']['credit_info']['step']);
										Gv::init(array('credited'=>$result['result']['user']['credit_auth'],'api_token'=>$api_token,'type'=>1,'user_id'=>isset($userInfo['user_id'])?$userInfo['user_id']:null,'status'=>isset($result['result']['user']['status'])?$result['result']['user']['status']:null));
										Database::instance()->commit();
									} catch (Exception $e) {
										Database::instance()->rollback();
										exit($e->getMessage());
									}
									Gv::$Log = true;
								}else{
									if(isset($result['code'])){
										if($result['code'] == 2020){
											//未登陆(快速登录)
											//进行快速登陆,判断是否有wechat_passport值来判断能否快速登陆
											if(Valid::not_empty($userInfo['wechat_passport'])){
												//快速登陆
												$variable = array(
													"openid"=>$openid,
													"passport"=>Libs::factory('AES126')->encrypt($userInfo['wechat_passport'],$this->_api_config['wx']['app_key']),
													"app"=>$this->getapp()
												);
												$json_info = json_encode($variable);
												
												$result = $this->_api->getApiArrays('Wechat','Login','',array('json'=>$json_info));
												if(isset($result) && $result['code']==1000){
													//修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
													$result = $this->_api->getApiArrays('CreditInfo','Step','',array('json'=>$json_info_step));
													if(isset($result['code']) && $result['code']==1000){
														//修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
														try {
															//开启事务
															Database::instance()->begin();
															$result['result']['credit_info']['step']['user_id'] = $userInfo['user_id'];
															$result['result']['credit_info']['step']['has_fastloan_order'] = $result['result']['has_fastloan_order'];
															Model::factory('Credit')->insert_update_creditStep($result['result']['credit_info']['step']);
															Gv::init(array('credited'=>$result['result']['user']['credit_auth'],'api_token'=>$api_token,'type'=>1,'user_id'=>isset($userInfo['user_id'])?$userInfo['user_id']:null,'status'=>isset($result['result']['user']['status'])?$result['result']['user']['status']:null));
															Database::instance()->commit();
														} catch (Exception $e) {
															Database::instance()->rollback();
															exit($e->getMessage());
														}
														Gv::$Log = true;
													}else{
														//防止死循环直接过掉
														Gv::$Log = false;
													}
													//$this->updateUserInfo($result_info,$userInfoDb['headimgurl'],$userInfoDb['wechat_username'],$json_info);
												}else{
													if(isset($result['code'])){
														//删除用户信息id,结果没有删除微信专用id,出现'用户查询数据异常'现象
														if($result['code'] == 5018){
															//删除id和快速登录字段
															$this->_user->set_user_wechat_info(array('user_id'=>NULL,'wechat_passport'=>NULL),Wxgv::$wx['openid']);
															$this->redirect('/User/Index');
															die;
														}elseif($result['code'] == 5025){
															//openid失效
															//$this->user->set_user_wechat_info(array('user_id'=>NULL,'wechat_passport'=>NULL,'token'=>NULL),Wxgv::$wx['openid']);
															$this->redirect('/User/Index');
															die;
														}else{
															$this->error($result['message']);
															die;
														}
													}else{
														//系统繁忙，请联系客服！
														$this->error(Kohana::message('wx','system_busy'));
														die;
													}
												}
											}else{
												//使其进入登陆页面进行注册登陆
												Wxgv::$login = false;
											}
										}else{
											$this->error($result['message']);
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
						//判断$api_token是否为空（获得需要判断是否注册或者登陆）
						if(!Valid::not_empty($api_token)&&Valid::not_empty($openid)){
							//申请token
							//没有token或者过期直接申请新token
							$result = $this->getFirstToken();
							if(isset($result['code'])&&$result['code']==1000){
								//修改用户信息
								if(Valid::not_empty($openid)){
									Gv::init(array('api_token'=>$result['result']['token'],'type'=>1));
									$result['result']['expire_in'] = $result['result']['expire_in']+time();
									$this->_user->set_user_wechat_info($result['result'],$openid);
									//对应上面获取
									$this->_session->sessionSet('api_token',$result['result']['token']);
									//从新请求进行标示
									$this->_app_session_sign = 1;
									//在未授权下直接打开文档,下面的定义决定用户去授信
								}
							}else{
								if(isset($result['code'])){
									$this->error($result['message']);
									die;
								}else{
									//网络错误
									$this->error(Kohana::message('wx','network_error'));
									die;
								}
							}
						}
						Gv::$type = 1;
					}else{
						//app未登录用户,开了个口,(app不带target_token进来的路径),其他浏览器也可以访问活动及降担保授信申请,api3可以限制住,不知道会有什么副作用(呵呵)
						Gv::$type = 2;
						//非法请求
//						$this->error(Kohana::message('wx','illegal_request'));
//						die;
					}
				}
			}
		
			if(!isset(Gv::$user_id)||!Valid::not_empty(Gv::$user_id)){
				if(Gv::$type==2){
					//未登陆
//					$this->error(Kohana::message('wx','validation_failure'),'app');
//					die;
				}elseif(Gv::$type==1){
					if(!isset($openid)||!Valid::not_empty($openid)){
						//授权失效
						//获取微信的各项配置信息（微信获得专用通道，获取授权）（活动）
						Wxgv::$wx = $this->_session->sessionGet('wx');
						if(!Valid::not_empty(Wxgv::$wx['openid'])){
							$wx_config = Kohana::$config->load('site.wx');
							//导入微信sdk完成授权
							$wx = Libs::factory('vendor_wxopenid')->init($wx_config['appId'],$wx_config['appSecret'],$wx_config['callbackurl'],$wx_config['state']);
							//判断微信回调 带的参数code 和state
							if(isset($_GET["code"])&&Valid::not_empty($_GET["code"]) && $_GET["state"]=='kuaijin'){
								$code = trim($_GET["code"]);
								//通过回调返回的code值获取openid
								$callback = $wx->getOpenId($code);
								if(Valid::not_empty($callback['openid'])){
									$this->_session->sessionSet('wx',array('openid'=>$callback['openid']));
									//获取微信用户信息
									$userinfo = $wx->getUserInfo($callback['access_token'],$callback['openid']);
									//去除微信昵称上特殊图片字符
									$userinfo['nickname'] = Tool::factory('String')->removeEmoji($userinfo['nickname']);
									//修改微信表的 用户头像（防止用户改了头像  我们这里没有修改）(坑爹处)
									$this->_user->set_user_wechat_info(array("headimgurl"=>$userinfo['headimgurl'],"wechat_username"=>$userinfo['nickname']),$userinfo['openid']);
									//获取到openid以后刷新页面获取用户信息
									if(!Valid::not_empty($openid)){
										//模仿banner访问,获取最新token
										$this->redirect('/'.$this->_controller.'/'.$this->_action.'?target_token={target_token}&d={device_id}');
										die;
									}
								}else{
									//没有拿到openid 网络错误
									$this->error(Kohana::message('wx','network_error'));
									die;
								}
							}else{
								//获取微信的code并重新访问该地址(回调地址)
								//$wx->getCode('/Activity/Turntable2');exit;
								$user_id = isset($_GET['user_id'])?$_GET['user_id']:'';
								//用activity_userid保存userid信息
								if(!empty($user_id)){
									$this->_session->sessionSet('activity_userid',$user_id);
								}
								$callback_url = '/'.$this->_controller.'/'.$this->_action;
								$wx->getCode($callback_url);exit;
								//获取微信的code并重新访问该地址(回调地址)
							}
						}else{
							$userinfo['openid'] = Wxgv::$wx['openid'];
						}
					}else{
						$userInfo = $this->_model['user']->get_basic_userinfo($openid);
						//解决消除微信cookie的时候,不能更新step和快速登录问题。
						if((!isset($userInfo['user_id'])||empty($userInfo))&&$this->_app_session_sign != 1){
							//如果手动删除微信表里的数据
							$this->_session->sessionDelete('api_token');
							$api_token = null;
//								$this->redirect('/'.$this->_controller.'/'.$this->_action.'?target_token={target_token}&d={device_id}');
//								die;
						}else{
							Gv::$user_id = $userInfo['user_id'];
							//获取用户授权信息
							$variable = array(
								"app"=>$this->getapp()
							);
							$json_info_step = json_encode($variable);
							$result = $this->_api->getApiArrays('CreditInfo','Step','',array('json'=>$json_info_step));
							if(isset($result['code']) && $result['code']==1000){
								//修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
								try {
									//开启事务
									Database::instance()->begin();
									$result['result']['credit_info']['step']['user_id'] = $userInfo['user_id'];
									$result['result']['credit_info']['step']['has_fastloan_order'] = $result['result']['has_fastloan_order'];
									Model::factory('Credit')->insert_update_creditStep($result['result']['credit_info']['step']);
									Gv::init(array('credited'=>$result['result']['user']['credit_auth'],'api_token'=>$api_token,'type'=>1,'user_id'=>isset($userInfo['user_id'])?$userInfo['user_id']:null,'status'=>isset($result['result']['user']['status'])?$result['result']['user']['status']:null));
									Database::instance()->commit();
								} catch (Exception $e) {
									Database::instance()->rollback();
									exit($e->getMessage());
								}
								Gv::$Log = true;
							}else{
								if(isset($result['code'])){
									if($result['code'] == 2020){
										//未登陆(快速登录)
										//进行快速登陆,判断是否有wechat_passport值来判断能否快速登陆
										if(Valid::not_empty($userInfo['wechat_passport'])){
											//快速登陆
											$variable = array(
												"openid"=>$openid,
												"passport"=>Libs::factory('AES126')->encrypt($userInfo['wechat_passport'],$this->_api_config['wx']['app_key']),
												"app"=>$this->getapp()
											);
											$json_info = json_encode($variable);
											$result = $this->_api->getApiArrays('Wechat','Login','',array('json'=>$json_info));
											if(isset($result) && $result['code']==1000){
												//修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
												$result = $this->_api->getApiArrays('CreditInfo','Step','',array('json'=>$json_info_step));
												if(isset($result['code']) && $result['code']==1000){
													//修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
													try {
														//开启事务
														Database::instance()->begin();
														$result['result']['credit_info']['step']['user_id'] = $userInfo['user_id'];
														$result['result']['credit_info']['step']['has_fastloan_order'] = $result['result']['has_fastloan_order'];
														Model::factory('Credit')->insert_update_creditStep($result['result']['credit_info']['step']);
														Gv::init(array('credited'=>$result['result']['user']['credit_auth'],'api_token'=>$api_token,'type'=>1,'user_id'=>isset($userInfo['user_id'])?$userInfo['user_id']:null,'status'=>isset($result['result']['user']['status'])?$result['result']['user']['status']:null));
														Database::instance()->commit();
													} catch (Exception $e) {
														Database::instance()->rollback();
														exit($e->getMessage());
													}
													Gv::$Log = true;
												}else{
													//防止死循环直接过掉
													Gv::$Log = false;
												}
												//$this->updateUserInfo($result_info,$userInfoDb['headimgurl'],$userInfoDb['wechat_username'],$json_info);
											}else{
												if(isset($result['code'])){
													//删除用户信息id,结果没有删除微信专用id,出现'用户查询数据异常'现象
													if($result['code'] == 5018){
														//删除id和快速登录字段
														$this->_user->set_user_wechat_info(array('user_id'=>NULL,'wechat_passport'=>NULL),Wxgv::$wx['openid']);
														$this->redirect('/User/Index');
														die;
													}elseif($result['code'] == 5025){
														//openid失效
														//$this->user->set_user_wechat_info(array('user_id'=>NULL,'wechat_passport'=>NULL,'token'=>NULL),Wxgv::$wx['openid']);
														$this->redirect('/User/Index');
														die;
													}else{
														$this->error($result['message']);
														die;
													}
												}else{
													//系统繁忙，请联系客服！
													$this->error(Kohana::message('wx','system_busy'));
													die;
												}
											}
										}else{
											//使其进入登陆页面进行注册登陆
											Wxgv::$login = false;
										}
									}else{
										$this->error($result['message']);
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
					//获取微信的各项配置信息（微信获得专用通道，获取授权）（活动）
					Wxgv::$wx = $this->_session->sessionGet('wx');
					if(!Valid::not_empty(Wxgv::$wx['openid'])){
						$wx_config = Kohana::$config->load('site.wx');
						//导入微信sdk完成授权
						$wx = Libs::factory('vendor_wxopenid')->init($wx_config['appId'],$wx_config['appSecret'],$wx_config['callbackurl'],$wx_config['state']);
						//判断微信回调 带的参数code 和state
						if(isset($_GET["code"])&&Valid::not_empty($_GET["code"]) && $_GET["state"]=='kuaijin'){
							$code = trim($_GET["code"]);
							//通过回调返回的code值获取openid
							$callback = $wx->getOpenId($code);
							if(Valid::not_empty($callback['openid'])){
								$this->_session->sessionSet('wx',array('openid'=>$callback['openid']));
								//获取微信用户信息
								$userinfo = $wx->getUserInfo($callback['access_token'],$callback['openid']);
								//去除微信昵称上特殊图片字符
								$userinfo['nickname'] = Tool::factory('String')->removeEmoji($userinfo['nickname']);
								//修改微信表的 用户头像（防止用户改了头像  我们这里没有修改）(坑爹处)
								$this->_user->set_user_wechat_info(array("headimgurl"=>$userinfo['headimgurl'],"wechat_username"=>$userinfo['nickname']),$userinfo['openid']);
								//获取到openid以后刷新页面获取用户信息
								if(!Valid::not_empty($openid)){
									//模仿banner访问,获取最新token
									$this->redirect('/'.$this->_controller.'/'.$this->_action.'?target_token={target_token}&d={device_id}');
									die;
								}
							}else{
								//没有拿到openid 网络错误
								$this->error(Kohana::message('wx','network_error'));
								die;
							}
						}else{
							//获取微信的code并重新访问该地址(回调地址)
							//$wx->getCode('/Activity/Turntable2');exit;
							$user_id = isset($_GET['user_id'])?$_GET['user_id']:'';
							//用activity_userid保存userid信息
							if(!empty($user_id)){
								$this->_session->sessionSet('activity_userid',$user_id);
							}
							$callback_url = '/'.$this->_controller.'/'.$this->_action;
							$wx->getCode($callback_url);exit;
							//获取微信的code并重新访问该地址(回调地址)
						}
					}else{
						$userinfo['openid'] = Wxgv::$wx['openid'];
					}
				}
			}
			//活动跳过分享(功能跳过分享)
			//if(($this->_controller=='Activity'||$this->_controller=='Sign')&&($this->_action=='shareInvitation'||$this->_action=='inviteFriend'||$this->_action=='AdPunchClock'||$this->_action=='SignPage'||$this->_action=='SignCoupon')){
			if($this->_controller=='Activity'||$this->_controller=='Sign'){

			}else{
				//锁下同盾不过的人
				if(isset(Gv::$status)&&Valid::not_empty(Gv::$status)&&(Gv::$status=='3'||Gv::$status=='4'||Gv::$status=='5')){
					//为满足借款要求
					$this->error(Kohana::message('wx','not_conform'));
					die;
				}
			}
			//授信步骤（app是刚进入该页面的时候添加，微信是刚进入首页的时候添加）
			if(Valid::not_empty(Gv::$user_id)){
				if(self::$arr_step = $this->_model['credit']->select_credit_info('zhimacredit,work_info,home_info,phone_book,account_taobao,account_jingdong,mno,picauth,contact,faceid,has_fastloan_order',Gv::$user_id)){

				}else{
					//异常错误
					$this->error(Kohana::message('wx','abnormal_error'));
					die;
				};
			}
			//用!isset(Gv::$user_id) or !Valid::not_empty(Gv::$user_id) 来判断用户是否登录或注册
        }
		protected function get_apptoken($target_token){
			$variable = array(
				"target_token"=>$target_token,
				"app"=>$this->getapp()
			);
			$json_info = json_encode($variable);
			//创建新token
			$result = $this->_api->getApiArrays('Target','Auth','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
				//注册成功,插入用户id
				//获取用户信息
				$variable = array(
					"target_token"=>$target_token,
					"app"=>$this->getappapp($result['result']['token'])
				);
				$json_info = json_encode($variable);
				$result_info = $this->_api->getApiArrays('User','Info','',array('json'=>$json_info));
                if(isset($result_info) && $result_info['code']==1000){
						//开启事务
						Database::instance()->begin();
						$result['result']['name'] = $result_info['result']['user']['name'];
						$result['result']['mobile'] = $result_info['result']['user']['mobile'];
						$result['result']['identity_code'] = $result_info['result']['user']['identity_code'];
						$result['result']['credit_auth'] = $result_info['result']['user']['credit_auth'];
						//保存用户基本信息
						$this->_app_session = $result['result'];
						$this->_model['session']->set('session_id',$result['result']);
						//获取用户setep
						$result_step = $this->_api->getApiArrays('CreditInfo','Step','',array('json'=>$json_info));
						if(isset($result_step['code']) && $result_step['code']==1000){
								//保存授信情况
								$result_step['result']['credit_info']['step']['user_id'] = $result_info['result']['user']['user_id'];
								$result_step['result']['credit_info']['step']['has_fastloan_order'] = $result_step['result']['has_fastloan_order'];
								//保存用户授信情况
								try {
									$insertid = Model::factory('Credit')->insert_update_creditStep($result_step['result']['credit_info']['step']);
									if($insertid){
										//暂存用户基本信息
									}else{
										//异常错误
										$this->error(Kohana::message('wx','abnormal_error'));
										die;
									}
									//由于没有定制session里面(status)直接加入Gv里面
									Gv::init(array('app_token' => $this->_app_session['token'], 'user_id' => $this->_app_session['user_id'], 'credited'=>$result_info['result']['user']['credit_auth'],'status'=>$result_info['result']['user']['status'],'mobile' => $this->_app_session['mobile'], 'type' => 2));
									Database::instance()->commit();
								} catch (Exception $e) {
									Database::instance()->rollback();
									exit($e->getMessage());
								}
						}else{
							if(isset($result_step['code'])){
								if($result_step['code'] == 2020){
									//未登陆(但是需要保存token)
									$this->_app_session['token'] = $result['result']['token'];

								}else{
									$this->error($result_info['message']);
									die;
								}
							}else{
								//系统繁忙，请联系客服！
								$this->error(Kohana::message('wx','system_busy'));
								die;
							}
						}
				}else{
					if(isset($result_info['code'])){
						//用户未登录(但是需要保存token)
						if($result_info['code'] == 2020){
							//$this->model['session']->set('session_id',$result['result']);
							$this->_app_session['token'] = $result['result']['token'];
							$this->_session->sessionSet('type',2);
							Gv::$type = 2;
						}
//						$this->error($result_info['message'],'app');
//						die;
					}else{
						//系统繁忙，请联系客服！
						$this->error(Kohana::message('wx','system_busy','app'));
						die;
					}
				}

			}else{
				if(isset($result['code'])){
					$this->error($result['message'],'app');
					die;
				}else{
					//系统繁忙，请联系客服！
					$this->error(Kohana::message('wx','system_busy'),'app');
					die;
				}
			}
		}
	}