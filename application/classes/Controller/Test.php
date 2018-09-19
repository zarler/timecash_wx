<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
    class Controller_Test extends Controller {
		protected static $_config;
		public function before(){







			parent::before();
			//配置文件里的微信appId和appSecret
//			self::$_config = Kohana::$config->load('site')->get('wx');
////		$this->_api = Tool::factory('API');
//			if(!self::$_config ||!isset(self::$_config['appId']) || !isset(self::$_config['appSecret']) || !isset(self::$_config['apiUrl']) ){
//				echo "无法获取微信配置信息\r\n";
//				exit;
//			}
		}






		//html测试(微信二维码关注)
        public function action_HtmlShow(){
            $json = json_encode(array('html'=>file_get_contents(APPPATH.'/views/v2/Test/FocusOnWechat.php')));
//            $json = json_encode(array('html'=>'<!DOCTYPE html><html><body></body><img style="margin: 0 auto;display: block;width: 35%;" src="/static/images/v2/activity/2weima.png"></body></html>'));
            header('Content-type: application/json');
            echo $json;
        }

        //html测试(首页项目栏)
        public function action_HomePageLinks(){


            $a="A journey of a thousand miles must begin with a single step";
            $re=strrev($a);

//print_r($re);die;
            $b=ucwords($re);
//print_r($b);
            $c=strrev($b);
            $d= lcfirst($c);
            print_r($d);
            die;


            set_time_limit(0);
            header("Connection:Keep-Alive");
            header("Proxy-Connection:Keep-Alive");
            for($i=0;$i<60;$i++) {
                print 'text'.$i.'<br>';
                ob_flush();
                flush();
//                sleep(1);
//                clearstatcache();
            }
            die;

            $filename='abc.exe.jpg';
            $item=pathinfo($filename);
            echo $item['extension'];
            die;


//            $readcontents = fopen("http://www.baidu.com",'rb');
//            $contents = stream_get_contents($readcontents);
//            fclose($readcontents);

            $num=1234567890;  //你给定的数字
            echo number_format($num);
            die;


            $str='12,65,110,2,3,55,79,10,45';
            //print_r($str);die;
            //把字符串分割成数组
            $item_arr=explode(',',$str);
            //print_r($item_arr);die;
            //while循环

            print_r(array(sizeof($item_arr),count($item_arr)));

            while(sizeof($item_arr)>0){
                //求最大
                $max=max($item_arr);
                //print_r($max);die;
                //求最小
                $min=min($item_arr);
                //print_r($min);die;
                echo $max."<br/>";
                echo $min."<br/><hr>";
                //求最大数
                $max_pos=array_keys($item_arr,$max);
                print_r($max_pos);
                //求最小数
                $min_pos=array_keys($item_arr,$min);
                unset($item_arr[$max_pos[0]]);
                unset($item_arr[$min_pos[0]]);
            }

            print_r($max_pos);

            die;


            $str = 'abcdefg';
            $str = chunk_split($str,3,',');
            echo rtrim($str,',');
            die;


            $str = "您好hello";
            print_r(strlen($str));

            die;

            $arr = array('da','eb','c');
//            sort($arr);
//            asort($arr);
            ksort($arr);

            xdebug_debug_zval($arr);


//            var_dump(array($arr));
            die;


            $contents = file_get_contents('http://www.baidu.com');

            echo $contents;
            DIE;



            echo $_SERVER['REMOTE_ADDR'].'<hr/>',gethostbyname("www.baidu.com").'<hr/>',$_SERVER['HTTP_HOST'];
            die;


            $arr = array('a','b','c');
            $arrb = array('a','b','c');
            array_unshift($arr,'d');
//            array_shift($arr);
            array_push($arrb,'d');
            array_pop($arr);
            var_dump(array($arr,$arrb));
            die;



//            $_data = [1, [2, 3], [4, [5, 6]], [[[7]]]];
//            $res = $this->test($_data);
//            var_dump($res);
//            $arr = '[1, [2, 3], [4, [5, 6]], [[[7]]]]';
//            $_data = [1, [2, 3], [4, [5, 6]], [[[7]]]];
//            $res = $this->recursion($_data);
//            print_r($res);

//            $_data = [0, 1, 0, 13, 4];
//            print_r($this->zarro($_data));

//            $this->zarro($_data);

            print_r($this->f(9));
        }

        function f($n){
            if($n==10){
                return 1;
            }
            return ($this->f($n+1)+1)*2;
        }

        public function zarro($arr){
            foreach ($arr as $key => $val){
                if(empty($val)){
                    array_push($arr,$val);
                    unset($arr[$key]);
                }
            }
            return $arr;
        }




        public function recursion($arr,&$arrResult = []){
//                if(!is_array($arr)){
//                    return 0;
//                }
                foreach($arr as $key => $value){
                    if(is_array($value)){
                        $this->recursion($value,$arrResult);
                    }else{
                        $arrResult[] = $value;
                    }
                }
                return $arrResult;
        }

        function test($arr, &$_arr = []) {

            foreach($arr as $key => $value) {
                if (is_array($value)) {
                    $this->test($value, $_arr);
                } else {
                    $_arr[] = $value;
                }

            }
            return $_arr;

        }

        public function action_HtmlShowWx(){
            $view = View::factory('Test/FocusOnWechat');
            $this->response->body($view);
        }


		public function action_Indexsql(){
//			$requery = DB::select('tc_agent_relation.agent_id','tc_user.id','tc_user.mobile',array('tc_order.id', 'order_id'),'tc_user.create_time','tc_order.status',array('tc_order.loan_amount', 'loan_amount'),'tc_order.type','tc_order.start_time','tc_order.day')
////			$requery = DB::select('tc_user.id','tc_agent_relation.agent_id','tc_user.name',array(DB::expr('COUNT(*)'), 'total')array('tc_order.id'=>),'tc_user.create_time')
//				->from('tc_user')
//				->join('tc_agent_relation')->on('tc_agent_relation.user_id','=','tc_user.id')
//				->join('tc_order')->on('tc_order.user_id','=','tc_user.id')
////				->join('tc_order')
//				->where("tc_agent_relation.agent_id",'=',27)
//				->where('tc_order.status','IN',array(5,50,61,51))
////				->where("tc_order.status",'!=',10)
//				->group_by('tc_user.mobile')
////				->limit(10)
//				->compile('admin');
////				->execute('admin')->as_array();
			//查找只注册,订单表里没有数据的人
//			$requery = DB::query(Database::SELECT, "SELECT mobile,create_time FROM tc_user WHERE id IN (SELECT  user_id FROM tc_agent_relation WHERE tc_agent_relation.agent_id = 13 AND  tc_agent_relation.user_id NOT IN (SELECT user_id FROM tc_order))")
//				->execute('admin')->as_array();
			//查找在订单表里有有效数据的人
//			$requery = DB::query(Database::SELECT, "SELECT tc_agent_relation.agent_id, tc_user.id, tc_user.mobile, tc_order.id AS order_id, tc_user.create_time, tc_order.status, tc_order.loan_amount AS loan_amount, tc_order.type, tc_order.start_time, tc_order.day FROM tc_user
//JOIN tc_agent_relation ON (tc_agent_relation.user_id = tc_user.id) JOIN tc_order ON (tc_order.user_id = tc_user.id) WHERE tc_agent_relation.agent_id = 13 AND tc_order.status IN (5, 50, 61, 51) GROUP BY tc_user.mobile")
//				->execute('admin')->as_array();
			//注册用户生成的废弃订单
			$requery = DB::query(Database::SELECT, "SELECT tc_agent_relation.agent_id, tc_user.id, tc_user.mobile, tc_order.id AS order_id, tc_user.create_time, tc_order.status, tc_order.loan_amount AS loan_amount, tc_order.type, tc_order.start_time, tc_order.day FROM tc_user JOIN tc_agent_relation ON (tc_agent_relation.user_id = tc_user.id)
JOIN tc_order ON (tc_order.user_id = tc_user.id) WHERE tc_agent_relation.agent_id = 13 and tc_user.id NOT IN (SELECT tc_user.id FROM tc_user JOIN tc_agent_relation ON (tc_agent_relation.user_id = tc_user.id)
JOIN tc_order ON (tc_order.user_id = tc_user.id) WHERE tc_agent_relation.agent_id = 13 AND tc_order.status IN (5, 50, 61, 51) GROUP BY tc_user.mobile ) GROUP BY tc_user.mobile;")
				->execute('admin')->as_array();
//			echo '<pre>';
//			print_r(count($requery));
//			echo '</pre>';
//			die;

//			$str = '<table border="1">';
//			foreach($requery as $key =>$val){
//
//				if($val['type']==3){
//					$val['type'] = '极速贷';
//				}else{
//					$val['type'] = '担保借款';
//				}
//				if($val['status']==10){
//					$val['type'] = $val['day'] = $val['loan_amount'] = $val['status'] = '';
//				}else if(in_array($val['status'],array(50,51))){
//					$val['status'] = '逾期';
//					$val['day'] = $val['day'].'天';
//				}else{
//					$val['day'] = $val['day'].'天';
//					$val['status'] = '';
//				}
//				$str .= '<tr>
//						<th>'.$val['agent_id'].'</th>
//						<th>'.$val['name'].'</th>
//						<th>'.date("Y-m-d H:i",$val['create_time']).'</th>
//						<th>'.date("Y-m-d H:i",$val['start_time']).'</th>
//						<th>'.$val['type'].'</th>
//						<th>'.$val['day'].'</th>
//						<th>'.$val['loan_amount'].'</th>
//						<th>'.$val['status'].'</th>
//					  </tr>';
//			}
//
//			echo  $str;
//			die;
			//导出数据
			//创建一个excel

			Kohana::load(APPPATH . 'classes/Libs/PHPExcel.php');
			//创建一个excel对象
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("ctos")
				->setLastModifiedBy("ctos")
				->setTitle("Office 2007 XLSX Test Document")
				->setSubject("Office 2007 XLSX Test Document")
				->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
				->setKeywords("office 2007 openxml php")
				->setCategory("Test result file");
			//set width
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);

			//设置行高度
			$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);
			$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

			//设置水平居中
			$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$objPHPExcel->getActiveSheet()->setCellValue('A' . 1, '代理商ID');
			$objPHPExcel->getActiveSheet()->setCellValue('B' . 1, '客户手机号');
			$objPHPExcel->getActiveSheet()->setCellValue('C' . 1, '注册日期');
			$objPHPExcel->getActiveSheet()->setCellValue('D' . 1, '借款日期');
			$objPHPExcel->getActiveSheet()->setCellValue('E' . 1, '借款类型 （极速贷、担保借款）');
			$objPHPExcel->getActiveSheet()->setCellValue('F' . 1, '借款周期（7天、14天、21天）');
			$objPHPExcel->getActiveSheet()->setCellValue('G' . 1, '首次借款金额');
			$objPHPExcel->getActiveSheet()->setCellValue('H' . 1, '是否逾期');
			$i = 2;
			foreach($requery as $key =>$val){
				if($val['type']==3){
					$val['type'] = '极速贷';
				}else{
					$val['type'] = '担保借款';
				}
				if($val['status']==10){
					$val['type'] = $val['day'] = $val['loan_amount'] = $val['status'] = $val['start_time'] = '';
				}else if(in_array($val['status'],array(50,51))){
					$val['status'] = '逾期';
					$val['day'] = $val['day'].'天';
					$val['start_time'] = date("Y-m-d H:i",$val['start_time']);
				}else{
					$val['day'] = $val['day'].'天';
					$val['status'] = '';
					$val['start_time'] = date("Y-m-d H:i",$val['start_time']);
				}
//				$val['type'] = $val['day'] = $val['loan_amount'] = $val['status'] = $val['start_time'] = '';

				$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $val['agent_id']);
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $val['mobile']);
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, date("Y-m-d H:i",$val['create_time']));
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $val['start_time']);
				$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $val['type']);
				$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $val['day']);
				$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $val['loan_amount']);
				$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $val['status']);

