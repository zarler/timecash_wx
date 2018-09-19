<html>
<head>
    <meta charset="utf-8">
    <title>428整点抢免单</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--<link rel="stylesheet" href="//res.layui.com/layui/build/css/layui.css"  media="all">-->
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/js/v2/standard_local.js');?>
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
   
    <script>
        function autoScroll(obj){
            $(obj).find("ul").animate({
                marginTop : "-39px"
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
            background:#f45b5e;
        }
        li{ list-style:none;font-size: .02rem; }
        a{text-decoration:none;color: black}
        .apple{ width:100%; height:.6rem; overflow:hidden; text-align: center;}
        .apple a{ display:inline; text-decoration:none;font-size:.3rem;width:100%; height:.8rem; line-height:.6rem; text-indent:.02rem; color:black;}

        #example1 {
            background-image: url(/static/images/v2/activity/WholePoitGo/1.png);
            background-position: left top;
            background-repeat: no-repeat;
            background-size:cover;
            padding: 13px;
            margin: 0 13px;
        }
        #example2 {
            background-image: url(/static/images/v2/activity/WholePoitGo/5.png);
            background-position: left top;
            background-repeat: no-repeat;
            background-size:cover;
            width: 3.9rem;
            height: .96rem;
            display: inline-block;
            position: relative;
            right: -.4rem;
            top: .1rem;
            text-align: center;
            line-height: 5.5;
        }
        #example1 {
            background-image: url(/static/images/v2/activity/WholePoitGo/1.png);
            background-position: left top;
            background-repeat: no-repeat;
            background-size:cover;
            padding: 13px;
            margin: 0 13px;
        }
        #example2 span{
            font-size:.3rem ;
            position: relative;
            top: -.3rem;
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
            padding: .3rem .5rem;
            line-height:1.8;
            height: 7.7rem;
            font-size: .32rem;
        }
        strong{
            font-size: .35rem;
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
            p{
                height:7.6rem;
            }
            .ceshi{
                background: red;
            }
            #example1 {
                height: 9.34rem;
            }
        }
        @media (min-device-width : 330px) and (max-device-width :  413px) and (-webkit-min-device-pixel-ratio : 2){
            /*小米*/
            p{
                height:7.83rem;
            }
            #example1 {
                height:9.7rem;
            }
            .ceshi{
                background: black;
            }
        }

        @media (min-device-width : 330px) and (max-device-width :  413px) and (-webkit-max-device-pixel-ratio : 2){
            /*iphone 6*/
            p{
                height:7.83rem;
            }
            #example1 {
                height:9.5rem;
            }
            .ceshi{
                background: black;
            }
        }
        @media (min-device-width : 413px) and (max-device-width : 667px) and (-webkit-min-device-pixel-ratio : 3){
            /*iphone 6plus*/
            p{
                height:8.1rem;
            }
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
<img  width="100%" src="/static/images/v2/activity/WholePoitGo/6.png">
<section style="background: #fa8b4f;width: 100%;height:1rem ;"></section>
<div class="apple" style="position: relative;top: -.8rem;">
    <img src="/static/images/v2/activity/WholePoitGo/horn.png"  style="float: left;display: -webkit-box;position: relative;left: .5rem;width: .4rem;top: .1rem;"/>
    <?php echo $lunbo; ?>
</div>
<section style="background: #f45b5e;width: 100%;padding: .2rem 0;margin-top:-.6rem">
    <div style="border: .04rem dashed black; width: 90%;height: 1.6rem; margin: 0 auto;border-radius: .2rem;">
        <img src="/static/images/v2/activity/WholePoitGo/3.png" style="width:.7rem;margin-top: .4rem;margin-left: .2rem;">
        <strong style="position: relative;top: -0.4rem;left: .1rem;">担保借款</strong>
        <strong style="display:inline-block;margin-left: .6rem;">
            5000元<br>
            7--21天
        </strong>
        <a href="<?php echo $url_guarantee; ?>"<article id="example2"><span>马上去抢</span></article></a>
    </div>
    <div style="border: .04rem dashed black; width: 90%;height: 1.6rem; margin: 0 auto;border-radius: .2rem;margin: .4rem auto;">
        <img src="/static/images/v2/activity/WholePoitGo/4.png" style="width:.7rem;margin-top: .4rem;margin-left: .2rem;">
        <strong style="position: relative;top: -0.4rem;left: .1rem;">极速贷</strong>
        <strong style="display:inline-block;margin-left: .9rem;">
            1500元<br>
            7--21天
        </strong>
        <a href="<?php echo $url_rapidly; ?>"><article id="example2"><span>马上去抢</span></article></a>
    </div>
    <img src="/static/images/v2/activity/WholePoitGo/2.png" width="80%" style="margin: 10px auto  .4rem;display:block" />
    <div id="example1" >
        <h2 style="text-align:center;margin-top: .5rem;color: #f45b5e;font-size:.4rem ;">活动规则</h2>
        <p style="">
            1、开抢时间：4月28日10点、13点、16点、19点;<br>
            2、活动形式：各抢购时间点开始后，用户开始下单，系统随机抽出数十名获奖用户，给予免单、免息和利息随机减的优惠，奖励数量有限，先到先得;<br>
            3、中奖名单：中奖名单会在各抢购时间段全部结束后进行公布，如13点公布10点获奖名单；同时获奖用户将活动页面分享到微信群并截图私信快金微信服务号，还可获得30元续贷优惠券一张；<br>
            4、此活动不与线上其他优惠（包括但不限于优惠券）同时使用；<br>
            5、同一用户只能参加一次，同一设备同一手机号同一张银行卡视为同一个用户;<br>
<!--            6、本活动只在最新版（2.2.0）快金APP中参加，活动最终解释权归快金所有。-->
            6、活动仅限安卓最新版APP和微信端参加,苹果用户在微信端参加活动更容易中奖,最终解释权归快金所有。
        </p>
    </div>
</section>
<img  width="100%" src="/static/images/v2/activity/WholePoitGo/7.png">

<?php if($showbuoy){ ?>
<div class="buoy" onclick="clickEvent();sendToAndroid();"></div>
<?php } ?>

<!--		<div class="ceshi" style="width: 2rem;height: 2rem;"></div>-->
</body>

<script>
    function showmsgMobileRem(){
        $('.layui-m-layerchild h3').css({'height':'1rem','font-size':'0.4rem','border-radius':'.09rem .09rem 0 0'});
        $('.layui-m-layercont').css({'padding':'.2rem .2rem'});
        $('.layui-m-layerbtn span').css({'font-size':'0.4rem'});
        $('.layui-m-layerbtn').css({'height':'1rem','line-height':'3'});
        $('.layui-m-layerbtn, .layui-m-layerbtn span').css({'border-radius':'0 0 .09rem .09rem'});
    };
    function changeShowRem(){
        $('.layui-m-layercont').css({'line-height':'1.3'});
        $('.layui-m-layerchild').css({'border-radius':'.1rem','bottom':'-5.1rem'});
    };
    function showmsg(url){
        layer.open({
            title: [
                '提示',
                'background-color:#ff8470; color:#fff;'
            ]
            ,content: '您尚有未完成的借款订单,请还款后参与活动!'
            ,btn: ['确认']
            ,yes: function(index){
                location.href = url;
        }
        });
    };
    function showmsgCancel(msg){
        layer.open({
            title: [
                '提示',
                'background-color:#ff8470; color:#fff;'
            ]
            ,content: msg
            ,btn: ['确认']
            ,yes: function(index){
                layer.close(index);
            }
        });
    };
    function noLogin(url,msg) {
        layer.open({
            title: [
                '提示',
                'background-color:#ff8470; color:#fff;'
            ]
            ,content: msg
            ,btn: ['确认','取消']
            ,yes: function(index){
                layer.close(index);
                location.href = url;
            }
        });
    };
    function clickOk(msg) {
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 3 //2秒后自动关闭
        });
    };
    function borrowType(type) {
        $.ajax({
            url:'/FunctionsApp/statisticsBorrow',
            type:'POST',
            data:{action:'borrow',type:type,event_name:'TCOA_006'},
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
            url:'/FunctionsApp/statisticsWx',
            type:'POST',
            data:{action:'click',event_name:'TCOA_006'},
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
    $(document).ready(function(){
        $.ajax({
            url:'/FunctionsApp/statisticsWx',
            type:'POST',
            data:{action:'look',event_name:'TCOA_006'},
            dataType:'json',
            async: true,
            beforeSend:function(){
            },
            success:function(result){
            },
            error:function(){
            }
        });
    });
</script>
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
                data:{action:'show',event_name:'TCOA_006'},
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
