<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <title>快金打卡</title>
    <style type="text/css">
        *{margin: 0;padding: 0}
        ul li {
            list-style: none;
            padding: 0;
            font-size: .4rem;
            float: left;
            width: 23%;
            height: 3.5rem;
            margin: .1rem .43rem;
        }
        ul li span{
            font-size: .2rem;
        }
        ul li a{
            margin: 1.4rem .2rem 0 0.2rem;
            display: block;
            line-height: .9;
        }
        .circular p{
            font-size: .35rem;
            color: black;
            text-align: center;
            line-height: .59rem;
            letter-spacing: .03rem;
        }
        .circular strong{
            font-size: .4rem;
        }
        .circular img{
            margin: .3rem auto 0 auto;
            display: block;
        }
        footer{
            position: absolute;
            bottom: -1.9rem;
            width: 100%;
        }
        footer img{
            position: relative;
            bottom: -.28rem;
        }
    </style>
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/js/v2/standard_local.js');?>
</head>
<body style="background: #fc3e42;">
<div style="width: 100%;height: .7rem "></div>

<div style="clear:both"></div>
<section  class="circular" style="margin: .5rem 0.3rem 1rem 0.3rem;padding-top:3rem;background: url(/static/images/v2/activity/sign/2.png) no-repeat;height: 10.72rem;background-size: cover;">
    <p>快金服务号打卡体系上线啦</p>
    <p>参于打卡即可领取优惠券</p>
    <p><strong>什么时候领、领多少,你说了算</strong></p>
    <img src="/static/images/v2/activity/2weima.png" width="28%" />
    <p style="margin-top: 1.3rem">截图到微信扫描二维码</p>
    <p>或微信搜索"快金"关注服务号即可参加</p>
    <p>小金在服务号等你来拿券哦!</p>
</section>
<footer> <img src="/static/images/v2/activity/sign/1.png" width="100%" /></footer>

<?php echo HTML::script('static/js/v2/local/punchClock.js?1111'); ?>

</body>
</html>