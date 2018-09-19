<?php defined('SYSPATH') or die('No direct script access.');


/*
 * Created by PhpStorm.
 * Permission: liujinsheng
 * Date: 17/10/11
 * 主要用于微信授权登录(v3后改版)(微信端的基类)
 * 使用工具
 * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Debug')->array2file($array, $filename);
 * Tool::factory('Debug')->array2file($card_no, APPPATH.'../static/liu_test.php');
 * Tool::factory('Debug')->array2file(array('AppHome---101------',$result), APPPATH.'../static/liu_test.php');
*/
    class WxHome extends Common {
		protected static $arr_step = NULL;
		protected $_have_credit = false;
		protected $_Msg = null;
		protected $_User = null;
		//需要更新的页面
		protected static $_UpdateAction = array(
			'Index','index','Promote','InvitationShare'
		);
		//权限(用户状态)
		protected static $_PowerStatus = array(3,4,5);
		//权限(用户授信)需要授信的action
		protected static $_PowerCredit = array('bankinfo','index','borrow','extremeBorrow');
		//授信不过者
		protected static $_CreditOk = array(11,12,13,14,16,17);

        //获取微信openid 用于登录前和登录后
        public function before(){

//			$this->ip_limit();
			parent::before();

            //post接受微信发过来的xml信息
			$this->init();
			//响应微信服务器
			$this->responseMsg();
			//微信初始化
			$this->initWx();//出Gv::$_userInfo
			//请求api3 token //token超时或没有
			$this->getReqAppToken();  //修改请求Gv::$_userInfo['token']的值(首次不更改时间,库里面有修改)
            //更新用户信息
			$this->updateUserBaseInfo();
			//授信步骤（app是刚进入该页面的时候添加，微信是刚进入首页的时候添加）
			$this->getUserStep();//得到self::$arr_step
		}
		//初始化对象
		protected function init(){
			//优惠券
			$this->_model['order'] = Model::factory('Order');
			$this->_model['bankcard'] = Model::factory('Bankcard');
			$this->_Msg = $this->_site_config['push']['message'];
			$this->_User = Model::factory('User');
		}
		/**
		 *  微信初始化
		 */
		protected function initWx(){
			//判断微信的session是否存在  不存在授权登录
			Gv::$_Openid = $this->_session->sessionGet('openid');
            if(!Valid::not_empty(Gv::$_Openid)){
				//获取微信的各项配置信息(请求信息微信信息)
				$wx_config = $this->_site_config['wx'];
				//导入微信sdk完成授权
				//返回地址进行
                //$wx_config['callbackurl']变成全地址
                $callbackurl = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//                Tool::factory('Debug')->D($callbackurl);
				$wx = Libs::factory('vendor_wxopenid')->init($wx_config['appId'],$wx_config['appSecret'],$callbackurl,$wx_config['state']);
				//判断微信回调 带的参数code 和state
				if(isset($_GET["code"])&&Valid::not_empty($_GET["code"])&&$_GET["state"]=='kuaijin'){
					$code = trim($_GET["code"]);
					//通过回调返回的code值获取openid
					$callback = $wx->getOpenId($code);
					if(isset($callback['openid'])&&Valid::not_empty($callback['openid'])){
						//获取微信用户信息
						$userinfoWx = $wx->getUserInfo($callback['access_token'],$callback['openid']);
                        //去除微信昵称上特殊图片字符
						$nickname = isset($userinfoWx['nickname'])?$userinfoWx['nickname']:null;
						$userinfoWx['nickname'] = Tool::factory('String')->removeEmoji($nickname);
						//修改微信表的 用户头像（防止用户改了头像  我们这里没有修改）(坑爹处)(无用户的时候,不能修改)
						//查询是否有记录
						Gv::$_userInfo = Model::factory('Home')->dbfind($userinfoWx['openid'],'openid','user_wechat','id,user_id,token,expire_in,mobile,credited,nickname,sex,identity_code,wechat_passport,wechat_username,headimgurl,max_amount,ensure_rate,status');
                        //保存微信openid
                        $this->_session->sessionSet('openid',$userinfoWx['openid']);
						if(!isset(Gv::$_userInfo['id'])||!Valid::not_empty(Gv::$_userInfo['id'])){
							//添加
							$wechat_arr = array(
								'openid'=>$callback['openid'],
								'create_time'=>time(),
								'token'=>'',
								'expire_in'=>0,
								'update_time'=>date('Y-m-d H:i:s', time()),
								'wechat_username'=>$userinfoWx['nickname'],
								'nickname'=>null,
								'max_amount'=>$this->_site_config['config']['max_amount'],
								'ensure_rate'=>$this->_site_config['config']['ensure_rate'],
								'headimgurl'=>$userinfoWx['headimgurl'],
								'status'=>1
							);
							$insertId = $this->_User->insert_user_wechat_info($wechat_arr);
							$wechat_arr['id'] = $insertId;
							Gv::$_userInfo = $wechat_arr;
						}else{
							//修改
							$this->_User->set_user_wechat_info(array("headimgurl"=>isset($userinfoWx['headimgurl'])?$userinfoWx['headimgurl']:null,"wechat_username"=>$userinfoWx['nickname']),$callback['openid']);
						}
						Gv::$_Openid = $callback['openid'];
					}else{
						//没有拿到openid 网络错误(微信服务返回错误)
						$this->error('重复请求!');
						die;
					}
				}else{
					//获取微信的code并重新访问该地址(回调地址)
					//$activity = $this->_session->sessionGet('activity');
					//保存get值
					if(isset($_GET)&&!empty($_GET)){
						$this->_session->sessionSet('ACT_GET',json_encode($_GET));
					}
//                    $callbackurl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					$wx->getCode();exit;
				}
			}else{
                Gv::$_userInfo = Model::factory('Home')->dbfind(Gv::$_Openid,'openid','user_wechat','id,user_id,token,expire_in,mobile,credited,nickname,sex,identity_code,wechat_passport,wechat_username,headimgurl,max_amount,ensure_rate,status');
                //如果没有则进行删除openid后,重新刷新
				if(!Valid::not_empty(Gv::$_userInfo)){
					$this->_session->sessionDelete('openid');
					$this->redirect('/'.$this->_directory.'/'.$this->_controller.'/'.$this->_action);
				}
			}
		}

		/**
		 *  申请token(修改Gv::$_userInfo['token']里面的token值)
		 */
		protected function getReqAppToken(){
			$time = time();
			if(empty(Gv::$_userInfo['token']) || Gv::$_userInfo['expire_in'] < $time){
				$result = $this->getFirstToken();
				if(isset($result['code'])&&$result['code']==1000){
					//修改用户信息
					if(Valid::not_empty(Gv::$_Openid)){
						$result['result']['expire_in'] = $result['result']['expire_in']+time();
						$this->_User->set_user_wechat_info($result['result'],Gv::$_Openid);
						//api_token api3的token保存
						Gv::$_userInfo['token'] = $result['result']['token'];
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
			}elseif(!empty(Gv::$_userInfo['token'])&& (Gv::$_userInfo['expire_in']-1000) < $time && Gv::$_userInfo['expire_in']>$time) {
				$result = $this->getRenewToken();
				if(isset($result['code'])&&$result['code']==1000){
					//修改用户信息
					if(!empty($openid['openid'])){
						$result['result']['expire_in'] = $result['result']['expire_in']+time();
						$this->_User->set_user_wechat_info($result['result'],Gv::$_Openid);
						Gv::$_userInfo['token'] = $result['result']['token'];
					}
				}else{
					if(isset($result['code'])&&$result['code']!=1000){
						$result = $this->getFirstToken();
						if(isset($result['code'])&&$result['code']==1000){
							//修改用户信息
							//if(Valid::not_empty(Wxgv::$wx['openid'])){
							$result['result']['expire_in'] = $result['result']['expire_in']+time();
							$this->_User->set_user_wechat_info($result['result'],Gv::$_Openid);
							Gv::$_userInfo['token'] = $result['result']['token'];
							//}
						}else{
							if(isset($result['code'])){
								$this->error($result['message']);
								die;
							}else{
								$this->error('网络错误');
								die;
							}
						}
					}elseif(isset($result['code'])){
						$this->error($result['message']);
						die;
					}else{
						$this->error('网络错误');
						die;
					}
				}
			}
		}

		/**
		 *  修改用户信息
		 */
		protected function updateUserBaseInfo(){
			//每次对注册的用户进入index的时候进行用户信息更新

//			if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])&&in_array($this->_action,self::$_UpdateAction)){
				$variable = array(
					"app"=>$this->getWxInfo()
				);
				$json_info = json_encode($variable);
				$result = $this->_api->getApiArrays('User','Info','',array('json'=>$json_info));
//				Tool::factory('Debug')->D($result);
				if(isset($result['code']) && $result['code']==1000){
				        if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])&&in_array($this->_action,self::$_UpdateAction)){
                            //保存用户数据
                            if(Gv::$_userInfo['user_id']!=$result['result']['user']['user_id']){
                                //异常错误
                                $this->error(Kohana::message('wx','abnormal_error'));
                                die;
                            }else{
                                //用于Account_Promote下对信用卡有无的判断
                                if($this->_action=='Promote'){
                                    if(isset($result['result']['credit_card'])&&!empty($result['result']['credit_card'])){
                                        $this->_have_credit = true;
                                    }
                                }
                                //修改基本用户信息
                                $this->updateUserInfo($result,$json_info);
                            }
                        }
				} else {
					if(isset($result['code'])){
						//未登录
						if($result['code'] == 2020){
							//进行快速登陆,判断是否有wechat_passport值来判断能否快速登陆
							if(isset(Gv::$_userInfo['wechat_passport'])&&Valid::not_empty(Gv::$_userInfo['wechat_passport'])){
								//快速登陆
								$variable = array(
									"openid"=>Gv::$_Openid,
									"passport"=>Libs::factory('AES126')->encrypt(Gv::$_userInfo['wechat_passport'],$this->_api_config['wx']['app_key']),
									"app"=>$this->getWxInfo()
								);
								$json_info = json_encode($variable);
								$result = $this->_api->getApiArrays('Wechat','Login','',array('json'=>$json_info));

                                if(isset($result) && $result['code']==1000){
									//修改基本用户信息(快速登陆成功以后，再次获取修改用户信息)
									$variable = array(
										"app"=>$this->getWxInfo()
									);
									$json_info = json_encode($variable);
									$result_info = $this->_api->getApiArrays('User','Info','',array('json'=>$json_info));
                                    $this->updateUserInfo($result_info,$json_info);
								}else{
									if(isset($result['code'])){
										//删除用户信息id,结果没有删除微信专用id,出现'用户查询数据异常'现象
										if($result['code'] == 5018){
											//删除id和快速登录字段
											$this->_User->set_user_wechat_info(array('user_id'=>NULL,'wechat_passport'=>NULL),Wxgv::$wx['openid']);
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
							}
							//解决缺少token问题
						}elseif($result['code'] == 2003){
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
//			}
		}

		/**
		 *  获得用户step
		 */
		protected function getUserStep(){
			if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])){
				if(self::$arr_step = Model::factory('Credit')->select_credit_info('zhimacredit,work_info,home_info,phone_book,account_taobao,account_jingdong,mno,picauth,contact,faceid,has_fastloan_order',Gv::$_userInfo['user_id'])){
				}else{
					//异常错误
					$this->error(Kohana::message('wx','abnormal_error'));
					die;
				};
			}
		}

		/**
		 *  获取用户信息(有两个地方用)
		 */
		protected function updateUserInfo($result,$json_info=null){

            $update_arr = array(
				'user_id'=>$result['result']['user']['user_id'],
				'nickname'=>$result['result']['user']['name'],
				'mobile'=>$result['result']['user']['mobile'],
				'identity_code'=>$result['result']['user']['identity_code'],
				'sex'=>$result['result']['user']['sex'],
				'credited'=>$result['result']['user']['credit_auth'],
				'max_amount'=>$result['result']['finance']['max_amount'],
				'ensure_rate'=>$result['result']['finance']['ensure_rate'],
				'status'=>$result['result']['user']['status']
			);

            try {
				//开启事务
				Database::instance()->begin();
				//坑爹处credited
				$this->_User->set_user_wechat_info($update_arr,Gv::$_Openid);
				//更新step
				$result = $this->_api->getApiArrays('CreditInfo','Step','',array('json'=>$json_info));
				if(isset($result['code']) && $result['code']==1000){
					if(isset($result['result']['credit_info']['step'])&&!empty($result['result']['credit_info']['step'])){
						$result['result']['credit_info']['step']['has_fastloan_order'] = $result['result']['has_fastloan_order'];
						$result['result']['credit_info']['step']['user_id'] = Gv::$_userInfo['user_id'];
						Model::factory('Credit')->insert_update_creditStep($result['result']['credit_info']['step']);
					}
				}else{
					if(isset($result['code'])){
						if($result['code'] == 2000){
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
				Database::instance()->commit();
			} catch (Exception $e) {
				Database::instance()->rollback();
				exit($e->getMessage());
			}
			//修改用户基本数据(组装)(最新数据)
			Gv::$_userInfo['user_id']=$update_arr['user_id'];
			Gv::$_userInfo['nickname']=$update_arr['nickname'];
			Gv::$_userInfo['mobile']=$update_arr['mobile'];
			Gv::$_userInfo['sex']=$update_arr['sex'];
			Gv::$_userInfo['credited']=$update_arr['credited'];
			Gv::$_userInfo['max_amount']=$update_arr['max_amount'];
			Gv::$_userInfo['status']=$update_arr['status'];



		}
		//取user表里的 某些字段做判断
        protected function isstatus($openid,$field='validated_identity'){
            //查询validated_identity的值 是否为空  空说明是没有注册的用户
			$auth = $this->_User->user_isstatus($openid,$field);
            return $auth;
        }

		/**
		 *  用户状态限制
		 */
		protected function powerStatus(){
			if(in_array(Gv::$_userInfo['status'],self::$_PowerStatus)){
				$this->error(Kohana::message('wx','not_conform'));
				die;
			}
		}
		/**
		 *  用户授信限制
		 */
		protected function powerCredit(){
			if(!in_array($this->_action,self::$_PowerCredit)){
				if(in_array(Gv::$_userInfo['credited'],self::$_CreditOk)){
					$this->error(Kohana::message('wx','not_conform'));
					die;
				}
			}
		}


		//不记利息的用户 用于免息测试
		protected function testUser($mobile){
			$array = array('13521575710','13011806661','17710264770','18511320703','18911216296','13811440897','15210327642','15522613388','18500354921','13910009730','13718161521','13811824927');
			if(in_array($mobile,$array)){
				return true;
			}else{
				return false;
			}
		}

		protected function responseMsg()//执行接收器方法
		{
			$postStr = file_get_contents("php://input");
			//$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"])?$GLOBALS["HTTP_RAW_POST_DATA"]:false;
			//Tool::factory('Debug')->array2file($postStr, APPPATH.'../static/liu_test.php');
			if(!empty($postStr)&&strpos($postStr,'<xml>')!== false){
				//Tool::factory('Debug')->D($postStr);
				$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				$RX_TYPE = trim($postObj->MsgType);
				$wxModel = Model::factory('Wx');
				//区分类型(text,event)
				switch ($RX_TYPE) {
					case "event":
						switch (trim($postObj->Event)){
							case "subscribe": //关注
								$wxPost = array(
									"ToUserName"=>trim($postObj->ToUserName),
									"FromUserName"=>trim($postObj->FromUserName),
									"EventKey"=>trim($postObj->EventKey),
									"CreateTime"=>trim($postObj->CreateTime),
									"Event"=>trim($postObj->Event)
								);
								//过滤掉没有场景id注册的用户
								if(empty($wxPost['EventKey'])){
									//主动关注
									$textTpl = "<xml>
									   <ToUserName><![CDATA[%s]]></ToUserName>       
									   <FromUserName><![CDATA[%s]]></FromUserName>      
									   <CreateTime>%s</CreateTime>
									   <MsgType><![CDATA[text]]></MsgType>
									   <Content><![CDATA[%s]]></Content>
									   </xml>";
									$result = sprintf($textTpl,trim($postObj->FromUserName),trim($postObj->ToUserName),trim($postObj->CreateTime),$this->_Msg['subscribe']);
									echo $result;
								}else{
									$textTpl = "<xml>
									   <ToUserName><![CDATA[%s]]></ToUserName>       
									   <FromUserName><![CDATA[%s]]></FromUserName>      
									   <CreateTime>%s</CreateTime>
									   <MsgType><![CDATA[text]]></MsgType>
									   <Content><![CDATA[%s]]></Content>
									   </xml>";
									$result = sprintf($textTpl,trim($postObj->FromUserName),trim($postObj->ToUserName),trim($postObj->CreateTime),$this->_Msg['subscribe']);
									echo $result;

									//根据渠道区分用户响应
//									switch ($wxPost['EventKey']){
//										case 'qrscene_101':
//									        //添加一个统计用户是否注册记录
//											$wxUserInfo = $this->_User ->get_basic_userinfo($wxPost['FromUserName']);
//											if(isset($wxUserInfo['user_id'])&&!empty($wxUserInfo['user_id'])){
//												//调取春雨的接口()
//												$trid = time().Text::random('numeric',8);
//												$time = Date('Y-m-d H:i:s',time());
//												$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR'])&&$_SERVER['HTTP_X_FORWARDED_FOR']?$_SERVER['HTTP_X_FORWARDED_FOR']:(isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'');
//												$ip = explode(",",$ip)[0];
//												$app_str = '' . $this->_api_config['wx']['app_id'] . $trid . md5($this->_api_config['wx']['app_key']) . $time ;
//												$variable = array(
//													"user_id"=>$wxUserInfo['user_id'],
//													"app"=>array('os'=>$this->_api_config['wx']['app_id'],'ver'=>$this->_api_config['wx']['ver'],'ip'=>$ip,'unique_id'=>$wxPost['FromUserName'],'trid'=>$trid,'time'=>$time,'app_id'=>$this->_api_config['wx']['app_id'],'sign'=>md5(md5($app_str).$this->_api_config['wx']['app_key']))
//												);
////                                                Tool::factory('Debug')->array2file(array($this->_api_config,md5($this->_api_config['wx']['app_key']),$app_str), APPPATH.'../static/liu_test.php');
//												$json_info = json_encode($variable);
//												$this->_api->getApiArrays('WeiXin','Follow','',array('json'=>$json_info));
//											}
//											break;
//										default:
//											break;
//									}


									//$shareInfo = $wxModel->get_shareUserInfo("",array('ToUserName'=>$wxPost['ToUserName'],'FromUserName'=>$wxPost['FromUserName'],'EventKey'=>$wxPost['EventKey']));
									//if(!empty($shareInfo)){
										//改库
//										$update = $wxModel->update_shareUserInfo(array('Event'=>'subscribe','CreateTime'=>$wxPost['CreateTime']),array('ToUserName'=>$wxPost['ToUserName'],'FromUserName'=>$wxPost['FromUserName'],'EventKey'=>$wxPost['EventKey']));
//									if($update){
//										//推送
//										$this->wxPushMsg($wxPost['ToUserName'],$wxPost['CreateTime'],$wxPost['EventKey']);
//									}
									//}else{
										//入库
//										$insert_id = $wxModel->insert_shareUserInfo(array('ToUserName'=>$wxPost['ToUserName'],'MsgType'=>$RX_TYPE,"FromUserName"=>$wxPost['FromUserName'],"CreateTime"=>$wxPost['CreateTime'],"Event"=>$wxPost['Event'],"create_time"=>time(),'EventKey'=>$wxPost['EventKey']));
	//									if($insert_id){
	//										//推送
	//										$this->wxPushMsg($wxPost['ToUserName'],$wxPost['CreateTime'],$wxPost['EventKey']);
	//									}
									//}
								}
								//Tool::factory('Debug')->array2file($shareInfo, APPPATH.'../static/liu_test.php');
								break;
							case "unsubscribe"://取消关注(未进行)
								//Tool::factory('Debug')->array2file(array('Event'=>'unsubscribe','CreateTime'=>trim($postObj->CreateTime)),array('ToUserName'=>trim($postObj->ToUserName),'FromUserName'=>trim($postObj->FromUserName)), APPPATH.'../static/liu_test.php');
//								$wxModel->update_shareUserInfo(array('Event'=>'unsubscribe','CreateTime'=>trim($postObj->CreateTime)),array('ToUserName'=>trim($postObj->ToUserName),'FromUserName'=>trim($postObj->FromUserName)));
								//推送
								//$this->wxPushMsg(trim($postObj->FromUserName),trim($postObj->ToUserName),trim($postObj->CreateTime),'取消关注');
								//Tool::factory('Debug')->array2file($shareInfo, APPPATH.'../static/liu_test.php');
								break;
							case "TEMPLATESENDJOBFINISH"://模板消息推送后获得的反馈(20171113,v3修改)
                                $log = new Tool_Log(DOCROOT.'/protected/logs');
                                $log->write(array(array('body'=>json_encode(array('Event'=>'TEMPLATESENDJOBFINISH','CreateTime'=>trim($postObj->CreateTime),'ToUserName'=>trim($postObj->ToUserName),'FromUserName'=>trim($postObj->FromUserName),'MsgType'=>'event','MsgID'=>trim($postObj->MsgID),'Status'=>trim($postObj->Status),'create_time'=>time())),'time'=>time())),"time --- body\r\n");
								//$wxModel->insert_templatesEndJobFinish(array('Event'=>'TEMPLATESENDJOBFINISH','CreateTime'=>trim($postObj->CreateTime),'ToUserName'=>trim($postObj->ToUserName),'FromUserName'=>trim($postObj->FromUserName),'MsgType'=>'event','MsgID'=>trim($postObj->MsgID),'Status'=>trim($postObj->Status),'create_time'=>time()));
								break;
							default:
								break;
						}
						break;
					case "text":
						$wxPost = array(
							"ToUserName"=>trim($postObj->ToUserName),
							"FromUserName"=>trim($postObj->FromUserName),
							"CreateTime"=>trim($postObj->CreateTime),
							"MsgType"=>trim($postObj->MsgType),
							"Content"=>trim($postObj->Content),
							"MsgId"=>trim($postObj->MsgId)
						);
						//Tool::factory('Debug')->array2file(array($wxPost), APPPATH.'../static/liu_test.php');
						//根据关键字来获取内容信息
						switch ($wxPost['Content']){
							case '1':
							case '2':
							case '3':
							case '4':
							case '5':
							case '6':
							case '7':
							case '8':
							case '9':
							case '10':
							case '11':
								$textTpl = "<xml>
								   <ToUserName><![CDATA[%s]]></ToUserName>       
								   <FromUserName><![CDATA[%s]]></FromUserName>      
								   <CreateTime>%s</CreateTime>
								   <MsgType><![CDATA[text]]></MsgType>
								   <Content><![CDATA[%s]]></Content>
								   </xml>";
								$result = sprintf($textTpl,trim($postObj->FromUserName),trim($postObj->ToUserName),trim($postObj->CreateTime),$this->_Msg[$wxPost['Content']]);
								//Tool::factory('Debug')->array2file($result, APPPATH.'../static/liu_test.php');
								echo $result;
								break;
							default:
								//多客服响应
//								$textTpl = "<xml>
//								   <ToUserName><![CDATA[%s]]></ToUserName>       
//								   <FromUserName><![CDATA[%s]]></FromUserName>      
//								   <CreateTime>%s</CreateTime>
//								   <MsgType><![CDATA[transfer_customer_service]]></MsgType>
//								   </xml>";
								//自动回复
								$textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName>       
								   <FromUserName><![CDATA[%s]]></FromUserName>      
								   <CreateTime>%s</CreateTime>
								   <MsgType><![CDATA[text]]></MsgType>
								   <Content><![CDATA[%s]]></Content>
								   </xml>";
								$result = sprintf($textTpl,trim($postObj->FromUserName),trim($postObj->ToUserName),trim($postObj->CreateTime),$this->_Msg['reply']);
								echo $result;
								break;
						}
						break;
					default:
						break;
				}
//				echo $result;
//			}else {
//				Tool::factory('Debug')->array2file(array(11111111), APPPATH.'../static/liu_test.php');
//				echo "";
//				exit;
			}
		}

		//推送
		protected function wxPushMsg($ToUserName,$CreateTime,$EventKey)//执行接收器方法
		{
			//Tool::factory('Debug')->array2file(array($ToUserName,$CreateTime,$EventKey), APPPATH.'../static/liu_test.php');
			//对注册快进又微信登录的人进行推送
			if(!empty($EventKey)){
				$user_id = substr($EventKey,8);
				$openid = $this->_user->get_userinfo_arr('openid',array('user_id'=>$user_id))['openid'];
//				ToUserName	发送方帐号（一个OpenID）
//				FromUserName	开发者微信号
//				CreateTime	消息创建时间 （整型）
//				MsgType	消息类型，event
				if(!empty($openid)){
					$textTpl = "<xml>
					   <ToUserName><![CDATA[%s]]></ToUserName>       
					   <FromUserName><![CDATA[%s]]></FromUserName>      
					   <CreateTime>%s</CreateTime>
					   <MsgType><![CDATA[text]]></MsgType>
					   <Content><![CDATA[%s]]></Content>
					   <FuncFlag>0</FuncFlag>
					   </xml>";
					$result = sprintf($textTpl,$openid,$ToUserName,$openid, $CreateTime, '注册成功');
//					Tool::factory('Debug')->array2file($result, APPPATH.'../static/liu_test.php');
					echo $result;
				}
			}
		}

        protected function sign($str,$key){
            return md5(md5($str).$key);
        }


}