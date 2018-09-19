<?php defined('SYSPATH') or die('NoD direct script access.');
/*
*/
class Task_WxPush extends Minion_Task
{
	protected  $_options = array();
	
	public function _execute(array $params){
//		$appId = 'wxb6606932ddd5f1fa';
//		$appSecret = '12b55a75c9af1d9a0855d11c49473c36';
//		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appSecret";
//		$res = json_decode($this->httpGet($url),true);
//		echo '<pre>';
//		print_r($res);
//		echo '</pre>';
//		$accessToken = $res['access_token'];
		$accessToken = 'zad-CYHM07GPkFiZzjHQXPebYa3lUg21A3QnKE8XQBey-AK1hTsdzIEpbsajUdmV44Y8OYlMcZJLM2KIRH381CC9OEx-LDlD62xOwxZOqivStFpjddmiIzQmiPYzq1ZpALMeAIAMXY';
		$openid = 'oSfihs4-3jMf1ppHK4gklCJ-eK5o';
		$template_id = 'IwTGdOyYY3O8rBwee_PD8WwXVbNB5LKIbfRg1OigIVo';
		$info = array('name'=>'刘金生','time'=>date('Y-m-d',time()));
		$data = $this->set_msg($openid,$template_id,$info,$accessToken);
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		die;
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
	//设置与发送模板信息$info = array('name'=>'用户名称','time'=>'动作产生时间'); $data = $this->set_msg($openid,$template_id,$info,$accessToken);
	function set_msg($openid=null,$template_id=null,$info=null,$url=null){

		if(empty($openid)||empty($template_id)||empty($info)){
			return false;
		}

		//这里是在模板里修改相应的变量
		$formworkArr = array(
			'touser'=>$openid,
			'template_id'=>$template_id,
			'url'=>empty($url)?'http://m.timecash.cn':$url
		);
		//获得微信接口token
		$accessToken =  DB::select('token')->from('wxconst')->execute()->current();
		$accessToken['token'] = 'RK6v6635QXkmnIOOxYsAEMn7CKteukzQG8Pych21Jg57mgfH47HNrAYxq8bDmSSeTFlgZOmGPA9fjOAM6HYHfhIwFEK42As0qiJGD7QUIA7n2tQniumiSW_qp4Rr6ODEWBWhAIADID';
		switch ($template_id){
			//成为会员通知
			case 'IwTGdOyYY3O8rBwee_PD8WwXVbNB5LKIbfRg1OigIVo':
				$data['data'] = array(
					'first'=>array(
						'value'=>"您已成功成为快金会员，从此，您可以听到金融精英的声音！",
						'color'=>"#173177"
					),
					'keyword1'=>array(
						'value'=>$info['name'],
						'color'=>"#173177"
					),
					'keyword2'=>array(
						'value'=>$info['time'],
						'color'=>"#173177"
					),
					'keyword3'=>array(
						'value'=>"快金小额贷款平台",
						'color'=>"#173177"
					),
					'remark'=>array(
						'value'=>"干活中看成长，人脉中见机会。！",
						'color'=>"#173177"
					));
				break;
			//业务提醒
			case 'LbxJmydOug8clHj_w96nD0aQivSVR8flnUPMhtw-cUs':
				$data['data'] = array(
					'first'=>array(
						'value'=>"尊敬的客户：",
						'color'=>"#173177"
					),
					'keyword1'=>array(
						'value'=>$info['name'],
						'color'=>"#173177"
					),
					'keyword2'=>array(
						'value'=>"小额贷款",
						'color'=>"#173177"
					),
					'remark'=>array(
						'value'=>"请注意还款时间，及时还款。",
						'color'=>"#173177"
					));
				break;
			//功能开通通知
			case 'PaqjdAWaqeEcd279gi_quJJki9DeN_1PQRofrSGGLFk':
				$data['data'] = array(
					'first'=>array(
						'value'=>"您好，恭喜您已成功开通微信交易！",
						'color'=>"#173177"
					),
					'keyword1'=>array(
						'value'=>"微信基金交易",
						'color'=>"#173177"
					),
					'keyword2'=>array(
						'value'=>$info['time'],
						'color'=>"#173177"
					),
					'remark'=>array(
						'value'=>"您可以使用下方微信菜单进行更多体验。",
						'color'=>"#173177"
					));
				break;
			//奖品到账通知
			case 'lrI74D5h_zbkut30-jouzDi7iLBIw4blc_jnW-YWzfU':
				$data['data'] = array(
					'first'=>array(
						'value'=>"恭喜您在谁牛金融“上证指数涨跌竞猜”中竞猜正确并获得奖品，请查收.",
						'color'=>"#173177"
					),
					'keyword1'=>array(
						'value'=>date('Y-m-d',time()),
						'color'=>"#173177"
					),
					'keyword2'=>array(
						'value'=>"正确",
						'color'=>"#173177"
					),
					'keyword3'=>array(
						'value'=>"20元话费",
						'color'=>"#173177"
					),
					'remark'=>array(
						'value'=>"感谢您对谁牛金融的支持.",
						'color'=>"#173177"
					));
				break;
				break;
			default:
				$data = array();
				break;
		}
		$formworkArr = array_merge($formworkArr,$data);
		$formwork = json_encode($formworkArr);
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$accessToken['token']}";    //模板消息推送
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}



}