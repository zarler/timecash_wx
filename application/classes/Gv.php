<?php
/**
 * Created by PhpStorm.
 * User: machenike
 * Date: 2016/5/22
 * Time: 10:18
 */
class Gv{
    public static $api_token = NULL;
    public static $app_token = NULL;
    public static $user_id = NULL;
    public static $mobile = NULL;
    public static $target_token = NULL;
    public static $type = NULL;//区分客户端口  1为web端，2为其他端
    public static $status = NULL;
    public static $Log = false;  //true为登陆，false为未登录
    public static $credited = false;  //true为登陆，false为未登录
    public static $_userInfo = null;  //用户基本信息
    public static $_Openid = null;


    public static function init($array = null){
        Gv::$api_token = isset($array['api_token'])?$array['api_token']:NULL;
        Gv::$app_token = isset($array['app_token'])?$array['app_token']:NULL;
        Gv::$user_id = isset($array['user_id'])?$array['user_id']:NULL;
        Gv::$type = isset($array['type'])?$array['type']:NULL;
        Gv::$target_token = isset($array['target_token'])?$array['target_token']:NULL;
        Gv::$mobile = isset($array['mobile'])?$array['mobile']:NULL;
        Gv::$status = isset($array['status'])?$array['status']:NULL;
        Gv::$credited = isset($array['credited'])?$array['credited']:NULL;
    }
    public static function initArray($array = null){
        self::$_userInfo = $array;
    }
}