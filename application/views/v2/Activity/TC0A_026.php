<?php include Kohana::find_file('views', 'v2/public/activityHead');?>
<link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-026/css/TCOA-026.css?!1112"/>
    <script type="text/javascript" src="/static/ui_bootstrap/bomb/bomb_screen.js"></script>
    <script src="/static/js/v2/timecash.app.js"></script>
    <script>
        seajs.config({
            vars: {
                wx:<?php echo (isset($_VArray['wx'])&&!empty($_VArray['wx']))?1:2; ?>,
                appId:'<?php echo isset($_VArray['signPackage']["appId"])?$_VArray['signPackage']["appId"]:'' ?>',
                timestamp:'<?php echo isset($_VArray['signPackage']["timestamp"])?$_VArray['signPackage']["timestamp"]:'' ?>',
                nonceStr:'<?php echo isset($_VArray['signPackage']["nonceStr"])?$_VArray['signPackage']["nonceStr"]:'' ?>',
                signature:'<?php echo isset($_VArray['signPackage']['signature'])?$_VArray['signPackage']['signature']:'' ?>',
                sharetitle:'<?php echo isset($_VArray['sharetitle'])?$_VArray['sharetitle']:'' ?>',
                text:'<?php echo isset($_VArray['text'])?$_VArray['text']:'' ?>',
                url:'<?php echo isset($_VArray['url'])?$_VArray['url']:'' ?>',
                img_url:'<?php echo isset($_VArray['img_url'])?$_VArray['img_url']:'' ?>',
                requestUrl:'<?php echo isset($_VArray['requestUrl'])?$_VArray['requestUrl']:'' ?>',
                clickButtonUrl:'<?php echo isset($_VArray['clickButtonUrl'])?$_VArray['clickButtonUrl']:'' ?>',
                shareButtonUrl:'<?php echo isset($_VArray['shareUrl'])?$_VArray['shareUrl']:'' ?>',
            }
        });
        seajs.use('js/v2/seajs/act_026');
        var $AppInst = new $.AppInst();

    </script>
    <style>

    </style>
<body style="font-size: .35rem;background:#0C1059">

<?php if(isset($_VArray['showtitle'])&&$_VArray['showtitle']){?>
    <section class="t-login-nav">
        <div class='t-login-nav-1'>
            <a href="<?php echo isset($_VArray['urlHome'])?$_VArray['urlHome']:'javascritp:history.go(-1);' ?>" class="return_i i_public"></a>邀请好友
        </div>
    </section>
    <div class="top_height"></div>
<?php }?>

<!--<div class="text1"></div>-->

<div class="column bb_modal" data-code="modal-1" onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', '活动规则','1','huodongguize']);">活动规则</div>
<!--头-->
<div style="font-size: 0">
    <img onclick="return false" src="/static/Activity/TC0A-026/images/TC0A-026-1.jpg" />
</div>
<!--分享-->
<div class="share_div_s">
    <a href="/h5/Activity/TCOA026Raiders">查看赚钱攻略></a>
</div>

<div style="font-size: 0;text-align: center;padding: .5rem 0">
    <img onclick="return false" style="width: 60%;margin: 0 .3rem auto" src="/static/Activity/TC0A-026/images/TC0A-026-3.png" />
</div>
<div class="OA026-3" style="">
    <div style="float: left;">
        <p>成功邀请好友（人）</p>
        <p style="margin:.1rem 0;font-size: .5rem;color: #fbb317"><?php echo $_VArray['invited_num']; ?></p>
        <a onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', '查看详情','2','kankanxiangqing']);" href="<?php echo $_VArray['Urldetails'];?>">查看详情</a>
    </div>
    <div style="float: right;">
        <p>获得现金红包（元）</p>
        <p style="margin:.1rem 0;font-size: .5rem;color: #ff4d5e"><?php echo $_VArray['award']; ?></p>
        <a onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', '点击提现','3','dianjitixian']);" href="<?php echo $_VArray['UrlWithdrawals'];?>">点击提现</a>
    </div>
</div>
<div style="clear: both"></div>
<div style="font-size: 0;text-align: center;padding: .5rem 0">
    <img onclick="return false" style="width: 60%;margin: 0 .3rem auto" src="/static/Activity/TC0A-026/images/TC0A-026-4.png" />
