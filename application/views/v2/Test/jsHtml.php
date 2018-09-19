
<html>
<head>
    <meta charset="utf-8">
    <title>JS互交测试</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--<link rel="stylesheet" href="//res.layui.com/layui/build/css/layui.css"  media="all">-->
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/js/v2/standard_local.js');?>
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
</head>
<body>
<div style="height: 300px"></div>
<?php echo $_VArray['html']; ?>

<button style="width: 500px;height: 150px;font-size: 22px;background: gainsboro;" onclick="getContractApp();">JS互交测试(生成新的webview)</button>
<div class="ceshi" style="width: 2rem;height: 2rem;"></div>
<button style="width: 500px;height: 150px;font-size: 22px;background: gainsboro;" onclick="getContractAppTwo();">JS互交测试(跳转外部浏览器)</button>
<div class="ceshi" style="width: 2rem;height: 2rem;"></div>

<button style="width: 500px;height: 150px;font-size: 22px;background: gainsboro;" onclick="getContractAppTHR();">复制微信号</button>
<div class="ceshi" style="width: 2rem;height: 2rem;"></div>
<button style="width: 500px;height: 150px;font-size: 22px;background: gainsboro;" onclick="getContractAppFOR();">保存二维码</button>


<div class="ceshi" style="width: 2rem;height: 2rem;"></div>
<button style="width: 500px;height: 150px;font-size: 22px;background: gainsboro;" onclick="sharePage();">分享</button>


</body>

<script>
    //获取合同
    function getContractApp(){
        <?php if($_VArray['client']=='android'){?>
            window.android.JsAppInteraction('web_within','http://test33.m.timecash.cn/app/Activity/TestJs?target_token={target_token}&d={device_id}#');
        <?php }elseif($_VArray['client']=='ios'){?>
            JsAppInteraction('web_within','http://test33.m.timecash.cn/app/Activity/TestJs?target_token={target_token}&d={device_id}#');
        <?php } ?>
    }
    function getContractAppTwo(){
        <?php if($_VArray['client']=='android'){?>
                window.android.JsAppInteraction('web_abroad','http://www.baidu.com');
//            window.share.JsAppInteraction('web_within','http://test33.m.timecash.cn/app/Activity/TestJs?target_token={target_token}&d={device_id}#')
        <?php }elseif($_VArray['client']=='ios'){?>
                JsAppInteraction('web_abroad','http://www.baidu.com');
        <?php } ?>
    }
    function getContractAppTHR(){
        <?php if($_VArray['client']=='android'){?>
            window.android.JsAppInteraction('copyWxNum','快金');
//            window.share.JsAppInteraction('web_within','http://test33.m.timecash.cn/app/Activity/TestJs?target_token={target_token}&d={device_id}#')
        <?php }elseif($_VArray['client']=='ios'){?>
            JsAppInteraction('copyWxNum','快金');
        <?php } ?>
    }

    function getContractAppFOR(){
        <?php if($_VArray['client']=='android'){?>
        window.android.JsAppInteraction('savePicture','http://test33.m.timecash.cn/static/images/v2/activity/2weima.png');
//            window.share.JsAppInteraction('web_within','http://test33.m.timecash.cn/app/Activity/TestJs?target_token={target_token}&d={device_id}#')
        <?php }elseif($_VArray['client']=='ios'){?>
        JsAppInteraction('savePicture','http://test33.m.timecash.cn/static/images/v2/activity/2weima.png');
        <?php } ?>
    }

    function sharePage() {
        <?php if($_VArray['client']=='android'){?>
            window.android.sharingFriends('免单优惠来袭,我比你手快,猛戳!', '端午节整点抢免单,早10点到晚9点惊喜抢不停！', 'static/images/promotion/icon_logo.png', 'http://www.baidu.com');
        <?php }elseif($_VArray['client']=='ios'){?>
            sharingFriends('免单优惠来袭,我比你手快,猛戳!', '端午节整点抢免单,早10点到晚9点惊喜抢不停！', 'static/images/promotion/icon_logo.png', 'http://www.baidu.com');
        <?php } ?>
    }



    function errorContractApp(msg){
        $(".t-error").text(msg);
    }

</script>

</html>
