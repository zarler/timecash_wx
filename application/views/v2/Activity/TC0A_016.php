<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>领券下单享立减，快金就是要你省</title>
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <!-- <link href="images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" /> -->
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-016/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-016/css/coupon.css">
    <style>
        .t-login-nav {
            background: white;
            display: block;
            text-align: center;
            width: 100%;
            height: 2.25rem;
            line-height: 2.2rem;
            border-bottom: 1px solid #f7f2f2;
            position: fixed;
            z-index: 99;
        }
        .t-login-nav-1 {
            text-align: center;
            color: #363636;
            font-size: 14px;
        }
        .t-login-nav-1 a {
            color: #363636;
        }
        .return_i {
            background: url(/static/images/v2/icon-Return.png) no-repeat;
            width: 1.2rem;
            height: 1.2rem;
            background-size: contain;
            display: inline-block;
            vertical-align: middle;
            margin-top: .5rem;
            left: .75rem;
            position: absolute;
        }
        .top_height{
            height: 2.25rem;
        }
    </style>

    <script type="text/javascript">
        //ready 函数
        var readyRE = /complete|loaded|interactive/;
        var ready = window.ready = function (callback) {
            if (readyRE.test(document.readyState) && document.body) callback()
            else document.addEventListener('DOMContentLoaded', function () {
                callback()
            }, false)
        }
        //rem方法
        function ready_rem() {
            var view_width = document.getElementsByTagName('html')[0].getBoundingClientRect().width;
            var _html = document.getElementsByTagName('html')[0];
            if (view_width > 750) {
                _html.style.fontSize = 750 / 16 + 'px'
            } else {
                _html.style.fontSize = view_width / 16 + 'px';
            }
        }
        ready(function () {
            ready_rem();
        });
    </script>
</head>
<body>
<?php if(isset($_VArray['showtitle'])&&$_VArray['showtitle']){?>
    <section class="t-login-nav">
        <div class='t-login-nav-1'>
            <a href="<?php if(isset($_VArray['urlHome'])){echo $_VArray['urlHome'];}else{ echo '/?#jump=no';} ?>" class="return_i i_public"></a>领券下单享立减，快金就是要你省
        </div>
    </section>
    <div class="top_height"></div>
<?php }else{?>

<?php }?>



<article>
    <div class="coupon-banner">
        <p class="coupon-summary">每天10点、14点、17点准时发券记得来抢哦！</p>
    </div>
    <!-- 优惠券 -->
    <!-- 重要：每个优惠券的进度条有单独的ID对应下面的js；targetPersent为领取进度，与上面的数字对应 -->
    <!-- 可领状态 -->
    <?php
    if(isset($_VArray['couponList'])&&Valid::not_empty($_VArray['couponList'])){
        foreach ($_VArray['couponList'] as $key =>$val){
            $key++;
            if($val['proportion']==0){
                $strdiv = "<div class='coupon-progress coupon-none'><p>已抢<br><span>{$val['proportion']}</span>%</p></div>{$val['button'.$key]}";
            }elseif($val['proportion']>=100){
                $strdiv = "<div class='coupon-soldout'></div>";
            }else{
                $strdiv = "<div class='coupon-progress '><p>已抢<br><span>{$val['proportion']}</span>%</p><canvas id='myCanvas{$key}'></canvas></div>{$val['button'.$key]}";
            }
            echo "<div class='coupon-block'><div class='coupon-num'>¥<big>{$val['amount']}</big>元优惠券</div><div class='coupon-status'>{$strdiv}</div></div>";
        }
    }
    ?>
    <!-- End 优惠券 -->
    <div class="coupon-rule">
        <div class="coupon-title">
            <span>活动规则</span>
        </div>
        <div class="coupon-rule-main">
            <p>1.用户在登录状态下进入发券活动页，可直接领取优惠券;</p>
            <p>2.在活动页每天10点、14点、17点3个时间段发放优惠券;</p>
            <p>3.每个时间段发放3种不同金额的优惠券，先到先得，抢完为止;</p>
            <p>4.所有券的有效使用时间都是到账后的7个自然日;</p>
            <p>5.用户领券后在优惠券规定使用时间内借款时，直接使用进行减免;</p>
            <p>6.成功领取后，优惠券可在“我的钱包”- “优惠券”中查看;</p>
            <p>7.3种不同面额的优惠券每个用户每天只能各领取一次。</p>
        </div>
    </div>

    <div class="coupon-used">
        <div class="coupon-title">
            <span>优惠券使用规则</span>
        </div>
        <div class="coupon-used-main">
            <p>1.此活动所得优惠券不与快金其他优惠活动同时使用;</p>
            <p>2.优惠券只在快金借款时可用，不可提现以及作为其他用途;</p>
            <p>3.本活动最终解释权由快金所有。</p>
        </div>
    </div>
