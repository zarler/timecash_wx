<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1,target-densitydpi=medium-dpi">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
    <?php echo HTML::style('static/v1/css/turntable/reset.css'); ?>
    <?php echo HTML::style('static/v1/css/turntable/turntable.css'); ?>
    <?php echo HTML::script('static/v1/js/jquery-1.9.1.min.js'); ?>
</head>
<body>
<script type="text/javascript">
// var loadingObj = new loading(document.getElementById('loading'),{radius:20,circleLineWidth:8});   
//     loadingObj.show();   
</script>
<section class="turntable-1">
    <?php echo HTML::image('static/v1/images/turntable/turntable-banner.png',array("class"=>"img turntable-banner"));?>
	<div id="outercont">
		<div id="outer-cont">
            <div id="outer"><?php echo HTML::image('static/v1/images/turntable/activity-lottery-1.png',null);?></div>
			</div>
			<div id="inner-cont">
			<div id="inner"><?php echo HTML::image('static/v1/images/turntable/activity-lottery-2.png',null);?></div>
		</div>
        <?php echo HTML::image('static/v1/images/turntable/turntable-cash.png',array("class"=>"turntable-cash"));?>
	</div>

</section>

<section class="turntable-2">
	<!-- 新用户 -->
	<dl class="t-code">
		<dt><?php echo HTML::image('static/v1/images/turntable/code.png',null);?></dt>
		<dd>
			<p>长按二维码</p>
			<p>关注 <span>快金服务号</span></p>
		</dd>
	</dl>
	<h4 class="turntable-title turntable-title1">活动规则</h4>
	<div class="turntable-3">
		<dl>
			<dt>●</dt>
			<dd>每位用户每天至少可转一次转盘</dd>
		</dl>
		<dl>
			<dt>●</dt>
			<dd>如抽到再转一次可重新抽奖一次，每个用户每天最多可转三次</dd>
		</dl>
		<dl>
			<dt>●</dt>
			<dd>抽到的减息券会自动放入用户的账户内有效期3个月</dd>
		</dl>
		<dl>
			<dt>●</dt>
			<dd>本次活动最终解释权归快金所有</dd>
		</dl>
	</div>
	
	<!-- 老用户 -->
	<h4 class="turntable-title">活动规则</h4>
	<div class="turntable-3">
		<dl>
			<dt>●</dt>
			<dd>每位用户每天至少可转一次转盘</dd>
		</dl>
		<dl>
			<dt>●</dt>
			<dd>如抽到再转一次可重新抽奖一次，每个用户每天最多可转三次</dd>
		</dl>
		<dl>
			<dt>●</dt>
			<dd>抽到的减息券会自动放入用户的账户内有效期3个月</dd>
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
	<div class="t-bomb_box">
		<!-- 快金狂送减息券 -->
		<!-- <div class="t-bomb-couns">
			<p class="t-bomb-couns1">
				<span>50</span>元
			</p>
		</div>
		<p class="t-bomb-couns2">50元减息券已放入账户，大神受我一拜！明日再战，更多惊喜等着你哟！</p>
		<a href="#" class="turntable-btn">现在去借款</a> -->
		
		<!-- 快金狂送减息券 -->
		
		<!-- 手气不佳 -->
			<!-- <div class="t-bomb-img"><img src="../images/turntable-img.png"></div>
			<p class="t-bomb-1 mb">每天最多3次机会</p>
			<p  class="t-bomb-1">今日手气不佳</p>
			<p  class="t-bomb-1 mb1">明日再战吧!</p>
			<a href="#" class="turntable-btn">确定</a> -->
		<!-- 手气不佳 -->

		<!-- 二维码代金券 -->
			<div class="t-bomb-couns">
				<p class="t-bomb-couns1">
					<span>50</span>元
				</p>
			</div>
			<p class="t-bomb-couns4">50元减息券已放入账户</p>
			<p class="t-bomb-2">长按二维码关注“快金”公众注册借款最快10分钟放款</p>
			<a href="#" class="turntable-btn">现在去借款</a>
		<!-- 二维码代金券  -->

		 <div class="t-bomb-close"></div>

	</div> 
	<!-- end  -->

<!-- start -->
<!-- 二维码再试一次 -->
<!-- <div class="t-bomb_box1">
		<div class="t-bomb-img"><img src="../images/turntable-img.png"></div>
		<p class="t-bomb-3">每天最多3次机会，今日手气不佳明日再战吧!</p>
		<p class="t-bomb-2">长按二维码关注“快金”公众注册借款最快10分钟放款</p>
		<a href="#" class="turntable-btn">确定</a>
	<div class="t-bomb-close"></div>
