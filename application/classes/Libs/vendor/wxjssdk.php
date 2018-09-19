<?php
class Libs_vendor_wxjssdk{
	private $appId;
	private $appSecret;
	private $token;
	private $ticket;

//	public function __construct($appId, $appSecret,$token,$ticket) {
//
//		$this->appId = $appId;
//		$this->appSecret = $appSecret;
//		$this->token = $token;
//		$this->ticket = $ticket;
//	}
	public function init($appId, $appSecret,$token,$ticket){
		$wx = new Libs_vendor_wxjssdk();
		$wx->appId = $appId;
		$wx->appSecret = $appSecret;
		$wx->token = $token;
		$wx->ticket = $ticket;
		return $wx;
	}



	public function getSignPackage() {
		$jsapiTicket = $this->ticket;
		// 注意 URL 一定要动态获取，不能 hardcode.
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$timestamp = time();
		//16位随机数

        $nonceStr = $this->createNonceStr();
		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		//$string = 'jsapi_ticket='.$jsapiTicket.'&noncestr='.$nonceStr.'&amp;timestamp='.$timestamp.'&url='.$url.'';
		$string = 'jsapi_ticket='.$jsapiTicket.'&noncestr='.$nonceStr.'&timestamp='.$timestamp.'&url='.$url.'';
		$signature = sha1($string);
		$signPackage = array(
		"appId"     => $this->appId,
		"nonceStr"  => $nonceStr,
		"timestamp" => $timestamp,
		"url"       => $url,
		"signature" => $signature,
		"rawString" => $string
		);
		return $signPackage; 
	}
	//获取上传到微信服务器的图片（兼容ios）
	public function imgUpload($imgid){
		$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->token.'&media_id='.$imgid;
		$img = file_get_contents($url);
		//获取返回的头信息 用于截取文件后缀
		$responseInfo = $this->parseHeaders($http_response_header);		
		preg_match_all('/filename=\"(.*?)\"/is',$responseInfo['Content-disposition'],$filename);
		$imgArr['binary']=base64_encode($img);
		$imgArr['name']=$filename[1][0];
		$imgArr['size']=$responseInfo['Content-Length'];
		//file_put_contents('abc.txt',var_export($imgArr,true));
		return $imgArr;
		//后缀
		//print_r($responseInfo);exit;
		if(!empty($filename[1][0])){
			$ext = substr(strrchr($filename[1][0], '.'), 1);
		}else{
			return false;
		} 
		//$ext='jpg';
		//生成文件的名称  时间戳加6个随机数
		//$url ='./user_identity/idcard/'.date('Y').'/'.date('m') . date('d') . '/' ;
		$url = './user_picauth/';
		//检查文件夹是否存在 不存在创建
		$this->directorys($url);
		
		$image =$url . time() . $this->createNonceStr(6) . '.' . $ext;
		//生成图片保留到本地
		$fp = @fopen($image, "w");
		fwrite($fp,  $img);
		fclose($fp);
		return substr($image,15);
	}
	//生成随机数
	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}

