<html>
<head>
    <meta charset="utf-8">
    <title>端午整点抢免单</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--<link rel="stylesheet" href="//res.layui.com/layui/build/css/layui.css"  media="all">-->
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/js/v2/standard_local.js');?>
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
    <?php echo HTML::script('static/ui_bootstrap/bomb/bomb_screen.js');?>
    <?php echo HTML::script('static/js/v2/common_layer_mobile.js');?>
    <script>
        $(document).ready(function(){
            bomob_screen.firstready();
            $('#bomb_screen').on('click',function () {
                bomob_screen.bomobremove();
            });
        });
    </script>
    <script>
        function autoScroll(obj){
            $(obj).find("ul").animate({
                marginTop : "-.3rem"
            },500,function(){
                $(this).css({marginTop : "0px"}).find("li:first").appendTo(this);
            })
        }
        $(function(){
            setInterval('autoScroll(".apple")',3000);
        })
    </script>
    <style type="text/css">
        *{
            margin: 0;padding: 0;
            font-size: .3rem;
        }
        body{
            background:#235E52;
        }
        li{ list-style:none;font-size: .02rem; margin-left: .3rem}
        a{text-decoration:none;color: black}
        .apple{ width:100%; height:.9rem; overflow:hidden; text-align: center;background: #437266;}
        .apple a{margin-left: .3rem; display:block; text-decoration:none;font-size:.4rem;width:100%; height:.9rem; line-height:.8rem; text-indent:.06rem; color:black;color: white}

        #example2 {
            background-image: url(/static/images/v2/activity/DragonBoat/01.png);
            background-position: left top;
            background-repeat: no-repeat;
            background-size: cover;
            width: 3.89rem;
            height: 1.1rem;
            display: inline-block;
            position: relative;
            right: -.1rem;
            top: .1rem;
            text-align: center;
            line-height: 4.7;
            color: white;
        }
        #example1 {
            background-image: url(/static/images/v2/activity/DragonBoat/004.png);
            background-position: left top;
            background-repeat: no-repeat;
            background-size:contain;
            padding: 13px;
            margin: 0 auto;
            width: 80%;
            color: white;
        }
        #example2 span{
            font-size:.4rem;
            position: relative;
            top: -.4rem
        }
        #jisudai{
            background-image: url(/static/images/v2/activity/DragonBoat/003.png);
            background-position: left top;
            background-repeat: no-repeat;
            background-size:cover;
            padding: 13px;
            margin: 0 auto;
            height: 3.9rem;
            width: 88%;
        }
        #danbao{
            background-image: url(/static/images/v2/activity/DragonBoat/002.png);
            background-position: left top;
            background-repeat: no-repeat;
            background-size:cover;
            padding: 13px;
            margin: 0 auto;
            height: 3.9rem;
            width: 88%;
        }
        .buoy{
            position: fixed;
            bottom: .5rem;
            right: .3rem;
            background: url(/static/images/v2/activity/WholePoitGo/8.png);
            background-position: left top;
            background-repeat: no-repeat;
            background-size:cover;
            width: 2rem;
            height: 2.3rem;
        }
        p{
            padding: .5rem .2rem;
            line-height: 2.2;
            height: 6rem;
            font-size: .25rem;
            font-weight: lighter;
        }
        strong{
            font-size: .4rem;
        }
        #fullbg {
            position: fixed;
            background-color: rgba(0,0,0,.8);
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: 99;
        }
        @media (min-device-width : 220px) and (max-device-width : 350px)  and (-webkit-min-device-pixel-ratio : 2){
            /*iphone 5*/

            .ceshi{
                background: red;
            }
            #example1 {
                height: 9.34rem;
            }
        }
        @media (min-device-width : 330px) and (max-device-width :  413px) and (-webkit-min-device-pixel-ratio : 2){
            /*小米*/

            #example1 {
                height:9.7rem;
            }
            .ceshi{
                background: black;
            }
        }

        @media (min-device-width : 330px) and (max-device-width :  413px) and (-webkit-max-device-pixel-ratio : 2){
            /*iphone 6*/

            #example1 {
                height:9.5rem;
            }
            .ceshi{
                background: black;
            }
        }
        @media (min-device-width : 413px) and (max-device-width : 667px) and (-webkit-min-device-pixel-ratio : 3){
            /*iphone 6plus*/

            #example1 {
                height: 9.7rem;
            }
            .ceshi{
                background: yellow;
            }
        }

    </style>
</head>
<body>
<img  width="100%" src="/static/images/v2/activity/DragonBoat/006.png">
<div class="apple" style="position: relative;">
    <?php echo $lunbo; ?>
</div>
<section style="background:  url(/static/images/v2/activity/DragonBoat/005.png) repeat fixed center;width: 100%;padding: .2rem 0;">
    <div id="jisudai" style="text-align: center;">
        <div style="height: 1.2rem;"></div>
        <strong style="display:inline-block;margin-left: 1.9rem;color: #54F2CD;">
            1500元<br>
            7--21天
        </strong>
        <a href="<?php echo $url_rapidly; ?>"
        		<article id="example2">
        			<span>马上去抢</span>
        		</article>
        </a>
    </div>
    <div id="danbao" style="text-align: center;">
        <div style="height: 1.2rem;"></div>
        <strong style="display:inline-block;margin-left: 1.9rem;color: #54F2CD;">
            5000元<br>
            7--21天
        </strong>
        <a href="<?php echo $url_guarantee; ?>"><article id="example2"><span>马上去抢</span></article></a>
    </div>
    <div style="height: .5rem;"></div>
    <div id="example1" >
        <h2 style="text-align:center;margin-top: .4rem;font-size:.4rem ;">活动规则</h2>
        <p style="">
            1、开抢时间：5月26/27日10点、13点、16点、19点;<br>
            2、活动形式：各抢购时间点开始后，用户开始下单，系统随机抽出数十名获奖用户，给予免单、免息和利息随机减的优惠，奖励数量有限，先到先得;<br>
            3、中奖名单：中奖名单会在该抢购时间段结束后公布（如13点公布10点获奖名单），获奖用户将活动页面分享到微信群并截图私信快金微信服务号，还可获得30元续贷优惠券一张；<br>
            4、此活动不与线上其他其他优惠（包括但不限于优惠券）同时使用；<br>
            5、同一用户只能参加一次，同一设备同一手机号同一张银行卡视为同一个用户;<br>
            6、活动最终解释权归快金所有。
        </p>
    </div>

</section>
<div class="buoy" onclick="clickEvent();<?php if($type == 2){ ?>sendToAndroid();<?php }else{ ?>bomob_screen.showMask(true);<?php }?>"></div>

<div id="fullbg" style="display: none" onclick="$('#fullbg').hide()">
    <div id="dialog">
        <img style="position:fixed;top:.1rem;right: 0;width: 5rem;z-index:100" src="/static/images/v2/activity/WholePoitGo/02_03.png">
    </div>
</div>
</body>

<script>

    function borrowType(type) {
        $.ajax({
            url:'/FunctionsApp/statisticsBorrow',
            type:'POST',
            data:{action:'borrow',type:type,event_name:'TCOA_010'},
            dataType:'json',
            async: true,
            beforeSend:function(){
            },
            success:function(result){
            },
            error:function(){
            }
        });
    };
    function clickEvent() {
        $.ajax({
            url:'/FunctionsApp/statisticsAllIp',
            type:'POST',
            data:{time:1495900800,action:'click',event_name:'TCOA_010'},
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

<?php if($type == 1){ ?>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
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
