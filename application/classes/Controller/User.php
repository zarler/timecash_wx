<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
class Controller_User extends WxHome {
	public function before(){
		parent::before();
	}
	public function action_Index(){

		$variable = array(
			"app"=>$this->getWxInfo()
		);
		$json_info = json_encode($variable);
		/*-------------------广告banner-----------------------*/
		$result = $this->_api->getApiArrays('AD','Wechat','',array('json'=>$json_info));
		$time = time();
		if(isset($result['code']) && $result['code']==1000){
			if(isset($result['result']['top_banner'])&&!empty($result['result']['top_banner'])){
				$strBanner = "";
				$imgBanner = "";
				$signBanner = "";
				foreach ($result['result']['top_banner'] as $key => $val){
					if(strtotime($val['start_time'])<=$time && $time<strtotime($val['end_time'])){
						$strBanner .= '<li><a href="'.$val['target'].'"><img style="height: 130px;width: 100%;" src="'.$val['img'].'"></a></li>';
						$signBanner .= '<a href="#">'.($key+1).'</a>';
					}
				}
                parent::$_VArray['strBanner'] = $strBanner;
                parent::$_VArray['signBanner'] = $signBanner;
			}else{
                parent::$_VArray['banner'] = null;
			}
			//公告广告
			if(isset($result['result']['top_banner2'])&&!empty($result['result']['top_banner2'])){
				if(strtotime($result['result']['top_banner2'][0]['start_time'])<=$time && $time<strtotime($result['result']['top_banner2'][0]['end_time'])){
                    parent::$_VArray['bannerNotice'] = '<section class="add_user_index"><a style="display: block;height: 30px;color: black;" href="'.$result['result']['top_banner2'][0]['target'].'"><img style="width: 15px;margin: 3px;" src="'.$result['result']['top_banner2'][0]['img'].'"><span>'.$result['result']['top_banner2'][0]['subject'].'</span><i></i></a></section>';
				}else{
                    parent::$_VArray['bannerNotice'] = null;
				}
			}else{
                parent::$_VArray['bannerNotice'] = null;
			}
		}else{
			if(isset($result['code'])){
				$this->error($this->handleCode($result['code'],$result['message']));
				die;
			}else{
				//系统繁忙，请联系客服！
				$this->error(Kohana::message('wx','system_busy'));
				die;
			}
		}
        /*-------------------广告banner-----end-----------------------*/
        //版本号识别自动适配3.0 就是新JSON结构  2.4 就是老的
		$result = $this->_api->getApiArrays('AppHome','Wechat','',array('json'=>$json_info));
        //首页接口,含有当前订单
		if(isset($result['code']) && $result['code']==1000){
            //用户是否登录
			if(!empty(Gv::$_userInfo['user_id'])){
				if(!Valid::not_empty(Gv::$_userInfo['headimgurl'])){
					if(Gv::$_userInfo['sex']=='男'){
						$userinfo['headimgurl'] ='/static/images/m-pic.png';
					}elseif(Gv::$_userInfo['sex']=='女'){
						$userinfo['headimgurl'] = '/static/images/n-pic.png';
					}
				}else{
					$userinfo['headimgurl'] = Gv::$_userInfo['headimgurl'];
				}
                //是否有借款
				if(isset($result['result']['current_order'])&&!empty($result['result']['current_order'])){
					//有订单分为新旧用户
					 parent::$_VArray['currentOrder']= $this->user_status($result['result']['current_order']);
//                    $userinfo = $user_info['userinfo'];
//					$info = $user_info['info'];
				}
                //显示的用户信息(重新组装)
                parent::$_VArray['userinfo'] = $userinfo;
                //授信情况(基础授信没过)
//                if(isset(Gv::$_userInfo['credited'])&&in_array(Gv::$_userInfo['credited'],array(11,12,13,14))){
//                    parent::$_VArray['userinfo']['credited'] = false;
//                }else{
//                    parent::$_VArray['userinfo']['credited'] = true;
//                }

                //侧栏列表

//                Tool::factory('Debug')->D($result['result']['menu']);
                foreach ($result['result']['menu'] as $key=>&$val){
                    $rulCoin = $this->Routingnew($val);
                    $val['left_url'] = $rulCoin['url'];
                    $val['left_icon'] = $rulCoin['icon'];
                }


                parent::$_VArray['menu'] = $result['result']['menu'];
                //产品列表
                foreach ($result['result']['product_list'] as $key=>&$val){
                    if(in_array($val['type'],array('fast_loan','full_pre_auth_loan','pre_auth_loan'))){
                        if(Valid::not_empty($val['button']['click'])){
                            $val['button']['click'] = $this->Routing($val['button']['click'])['url'];
                        }
                    }
                }
                parent::$_VArray['product_list'] = $result['result']['product_list'];

			}else{
                //产品列表
                foreach ($result['result']['product_list'] as $key=>&$val){
                    if(in_array($val['type'],array('fast_loan','full_pre_auth_loan','pre_auth_loan'))){
                        $val['button']['click'] = '/Login';
                    }
                }
                parent::$_VArray['product_list'] = $result['result']['product_list'];
				//$this->redirect('/Login/index');
//                parent::$_VArray['product_list']['jumpUrlBorrow'] = '/Login';
//				parent::$_VArray['product_list']['jumpUrlEx'] = '/Login';
			}
        }else{
			if(isset($result['code'])){
				$this->error($this->handleCode($result['code'],$result['message']));
				die;
			}else {
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx', 'system_busy'));
                die;
            }

		}
        //Tool::factory('Debug')->D(parent::$_VArray['product_list']);

        $userinfo['name'] = Valid::not_empty(Gv::$_userInfo['nickname'])?Gv::$_userInfo['nickname']:(Valid::not_empty(Gv::$_userInfo['wechat_username'])?Gv::$_userInfo['wechat_username']:'用户名');
        $userinfo['headimgurl'] = Valid::not_empty(Gv::$_userInfo['headimgurl'])?Gv::$_userInfo['headimgurl']:'/static/images/m-pic.png';
        $userinfo['mobile'] = isset(Gv::$_userInfo['mobile'])?substr_replace(Gv::$_userInfo['mobile'],'****',3,4):null;
        parent::$_VArray['userinfo'] = $userinfo;
		parent::$_VArray['title']=Kohana::$config->load('url.title.user');
        $view = View::factory($this->_vv.'User/index');
        $view->_VArray = parent::$_VArray;
		$this->response->body($view);

	}

