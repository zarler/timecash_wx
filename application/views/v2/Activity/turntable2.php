<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>疯狂大转盘</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1,target-densitydpi=medium-dpi">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
    <?php echo HTML::style('static/css/activity/turntable/reset.css'); ?>
    <?php echo HTML::style('static/css/activity/turntable/turntable.css?11111'); ?>
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js'); ?>
    <?php echo HTML::script('static/js/activity/turntable/awardRotate.js'); ?>
</head>
<body>
<script type="text/javascript">
</script>

<section class="turntable-1">
    <?php echo HTML::image('static/images/activity/turntable/turntable-banner2.png',array("class"=>"img turntable-banner"));?>
    <!-- 代码 开始 -->
    <div class="banner">
        <div class="turnplate">
            <canvas class="item" id="wheelcanvas" width="422px" height="422px"></canvas>
            <?php echo HTML::image('static/images/activity/turntable/activity-lottery-2.png',array("class"=>"pointer","disable"=>"true"));?>
        </div>
    </div>
    <!-- 代码 结束 -->
</section>
<section class="turntable-2">
	<!-- 新用户 -->
	<dl class="t-code">
		<dt><?php echo HTML::image('static/images/activity/turntable/code.png',null);?></dt>
		<dd>
			<p>长按二维码</p>
			<p>关注 <span>快金服务号</span></p>
		</dd>
	</dl>
    <h4 class="turntable-title turntable-title1">活动规则</h4>
    <!-- 老用户 -->
    <!-- <h4 class="turntable-title">活动规则</h4>-->
    <div class="turntable-3">
        <dl>
            <dt>●</dt>
            <dd>每位用户有3次抽奖机会</dd>
        </dl>
        <dl>
            <dt>●</dt>
            <dd>抽到的减息券会自动放入用户账户内，有效期30天</dd>
        </dl>
        <dl>
            <dt>●</dt>
            <dd>新用户使用当前微信号注册后即可使用</dd>
        </dl>
        <dl>
            <dt>●</dt>
            <dd>本次活动最终解释权归快金所有</dd>
        </dl>
    </div>
    <!-- 老用户 -->
</section>
<!-- 弹窗 -->
<div class="box_alert" style="display: none;">
<div class="t-mask"></div>
	<!-- start  -->
	<div class="t-bomb_box" style="height:400px;display: none">
		<!-- 二维码代金券 -->
			<div class="t-bomb-couns"><p class="t-bomb-couns1"><span>0</span>元</p>
			</div>
			<p class="t-bomb-couns4">减息券已放入您的账户中，赶快去借款吧！</p>
			<p class="t-bomb-2" style="margin-top:30px;font-size:12px;line-height:28px">长按下方二维码关注“快金”公众号立即借款，最快10分钟放款！</p>
        <?php echo HTML::image('static/images/activity/turntable/code1.png',array("class"=>"turntable-cash-fu"));?>
		<!-- 二维码代金券  -->
		 <div class="t-bomb-close"></div>
	</div> 
	<!-- end  -->
<!-- start -->
<!-- 二维码再试一次 -->
    <div class="t-bomb_box1" style="height:400px;display: none">
            <div class="t-bomb-img"><?php echo HTML::image('static/images/activity/turntable/turntable-img.png',array());?></div>
            <p class="t-bomb-3">哎呀，没有抽到，赶快再试一次吧！</p>
            <p class="t-bomb-2">长按下方二维码关注“快金”公众号立即借款，最快10分钟放款！</p>
            <a href="javascript:$('.box_alert').fadeOut();" class="turntable-btn">再转一次</a>
            <?php echo HTML::image('static/images/activity/turntable/code1.png',array("class"=>"turntable-cash-fu"));?>
        <div class="t-bomb-close"></div>
    </div>
    <div class="t-bomb_box2" style="height:400px;display: none">
        <div class="t-bomb-img"><?php echo HTML::image('static/images/activity/turntable/icon_keai.png',array());?></div>
        <p class="t-bomb-3 t-bomb-4">您的3次机会已用完，下次活动再来吧~</p>
        <p class="t-bomb-2 t-margin-top">长按下方二维码关注“快金”公众号立即借款，最快10分钟放款！</p>
        <?php echo HTML::image('static/images/activity/turntable/code1.png',array("class"=>"turntable-cash-fu"));?>
        <div class="t-bomb-close"></div>
    </div>
    <div id="icon"></div>
