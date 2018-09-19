<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * User: liujinsheng
 * 身份证图片数据
 */
//关键词常量
class Model_Home extends Model_Database {

    const PAGE_TO_LOGIN = "280"; //跳登陆页面
    const PAGE_TO_CREDIT = "290"; //跳授信页面页面
    const PAGE_TO_LEND_MONEY = "130"; //跳借款流程页面
    const PAGE_TO_REPAYMENT = "180"; //跳还款流程页面
    const PAGE_TO_GOON = "140"; //继续借款
    const PAGE_TO_FORBID = "forbid"; //禁止借款
    const NEW_USER_NO_BORROW = 'noborrow';//新注册用户,暂时不能借款

    //授信状态
    const PAGE_TO_CREDIT_SUBMITTED = "credit_submitted"; //预授权已提交
    const PAGE_TO_CREDIT_READY = "credit_ready"; //预授权审核中
    const PAGE_TO_CREDIT_BASE_FALSE = "credit_base_false"; //基础授信失败,不能借款

    const PAGE_TO_INIT = "init"; //初始状态0
    const PAGE_TO_READY = "ready"; //待审状态1
    const PAGE_TO_PASS = "pass"; //通过2
    const PAGE_TO_REJECT = "reject"; //拒绝3
    const PAGE_TO_PAY_IN = "pay_in"; //付款中4
    const PAGE_TO_PAID = "paid"; //已付待还5
    const PAGE_TO_ACTREPAY_IN = "actrepay_in"; //主动还款中6
    const PAGE_TO_ACTREPAY_FAIL = "actrepay_fail"; //主动还款失败7
    const PAGE_TO_DEDUCT_SUCC = "deduct_succ"; //扣款成功8
    const PAGE_TO_DEDUCT_FAIL = "deduct_fail"; //扣款失败9
    const PAGE_TO_CLOSED = "closed"; //强制关闭10
    const PAGE_TO_REPAY_IN = "repay_in"; //扣款处理中11
//    const PAGE_TO_PAY_IN = "pay_in"; //付款中12（和4相同）
    const PAGE_TO_REPAY_FAIL= "pay_fail"; //付款失败13
    const PAGE_TO_PAY_SUCC= "pay_succ"; //付款成功（和5一样）14
    const PAGE_TO_PREAUTH_IN= "preauth_in"; //预授权处理中23
    const PAGE_TO_PREAUTH_SUCC= "preauth_succ"; //预授权还款成功21
    const PAGE_TO_PREAUTH_FAIL = "preauth_fail"; //预授权还款失败22
    const PAGE_TO_OVERDUE_DEDUCT_SUCC = "overdue_deduct_succ"; //逾期主动还款后扣款成功58


    const PAGE_TO_OVERDUE_IN = "overdue_in"; //逾期中50
    //新增逾期还款中状态
    const PAGE_TO_OVERDUE_ACTREPAY_IN = "overdue_actrepay_in"; //逾期主动还款中56
    const PAGE_TO_OVERDUE_ACTREPAY_FAIL = "overdue_actrepay_fail"; //逾期主动还款失败57
    const PAGE_TO_OVERDUE_DEDUCT_SUCCESS = "overdue_deduct_success"; //逾期扣款成功 to:51/61
    const PAGE_TO_OVERDUE_DEDUCT_RUNNING = "overdue_deduct_running"; //逾期扣款处理中 511

    const PAGE_TO_OVERDUE_SUCC = "overdue_succ"; //逾期催缴成功51
    const PAGE_TO_OVERDUE_FAIL = "overdue_fail"; //逾期催缴失败52
    const PAGE_TO_REPAY_SUCC= "repay_succ"; //订单还款成功 61

    //京东淘宝（授权显示状态）
    const CREDIT_NOT_OPEN = 0; //未开通
    const CREDIT_NOT_SUBMIT = 1; //未提交
    const CREDIT_NOT_SUBMITED = 2; //已提交


    //降担保授信
    const CREDIT_AUTH_STATUS_READY = 1;     //降担保授信:准备就绪
    const CREDIT_AUTH_STATUS_ONSUBMIT = 2;  //降担保授信:开始提交
    const CREDIT_AUTH_STATUS_SUBMITED = 3;  //降担保授信:已提交
    const CREDIT_AUTH_STATUS_CHECKING = 4;  //降担保授信:审查中
    const CREDIT_AUTH_STATUS_VERIFIED = 5;  //降担保授信:验证通过
    const CREDIT_AUTH_STATUS_FAILED = 6;    //降担保授信:失败
    const CREDIT_AUTH_STATUS_BACK = 7;      //降担保授信:退回补充

