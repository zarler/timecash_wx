<?php defined('SYSPATH') or die('NoD direct script access.');
/*
*/
class Task_WxCrontab extends Minion_Task
{
	protected  $_options = array();
	
	public function _execute(array $params){
		$appId = Kohana::$config->load('wx.appId');
		$appSecret = Kohana::$config->load('wx.appSecret');
		echo date('Y-m-d H:i:s').' : ' . __CLASS__ . "\n";
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appSecret";
		$res = json_decode($this->httpGet($url),true);
		$accessToken = $res['access_token'];
		DB::update('wxconst')->set(array('val'=>$accessToken))->where('name','=','TOKEN')->execute();
		echo 'TOKEN: '.$accessToken ."\n";
		$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
		$res = json_decode($this->httpGet($url),true);
		$ticket = $res['ticket'];
		DB::update('wxconst')->set(array('val'=>$ticket))->where('name','=','TICKET')->execute();
		echo 'TICKET: '.$ticket ."\n" . date('Y-m-d H:i:s').' : ' . __CLASS__ . "end \n";
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