</div>
<div class="OA026-4" style="">
    <div class="div1" style="">
        <p style="margin-bottom: 1.7rem">好友成功借款<br>您将获得</p>
        <p style="color: #fbb317;font-size: .4rem;">40元现金奖励<br><span style="font-size: .3rem">(返现无上限)</span></p>
    </div>
    <div class="div2" style="">
        <p style="margin-bottom: 1.7rem">好友成功注册<br>您和好友将获得</p>
        <p style="color: #ff4d5e;font-size: .4rem;">7天免息券<br><span style="font-size: .3rem">(使用无门槛)</span></p>
    </div>
</div>
<div style="clear: both"></div>
<div class="OA026-5">
        <?php echo $_VArray['prizeList']; ?>
</div>
<a href="<?php echo $_VArray['UrlMyPrize']; ?>" class="OA026-5-a">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
<div class="OA026-6">
    <ul>
        <li style="font-size: .35rem"><span class="span1">名次</span><span class="span2">手机号</span><span class="span3">邀请好友数</span></li>
        <?php echo $_VArray['invitedList']; ?>
    </ul>
</div>
<div style="height: 1.2rem"></div>
<div class="OA026-f">
    <a href="<?php echo $_VArray['UrlInvitation'];?>"></a>
</div>
<!--遮罩-->
<div class="mask"></div>
<!--活动规则-->
<div class="bombbox">
    <div class="bombboxag">
        <h1>活动规则</h1>
        <p>1、活动时间：2018年4月26日-5月25日;<br>
            2、奖励获得必须满足以下条件:<br>
            &nbsp;&nbsp;&nbsp;&nbsp;a、被邀请好友必须从未注册过快金;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;b、好友必须通过邀请人分享的链接注册才视为邀请成功;<br>
            3、活动期间，每邀请一名好友成功注册，您与好友各得一张7天免息券，免息券仅限在快金平台借款时使用，单个账户免息券领取上限为30张，超过部分不再累计赠送；<br>
            4、被邀请的好友在活动期间成功借款，您可得40元现金奖励，奖励金额不设上限，多邀多得。现金奖励实时发放至您的账户中，可随时申请提现；<br>
            5、借款好友满3人，可领取50元现金奖励；借款好友满20人，可领取价值500元的京东购物卡；借款好友满50人，可领取价值1500元的足金金元宝；借款好友满100人，可领取价值8388元的IphoneX;<br>
            6、实物类奖励将在活动结束后5个工作日内统一发放；<br>
            7、被邀请的好友必须是真实用户，同一身份证信息将被认同为同一用户，若发现重复、批量注册等涉嫌欺骗性行为，快金有权利不给涉及账号奖励！<br>
            8、如有疑问，请咨询：010-56592060。
        </p>
    </div>
    <div class="bxg-img">
        <img class="md-close" src="/static/Activity/TC0A-026/images/clock.png">
    </div>
</div>
<!--领取成功-->
<div class="bombbox2">
    <div class="bombboxag2">
        <p>温馨提示：活动结束后统一发放实物奖品</p>
        <button onclick="$('.bombbox2').hide();$('.mask').hide();">好&nbsp;&nbsp;&nbsp;的</button>
    </div>
    <div class="bxg-img">
        <img class="md-close" src="/static/Activity/TC0A-026/images/clock.png">
    </div>
</div>
<!--二维码-->
<div class="bombbox3">
    <div class="bombboxag3">
    </div>
    <div class="bxg-img">、
        <img class="md-close" src="/static/Activity/TC0A-026/images/clock.png">
    </div>
</div>

<div class="bombbox4">
    <div class="bombboxag4">
        <p>您还没有登录哦~ 请先登录账号！</p>
        <a href="javascript:receiveReward(5);">前往登录</a>
    </div>
    <div class="bxg-img">
        <img class="md-close" src="/static/Activity/TC0A-026/images/clock.png">
    </div>
</div>
</div>
<script src="https://s22.cnzz.com/z_stat.php?id=1273339547&web_id=1273339547" language="JavaScript"></script>
</body>
</html>
