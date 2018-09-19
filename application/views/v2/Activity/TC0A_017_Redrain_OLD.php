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
    <script>
        $(function(){

            if (sessionStorage.getItem("times")) {
                // 恢复文本输入框的内容
                times = sessionStorage.getItem("times");
            }else{
                times = <?php echo isset($_VArray['times'])?$_VArray['times']:0 ?>;
            }
            sessionStorage.setItem("times", times);
            console.log(times);

            function game(){
                if(times<=0){
                    //显示次数超限
                    $('#pop-notimes').show();
                    $('.page-time').hide();
                    return false
                }

                $(".page-time span").text(8);
                $(".div").removeClass("bg_2");
                $(".page-time").show();
                Timerr = window.setInterval(aa,100); //数量速度
                var removepackage = setInterval(function(){
                    for(var jj=0;jj<$('.div>div').size()/4;jj++){
                        $('.div>div').eq($('.div>div').size()-jj).remove();
                    }
                },1000)
                function aa(){
                    for(var i=0;i<4;i++){
                        var m=parseInt(Math.random()*700+100);
                        var j2=parseInt(Math.random()*300+1200);
                        var j=parseInt(Math.random()*1600+000); //红包起始右侧位置
                        var j1=parseInt(Math.random()*100+300); //
                        var n=parseInt(Math.random()*10+(-100)); //红包起始顶部位置
                        $('.div').prepend('<div class="dd"></div>');
                        $('.div').children('div').eq(0).css({'right':j,'top':n});
                        $('.div').children('div').eq(0).animate({'right':j-j1,'top':$(window).height()+200},3000);
                    }
                };
                runTime = window.setInterval(run, 1000);
                function run(){
                    var s = $(".page-time span").text();
                        if(s == 0){
                            $("#pop-end").show();
                            $(".page-time").hide();
                            window.clearInterval(runTime);
                            window.clearInterval(Timerr);
                            //扣除一次抽奖次数
                            $.ajax({
                                url:'<?php echo $_VArray['timeReq']  ?>',
                                type:'POST',
                                data:{one:1},
                                dataType:'json',
                                async: true,  //同步发送请求t-mask
                                beforeSend:function(){
                                },
                                success:function(result){
                                    if(result.status == true){
                                        times = result.times;
                                    }else{
                                        times--;
                                    }
                                    sessionStorage.setItem('times', times);
                                    console.log(sessionStorage.getItem("times"));
                                },
                                error:function(){
                                    times--;
                                }
                            });
                            return false;
                    }
                    s--;
                    $(".page-time span").text(s);
                }
            }

            var a = Math.round(Math.random()*2+1);
            $(document).on('touchstart', '.dd', function(){
                $(this).css("background-position","0 -4.907rem");
                a++;
                if(a == 4){
                    $.ajax({
                        url:'<?php echo $_VArray['luckDrawReq']  ?>',
                        type:'POST',
                        data:{one:1},
                        dataType:'json',
                        async: true,  //同步发送请求t-mask
                        beforeSend:function(){
                        },
                        success:function(result){
                            if(result.status == true){
                                $('.redrain-pop-bonus big').text(result.msg.prize);
                                $('.redrain-pop-bonus-p').text(result.msg.msg);
                                $('#pop-bonus').show();
                            }else{
                                $('#pop-noRed').show();

                            }
                            times--;
                            sessionStorage.setItem('times', times);
                            console.log(sessionStorage.getItem("times"));
                            return  false;
                        },
                        error:function(){
                            commonUtil.submitOk("表单发送失败！");
                            layerMobile.changeCssPromptMsgAtc();
                            return false;
                        }
                    });
                    //请求获取优惠券接口
                    window.clearInterval(window.Timerr);
                    window.clearInterval(window.runTime);
                    $(".div").removeClass("bg_1");
                    setTimeout(function(){
                        $(".page-time").hide();
                        $(".div").addClass("bg_2");
                    },2000);
                    a = 0;
                }
            });
            if(times>0){
                game();
            }else{
                //显示次数超限
                $('#pop-notimes').show();
                $('.page-time').hide();
            }

            $(".begin").on("touchend",function(){
                if(times>0){
                    $(".pop-wrap").hide();
                    game();
                }else{
                    //显示次数超限
                    $('.js-mask').hide();
                    $('#pop-notimes').show();
                }
//                $(".pop-wrap").hide();
//                game();
            })
        })

    </script>
