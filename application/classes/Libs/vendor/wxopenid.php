<?php
class Libs_vendor_wxopenid {
	private $appId;
	private $appSecret;
	private $callbackurl;//回调地址
	private $state;//回调后带的参数

//	public function __construct($appId, $appSecret,$callbackurl,$state) {

//	}
	public function init($appId, $appSecret,$callbackurl,$state) {
		$wx = New Libs_vendor_wxopenid();
		$wx->appId = $appId;
		$wx->appSecret = $appSecret;
		$wx->callbackurl = $callbackurl;
		$wx->state = $state;
		return $wx;
	}
	public function getCode($str = null){
		//判断是否是关注微信号
		if(!empty($str)){
			$this->callbackurl = $this->callbackurl.$str;
		}
		$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->appId.'&redirect_uri='.urlencode($this->callbackurl).'&response_type=code&scope=snsapi_userinfo&state='.$this->state.'#wechat_redirect';
		header("Location:".$url);
	}
	public function getOpenId($code){
		$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appId.'&secret='.$this->appSecret.'&code='.$code.'&grant_type=authorization_code';
		return json_decode($this->curlopen($get_token_url),true);
	}
	public function getUserInfo($access_token,$openid){
		$get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
		return json_decode($this->curlopen($get_user_info_url),true);
	}
	private function curlopen($url, $data = array()){
	
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		if(!empty($data)){
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		}
		$return = curl_exec ( $ch );
		curl_close ( $ch );
		return $return;
	}
}

