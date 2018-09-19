<section class="m-nav">
	<ul>
		<?php if($controller=='User'){ ?>
	<li class="checked">
	<?php }else{?>
		<li>
			<?php }?>
			<a href="<?php echo URL::site('User/Index'); ?>">
				<i class="icon1"></i>
				<p>立即借款</p>
			</a>
		</li>
		<?php if($controller=='Coupon'){ ?>
	<li class="checked">
	<?php }else{?>
		<li>
			<?php }?>
			<a href="<?php echo URL::site('Coupon/coupon'); ?>">
				<i class="icon2"></i>
				<p>优惠券</p>
			</a>
		</li>
		<?php if($controller=='Account'){ ?>
		<li class="checked">
			<?php }else{?>
		<li>
			<?php }?>
			<a href="<?php echo URL::site('Account/index'); ?>">
				<i class="icon3"></i>
				<p>我的快金</p>
			</a>
		</li>
	</ul>
</section>
<script>seajs.use('js/seajs/public-menu');</script>