    //用户状态判断（首页卡片）
    public function user_status($result=null){
        if(!isset($result['status'])){
            return false;
        }
        $currentOrder = null;
        //还款按钮
        $repayButton = false;
        //时间名词
        $timeMoun = '借款时间';

        //预授权中
        if($result['status'] == Model_Home::PAGE_TO_INIT){
            $statusOrder = '预授权确定中';
            //首页还款按钮
            $repaymentButton = null;
            //还款时间
            $repaymentTime = '── ──';
            $timeMoun = '距还款日还剩';
        }
        //审核中
        if(in_array($result['status'],Model_HOME::HOMEPAGE_CARD_INFO_EXAMINE)){
            $statusOrder = '审核中';
            //还款时间提醒
            //首页还款按钮
            $repaymentButton = null;
            //还款时间
            $repaymentTime = '── ──';
            $timeMoun = '距还款日还剩';
        }
        //还款处理中
        if(in_array($result['status'],Model_HOME::HOMEPAGE_CARD_INFO_REPAYMENTING)){
            $statusOrder = '还款处理中';
            $expire_time = strtotime($result['expire_time']);
            $time = strtotime(date('Y-m-d',time()));
            $day = ($expire_time-$time)/86400;//echo date('Y-m-d H:i:s','1456243200');
            $abs = abs($day);
            $repaymentTime = $abs.'天';
            $timeMoun = '距还款日还剩';
            if(in_array($result['status'],Model_HOME::HOMEPAGE_CARD_INFO_REPAYMENTING_SIGN)){
                $timeMoun = '已逾期';
            }
            if($expire_time<$time){
                $timeMoun = '已逾期';
            }
            $repaymentButton = null;
        }
        //审核未通过
        if($result['status'] == Model_Home::PAGE_TO_REJECT){
            $statusOrder = '审核未通过';
            //首页还款按钮
            $repaymentButton = null;
            //还款时间
            $repaymentTime = '── ──';
            $timeMoun = '距还款日还剩';
        }
        //已放款5
        if($result['status'] == Model_Home::PAGE_TO_PAID){
            //首页还款按钮
            $repaymentButton = null;
            //还款按钮
            $repayButton = true;
            //还款时间
            $expire_time = strtotime($result['expire_time']);
            $time = strtotime(date('Y-m-d',time()));
            $day = ($expire_time-$time)/86400;//echo date('Y-m-d H:i:s','1456243200');
            $abs = abs($day);
            $repaymentTime = $abs.'天';
            $timeMoun = '距还款日还剩';
            if($abs==0){
                $statusOrder = '今日还款';

            }else{
                $statusOrder = '已放款';
            }
        }
        //关闭订单10
        if($result['status'] == Model_Home::PAGE_TO_CLOSED){
            $statusOrder = '订单已关闭';
            //首页还款按钮
            $repaymentButton = null;
            //还款时间
            $repaymentTime = '── ──';
            $timeMoun = '距还款日还剩';
        }

        //逾期中50，52
        if(in_array($result['status'],Model_Home::HOMEPAGE_CARD_INFO_OVERDUE)){
            $statusOrder = '好借好还，再借不难';
            //首页还款按钮
            $repaymentButton = null;
            //还款按钮
            $repayButton = true;
            $timeMoun = '已逾期';
            //还款时间
            //逾期计算
            if(Valid::not_empty($result['expire_time'])){
                $expire_time = strtotime($result['expire_time']);
                $time = strtotime(date('Y-m-d',time()));
                $day = ($expire_time-$time)/86400;//echo date('Y-m-d H:i:s','1456243200');
                $abs = abs($day);
                $repaymentTime = $abs.'天';
            }else{
                $repaymentTime = '── ──';
            }
        }
        //已还款51，61
        if(in_array($result['status'],Model_Home::HOMEPAGE_CARD_INFO_REPAYMENT)){
            $statusOrder = '已还款';
            //首页还款按钮
            $repaymentButton = null;
            //还款时间
            $repaymentTime = '── ──';
        }

        $currentOrder=array(
            'id' =>$result['id'],
            'timeMoun'=>$timeMoun,
            'loanAmount' =>"￥".$result['loan_amount'],
            'statusOrder'=>$statusOrder,
            'repaymentTime'=>$repaymentTime,
            'repaymentButton'=>$repaymentButton,
            'repayButton'=>$repayButton

        );
        return $currentOrder;
    }