</div> -->
<!-- 二维码再试一次 -->
<!-- end -->
</div>
</body>
</html>
<script type="text/javascript">
$(function(){
	//弹窗
	function alert1(){
		$(".box_alert").fadeIn()
	}
	$(".t-bomb-close,.t-mask").click(function(){
		$(".box_alert").fadeOut();
	})
	// 转盘
    window.requestAnimFrame = (function() {
        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
        function(callback) {
            window.setTimeout(callback, 1000 / 60)
        }
    })();
    var totalDeg = 360 * 3 + 0;
    var steps = [];
    var lostDeg = [36, 66, 96, 156, 186, 216, 276, 306, 336];
    var prizeDeg = [6, 126, 246];
    var prize, sncode;
    var count = 0;
    var now = 0;
    var a = 0.03;
    var outter, inner, timer, running = false;
    function countSteps() {
        var t = Math.sqrt(2 * totalDeg / a);
        var v = a * t;
        for (var i = 0; i < t; i++) {
            steps.push((2 * v * i - a * i * i) / 2)
        }
        steps.push(totalDeg)
    }
    function step() {
        outter.style.webkitTransform = 'rotate(' + steps[now++] + 'deg)';
        outter.style.MozTransform = 'rotate(' + steps[now++] + 'deg)';
        if (now < steps.length) {
            requestAnimFrame(step)
        } else {
            running = false;
            setTimeout(function() {
                if (prize != null) {
                    $("#sncode").text(sncode);
                    var type = "";
                    if (prize == 1) {
                        type = "一等奖"
                    } else if (prize == 2) {
                        type = "二等奖"
                    } else if (prize == 3) {
                        type = "三等奖"
                    }
                    $("#prizetype").text(type);
                    $("#result").slideToggle(500);
                    $("#outercont").slideUp(500)
                } else {
                    // alert("谢谢您的参与，下次再接再厉")
                    alert1();

                }
            },
            200)
        }
    }
    function start(deg) {
        //deg = deg || lostDeg[parseInt(lostDeg.length * Math.random())];
        running = true;
        clearInterval(timer);
        totalDeg = 360 * 5 + deg;
        steps = [];
        now = 0;
        countSteps();
        requestAnimFrame(step)
    }
    window.start = start;
    outter = document.getElementById('outer');
    inner = document.getElementById('inner');
    i = 10;
    $("#inner").click(function() {
        if (running) return;
        if (count >= 3) {
            alert("您已经抽了 3 次奖。");
            return
        }
        if (prize != null) {
            alert("亲，你不能再参加本次活动了喔！下次再来吧~");
            return
        }
        $.ajax({
            url: "<?php echo URL::site('Turntable/Lottery');?>",
            dataType: "json",
            data: {
                token: "o7MB9ji5fQRsE0ZoVAMU7SlnRyMI",
                ac: "activityuser",
                tid: "5",
                t: Math.random()
            },
            beforeSend: function() {

                running = true;
                timer = setInterval(function() {
                    i += 5;
                    outter.style.webkitTransform = 'rotate(' + i + 'deg)';
                    outter.style.MozTransform = 'rotate(' + i + 'deg)'
                },
                1)
            },
            success: function(data) {
//                alert(data.angle);
//                alert(data.prize);
//                if (data.error == "invalid") {
//                    alert("您已经抽了 3 次奖。");
//                    count = 3;
//                    clearInterval(timer);
//                    return
//                }
//                if (data.error == "getsn") {
//                    alert('本次活动你已经中过奖，本次只显示你上次抽奖结果!兑奖SN码为:' + data.sn);
//                    count = 3;
//                    clearInterval(timer);
//                    prize = data.prizetype;
//                    sncode = data.sn;
//                    start(prizeDeg[data.prizetype - 1]);
//                    return
//                }
                if (data.status) {
                    $('.t-bomb-couns4').text(data.msg);
                    $('.t-bomb-couns1 span').text(data.prize);
                    if(data.id==1){
                        $('.turntable-btn').css('display','none');
                    }else{
                        $('.turntable-btn').css('display','block');
                    }
                    start(data.angle);
                } else {
                    prize = null;
                    start()
                }
                running = false;
                count++
            },
            error: function() {
                prize = null;
                start();
                running = false;
                count++
            },
            timeout: 4000
        })
    })
});

    
</script>