</head>
<body>
<div class="redrain-notice">
    <div id="scroll_div">
        <ul>
            <?php echo $_VArray['listStr']; ?>
        </ul>
    </div>
</div>
<div class="page_rain">
    <div class="page-time"><span>8</span>s</div>
    <div class="div bg_1"></div>
</div>

<!-- 弹窗开始 -->

<!-- 游戏时间结束 -->
<div class="pop-wrap js-mask" id="pop-end">
    <div class="redrain-pop-mask"></div>
    <div class="redrain-pop">
        <div class="redrain-pop-close" data-toggle="mask" data-target="js-mask"></div>
        <div class="redrain-pop-end"></div>
        <div class="redrain-pop-btn">
            <a href="<?php echo $_VArray['timesReqt']; ?>">查看获奖记录</a>
            <a href="javascript:;" class="begin">再玩一次</a>
        </div>
    </div>
</div>
<!-- End 游戏时间结束 -->

<!-- 抢到红包 -->
<div class="pop-wrap js-mask" id="pop-bonus" style="display: ;">
    <div class="redrain-pop-mask"></div>
    <div class="redrain-pop">
        <div class="redrain-pop-close" data-toggle="mask" data-target="js-mask"></div>
        <div class="redrain-pop-bonus">
            <p>¥<big>30</big></p>
            <p class="redrain-pop-bonus-p">恭喜您本次红包雨获得<span>30</span>优惠券</p>
        </div>
        <div class="redrain-pop-btn bonus-btn">
            <a href="<?php echo $_VArray['timesReqt']; ?>">查看获奖记录</a>
            <a href="javascript:;" class="begin">再玩一次</a>
        </div>
    </div>
</div>
<!-- End 抢到红包 -->

<!-- 未抢到红包 -->
<div class="pop-wrap js-mask" id="pop-noRed" style="display: ;">
    <div class="redrain-pop-mask"></div>
    <div class="redrain-pop">
        <div class="redrain-pop-close" data-toggle="mask" data-target="js-mask"></div>
        <div class="redrain-pop-none">
            <p>很遗憾未中奖</p>
        </div>
        <div class="redrain-pop-btn bonus-none">
            <a href="<?php echo $_VArray['timesReqt']; ?>">查看获奖记录</a>
            <a href="javascript:;" class="begin">再玩一次</a>
        </div>
    </div>
</div>
<!-- End 未抢到红包 -->

<!-- 赞过了 -->
<div class="pop-wrap js-mask" style="display: ;">
    <div class="redrain-pop-mask"></div>
    <div class="redrain-pop">
        <div class="redrain-pop-close" data-toggle="mask" data-target="js-mask"></div>
        <div class="redrain-pop-done"></div>
    </div>
</div>
<!-- End 赞过了 -->

<!-- 3次机会用完 -->
<div class="pop-wrap js-mask" id="pop-notimes" style="display: ;">
    <div class="redrain-pop-mask"></div>
    <div class="redrain-pop">
<!--        <div class="redrain-pop-close" data-toggle="mask" data-target="js-mask"></div>-->
        <div class="redrain-pop-chance"></div>
        <div class="redrain-pop-btn">
            <a href="=<?php echo $_VArray['invitationUrl']; ?>">马上邀请</a>
        </div>
    </div>
</div>
<!-- End 3次机会用完 -->
<script type="text/javascript">
    //消息滚动
    jQuery("#scroll_div").jCarouselLite({
        auto:1000,
        speed:2000,
        visible:1,
        vertical:false
    });
    $(function(){

        //弹窗关闭隐藏
        $(document).on('touchend', '[data-toggle="mask"]', function (event) {
            event.stopPropagation();
            var target = $(this).attr("data-target");
            $("."+target).hide();
        });

        // 弹窗调用
        $(document).on('touchend', 'a[data-target]',function(event){
            event.stopPropagation();
            var target = $(this).attr("data-target");
            $("div[data-module="+target+"]").show();
        });
    })
</script>

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


</body>
</html>