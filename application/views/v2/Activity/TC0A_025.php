<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>我要现金</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <!-- <link href="images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" /> -->
    <link rel="stylesheet" type="text/css" href="/static/css/public.css">
    <script type="text/javascript" src="/static/js/jquery-1.9.1.min.js"></script>
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
    <script type="text/javascript" src="/static/js/v2/common_layer_mobile.js"></script>
    <script type="text/javascript" src="/static/js/v2/compatibleEqui.js"></script>
    <style type="text/css">
        img{
            width: 100%;
        }
        a{
            width: 70%;
            height: 1.6rem;
            background: #ff4d1e;
            margin: 0 auto;
            display: block;
            border-radius: .4rem;
            position: relative;
            margin-top: -1.6rem;
            color: white;
            font-size: .6rem;
            line-height: 1.6rem;
            text-align: center;
        }
    </style>
</head>
<body class="bodybox" style="line-height: .2rem;background: #ff4d1e">
    <img src="/static/Activity/TC0A-025/images/TCOA025-1.png">
    <img src="/static/Activity/TC0A-025/images/TCOA025-2.png">
    <img src="/static/Activity/TC0A-025/images/TCOA025-3.png">
    <a href="<?php echo $_VArray['buttonStr'];?>">我要现金</a>
    <img src="/static/Activity/TC0A-025/images/TCOA025-4.png">
</body>
<script>
    function clickSubmit() {
        $.ajax({
            url: '<?php echo $_VArray['clickButtonUrl']; ?>',
            type: 'POST',
            //data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
            data:{action:'click',event_name:'TCOA_025'},
            dataType: 'json',
            async: true,  //同步发送请求t-mask
            beforeSend: function () {
            },
            success: function (result) {
            },
            error: function () {

            }
        });
    }
</script>
</html>