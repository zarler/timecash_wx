<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Created by PhpStorm.
 * Permission: liujinsheng
 * Date: 17/10/11
 * app访问的基类(始建于V3版本)
 * 使用工具
 * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Debug')->array2file($array, $filename);
 * Tool::factory('Debug')->array2file($card_no, APPPATH.'../static/liu_test.php');
 * Tool::factory('Debug')->array2file(array('AppHome---101------',$result), APPPATH.'../static/liu_test.php');
*/

    class AppHome extends Common {
        //重写构造方法
		protected $_target_token = null;
		//通过target_token获取的token信息
		protected $_app_token_Info = null;
		//用户基本信息
		protected  $_app_session = null;
		protected static $arr_step = NULL;
		protected  $_app_session_sign = 0;
		
		//用户信息Gv::$userInfo
        public function before(){

			parent::before();
            //初始化
			$this->init();
			//验证target_token
			$this->getTargetTokenInfo();
			//用户的基本信息(session_userInfo 保存在session里面的用户数据)
            $this->_app_token_Info = Valid::not_empty($this->_app_token_Info)?$this->_app_token_Info:$this->_session->sessionGet('session_userInfo');
            $arrayInfo= json_decode($this->_app_token_Info,true);
            if(!is_null($arrayInfo)){
				//赋值给公共类
				Gv::initArray($arrayInfo);
			}
            //授信步骤（app是刚进入该页面的时候添加，微信是刚进入首页的时候添加）
            $this->getUserStep();//得到self::$arr_step
        }

		/**
		 *  初始化
		 */
		public function init()
		{
			$this->_model['credit'] = Model::factory('Credit');
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
		 *  验证target_token,删除旧数据
		 */
		public function getTargetTokenInfo()
		{

    //            $_GET['target_token'] = 'TO20171226160213QHTxjbMkRJdSALOimlbWUFXIywUbQCxkGzgdzaXYklOWRtsg';

			if(isset($_GET['target_token'])&&Valid::not_empty($_GET['target_token'])){
				//消除上个账号的缓存(说明第一次进来)
				$this->_session->sessionDelete('session_userInfo');
				//获取用户信息
				$this->_target_token = $_GET['target_token'];
				$this->get_apptoken();
			}
		}

		/**
		 *  通过target_token获取用户信息
		 */
		protected function get_apptoken(){
			//检验target_token获得token是否过期
			$variable = array(
				"target_token"=>$this->_target_token,
				"app"=>$this->getAppInfo()
			);
			$json_info = json_encode($variable);
            //创建新token
			$result = $this->_api->getApiArrays('Target','Auth','',array('json'=>$json_info),'v');
//            Tool::factory('Debug')->D(array($_GET,$variable,$json_info,$result));
            if(isset($result['code']) && $result['code']==1000){
				//注册成功,插入用户id
				//获取用户信息
				$variable = array(
					"app"=>$this->getAppInfo($result['result']['token'])
				);
				$json_info = json_encode($variable);
				$result_info = $this->_api->getApiArrays('User','Info','',array('json'=>$json_info));
                if(isset($result_info['code']) && $result_info['code']==1000){
						//组织用户信息(保存到session)
						$result['result']['name'] = $result_info['result']['user']['name'];
						$result['result']['mobile'] = $result_info['result']['user']['mobile'];
						$result['result']['identity_code'] = $result_info['result']['user']['identity_code'];
						$result['result']['credit_auth'] = $result_info['result']['user']['credit_auth'];
						$result['result']['status'] = $result_info['result']['user']['status'];
//						Tool::factory('Debug')->D($result['result']);
						//获取用户setep
						$result_step = $this->_api->getApiArrays('CreditInfo','Step','',array('json'=>$json_info));
						if(isset($result_step['code']) && $result_step['code']==1000){
							//保存授信情况
							$result_step['result']['credit_info']['step']['user_id'] = $result_info['result']['user']['user_id'];
							$result_step['result']['credit_info']['step']['has_fastloan_order'] = $result_step['result']['has_fastloan_order'];
							$strResult = json_encode($result['result']);
							//开启事务
							Database::instance()->begin();
							try {
								//保存用户基本信息
								$this->_session->sessionSet('session_userInfo',$strResult);
								$this->_app_token_Info = $strResult;
								//修改用户step数据
								Model::factory('Credit')->insert_update_creditStep($result_step['result']['credit_info']['step']);
								Database::instance()->commit();
							} catch (Exception $e) {
								Database::instance()->rollback();
								exit($e->getMessage());
							}
					}else{
						if(isset($result_step['code'])){
							$this->error($result_info['message']);
							die;
						}else{
							//系统繁忙，请联系客服！
							$this->error(Kohana::message('wx','system_busy'));
							die;
						}
					}
				}else{
                    if(isset($result_info['code'])){
                        if($result_info['code']==2020){
                            $strResult = json_encode(array('token'=>$result['result']['token']));
                            $this->_app_token_Info = $strResult;
                        }else{
                            $this->error($result_info['message']);
                            die;
                        }
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