<!-- 二维码再试一次 -->
<!-- end -->
</div>
</body>
</html>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<?php if(isset($type)&&$type==1){?>
    <script>
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
                title: '快金疯狂大转盘，狂送减息券！', // 分享标题
                link: 'http://test.wx.timecash.cn/Turntable/index2?action=index2', // 分享链接
                imgUrl: 'http://test.wx.timecash.cn/static/v1/images/turntable/sharepicture.png', // 分享图标
                success:function(){
                    // 用户确认分享后执行的回调函数
                },
                cancel:function(){
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareAppMessage({
                title: '快金疯狂大转盘，狂送减息券！', // 分享标题
                desc: '还等什么，快来抢啊！', // 分享描述
                link: 'http://test.wx.timecash.cn/Turntable/index2?action=index2', // 分享链接
                imgUrl: 'http://test.wx.timecash.cn/static/v1/images/turntable/sharepicture.png', // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success:function(){
                    // 用户确认分享后执行的回调函数
                },
                cancel:function(){
                    // 用户取消分享后执行的回调函数
                }
            });
        });

    </script>
<?php }?>

<script type="text/javascript">
    var clickable = true;
    var timer2 = null;
    //弹窗
    function alert1(){
        clickable = true;
        $(".box_alert").fadeIn()
    }
    $(".t-bomb-close,.t-mask").click(function(){
        $(".box_alert").fadeOut();
    });
    // 转盘
    var turnplate={
        restaraunts:[],             //大转盘奖品名称
        colors:[],                  //大转盘奖品区块对应背景颜色
        outsideRadius:167,          //大转盘外圆的半径
        textRadius:110,             //大转盘奖品位置距离圆心的距离
        insideRadius:54,            //大转盘内圆的半径
        startAngle:0,               //开始角度
        bRotate:false               //false:停止;ture:旋转
    };

    $(document).ready(function(){
        //动态添加大转盘的奖品与奖品区域背景颜色
        turnplate.restaraunts = ["¥20减息券", "再转一次", "¥50减息券", "¥10减息券"];
        turnplate.colors = ["#ffc029", "#ffde3d", "#ffc029", "#ffde3d"];
        var rotateTimeOut = function (){
            $('#wheelcanvas').rotate({
                angle:0,
                animateTo:2160,
                duration:8000,
                callback:function (){
                    alert('网络超时，请检查您的网络设置！');
                }
            });
        };

        //旋转转盘 item:奖品位置; txt：提示语;
        var rotateFn = function (item, txt){
            //var angles = item * (360 / turnplate.restaraunts.length) - (360 / (turnplate.restaraunts.length*2));
//            alert(angles);
//            if(angles<270){
//                angles = 270 - angles;
//            }else{
//                angles = 360 - angles + 270;
//            }
            $('#wheelcanvas').stopRotate();
            $('#wheelcanvas').rotate({
                angle:0,
                animateTo:item-3600,
                duration:8000,
                callback:function (){
                    alert1();
                    turnplate.bRotate = !turnplate.bRotate;
                }
            });
        };
        var count = <?php echo isset($count)?$count:0; ?>;
        <?php if(isset($register)&&$register==1){?>
        $('.pointer').click(function (){
            if(clickable==false){
                return false;
            }
            clickable = false;
            if(turnplate.bRotate)return;
            if (count >= 3) {
                 $('.t-bomb_box2').css('display','block');
                 $('.t-bomb_box1').css('display','none');
                 $('.t-bomb_box').css('display','none');
                $('.t-bomb-4').text('您的3次机会已用完，下次活动再来吧~');
                turnplate.bRotate = !turnplate.bRotate;
                 alert1();
                 return
             }
            turnplate.bRotate = !turnplate.bRotate;
            //获取随机数(奖品个数范围内)
            //var item = rnd(1,turnplate.restaraunts.length);
            //奖品数量等于10,指针落在对应奖品区域的中心角度[252, 216, 180, 144, 108, 72, 36, 360, 324, 288]
            $.ajax({
                url: "<?php echo URL::site('Activity/Lottery2');?>",
                dataType: "json",
                data: {
                    token: "o7MB9ji5fQRsE0ZoVAMU7SlnRyMI",
                    ac: "activityuser",
                    tid: "5",
                    t: Math.random()
                },
                beforeSend: function() {
                },
                success: function(data) {
                    if (data.status) {
                        if(data.id==1){
                            $('.t-bomb_box1').css('display','block');
                            $('.t-bomb_box').css('display','none');
                            $('.t-bomb_box2').css('display','none');
                            $('.turntable-btn').text(data.msg);
                        }else{
                            $('.t-bomb_box1').css('display','none');
                            $('.t-bomb_box').css('display','block');
                            $('.t-bomb_box2').css('display','none');
                            $('.t-bomb-couns1 span').text(data.prize);
                            $('.turntable-btn').text('现在去借款');
                        }
                        rotateFn(data.angle, data.msg);
                    } else {
                        prize = null;
                        $('.t-bomb_box2').css('display','block');
                        $('.t-bomb_box1').css('display','none');
                        $('.t-bomb_box').css('display','none');
                        $('.t-bomb-4').text(data.msg);
                        alert1();
                        turnplate.bRotate = !turnplate.bRotate;
                        //start()
                    }
                    count++
                },
                error: function() {
                    clickable = true;
                    turnplate.bRotate = !turnplate.bRotate;
                },
            });
        });
        <?php }else{?>
            $('.pointer').click(function (){
                prize = null;
                $('.t-bomb_box2').css('display','block');
                $('.t-bomb_box1').css('display','none');
                $('.t-bomb_box').css('display','none');
                $('.t-bomb-4').text('未登陆');
                alert1();
            });
        <?php }?>
        drawRouletteWheel();
    });
    function rnd(n, m){
        var random = Math.floor(Math.random()*(m-n+1)+n);
        return random;
    }
    //页面所有元素加载完毕后执行drawRouletteWheel()方法对转盘进行渲染
