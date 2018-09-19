
<?php include Kohana::find_file('views', 'public/headapp');?>
<style type="text/css">
	html,body{ width: 100%; position:relative;margin:0;padding: 0;background: white;}
	.all{ width: 100%;1136px}
	.header{ width: 12rem; background:url("/static/images/activity/receivecoupon/lips.png") 0 0 no-repeat; background-size: contain; height: 12rem; margin: auto;margin-top: 6rem}
	a{
		text-decoration:none;
	}
	a:hover{
		background: #FF00FF;
	}
	a:focus{
		background: #FF00FF;
	}
</style>
<body>
<div class="all">
	<a href="wxe28c2110b2833b40://openwebview/?ret=0">
		<header class="header">
		</header>
	</a>
	<div class="t-login-footer">
		<p class="t-error"></p>
		<input type="submit" class="t-red-btn t-red-company" value="点击分享,马上邀请好友"></br></br>
		<!--    <a href="/RegisterApp/Contacts"  class="t-red-btn">跳过</a></br>-->
	</div>
</div>
</body>
<?php echo HTML::script('static/js/jquery-1.9.1.min.js'); ?>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
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
			title: '点击分享,马上邀请好友！', // 分享标题
			link: 'http://test22.m..timecash.cn/Activity/ReceiveCoupon', // 分享链接
			imgUrl: 'http://test22.m.timecash.cn/static/v1/images/turntable/sharepicture.png', // 分享图标
			success:function(){
				// 用户确认分享后执行的回调函数
			},
			cancel:function(){
				// 用户取消分享后执行的回调函数
			}
		});
		wx.onMenuShareAppMessage({
			title: '点击分享,马上邀请好友！', // 分享标题
			desc: '点击分享,马上邀请好友！', // 分享描述
			link: 'http://test22.m.timecash.cn//Activity/ReceiveCoupon', // 分享链接
			imgUrl: 'http://test22.m.timecash.cn/static/v1/images/turntable/sharepicture.png', // 分享图标
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


<script>
	$('.header').click(function(){
		location.href = 'wx234ad233ae222://openwebview/?ret=0';
	});
</script>
</html>
