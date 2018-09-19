<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: liujinsheng
 * 身份证图片数据
 */
//关键词常量
class Model_Order extends Model_Home {
    //判断当前订单状态
    public function get_orderStatus($field,$user_id){
        $status = DB::select($field)->from('order')->limit(1)->where('user_id','=',$user_id)
//            ->compile();
            ->execute()
            ->current();
        return $status;
    }
    //根据传入字段获得其值（未完成的订单信息）
    public function get_fieldstatus($field,$uid){
        if(!Valid::not_empty($uid)){
            return false;
        }
        $order = DB::query(Database::SELECT, "SELECT $field FROM {$this->_prefix}order  where  user_id = '{$uid}' and status='0'")->execute()->current();
        return $order;
    }
    //获得未完成订单总数(为极速贷专业,暂时)
    public function get_order_count($uid){
        if(!Valid::not_empty($uid)){
            return false;
        }
        return DB::select('id')
            ->from('order')
            ->where("user_id",'=',$uid)
            ->where("status","=",0)
            ->execute()
            ->count();
    }
    //获得未完成订单总数(为极速贷专业,暂时)
    public function get_order_count_type($uid,$type,$no = false){
        if(!Valid::not_empty($uid)){
            return false;
        }
        $query = DB::select('id')->from('order');
        if($no){
            $query = $query->and_where("type",'!=',$type);
        }else{
            $query = $query->and_where("type",'=',$type);
        }
        return $query->and_where("user_id",'=',$uid)->and_where("status","=",0)->execute()->count();
    }


    //删除订单信息

    public function delete_order($uid){
        return  DB::delete('order')->where('user_id','=',$uid)->execute();
    }
    //删除优惠券
    public function delect_order_coupon($user_id){
        DB::update('order')->set(array("coupon_id" => 0,"coupon_amount" => 0.00))->where('user_id', '=', $user_id)->execute();
    }

    //获得未完成订单总数
    public function get_order_info($uid,$field){
        if(!Valid::not_empty($uid)){
            return false;
        }
        return DB::select($field)
            ->from('order')
            ->where("user_id",'=',$uid)
            ->where("status","=",0)
            ->execute()
            ->current();
//        return DB::query(Database::SELECT, "SELECT count(id) as count FROM {$this->prefix}order where user_id = '{$uid}' and `status`='0'")->execute()->current();;
    }
    //插入订单信息
    public function insert_order($array){
        list($insert_id,$affected_rows) = DB::insert('order', array_keys($array))->values(array_values($array))->execute();
        if($insert_id) {
            return $insert_id;
        }
        return FALSE;
    }
    //添加order_change数据
    public function insert_order_charge($array){
        list($insert_id,$affected_rows) = DB::insert('order_charge', array_keys($array))->values(array_values($array))->execute();
        if($insert_id) {
            return $insert_id;
        }
        return FALSE;
    }

    //修改order_change数据
    public function update_order_charge($array,$id){
        return DB::query(Database::UPDATE, "update {$this->_prefix}order_charge set amount=:amount where order_id = '{$id}' and in_de='1'")
            ->parameters($array)
            ->execute();
    }
    //判断是否有优惠券
    public function get_couponid($id){
        return DB::select('id')->from('order_charge')->where('order_id', '=', $id)->and_where('in_de', '=', '2')->execute()->current();
    }

    //修改未完成的订单信息
    public function update_order_info($array,$num){
         DB::update('order')->set($array)->where('order_no', '=', $num)->execute();
    }
    //修改订单信息
    public function update_order_info_field($array,$user_id){
        return DB::update('order')->set($array)->where('user_id', '=', $user_id)->and_where('status', '=', '0')->execute();
    }

    //修改订单信息(单独为区分type为3写的)
    public function update_order_info_field_type($array,$user_id,$type){
        if($type==3){
            return DB::update('order')->set($array)->where('user_id', '=', $user_id)->where('type', '=', $type)->and_where('status', '=', '0')->execute();
        }else{
            return DB::update('order')->set($array)->where('user_id', '=', $user_id)->where('type', '!=', 3)->and_where('status', '=', '0')->execute();
        }
    }

    //查询当前用户的订单信息
    public function get_now_order_info(){
       return  DB::query(Database::SELECT, "SELECT o.id,o.payment_amount,o.repayment_amount,o.day,o.charge,o.bankcard_no,c.card_no FROM `{$this->_prefix}order` as o ,{$this->_prefix}creditcard as c  WHERE o.user_id='{$this->session->sessionGet('uid')}' and o.status='0' and o.creditcard_id=c.id")->execute()->current();
    }
    //判断是否之前有过成功的借款记录 Y 手续费加4  N 加8
    public function is_first(){
        return  DB::query(Database::SELECT, "SELECT id FROM {$this->_prefix}order where user_id = '{$this->session->sessionGet('uid')}' and (`status`='8' or `status`='21' or `status`='51') limit 0,1")->execute()->current();
    }
    //获取订单失败原因
    public function get_message(){
        return DB::query(Database::SELECT, "SELECT status_message FROM {$this->_prefix}order where user_id = '{$this->session->sessionGet('uid')}' and (status='3' or status='10') order by create_time desc limit 1")->execute()->current();
    }
    //根据id获取的订单信息
    public function get_order_info_toid($id){
        return  DB::query(Database::SELECT, "SELECT refunded_amount,payment_amount,repayment_amount,day,charge,bankcard_no,creditcard_id FROM `{$this->_prefix}order`   WHERE id='{$id}' ")->execute()->current();
    }

}