</article>
<div class="pop-wrap js-mask" style="display: none">
    <div class="coupon-pop-mask"></div>
    <div class="coupon-pop">
        <div class="coupon-pop-close" data-toggle="mask" data-target="js-mask"></div>
        <a href="<?php echo $_VArray['shareButton'] ?>" class="coupon-pop-btn">马上分享</a>
    </div>
</div>
<script type="text/javascript" src="/static/Activity/TC0A-016/js/createProgress.js"></script>
<script type="text/javascript" src="/static/js/jquery-1.9.1.min.js"></script>
<?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
<script type="text/javascript" src="/static/js/v2/common_layer_mobile.js"></script>

<?php if(isset($_VArray['app'])&&$_VArray['app']){ ?>
    <script>
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        function shareWx(){
            if(isAndroid){
                window.android.sharingFriends('<?php echo $_VArray['sharetitle']; ?>', '<?php echo $_VArray['text']; ?>', '<?php echo $_VArray['img_url']; ?>', '<?php echo $_VArray['url']; ?>');
            }
            if(isiOS){
                sharingFriends('<?php echo $_VArray['sharetitle']; ?>', '<?php echo $_VArray['text']; ?>', '<?php echo $_VArray['img_url']; ?>', '<?php echo $_VArray['url']; ?>');
            }
        }
    </script>

<?php } ?>

<?php if(isset($_VArray['wx'])&&$_VArray['wx']){ ?>
    <script type="text/javascript" src="/static/ui_bootstrap/bomb/bomb_screen.js"></script>
    <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js?111123"></script>
    <script>
        bomob_screen.firstready();
        $('#bomb_screen').on('click',function () {
            bomob_screen.bomobremove();
        });
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
    </script>

<?php } ?>

<script type="text/javascript">
    $(function(){
        $(".coupon-pop-close").click(function(){
            $('.js-mask').hide();
            location.reload();
        });
        if($('#myCanvas1').length>0){
            var instance1 = new percentCircle("myCanvas1",{
                startPoint:Math.PI*0.8,
//                targetPersent:1  //进度（0-1）
                targetPersent:<?php echo isset($_VArray['couponList'][0]['percent1'])?$_VArray['couponList'][0]['percent1']:0 ?>  //进度（0-1）

            });
            instance1.execAnimation();
        };

        if($('#myCanvas2').length>0){
            var instance2 = new percentCircle("myCanvas2",{
                startPoint:Math.PI*0.8,
//                targetPersent:0.3  //进度（0-1）
                targetPersent:<?php echo isset($_VArray['couponList'][1]['percent2'])?$_VArray['couponList'][1]['percent2']:0 ?>  //进度（0-1）

            });
            instance2.execAnimation();
        };

        if($('#myCanvas3').length>0){
            var instance3 = new percentCircle("myCanvas3",{
                startPoint:Math.PI*0.8,
                targetPersent:<?php echo isset($_VArray['couponList'][2]['percent3'])?$_VArray['couponList'][2]['percent3']:0 ?>  //进度（0-1）

            });
            instance3.execAnimation();
        };
    });
    function getCoupon(ob){
        var code = $('#'+ob).data("code");
        if(layerMobile.isnull(code)!=true){
            layerMobile.showlayer('数据错误！');
            layerMobile.changeCssMsg();
            return false;
        }
        layerMobile.lockup();
        $.ajax({
            url:'<?php echo $_VArray['requestUrl']  ?>',
            type:'POST',
            data:{code:code},
            dataType:'json',
            async: true,  //同步发送请求t-mask
            beforeSend:function(){
            },
            success:function(result){
                layerMobile.unlock();
                if(result.status == true){
                    $('.js-mask').show();
                    return  false;
                }else{
                    layerMobile.submitOk(result.msg);
                    layerMobile.changeCssPromptMsgAtc();
                    return  false;
                }
            },
            error:function(){
                layerMobile.unlock();
                commonUtil.submitOk("表单发送失败！");
                layerMobile.changeCssPromptMsgAtc();
                return false;
            }
        });
    }

    function clickSubmit() {
        $.ajax({
            url: '<?php echo $_VArray['clickButtonUrl']; ?>',
            type: 'POST',
            //data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
            data:{action:'click',event_name:'TCOA_016'},
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

    //分享成功
    function shareAjax() {
        $.ajax({
            url:'<?php echo $_VArray['shareUrl']; ?>',
            type:'POST',
            data:{action:'show',event_name:'TCOA_016',time:0},
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