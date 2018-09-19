<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<script>
	seajs.config({
		vars: {
			'userId':<?php echo (isset(Wxgv::$userinfo['user_id'])&&!empty(Wxgv::$userinfo['user_id']))?1:2; ?>
		}
	});
	seajs.use('js/v2/seajs/my-wallet');
</script>
<style type="text/css">

</style>
<body style="background: #F3F3F3">
<div class="loading_ok" style="display: none">
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a href="/?jump=no" class="return_i i_public"></a>我的钱包
	</div>
</section>
<!-- 头信息end -->
<div class="top_height"></div>
<section class="wallet_secone_home">
	<a href="/Wallet/Detailed"  class="tc_divleft">
		<p style="padding: 0"><strong><?php echo $coin; ?></strong></p>
		<p style="padding: 0">金额 (元)</p>
	</a>
	<div class="tc_divmiddle_home"></div>
	<a href="/CouponApp/coupon"  class="tc_divright">
		<p><strong><?php echo $coupon_num; ?></strong></p>
		<p>优惠券</p>
	</a>
</section>
<div style="clear: both"></div>
</div>
</body>
</html>