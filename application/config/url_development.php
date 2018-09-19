<?php
defined('SYSPATH') or die('No direct script access.');
return array(
    'trusted_hosts' => array(
        'timecash\.cn',
        '.*\.timecash\.cn',
    ),
//	//和api通信的url地址
//	'communic_url'=>array(
//		//快金接口地址
//		'timecash_api'=>'http://test22.capi.timecash.cn/v2/',
//		'timecash_api_v'=>'http://test22.capi.timecash.cn/',
//		//gps坐标->百度坐标
//		'baidu_api_gps'=>'http://api.map.baidu.com/geoconv/v1/',
//		'baidu_api_bz'=>'http://api.map.baidu.com/geocoder/v2/',
//	),
	//和api通信的url地址(测试)
	'communic_url'=>array(
		'timecash_m'=>'https://test33.m.timecash.cn/',
		'timecash_m_http'=>'http://test33.m.timecash.cn/',
		//快金接口地址
		'timecash_api'=>'https://test23.capi.timecash.cn/v2/',
		'timecash_api_in'=>'https://test23.capi.timecash.cn/',
		//gps坐标->百度坐标
		'baidu_api_gps'=>'http://api.map.baidu.com/geoconv/v1/',
		'baidu_api_bz'=>'http://api.map.baidu.com/geocoder/v2/',
	),
	//和api通信的url地址(线上)
//	'communic_url'=>array(
//		'timecash_m'=>'http://m.timecash.cn/',
//		//快金接口地址
//		'timecash_api'=>'http://wx.capi.timecash.cn/v2/',
//		'timecash_api_in'=>'http://wx.capi.timecash.cn/',
//		//gps坐标->百度坐标
//		'baidu_api_gps'=>'https://api.map.baidu.com/geoconv/v1/',
//		'baidu_api_bz'=>'https://api.map.baidu.com/geocoder/v2/',
//	),
	
//	'communic_url'=>array(
//		//快金接口地址
//		'timecash_api'=>'http://test21.capi.timecash.cn/',
//		//gps坐标->百度坐标
//		'baidu_api_gps'=>'http://api.map.baidu.com/geoconv/v1/',
//		'baidu_api_bz'=>'http://api.map.baidu.com/geocoder/v2/',
//	),
	//所有页面的title文本输出
	'title'=>array(
		'login'=>'会员登陆',
		'register'=>'会员注册',
		'invitecode'=>'填写邀请码',
		'login_company'=>'公司信息',
		'login_contacts'=>'紧急联系人',
		'login_authid'=>'授权账号',
		'login_operator'=>'手机运营商',
		'back_pwd'=>'验证手机号',
		'resetpwd'=>'修改密码',
		'user'=>'会员中心',
		'borrowmoney'=>'立即借款',
		'borrow'=>'选择借款方式',
		'bankinfo'=>'添加银行卡',
		'credit'=>'添加信用卡',
		'identity'=>'添加身份证信息',
		'check'=>'核对借款信息',
		'refuse'=>'审核失败',
		'repaymoney'=>'立即还款',
		'deductmoney'=>'保证金划扣',
		'describe'=>'借款详细信息',
		'account'=>'个人中心',
		'repaystatus'=>'还款处理中',
		'protocol1'=>'用户账户注册及使用协议',
		'protocol2'=>'快金借款服务协议',
		'protocol3'=>'快金出借服务协议',
		'protocol4'=>'代扣服务协议',
		'callback'=>'申请中',
		'coupon'=>'优惠券',
		'quota'=>'授信管理',
		'borrowingrecords'=>'借款记录',
		'update_bank'=>'更换银行卡',
		'bank_card_manage'=>"银行卡管理"
	),
);