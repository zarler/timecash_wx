<?php
defined('SYSPATH') or die('No direct script access.');
return array(
//	'default' => array(
//		'type'			=> 'PDO',
//		'connection'	=> array(
//            'dsn'	=> 'mysql:host=114.215.199.93;dbname=timecash',
//			'database'	=> 'timecash',
//			'username'	=> 'timecash',
//			'password'	=> 'T1i2m3e4c5a,s.h',
//			'persistent'=> FALSE,
//            'options' => NULL,
//		),
//		'table_prefix'	=> 'tc_',
//		'charset'		=> 'utf8',
//		'caching'		=> FALSE,
//		'profiling'		=> TRUE
//	),
//	'default' => array(
//		'type'			=> 'PDO',
//		'connection'	=> array(
//			'dsn'	=> 'mysql:host=114.215.199.93;dbname=timecash2',
//			'database'	=> 'timecash2',
//			'username'	=> 'timecash2',
//			'password'	=> 'Timecash#169$',
//			'persistent'=> FALSE,
//			'options' => NULL,
//		),
//		'table_prefix'	=> 'tcwx_',
//		'charset'		=> 'utf8',
//		'caching'		=> FALSE,
//		'profiling'		=> TRUE
//	),

//    'default' => array(
//        'type'			=> 'PDO',
//        'connection'	=> array(
//            'dsn'	=> 'mysql:host=rm-2ze5n27f3kej99xxe.mysql.rds.aliyuncs.com;dbname=timecash_wx',
//            'database'	=> 'timecash_wx',
//            'username'	=> 'kuaijin_wx2_prod',
//            'password'	=> 'zr1eQUzbzyZ068cF',
//            'persistent'=> FALSE,
//            'options' => NULL,
//        ),
//        'table_prefix'	=> 'tcwx_',
//        'charset'		=> 'utf8',
//        'caching'		=> FALSE,
//        'profiling'		=> TRUE
//    ),



//测试
	'default' => array(
		'type'			=> 'PDO',
		'connection'	=> array(
			'dsn'	=> 'mysql:host=114.55.103.7;dbname=timecash22_wx',
			'database'	=> 'timecash22_wx',
			'username'	=> 'timecash2',
			'password'	=> 'Timecash#169$',
			'persistent'=> FALSE,
			'options' => NULL,
		),
		'table_prefix'	=> 'tcwx_',
		'charset'		=> 'utf8',
		'caching'		=> FALSE,
		'profiling'		=> TRUE
	),

	'admin' => array(
		'type'			=> 'PDO',
		'connection'	=> array(
			'dsn'	=> 'mysql:host=rm-2ze5n27f3kej99xxe.mysql.rds.aliyuncs.com;dbname=timecash',
			'username'	=> 'kuaijin_prod',
			'password'	=> 'o1tubeT0ufXH9b',
			'persistent'=> FALSE,
			'options' => NULL,
		),
		'table_prefix'	=> '',
		'charset'		=> 'utf8',
		'caching'		=> FALSE,
		'profiling'		=> TRUE
	),

	//正式
//	'default' => array(
//		'type'			=> 'PDO',
//		'connection'	=> array(
//			'dsn'	=> 'mysql:host=rm-2ze5n27f3kej99xxe.mysql.rds.aliyuncs.com;dbname=timecash_wx',
//			'database'	=> 'timecash_wx',
//			'username'	=> 'kuaijin_wx2_prod',
//			'password'	=> 'zr1eQUzbzyZ068cF',
//			'persistent'=> FALSE,
//			'options' => NULL,
//		),
//		'table_prefix'	=> 'tcwx_',
//		'charset'		=> 'utf8',
//		'caching'		=> FALSE,
//		'profiling'		=> TRUE
//	),
);