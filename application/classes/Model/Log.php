<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: liujinsheng
 * 微信信息
 */
//关键词常量
class Model_Log extends Model_Home {

    /*------------------------------------------user_wechat_behavior-----------------------------------------------------------*/
    //保存模板消息反馈信息 templatesEndJobFinish
    public function insert_Log($array = null) {
        if(empty($array)){
            return false;
        }
        list($insert_id, $total_rows) = DB::insert('log', array_keys($array))->values(array_values($array))->execute();
        if($insert_id){
            return $insert_id;
        }
        return false;
    }

}