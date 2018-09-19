<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <title>兑换优惠券</title>
    <style type="text/css">
        *{margin: 0;padding: 0}
        .newcoupon{
            text-align: center;
            background: url(/static/images/v2/activity/sign/6.png) no-repeat;
            background-size: cover;
        }
        .oldcoupon{
            text-align: center;
            background: url(/static/images/v2/activity/sign/5.png) no-repeat;
            background-size: cover;
        }
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
    </style>
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/ui_bootstrap/bomb/bomb_screen.js'); ?>
</head>
<body style="background: #fc3e42;">
<div style="width: 100%;height: 1.2rem "></div>
<section style="width: 100%;background: white;height: 1.2rem;position: fixed;top: 0;left: 0">
    <span onclick="location.href ='/Sign/SignPage';" style="font-size: .4rem;color: #ff8470;display: block;line-height: 1.3rem;"><i  style="float: left;display: block;width: .5rem;height: .5rem;background: url(/static/images/back.png) no-repeat;background-size: contain;margin: .3rem 0 0 .3rem;"></i><span style="position: relative;top: -.08rem;">返回打卡页面</span></span>
</section>
<div style="clear:both"></div>
<section  class="circular" style="margin: .5rem 0.3rem 1rem 0.3rem;background: url(/static/images/v2/activity/sign/4.png) no-repeat;height: 8.3rem;background-size: cover;">
    <ul style="width: 100%;margin-top: 2rem;padding-top: 4rem;">
        <?php echo $strli ?>
    </ul>
</section>
<footer><img src="/static/images/v2/activity/sign/3.png" width="100%" /></footer>

<?php echo HTML::script('static/js/v2/standard_local.js');?>
<?php echo HTML::script('static/js/lockPhoneBackBtn.js');?>
<?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>

<script>
//    var total_day =20;
    var total_day = <?php echo isset($total_day)?$total_day:0?>;
</script>
<?php echo HTML::script('static/js/v2/local/punchClock.js?1111'); ?>
<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?1dceaa9922352fd2c81930784948dc71";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>
</body>
</html>