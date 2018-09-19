<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
    class Controller_Faceid extends Controller {
        protected $_faceid = null;
        protected $_config = null;
        private $_file_path = DOCROOT.'protected/tmp/';

        protected $_api = [
            'get_token'=>'https://api.megvii.com/faceid/lite/get_token',
            'get_html'=>'https://api.megvii.com/faceid/lite/do',
            'ocridcard'=>'https://api.faceid.com/faceid/v1/ocridcard'
        ];
        public function before(){
            if(!isset($this->_faceid) || empty($this->_faceid)){
                $this->_faceid = Libs::factory('faceid_faceppsdk');
                $this->_faceid->api_key       = 'zhongguoyaosheng-test';
                $this->_faceid->api_secret    = '3eyQrwlQbGe9TcO-wwo7rzbxSeTRa6is';
            }
            if(!isset($this->_config) || empty($this->_config)){
                $this->_config = array('client_id'=>'wx','client_key'=>1111);
            }
        }
            public function action_Index()
        {
//            $data = array(
//                'api_key'=>$this->_faceid->api_key,
//                'api_secret'=>$this->_faceid->api_secret,
//                'return_url'=>'http://test31.m.timecash.cn',
//                'notify_url'=>'http://test31.m.timecash.cn',
//                'biz_no'=>'biz_no',
//                'comparison_type'=>0,
//                'uuid'=>'face_135',
//                'scene_id'=>'TimecashH5',
//                'image_ref1'=>1111
//            );
//            $data['hash'] = '0af6e008e315d49f0c158382113d311f';
//            $result = HttpClient::factory('http://test23.ps.timecash.cn/API/Operation/Json')->get($data)->httpheader(array("CLIENTID:".$this->_config['client_id'],"CLIENTSIGN:".md5(json_encode($data).$this->_config['client_key'])))->execute();
//                $res_obj = json_decode($result->body(), true);
//                $verify_tmp = $this->_file_path.'verify_'.$res_obj['file'];
//                file_put_contents($verify_tmp,base64_decode($res_obj['binary']));

                $verify_tmp = $this->_file_path.'E5FB7084-9721-446D-B975-3EC8EDB80F0C.png';

//            Tool::factory('Debug')->D($res_obj);
            $dataOcr = array(
                'api_key'=>$this->_faceid->api_key,
                'api_secret'=>$this->_faceid->api_secret,
                'return_url'=>'http://test31.m.timecash.cn',
                'notify_url'=>'http://test31.m.timecash.cn',
                'biz_no'=>'biz_no',
                'procedure_type'=>'selfie',
                'comparison_type'=>0,
                'uuid'=>'face_135',
                'scene_id'=>'TimecashH5',
                'image_ref1'=> curl_file_create($verify_tmp,'png','image')
//                'image_ref1'=> '@' . $verify_tmp
            );
//                Tool::factory('Debug')->D($dataOcr);
            //使用完删除临时图片
//            unlink($verify_tmp);
//            Tool::factory('Debug')->D($dataOcr);
            $resultFaceId = HttpClient::factory($this->_api['get_token'])->post($dataOcr)->execute()->body();
             $res_obj = json_decode($resultFaceId, true);
             if(isset($res_obj['token'])){
                 $dataHtml = array('token'=>$res_obj['token']);
                 $resultHtml = HttpClient::factory($this->_api['get_html'])->get($dataHtml)->execute()->body();
                 echo $resultHtml;
                 die;
             }else{
                 echo '请求token失败';
                 die;
             }


             //$resultFaceId =   WebUtil::curl($this->_api['get_token'],$dataOcr);




            //$data['hash'] = '05320caa371f670f09f11d84329e3f25';
            //$result = HttpClient::factory('http://test.ps.timecash.cn/API/Operation/Get')->get($data)->httpheader(array("CLIENTID:".$this->config['client_id'],"CLIENTSIGN:".md5(json_encode($data).$this->config['client_key'])))->execute();
            //$new_name = time().Text::random('alnum',8).".jpg";
            //$flash_dir =  Tool::factory('Dir')->dir_path($this->config['security_path']);
//            if( !is_dir($flash_dir) ){
//                Tool::factory('Dir')->dir_create($flash_dir,'755');
//            }
//            Tool::factory('Debug')->array2file($flash_dir.$new_name, APPPATH.'../static/liu_test.php');
//            $file_parh = fopen($flash_dir.$new_name,"w");
//            if(fwrite($file_parh,$result->body())){
//                fclose($file_parh);
                //保存数据
                //重新获取文件大小
//                if(is_file($flash_dir.$new_name)){
//                    $size = filesize($flash_dir.$new_name);
//                }
//            }else{
//                fclose($file_parh);
//                return array('status'=>false,'msg'=>'上传失败!');
//            };

//            echo '<pre>';
//            $params2['img'] = $_SERVER['DOCUMENT_ROOT'].'/upload/1461750253kv1Y4iEM.jpg';
//            $response2 = $this->faceid->execute('/detect',$params2);
//            Tool::factory('Debug')->D(json_decode($response2['body']));
//            echo '用户手持身份证读取出的人脸: ';echo '<br/>';
//            $faces = json_decode($response2['body'],1);
//            print_r($faces);
//            die;


//            if(is_file($flash_dir.$new_name)){
//                Tool::factory('Debug')->array2file(111111111111, APPPATH.'../static/liu_test.php');
//                echo '<pre>';
//                //身份证照片
//                $params2['img'] = $flash_dir.$new_name;
//                $response2 = $this->faceid->execute('/detect',$params2);
//                echo '用户手持身份证读取出的人脸: ';echo '<br/>';
//                $faces = json_decode($response2['body'],1);
//                print_r($faces);
//                echo 123;
//                die;
//            }else{
//                Tool::factory('Debug')->array2file(22222222222222, APPPATH.'../static/liu_test.php');
//                echo '保存失败！';
//                die;
//            }

		}

	}