    /*************************************************************
     *  会员申请贷款被拒绝原因
     *************************************************************/
	public function action_refuse(){
		$view = View::factory($this->_vv.'User/refuse');
		//分身份证没过的原因  和  订单关闭的原因
		if($this->request->query('type')=='identity'){
			$status = $this->_picauth->get_message();
			$view->message=$status['message'];
			$view->tit="注册";
			$view->title="审核失败";
			$view->url = URL::site('Again/index');
		}elseif($this->request->query('type')=='order'){
			$variable = array(
				"user_id"=>Gv::$_userInfo["user_id"],
				"app"=>$this->getWxInfo()
			);
			$json_info = json_encode($variable);
			$result = $this->_api->getApiArrays('Order','Current','',array('json'=>$json_info));
			if(isset($result['result']) && $result['code']==1000){
				//是否订单拒绝只有这一种需要确认
				if($result['result']['order']['status'] == 'reject'){
					if(Valid::not_empty($result['result']['order']['status_message'])){
						$view->message = $result['result']['order']['status_message'];
					}else{
						//暂无数据
						$view->message = Kohana::message('wx','no_data');
					}
				}else{
					//无拒绝订单
					$this->error(Kohana::message('wx','no_reject_order'));
					die;
				}
			}else{
				if(isset($result['code'])){
					$this->error($this->handleCode($result['code'],$result['message']));
					die;
				}else{
					//系统繁忙，请联系客服！
					$this->error(Kohana::message('wx','system_busy'));
					die;
				}
			}
			$view->tit="立即借款";
			$view->title="借款失败";
			$view->url = URL::site('Borrowmoney/index');
		}else{
			//非法请求
			$this->error(Kohana::message('wx','illegal_request'));
			die;
		}
		$this->response->body($view);
	}




