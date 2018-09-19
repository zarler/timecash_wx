
<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 放弃借款理由
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 * */
class Controller_H5_GiveupReason extends AppCore {
//    class Controller_Ver1_H5_APP_GiveupReason extends Common {
        public function before(){
            parent::before();
        }
        //分期下载
        public function action_Index(){
//            $this->Load();
//            $list = Model::factory('GiveUpType')->getList();
//            parent::$_VArray['listStr'] = '';
//            if(Valid::not_empty($list)){
//                foreach ($list as $key=>$val){
//                    parent::$_VArray['listStr'] .= '<li data-code="'.$val['id'].'">'.$val['name'].'</li>';
//                }
//            }else{
//                $this->error("数据获取错误！");
//            }
//            parent::$_VArray['seajsVer'] = $this->getVerification();
//            parent::$_VArray['seajsVer'] = 'app_id=android&ver=1.0.0&os=5.1&unique_id=869609022752180&ip=61.51.129.138&token=TA20180115214638PVEyiIFphAhsTtmR';
            parent::$_VArray['title'] = '放弃借款';
//            parent::$_VArray['reqUrl'] = '/v1/GiveUp/Add';
//            parent::$_VArray['jumpUrl'] = '/#jump=InstHome';
//
//            if(isset($_GET['intent'])&&$_GET['intent']=='InstHome') {
//                parent::$_VArray['backUrl'] = '/#jump=InstHome';
//            }else{
//                parent::$_VArray['backUrl'] = '?#jump=no';
//            }
            $view = View::factory($this->_vv.'Borrowmoney/GiveupReason');
            $view->_VArray = parent::$_VArray;
            $this->response->body($view);
        }

}