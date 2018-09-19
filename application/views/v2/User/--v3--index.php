<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.config({
		vars: {
			'userId':<?php echo (isset(Gv::$_userInfo['user_id'])&&!empty(Gv::$_userInfo['user_id']))?1:2; ?>
		}
	});
	seajs.use('js/v2/seajs/user-index');
</script>
<body>
<div class="loading_ok" style="display: none">
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<?php if(empty(Gv::$_userInfo['user_id'])){ ?>
		<a href="/Login"><span class="t_return_i"></span></a><lebal class="sign"></lebal>
	</div>
	</section>
		<?php }else{?>
			<a href="javascript:;"><span class="t_return_i" id='clickl'></span></a><lebal class="sign"></lebal>
			</div>
			</section>
		<?php
			include Kohana::find_file('views', 'v2/public/menu');
		}?>
<!-- 头信息end -->
<div style="height: 1.2rem"></div>
<div style="clear: both"></div>
<!--轮播图-->
<div class="main_visual">
	<div class="flicking_con">
		<?php echo $_VArray['signBanner']; ?>
	</div>
	<div class="main_image">
		<ul>
				<?php echo $_VArray['strBanner'] ?>
		</ul>
		<a style="display: none !important;" href="javascript:;" id="btn_prev"></a>
		<a style="display: none !important;" href="javascript:;" id="btn_next"></a>
	</div>
</div>
<?php echo $_VArray['bannerNotice']; ?>


<section class="m-information">
	<div class='kapian' style='position: relative;'>
		<div class='top'>
			<i></i>
			<label>我的订单</label>
			<?php if(isset(Gv::$_userInfo['user_id'])&&!empty(Gv::$_userInfo['user_id'])){ ?>
				<a class='float_right' href="<?php echo isset($_VArray['info']['con']['id'])?'/User/Singledescribe?id='.$_VArray['info']['con']['id']:'javascript:;' ?>">借款明细<i></i></a>
			<?php }else{?>
				<a class='float_right' href="/Login">借款明细<i></i></a>
			<?php } ?>
		</div>
		<div class="clear"></div>
		<div class="m-card-span">
			<?php switch($_VArray['info']['status']){
				case Model_Home::PAGE_TO_CLOSED;   				//强制关闭
				case Model_Home::PAGE_TO_PAID;					//已付代还
				case Model_Home::PAGE_TO_ACTREPAY_IN;			//主动还款中
				case Model_Home::PAGE_TO_OVERDUE_IN;			//订单逾期
				case Model_Home::PAGE_TO_REPAY_IN;				//扣款处理中
				case Model_Home::PAGE_TO_INIT;					//预授权确定中
				case Model_Home::PAGE_TO_GOON;					//继续借款
				case Model_Home::PAGE_TO_REPAY_SUCC;			//还款成功
				case Model_Home::PAGE_TO_PAY_IN;			//审核中
				case Model_Home::PAGE_TO_PASS;				//审核通过
				case Model_Home::PAGE_TO_PAY_SUCC;			//付款成功
				case Model_Home::PAGE_TO_READY;			//待审状态
				case Model_Home::PAGE_TO_REJECT;			//拒绝
				case Model_Home::PAGE_TO_ACTREPAY_FAIL;			//主动还款失败
				case Model_Home::PAGE_TO_DEDUCT_SUCC;			//扣款成功
				case Model_Home::PAGE_TO_DEDUCT_FAIL;			//扣款失败
				case Model_Home::PAGE_TO_OVERDUE_SUCC;			//逾期催缴成功
				case Model_Home::PAGE_TO_OVERDUE_FAIL;			//逾期催缴失败
				case Model_Home::PAGE_TO_OVERDUE_ACTREPAY_IN;			//逾期主动还款中
				case Model_Home::PAGE_TO_OVERDUE_ACTREPAY_FAIL;			//逾期主动还款失败
				case Model_Home::PAGE_TO_OVERDUE_DEDUCT_RUNNING;			//逾期扣款处理中
				case Model_Home::PAGE_TO_PREAUTH_SUCC;			//预授权还款成功
				case Model_Home::PAGE_TO_PREAUTH_FAIL;			//预授权还款失败
				case Model_Home::PAGE_TO_PREAUTH_IN;			//预授权处理
				case Model_Home::PAGE_TO_OVERDUE_DEDUCT_SUCC;			//逾期主动还款成功
				case Model_Home::PAGE_TO_REPAY_FAIL;			//付款失败
			?>
				<span class='float_left border-right-white'>¥<?php echo $_VArray['info']['con']['loan_amount'] ?><br><small>本次借款</small></span>
				<span class='float_left'><?php echo $_VArray['info']['con']['day'] ?>天<br><small>借款时间</small></span>
				</div>
				<div class="clear"></div>
				<div class='status'><?php echo $_VArray['info']['statustext'];?></div>
			<?php
					break;
				case  Model_Home::PAGE_TO_LOGIN;   				//未登录
				case  Model_Home::NEW_USER_NO_BORROW;   		//新注册用户
				case Model_Home::PAGE_TO_LEND_MONEY;			//还没有借款记录
				case Model_Home::PAGE_TO_FORBID;			//还没有借款记录
				case Model_Home::PAGE_TO_CREDIT_BASE_FALSE;			//还没有借款记录
			?>
				<span class='float_left border-right-white'>── ──<br><small>本次借款</small></span>
				<span class='float_left'>── ──<br><small>借款时间</small></span>
				</div>
				<div class="clear"></div>
				<div class='status'><?php echo $_VArray['info']['statustext'];?></div>
			<?php
					break;
				default;
					break;
			} ?>
		</div>
	<!--  <div class='status'>审核中</div> -->