	//单独获得订单状态(订单详情)
	public function order_status($result=null){

		if(empty($result)){
			return null;
		}
        $statusOrder = '── ──';

        if($result['status'] == Model_Home::PAGE_TO_INIT){
            $statusOrder = '预授权确定中';
        }


        //审核未通过（3）
        if($result['status'] == Model_Home::PAGE_TO_REJECT){
            $statusOrder = '审核未通过';
        }
        //审核中
        if(in_array($result['status'],Model_HOME::HOMEPAGE_CARD_INFO_EXAMINE)){
            $statusOrder = '放款审核中';
        }
        //还款处理中
        if(in_array($result['status'],Model_HOME::HOMEPAGE_CARD_INFO_REPAYMENTING)){
            $statusOrder = '还款处理中';
        }
        //审核未通过（3）
        if($result['status'] == Model_Home::PAGE_TO_REJECT){
            $statusOrder = '审核未通过';
        }
        //已放款5
        if($result['status'] == Model_Home::PAGE_TO_PAID){

            $expire_time = strtotime($result['expire_time']);
            $time = strtotime(date('Y-m-d',time()));
            $day = ($expire_time-$time)/86400;//echo date('Y-m-d H:i:s','1456243200');
            $abs = abs($day);
            if($abs==0){
                $statusOrder = "今日还款";

            }else{
                $statusOrder = "已放款，距还款日还有{$abs}天";

            }

        }
        //关闭订单10
        if($result['status'] == Model_Home::PAGE_TO_CLOSED){
            $statusOrder = '订单已关闭';
        }
        //还款处理中10
        if($result['status'] == Model_Home::PAGE_TO_REPAY_IN){
            $statusOrder = '还款处理中';
        }
        //逾期中50，52
        if(in_array($result['status'],Model_Home::HOMEPAGE_CARD_INFO_OVERDUE)){

            $expire_time = strtotime($result['expire_time']);
            $time = strtotime(date('Y-m-d',time()));
            $day = ($expire_time-$time)/86400;//echo date('Y-m-d H:i:s','1456243200');
            $abs = abs($day);
            $statusOrder = "已逾期{$abs}天";
        }
        //已还款51，61
        if(in_array($result['status'],Model_Home::HOMEPAGE_CARD_INFO_REPAYMENT)){
            $statusOrder = '已还款';
        }
        return $statusOrder;
	}

