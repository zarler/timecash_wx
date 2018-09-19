<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-026/css/TCOA-026.css"/>

<script>
    window.onscroll = function(){
        var t = document.documentElement.scrollTop || document.body.scrollTop;  //获取距离页面顶部的距离
        if(t>434){
            $('.OA026-f').css('position','fixed');
        }else{
            $('.OA026-f').css('position','');
        }
    };
    $(document).ready(function(){
        $('.bb_modal').click(function () {
            $('.bombbox').show();
            $('.mask').show();
            $('body').css('position','fixed');
            $('body').css('width','100%');
        });
        $('.md-close').click(function () {
            $('.bombbox').hide();
            $('.bombbox1').hide();
            $('.bombbox2').hide();
            $('.bombbox3').hide();
            $('.mask').hide();
            $('body').css('position','');
        });
        $('.jiathis_button_2weima').click(function () {
            $('.bombbox3').hide();
            $('.mask').hide();
            $('body').css('position','');
        });
    })
    function showbombox(num) {
        $('.bombbox'+num).show();
        $('.mask').show();
        $('body').css('position','fixed');
        $('body').css('width','100%');
    }
    function hidebombox(num) {
        $('.bombbox'+num).hide();
        $('.mask').hide();
        $('body').css('position','');
    }
//    领取奖励
    function receiveReward(num) {
        switch (num){
            case 1:case 2:case 3:case 4:

            break;
            default:
                layerMobile.submitUrl('亲，需要您先登录哦！','/Login');
                layerMobile.changeCssPromptMsgAtc();
                break;
        }
    }
</script>

<body style="font-size: .35rem;background:#0C1059">
<div class="column bb_modal" data-code="modal-1" onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', '活动规则','1','huodongguize']);">活动规则</div>
<!--头-->
<div style="font-size: 0">
    <img src="/static/Activity/TC0A-026/images/TC0A-026-1.jpg" />
</div>
<!--分享-->
<div class="share_div">
    <a href="/h5/Activity/TCOA026Raiders" style="height: 0.85rem;line-height: 0.89rem;padding-left: 1.5rem;color: white;font-size: .45rem">查看赚钱攻略></a>
    <div style="height: 5.15rem;margin: 0.55rem 3% 0 3%">
        <div class="tip " onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', '微信分享','1','huodongguize']);">
            <a  class="jiathis_button_weixin" ></a>
        </div>
        <div class="tip" onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', 'qq分享','1','huodongguize']);" >
                    <a class="jiathis_button_cqq"></a>
        </div>
        <div class="tip" onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', '二维码分享','1','huodongguize']);">
                    <a class="jiathis_button_2weima" href="javascript:showbombox(3);" ></a>
        </div>
        <div class="tip" onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', 'QQ空间分享','1','huodongguize']);">

            <a  class="jiathis_button_qzone" ></a>
        </div>
        <div class="tip" onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', '新浪分享','1','huodongguize']);">
            <!--        <a class="jiathis_button_weixin" ></a>-->
            <a  class="jiathis_button_tsina" ></a>
        </div>
    </div>
<!--    <a href="http://www.jiathis.com/share?uid=2160350" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>-->
</div>
<script type="text/javascript">
    var jiathis_config = {
        url: "<?php echo $_VArray['UrlShare']; ?>",
        pic:'http://a-cdn.timecash.cn/banner/inst/banner/xdxcy.png',
        title: "自定义网页标题",
        summary:"分享的文本摘要"
    }
</script>
<?php if($_VArray['Login']){ ?>
    <script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js?uid=2160350" charset="utf-8"></script>
<?php } ?>
<div style="font-size: 0;text-align: center;padding: .5rem 0">
    <img style="width: 60%;margin: 0 .3rem auto" src="/static/Activity/TC0A-026/images/TC0A-026-3.png" />
</div>
<div class="OA026-3" style="">
    <div style="float: left;">
        <p>成功邀请好友（人）</p>
        <p style="margin:.1rem 0;font-size: .5rem;color: #fbb317">100</p>
        <button onclick="<?php echo $_VArray['Urldetails'];?>">查看详情</button>
    </div>
    <div style="float: right;">
        <p>获得现金红包（元）</p>
        <p style="margin:.1rem 0;font-size: .5rem;color: #ff4d5e">5000</p>
        <button onclick="<?php echo $_VArray['UrlWithdrawals'];?>">点击提现</button>
    </div>
</div>
<div style="clear: both"></div>
<div style="font-size: 0;text-align: center;padding: .5rem 0">
    <img style="width: 60%;margin: 0 .3rem auto" src="/static/Activity/TC0A-026/images/TC0A-026-4.png" />
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
<div class="OA026-6">
    <ul>
        <li style="font-size: .35rem"><span class="span1">名次</span><span class="span2">手机号</span><span class="span3">邀请好友数</span></li>
        <li><span class="span1">1</span><span class="span2">185****8888</span><span class="span3">800人</span></li>
        <li><span class="span1">2</span><span class="span2">185****8888</span><span class="span3">800人</span></li>
        <li><span class="span1">3</span><span class="span2">185****8888</span><span class="span3">800人</span></li>
        <li><span class="span1">4</span><span class="span2">185****8888</span><span class="span3">800人</span></li>
        <li><span class="span1">5</span><span class="span2">185****8888</span><span class="span3">800人</span></li>
        <li><span class="span1">6</span><span class="span2">185****8888</span><span class="span3">800人</span></li>
        <li><span class="span1">7</span><span class="span2">185****8888</span><span class="span3">800人</span></li>
        <li><span class="span1">8</span><span class="span2">185****8888</span><span class="span3">800人</span></li>
        <li><span class="span1">9</span><span class="span2">185****8888</span><span class="span3">800人</span></li>
        <li><span class="span1">10</span><span class="span2">185****8888</span><span class="span3">800人</span></li>

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
        <p>1、活动时间：2018年5月1日-5月31日;<br>
            2、奖励获得必须满足以下条件:<br>
            &nbsp;&nbsp;&nbsp;&nbsp;a、被邀请好友必须从未注册过快金;<br>
            &nbsp;&nbsp;&nbsp;&nbsp;b、好友必须通过邀请人分享的链接注册才视为邀请成功;<br>
            3、活动期间，每邀请一名好友成功注册，您与好友各得一张7天免息券，免息券仅限在快金app借款时使用，单个账户免息券领取上限为30张，超过部分不再累计赠送；<br>
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
        <button>好&nbsp;&nbsp;&nbsp;的</button>
    </div>
    <div class="bxg-img">
        <img class="md-close" src="/static/Activity/TC0A-026/images/clock.png">
    </div>
</div>
<!--二维码-->
<div class="bombbox3">
    <div class="bombboxag3">
        <p>邀请好友扫描二维码<br>双方各得一张</p>
        <img src="/static/images/activity/turntable/code.png">
    </div>
    <div class="bxg-img">
        <img class="md-close" src="/static/Activity/TC0A-026/images/clock.png">
    </div>
</div>
</div>
<script src="https://s22.cnzz.com/z_stat.php?id=1273339547&web_id=1273339547" language="JavaScript"></script>
</body>
</html>