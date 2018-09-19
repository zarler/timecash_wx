<?php //include Kohana::find_file('views', 'v2/public/newHead');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo isset($title)?$title:'快金';?></title>
    <!--    <title>快金</title>-->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/ui_bootstrap/layer/layer.js'); ?>

</head>
<body>

<script>
//    seajs.config({
//        vars: {
//            'sharetitle':'<?php //echo isset($_VArray['sharetitle'])?$_VArray['sharetitle']:''; ?>//',
//            'islogin':'<?php //echo empty($_VArray['islogin'])?0:1 ?>//',
//            'text':'<?php //echo isset($_VArray['text'])?$_VArray['text']:''; ?>//',
//            'url':'<?php //echo isset($_VArray['url'])?$_VArray['url']:''; ?>//',
//            'img_url':'<?php //echo isset($_VArray['img_url'])?$_VArray['img_url']:''; ?>//',
//            'appId':'<?php //echo isset($_VArray['signPackage']['appId'])?$_VArray['signPackage']['appId']:''; ?>//',
//            'timestamp':'<?php //echo isset($_VArray['signPackage']['timestamp'])?$_VArray['signPackage']['timestamp']:''; ?>//',
//            'nonceStr':'<?php //echo isset($_VArray['signPackage']['nonceStr'])?$_VArray['signPackage']['nonceStr']:''; ?>//',
//            'signature':'<?php //echo isset($_VArray['signPackage']['signature'])?$_VArray['signPackage']['signature']:''; ?>//',
//        }
//    });
//    seajs.use('js/v2/seajs/invitationShare');
$(document).ready(function() {
    //自定义标题风格
    layer.open({
        title: [
            '提示',
            'background-color: #FF4351; color:#fff;'
        ]
        , content: '活动已下线！'
    });
});
</script>

<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <meta charset="utf-8">-->
<!--    <title>--><?php //echo isset($title)?$title:'快金';?><!--</title>-->
<!--    <!--    <title>快金</title>-->
<!--    <meta name="renderer" content="webkit">-->
<!--    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
<!--    --><?php //echo HTML::script('static/js/jquery-1.9.1.min.js');?>
<!--    --><?php //echo HTML::script('static/ui_bootstrap/layer/layer.js'); ?>
<!---->
<!--</head>-->
<!---->
<!--<body>-->
<!--<div class="top_height"></div>-->
<!--<p class="share_p">-->
<!--   --><?php //echo $_VArray['showMsg']; ?>
<!--</p>-->
<!--<section class="share_button">-->
<!--    <button><a href="--><?php //echo $_VArray['urlSubmit']; ?><!--">分享去赚钱</a></button>-->
<!--    <button><a href="/">赶快去借钱</a></button>-->
<!--</section>-->
<!--<img class="share_img" width="20%" src="--><?php //echo $_VArray['imgUrl']; ?><!--">-->
<!--<p class="share_foot_p">长按识别二维码关注快金获取更多优惠信息</p>-->
<!--</body>-->
<!--</html>-->