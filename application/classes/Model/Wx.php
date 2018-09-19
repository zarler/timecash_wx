<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: liujinsheng
 * 微信信息
 */
//关键词常量
class Model_Wx extends Model_Home {


    /*------------------------------------------user_wechat_2weima-----------------------------------------------------------*/
    //获取微信二维码信息
    public function get_2weimainfo($scene_id=null) {
        if(empty($scene_id)){
            return false;
        }
        $query = DB::select()->from('user_wechat_2weima');
        $result = $query->where('scene_id','=',$scene_id)->execute()->current();
        return empty($result)?false:$result;
    }
    //插入新信息

    public function insert_2weimainfo($array = null) {
        if(empty($array)){
            return false;
        }
        list($insert_id, $total_rows) = DB::insert('user_wechat_2weima', array_keys($array))->values(array_values($array))->execute();
        if($insert_id){
            return $insert_id;
        }
        return false;
    }

    //修改微信二维码信息
    public function update_2weimainfo($array=null,$scene_id=null) {
        if(empty($array)||empty($scene_id)){
            return false;
        }

        return DB::update('user_wechat_2weima')->set($array)->where('scene_id', '=', $scene_id)->execute();
    }

/*------------------------------------------user_wechat_behavior-----------------------------------------------------------*/
    //查找分享关联表用户信息入库(活动)
    public function insert_shareUserInfo($array = null) {
        if(empty($array)){
            return false;
        }
        list($insert_id, $total_rows) = DB::insert('user_wechat_behavior', array_keys($array))->values(array_values($array))->execute();
        if($insert_id){
            return $insert_id;
        }
        return false;
    }
    //查找分享关联表用户信息(活动)
    public function get_shareUserInfo($field = '',$where=null) {
        if(empty($field)){
            $query = DB::select()->from('user_wechat_behavior');
        }else{
            $query = DB::select($field)->from('user_wechat_behavior');
        }
        if(!empty($where)){
            foreach ($where as $key=>$val){
                $query->where($key,'=',$val);
            }
        }
        $result = $query->execute()->current();
        return empty($result)?false:$result;
    }
    //修改微信二维码信息
    public function update_shareUserInfo($array=null,$where=null) {
        if(empty($array)||empty($where)){
            return false;
        }
        $query = DB::update('user_wechat_behavior')->set($array);
        if(!empty($where)){
            foreach ($where as $key=>$val){
                $query->where($key,'=',$val);
            }
        }else{
            return false;
        }
        return $query->execute();
    }
    /*------------------------------------------user_wechat_behavior-----------------------------------------------------------*/

    //保存模板消息反馈信息 templatesEndJobFinish
    public function insert_templatesEndJobFinish($array = null) {
        if(empty($array)){
            return false;
        }
        list($insert_id, $total_rows) = DB::insert('wechat_template_message', array_keys($array))->values(array_values($array))->execute();
        if($insert_id){
            return $insert_id;
        }
        return false;
    }

}