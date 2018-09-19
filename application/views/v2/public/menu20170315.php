<nav class="main-menu" style="display: none;">
	<div class="settings">
			<img class="float_left" style="display: none;" src="<?php echo empty($userinfo['headimgurl'])?'/static/images/v2/icon-Avatar.png':$userinfo['headimgurl']?>">
			<span><?php echo empty($userinfo['name'])?(empty($userinfo['wechat_username'])?'用户名':$userinfo['wechat_username']):$userinfo['name'] ?><br>
				<small><?php echo isset($mobile)?$mobile:'' ?></small>
			</span>
	</div>
	<ul>
		<li>
			<a href="/Account/BorrowingRecords">
				<i class="fa record_icon_i"></i>
				<span class="nav-text">借款记录</span>
			</a>
		</li>
		<li>
			<a href="/Account/Promote">
				<i class="fa creditgranting_icon_i"></i>
                <span class="nav-text">授信管理<label class="nav-text-two">申请降担保</label></span>
			</a>
		</li>
		<li>
			<?php if($userinfo['credited']){ ?>
			<a href="/Account/bankCreditList">
				<i class="fa card_icon_i"></i>
                <span class="nav-text">银行卡管理</span>
			</a>
			<?php }else{?>
				<a href="javascript:commonUtil.showconfirm('请先下载APP完成基础授信','下载APP')">
					<i class="fa card_icon_i"></i>
					<span class="nav-text">银行卡管理</span>
				</a>
			<?php } ?>
		</li>
		<li>
			<a href="/Coupon/coupon">
				<i class="fa coupon_icon_i"></i>
                <span class="nav-text">优惠券</span>
			</a>
		</li>
		<li>
			<a href="/Protocol/Problem">
				<i class="fa question_icon_i"></i>
                <span class="nav-text">问题与帮助</span>
			</a>
		</li>
		<li>
			<a href="/Login/BackPwd">
				<i class="fa changePassword_icon_i"></i>
				<span class="nav-text">修改密码</span>
			</a>
		</li>
<!--		<li>-->
<!--			<a href="#">-->
<!--				<i class="fa quit_icon_i"></i>-->
<!--                <span class="nav-text">退出当前账号</span>-->
<!--			</a>-->
<!--		</li>-->
	</ul>
	<section class="menu_footer">
		<div><a href="tel:4006067571">联系客服</a></div>
		<div>400-606-7571</div>
	</section>
</nav>
<script>
	seajs.use('js/v2/menu');
	$(window).load(function(){
		$("#clickl").click(function(){
			$(".main-menu").addClass("block");
		})
		$(function() {
			$('.main-menu').simplerSidebar({
				opener: '#toggle-sidebar',
				sidebar: {
					align: 'left',
					width: 500,
				}
			});
		});
		
		$(".settings img").show();
		$(".main-menu").show();
	});
</script>

