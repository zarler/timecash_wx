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
    <script type="text/javascript" src="/static/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/static/js/v2/compatibleEqui.js"></script>
    <script type="text/javascript" src="/static/Activity/TC0A-017/js/tab.js"></script>

</head>
<body>
<article>
    <div class="redrain-notice">
        <div id="scroll_div">
            <ul>
                <?php echo $_VArray['listStr']; ?>
            </ul>
        </div>
    </div>
    <div class="redrain-main">
        <a href="javascript:;" class="redrain-rule-btn" data-target="pop-rule">活动规则</a>
<!--        <a href="redrain.html" class="redrain-btn">马上抢红包</a>-->
        <?php echo $_VArray['LoanButton']; ?>
    </div>
    <div class="redrain-info">
        <ul class="redrain-tab">
            <li class="active">红包记录</li>
            <li>奖励使用须知</li>
        </ul>
        <div class="redrain-tab-main">
            <ul class="redrain-tab-list">
                <li><span>红包明细</span><span>获奖时间</span></li>
                <?php echo $_VArray['listRed']?>
            </ul>
            <div  class="redrain-list-btn">
                <?php echo $_VArray['listRedMore']  ?>
            </div>
        </div>
        <div class="redrain-tab-main">
            <div class="redrain-use-rule">
                <p>1.免单：本活动获得的免单使用权是到账后的30天，30天内用户在快金借一笔7天1000元极速贷，系统自动免单;</p>
                <p>2.提额：本活动获得的提额有效期是到账后的30天，获奖后可在借款首页查看，借款极速贷时直接使用;</p>
                <p>3.免息：本活动获得的极速贷7天1000元免息奖励以免息券形式发放到账户，有效期是到账后的30天;</p>
                <p>4.优惠券：本活动获得的优惠券使用期限是到账后的30天，借款时直接使用;</p>
                <p>5.本活动获得所有奖励只在快金借款时使用，不可提现以及作为其他用途;</p>
                <p>6.本活动发放的所有奖励只有符合快金借款资格的用户可用;</p>
                <p>7.如有疑问可咨询客服电话是010-56592060;</p>
                <p>8.本活动最终解释权在法律允许范围内归快金所有。</p>
            </div>
        </div>
    </div>

</article>
<div class="pop-wrap js-mask" data-module="pop-rule">
    <div class="redrain-pop-mask"></div>
    <div class="redrain-pop-rule">
        <div class="redrain-pop-close" data-toggle="mask" data-target="js-mask"></div>
        <div class="redrain-pop-rule-txt">
            <h3>活动规则</h3>
            <p>1.活动时间:11月23日-11月25日;</p>
            <p>2.在规定时间内接到有奖励的红包，就算成功领取红包奖励，可在我的获奖记录查看，使用办法可查看奖励使用须知;</p>
            <p>3.活动期间红包奖项包括:<br>
                &nbsp;&nbsp;极速贷1000元7天免单：9名;<br>
                &nbsp;&nbsp;极速贷500元提额：9名;<br>
                &nbsp;&nbsp;极速贷1000元7天免息：3名;<br>
                &nbsp;&nbsp;优惠券:极速贷50元、极速贷30元、极速贷20元若干;<br>
            </p>
            <p>4.每个用户每日3次参与机会;</p>
            <p>5.把活动页面分享给不同的好友，只要好友点开分享链接完成点赞，即算成功分享，每成功分享一次即可多获得一次（当日）抽奖机会，每个用户每日最多可额外获得3次抽奖机会，抽奖机会当日有效。</p>
        </div>
    </div>
</div>

<script type="text/javascript" src="/static/Activity/TC0A-017/js/jquery.jCarouselLite.js"></script>

<?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
<script type="text/javascript" src="/static/js/v2/common_layer_mobile.js"></script>
<script type="text/javascript">
    if (sessionStorage.getItem("times")) {
        console.log(sessionStorage.getItem("times"));
        sessionStorage.removeItem("times");
        // 恢复文本输入框的内容
    }
    //消息滚动
    jQuery("#scroll_div").jCarouselLite({
        auto:1000,
        speed:2000,
        visible:1,
        vertical:false
    });


    $(function(){
        // tab 切换
        $(".redrain-info").tabs({
            tabList: ".redrain-tab li",
            tabContent: ".redrain-tab-main",
            action:'touchend'
        });

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
</body>
</html>