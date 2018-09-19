<?php include Kohana::find_file('views','public/head');?>
<?php echo HTML::style('static/css/rangeslider.css?123'); ?>
<script>
	seajs.config({
		vars: {
			'last_id':<?php echo isset($last_id)?$last_id:1;  ?>,
			'total':<?php echo isset($total_coupon)?$total_coupon:1;  ?>

		}
	});
	seajs.use('js/seajs/coupon');
</script>
	<body>
<!--	<section class="t-login-nav">-->
<!--		<div class="t-login-nav-1">优惠券</div>-->
<!--	</section>-->
		<article>
			<ul class="t-tab">
				<li class="t-tab-cur"><a href="javascript:changeTrue()">可使用</a> </li>
				<li><a href="javascript:changeFalse()">历史记录</a></li>
			</ul>
			<p class="t-rules"><?php echo HTML::image('static/images/t-cash-question.png');?> <a href="javascript:;" id="show-rules"> 使用规则</a></p>
			<section class="section">
				<!--优惠券正常状态 -->
				<?php
				if($couponlist){
				foreach($couponlist as $v){?>
				<div class="t-coupon-card hidden">
					<div class="t-coupon-card-tb">
						<div class="t-coupon-card-bg"></div>
					</div>
					<div class="t-coupon-card-list">
						<div class="t-coupon-item-price"><span>¥</span><?php echo floor($v['amount']);?></div>
						<div class="t-coupon-item-des">
							<p class="t-des-txt1"><?php echo $v['name'];?></p>
							<p class="t-des-txt2"><?php if($v['type']=='1'){echo $v['min_loan']."元以上借款可以使用";}elseif($v['type']=='2'){echo $v['min_loan']."元以上借款,借款天数最少".$v['min_day'].'天';}elseif($v['type']=='3'){echo '手续费金额满'.$v['full_cut'].'才可以使用';}?></p>
							<p class="t-des-txt3">请于<?php echo date("Y-m-d",$v['expire_time']);?>前使用</p>
						</div>
					</div>
				</div>
				<?php }}else{?>
					<div style="text-align: center;line-height:40">
						<?php echo HTML::image('static/images/icon_meiyoujuan.png',array('style'=>'width:4rem;'));?>
					</div>
				<?php }?>
			</section>
			<section class="section t-tab-on">
				<!--优惠券 已使用状态 增加 t-tag-used 样式 已过期状态 增加 t-expire 样式 -->
				<?php
				if($couponlastlist){
					foreach($couponlastlist as $v){?>
						<div class="t-coupon-card hidden">
							<div class="t-coupon-card-tb">
								<div class="t-coupon-card-bg"></div>
							</div>
							<div class="t-coupon-card-list">
								<div class="t-coupon-item-price"><span>¥</span><?php echo floor($v['amount']);?></div>
								<div class="t-coupon-item-des">
									<p class="t-des-txt1"><?php echo $v['name'];?></p>
									<p class="t-des-txt2"><?php if($v['type']=='1'){echo $v['min_loan']."元以上借款可以使用";}elseif($v['type']=='2'){echo $v['min_loan']."元以上借款,借款天数最少".$v['min_day'].'天';}elseif($v['type']=='3'){echo '手续费金额满'.$v['full_cut'].'才可以使用';}?></p>
									<p class="t-des-txt3">请于<?php echo date("Y-m-d",$v['expire_time']);?>前使用</p>
								</div>
							</div>
						</div>
					<?php }}else{?>
					<div style="text-align: center;line-height:40">
						<?php echo HTML::image('static/images/icon_meiyoujuan.png',array('style'=>'width:4rem;'));?>
					</div>
				<?php }?>
			</section>
			<div style="width:100%;height: 2.45rem"></div>
			<!--优惠券弹层 -->
			<div class="t-box_alert" id="t-box_alert" style="display: none;">
				<div class="t-mask"></div>
				<div class="t-bomb_box" id="t-bomb_box">
					<h3 class="t-bomb_box-1 t-title">使用规则<a href="javascript:;" class="t-close-btn"></a> </h3>
					<ul class="t-rules-item">
						<li><span>•</span><p>用户在借款达到一定额度时,可以使用符合借款额度的优惠券,按面值抵扣借款手续费</p></li>
						<li><span>•</span><p>每一笔借款只能使用1张优惠券</p></li>
						<li><span>•</span><p>优惠券有效期过期后不可再使用</p></li>
						<li><span>•</span><p>每张优惠券不可重复使用,不可找零或兑现</p></li>
					</ul>
				</div>
			</div>
			<?php include Kohana::find_file('views', 'public/menu');?>
		</article>
	</body>

</html>
