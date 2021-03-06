<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo isset($title)?$title:'快金';?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/js/v2/standard_local.js');?>
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
    <link rel="stylesheet" type="text/css" href="/static/css/v2/local/m-rem-cash.css" />
    <style type="text/css">
        .p1{
            text-align: center;
            font-size: .4em;
            color: #ff8470;
            font-weight: lighter;
            margin-top: 1.4rem;
        }
        .p2{
            font-size: .35rem;
            margin: .3rem;
            line-height: .6rem;
            font-weight: lighter;
        }
        a.t-orange-btn{
            height: .9rem;
            box-sizing: border-box;
            font-size: .4rem;
            text-align: center;
            line-height: .8rem;
            display: block;
            color: #fff;
            border: 1px solid #ff8470 !important;
            width: 70% !important;
            border-radius: 1.3rem;
            margin: 0 auto;
            background: #ff8470 !important;
        }

    </style>
</head>
<body style="background: #F3F3F3">
<div class="loading_ok_show" style="display: none">
    <section class="t-login-nav">
        <div class='t-login-nav-1'>
            运营商授权页面
<!--            <a href="--><?php //echo $url; ?><!--" class="return_i i_public"></a>运营商授权页面-->
        </div>
    </section>
    <div class="top_height"></div>
    <section class="m-webbox">
        <p class="p1">签约绑卡成功</p>
        <p class="p2">您的收款卡也将作为您的还款卡,请在借款到期前保证卡内有足够的余额,到期时会自动划扣卡内余额还款。</p>
        <a href="<?php echo $url; ?>" class="t-orange-btn" style="margin-top: 1.5rem">确定</a>
    </section>
</div>
</body>
<script>
    var layshow = layer.open({
        type: 2
        ,content: '加载中'
    });
    $(document).ready(function(){
        layer.close(layshow);
        $('.loading_ok_show').fadeIn('slow');

    });
</script>
</html>