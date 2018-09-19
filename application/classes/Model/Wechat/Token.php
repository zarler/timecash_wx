<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Created by PhpStorm.
 * User: majin
 * Date: 16/12/5
 * Time: 下午1:51
 *
 * 微信TOKEN 查询与刷新
 *
 */
class Model_Wechat_Token extends Model_Database
{

    const WX_KEY ='tcwx_v2';

    // 查询
    public function get_one(){
        $data = DB::select()->from('wxconst')->where('status','=','1')->execute()->current();
        return $data;
    }

    // 修改
    public function update($array=NULL) {
        if($array===NULL){
            return FALSE;
        }
        //array('token'=>$accessToken,'ticket'=>$wx_card_json['ticket'],'expires_in'=>$token_json['expires_in']+time())
        $affected_rows = DB::update('wxconst')->set($array)->where('status','=','1')->execute();

        return $affected_rows!==NULL;
    }


}