</section>


<?php if(isset($_VArray['product_list'])&&Valid::not_empty($_VArray['product_list'])){foreach ($_VArray['product_list'] as $key=>$val){?>
    <section class="index_menu">
        <div style='padding:.6rem 1rem;'>
            <i class='down_guarantee_i'></i>
            <label><?php echo $val['name'] ?><span class='float_right'><?php echo $val['summary'] ?></span></label>
        </div>
        <div class='index_menu_b border-top' style='padding:1rem 0;'>
            <span class='float_left'><?php echo $val['amount'].$val['amount_unit']; ?><br><small style='color:#8e949b'><?php echo $val['amount_title']; ?></small></span>
            <span class='float_left'><?php echo $val['time'].$val['time_unit'];?><br><small style='color:#8e949b'><?php echo $val['time_title'] ?></small></span>
            <?php if($val['button']['enable']==1){if($val['type']=='loan'){ ?>
                <a href="<?php echo $_VArray['product_list']['jumpUrlBorrow'] ?>"><span class='float_right spok'><?php echo $val['button']['title'] ?></span></a>
            <?php }elseif($val['type']=='repay'){ ?>
                <a href="/Repaymoney"><span class='float_right spok'><?php echo $val['button']['title'] ?></span></a>
            <?php }}else{ ?>
                <a href="javascript:;"><span class='float_right sp b_disabled'><?php echo $val['button']['title'] ?></span></a>
            <?php } ?>
        </div>
    </section>

<?php }}?>


<!---->
<section class="index_menu">
	<div style='padding:.6rem 1rem;'>
		<i class='down_guarantee_i'></i>
		<label>担保借款<span class='float_right'><?php echo $_VArray['listInfo']['guarantee']['summary'] ?></span></label>
	</div>
	<div class='index_menu_b border-top' style='padding:1rem 0;'>
		<span class='float_left'><?php echo $_VArray['listInfo']['guarantee']['amount'].$_VArray['listInfo']['guarantee']['amount_unit'] ?><br><small style='color:#8e949b'><?php echo $_VArray['listInfo']['guarantee']['amount_title'] ?></small></span>
		<span class='float_left'><?php echo $_VArray['listInfo']['guarantee']['time'].$_VArray['listInfo']['guarantee']['time_unit'] ?><br><small style='color:#8e949b'><?php echo $_VArray['listInfo']['guarantee']['time_title'] ?></small></span>
		<?php if($_VArray['listInfo']['guarantee']['button']['enable']==1){
		    if($_VArray['listInfo']['guarantee']['button']['type']=='loan'){ ?>
			<a href="<?php echo $_VArray['jumpUrlBorrow'] ?>"><span class='float_right spok'><?php echo $_VArray['listInfo']['guarantee']['button']['title'] ?></span></a>
		<?php }elseif($_VArray['listInfo']['guarantee']['button']['type']=='repay'){ ?>
			<a href="/Repaymoney"><span class='float_right spok'><?php echo $_VArray['listInfo']['guarantee']['button']['title'] ?></span></a>
		<?php }}else{ ?>
			<a href="javascript:;"><span class='float_right sp b_disabled'><?php echo $_VArray['listInfo']['guarantee']['button']['title'] ?></span></a>
		<?php } ?>
	</div>
</section>



<!--<section class="index_menu">-->
<!--	<div style='padding:.6rem 1rem;'>-->
<!--		<i class='extreme_credit_i'></i>-->
<!--		<label>极速贷<span class='float_right'>--><?php //echo $_VArray['listInfo']['extreme']['summary'] ?><!--</span></label>-->
<!--	</div>-->
<!--	<div class='index_menu_b border-top' style='padding:1rem 0;'>-->
<!--		<span class='float_left'>--><?php //echo $_VArray['listInfo']['extreme']['amount'].$_VArray['listInfo']['extreme']['amount_unit'] ?><!--<br><small style='color:#8e949b'>--><?php //echo $_VArray['listInfo']['extreme']['amount_title'] ?><!--</small></span>-->
<!--		<span class='float_left'>--><?php //echo $_VArray['listInfo']['extreme']['time'].$_VArray['listInfo']['extreme']['time_unit'] ?><!--<br><small style='color:#8e949b'>--><?php //echo $_VArray['listInfo']['extreme']['time_title'] ?><!--</small></span>-->
<!--		--><?php //if($_VArray['listInfo']['extreme']['button']['enable']==1){if($_VArray['listInfo']['extreme']['button']['type']=='loan'){ ?>
<!--			<a href="--><?php //echo $_VArray['jumpUrlEx'] ?><!--"><span class='float_right spok'>--><?php //echo $_VArray['listInfo']['extreme']['button']['title'] ?><!--</span></a>-->
<!--		--><?php //}elseif($_VArray['listInfo']['extreme']['button']['type']=='repay'){ ?>
<!--			<a href="/Repaymoney"><span class='float_right spok'>--><?php //echo $_VArray['listInfo']['extreme']['button']['title'] ?><!--</span></a>-->
<!--		--><?php //}}else{ ?>
<!--			<a href="javascript:;"><span class='float_right sp b_disabled'>--><?php //echo $_VArray['listInfo']['extreme']['button']['title'] ?><!--</span></a>-->
<!--		--><?php //} ?>
<!--	</div>-->
<!--</section>-->

<!--<section class="t-banner">-->
<!--		--><?php //if(!empty($banner)){foreach ($banner as $key=>$val){
//			echo '<a href='.$val['target'].'><img src='.$val['img'].'></a>';
//		}} ?>
<!--</section>-->
<div class="top_height"></div>
</div>
</body>
</html>