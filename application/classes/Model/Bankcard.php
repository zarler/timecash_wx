<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: liujinsheng
 * 银行卡信息
 */
//关键词常量
class Model_Bankcard extends Model_Home {

    //查找银行卡
    public function get_bankcard_info($uid){
        return DB::query(Database::SELECT, "SELECT id,card_no,bank_id FROM {$this->_prefix}bankcard where user_id = '{$uid}' and `status`='1'")
            ->execute()
            ->as_array();
    }
    //查找银行卡信息
    public function get_back_toid($card_no){
       return  DB::select('id')->from('bankcard')->where('card_no', '=', $card_no)->and_where('status', '=', '1')->execute()->current();
    }
    //获得全部银行卡
    public function get_allbank(){
        return DB::select('id,name,code')->from('bank')->where('status', '=', '1')->execute()->as_array();
    }
    //添加银行卡信息
    public function insert_bankcard($array){
        list($insert_id, $total_rows) = DB::insert('bankcard', array_keys($array))->values(array_values($array))->execute();
        if($insert_id){
            return $insert_id;
        }
        return false;
    }
    //查找某人银行卡是否存在
    public function is_exist(){
        return DB::select('id')->from('bankcard')->where('user_id', '=', $this->_session->sessionGet('uid'))->and_where('status', '=', '1')->execute()->current();
    }
    //获得信用卡信息
    public function get_creditcard_info($field,$user_id){
        if(!$user_id){
            return false;
        }
        return DB::select($field)->from('creditcard')->where('user_id', '=', $user_id)->and_where('status', '=', '1')->execute()->as_array();
    }
    //获得信用卡信息
    public function get_creditcard_info_arr($field,$array = null){
        if(!$array){
            return false;
        }
        $query = DB::select($field)->from('creditcard');
        foreach($array as $key=>$val){
            $query->and_where($key,'=',$val);
        }
        return $query ->execute()->as_array();
    }
    //获得银行卡信息
    public function get_bankcard_info_arr($field,$array = null){
        if(!$array){
            return false;
        }
        $query = DB::select($field)->from('bankcard');
        foreach($array as $key=>$val){
            $query->and_where($key,'=',$val);
        }
        return $query ->execute()->as_array();
    }



    //注销信用卡
    public function cancel_creditcard($id,$user_id){
        DB::update('creditcard')->set(array("status" => '2'))->where('user_id', '=', $user_id)->and_where("status", '=', '1')->and_where("id", '=', $id)->execute();
    }
    //注销银行卡
    public function cancel_bankcard($id,$user_id){
        DB::update('bankcard')->set(array("status" => '2'))->where('user_id', '=', $user_id)->and_where("status", '=', '1')->and_where("id", '=', $id)->execute();
    }

    //判断是否已经存在默认的信用卡
    public function is_default(){
        $dbfind = DB::select('id')->from('creditcard')->where('user_id', '=', $this->_session->sessionGet('uid'))->and_where("`default`", '=', '1')->execute()->current();
        return $dbfind;
    }
    //查找默认的信用卡
    public function get_default(){
        $dbfind = DB::select('card_no,id')->from('creditcard')->where('user_id', '=', $this->_session->sessionGet('uid'))->and_where("`default`", '=', '1')->execute()->current();
        return $dbfind;
    }
    //修改默认信用卡
    public function set_default(){
        DB::update('creditcard')->set(array("`default`" => '2'))->where('user_id', '=', $this->_session->sessionGet('uid'))->and_where("`default`", '=', '1')->execute();
    }
    public function set_default_only($id){
       return DB::update('creditcard')->set(array("`default`" => '1'))->where('id', '=', $id)->execute();
    }

    //添加新信息，如果重复修改
    public function insert_update_bankcard($array){
        if(!$array){
            return false;
        }
        $keyarr = implode(",",array_keys($array));
        $valarr = "'".implode("','",array_values($array))."'";
        DB::query(Database::INSERT,"INSERT INTO {$this->_prefix}bankcard($keyarr)VALUES({$valarr}) ON DUPLICATE KEY UPDATE card_no=VALUES(card_no),bank_name=VALUES(bank_name),status=VALUES(status)")
            ->execute();
        return true;
    }
    //添加新信息，如果重复修改
    public function insert_update_creditcard($array){
        if(!$array){
            return false;
        }
        $keyarr = implode(",",array_keys($array));
        $valarr = "'".implode("','",array_values($array))."'";
        DB::query(Database::INSERT,"INSERT INTO {$this->_prefix}creditcard($keyarr)VALUES({$valarr}) ON DUPLICATE KEY UPDATE card_no=VALUES(card_no),bank_name=VALUES(bank_name),bank_code=VALUES(bank_code),status=VALUES(status)")
            ->execute();
        return true;
    }


    //添加信息
    public function insert_creditcard($array){
        list($insert_id, $total_rows) = DB::insert('creditcard', array_keys($array))->values(array_values($array))->execute();
        if($insert_id){
            return $insert_id;
        }
        return false;
    }

    //做一个判断 判断是否 上一步信用卡是否选择好
    public function check_creditcard(){
       return  DB::query(Database::SELECT, "select id,bank_code from `{$this->_prefix}creditcard` where id = (SELECT creditcard_id FROM `{$this->_prefix}order` WHERE user_id='{$this->_session->sessionGet('uid')}' and status='0')")->execute()->current();
    }
    //做一个判断 判断是否 上一步信用卡是否选择好
    public function get_creditcard_toid($id){
        return  DB::query(Database::SELECT, "SELECT card_no FROM {$this->_prefix}creditcard   WHERE id='{$id}'")->execute()->current();
    }
}