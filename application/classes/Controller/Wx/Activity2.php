<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 活动页面
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_Wx_Activity2 extends WxHome
{
    protected $_activity = null;
    protected $_signPackage = null;
    protected $_RecordVisit = null;
    //构造方法  如果已登录  直接跳转到用户页面
    public function before(){
        parent::before();
        $this->_activity = Model::factory('Activity');
        //$this->_signPackage = $this->signPackage();
    }
    /************************************************************************************************************************************
     * 借的到才是硬道理(KJJD0420)
     ************************************************************************************************************************************/
    public function action_KJJD0420(){

        //流量统计(按照ip统计)
        $this->_RecordVisit = array('action'=>'look', 'event_name'=>'KJJD0420', 'reg_app'=>'wechat', 'table'=>'ac_count');
        $this->_activity->insert_statistics(array('user_id'=>isset(Gv::$_userInfo['user_id'])?Gv::$_userInfo['user_id']:null,'action'=>$this->_RecordVisit['action'],'ip'=>$this->_ip,'create_time'=>time(),'event_name'=>$this->_RecordVisit['event_name'],'reg_app'=>$this->_RecordVisit['reg_app']),$this->_RecordVisit['table']);

        parent::$_VArray['jumpUrl'] = '/';
        $view = View::factory($this->_vv.'Activity2/KJJD0420');
        $view->_VArray = parent::$_VArray;
        $this->response->body($view);
    }
}