    //基础授信
    const CREDIT_AUTH_BASE_READY = 11;     //基础授信:准备就绪
    const CREDIT_AUTH_BASE_ONSUBMIT = 12;  //基础授信:开始提交
    const CREDIT_AUTH_BASE_SUBMITED = 13;  //基础授信:已提交
    const CREDIT_AUTH_BASE_CHECKING = 14;  //基础授信:审查中
    const CREDIT_AUTH_BASE_VERIFIED = 15;  //基础授信:验证通过
    const CREDIT_AUTH_BASE_FAILED = 16;    //基础授信:失败
    const CREDIT_AUTH_BASE_BACK = 17;      //基础授信:退回补充

    //完成基础授信的用户
    const BASIC_CREDIT_FINISH = [
        self::CREDIT_AUTH_STATUS_READY,
        self::CREDIT_AUTH_STATUS_ONSUBMIT,
        self::CREDIT_AUTH_STATUS_SUBMITED,
        self::CREDIT_AUTH_STATUS_CHECKING,
        self::CREDIT_AUTH_STATUS_VERIFIED,
        self::CREDIT_AUTH_STATUS_FAILED,
        self::CREDIT_AUTH_STATUS_BACK,
        self::CREDIT_AUTH_BASE_VERIFIED
    ];


    //不能借款的人
    const NOT_ALLOW_BORROW = [
        self::PAGE_TO_INIT,
        self::PAGE_TO_READY,
        self::PAGE_TO_PASS,
        self::PAGE_TO_PAY_IN,
        self::PAGE_TO_PAID,
        self::PAGE_TO_ACTREPAY_IN,
        self::PAGE_TO_ACTREPAY_FAIL,
        self::PAGE_TO_DEDUCT_SUCC,
        self::PAGE_TO_DEDUCT_FAIL,
        self::PAGE_TO_REPAY_IN,
        self::PAGE_TO_REPAY_FAIL,
        self::PAGE_TO_PAY_SUCC,
        self::PAGE_TO_PREAUTH_SUCC,
        self::PAGE_TO_PREAUTH_FAIL,
        self::PAGE_TO_PREAUTH_IN,
        self::PAGE_TO_OVERDUE_IN,
        self::PAGE_TO_OVERDUE_SUCC,
        self::PAGE_TO_OVERDUE_ACTREPAY_IN,
        self::PAGE_TO_OVERDUE_ACTREPAY_FAIL,
        self::PAGE_TO_OVERDUE_DEDUCT_SUCC,
        self::PAGE_TO_OVERDUE_DEDUCT_RUNNING
    ];
    //首页卡显示(审核中)
    const HOMEPAGE_CARD_INFO_EXAMINE = [
        self::PAGE_TO_READY,
        self::PAGE_TO_PASS,
        self::PAGE_TO_PAY_IN,
        self::PAGE_TO_REPAY_FAIL,
    ];
    //首页卡显示(还款处理中)
    const HOMEPAGE_CARD_INFO_REPAYMENTING = [
        self::PAGE_TO_ACTREPAY_IN,
        self::PAGE_TO_ACTREPAY_FAIL,
        self::PAGE_TO_DEDUCT_SUCC,
        self::PAGE_TO_DEDUCT_FAIL,
        self::PAGE_TO_REPAY_IN,
        self::PAGE_TO_PREAUTH_IN,
        self::PAGE_TO_PREAUTH_SUCC,
        self::PAGE_TO_PREAUTH_FAIL,
        self::PAGE_TO_PREAUTH_IN,
        self::PAGE_TO_OVERDUE_ACTREPAY_IN,
        self::PAGE_TO_OVERDUE_ACTREPAY_FAIL,
        self::PAGE_TO_OVERDUE_DEDUCT_SUCC,
        self::PAGE_TO_OVERDUE_DEDUCT_RUNNING
    ];
    //首页卡显示(还款处理中,小提示)
    const HOMEPAGE_CARD_INFO_REPAYMENTING_SIGN = [
        self::PAGE_TO_OVERDUE_ACTREPAY_IN,
        self::PAGE_TO_OVERDUE_ACTREPAY_FAIL,
        self::PAGE_TO_OVERDUE_DEDUCT_SUCC,
        self::PAGE_TO_OVERDUE_DEDUCT_RUNNING
    ];





    //逾期
    const HOMEPAGE_CARD_INFO_OVERDUE = [
        self::PAGE_TO_OVERDUE_IN,
        self::PAGE_TO_OVERDUE_FAIL

    ];
    //已还款
    const HOMEPAGE_CARD_INFO_REPAYMENT = [
        self::PAGE_TO_OVERDUE_SUCC,
        self::PAGE_TO_REPAY_SUCC

    ];




