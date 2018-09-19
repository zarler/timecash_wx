<?php defined('SYSPATH') or die('No direct script access.');

/*
  * app兼容优惠券
  *Tool::factory('Debug')->D($this->controller);
  *Tool::factory('Debug')->array2file($array, $filename);
  *Tool::factory('Debug')->array2file($this->post, APPPATH.'../static/ui_bootstrap/liu_test.txt');
d*/
    class Controller_CouponApp extends Home {
		

        public function action_index()
        {
            $view = View::factory('Account/index');
            $view->controller = $this->_controller;
			$view->title=Kohana::$config->load('url.title.account');
            $this->response->body($view);
        }

        //优惠券
        public function action_coupon(){
            $view = View::factory($this->_vv.'CouponOld/coupon');
            $view->title=Kohana::$config->load('url.title.coupon');
            //获取优惠券可用列表
            if(Gv::$type == 2){
                $variable = array(
                    "app"=>$this->getappapp(Gv::$app_token)
                );
            }elseif(Gv::$type == 1){
                $variable = array(
                    "app"=>$this->getapp()
                );
            }else{
                $this->error('获取信息失败!');
                die;
            }
            $json_info = json_encode($variable);
            $result = $this->_api->getApiArrays('Coupon','Available','',array('json'=>$json_info));
            if(isset($result) && $result['code']==1000){
                $view->couponlist = isset($result['result']['coupon'])?(count($result['result']['coupon'])>0?$result['result']['coupon']:null):null;
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
                $view->total_coupon = count($couponlastlist);
                if($view->total_coupon>0){
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
            $view->controller = $this->_controller;
            $view->couponlastlist = count($couponlastlist)>0?$couponlastlist:null;
            $view->last_id = $last_id?$last_id:null;
            $this->response->body($view);
        }



}