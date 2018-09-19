<?php include Kohana::find_file('views','v2/public/head');?>
<script>
	seajs.config({
		vars: {
			'url':'/Functions/doDeleteCredit',
			'bj':'<?php echo $_VArray['bj'];?>'
		}
	});
	seajs.use('js/v2/seajs/bankcard');
</script>
<body>
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a class="return_i i_public" href="/"></a>银行卡管理
	</div>
</section>
<!-- 头信息end -->
<div class="top_height"></div>
<section>
	<!--<section class="t-login-nav" style="background: red;height: 3rem;text-align: center;display:list-item;vertical-align: middle">-->
	<div class="nav-coupon">
		<span class="float_left gray orange" style="">收款/还款卡</span>
		<span class="float_right gray" style="">担保卡</span>
	</div>
</section>

<section class="section ">
	<!--<section class="t-login-nav" style="background: red;height: 3rem;text-align: center;display:list-item;vertical-align: middle">-->
		<?php if(count($_VArray['bankArr'])>=1){ foreach ($_VArray['bankArr'] as $key=>$val){?>
			<div class='t-guarantee-list'>
				<div class='border-bottom top'>
					<img src="<?php echo $val['img']  ?>">
					<label><?php echo $val['bank_name'] ?></label>
					<span class='float_right'>借记卡</span>
				</div>
				<div class='clear'></div>
				<p class="t-select2"><span>**** **** **** </span><?php echo $val['card_no'] ?></p>
			</div>
		<a href="/Account/bankinfo" class="t-orange-btn button_submit button_bank" style="margin-top: 1.5rem">更换</a>
		<?php }}else{ ?>
				<p class="p_empty">未添加借记卡</p>
				<div class='t-guarantee-list-add' style="text-align: center;line-height: 1.3;">
					<a href="/Borrowmoney/bankinfo?entrance=bankCreditList" style="color: #b0b0b0" class="t-select3">
						<dl>
							<dt><?php echo HTML::image('static/images/t-cash-icon7.png');?></dt>
							<dd>添加新银行卡</dd>
						</dl>
					</a>
				</div>
		<?php } ?>
</section>
<section class="section display_none t-tab-on">
	<?php if(count($_VArray['creditArr'])>=1){ foreach ($_VArray['creditArr'] as $key=>$val){?>
		<div class="credit_delete_a">
		<?php if($val['is_expire']==1){ ?>
			<div class="credit_transparent">此卡已失效</br><span class="credit_delete" data-bubble="<?php echo $val['id'] ?>">删除</span></div>
		<?php } ?>
		<div class='t-guarantee-list'>
			<div class='border-bottom top'>
				<img src="<?php echo $val['img']  ?>">
				<label><?php echo $val['bank_name'] ?></label>
				<span class='float_right'>信用卡</span>
			</div>
			<div class='clear'></div>
			<p class="t-select2"><span>**** **** **** </span><?php echo $val['card_no'] ?></p>
		</div>
		</div>
	<?php }}else{ ?>
		<p class="p_empty">未添加信用卡</p>
	<?php } ?>

<!--	<section style="margin-top:1rem;">-->
<!--		<div class="credit_transparent">此卡已失效</br><span>删除</span></div>-->
<!--		<div class='t-guarantee-list'>-->
<!--			<div class='border-bottom top'>-->
<!--				<img src="--><?php //echo $k['img']  ?><!--">-->
<!--				<label>浦发银行</label>-->
<!--				<span class='float_right'>信用卡</span>-->
<!--			</div>-->
<!--			<div class='clear'></div>-->
<!--			<p class="t-select2"><span>**** **** **** </span>1108</p>-->
<!--		</div>-->
<!--	</section>-->

	<div class='t-guarantee-list-add' style="text-align: center;line-height: 1.3;">
		<a href="<?php echo URL::site('Borrowmoney/guaranteeadd?entrance=bankCreditList'); ?>" style="color: #b0b0b0">
			<dl>
				<dt><?php echo HTML::image('static/images/t-cash-icon7.png');?></dt>
				<dd>添加新信用卡</dd>
			</dl>
		</a>
	</div>
</section>

<div class="t-box_alert" id="t-box_alert" style="display: none;">
	<div class="t-bomb_box" id="t-bomb_box">
		<h3 class="t-bomb_box-1 t-title border-bottom">使用规则<a href="javascript:;" class="t-close-btn"></a> </h3>
		<ul class="t-rules-item">
			<li class="clear"></li>
			<li><span>•</span><p>用户在借款达到一定额度时,可以使用符合借款额度的优惠券,按面值抵扣借款手续费</p></li>
			<li><span>•</span><p>每一笔借款只能使用1张优惠券</p></li>
			<li><span>•</span><p>优惠券有效期过期后不可再使用</p></li>
			<li><span>•</span><p>每张优惠券不可重复使用,不可找零或兑现</p></li>
		</ul>
	</div>
</div>
<div class="t-mask" style="display: none"></div>
</body>
</html>
