<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <title>邀请好友赚现金</title>
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/js/v2/standard_local.js');?>
    <style type="text/css">
        body{
            padding: 0;
            margin: 0;
            font-size: .4rem;
            color: #e6e6e9;
            font-weight: lighter;
        }
        .t-login-nav{
            background: white;
            display: block;
            text-align: center;
            width: 100%;
            height: 1.25rem;
            line-height: 1.2rem;
            border-bottom: 1px solid #f7f2f2;
            position: fixed;
            z-index: 99;
            font-size: .4rem;
        }
        .t-login-nav-1 {
            text-align: center;
            color: white;
            background: #181818;
        }
        .t-login-nav-1 a {
            color: #363636;
        }
        .return_i {
            background: url(/static/images/v2/icon-Return.png) no-repeat;
            width: .5rem;
            height: .5rem;
            background-size: contain;
            display: inline-block;
            vertical-align: middle;
            margin-top: .33rem;
            left: .15rem;
            position: absolute;
        }
        .share_p{
            text-align: center;
            color: #ff7865;
            line-height: 1.1rem;
            margin: 1rem auto;
        }
        .top_height{
            height: 1.25rem;
        }
        .share_button {
            text-align: center;
        }
        .share_button button{
            width: 35%;
            height: 1.2rem;
            background: #ff7865;
            font-size: .4rem;
            color: white;
            border-radius: .3rem;
            margin-left: 5%;
            margin-right: 5%;
            border:none;
        }
        .share_img{
            width: 40%;
            margin: 2rem auto .5rem auto;
            display: block;
        }
        .share_foot_p{
            color: black;
            text-align: center;
            font-size: .4rem;
            margin-top: .6rem;
        }
    </style>
</head>
<body>
<section class="t-login-nav">
    <div class='t-login-nav-1'>
        <a href="javascript:;" class="return_i i_public"></a>邀请好友赚现金
    </div>
</section>
<div class="top_height"></div>
<p class="share_p">
    <strong>恭喜!免息优惠券已到账!</strong></br>
    <strong>赶快去借款!</strong>
</p>
<section class="share_button">
    <button>分享去赚钱</button>
    <button>赶快去借钱</button>
</section>
<img class="share_img" width="20%" src="/static/images/v2/activity/2weima.png">
<p class="share_foot_p">长按识别二维码关注快金获取更多优惠信息</p>
</body>

<?php if($type == 1){ ?>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        var titil = "<?php echo $sharetitle; ?>";
        var text = "<?php echo $text; ?>";
        var url = "<?php echo $url; ?>";
        var img_url = "<?php echo $img_url; ?>";
        wx.config({
            debug: false,
            appId: '<?php echo $signPackage["appId"];?>',
            timestamp: <?php echo $signPackage["timestamp"];?>,
            nonceStr: '<?php echo $signPackage["nonceStr"];?>',
            signature: '<?php echo $signPackage["signature"];?>',
            jsApiList: [
                'onMenuShareTimeline',
                'onMenuShareAppMessage'
            ]});
        wx.ready(function () {
            wx.onMenuShareTimeline({
                title: titil, // 分享标题
                link: url, // 分享链接
                imgUrl: img_url, // 分享图标
                success:function(){
                    shareAjax();
                },
                cancel:function(){
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareAppMessage({
                title: titil, // 分享标题
                desc: text, // 分享描述
                link: url, // 分享链接
                imgUrl: img_url, // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success:function(){
                    shareAjax();
                },
                cancel:function(){
                    // 用户取消分享后执行的回调函数
                }
            });
        });
        function sendToAndroid(){
            $('#fullbg').show();
        };

        function shareAjax() {
            $.ajax({
                url:'/FunctionsApp/shareWx',
                type:'POST',
                data:{time:1495900800,action:'share',event_name:'TCOA_010'},
                dataType:'json',
                async: true,
                beforeSend:function(){
                },
                success:function(result){
                },
                error:function(){
                }
            });
        }

    </script>
<?php }elseif($type == 2){ ?>
    <script>
        function sendToAndroid(){
            <?php if($client=='android'){?>
            window.share.runOnAndroidJavaScript('<?php echo $sharetitle; ?>','<?php echo $text; ?>','<?php echo $img_url; ?>','<?php echo $url; ?>');
            <?php }elseif($client=='ios'){?>
            sharePhone('<?php echo $sharetitle; ?>','<?php echo $text; ?>','<?php echo $img_url; ?>','<?php echo $url; ?>');
            <?php } ?>
        }
    </script>
<?php } ?>
</html>