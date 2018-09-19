<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: liujinsheng
 * Date: 15/12/31
 */
class Model_Session extends  Model_Database{
    //dbsession 设置
    public function sessionSet($k,$v){
        Session::instance('database')->set($k,$v);
    }
    //dbsession 获取
    public function sessionGet($value){
        return Session::instance('database')->get($value);
    }
    //dbsession 删除
    public function sessionDelete($k){
        Session::instance('database')->delete($k);
    }
    //dbsession 删除
    public function Delete(){
        Session::instance('database')->destroy();
    }
}