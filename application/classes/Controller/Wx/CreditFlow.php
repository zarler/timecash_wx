<?php defined('SYSPATH') or die('No direct script access.');
/*
 *  Tool::factory('Debug')->D($this->controller);
 *  Tool::factory('Debug')->array2file($array, $filename);
 *  Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
 *
 * */
class Controller_Wx_CreditFlow extends WxHome
{
    //构造方法  如果已登录  直接跳转到用户页面
    public function before()
    {
        parent::before();
    }

    /*******************************************************
     * 注册公司信息（工作信息）
     *******************************************************/
    public function action_WorkCredit(){
        //通过下面几个字段来判断是否完成基本授信(跳出)
        if(!Valid::not_empty(self::$arr_step)){
            //异常错误
            $this->error(Kohana::message('wx','abnormal_error'));
            die;
        }
        $view = View::factory($this->_vv.'Register/company');
        //判断跳转路径
        parent::$_VArray['type'] = Gv::$type;
        //请求地址
        parent::$_VArray['requestUrl'] = '/app/Functions/docompanyinfo';
        parent::$_VArray['title'] = Kohana::$config->load("url.title.login_company");
        parent::$_VArray['urlHome'] = '/?jump=no';
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);
    }
    /*******************************************************
     *注册紧急联系人
     *******************************************************/
    public function action_EmergencyContacts(){
        //通过下面几个字段来判断是否完成基本授信(跳出)
        if(!Valid::not_empty(self::$arr_step)){
            //异常错误
            $this->error(Kohana::message('wx','abnormal_error'));
            die;
        }
        $view = View::factory($this->_vv.'Register/contacts');
        //请求地址
        parent::$_VArray['requestUrl'] = '/app/Functions/docontacts';
        parent::$_VArray['title'] = Kohana::$config->load("url.title.login_contacts");
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);
    }
    //360手机动态验证码(手机循环入口)
    public function action_MNO_Rong360_Return(){
        //如果是120秒后跳过来
        if(isset($_GET['jump'])&&!empty($_GET['jump'])){
            if(Gv::$type == 2){
                $app = $this->getappapp(Gv::$app_token);
            }elseif(Gv::$type == 1){
                $app = $this->getapp();
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
                die;
            }
            $variable = array(
                "app"=>$app
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('CreditInfo','MNORecord','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                if(isset($result['result']['jump'])&&$result['result']['jump']==1){
                    echo $result['result']['html'];
                    die;
                }else{
                    $this->error('不需要移动运营商授权!');
                    die;
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
            //普通确定页面(用session区分)(MNO回调地址路径)
            //获取标记(Functions.php--->CreditQuery_TakeTurns)
            if($this->_session->sessionGet('rong360_MNS')==1){
                //直接跳倒计时(删除标记)
                $this->_session->sessionDelete('rong360_MNS');
                $this->redirect('/RegisterApp/CreditQuery_CountDown_Last');
                die;
            }else{
                //正规过来挑faceId
                $this->redirect('/?jump=BannerFaceIDAuth');
                die;
            }

//
//
//            $view = View::factory($this->_vv.'Register/MNO_Rong360_Return');
//            跳向faceId
//            $view->url = "/?jump=BannerFaceIDAuth";
//            $this->response->body($view);
        }
    }

    //天极回调(和上面的360一样)
    public function action_MNO_TCredit_Return(){
        //如果是120秒后跳过来
        if(isset($_GET['jump'])&&!empty($_GET['jump'])){
            if(Gv::$type == 2){
                $app = $this->getappapp(Gv::$app_token);
            }elseif(Gv::$type == 1){
                $app = $this->getapp();
            }else{
                //系统繁忙，请联系客服！
                $this->error(Kohana::message('wx','system_busy'));
                die;
            }
            $variable = array(
                "app"=>$app
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('CreditInfo','MNORecord','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                if(isset($result['result']['jump'])&&$result['result']['jump']==1){
                    echo $result['result']['html'];
                    die;
                }else{
                    $this->error('不需要移动运营商授权!');
                    die;
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
            //普通确定页面(用session区分)(MNO回调地址路径)
            //获取标记(Functions.php--->CreditQuery_TakeTurns)
            if($this->_session->sessionGet('rong360_MNS')==1){
                //直接跳倒计时(删除标记)
                $this->_session->sessionDelete('rong360_MNS');
                $this->redirect('/RegisterApp/CreditQuery_CountDown_Last');
                die;
            }else{
                //正规过来挑faceId
                $this->redirect('/?jump=BannerFaceIDAuth');
                die;
            }

//
//
//            $view = View::factory($this->_vv.'Register/MNO_Rong360_Return');
//            跳向faceId
//            $view->url = "/?jump=BannerFaceIDAuth";
//            $this->response->body($view);
        }
    }

    //授信倒计时
    public function action_CreditQuery_CountDown_Last(){
        $view = View::factory($this->_vv.'Register/CreditQuery_CountDown_Last');
        $this->_session->sessionDelete('rong360_MNS');
        //判读mno
        if(isset($_GET['jump'])){
            switch ($_GET['jump']){
                case 'overtime_2':
                    parent::$_VArray['content'] = '您的资料已提交,审核时间需要2分钟,请耐心等待审核结果,在此期间请不要返回或者退出APP,否则需要重新进行运营商授权流程。';
                    parent::$_VArray['time'] = 120;
                    break;
                default:
                    //超时
                    parent::$_VArray['content'] = '您的资料已提交,审核时间需要3分钟,请耐心等待审核结果,在此期间请不要返回或者退出APP,否则需要重新进行运营商授权流程。';
                    parent::$_VArray['time'] = 180;
                    break;
            }
        }else{
            //超时
            parent::$_VArray['content'] = '您的资料已提交,审核时间需要3分钟,请耐心等待审核结果,在此期间请不要返回或者退出APP,否则需要重新进行运营商授权流程。';
            parent::$_VArray['time'] = 180;
        }
        parent::$_VArray['requestUrl'] = "/wx/Functions/CreditQuery_TakeTurns";
        parent::$_VArray['requestjump'] = "/wx/CreditFlow/CreditQuery_CountDown_Result";
        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);
    }
    //授信结果
    public function action_CreditQuery_CountDown_Result(){
        $view = View::factory($this->_vv.'Register/CreditQuery_CountDown_Result');
        if(isset($_GET['jump'])){
            switch ($_GET['jump']){
                case 'overtime_3':
                    //超时
                    $view->title = '授权超时';
                    $view->content = '抱歉,运营商授权结果获取失败,请点击按钮尝试重新获取结果,可提高85%通过可能性,若基础授信通过,会进行短信通知,请及时查看。';
                    $view->submit = '点击重新获取';
                    $view->url = '/wx/CreditFlow/CreditQuery_CountDown_Last?jump=overtime_2';
                    break;
                case 'overtime_2':
                    //超时
                    $view->title = '授权超时';
                    $view->content = '审核已超时,请点击重试从新进行运营商授权,最多重试3次。';
                    $view->submit = '重试';
                    $view->url = '/wx/CreditFlow/MNO_Rong360_Return?jump=DynamicCode';
                    break;
                case 'pass':
                    $view->title = '审核通过';
                    $view->content = '<p style="text-align: center;font-size: 14px;line-height: 26px;">恭喜,您已经通过审核</br></br>授信额度:3000元</br>担保比例:100%</p>';
                    $view->submit = '确定';
                    $view->url = '/?#jump=yes';
                    break;
                case 'unknown':
                    $view->title = '审核失败';
                    $view->content = '您的资料暂不符合要求,未能通过审核,您可在30天后重新提交审核。';
                    $view->submit = '确定';
                    $view->url = '/?#jump=no';
                    break;
//                case 'failed':
//                    $view->title = '审核失败';
//                    $view->content = '您的资料暂不符合要求,未能通过审核,您可在30天后重新提交审核。';
//                    $view->submit = '确定';
//                    $view->url = '/wx/CreditFlow/MNO_Rong360_Return?jump=DynamicCode';
//                    break;
                default:
                    $view->title = '异常错误';
                    $view->content = '出现未知错误,请联系客服。';
                    $view->submit = '确定';
                    $view->url = '/?#jump=no';
                    break;
            }
        }else{
            $view->title = '异常错误';
            $view->content = '出现未知错误,请联系客服。';
            $view->submit = '确定';
            $view->url = '/?#jump=no';
        }
        $this->response->body($view);
    }



/*--------------------------------------v3上---------------------------------------------*/



    //注册公司信息(极速贷进来)
    public function action_CompanyExtreme(){
        //跳转(has_fastloan_order为1则不用添加工作信息)
        if(self::$arr_step['work_info']==2||self::$arr_step['has_fastloan_order']==1){
            $this->redirect('/RegisterApp/ContactsExtreme');
            die;
        }
        $view = View::factory($this->_vv.'Register/company');
        //通过下面几个字段来判断是否完成基本授信(跳出)
        parent::$_VArray['url'] = "/Borrowmoney/extremeBorrow";
        parent::$_VArray['jumpurl'] = "/?jump=yes";
        parent::$_VArray['type'] = 3;
        parent::$_VArray['title'] = Kohana::$config->load("url.title.login_company");

        $view->_VArray =  parent::$_VArray;
        $this->response->body($view);
    }


}