	//订单的状态
	public function action_describe(){
//		if(isset($_GET['id'])&&Valid::alpha_numeric($_GET['id'])){
		$variable = array(
			"user_id"=>Gv::$_userInfo["user_id"],
			"app"=>$this->getWxInfo()
		);
		$json_info = json_encode($variable);
		$result = $this->_api->getApiArrays('Order','Current','',array('json'=>$json_info));
		if(isset($result['result']) && $result['code']==1000){
			//注册成功,插入用户id
			if(isset($result['result']['order'])&&Valid::not_empty($result['result']['order'])){

//				$view = View::factory($this->_vv.'Account/describe');
                parent::$_VArray['title'] = Kohana::$config->load('url.title.describe');
                //订单状态

                $result['result']['order']['statusOrder'] = $this->order_status($result['result']['order']);
                if(isset($result['result']['order']['type'])&&$result['result']['order']['type'] != 'fast'){
                    $result['result']['order']['typeBank'] = true;
                    $result['result']['order']['ensure_rate'] = bcdiv($result['result']['order']['ensure_amount'],$result['result']['order']['loan_amount'],2)*100;
                }else{
                    $result['result']['order']['typeBank'] = false;
                    //计算担保比例
                }
                //统一处理金钱
                if(isset($result['result']['order'])&&!empty($result['result']['order'])){
                    $result['result']['order']['loan_amount'] = $this->MoneyStrStr($result['result']['order']['loan_amount']);
                    $result['result']['order']['payment_amount'] = $this->MoneyStrStr($result['result']['order']['payment_amount']);
                    $result['result']['order']['ensure_amount'] = $this->MoneyStrStr($result['result']['order']['ensure_amount']);
                    $result['result']['order']['credit_amount'] = $this->MoneyStrStr($result['result']['order']['credit_amount']);
                    $result['result']['order']['repayment_amount'] = $this->MoneyStrStr($result['result']['order']['repayment_amount']);
                    $result['result']['order']['refunded_amount'] = $this->MoneyStrStr($result['result']['order']['refunded_amount']);
                    //$view->describe['info']['con']['charge'] = $this->MoneyStrStr($view->describe['info']['con']['charge']);
                }
                //合计手续费
                $result['result']['order']['charge'] = $this->MoneyStrStr($result['result']['order_charge_total'][0]['amount']).$result['result']['order_charge_total'][0]['unit'];
                //循环获取手续费
                parent::$_VArray['order_charge_item'] = '';
                if(isset($result['result']['order_charge_item'])&&!empty($result['result']['order_charge_item'])){
                    foreach ($result['result']['order_charge_item'] as $val){
                        parent::$_VArray['order_charge_item'] .= '<p class="t-login-center-1 border-bottom check_charge"><span class="form-control float_left">'.$val['name'].'</span><label class="float_right">'.$val['amount'].$val['unit'].'</label></p>';
                    }
                }
                //费用扩展
                parent::$_VArray['order_charge_extension'] = '';
                if(isset($result['result']['order_charge_extension'])&&Valid::not_empty($result['result']['order_charge_extension'])){
                    foreach ($result['result']['order_charge_extension'] as $value){
                        parent::$_VArray['order_charge_extension']  .= '<p class="t-login-center-1 border-bottom"><span class="form-control float_left">'.$value['name'].'</span><label class="float_right">'.$value['amount'].$value['unit'].'</label></p>';
                    }
                }
                //扩展
                if(isset($result['result']['order_extension'])&&Valid::not_empty($result['result']['order_extension'])){
                    parent::$_VArray['extension'] = $result['result']['order_extension'];
                }else{
                    parent::$_VArray['extension'] = null;
                }
                parent::$_VArray['rateSummary'] = isset($result['result']['foot_html'])?$result['result']['foot_html']:null;
                parent::$_VArray['url'] = isset($_GET['jump'])?'/':'javascript:history.back(-1);';
                parent::$_VArray['requestUrl'] = "/wx/Functions/DownloadContract";
                parent::$_VArray['currentOrder'] = $result['result']['order'];

                $view = View::factory($this->_vv.'Account/describe');
                $view->_VArray =  parent::$_VArray;
                $this->response->body($view);
			}else{
				//暂无数据
				$this->error(Kohana::message('wx','no_data'));
				die;
			}
		}else{
			if(isset($result['code'])){
				//系统繁忙，请联系客服！
				$this->error($this->handleCode($result['code'],$result['message']));
				die;
			}else{
				//系统繁忙，请联系客服！
				$this->error(Kohana::message('wx','system_busy'));
				die;
			}
		}
//		}else{
//			//异常错误
//			$this->error(Kohana::message('wx','abnormal_error'));
//			die;
//		}
	}
	//单笔订单查询
	public function action_Singledescribe()
	{
		if (isset($_GET['id']) && Valid::alpha_numeric($_GET['id'])) {
			$variable = array(
				"user_id"=>Gv::$_userInfo["user_id"],
				"order_id"=>(int)$_GET['id'],
				"app"=>$this->getWxInfo()
			);
			$json_info = json_encode($variable);
			$result = $this->_api->getApiArrays('Order','Detail','',array('json'=>$json_info),'v');
            if(isset($result['result']) && $result['code']==1000){

//				$view = View::factory($this->_vv.'Account/describe');
                parent::$_VArray['title'] = Kohana::$config->load('url.title.describe');
				//订单状态

                $result['result']['order']['statusOrder'] = $this->order_status($result['result']['order']);
				if(isset($result['result']['order']['type'])&&$result['result']['order']['type'] != 'fast'){
                    $result['result']['order']['typeBank'] = true;
                    $result['result']['order']['ensure_rate'] = bcdiv($result['result']['order']['ensure_amount'],$result['result']['order']['loan_amount'],2)*100;
                }else{
                    $result['result']['order']['typeBank'] = false;
					//计算担保比例
				}

				//统一处理金钱
				if(isset($result['result']['order'])&&!empty($result['result']['order'])){
                    $result['result']['order']['loan_amount'] = $this->MoneyStrStr($result['result']['order']['loan_amount']);
                    $result['result']['order']['payment_amount'] = $this->MoneyStrStr($result['result']['order']['payment_amount']);
                    $result['result']['order']['ensure_amount'] = $this->MoneyStrStr($result['result']['order']['ensure_amount']);
                    $result['result']['order']['credit_amount'] = $this->MoneyStrStr($result['result']['order']['credit_amount']);
                    $result['result']['order']['repayment_amount'] = $this->MoneyStrStr($result['result']['order']['repayment_amount']);
                    $result['result']['order']['refunded_amount'] = $this->MoneyStrStr($result['result']['order']['refunded_amount']);
					//$view->describe['info']['con']['charge'] = $this->MoneyStrStr($view->describe['info']['con']['charge']);
				}
				//合计手续费
                $result['result']['order']['charge'] = $this->MoneyStrStr($result['result']['order_charge_total'][0]['amount']).$result['result']['order_charge_total'][0]['unit'];
				//循环获取手续费
				parent::$_VArray['order_charge_item'] = '';
				if(isset($result['result']['order_charge_item'])&&!empty($result['result']['order_charge_item'])){
					foreach ($result['result']['order_charge_item'] as $val){
                        parent::$_VArray['order_charge_item'] .= '<p class="t-login-center-1 border-bottom check_charge"><span class="form-control float_left">'.$val['name'].'</span><label class="float_right">'.$val['amount'].$val['unit'].'</label></p>';
					}
				}
				//费用扩展
				parent::$_VArray['order_charge_extension'] = '';
				if(isset($result['result']['order_charge_extension'])&&Valid::not_empty($result['result']['order_charge_extension'])){
					foreach ($result['result']['order_charge_extension'] as $value){
                        parent::$_VArray['order_charge_extension']  .= '<p class="t-login-center-1 border-bottom"><span class="form-control float_left">'.$value['name'].'</span><label class="float_right">'.$value['amount'].$value['unit'].'</label></p>';
					}
				}
				//扩展
				if(isset($result['result']['order_extension'])&&Valid::not_empty($result['result']['order_extension'])){
                    parent::$_VArray['extension'] = $result['result']['order_extension'];
				}else{
                    parent::$_VArray['extension'] = null;
				}
				//还款按钮
                if(isset($result['result']['foot_button'])&&Valid::not_empty($result['result']['foot_button'])){
				    if($result['result']['foot_button']['hidden']==0){
                        //显示
                        parent::$_VArray['foot_button'] = "<section class='t-login-footer'><p class='t-error'></p><a class='t-orange-btn position_bottom t-register-button' href='/Repaymoney'>{$result['result']['foot_button']['title']}</a></section>";
                    }else{
                        parent::$_VArray['foot_button'] = '';
                    }
                }else{
                    parent::$_VArray['foot_button'] = '';
                }
				parent::$_VArray['rateSummary'] = isset($result['result']['foot_html'])?$result['result']['foot_html']:null;
				parent::$_VArray['url'] = isset($_GET['jump'])?'/':'javascript:history.back(-1);';
                parent::$_VArray['requestUrl'] = "/wx/Functions/DownloadContract";
                parent::$_VArray['currentOrder'] = $result['result']['order'];
                $view = View::factory($this->_vv.'Account/describe');
                $view->_VArray =  parent::$_VArray;
                $this->response->body($view);
			}else{
				if(isset($result['code'])){
					//系统繁忙，请联系客服！
					$this->error($this->handleCode($result['code'],$result['message']));
					die;
				}else{
					//系统繁忙，请联系客服！
					$this->error(Kohana::message('wx','system_busy'));
					die;
				}
			}
		}else{
            //异常错误
            $this->error(Kohana::message('wx', 'abnormal_error'));
            die;
        }

	}

}


