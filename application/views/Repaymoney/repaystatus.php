<?php include Kohana::find_file('views', 'public/head');?>
	<body>
		<section class="t-login-nav">
			<div class="t-login-nav-1"><a href="<?php echo URL::site('User/index');?>" class="t-return"></a>还款处理中</div>
		</section>
		<section class="m-successbox">
			<div class="m-successbg">
				<?php echo HTML::image('static/images/m-successok.png');?>
				<p class="m-successtxt">还款处理中</p>
				<p class="m-borrow">还款正在处理中！</p>
			</div>
		</section>
		<section class="m-returnbox">
			<a href="<?php echo URL::site('User/index');?>" class="t-red-btn">返回我的账户</a>
		</section>
	</body>
</html>
