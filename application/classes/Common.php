<?php defined('SYSPATH') or die('No direct script access.');
	/*
		主要用于微信授权登录
		登录前和登录后的一般通用方法
	*/
    class Common extends Controller {
		protected $_api_config= null;
		protected $_site_config= null;
		protected $_session = null;
		protected $_api = null;
		protected $_model = null;
		protected $_controller = NULL;
		protected $_action = NULL;
		protected $_directory = NULL;
		//ip
		protected $_ip = null;
        //互动变量
        public static $_VArray = null;
		//view模板版本
		protected $_vv = null;
        public function before(){

//            $this->ip_limit();

//			if($this->checkSignature()){
//				echo $_GET['echostr'];
//				die;
//			}
			parent::before();
			self::init();
		}
		protected function init(){
			$this->_controller = Request::current()->controller();
			$this->_action = Request::current()->action();
			$this->_directory = Request::current()->directory();
			$this->_api_config = Kohana::$config->load('api');

			$this->_site_config = Kohana::$config->load('site');
			$this->_session = Model::factory('Session');
			$this->_api = Tool::factory('API');

			//获取ip
			$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR'])&&$_SERVER['HTTP_X_FORWARDED_FOR']?$_SERVER['HTTP_X_FORWARDED_FOR']:(isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'');
			$this->_ip = explode(",",$ip)[0];

			if(isset($this->_site_config['config']['view_version'])&&!empty($this->_site_config['config']['view_version'])){
				$this->_vv = $this->_site_config['config']['view_version'].'/';
			}else{
				$this->_vv = '';
			}
		}
		//生成公共app变量(wx)
		protected  function getapp(){
			$trid = time().Text::random('numeric',8);
			$time = Date('Y-m-d H:i:s',time());
			$openid = $this->_session->sessionGet('wx')['openid'];
			$openid = Valid::not_empty($openid)?$openid:'';
			$api_token = $this->_session->sessionGet('api_token');
			if(!Valid::not_empty($api_token)){
				$app_str = '' . $this->_api_config['wx']['app_id'] . $trid . md5($this->_api_config['wx']['app_key']) . $time ;
				return array('os'=>$this->_api_config['wx']['app_id'],'ver'=>$this->_api_config['wx']['ver'],'ip'=>$this->_ip,'unique_id'=>$openid,'trid'=>$trid,'time'=>$time,'app_id'=>$this->_api_config['wx']['app_id'],'sign'=>md5(md5($app_str).$this->_api_config['wx']['app_key']));
			}else{
				$app_str = $api_token. $this->_api_config['wx']['app_id'] . $trid . md5($this->_api_config['wx']['app_key']) . $time ;
				return array('os'=>$this->_api_config['wx']['app_id'],'ver'=>$this->_api_config['wx']['ver'],'ip'=>$this->_ip,'unique_id'=>$openid,'trid'=>$trid,'time'=>$time,'app_id'=>$this->_api_config['wx']['app_id'],'token'=>$api_token,'sign'=>md5(md5($app_str).$this->_api_config['wx']['app_key']));
			}
		}

		//生成公共app变量(app)
		protected  function getappapp($app_token){
			$trid = time().Text::random('numeric',8);
			$time = Date('Y-m-d H:i:s',time());
			$app_str = $app_token . $this->_api_config['app_h5']['app_id'] . $trid . md5($this->_api_config['app_h5']['app_key']) . $time ;
			$openid = $this->_session->sessionGet('wx')['openid']?$this->_session->sessionGet('wx')['openid']:'';

			return array('os'=>$this->_api_config['app_h5']['app_id'],'ver'=>$this->_api_config['app_h5']['ver'],'ip'=>$this->_ip,'unique_id'=>$openid,'trid'=>$trid,'time'=>$time,'app_id'=>$this->_api_config['app_h5']['app_id'],'token'=>$app_token,'sign'=>md5(md5($app_str).$this->_api_config['app_h5']['app_key']));
		}

	
		//v3版本通过token获取用户信息(app)($app_token当为默认的时候,为基本信息请求target_token)
		protected  function getAppInfo($app_token=''){
			$trid = time().Text::random('numeric',8);
			$time = Date('Y-m-d H:i:s',time());

            $app_str = $app_token . $this->_api_config['app_h5']['app_id'] . $trid . md5($this->_api_config['app_h5']['app_key']) . $time ;
			return array('os'=>$this->_api_config['app_h5']['app_id'],'ver'=>$this->_api_config['app_h5']['ver'],'ip'=>$this->_ip,'unique_id'=>'','trid'=>$trid,'time'=>$time,'app_id'=>$this->_api_config['app_h5']['app_id'],'token'=>$app_token,'sign'=>md5(md5($app_str).$this->_api_config['app_h5']['app_key']));
		}
		//v3版本微信获取token 请求api3获取基本数据
		protected  function getWxInfo()
		{
			$trid = time() . Text::random('numeric', 8);
			$time = Date('Y-m-d H:i:s', time());
			$openid = Valid::not_empty(Gv::$_Openid) ? Gv::$_Openid : '';
			$api_token = Valid::not_empty(Gv::$_userInfo['token']) ? Gv::$_userInfo['token'] : '';
			$app_str = $api_token . $this->_api_config['wx']['app_id'] . $trid . md5($this->_api_config['wx']['app_key']) . $time;
			return array('os' => $this->_api_config['wx']['app_id'], 'ver' => $this->_api_config['wx']['ver'], 'ip' => $this->_ip, 'unique_id' => $openid, 'trid' => $trid, 'time' => $time, 'app_id' => $this->_api_config['wx']['app_id'], 'token' => $api_token, 'sign' => md5(md5($app_str) . $this->_api_config['wx']['app_key']));
		}
        protected  function getH5Info($api_token='')
        {
            $trid = time() . Text::random('numeric', 8);
            $time = Date('Y-m-d H:i:s', time());
            $app_str = $api_token . $this->_api_config['app_h5']['app_id'] . $trid . md5($this->_api_config['app_h5']['app_key']) . $time;
            return array('os' => $this->_api_config['app_h5']['app_id'], 'ver' => $this->_api_config['app_h5']['ver'], 'ip' => $this->_ip, 'unique_id' => '', 'trid' => $trid, 'time' => $time, 'app_id' => $this->_api_config['app_h5']['app_id'], 'token' => $api_token, 'sign' => md5(md5($app_str) . $this->_api_config['app_h5']['app_key']));
        }



        //转路由
        function Routingnew($kw1){
            $returnArr = null;
		    if(isset($kw1['name'])&&Valid::not_empty($kw1['name'])){
                switch ($kw1['name']){
                    //借款记录
                    case 'order_list':
                        $returnArr['url'] = '/Account/BorrowingRecords';
                        $returnArr['icon'] = '/static/images/v2/icon-Record.png';
                        break;
                    //银行卡
                    case 'card_list':
                        $returnArr['url'] = '/Account/bankCreditList';
                        $returnArr['icon'] = '/static/images/v2/icon--card.png';
                        break;
                    //问题
                    case 'faq':
                        $returnArr['url'] = '/Protocol/Problem';
                        $returnArr['icon'] = '/static/images/v2/icon-question.png';
                        break;
                    //我的钱包
                    case 'user_wallet':
                        $returnArr['url'] = isset($kw1['left_url'])?$kw1['left_url']:'';
                        $returnArr['icon'] = isset($kw1['left_icon'])?$kw1['left_icon']:'';
                        break;
                    //设置
                    case 'user_settings':
                        $returnArr['url'] = '/SetUp/HomePage';
                        $returnArr['icon'] = '/static/images/v2/icon_shezhi.png';
                        break;
                    default:
                        $returnArr['url'] = isset($kw1['left_url'])?$kw1['left_url']:'';
                        $returnArr['icon'] = isset($kw1['left_icon'])?$kw1['left_icon']:'';
                        break;
                }
                return $returnArr;
            }else{
                $this->error('异常错误！');
                die;
            }

        }







        //转路由
        function Routing($kw1,$arr=null){

            preg_match("#app://app.timecash(.*)(.*?[^,\?])?#", $kw1, $a);
            $str = strstr($a[1],'?',true);
            if(!Valid::not_empty($str)){
                $str =  $a[1];
            }
            $returnArr = null;
            //url跳转地址  icon图片样式
            switch ($str){
                case '/Order/List':
                    $returnAr['url'] = '/Account/BorrowingRecords';
                    $returnAr['icon'] = 'record_icon_i';
                    break;
                case '/User/CreditList':
                    $returnAr['url'] = '/Account/Promote';
                    $returnAr['icon'] = 'creditgranting_icon_i';
                    break;
                case '/BankCard/List':
                    //授信判断银行卡入口
//                    if(isset($arr['/BankCard/List'])) {
//                        if ($arr['/BankCard/List']) {
//                            $returnAr['url'] = '/Account/bankCreditList';
//                        } else {
//                            $returnAr['url'] = "javascript:commonUtil.showconfirm('请先下载APP完成基础授信','下载APP')";
//                        }
//                    }else{
//                        $returnAr['url'] = 'javascript:;';
//                    }
                    $returnAr['url'] = '/Account/bankCreditList';
                    $returnAr['icon'] = 'card_icon_i';
                    break;
                case '/User/Wallet':
                    if(strpos($kw1, 'MyWallet')){
                        $returnAr['url'] = '/wx/MyWallet/HomePage';
                        $returnAr['icon'] = 'quit_icon_i';
                    }else{
                        $returnAr['url'] = '/wx/MyCard/MyList';
                        $returnAr['icon'] = 'quit_icon_i';

                    }
                    break;
//                case '/User/Wallet':
//                    $returnAr['url'] = '/wx/MyCard/MyList';
//                    $returnAr['icon'] = 'quit_icon_i';
                    break;
                case '/Faq/Index':
                    $returnAr['url'] = '/Protocol/Problem';
                    $returnAr['icon'] = 'question_icon_i';
                    break;
                case '/User/Settings':
                    $returnAr['url'] = '/SetUp/HomePage';
                    $returnAr['icon'] = 'quit_icon_shezhi';
                    break;
//          极速贷
                case '/FastLoan/Start':
                    $returnAr['url'] = '/Borrowmoney/extremeBorrow';
                    break;
//          全担保借款
                case '/FullPreAuthLoan/Start':
                    $returnAr['url'] = '/Borrowmoney/borrow?type=FullPreAuthLoan';
                    break;
//          半担保借款
                case '/PreAuthLoan/Start':
                    $returnAr['url'] = '/Borrowmoney/borrow?type=PreAuthLoan';
                    break;
//          首页
                case '/AppHome/Index':
                    $returnAr['url'] = '/';
                    break;
                default:
                    $returnAr['url'] = 'javascript:;';
                    $returnAr['icon'] = 'record_icon_i';
                    break;
            }
            return $returnAr;

        }


		//curl 发送post数据 或者请求地址 用于各个接口调用
		protected function curlopen($url, $data = array(),$head=array()){
			$HTTPAPPID = Kohana::$config->load('wx.HTTPAPPID');
			$HTTPSECRET = Kohana::$config->load('wx.HTTPSECRET');
			if(empty($data)){
				foreach($data as $k=>$v){
					$data[$k]=(string)$v;
				}
			}
			$head[]="APPSIGN:".md5(json_encode($data).$HTTPSECRET);
			$head[]="APPID:".$HTTPAPPID;
			return HttpClient::factory($url)->post($data)->httpheader($head)->execute()->body();
		}
		//百度经纬度
		protected function bd_map($x,$y){
			$url_bd_xy_gps =  Kohana::$config->load('url.communic_url.baidu_api_gps')."?coords={$x},{$y}&from=1&to=5&ak=".Kohana::$config->load('site.baidu.ak');
			$bd_XY_arr = $this->_api->getApiArraysUrl($url_bd_xy_gps);
			if($bd_XY_arr['code']==1000){
				if($bd_XY_arr['data']['status']==0){
					$url = Kohana::$config->load('url.communic_url.baidu_api_bz')."?ak=".Kohana::$config->load('site.baidu.ak')."&coordtype=wgs84ll&location={$bd_XY_arr['data']['result'][0]['y']},{$bd_XY_arr['data']['result'][0]['x']}&output=json";
					$bd_address_arr = $this->_api->getApiArraysUrl($url);
					if($bd_address_arr['code']==1000){
						if($bd_address_arr['data']['status']==0){
							$bmap['lng'] = $bd_address_arr['data']['result']['location']['lng'];
							$bmap['lat'] = $bd_address_arr['data']['result']['location']['lat'];
							$bmap['formatted_address'] = $bd_address_arr['data']['result']['formatted_address'];
							$bmap['city'] = $bd_address_arr['data']['result']['addressComponent']['city'];
							$bmap['country'] = $bd_address_arr['data']['result']['addressComponent']['country'];
							$bmap['district'] = $bd_address_arr['data']['result']['addressComponent']['district'];
							$bmap['province'] = $bd_address_arr['data']['result']['addressComponent']['province'];
							$bmap['street'] = $bd_address_arr['data']['result']['addressComponent']['street'];
							$bmap['street_number'] = $bd_address_arr['data']['result']['addressComponent']['street_number'];
							$bmap['business_circle'] = $bd_address_arr['data']['result']['business'];
							return $bmap;
						}else{
							Model::factory('Home')->insert_log(array('address'=>'common.php的bd_map()','message'=>$bd_address_arr['data']['message']));
							return null;
						}
					}else{
						Model::factory('Home')->insert_log(array('address'=>'common.php的bd_map()','message'=>$bd_address_arr['data']['message']));
						return null;
					}
				}else{
					Model::factory('Home')->insert_log(array('address'=>'common.php的bd_map()','message'=>$bd_XY_arr['data']['message']));
					return null;
				}
			}else{
				Model::factory('Home')->insert_log(array('address'=>'common.php的bd_map()','message'=>$bd_XY_arr['data']['message']));
				return null;
			}
		}
		//公共session检测
		protected function check_session($key){
			$data = $this->_session->sessionGet($key);
			if($data){
				return array('status'=>true,'data'=>$data);
			}else{
				return array('status'=>false);
			}
		}
		//发送验证码  $prefix 存到session的前缀
		protected function phoneCode($codesession,$phone,$prefix,$inviter_user_id=null){
			if(empty($codesession) || time() - $codesession['time'] > $codesession['next_send']){
				$variable = array(
					"mobile"=>$phone,
					'inviter_user_id'=>$inviter_user_id,
					"app"=>$this->getWxInfo()
				);
				$json_info = json_encode($variable);
				switch($prefix){
					case 'sendcode':
						$result = $this->_api->getApiArrays('User','RegisterVerifySMS','',array('json'=>$json_info),'v');
						if(isset($result) && $result['code']==1000){
							$result['result']['time'] = time();
							$this->_session->sessionSet('sendcode',$result['result']);
							return json_encode(array('status' =>true,'userid'=>isset($result['result']['user_id'])?$result['result']['user_id']:null,'coupons'=>isset($result['result']['coupons'])?$result['result']['coupons']:null));
						}else{
							if(isset($result['code'])){
								return json_encode(array('status' =>false,'code'=>$result['code'],'msg'=>$result['message']));
							}else{
								//系统繁忙，请联系客服！
								return json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy')));
							}
						}
						break;
					case 'resetcode':
						$result = $this->_api->getApiArrays('User','ResetPasswordVerifySMS','',array('json'=>$json_info));
						if(isset($result) && $result['code']==1000){
							$result['result']['time'] = time();
							$this->_session->sessionSet('resetcode',$result['result']);
							return json_encode(array('status' =>true));
						}else{
							if(isset($result['code'])){
								return json_encode(array('status' =>false,'msg'=>$result['message']));
							}else{
								//系统繁忙，请联系客服！
								return json_encode(array('status' =>false,'msg'=>Kohana::message('wx','system_busy')));
							}
						}
						break;
					default:
						//异常错误
						return json_encode(array('status' =>false,'msg'=>Kohana::message('wx','abnormal_error')));
						break;
				}
			}else{
				if($codesession['send_count']>=$codesession['max_count']){
					//今日申请次数太多
					return array('status' =>false,'msg'=>Kohana::message('wx','apply_frequently'));
				}else{
					//操作繁忙
					return json_encode(array('status' =>false,'msg'=>Kohana::message('wx','busy_operation')));
				}
			}
		}
	//错误处理 发送到错误页面
	protected function error($error,$type=null){
		$view = View::factory($this->_vv.'Error/index');
		$view->error = $error;
		$view->type = $type;
		$view->url = '/User/index?#jump=no';
		$out = $view->render();
		exit( $out);
	}

	//错误处理 app进入该页面的报错信息
	protected function error_app(){
		$view = View::factory('Error/indexApp');
		$view->error = '快金已简化降担保流程,无需填写本项信息,请搜索关注快金微信公众号,下载新版APP,申请降担保';
		$view->type = null;
		$view->url = '/User/index?jump=no';
		$out = $view->render();
		exit( $out);
	}
	
	//上传图片url专用
	protected function curl($url,$json,$post){
		$ch = curl_init();
		$post['json'] = $json;
		curl_setopt($ch, CURLOPT_NOBODY, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTP_VERSION  , CURL_HTTP_VERSION_1_0 );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_TIMEOUT, 90);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
		//CURLFile这个类只支持php5.5+版本
		$post['pic1'] = new CURLFile($post['pic1']);
		$post['pic2'] = new CURLFile($post['pic2']);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$res = curl_exec($ch);
		curl_close($ch);
		if(empty($res) ){
			$ListArray=false;
		}else{
			$ListArray = json_decode($res,true);
		}
		return $ListArray;
	}
	//获取jssdk所需要的值
	protected function signPackage(){
		$wx = $this->wxconfig();
		$signPackage = $wx->GetSignPackage();
		return $signPackage;
	}
	protected function wxconfig(){
		//配置文件里的微信appId和appSecret
		$appId = $this->_site_config['wx']['appId'];
		$appSecret = $this->_site_config['wx']['appSecret'];
		$wechat_token = Libs::factory('TCCache_Wechat')->uri(Model_Wechat_Token::WX_KEY)->get();

        if(!$wechat_token){
			$wechat_token = Model::factory('Home')->get_token();
			//$wechat_token = $this->model['wechat_token']->get_one();
			if(!$wechat_token){
				//获得token值失败
				$this->error(Kohana::message('获取微信token失败'));
			}
		}
        $wx = Libs::factory('vendor_wxjssdk')->init($appId,$appSecret,$wechat_token['token'],$wechat_token['ticket']);

        return $wx;
	}

    //把图片从微信服务器拿到本地服务器
    protected function wxupload($post){
        //获取微信配置的对象
        $wx = $this->wxconfig();
        //请求微信下载多媒体接口(需要在这做循环获取图片)
        $dir = $wx->imgUpload($post['serverid']);
        $imgurl = Kohana::$config->load('url.communic_url.imgupload_url');
        $imgJson['_file'] = json_encode($dir);
        //1111  微信的上传api的一个密钥
        $res = json_decode(HttpClient::factory($imgurl)->post($imgJson)->httpheader(array("CLIENTID:wx","CLIENTSIGN:".md5(json_encode($imgJson).'1111')))->execute()->body(),true);

        if($res['status']==true){
            return json_encode(array('pic'=>$dir['binary'],'hash'=>$res['hash']));
        }else{
            return false;
        }


    }


    //申请token
	protected function getFirstToken(){;
		$json = json_encode(array('app'=>$this->getWxInfo()));
		return $this->_api->getApiArrays('Token','Create',"",array('json'=>$json));
	}
	//续约token
	protected function getRenewToken(){
		$json = json_encode(array('app'=>$this->getapp()));
		return $this->_api->getApiArrays('Token','Renew',"",array('json'=>$json));
	}
	//统一处理code码
	protected function handleCode($code,$message = null){
		switch ($code){
			case 4005:
			case 5072:
			case 5113:
			case 5060:
			case 4012:
			case 4000:
			case 2000:
			case 2001:
			case 2010:
			case 2011:
			case 2012:
			case 2002:
			case 2005:
			case 2003:
			case 2022:
			case 5014:
			case 5013:
			case 4008:
			case 4009:
			case 5012:
			case 5066:
			case 5065:
			case 5064:
			case 5003:
			case 5116:
				$message = "出错啦！请联系客服（错误代码".$code."）";
				break;
			default:
				break;
		}
		return $message;
	}
	//金钱点截取函数
	protected function MoneyStrStr($money=null){
		if(empty($money)){
			return 0;
		}
		if(substr(strstr($money, '.',0),-2)==00){
			return (int)$money;
		}else{
			return $money;
		}
	}
	//微信绑定网站
	private function checkSignature()
	{
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];
		$token = "weixin";
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		//die;
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	//ip限制
	public function ip_limit(){
		$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
		$ip = explode(",",$ip)[0];
		if(in_array($ip,array('61.51.129.141','61.51.129.138'))){
		}else{
			echo '维护中.....';
			die;
		}
	}
    //获取ip地址
    public function getIp(){
        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
        return trim(explode(",",$ip)[0]);
    }

    //加载中
    public function Load(){
        echo '<body style="margin: 0;padding: 0"><div class="t-mask-loading" style="display: block;position: fixed;width: 100%;height: 100%;background: white;z-index: 100;"><img style="width:10%;margin: 60% auto;display: -webkit-box;" src="/static/ui_bootstrap/layer/skin/default/loading-2.gif"></div></body>';
    }
}