//    window.onload=function(){
//        clearTimeout(timer2);
//        timer2 = setTimeout(drawRouletteWheel(),100)
//    };
    window.onload=function(){
        drawRouletteWheel();
    };
    function drawRouletteWheel() {
        var canvas = document.getElementById("wheelcanvas");
        if (canvas.getContext) {
            //根据奖品个数计算圆周角度
            var arc = Math.PI / (turnplate.restaraunts.length/2);
            var ctx = canvas.getContext("2d");
            //在给定矩形内清空一个矩形
            ctx.clearRect(0,0,422,422);
            //strokeStyle 属性设置或返回用于笔触的颜色、渐变或模式
            ctx.strokeStyle = "#FFBE04";
            //font 属性设置或返回画布上文本内容的当前字体属性
            ctx.font = '1.3rem Microsoft YaHei';
            for(var i = 0; i < turnplate.restaraunts.length; i++) {
                var angle = turnplate.startAngle + i * arc;
                ctx.fillStyle = turnplate.colors[i];
                ctx.beginPath();
                //arc(x,y,r,起始角,结束角,绘制方向) 方法创建弧/曲线（用于创建圆或部分圆）
                ctx.arc(211, 211, turnplate.outsideRadius, angle, angle + arc, false);
                ctx.arc(211, 211, turnplate.insideRadius, angle + arc, angle, true);
                ctx.stroke();
                ctx.fill();
                //锁画布(为了保存之前的画布状态)
                ctx.save();
                //----绘制奖品开始----
                ctx.fillStyle = "#f9321b";
                var text = turnplate.restaraunts[i];
                var line_height = 23;
                //translate方法重新映射画布上的 (0,0) 位置
                ctx.translate(211 + Math.cos(angle + arc / 2) * turnplate.textRadius, 211 + Math.sin(angle + arc / 2) * turnplate.textRadius);

                //rotate方法旋转当前的绘图
                ctx.rotate(angle + arc / 2 + Math.PI / 2);

                /** 下面代码根据奖品类型、奖品名称长度渲染不同效果，如字体、颜色、图片效果。(具体根据实际情况改变) **/
                if(text.indexOf("5")>0&&text.indexOf("0")==-1){//流量包

                    var texts = text.split("5");
                    for(var j = 0; j<texts.length; j++){
                        ctx.font = j == 0?'bold 2.3rem Microsoft YaHei':'1.3rem Microsoft YaHei';
                        if(j == 0){
                            ctx.fillText(texts[j]+"5", -ctx.measureText(texts[j]+"5").width / 2, j * line_height);
                        }else{
                            ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
                        }
                    }
                }else if(text.indexOf("0")>0){//流量包

                    var texts = text.split("0");
                    for(var j = 0; j<texts.length; j++){
                        ctx.font = j == 0?'bold 2.3rem Microsoft YaHei':'1.3rem Microsoft YaHei';
                        if(j == 0){
                            ctx.fillText(texts[j]+"0", -ctx.measureText(texts[j]+"0").width / 2, j * line_height);
                        }else{
                            ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
                        }
                    }
                }else if(text.indexOf("0") == -1 && text.length>6){//奖品名称长度超过一定范围
                    text = text.substring(0,6)+"||"+text.substring(6);
                    var texts = text.split("||");
                    for(var j = 0; j<texts.length; j++){
                        ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
                    }
                }else{
                    //在画布上绘制填色的文本。文本的默认颜色是黑色
                    //measureText()方法返回包含一个对象，该对象包含以像素计的指定字体宽度
                    ctx.fillText(text, -ctx.measureText(text).width / 2, 0);
                }

                //添加对应图标
                // if(text.indexOf("闪币")>0){
                //     var img= document.getElementById("shan-img");
                //     img.onload=function(){
                //         ctx.drawImage(img,-15,10);
                //     };
                //     ctx.drawImage(img,-15,10);
                // }else if(text.indexOf("谢谢参与")>=0){
                //     var img= document.getElementById("sorry-img");
                //     img.onload=function(){
                //         ctx.drawImage(img,-15,10);
                //     };
                //     ctx.drawImage(img,-15,10);
                // }
                //把当前画布返回（调整）到上一个save()状态之前

                ctx.restore();
                //----绘制奖品结束----
            }
        }


    }

</script>