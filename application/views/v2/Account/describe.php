<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.config({
		vars: {
            url:'<?php echo $_VArray['requestUrl'];?>'
		}
	});
	seajs.use('js/v2/seajs/describe');
</script>
<body>
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a class="return_i i_public" href="<?php echo $_VArray['url']?>"></a>借款记录
	</div>
</section>
<div class="top_height"></div>
<section class="rapidly_loan_ban">
	<p class="t-loan" style="color: #555555;line-height:1.3rem"><?php echo $_VArray['currentOrder']['statusOrder'];?></p>
</section>
<section class="index_menu" style="margin-top:0;margin-bottom: 1rem">
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款人姓名</span><label class="float_right"><?php echo $_VArray['currentOrder']['name'];?></label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">手机号</span><label class="float_right"><?php echo $_VArray['currentOrder']['mobile'];?></label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款金额</span><label class="float_right"><?php echo $_VArray['currentOrder']['loan_amount'];?>元</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款类型</span><label class="float_right"><?php if($_VArray['currentOrder']['typeBank']){echo "担保借款";}else{echo '极速贷';};?></label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款期限</span><label class="float_right"><?php echo $_VArray['currentOrder']['day'];?>天</label></p>
	<?php if($_VArray['currentOrder']['type']=='credit'){ ?>
	     <p class="t-login-center-1 border-bottom"><span class="form-control float_left">担保比例</span><label class="float_right"><?php echo $_VArray['currentOrder']['ensure_rate'];?>%</label></p>
	     <p class="t-login-center-1 border-bottom"><span class="form-control float_left">担保金额</span><label class="float_right"><?php echo $_VArray['currentOrder']['ensure_amount'];?>元</label></p>
	<?php }elseif($_VArray['currentOrder']['type']=='ensure'){ ?>
		 <p class="t-login-center-1 border-bottom"><span class="form-control float_left">担保比例</span><label class="float_right">100%</label></p>
	<?php } ?>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">手续费合计</span><label class="float_right"><?php echo $_VArray['currentOrder']['charge'];?></label></p>
	<?php echo $_VArray['order_charge_item']; ?>
	<?php echo $_VArray['order_charge_extension']; ?>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">实际放款金额</span><label class="float_right"><?php echo $_VArray['currentOrder']['payment_amount'];?>元</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">到期还款金额</span><label class="float_right"><?php echo $_VArray['currentOrder']['repayment_amount'];?>元</label></p>
	<?php if(isset($_VArray['currentOrder']['refunded_amount'])&&!empty($_VArray['currentOrder']['refunded_amount'])){ ?>
		<p class="t-login-center-1 border-bottom"><span class="form-control float_left">已还金额</span><label class="float_right"><?php echo $_VArray['currentOrder']['refunded_amount'];?>元</label></p>
	<?php } ?>
<!--	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">到期还款日</span><label class="float_right">--><?php // echo  !empty($_VArray['currentOrder']['expire_time'])?$_VArray['currentOrder']['expire_time']:'以实际放款日计算';?><!--</label></p>-->
	<p class="t-login-center-1"><span class="form-control float_left">还款银行卡</span><label class="float_right"><?php echo $_VArray['currentOrder']['bankcard_no'];?></label></p>
	<?php if($_VArray['currentOrder']['type']!='fast'){?>
		<p class="t-login-center-1 border-top"><span class="form-control float_left">担保银行卡</span><label class="float_right"><?php echo $_VArray['currentOrder']['creditcard_no'];?></label></p>
	<?php };?>
	<p class="t-login-center-1 border-top"><span class="form-control float_left">借款合同</span><a href="javascript:downloadContract(<?php echo $_VArray['currentOrder']['id'];?>);" style="color: #ff8470" class="float_right">点击查看</a></p>
</section>

<section class="index_menu" style="margin-top:0;border-bottom:none;margin-bottom: 1rem">
	<?php if(!empty($_VArray['extension'])){
		$i = 0;
		$count = count($_VArray['extension']);
		foreach ($_VArray['extension'] as $key=>$value){
			$i++;
			if($i == $count){
				echo '<p class="t-login-center-1"><span class="form-control float_left">'.(isset($value['left'])?$value['left']:null).'</span><a href="'.(isset($value['right_is_link'])?$value['right_is_link']:"javascript:;").'"><label class="float_right">'.(isset($value['right'])?$value['right']:null).'</label></a></p>';
			}else{
				echo '<p class="t-login-center-1 border-bottom"><span class="form-control float_left">'.(isset($value['left'])?$value['left']:null).'</span><a href="'.(isset($value['right_is_link'])?$value['right_is_link']:"javascript:;").'"><label class="float_right">'.(isset($value['right'])?$value['right']:null).'</label></a></p>';
			}
		}
	}
	?>
</section>
<?php include Kohana::find_file('views', 'v2/public/prompt');?>
<div style="height: 20px;width: 20px"></div>
<?php
    if(isset($_VArray['foot_button'])){
        echo $_VArray['foot_button'];
    }
?>
</body>
</html>