//				$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, 13);
//				$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $val['mobile']);
//				$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, date("Y-m-d H:i",$val['create_time']));
//				$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, '');
//				$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, '');
//				$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, '');
//				$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, '');
//				$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, '');

				$i++;
			}
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle('邀请码统计');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			ob_end_clean();//清除缓冲区,避免乱码
			//$objWriter->save($time . ".xlsx");
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="wuxiao_13.xls"');
			header('Cache-Control: max-age=0');
			//保存excel—2007格式
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			die;




//        $query->join('grouplink')->on('user.id','=','grouplink.user_id');
//        $query->where('grouplink.group_id','=', $array['group_id']);



//			-----------------------------
//			$str = '<table border="1">';
//			foreach($requery as $key =>$val){
//
//				if($val['type']==3){
//					$val['type'] = '极速贷';
//				}else{
//					$val['type'] = '担保借款';
//				}
//				if($val['status']==10){
//					$val['type'] = $val['day'] = $val['loan_amount'] = $val['status'] = '';
//				}else if(in_array($val['status'],array(50,51))){
//					$val['status'] = '逾期';
//					$val['day'] = $val['day'].'天';
//				}else{
//					$val['day'] = $val['day'].'天';
//					$val['status'] = '';
//				}
//				$str .= '<tr>
//						<th>'.$val['agent_id'].'</th>
//						<th>'.$val['name'].'</th>
//						<th>'.date("Y-m-d H:i",$val['create_time']).'</th>
//						<th>'.date("Y-m-d H:i",$val['start_time']).'</th>
//						<th>'.$val['type'].'</th>
//						<th>'.$val['day'].'</th>
//						<th>'.$val['loan_amount'].'</th>
//						<th>'.$val['status'].'</th>
//					  </tr>';
//			}
//			$str .= '</table>';
//			echo $str;
//
//
//			echo '<pre>';
//
//			print_r($requery);
//			echo '</pre>';
			//			-----------------------------
			die;
		}


		public function action_Index(){

			
			
			
			
			$url = self::$_config['apiUrl'].'/cgi-bin/message/custom/send?access_token=X09ACADyo0vvrI2jaV3QtX1o6-ccP7-DlB0fv39hArYuKC5d9R2gL09vFxOT3FmA0gkquYRrNPd-ip6ek6Cwc9ihgWvyeJwoZsp_BbNtgCRrSnSJvNMaAbUM0rpFb6KLOIZaAFACWN';
			$post = array(
				'touser'=>'ofBjfvgyF3hEZoioRwjFucYei0Hs',
				'msgtype'=>'text',
				'text'=>array(
					'content'=>"Hello World"
				)
			);

			$ticket_api = HttpClient::factory($url)->post(json_encode($post))->execute();
			$ticket_array = $ticket_api->as_array();
			print_r($ticket_array);

			//$ListJson = HttpClient::factory($url)->get()->execute();
//		$ListJson = HttpClient::factory($url)->post(json_encode($post))->execute()->body();
			//Tool::factory('Debug')->array2file(array($url,$ticket_array), APPPATH.'../static/liu_test.php');
			//$token_api = HttpClient::factory()->execute();
			//print_r($ListJson);
			die;

			die;
			$value = 'http://www.cnblogs.com/txw1958/'; //二维码内容
			$errorCorrectionLevel = 'L';//容错级别
			$matrixPointSize = 6;//生成图片大小
			//生成二维码图片
			QRcode::png($value, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);
			$logo = 'logo.png';//准备好的logo图片
			$QR = 'qrcode.png';//已经生成的原始二维码图
			if ($logo !== FALSE) {
				$QR = imagecreatefromstring(file_get_contents($QR));
				$logo = imagecreatefromstring(file_get_contents($logo));
				$QR_width = imagesx($QR);//二维码图片宽度
				$QR_height = imagesy($QR);//二维码图片高度
				$logo_width = imagesx($logo);//logo图片宽度
				$logo_height = imagesy($logo);//logo图片高度
				$logo_qr_width = $QR_width / 5;
				$scale = $logo_width/$logo_qr_width;
				$logo_qr_height = $logo_height/$scale;
				$from_width = ($QR_width - $logo_qr_width) / 2;
				//重新组合图片并调整大小
				imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
					$logo_qr_height, $logo_width, $logo_height);
			}
            //输出图片
			imagepng($QR, 'helloweixin.png');
			echo '<img src="helloweixin.png">';


