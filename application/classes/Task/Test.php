<?php defined('SYSPATH') or die('NoD direct script access.');
/*
*/
class Task_Test extends Minion_Task
{
	protected  $_options = array();
	protected static $_config;
	protected  $_api;
	public function __construct() {
		parent::__construct();
		//配置文件里的微信appId和appSecret
		self::$_config = Kohana::$config->load('site')->get('wx');
//		$this->_api = Tool::factory('API');
		if(!self::$_config ||!isset(self::$_config['appId']) || !isset(self::$_config['appSecret']) || !isset(self::$_config['apiUrl']) ){
			echo "无法获取微信配置信息\r\n";
			exit;
		}
	}
	
	public function _execute(array $params){

//		$redis = new Redis();
//		$redis->connect('127.0.0.1',6379);
//		$redis->set('test','hello redis');
//		print_r(self::$_config['apiUrl'].'/cgi-bin/message/custom/send?access_token=m9VnQofSGHOO_bzxhoLV7-PgVUtLmP9pUzrtwDQR5vrgXs1g2WF4KdAMjl8aNK1XKkd0x-8JVTXLspAS9QVu6_QvMQ8apenPkKTU-ZlG-G6CnS00IUcCBqNNClR-BURjPEYgAAACRL'."\r\n");
//		echo 123;
		$url = self::$_config['apiUrl'].'/cgi-bin/message/custom/send?access_token=m9VnQofSGHOO_bzxhoLV7-PgVUtLmP9pUzrtwDQR5vrgXs1g2WF4KdAMjl8aNK1XKkd0x-8JVTXLspAS9QVu6_QvMQ8apenPkKTU-ZlG-G6CnS00IUcCBqNNClR-BURjPEYgAAACRL';
		$post = array(
					'touser'=>'OPENID',
					'msgtype'=>'text',
					'text'=>array(
							'content'=>"Hello World"
					)
		);
		$ticket_api = HttpClient::factory($url)->execute();
		$ticket_array = $ticket_api->as_array();
		//$ListJson = HttpClient::factory($url)->get()->execute();
//		$ListJson = HttpClient::factory($url)->post(json_encode($post))->execute()->body();
		Tool::factory('Debug')->array2file(array($url,$ticket_array), APPPATH.'../static/liu_test.php');
		//$token_api = HttpClient::factory()->execute();
		//print_r($ListJson);
		die;
		echo "\r\n".date('Y-m-d H:i:s').' ' . __CLASS__ . "\tBegin\r\n";




		echo $redis->get('test');
//		print_r(get_extension_funcs ('redis'));
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