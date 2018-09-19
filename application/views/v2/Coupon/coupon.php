<?php include Kohana::find_file('views','v2/public/head');?>
<script>
	seajs.config({
		vars: {
			'last_id':<?php echo isset($_VArray['last_id'])?$_VArray['last_id']:1;  ?>,
			'total':<?php echo isset($_VArray['total_coupon'])?$_VArray['total_coupon']:1;  ?>,
			'requestUrl':'<?php echo isset($_VArray['requestUrl'])?$_VArray['requestUrl']:null;  ?>'
		}
	});
	seajs.use('js/v2/seajs/coupon');
</script>
<body>
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a class="return_i i_public" href="javascript:history.go(-1);"></a>优惠券
		<a href="javascript:;"><span id="show-rules" style="margin-right: 0.2rem"><i class="problem_i"></i>使用规则</span></a>
	</div>
</section>
<!-- 头信息end -->
<div class="top_height"></div>
<section>
	<!--<section class="t-login-nav" style="background: red;height: 3rem;text-align: center;display:list-item;vertical-align: middle">-->
	<div class="nav-coupon">
		<span class="float_left gray orange" style=""><a href="javascript:changeTrue()">可使用</a></span>
		<span class="float_right gray" style=""><a href="javascript:changeFalse()">历史记录</a></span>
	</div>
</section>

<section class="section ">
	<!--<section class="t-login-nav" style="background: red;height: 3rem;text-align: center;display:list-item;vertical-align: middle">-->
		<!--优惠券正常状态 -->
		<?php
		if($_VArray['couponlist']){
			foreach($_VArray['couponlist'] as $v){?>
				<div class="nav-coupon-list">
					<div class="t-coupon-item-price float_left font_orange coupon_border_right_orange"><span>¥</span><?php echo floor($v['amount']);?></div>
					<div class="t-coupon-item-des">
						<p class="t-des-txt1"><?php echo $v['name'];?></p>
						<p class="t-des-txt2"><?php if($v['type']=='1'){echo $v['min_loan']."元以上借款可以使用";}elseif($v['type']=='2'){echo $v['min_loan']."元以上借款,借款天数最少".$v['min_day'].'天';}elseif($v['type']=='3'){echo '手续费金额满'.$v['full_cut'].'才可以使用';}?></p>
						<p class="t-des-txt3">请于<?php echo date("Y-m-d",$v['expire_time']);?>前使用</p>
					</div>
				</div>
			<?php }}else{?>
			<div style="text-align: center;line-height:40">
				<?php echo HTML::image('static/images/icon_meiyoujuan.png',array('style'=>'width:4rem;'));?>
			</div>
		<?php }?>
</section>
<section class="section display_none t-tab-on">
	<!--优惠券 已使用状态 增加 t-tag-used 样式 已过期状态 增加 t-expire 样式 -->
	<?php
	if($_VArray['couponlastlist']){
		foreach($_VArray['couponlastlist'] as $v){?>
			<div class="nav-coupon-list-old">
				<div class="t-coupon-item-price float_left font_gray coupon_border_right_orange"><span>¥</span><?php echo floor($v['amount']);?></div>
				<div class="t-coupon-item-des">
					<p class="t-des-txt1"><?php echo $v['name'];?></p>
					<p class="t-des-txt2"><?php if($v['type']=='1'){echo $v['min_loan']."元以上借款可以使用";}elseif($v['type']=='2'){echo $v['min_loan']."元以上借款,借款天数最少".$v['min_day'].'天';}elseif($v['type']=='3'){echo '手续费金额满'.$v['full_cut'].'才可以使用';}?></p>
					<p class="t-des-txt3">请于<?php echo date("Y-m-d",$v['expire_time']);?>前使用</p>
					<?php if(isset($v['img'])){
						echo '<img src='.$v['img'].'>';
					 } ?>
				</div>
			</div>
		<?php }}else{?>
		<div style="text-align: center;line-height:40">
			<?php echo HTML::image('static/images/icon_meiyoujuan.png',array('style'=>'width:4rem;'));?>
		</div>
	<?php }?>
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
