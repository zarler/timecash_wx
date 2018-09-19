<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>元旦有豪礼,500元现金红包抽不停</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <!-- <link href="images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" /> -->
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-021/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-021/css/style.css">
    <script type="text/javascript" src="/static/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/static/js/v2/compatibleEqui.js"></script>
</head>
<body>
<article>
    <img src="/static/Activity/TC0A-021/images/banner.png" class="img">

    <div class="box">
        <h2>活动规则</h2>
        <p>1.活动时间：2018.01.01-2018.01.03;</p>
        <p>2.活动期间，每天10点-22点，每隔2小时的第1个主动成功还款的用户会获得元旦幸运500元现金大红包，每日共产生6个幸运现金大红包;</p>
        <p>3.当天获奖的用户名单次日上午10点会在APP活动页面公布，用户可查看获奖记录；</p>
        <p>4.所有获奖用户都会收到快金发送的获奖短信通知，收到短信后2个自然日内在原短信直接<span class="yellow">回复“确认”两个字</span>，确保您已得知获得快金元旦500元现金大红包的事宜；</p>
        <p>5.活动结束后的5个工作日内，我们会用银行转账的方式直接把500元转入您在快金绑定的银行卡内，请注意查收；</p>
        <p>6.请获奖用户注意查收获奖短信，若未收到短信，可联系快金人工客服进行咨询010-56592060；</p>
        <p>7.如获奖用户未在规定时间内回复相关信息，将视为主动放弃此次活动获得的奖励及相关权益；</p>
        <p>8.本活动奖品只为回馈快金用户，直接转账到获奖用户绑定快金的银行卡，不接受指定银行卡或者折现及其他；</p>
        <p>9.本活动在法律允许范围内最终解释权归快金所有。</p>
    </div>
    <div class="list">
        <h2>获奖名单</h2>

        <?php if(isset($_VArray['resultAtt'])&&Valid::not_empty($_VArray['resultAtt'])){
            foreach ($_VArray['resultAtt'] as $key => $val){
                echo "<h3><span>1月{$key}日</span></h3><ul>$val</ul>";
            }
            echo "<a class='btn' href='{$_VArray['reqUrl']}'>查看全部</a>";
        }else{
            echo "<h3 style='margin-top: 2.5rem;'>暂无获奖数据</h3><div style='height: 1.5rem'></div>";
        }  ?>

    </div>
</article>
</body>



<?php if(isset($_VArray['app'])&&$_VArray['app']){ ?>
    <script>
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        function shareWx(){
            if(isAndroid){
                window.android.sharingFriends('<?php echo $_VArray['sharetitle']; ?>', '<?php echo $_VArray['text']; ?>', '<?php echo $_VArray['img_url']; ?>', '<?php echo $_VArray['url']; ?>','21');
            }
            if(isiOS){
                sharingFriends('<?php echo $_VArray['sharetitle']; ?>', '<?php echo $_VArray['text']; ?>', '<?php echo $_VArray['img_url']; ?>', '<?php echo $_VArray['url']; ?>','21');
            }
        }
    </script>

<?php } ?>
<?php if(isset($_VArray['wx'])&&$_VArray['wx']){ ?>
    <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js?111123"></script>
    <script>
        wx.config({
            debug: false,
            appId: '<?php echo isset($_VArray['signPackage']['appId'])?$_VArray['signPackage']['appId']:'' ?>',
            timestamp:'<?php echo isset($_VArray['signPackage']['appId'])?$_VArray['signPackage']['timestamp']:'' ?>',
            nonceStr:'<?php echo isset($_VArray['signPackage']['appId'])?$_VArray['signPackage']['nonceStr']:'' ?>',
            signature:'<?php echo isset($_VArray['signPackage']['appId'])?$_VArray['signPackage']['signature']:'' ?>',
            jsApiList: [
                'onMenuShareTimeline',
                'onMenuShareAppMessage'
            ]
        });
        wx.ready(function () {
            wx.onMenuShareTimeline({
                title: '<?php echo isset($_VArray['sharetitle'])?$_VArray['sharetitle']:'' ?>', // 分享标题
                link: '<?php echo isset($_VArray['url'])?$_VArray['url']:'' ?>', // 分享链接
                imgUrl: '<?php echo isset($_VArray['img_url'])?$_VArray['img_url']:'' ?>', // 分享图标
                success:function(){
                    shareAjax();
                },
                cancel:function(){
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareAppMessage({
                title: '<?php echo isset($_VArray['sharetitle'])?$_VArray['sharetitle']:'' ?>', // 分享标题
                desc: '<?php echo isset($_VArray['text'])?$_VArray['text']:'' ?>', // 分享描述
                link: '<?php echo isset($_VArray['url'])?$_VArray['url']:'' ?>', // 分享链接
                imgUrl: '<?php echo isset($_VArray['img_url'])?$_VArray['img_url']:'' ?>', // 分享图标
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
        //分享成功
        function shareAjax() {
            $.ajax({
                url:'<?php echo $_VArray['shareUrl']; ?>',
                type:'POST',
                data:{action:'show',event_name:'TCOA_021',time:0},
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

<?php } ?>

</html>