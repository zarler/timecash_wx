<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>免单免息提额，大额优惠券通通都在红包雨</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <!-- <link href="images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" /> -->
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-017/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-017/css/redrain.css">
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-017/css/rain.css">
    <script type="text/javascript" src="/static/Activity/TC0A-017/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/static/Activity/TC0A-017/js/jquery.jCarouselLite.js"></script>
    <script type="text/javascript" src="/static/js/v2/compatibleEqui.js"></script>
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>

    <script>
        $(function(){
            $(document).on('touchstart', '.dd', function(){

            });
        })

    </script>
</head>
<body>
<div class="page_rain">
    <div class="div bg_2"></div>
</div>
<!-- 弹窗开始 -->
<?php echo $_VArray['have'] ?>
</body>
<?php if(isset($_VArray['zanReq'])&&Valid::not_empty(isset($_VArray['zanReq']))){?>
    <script type="text/javascript" src="/static/js/v2/common_layer_mobile.js"></script>
    <script>


        function Zan() {
            $.ajax({
                url:'<?php echo $_VArray['zanReq']  ?>',
                type:'POST',
                data:{userId:<?php echo $_VArray['userId']; ?>},
                dataType:'json',
                async: true,  //同步发送请求t-mask
                beforeSend:function(){
                },
                success:function(result){
                    if(result.status == true){
                        $('.redrain-pop-zan a').hide();
                        $('.redrain-pop-up').addClass('redrain-pop-done');
                        $('.redrain-pop-done').removeClass('redrain-pop-up');
                        $('.redrain-pop-zan').addClass('redrain-pop');
                        $('.redrain-pop').removeClass('redrain-pop-zan');
                    }else{
                        layerMobile.submitOk(result.msg);
                        layerMobile.changeCssPromptMsgAtc();
                        return  false;
                    }
                },
                error:function(){
                    commonUtil.submitOk("表单发送失败！");
                    layerMobile.changeCssPromptMsgAtc();
                    return false;
                }
            });
        }
    </script>
<?php } ?>
</html>