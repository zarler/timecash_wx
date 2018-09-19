<?php defined('SYSPATH') or die('No direct script access.');
/*
 * 功能ajax请求核心文件
 * */
class Controller_FunctionsCount  extends Controller {
    //如果已登录  直接跳转到用户页面
    public function before(){
        parent::before();
    }
    /*-------------------------------------------登陆，修改密码----------------------------------------------------------*/
    //点击统计
    public function action_inviteFriend(){
        if($this->request->method()=='POST'){
           // $_GET['d'] = isset($_POST['uniqueid'])?$_POST['uniqueid']:null;
            //点击统计
            $this->browseStatistics($_POST['activity_id'],'click',$_POST['reg_app']);
            die;
        }
    }

    //浏览量统计
    protected  function browseStatistics($activity_id=null,$event=null,$client='else',$view=null){
        if(empty($activity_id)||empty($event)){
            return false;
        }
        if(isset(Gv::$type)&&Gv::$type==1){
            $unique = $this->session->sessionGet('wx')['openid'];
            $unique = empty($unique)?null:$unique;
        }else{
            $unique = (isset($_GET['d'])&&!empty($_GET['d']))?$_GET['d']:null;
        }
        $browseTotal = array(
            'user_id'=>(isset(Gv::$user_id)&&!empty(Gv::$user_id))?Gv::$user_id:0,
            'pagetype'=>'/'.$this->controller.'/'.$this->action,
            'uniqueid'=>$unique,
            'reg_app'=>($client=='else')?'wechat':$client,
            'event'=>$event,
            'create_time'=>time(),
            'activity_id'=>$activity_id
        );
        if($event=='click'){
            exit(json_encode(array('status' =>false,'msg'=>json_encode($browseTotal))));
        }
        //exit(json_encode(array('status' =>false,'msg'=>json_encode($browseTotal))));
        if(!empty($view)){
            $view->browseTotal = $browseTotal;
        }
        if(empty($unique)&&empty(Gv::$user_id)){
            return false;
        }else{
            $info = $this->activity->get_browse_info(array('pagetype'=>$browseTotal['pagetype'],'activity_id'=>$activity_id,'event'=>$event),array('user_id'=>Gv::$user_id,'uniqueid'=>$unique,));
            //存在更改,没有插入
            if(empty($info)){
                $this->activity->insert_browse_info($browseTotal);
            }
        }
    }

}