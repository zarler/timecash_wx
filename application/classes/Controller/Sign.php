<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 签到页面
 *  * Tool::factory('Debug')->D($this->controller);
 * Tool::factory('Dir')->dir_path(self::$config['security_path']).$result[0]['uri']);
 * Tool::factory('Debug')->array2file(array(1,2,3,4,5), APPPATH.'../static/liu_test.php');
 *
 *
 * */
class Controller_Sign extends WxHome
{
    protected $_activity = null;
    protected $_signPackage = null;
    //构造方法  如果已登录  直接跳转到用户页面
    public function before()
    {
        $this->_activity = Model::factory('Activity');
        parent::before();
    }
    //二期
    //发送模板到注册页面
    public function action_SignPage()
    {
        $view = View::factory($this->_vv.'Sign/SignPage');
        if(isset(Gv::$_userInfo['user_id'])&&Valid::not_empty(Gv::$_userInfo['user_id'])){
            //用户uv统计
            if($this->_activity->select_userid_day(array('user_id'=>Gv::$_userInfo['user_id'],'action'=>'look','event_name'=>'TCOA_008_LOOK'),'ac_count')){
                //插入
                $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR'])&&$_SERVER['HTTP_X_FORWARDED_FOR']?$_SERVER['HTTP_X_FORWARDED_FOR']:(isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'');
                $ip = explode(",",$ip)[0];
                $this->_activity->insert_userid_day(array('user_id'=>Gv::$_userInfo['user_id'],'event_name'=>'TCOA_008_LOOK','ip'=>$ip,'action'=>'look','create_time'=>time()),'ac_count');
            }
            $view->is_login = true;
            $variable = array(
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('CheckIn','get_info','',array('json'=>$json_info));
//            Tool::factory('Debug')->D($result);
            if(isset($result) && $result['code']==1000){
                $view->total_day = $result['result']['total_day'];
                $view->is_checkin_today = $result['result']['is_checkin_today'];
                $view->prevSignArr = json_encode(array('pre'=>$result['result']['pre'],'cur'=>$result['result']['cur']));
            }else{
                if(isset($result['code'])){
                    $this->error($result['message']);
                    die;
                }else{
                    //系统繁忙，请联系客服！
                    $this->error(Kohana::message('wx','system_busy'));
                    die;
                }
            }
        }else{
            //未登录
            //保存登录地点
            $this->_session->sessionSet('activity','/'.$this->_controller.'/'.$this->_action);
            $view->prevSignArr = json_encode(array('pre'=>'','cur'=>''));
            $view->total_day = 0;
            $view->is_login = false;
        }
        $view->month = Tool::factory('String')->numeric(Date('n'));
        $this->response->body($view);
    }





    //签到兑换优惠券
    public function action_SignCoupon()
    {
        $view = View::factory($this->_vv.'Sign/CalendarCoupon');
        if(Valid::not_empty(Gv::$_userInfo['user_id'])){
            $view->is_login = true;
            $variable = array(
                "app"=>$this->getWxInfo()
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('CheckIn','get_info','',array('json'=>$json_info));
//            Tool::factory('Debug')->D($result);
            if(isset($result) && $result['code']==1000){
                $view->total_day = $result['result']['total_day'];
                $view->strli = '';
                if($view->total_day>=7){
                    $view->strli .= '<li class="newcoupon" data-day = "7"><a>10元<br><span>打卡7天可兑满500元可用</span></a></li>';
                }else{
                    $view->strli .= '<li class="oldcoupon" data-day = "7"><a>10元<br><span>打卡7天可兑满500元可用</span></a></li>';
                }
                if($view->total_day>=14){
                    $view->strli .= '<li class="newcoupon" data-day = "14"><a>20元<br><span>打卡14天可兑满1000元可用</span></a></li>';
                }else{
                    $view->strli .= '<li class="oldcoupon" data-day = "14"><a>20元<br><span>打卡14天可兑满1000元可用</span></a></li>';
                }
                if($view->total_day>=21){
                    $view->strli .= '<li class="newcoupon" data-day = "21"><a>30元<br><span>打卡21天可兑满1500元可用</span></a></li>';
                }else{
                    $view->strli .= '<li class="oldcoupon" data-day = "21"><a>30元<br><span>打卡21天可兑满1500元可用</span></a></li>';
                }
                
            }else{
                if(isset($result['code'])){
                    $this->error($result['message']);
                    die;
                }else{
                    //系统繁忙，请联系客服！
                    $this->error(Kohana::message('wx','system_busy'));
                    die;
                }
            }
        }else{
            //未登录
            $this->redirect('/');
        }
        $this->response->body($view);
    }
}