<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<script>
    seajs.use('js/v2/seajs/my-wallet');
</script>
<style type="text/css">

</style>
<body style="background: #F3F3F3">
<div class="loading_ok" style="display: none">
<!-- 头信息 -->
<section class="t-login-nav">
    <div class='t-login-nav-1'>
        <a href="/?#jump=no" class="return_i i_public"></a><?php echo $_VArray['title']; ?>
    </div>
</section>
<!-- 头信息end -->
<div class="top_height"></div>
    <section class="wallet_secone_home">
        <a href="<?php echo $_VArray['urlCoin']; ?>"  class="tc_divleft">
            <p style="padding: 0"><strong><?php echo $_VArray['coin']; ?></strong></p>
            <p style="padding: 0">金额 (元)</p>
        </a>
        <div class="tc_divmiddle_home"></div>
        <a href="<?php echo $_VArray['urlCoupon']; ?>"  class="tc_divright">
            <p><strong><?php echo $_VArray['coupon_num']; ?></strong></p>
            <p>优惠券</p>
        </a>
    </section>
<div style="clear: both"></div>
<section class="m-webbox">
	<a href="<?php echo $_VArray['urlDailyCoupons'] ?>" class="identify1">
		<div class="m-lineblock">
			<i class="m-icon-Coupon left_i"></i>
			<label>每日领券</label>
			<i class="inter_i float_right"></i>
		</div>
	</a>
</section>
</div>
</body>
</html>