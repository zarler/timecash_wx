<?php
/**
 * Created by PhpStorm.
 * User: machenike
 * Date: 2016/5/22
 * Time: 10:18
 */
class Wxgv{
    public static $login = false;  //true为登陆，false为未登录
    public static $wx = array();
    public static $userinfo = array();
    public static $type = NULL;//区分客户端口  1为web端，2为其他端
    public static function init($array = null){
    }

}