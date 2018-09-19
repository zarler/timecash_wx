ls<?php defined('SYSPATH') or die('NoD direct script access.');
/*
*/
class Task_WxCrontabNew extends Minion_Task
{
	protected  $_options = array();
	
	public function _execute(array $params){
		//配置文件里的微信appId和appSecret
		$appId = Kohana::$config->load('site.wx.appId');
		$appSecret = Kohana::$config->load('site.wx.appSecret');
		$token = $this->httpGet('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appId.'&secret='.$appSecret.'');
		$token_json = json_decode($token,true);
		$accessToken = $token_json['access_token'];
		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
		$wx_card = $this->httpGet($url);
		$wx_card_json = json_decode($wx_card,true);
		echo DB::update('wxconst')->set(array('token'=>$accessToken,'ticket'=>$wx_card_json['ticket'],'expires_in'=>$token_json['expires_in']+time()))->where('status','=','1')->compile();
		//DB::update('wxconst')->set(array('token'=>$accessToken,'ticket'=>$wx_card_json['ticket'],'expires_in'=>$token_json['expires_in']+time()))->where('status','=','1')->execute();
		//echo 'access_token: '.$accessToken ."\n" .'ticket: '.$wx_card_json['ticket'] ."\n" . date('Y-m-d H:i:s').' : ' . __CLASS__ . "end \n";
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
	}
}