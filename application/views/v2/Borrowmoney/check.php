<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.use('js/v2/seajs/borrowmoney-check');
</script>
<body>
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a class="return_i i_public" href="javascript:history.go(-1);"></a>核对借款信息
	</div>
</section>
<div class="top_height"></div>
<!--<section class="rapidly_loan_ban">-->
<!--	<p class="t-loan" style="color: white;line-height:1.3rem">核对借款信息</p>-->
<!--</section>-->
<?php echo Form::open('Borrowmoney/skip', array('id'=>'checkForm')); ?>
<section class="index_menu" style="margin-top:0;border-bottom:none;margin-bottom:1rem;">
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款人姓名</span><label class="float_right"><?php echo $_VArray['name'];?></label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">手机号</span><label class="float_right"><?php echo $_VArray['mobile'];?></label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款金额</span><label class="float_right"><?php echo $_VArray['personal']['loan_amount'];?>元</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款类型</span><label class="float_right">担保借款</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款期限</span><label class="float_right"><?php echo $_VArray['personal']['day'];?>天</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">担保比例</span><label class="float_right"><?php echo $_VArray['personal']['ensure_rate'];?>%</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">担保金额</span><label class="float_right"><?php echo $_VArray['personal']['ensure_amount'];?>元</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">手续费合计</span><label class="float_right"><?php echo $_VArray['personal']['charge'];?></label></p>
	<?php echo $_VArray['order_charge_item'];?>
	<?php echo $_VArray['order_charge_extension'];?>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">实际放款金额</span><label class="float_right"><?php echo $_VArray['personal']['payment_amount'];?>元</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">到期还款金额</span><label class="float_right"><?php echo $_VArray['personal']['repayment_amount'];?>元</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">预计到期还款日</span><label class="float_right">以实际放款日计算</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">还款银行卡</span><label class="float_right"><?php echo $_VArray['personal']['bankcard_no'];?></label></p>
	<p class="t-login-center-1"><span class="form-control float_left">担保银行卡</span><label class="float_right"><?php echo $_VArray['personal']['creditcard_card'];?></label></p>
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
<section class="t-login-footer">
	<p class="t-error"></p>
	<p class="t-register1"><input type="checkbox" id="checkbox_a1"  style="display:none;" class="chk_1"/><label for="checkbox_a1" class="checkbox_a1"></label>同意<a href="<?php echo URL::site('Protocol/conten?num=2'); ?>">《借款服务协议》</a><a href="<?php echo URL::site('Protocol/conten?num=3&&type='.$_VArray['personal']['type']); ?>">《借款协议》</a></p>
	<input type="submit" class="t-orange-btn button_submit" value="提交借款申请"><br><br>
</section>
<?php echo Form::close();  ?>
</body>
</html>