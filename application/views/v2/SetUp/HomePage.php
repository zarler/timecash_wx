<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<style type="text/css">
	.m-webbox {
		background: white;
	}
	.m-webbox div {
		background: #fff;
		border-radius: .2rem;
		padding: 0 .3rem;
		border-bottom: 1px solid #f7f2f2;
	}
	.m-lineblock i {
		width: .5rem;
		height: .5rem;
		margin-top: .33rem;
	}
	.m-lineblock label {
		color: black;
		font-size: .4rem;
		padding-left: .2rem;
		position: absolute;
		top: -.1rem;
	}
	.float_right {
		float: right;
	}
	.inter_i {
		background-image: url(/static/images/v2/icon-into.png);
		display: inline-table;
		background-size: cover;
	}
</style>
<body style="background: #F3F3F3">
<div class="loading_ok" style="display: none">
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a href="/" class="return_i i_public"></a>设置
	</div>
</section>
<div class="top_height"></div>
	<section class="m-webbox">
		<a href="/Login/BackPwd" class="identify1">
			<div class="m-lineblock">
				<label>修改密码</label>
				<i class="inter_i float_right"></i>
			</div>
		</a>
	</section>
</div>
</body>
</html>