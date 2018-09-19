<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>幸运大抽奖提额送不停</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <!-- <link href="images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" /> -->
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-019/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-019/css/lottery.css">
    <script type="text/javascript" src="/static/Activity/TC0A-019/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/static/Activity/TC0A-019/js/cssrem.js"></script>
    <script type="text/javascript" src="/static/Activity/TC0A-019/js/jquery.jCarouselLite.js"></script>
    <script src="/static/Activity/TC0A-019/js/pop.js"></script>
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
    <script type="text/javascript" src="/static/js/v2/common_layer_mobile.js"></script>

</head>
<body>
<article>
    <div class="lottery-banner">
        <p class="lottery-des">100%中奖，最高800元提额等你拿</p>
        <div class="lottery-notice">
            <div id="scroll_div">
                <ul>
                    <?php echo $_VArray['listStr']; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- 代码 开始 -->
    <div id="lottery">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td class="lottery-unit lottery-unit-0"><img src="/static/Activity/TC0A-019/images/lottery-1.png"></td>
                <td class="lottery-unit lottery-unit-1"><img src="/static/Activity/TC0A-019/images/lottery-2.png"></td>
            </tr>
            <tr>
                <td class="lottery-unit lottery-unit-3"><img src="/static/Activity/TC0A-019/images/lottery-3.png"></td>
                <td class="lottery-unit lottery-unit-2"><img src="/static/Activity/TC0A-019/images/lottery-4.png"></td>
            </tr>
        </table>
    </div>
    <?php echo $_VArray['buttonStr']; ?>

    <div class="lottery-info">
        <h2>活动规则</h2>
        <div class="lottery-use-rule">
            <p>1.活动时间：2017.12.12-2017.12.15</p>
            <p>2.活动期间，所有在快金完成极速贷还款的用户都可进行抽奖，获得不同额度的提额，100%中奖;</p>
            <p>3.抽奖资格24小时内有效，获奖后在快金极速贷首页查看获得提额，下笔借款可直接使用;</p>
            <p>4.提额有效期是到账后的14天，活动期间多次抽奖获得的提额可累加，每笔提额只可使用一次;</p>
            <p>5.提额只在快金借款时使用，不能提现及作为其他用途;</p>
            <p>6.本活动发放的所有奖励只有符合快金借款资格的用户可用;</p>
            <p>7.本活动在法律允许范围内最终解释权归快金所有。</p>
        </div>
    </div>

</article>


<?php if(isset($_VArray['tipShare'])&&Valid::not_empty($_VArray['tipShare'])){ ?>
    <!-- 首次进入 -->
<!--    <div class="pop-wrap js-mask1" style="display: block;">-->
<!--        <div class="lottery-pop-mask"></div>-->
<!--        <div class="lottery-pop-content recevie">-->
<!--            <div class="lottery-pop-share-close" data-toggle="mask" data-target="js-mask1"></div>-->
<!--            <p class="lottery-pop-share-text">12月11日-12月28日在快金成功还款后，即可获得提额抽奖机会，最高800元，100%中奖！</p>-->
<!--            --><?php //echo $_VArray['buttonRepayStr'] ?>
<!--        </div>-->
<!--    </div>-->
<!---->
<!--    <div class="pop-wrap js-mask2" style="display: none;">-->
<!--        <div class="lottery-pop-mask"></div>-->
<!--        <div class="lottery-pop-content luck">-->
<!--            <div class="lottery-pop-share-close luck" data-toggle="mask" data-target="js-mask2"></div>-->
<!--            <p class="lottery-pop-luck-text">动动小手~<br>最高800元提额等着你哟~</p>-->
<!--            <a href="javascript:;" class="lottery-pop-share-btn">马上抽奖</a>-->
<!--        </div>-->
<!--    </div>-->
<!---->
    <!-- 中奖后 -->
    <div class="pop-wrap js-mask" id="winning" data-module="pop-rule" style="display: none;">
        <div class="lottery-pop-mask"></div>
        <div class="lottery-pop-content">
            <div class="lottery-pop-close" data-toggle="mask" data-target="js-mask"></div>
            <div class="lottery-pop-txt">
                <h3>恭喜您获得300元提额</h3>
                <p>天灵灵，地灵灵</p>
                <p>大奖小奖已显灵！</p>
            </div>
            <div class="lottery-pop-btn-wrap">
                <a href="/#jump=BannerAppHome" class="lottery-pop-btn default">马上使用</a>
                <a href="<?php echo $_VArray['invitationUrl'] ?>" class="lottery-pop-btn active">炫耀一下</a>
            </div>
        </div>
    </div>

<?php }else{ ?>
    <div class="pop-wrap js-mask1" style="display: block;">
        <div class="lottery-pop-mask"></div>
        <div class="lottery-pop-content recevie">
            <p class="lottery-pop-share-text">12月12日-12月15日在快金成功还款后，即可获得提额抽奖机会，最高800元，100%中奖！</p>
            <a href="/#jump=BannerLoanRecord" class="lottery-pop-share-btn">马上参与</a>
        </div>
    </div>

<?php } ?>


