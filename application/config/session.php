<?php defined('SYSPATH') OR die('No direct script access.');


return array(

    'native' => array(
        'name' => 'PHPSESSID',
        'lifetime' => 43200,
    ),

    'cookie' => array(
        'name' => 'PHPSESSID',
        'encrypted' => FALSE,
        'lifetime' => 43200,
    ),

    'database' => array(
        'name' => 'PHPSESSID',
        'encrypted' => FALSE,
        'lifetime' => 43200,
        'group' => 'default',//database.php:group=admin
        'table' => 'session',//tc_admin_session
        'columns' => array(
            'session_id'  => 'session_id',
            'last_active' => 'last_active',
            'contents'    => 'contents'
        ),
        'gc' => 500,
    ),
    'session_app' => array(
        'name' => 'PHPSESSID',
        'encrypted' => FALSE,
        'group' => 'default',//database.php:group=admin
        'table' => 'session_app',//tc_admin_session
        'columns' => array(
            'session_id'  => 'session_id',
            'user_id' => 'user_id',
            'token'    => 'token',
            'expire_in'   => 'expire_in',
            'name'=>'name',
            'mobile'=>'mobile',
            'identity_code'=>'identity_code',
            'credit_auth'=>'credit_auth'
        ),
        'gc' => 500,
    ),

);
