<?php defined('SYSPATH') or die('No direct script access.');

/*
  * app兼容优惠券
  *Tool::factory('Debug')->D($this->controller);
  *Tool::factory('Debug')->array2file($array, $filename);
  *Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
d*/
    class Controller_App_CouponList extends AppHome {
		

        public function action_index()
        {
            $view = View::factory('Account/index');
            $view->controller = $this->_controller;
			$view->title=Kohana::$config->load('url.title.account');
            $this->response->body($view);
        }

        //优惠券
        public function action_coupon(){
            parent::$_VArray['title']=Kohana::$config->load('url.title.coupon');
            //获取优惠券可用列表
            $variable = array(
                "app"=>$this->getAppInfo(Gv::$_userInfo['token'])
            );
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('Coupon','Available','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                parent::$_VArray['couponlist'] = isset($result['result']['coupon'])?(count($result['result']['coupon'])>0?$result['result']['coupon']:null):null;
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
            $result = $this->_api->getApiArrays('Coupon','History','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                $couponlastlist = isset($result['result']['coupon'])?(count($result['result']['coupon'])>0?$result['result']['coupon']:null):null;
                //优惠券过期判断
                //获取个数判断是否有翻页
                parent::$_VArray['total_coupon'] = count($couponlastlist);
                if(parent::$_VArray['total_coupon']>0){
                    foreach($couponlastlist as $key=>&$val){
                        switch ($val['status']){
                            case 2:
                                //已经使用
                                $val['img'] = '/static/images/v2/icon-beenused.png';
                                break;
                            default:
                                if($val['expire_time']<time()){
                                    $val['img'] = '/static/images/v2/icon-Overdue.png';
                                }else{
                                    $val['img'] = null;
                                }
                                break;
                        }
                    }
                }
                $last_id = isset($result['result']['last_id'])?($result['result']['last_id']>0?$result['result']['last_id']:0):0;
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
            parent::$_VArray['controller'] = $this->_controller;
            parent::$_VArray['couponlastlist'] = count($couponlastlist)>0?$couponlastlist:null;
            parent::$_VArray['last_id'] = $last_id?$last_id:null;
            parent::$_VArray['requestUrl'] = '/app/Functions/GetMoreCoupen';
            $view = View::factory($this->_vv.'Coupon/coupon');
            $view->_VArray =  parent::$_VArray;
            $this->response->body($view);
        }



}