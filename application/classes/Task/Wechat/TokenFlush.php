<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: majin
 * Date: 16/12/6
 * Time: 上午11:07
 *
 * 微信端定时任务
 * 每5-10分钟检测一次微信TOKEN是否过期,距离过期时间小于30分钟时主动刷新
 *  可以在多台服务器上同时运行,控制好相互间隔即可
 *
 */
class Task_Wechat_TokenFlush extends Minion_Task {

    protected static $_wechat_token = NULL;
    protected static $_wechat_expire = 1800;
    protected static $_config;

    protected  $_options = array(
        'expire' => 0,
    );


    public function __construct() {
        parent::__construct();
        self::$_wechat_token = Model::factory('Wechat_Token');
        //配置文件里的微信appId和appSecret
        self::$_config = Kohana::$config->load('site')->get('wx');
        if(!self::$_config ||!isset(self::$_config['appId']) || !isset(self::$_config['appSecret']) || !isset(self::$_config['apiUrl']) ){
            echo "无法获取微信配置信息\r\n";
            exit;
        }
    }



    public function _execute(array $param) {
        if( isset($param['expire']) && $param['expire']>0 ){
            self::$_wechat_expire = (int)$param['expire'];
        }
        $wechat_token = Libs::factory('TCCache_Wechat')->uri(Model_Wechat_Token::WX_KEY)->get();
        if(!$wechat_token){
            $wechat_token = self::$_wechat_token->get_one();

            if(!$wechat_token){
                echo "微信 access token 读取失败\r\n";
                exit;
            }
        }

//        if(isset($wechat_token['expires_in'])  &&  $wechat_token['expires_in']<time() && time()-$wechat_token['expires_in']>self::$_wechat_expire  ){
        if(isset($wechat_token['expires_in'])  &&  $wechat_token['expires_in']<time()  ){
            $this->token_flush();
        }else{

            echo "\r\n".date('Y-m-d H:i:s').' ' . __CLASS__ . "\t无需更新\r\n";
        }

    }


    public function token_flush(){

        echo "\r\n".date('Y-m-d H:i:s').' ' . __CLASS__ . "\tBegin\r\n";


//        $token_array['access_token'] = '5_JheDEVzn6oZysGgP7ec2CQ5kd726Gj03Nt8aiOMxhms1Dcubz7exPVYcSf1Z3Nc4fCVI9m8Bz_ioCC-rSJm6dC7bFReKJZLEKFwoMYXlTGNrlLckBFxoMLqDGnYFJLfACAYCE';
//        echo '<pre>';
//        print_r(self::$_config['apiUrl'].'/cgi-bin/ticket/getticket?type=jsapi&access_token='.$token_array['access_token']);
//        echo '<pre>';
//        die;

        $token_api = HttpClient::factory(self::$_config['apiUrl'].'/cgi-bin/token?grant_type=client_credential&appid='.self::$_config['appId'].'&secret='.self::$_config['appSecret'].'')->execute();
        $token_array = $token_api->as_array();
        if(is_array($token_array) && isset($token_array['access_token']) && isset($token_array['expires_in'])){
            $ticket_api = HttpClient::factory(self::$_config['apiUrl'].'/cgi-bin/ticket/getticket?type=jsapi&access_token='.$token_array['access_token'])->execute();
            $ticket_array = $ticket_api->as_array();
            if(is_array($ticket_array) && isset($ticket_array['ticket'])){
                $update_array = [
                    'token'=>$token_array['access_token'],
                    'ticket'=>$ticket_array['ticket'],
                    'expires_in'=>$token_array['expires_in']+time()
                ];
                Libs::factory('TCCache_Wechat')->uri(Model_Wechat_Token::WX_KEY)->set($update_array);
                Model::factory('Wechat_Token')->update($update_array);
                echo "access_token: {$token_array['access_token']}\r\nticket: {$ticket_array['ticket']}\r\n";
            }else{
                echo "\r\nticket获取失败,返回:-------------------\r\n".$ticket_api->body()."\r\n--------------------\r\n";
            }
        }else{
            echo "\r\ntoken获取失败,返回:-------------------\r\n".$token_api->body()."\r\n--------------------\r\n";
        }
        echo "\r\n".date('Y-m-d H:i:s').' ' . __CLASS__ . "\tEnd.\r\n";
    }

    public function token_Test(){





        $token_api = HttpClient::factory(self::$_config['apiUrl'].'/cgi-bin/token?grant_type=client_credential&appid=wxb6606932ddd5f1fa&secret=12b55a75c9af1d9a0855d11c49473c36')->execute();
        $token_array = $token_api->as_array();
        print_r($token_array);

    }



}