<script type="text/javascript">
    //消息滚动
    jQuery("#scroll_div").jCarouselLite({
        auto:1000,
        speed:2000,
        visible:1,
        vertical:false
    });
</script>


<?php if(isset($_VArray['share'])&&Valid::not_empty($_VArray['share'])){ ?>
    <script type="text/javascript">
        var index = 1;
        var lottery={
            index:-1,   //当前转动到哪个位置，起点位置
            count:0,    //总共有多少个位置
            timer:0,    //setTimeout的ID，用clearTimeout清除
            speed:20,   //初始转动速度
            times:0,    //转动次数
            cycle:50,   //转动基本次数：即至少需要转动多少次再进入抽奖环节
            prize:-1,   //中奖位置
            init:function(id){
                if ($("#"+id).find(".lottery-unit").length>0) {
                    $lottery = $("#"+id);
                    $units = $lottery.find(".lottery-unit");
                    this.obj = $lottery;
                    this.count = $units.length;
                    $lottery.find(".lottery-unit-"+this.index).addClass("active");
                };
            },
            roll:function(){
                var index = this.index;
                var count = this.count;
                var lottery = this.obj;
                $(lottery).find(".lottery-unit-"+index).removeClass("active");
                index += 1;
                if (index>count-1) {
                    index = 0;
                };
                $(lottery).find(".lottery-unit-"+index).addClass("active");
                this.index=index;
                return false;
            },
            stop:function(index){
                this.prize=index;
                return false;
            }
        };

        function roll(){
            lottery.times += 1;
            lottery.roll();
            if (lottery.times > lottery.cycle+10 && lottery.prize==lottery.index) {
                clearTimeout(lottery.timer);
                lottery.prize=-1;
                lottery.times=0;
                click=false;
            }else{
                if (lottery.times<lottery.cycle) {
                    lottery.speed -= 10;
                }else if(lottery.times==lottery.cycle) {
                    //var index = Math.random()*(lottery.count)|0;
                    console.log(index);
                    lottery.prize = index;
                }else{
                    if (lottery.times > lottery.cycle+10 && ((lottery.prize==0 && lottery.index==7) || lottery.prize==lottery.index+1)) {
                        lottery.speed += 110;
                        setTimeout(function () {
                            $('#winning').show();
                            $("#lottery-btn").attr("disabled", false);
                        },1700)
                    }else{
                        lottery.speed += 20;
                    }
                }
                if (lottery.speed<40) {
                    lottery.speed=40;
                };
                //console.log(lottery.times+'^^^^^^'+lottery.speed+'^^^^^^^'+lottery.prize);
                lottery.timer = setTimeout(roll,lottery.speed);
            }
            return false;
        }


        var click=false;
        var cansubmit = true;


        window.onload=function(){
            lottery.init('lottery');
        };
        function submit() {
            $("#lottery-btn").attr("disabled", true);
            if(cansubmit){
                cansubmit = false;
                $.ajax({
                    url: '<?php echo $_VArray['019LuckDraw']; ?>',
                    type: 'POST',
                    //data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
                    data:{one:'one'},
                    dataType: 'json',
                    async: true,  //同步发送请求t-mask
                    beforeSend: function () {
                    },
                    success: function (result) {
                        if(result.status){
                            index = result.code;
                            $('#winning .lottery-pop-txt h3').html('恭喜您获得'+result.prize+'元提额');
                            console.log(result);
                            if (click) {
                                return false;
                            }else{
                                lottery.speed=100;
                                roll();
                                click=true;
                                return false;
                            }
                        }else{
                            layerMobile.submitOk('亲，您已经抽过啦，下次还款成功后再来吧!');
                            layerMobile.changeCssPromptMsgAtc();
                        }
                    },
                    error: function () {

                    }
                });
            }else{
                layerMobile.submitOk('亲，您已经抽过啦，下次还款成功后再来吧!');
                layerMobile.changeCssPromptMsgAtc();
                $("#lottery-btn").attr("disabled", false);
            }
        }
        function clickSubmit($action) {
            $.ajax({
                url: '<?php echo $_VArray['clickButtonUrl']; ?>',
                type: 'POST',
                //data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
                data:{action:$action,event_name:'TCOA_019'},
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
    </script>
    <?php if(isset($_VArray['app'])&&$_VArray['app']){ ?>
        <script>
            var u = navigator.userAgent;
            var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
            var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
            function shareWx(){
                if(isAndroid){
                    window.android.sharingFriends('<?php echo $_VArray['sharetitle']; ?>', '<?php echo $_VArray['text']; ?>', '<?php echo $_VArray['img_url']; ?>', '<?php echo $_VArray['url']; ?>','19');
                }
                if(isiOS){
                    sharingFriends('<?php echo $_VArray['sharetitle']; ?>', '<?php echo $_VArray['text']; ?>', '<?php echo $_VArray['img_url']; ?>', '<?php echo $_VArray['url']; ?>','19');
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
            //分享成功
            function shareAjax() {
                $.ajax({
                    url:'<?php echo $_VArray['shareUrl']; ?>',
                    type:'POST',
                    data:{action:'show',event_name:'TCOA_019',time:0},
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
<?php } ?>


</body>
</html>