/* 	private function getJsApiTicket() {
		// jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
		//$data = json_decode($this->get_php_file("jsapi_ticket.php"));

		if (empty($_SESSION['wx']['ticket_time']) || $_SESSION['wx']['ticket_time'] < time()) {
			$accessToken = $this->getAccessToken();
			// 如果是企业号用以下 URL 获取 ticket
			// $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
			$res = json_decode($this->httpGet($url),true);
			$ticket = $res['ticket'];
			if ($ticket) {
				//$data->expire_time = time() + 7000;
				//$data->jsapi_ticket = $ticket;
				$_SESSION['wx']['ticket_time'] = time() + 5000;
				$_SESSION['wx']['jsapi_ticket'] = $ticket;
			}
		} else {
			$ticket = $_SESSION['wx']['jsapi_ticket'];
		}

		return $ticket;
	}

	private function getAccessToken() {
		// access_token 应该全局存储与更新，以下代码以写入到文件中做示例
		//$data = json_decode($this->get_php_file("access_token.php"));

		if (empty($_SESSION['wx']['token_time']) || $_SESSION['wx']['token_time'] < time()) {
			// 如果是企业号用以下URL获取access_token
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
			$res = json_decode($this->httpGet($url),true);
			$access_token = $res['access_token'];
			if ($access_token) {
				//$data->expire_time = time() + 7000;
				//$data->access_token = $access_token;
				$_SESSION['wx']['access_token'] = $access_token;
				$_SESSION['wx']['token_time'] = time() + 5000;
			}
		} else {
		//$access_token = Session::instance()->get('access_token');
			$access_token = $_SESSION['wx']['access_token'];
		}
		return $access_token;
	}

	private function httpGet($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);
		// 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
		// 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_URL, $url);

		$res = curl_exec($curl);
		curl_close($curl);

		return $res;
	} */
  	//生成上传到的目录 如果目录不存在 生成目录
	protected function  directorys($dir){    
		return   is_dir ( $dir )  or  ($this->directorys(dirname( $dir ))  and   mkdir ( $dir , 0777, true));
	}
	
	private function parseHeaders( $headers ){
		$head = array();
		foreach( $headers as $k=>$v )
		{
			$t = explode( ':', $v, 2 );
			if( isset( $t[1] ) )
				$head[ trim($t[0]) ] = trim( $t[1] );
			else
			{
				$head[] = $v;
				if( preg_match( "#HTTP/[0-9\.]+\s+([0-9]+)#",$v, $out ) )
					$head['reponse_code'] = intval($out[1]);
			}
		}
		return $head;
	}

	//获取用户二维码(渠道场景id) $v有值为永久二维码
	public function img2weima($scene_id=null,$v=null){

		if(empty($scene_id)){
			return false;
		}

		//"{\"action_name\":\"QR_LIMIT_SCENE\",\"action_info\":{\"scene\":{\"scene_id\":12}}}
		$weixinModel = Model::factory('Wx');
		$info2weima = $weixinModel->get_2weimainfo($scene_id);
		if(Valid::not_empty($info2weima)){
			//如果超时了重新申请$ticket
			if((empty($info2weima['expire_seconds'])||time()+1000>$info2weima['expire_seconds'])&&$info2weima['action_name']=='QR_SCENE'){
				//申请二维码ticket值
				//临时
				if(empty($v)){
					$action_name = "QR_SCENE";
					$qrcode = '{"expire_seconds": 2592000, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
				}else{
					$action_name = "QR_LIMIT_SCENE";
					$qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
				}
				//获取ticket值
				$_postRequest = Tool::factory('URLRequest');
				$result = $_postRequest->https_post('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->token,$qrcode);
				$jsoninfo = json_decode($result, true);
				$weixinModel->update_2weimainfo(array('ticket'=>$jsoninfo["ticket"],'action_name'=>$action_name,'expire_seconds'=>time()+$jsoninfo["expire_seconds"],'url'=>$jsoninfo["url"]),$scene_id);
				$ticket = $jsoninfo['ticket'];
			}else{
				$ticket = $info2weima['ticket'];
			}
		}else{
			//申请二维码ticket值
			//临时
			if(empty($v)){
				$action_name = "QR_SCENE";
				$qrcode = '{"expire_seconds": 2592000, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
			}else{
				$action_name = "QR_LIMIT_SCENE";
				$qrcode = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';
			}
			//获取ticket值
			$_postRequest = Tool::factory('URLRequest');
			$result = $_postRequest->https_post('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->token,$qrcode);
			$jsoninfo = json_decode($result, true);

			if(empty($v)){
				$insert_id = $weixinModel->insert_2weimainfo(array('scene_id'=>$scene_id,'ticket'=>$jsoninfo["ticket"],'action_name'=>$action_name,'expire_seconds'=>time()+$jsoninfo["expire_seconds"],'url'=>$jsoninfo["url"],'create_time'=>time()));
			}else{
				$insert_id = $weixinModel->insert_2weimainfo(array('scene_id'=>$scene_id,'ticket'=>$jsoninfo["ticket"],'action_name'=>$action_name,'expire_seconds'=>time(),'url'=>$jsoninfo["url"],'create_time'=>time()));
			}


			if($insert_id){
				$ticket = $jsoninfo['ticket'];
			}
		}
		if(!isset($ticket)||empty($ticket)){
			return false;
		}
		//通过ticke获取二维码
		//$result_img = $_postRequest->https_post('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket,null);
		return 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$ticket;
	}




}

