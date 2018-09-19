
<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 * */
    class Controller_Promotion extends Common

    {
        //浏览统计数组
        protected $_downLoadTimecash = 'http://download-cdn.timecash.cn/android/release/timecash-4.0.0.apk';
        protected $_downLoadInst = 'http://download-cdn.timecash.cn/android/release/inst/inst_2.0.2.apk';
        public function action_index()
        {

            //下载渠道
            if(isset($_GET['channel'])){
                Model::factory('Activity')->update_counter($_GET['channel']);
            }

            $view = View::factory($this->_vv.'Promotion/index');
            //判断是Android还是ios
            if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
                $view->client = "ios";
                //$view->url = 'http://mp.weixin.qq.com/mp/redirect?url='.urlencode('https://itunes.apple.com/cn/app/kuai-jin/id1130326523?mt=8');
                $view->url = '/Promotion/iosUpload';
            }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
                $view->client = "android";
                $view->url = '/Promotion/androidUpload';
            }else{
                $view->client = "else";
            }

            $view->title= Kohana::$config->load('url.title.quota');
            $view->userId = isset($_GET['user_id'])?$_GET['user_id']:0;
            $this->response->body($view);
        }

        public function action_iosUpload()
        {
            $view = View::factory($this->_vv.'Promotion/iosupload');
            //判断是否是微信浏览器
             if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
                 $view->is_weixin =  true;
             }else{
                 $view->is_weixin =  false;
             }
            $view->title=Kohana::$config->load('url.title.quota');
            $this->response->body($view);
        }


        public function action_androidUpload()
        {
            $view = View::factory($this->_vv.'Promotion/androidUpload');
            //判断是否是微信浏览器
            if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
                $view->is_weixin =  true;
            }else{
                $view->is_weixin =  false;
            }

            $view->url = $this->_downLoadTimecash;
            $view->title=Kohana::$config->load('url.title.quota');
            $this->response->body($view);
        }


        //分享
        public function action_shareView()
        {
            $view = View::factory('Promotion/showview');
            //判断是否是微信浏览器
            if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
                $view->is_weixin =  true;
            }else{
                $view->is_weixin =  false;
            }
            $view->title=Kohana::$config->load('url.title.quota');
            $this->response->body($view);
        }
       //统计
        public function action_StatisticsClick(){
            //$this->_model['AES26']->encrypt($post['password'],$this->_api_config['app_key']),
            //记录h5注册页面进来的点击次数
            if($this->request->is_ajax()&&$this->request->method()==='POST'&&isset($_POST['userid'])&&!empty($_POST['userid'])){
                //判断是Android还是ios
                if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
                    $client = "ios";
                }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
                    $client = "android";
                }else{
                    $client= "else";
                }
                //$_model['AES26'] = Libs::factory('AES126');
                //$sc = $_model['AES26']->encrypt(21520,'e3fac1c83acd62094cf3a8faa04ca7c2');
//                $userId = $_model['AES26']->decrypt($_POST['userid'],'e3fac1c83acd');
//                exit(json_encode(array('status' =>false,'msg'=>$userId)));
                if(is_numeric($_POST['userid'])){
                    $_model['activity'] = Model::factory('Activity');
                    $total = $_model['activity']->get_total_click(array('user_id'=>$_POST['userid']));
                    if($total>0){
                        //修改
                        $_model['activity']->update_click_statistics($_POST['userid']);
                    }else{
                        //添加
                        $_model['activity']->insert_click_statistics(array('user_id'=>$_POST['userid'],'check_times'=>1,'create_time'=>time(),'reg_app'=>$client));
                    }
                }
            }
            echo json_encode(array('status'=>true));
        }
        //调研统计
        public function action_Survey()
        {
            $view = View::factory($this->_vv.'Activity/survey');
            $this->response->body($view);
        }
        //普付宝app下载
        public function action_PufubaoApp()
        {
            $view = View::factory($this->_vv.'Promotion/pufubaoapp');
            $view->url = 'http://wuliu-loan.oss-cn-beijing.aliyuncs.com/app/dl/factoring-V2.0.0.apk?number='.rand(1, 15);
            $this->response->body($view);
        }
        //分期下载
        public function action_InstandroidUpload(){
            $view = View::factory($this->_vv.'Promotion/InstandroidUpload');
            //判断是否是微信浏览器
            if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
                $view->is_weixin =  true;
            }else{
                $view->is_weixin =  false;
            }
            $view->url = $this->_downLoadInst;
            $view->title=Kohana::$config->load('url.title.quota');
            $this->response->body($view);
        }

//快金4.0版引导下载
    public function action_timecashAndroidUpload(){
        $view = View::factory($this->_vv.'Promotion/timecashUpload');
        //判断是否是微信浏览器
        //判断是Android还是ios
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            $view->client = "ios";
            //$view->url = 'http://mp.weixin.qq.com/mp/redirect?url='.urlencode('https://itunes.apple.com/cn/app/kuai-jin/id1130326523?mt=8');
            $view->url = '/Promotion/iosUpload';
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            $view->client = "android";
            $view->url = '/Promotion/androidUpload';
        }else{
            $view->client = "else";
        }
//            $view->url ="javascript:\$AppInst.Share({'sharetitle':'{$sharetitle}','text':'{$text}','img_url':'{$img_url}','url':'{$url}','actIc':26});"
        $view->url = "javascript:\$AppInst.WebJump({'type':'web_abroad', 'par':'{$this->_downLoadTimecash}'})";

        $view->title=Kohana::$config->load('url.title.quota');
        $this->response->body($view);
    }
    
}