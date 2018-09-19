<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: liujinsheng
 * 身份证图片数据
 */
//关键词常量
class Model_Picauth extends Model_Home {


    //获得用户图片数据id
    public function get_id(){
        return DB::select('id')->from('user_picauth')->limit(1)->where('user_id','=',$this->session->sessionGet('uid'))->execute()->current();
    }

    //查询身份证是否通过审核
    public function get_picStatus(){
        $picStatus = DB::select('id')->from('user_picauth')->where('user_id','=',$this->session->sessionGet('uid'))->and_where('status','=','1')->execute()->current();
        return $picStatus['id'];
    }
    //如果没有通过 查询最近一条提交身份证信息的状态
    public function get_newpic(){
        return DB::select('status,message')->from('user_picauth')->limit(1)->order_by('create_time','DESC')->where('user_id','=',$this->session->sessionGet('uid'))->and_where('status','<>','1')->execute()->current();;
    }
    //获得已上传图片信息
    public function get_picauth(){
        return DB::query(Database::SELECT, "SELECT id FROM {$this->prefix}user_picauth where user_id = '{$this->session->sessionGet('uid')}' and (status='1' or status='3')")->execute()->current();
    }
    //添加信息
    public function insert_picauth($array){
        list($insert_id, $total_rows) = DB::insert('user_picauth', array_keys($array))->values(array_values($array))->execute();
        if($insert_id){
            return $insert_id;
        }
        return false;
    }
    //获得图片失败原因
    public function get_message(){
        return DB::select('message')->from('user_picauth')->limit(1)->order_by('create_time','DESC')->where('user_id','=',$this->session->sessionGet('uid'))->and_where('status','=','2')->execute()->current();
    }
    //获得上传总数
    public function get_uppic_count(){
        return DB::query(Database::SELECT, "SELECT count(id) as count FROM {$this->prefix}user_picauth where user_id = '{$this->session->sessionGet('uid')}' ")->execute()->current();
    }

}