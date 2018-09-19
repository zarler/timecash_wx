<?php include Kohana::find_file('views', 'public/head');?>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>借款记录</div>
</section>
<p class="t-loan t-color-orange"><?php echo $describe['info']['statustext'];?></p>
<section class="t-login-center t-mt0px">
	<p class="t-login-center-1 t-bt1px">借款人姓名<span class="t-loan1"><?php echo $describe['info']['con']['name'];?></span></p>
	<p class="t-login-center-1 t-bt1px">手机号<span class="t-loan1"><?php echo $describe['info']['con']['mobile'];?></span></p>
	<p class="t-login-center-1 t-bt1px">借款金额<span class="t-loan1"><?php echo $describe['info']['con']['loan_amount'];?>元</span></p>
	<p class="t-login-center-1 t-bt1px">借款类型<span class="t-loan1"><?php if($describe['info']['con']['type']){echo "担保借款";}else{echo '极速贷';};?></span</p>
	<p class="t-login-center-1 t-bt1px">借款期限<span class="t-loan1"><?php echo $describe['info']['con']['day'];?>天</span</p>
	<?php if($describe['info']['con']['type']=='credit'){ ?>
	<p class="t-login-center-1 t-bt1px">担保比例<span class="t-loan1"><?php echo $describe['userinfo']['ensure_rate'];?>%</span</p>
	<p class="t-login-center-1 t-bt1px">担保金额<span class="t-loan1"><?php echo $describe['info']['con']['ensure_amount'];?>元</span</p>
	<?php } ?>
	<p class="t-login-center-1 t-bt1px">借款手续费<span class="t-loan1"><?php echo $order_charge['amount'];?>元</span</p>
		<p class="t-login-center-1 t-bt1px">优惠券抵扣<span class="t-loan1"><?php echo $order_charge_coupon['amount'];?>元</span</p>
	<p class="t-login-center-1 t-bt1px">实际放款金额<span class="t-loan1"><?php echo $describe['info']['con']['payment_amount'];?>元</span></p>
	<p class="t-login-center-1 t-bt1px">到期还款金额<span class="t-loan1"><?php echo (int)$describe['info']['con']['repayment_amount'];?>元</span></p>
	<?php if(isset($describe['info']['con']['refunded_amount'])&&!empty($describe['info']['con']['refunded_amount'])){ ?>
		<p class="t-login-center-1 t-bt1px">已还金额<span class="t-loan1"><?php echo $describe['info']['con']['refunded_amount'];?>元</span></p>
	<?php } ?>
	<p class="t-login-center-1 t-bt1px">到期还款日<span class="t-loan1"><?php  echo  !empty($describe['info']['con']['expire_time'])?$describe['info']['con']['expire_time']:'以实际放款日计算';?></span></p>
	<p class="t-login-center-1">还款银行卡<span class="t-loan1"><?php echo $describe['info']['con']['bankcard_no'];?></span></p>
	<?php if($describe['info']['con']['typeBank']){?>
		<p class="t-login-center-1" style="border-top:1px solid #e0e0e0">担保银行卡<span class="t-loan1"><?php echo $describe['info']['con']['creditcard_no'];?></span></p>
	<?php };?>
</section>
<?php include Kohana::find_file('views', 'public/prompt');?>
<div style="height: 20px;width: 20px"></div>
</body>
</html>
