<!DOCTYPE html>
<html lang="zh-cn" class="no-js">
<head>
    <meta http-equiv="Content-Type">
    <meta content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <meta name="viewport">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/js/v2/common.js'); ?>
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
    <?php echo HTML::script('static/js/v2/standard_local.js');?>
    <title>授信享好礼</title>
    <style type="text/css">
        *{ padding: 0; margin: 0;}
        /*html { -webkit-text-size-adjust: none;height: 100%;}*/
        /*body{min-width:16rem; font-weight: lighter; background: #d5242a;}*/
    </style>
</head>
<body style="background: url(/static/images/v2/activity/credit_1/5.png) ;">
<img src="/static/images/v2/activity/credit_1/3.png" width="100%" />
<a href="<?php echo $url; ?>"><img src="/static/images/v2/activity/credit_1/4.png" width="50%" style="margin: 0 auto;display: block;position: relative;top: -.2rem;" /></a>
<img src="/static/images/v2/activity/credit_1/1.png"  width="80%" style="margin: .1rem auto;display: block;" />
<img src="/static/images/v2/activity/credit_1/6.png"  width="100%" style="margin: 0 auto;display: block;" />

<label>请选择一个图像文件：</label>
<input type="file" id="file_input" multiple/>

</body>
<script>
    $(document).ready(function(){
        $.ajax({
            url:'/FunctionsApp/statistics',
            type:'POST',
            data:{action:'look',event_name:'TCOA_004'},
            dataType:'json',
            async: true,
            beforeSend:function(){
            },
            success:function(result){
            },
            error:function(){
            }
        });
    });

    function clickOk(msg) {
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 3 //2秒后自动关闭
        });
    };
    function changeShowRem(){
        $('.layui-m-layercont').css({'line-height':'.3'});
        $('.layui-m-layerchild').css({'border-radius':'.1rem','bottom':'-2rem'});
    };
    function showmsgMobileRem(){
        $('.layui-m-layerchild h3').css({'height':'0.4rem','font-size':'0.16rem','border-radius':'.09rem .09rem 0 0'});
        $('.layui-m-layercont').css({'padding':'.2rem .2rem'});
        $('.layui-m-layerbtn span').css({'font-size':'.17rem'});
        $('.layui-m-layerbtn').css({'height':'.5rem','line-height':'3'});
        $('.layui-m-layerbtn, .layui-m-layerbtn span').css({'border-radius':'0 0 .09rem .09rem'});
    };

    function noLogin(url,msg) {
            layer.open({
                title: [
                    '提示',
                    'background-color:#ff8470; color:#fff;'
                ]
                ,content: msg
                ,btn: ['确认','取消']
                ,yes: function(index){
                    layer.close(index);
                    location.href = url;
                }
            });
    };

</script>
</html>



 