<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<!--<link rel="stylesheet" type="text/css" href="/static/ui_bootstrap/Bombbox/css/component.css?1111"/>-->
<style>
    ul{margin:0;padding:0;list-style:none}
    img{
        width: 100%;
        border: none;
        margin: 0;
        padding: 0;
    }
    .jiathis_style_32x32 .tip{
        width: 32%;
        display: -webkit-inline-box;
        text-align: center;
        padding-top: 1rem
    }
    .column{
        background: red;
        height: .8rem;
        width: 2rem;
        font-size: .3rem;
        line-height: .8rem;
        text-align: center;
        position: absolute;
        right: 0;
        top: .8rem;;
        border-top-left-radius:.6rem;
        border-bottom-left-radius:.6rem;
        color: white;
        background: -webkit-linear-gradient(left top, #FF7ED4 60%, white); /* Safari 5.1 - 6.0 */
        background: -o-linear-gradient(bottom right, #FF7ED4 60%, white); /* Opera 11.1 - 12.0 */
        background: -moz-linear-gradient(bottom right, #FF7ED4 60%, white); /* Firefox 3.6 - 15 */
        background: linear-gradient(to bottom right, #FF7ED4 60%, white); /* 标准的语法 */
    }

    /*分享样式*/

    .jiathis_button_qzone{
        display: block;
        height: 1.7rem;
        width: 76%;
        background: url(/static/Activity/TC0A-026/images/TC0A-026-weixin.png) no-repeat;
        background-size: contain;
        background-position: center;
        margin: 0 auto;
    }
    .tip{
        width: 33%;
        float: left;
        height: 2.3rem;
        /*margin-top: .7rem;*/
    }
    .share_div {
        background: url(/static/Activity/TC0A-026/images/TC0A-026-2.png) no-repeat;
        background-size: 100% 100%;
        width: 100%;
        background-position: center;
        height: 6rem;
    }
    .OA026-3{
        height: 2rem;
        width: 100%
    }
    .OA026-3 div{
        width: 44%;
        margin: 0 3%;
        background: url(/static/Activity/TC0A-026/images/TC0A-026-3-b.png) no-repeat;
        background-size: 100% 100%;
        background-position: center;
        height: 2.3rem;
        text-align: center;
        padding-top: .5rem;
    }
    .OA026-3 p{
        margin: 0;
    }
    .OA026-3 button{
        width: 80%;
        font-size: .3rem;
        background: #FF55BD;
        border-radius: .5rem;
        color: white;
        height: .7rem;
        border: none;
    }
    .OA026-4{
        height: 2rem;
        width: 94%;
        margin:0 3%;
        color: white;
    }

    .OA026-4 div{
        height: 4.5rem;
        text-align: center;
        width: 47%;
    }

    .OA026-4 .div1{
        background: url(/static/Activity/TC0A-026/images/TC0A-026-40.png) no-repeat;
        background-size: 100% 100%;
        background-position: center;
        float: left;
    }
    .OA026-4 .div2{
        background: url(/static/Activity/TC0A-026/images/TC0A-026-4-7.png) no-repeat;
        background-size: 100% 100%;
        background-position: center;
        float: right;
    }
    .OA026-5{
        /*height: 8rem;*/
        background: url(/static/Activity/TC0A-026/images/TC0A-026-4-b.png) no-repeat;
        background-size: 100% 100%;
        width: 94%;
        background-position: center;
        height: 7rem;
        margin: .7rem 3%;
        padding-top:1rem;
        padding-bottom: 1rem;
    }
    .OA026-5 div{
        height: 1.75rem;
        width: 94%;
        padding: 0 3%;
        color: white;
    }
    .OA026-5 button{
        font-size: .35rem;
        background: #ff55bc;
        height: .8rem;
        float: right;
        border-radius: .5rem;
        border: none;
        color: white;
        padding: 0 .4rem;
        margin-top: .34rem;
        margin-right: 3%;
    }
    .OA026-5 span{
        display: inline-block;
        height: 1.55rem;
        padding-top: .2rem;
    }

    .OA026-5 .span-o{
        float: left;margin-left: 19%;font-size: .38rem;width: 25%;
    }
    .OA026-5 em{
        color: #ff4d5e;
    }
    .OA026-5 .span-s{
        width: 30%;text-align: center;line-height: 1rem;color: #fbb317;font-size: .3rem;
    }
    .OA026-6{
        /*height: 8.6rem;*/
        background: url(/static/Activity/TC0A-026/images/TC0A-026-6.png) no-repeat;
        background-size: 100% 100%;
        width: 94%;
        background-position: center;
        height: 6.536rem;
        margin: .7rem 3%;
        padding-top:1.72rem;
        padding-bottom: 0.344rem;
    }
    .OA026-6 ul{
        height: 6.536rem;
        width: 70%;
        margin: 0 auto;
        font-size: .3rem;
    }
    .OA026-6 li{
        height: 0.564rem;
    }
    .OA026-6 ul span{
        display: inline-block;
        height: 0.564rem;
        line-height: 0.6536rem;
        text-align: center;
    }
    .OA026-6 ul .span1{
        padding-left: 6%;
        width: 14%;
    }
    .OA026-6 ul .span2{
        width: 50%;
    }
    .OA026-6 ul .span3{
        width: 30%;
    }
    .OA026-f{
        width: 100%;
        height: 1.2rem;
        padding-top: .2rem;
        background: rgba(12,16,89,0.5);
        position: relative;
        bottom:0
    }
    .OA026-f a{
        background: url(/static/Activity/TC0A-026/images/TC0A-026-button.png) no-repeat;
        background-size: contain;
        width: 70%;
        height: 1rem;
        margin: 0 auto;
        display: block;
        border: none;
    }
    /*遮罩*/
    .mask{
        position: fixed;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(12,16,89,0.6);
        z-index: 99;
    }
    .bombbox{
        width: 90%;
        height: 60%;
        z-index: 100;
        position: fixed;
        top: 25%;
        left: 5%;
        display: none;
    }
    .bombboxag{
        width:100%;
        height: 80%;
        background: #6530de;
    }
    .bombbox img{
        display: block;
        margin: 0 auto;
        width: 1.2rem;
        margin-top: 5%;
    }

</style>

<script>
    window.onscroll = function(){
        var t = document.documentElement.scrollTop || document.body.scrollTop;  //获取距离页面顶部的距离
        if(t>434){
            $('.OA026-f').css('position','fixed');
        }else{
            $('.OA026-f').css('position','');
        }
    }
</script>



<body style="font-size: .35rem;background:#0C1059">
<!--活动规则-->
<!--<div class="md-modal md-effect-1" id="modal-1">-->
<!--    <div class="md-content">-->
<!--        <h3>活动规则<i class="md-close"></i></h3>-->
<!--        <div>-->
<!--            <p>This is a modal window. You can do the following things with it:</p>-->
<!--            <ul>-->
<!--                <li><strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.</li>-->
<!--                <li><strong>Look:</strong> a modal window enjoys a certain kind of attention; just look at it and appreciate its presence.</li>-->
<!--                <li><strong>Close:</strong> click on the button below to close the modal.</li>-->
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


<!--活动规则-->
<div class="md-modal md-effect-1" id="modal-1">
        <div class="bombbox">
            <div class="bombboxag"></div>
            <img class="md-close" src="/static/images/t-cash-icon8.png">
        </div>
</div>



<div class="column md-trigger" data-modal="modal-1" onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', '活动规则','1','huodongguize']);">活动规则</div>
<script src="/static/ui_bootstrap/Bombbox/js/classie.js"></script>
<script src="/static/ui_bootstrap/Bombbox/js/modalEffects.js"></script>
<!--头-->
<div style="font-size: 0">
    <img src="/static/Activity/TC0A-026/images/TC0A-026-1.jpg" />
</div>
<!--分享-->
<!-- JiaThis Button BEGIN -->
<!--<div class="jiathis_style_32x32" style="width: 100%">-->
<div class="share_div">
    <a href="/h5/Activity/TCOA026Raiders" style="height: 0.85rem;line-height: 0.89rem;padding-left: 1.5rem;color: white;font-size: .45rem">查看赚钱攻略></a>
    <div style="height: 5.15rem;margin: 0.55rem 3% 0 3%">
        <div class="tip " onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', 'QQ空间分享','1','huodongguize']);">
            <a  class="jiathis_button_qzone" ></a>
        </div>
        <div class="tip" onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', '新浪分享','1','huodongguize']);" >
            <!--        <a class="jiathis_button_tsina"></a>-->
            <a  class="jiathis_button_qzone" ></a>
        </div>
        <div class="tip" onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', 'QQ微博分享','1','huodongguize']);">
            <!--        <a class="jiathis_button_tqq"></a>-->
            <a  class="jiathis_button_qzone" ></a>
        </div>
        <div class="tip" onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', '微信分享','1','huodongguize']);">
            <!--        <a class="jiathis_button_weixin" ></a>-->
            <a  class="jiathis_button_qzone" ></a>
        </div>
        <div class="tip" onclick="_czc.push(['_trackEvent', 'TC0A026', '点击', 'qq分享','1','huodongguize']);">
            <!--        <a class="jiathis_button_cqq"></a>-->
            <a  class="jiathis_button_qzone" ></a>
        </div>
    </div>
<!--    <a href="http://www.jiathis.com/share?uid=2160350" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>-->
<!--    <a class="jiathis_counter_style"></a>-->
</div>
<script type="text/javascript">
    var jiathis_config = {
        url: "http://www.baidu.com",
        pic:'http://a-cdn.timecash.cn/banner/inst/banner/xdxcy.png',
        title: "自定义网页标题",
        summary:"分享的文本摘要"
    }
</script>
<script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js?uid=2160350" charset="utf-8"></script>
<div style="font-size: 0;text-align: center;padding: .5rem 0">
    <img style="width: 60%;margin: 0 .3rem auto" src="/static/Activity/TC0A-026/images/TC0A-026-3.png" />
</div>
<div class="OA026-3" style="">
    <div style="float: left;">
        <p>成功邀请好友（人）</p>
        <p style="margin:.1rem 0;font-size: .5rem;color: #fbb317">100</p>
        <button>查看详情</button>
    </div>
    <div style="float: right;">
        <p>获得现金红包（元）</p>
        <p style="margin:.1rem 0;font-size: .5rem;color: #ff4d5e">5000</p>
        <button>点击体现</button>
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
        <div>
            <span class="span-o">现金红包<br><em>￥50元</em></span>
            <span class="span-s">借款人数满三人</span>
            <button>已领取</button>
        </div>
        <div style="clear: both">
            <span class="span-o">京东购物卡<br><em>￥500元</em></span>
            <span class="span-s">借款人数满三人</span>
            <button>已领取</button>
        </div>
        <div style="clear: both">
            <span class="span-o">足金金元宝<br><em>￥1500元</em></span>
            <span class="span-s">借款人数满三人</span>
            <button>已领取</button>
        </div>
        <div style="clear: both">
            <span class="span-o">IphoneX手机<br><em>￥8388元</em></span>
            <span class="span-s">借款人数满三人</span>
            <button>已领取</button>
        </div>
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
    <a></a>
</div>

<!--遮罩-->
<!--<div class="mask"></div>-->

</div>
<!--<script src="https://s22.cnzz.com/z_stat.php?id=1273339547&web_id=1273339547" language="JavaScript"></script>-->
</body>
</html>