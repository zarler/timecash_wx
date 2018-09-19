<?php include Kohana::find_file('views', 'public/head');?>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="<?php echo URL::site('User/index');?>" class="t-return"></a>立即借款</div>
</section>
<section class="borrow-wrap">
	<div class="borrow-title">
		<i></i><span>请选择借款类型</span><i></i>
	</div>
	<div class="m-pic-borrow">
		<a href="<?php echo URL::site($crediturl);?>"><img src="/static/images/icon_loaninassurance.png"></a>
	</div>
	<div class="borrow-rukou">需信用卡担保,最低可得0担保</div>
	<div class="m-pic-borrow" style="margin-top: 3rem">
		<a href="<?php echo URL::site($rapidlyurl);?>"><img src="/static/images/icon_gsou.png"></a>
	</div>
	<div class="borrow-rukou">无需信用卡担保,极速审核,极速放款</div>
	<div class="borrow-rukou" style="color: #ff7200;width:100%;font-size:16px">每天<?php echo date("H:s",$faststatus['today_start']); ?>开放<?php echo $faststatus['today_max']; ?>单，现余<?php echo ($faststatus['today_max']-$faststatus['today_total'])<0?0:$faststatus['today_max']-$faststatus['today_total'] ?>单。</div>
<!--	<a href="--><?php //echo URL::site('Borrowmoney/borrow');?><!--" class="borrow-btn">担保借款</a>-->
<!--	<a href="javascript:;" class="borrow-btn disable">极速贷<ins></ins></a>-->
<!--	<a href="--><?php //echo URL::site('Borrowmoney/extremeBorrow');?><!--" class="borrow-btn">极速贷<ins></ins></a>-->
<!--	<div class="borrow-txt"><i></i>信用借款即将上线，请持续关注微信公众号<br>快金将不定期赠送信用借款优惠券！</div>-->
</section>

</body>
</html>