//			if(Valid::not_empty(Tool::factory('Session')->sessionGet('wx'))){
//				$stir = Tool::factory('Session')->sessionGet('wx');
//			}else{
//				Tool::factory('Session')->sessionSet('wx',"不空");
//				$stir = "空";
//			}
//			if(Valid::not_empty($_GET)){
//				Tool::factory('Session')->sessionDelete('wx');
//				$stir = "空";
//			}
//			$view = View::factory('Test/index');
//			$view->despic = $stir;
//			$this->response->body($view);
		}
		public function action_Session(){
			//Tool::factory('Debug')->D(Libs::factory('Session')->set("session_id",array('user_id'=>235,'token'=>'aaaaaaaaaaaaa','expire_time'=>"2000")));
			Tool::factory('Debug')->D(Libs::factory('Session')->sessionDelete("session_id"));
//			if(!Valid::not_empty(Libs::factory('Session')->get("random"))){
//				Libs::factory('Session')->set("random",2000);
//			}
//			Tool::factory('Debug')->D(Libs::factory('Session')->get("random"));
//			$view = View::factory('Test/index');
//			$view->despic = $stir;
//			$this->response->body($view);

		}
		public function action_redis(){
			$redis = new Redis();
			$redis->connect('127.0.0.1',6379);
			$redis->set('test','hello redis');
			echo $redis->get('test');
		}

		public function action_Test(){
			$json = json_encode(array('order_rate_html'=>"<!DOCTYPE html>
<html lang='zh-cn' class='no-js'>
<head>
	<meta http-equiv='Content-Type'>
	<meta content='text/html; charset=utf-8'>
	<meta charset='utf-8'>
	<title></title>
	<meta name='viewport' content='width=320,maximum-scale=1.3,user-scalable=no'>
	<style type='text/css'>
		.t-login-center{
			background: white;
			margin-bottom: 1rem;
		}
		.t-loan2{ color: #868686; font-size:12px;padding: 2%;}
		.t-loan2 .dt1{
			position: absolute;
			width: .3rem;
			height: .3rem;
			background: #ff8470;
			border-radius: .3rem;
			margin-top: .3rem;
		}
		.t-loan2 .dt2{
			position: absolute;
			width: .3rem;
			height: .3rem;
			background: #ff8470;
			border-radius: .3rem;
			margin-top: .5rem;
		}
		.t-loan2 dd{ margin-left: .6rem; line-height: 1rem;margin-bottom:.03rem;}
		.t-loan2 p{ margin: 2px auto}
	</style>
</head>
<body>
<section class='t-login-center'>
	<dl class='t-loan2'>
		<dt class='dt1'></dt>
		<dd>请于还款日之前确保还款卡内余额充足</dd>
		<dt class='dt2'></dt>
		<dd>
			<p>若未按期还款将影响您在的信用评级,并会造成如下影响：</p>
			<p>1.逾期罚息：按未还金额×3‰/天</p>
			<p>2.逾期滞纳金：按未还金额×1‰/天</p>
			<p>3.征信黑名单：将影响您在互联网征信共享组织的信用评级</p>
		</dd>
	</dl>
</section>
</body>
</html>"));
			header('Content-type: application/json');
			echo $json;
		}

		public function action_TestOne(){

			$view = View::factory('Test/test');
			$view->str = "<!DOCTYPE html>
<html lang='zh-cn' class='no-js'>
<head>
	<meta http-equiv='Content-Type'>
	<meta content='text/html; charset=utf-8'>
	<meta charset='utf-8'>
	<title></title>
	<meta name='viewport' content='width=320,maximum-scale=1.3,user-scalable=no'>
	<style type='text/css'>
		.t-login-center{
			background: white;
			margin-bottom: 1rem;
		}
		.t-loan2{ color: #868686; font-size: 12px;padding: 2%;}
		.t-loan2 .dt1{
			position: absolute;
			width: .3rem;
			height: .3rem;
			background: #ff8470;
			border-radius: .3rem;
			margin-top: .3rem;
		}
		.t-loan2 .dt2{
			position: absolute;
			width: .3rem;
			height: .3rem;
			background: #ff8470;
			border-radius: .3rem;
			margin-top: .5rem;
		}
		.t-loan2 dd{ margin-left: .6rem; line-height: 1rem;margin-bottom:.03rem;}
		.t-loan2 p{ margin: 2px auto}
	</style>
</head>
<body>
<section class='t-login-center'>
	<dl class='t-loan2'>
		<dt class='dt1'></dt>
		<dd>请于还款日之前确保还款卡内余额充足</dd>
		<dt class='dt2'></dt>
		<dd>
			<p>若未按期还款将影响您在的信用评级,并会造成如下影响：</p>
			<p>1.逾期罚息：按未还金额×3‰/天</p>
			<p>2.逾期滞纳金：按未还金额×1‰/天</p>
			<p>3.征信黑名单：将影响您在互联网征信共享组织的信用评级</p>
		</dd>
	</dl>
</section>
</body>
</html>";
			$this->response->body($view);
		}

		public function action_TestDownLoadImg(){

//			$this->redirect('https://www.baidu.com');
			
//			die;
			$view = View::factory('Test/DownLoadImg');
			$view->url = 'weixin://wxpay/bizpayurl?pr=KJYxm47';
			$this->response->body($view);
		}

		public function action_TestJsHtml(){

//			$this->redirect('https://www.baidu.com');

//			die;

//            $data = array(
//                'type' => 'web_within',
//                'url' => 'http://test33.m.timecash.cn/app/Activity/TestJs?target_token={target_token}&d={device_id}#'
//            );
//            $jsonArr = json_encode($data);
//            Tool::factory('Debug')->D($jsonArr);
//
//

			$view = View::factory('Test/jsHtml');
			$this->response->body($view);
		}
		public function action_Testlayui(){

//			$this->redirect('https://www.baidu.com');

//			die;
			$view = View::factory('Test/jslayui');
			$this->response->body($view);
		}
	}