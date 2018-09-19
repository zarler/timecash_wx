<?php
class Libs_vendor_WechatCallbackapiTest{
	public function valid()
	{
		$echoStr = $_GET["echostr"];
		if($this->checkSignature()){
			error_log("\r\n"."-----------------------------".Date("Y-m-d H:i:s",time())."\r\n".var_export(array($echoStr), TRUE), 3, APPPATH.'../static/liu_test.php');

			echo $echoStr;
			exit;
		}
	}
	private function checkSignature() //配置时验证URL有效性
	{
		// you must define TOKEN by yourself
		if (!defined("TOKEN")) {
			throw new Exception('TOKEN is not defined!');
		}
		$signature = $_GET["signature"]; //微信加密签名，signature结合了开发者填写的token参数和请求中的timestamp参数、nonce参数。
		$timestamp = $_GET["timestamp"]; //时间戳
		$nonce = $_GET["nonce"];  //随机数

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		// use SORT_STRING rule
		sort($tmpArr,SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	public function responseMsg()
	{
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

		if (!empty($postStr)){
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$keyword = trim($postObj->Content);
			$time = time();
			$textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
			if(!empty( $keyword ))
			{

				if($keyword == "?" || $keyword == "？")
				{
					$msgType = "text";
					$contentStr = date("Y-m-d H:i:s",time());
					$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
					echo $resultStr;
				}else{

					$msgType = "text";
					$contentStr = "Welcome to wechat world!";
					$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
					echo $resultStr;
				}

			}else{
				echo "Input something...";
			}



		}else{
			echo "";
			exit;
		}
	}
}

