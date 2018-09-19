<?php defined('SYSPATH') OR die('No direct script access.');

return array(
    'baidu'=>array(
        'ak'=>'uIDrX26cP4rQ0UAglVhlkQm9oiaSI6DC'
    ),
    //正式
//    'wx'=>array(
//        'appId' => 'wx68305f3a1176fc79',
//        'appSecret' => '75126430b23d938a7adc2b856ad84e17',
//        'callbackurl' => 'https://m.timecash.cn', //微信授权回调地址
//        'apiUrl'	=>  'https://api.weixin.qq.com',		//微信API站点
//        'state' => 'kuaijin', //重定向后会带上state参数
//        'HTTPAPPID' =>  'Wechat',
//        'HTTPSECRET' => 'WeICVhDMrWtASLzVVFsuZyBnOihXFmBM',
//    ),
//    //测试
    'wx'=>array(
        'appId' => 'wxb6606932ddd5f1fa',
        'appSecret' => '12b55a75c9af1d9a0855d11c49473c36',
        'callbackurl' => 'https://test33.m.timecash.cn', //微信授权回调地址
        'apiUrl'	=>  'https://api.weixin.qq.com',		//API站点
        'state' => 'kuaijin', //重定向后会带上state参数
        'HTTPAPPID' =>  'Wechat',
        'HTTPSECRET' => 'WeICVhDMrWtASLzVVFsuZyBnOihXFmBM'
    ),
    //  测试 哈哈
//    'wx'=>array(
//        'appId' => 'wx736563df36fc4a7a',
//        'appSecret' => '95ee7bbbb1df41fc707a9b1772b2096e',
//        'callbackurl' => 'https://test33.m.timecash.cn', //微信授权回调地址
//        'apiUrl'	=>  'https://api.weixin.qq.com',		//API站点
//        'state' => 'kuaijin', //重定向后会带上state参数
//        'HTTPAPPID' =>  'Wechat',
//        'HTTPSECRET' => 'WeICVhDMrWtASLzVVFsuZyBnOihXFmBM'
//    ),
    'push'=>array(
            //关键字提示
            'message'=>array(
                '1'=>"（1）需要是自身常用的手机，并且把关于快金的权限打开（安卓手机版本需要是4.4.4以上；苹果需要是苹果5以上，版本是9.3.2以上）系统会自动对手机通讯录的数据反馈有评定，不符合的话，就无法通过，不能申请借款的。\r\n（2）请您联系人工客服，客服工作时间：9:00到18:00",
                '2'=>"（1)需要把关于快金的权限打开（安卓手机版本需要是4.4.4以上；苹果需要是苹果5以上，版本是9.3.2以上）\r\n（2)您把APP关了，稍后再进行尝试一下\r\n（3）请您联系人工客服，客服工作时间：9:00到18:00",
                '3'=>"（1）支持的储蓄卡类型：工商银行、建设银行、中信银行、民生银行、兴业银行、浦发银行、农业银行、光大银行、平安银行、广发银行；支持的信用卡类型：建设银行、中信银行、民生银行、浦发银行、广发银行、华夏银行，光大银行\r\n（2）银行预留手机号跟注册手机号不一致；\r\n（3）银行卡未开通网银或者快捷支付功能；\r\n（4）农业银行和建设银行需要开通银联无卡支付功能。\r\n（5）请您联系人工客服，客服工作时间：9:00到18:00",
                '4'=>"审核人员上班之后会尽快进行审核，您注意接听一下电话。",
                '5'=>"正常情况下是审核通过当天两个小时之内放款，如果出现其他问题有可能会延后，一般不会超过3天的。建议您使用如工商，建行，农业银行这些大银行收款，以免给您带来不必要的麻烦。",
                '6'=>"您好，我们目前有两种借款方式 （1）担保借款：需要有信用卡，通过冻结信用卡相应额度作为担保，来保证出借人的资金安全，担保比例是50%和100%两档（2）极速贷： 不需要用信用卡预授权担保的，需要完成基础授信，提交两位紧急联系人的联系方式。极速贷每天早上10:00开放抢单，抢完为止。",
                '7'=>"没有成功确认预授权或者信息未填写完整就退出了，您等1个小时之后重新操作申请就可以了。",
                '8'=>"（1）到期日晚上22点自动从绑定储蓄卡中足额扣款，所以您须在还款日晚上22点前将借款金额足额存入绑定储蓄卡中。\r\n （2）如有其他问题，请您联系人工客服，客服工作时间：9:00到18:00",
                '9'=>"快金的注册手机号，不支持进行修改",
                '10'=>"验卡一共有5次机会，如果您已经尝试过5次了，就没有办法再操作验卡并申请借款了；对于给您造成的不便，向您表示歉意。",
                '11'=>"（1）担保借款期限一般是7-21天，借款金额是500到3000元；每按时还款一笔之后，可以提升500元额度，最高6000元。\r\n （2）极速贷只有500和1000两档，天数是7天和14天可选。",
                'reply'=>"尊敬的快金用户您好！请<a href='https://www.sobot.com/chat/h5/index.html?sysNum=545a1dc0a4a646889ede877d16451268&source=1'>点击此处咨询客服</a>",
                'subscribe'=>"欢迎关注快金~\r\n\r\n未注册用户请【下载app】完成基础授信老用户可直接点击【我要借款】\r\n\r\n担保借款担保比例最低将至0%\r\n极速贷最快3分钟审核、1分钟放款\r\n分分钟满足你的各种借款需求\r\n\r\n快开启你的快金之旅吧！"
            ),
        ),
    //哈哈测试
//    'wx'=>array(
//        'appId' => 'wx736563df36fc4a7a',
//        'appSecret' => '95ee7bbbb1df41fc707a9b1772b2096e',
//        'callbackurl' => 'http://test21.m.timecash.cn', //微信授权回调地址
//        'state' => 'kuaijin', //重定向后会带上state参数
//        'HTTPAPPID' =>  'Wechat',
//        'HTTPSECRET' => 'WeICVhDMrWtASLzVVFsuZyBnOihXFmBM',
//    ),
    'config'=>array(
        'max_amount'=>'3000.00',
        'ensure_rate'=>'1.0',
        'view_version'=>'v2'  //空为默认null
    )
);