    //完成基础授信的用户
//    const REPAYMENT_STATUS_ADOPT = [
//        self::PAGE_TO_PAID,
//        self::PAGE_TO_OVERDUE_IN,
//        self::PAGE_TO_PAY_SUCC,
//    ];
    //首页卡上面按钮(不显示)
//    const HOMEPAGE_CARD_BUTTON_REPAYMENT = [
//        self::PAGE_TO_PAID,
//        self::PAGE_TO_OVERDUE_IN,
//        self::PAGE_TO_PAY_SUCC,
//    ];
    //首页卡金钱显示内容
//    const HOMEPAGE_CARD_CONTENT_ONE = [
//        self::PAGE_TO_CLOSED,                       //强制关闭
//        self::PAGE_TO_PAID,                         //已付代还
//        self::PAGE_TO_ACTREPAY_IN,                  //主动还款中
//        self::PAGE_TO_OVERDUE_IN,                   //订单逾期
//        self::PAGE_TO_REPAY_IN,                     //扣款处理中
//        self::PAGE_TO_INIT,                         //预授权确定中
//        self::PAGE_TO_GOON,                         //继续借款
//        self::PAGE_TO_REPAY_SUCC,                   //还款成功
//        self::PAGE_TO_PAY_IN,                       //审核中
//        self::PAGE_TO_PASS,                         //审核通过
//        self::PAGE_TO_PAY_SUCC,                     //付款成功
//        self::PAGE_TO_READY,                        //待审状态
//        self::PAGE_TO_REJECT,                       //拒绝
//        self::PAGE_TO_ACTREPAY_FAIL,                //主动还款失败
//        self::PAGE_TO_DEDUCT_SUCC,                  //扣款成功
//        self::PAGE_TO_DEDUCT_FAIL,                  //扣款失败
//        self::PAGE_TO_OVERDUE_SUCC,                 //逾期催缴成功
//        self::PAGE_TO_OVERDUE_FAIL,                 //逾期催缴失败
//        self::PAGE_TO_OVERDUE_ACTREPAY_IN,          //逾期主动还款中
//        self::PAGE_TO_OVERDUE_ACTREPAY_FAIL,        //逾期主动还款失败
//        self::PAGE_TO_OVERDUE_DEDUCT_RUNNING,       //逾期扣款处理中
//        self::PAGE_TO_PREAUTH_SUCC,                 //预授权还款成功
//        self::PAGE_TO_PREAUTH_FAIL,                 //预授权还款失败
//        self::PAGE_TO_PREAUTH_IN,                   //预授权处理
//        self::PAGE_TO_OVERDUE_DEDUCT_SUCC,          //逾期主动还款成功
//        self::PAGE_TO_REPAY_FAIL                    //付款失败
//    ];

    //首页卡金钱显示内容
//    const HOMEPAGE_CARD_CONTENT_SED = [
//        self::PAGE_TO_LOGIN,                       //未登录
//        self::NEW_USER_NO_BORROW,                  //新注册用户
//        self::PAGE_TO_LEND_MONEY,                  //还没有借款记录
//        self::PAGE_TO_FORBID,                      //还没有借款记录
//        self::PAGE_TO_CREDIT_BASE_FALSE,           //还没有借款记录
//    ];


    protected $_table = null;
    protected $_session = null;
    protected $_prefix;

    public function __construct(){
        $this->_session = Model::factory('Session');
        //获取表前缀 在用query查询数据库时得自己带表前缀 防止修改表前缀 语句失效
        $this->_prefix = Kohana::$config->load('database.default.table_prefix');
    }
    //获取首页头部幻灯数据
    public function get_marquee(){
        return DB::select('line')->from('wx_marquee')->limit(3)->execute()->as_array();
    }
    //添加用户的可用余额
    public function insert_finance_profile(){
        list($insert_id, $total_rows) = DB::insert('finance_profile', array('user_id', 'credit_amount'))->values(array( $this->_session->sessionGet('uid'), '500'))->execute();
        if($insert_id){
            return $insert_id;
        }
        return false;
    }
    //修改当前用户的可用余额
    public function set_finance_profile($money){
        DB::update('finance_profile')->set(array('loan_amount' => $money))->where('user_id', '=', $this->_session->sessionGet('uid'))->execute();
    }
    //查找卡信息
    public function dbfind($num , $type ,$table,$field='id'){
        $dbfind = DB::select($field)->from($table)->where($type,'=',$num)->execute()->current();
        return $dbfind;
    }
    //查找卡信息
    public function dbselect($table,$field='id',$array=array()){
        $query = DB::select($field)->from($table);
        if($array){
            foreach($array as $key=>$val){
                $query->where($key,'=',$val);
            }
        }

        $query->execute()->i;

        $dbfind = $query->execute()->current();
        return $dbfind;
    }

    //获得token值
    public function get_token(){
        return DB::select('token,ticket,expires_in')->from("wxconst")->execute()->current();
    }
    //获得token值
    public function update_token($array){
        return DB::update('wxconst')->set($array)->where('status','=','1')->execute();
    }
    //收集报错信息
    public function insert_log($array){
        DB::insert('interface_log', array_keys($array))->values(array_values($array))->execute();
    }
    //保存接口调取数据


}