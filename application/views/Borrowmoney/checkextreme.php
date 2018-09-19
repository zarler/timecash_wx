<?php include Kohana::find_file('views', 'public/head');?>
<script>
	<?php if($startExtreme){?>
		seajs.config({
			vars: {
				'url': '/Functions/checkSubmit'
			}
		});
		seajs.use('js/seajs/borrowmoney-checkextreme');
	<?php }else{ ?>
	 $(function () {
		 $(".t-red-btn").click(function(){
			 prompt_show();
		 });
	 });
	function prompt_hide(){
		$('.t-mask').hide();
		$('#t-bomb_box_prompt').hide();
	};
	function prompt_show(){
		$('.t-mask').show();
		$('#t-bomb_box_prompt').show();
	}
	<?php }?>
</script>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>立即借款</div>
</section>
<p class="t-loan"><span class="t-line"></span><em>核对借款信息</em><span></span></p>
<section class="t-login-center t-mt0px">
		<p class="t-login-center-1 t-bt1px">借款人姓名<span class="t-loan1"><?php echo $name;?></span></p>
		<p class="t-login-center-1 t-bt1px">手机号<span class="t-loan1"><?php echo $mobile;?></span></p>
		<p class="t-login-center-1 t-bt1px">借款金额<span class="t-loan1"><?php echo $personal['loan_amount'];?>元</span></p>
		<p class="t-login-center-1 t-bt1px">借款类型<span class="t-loan1">极速贷</span></p>
		<p class="t-login-center-1 t-bt1px">借款期限<span class="t-loan1"><?php echo $personal['day'];?>天</span</p>
		<p class="t-login-center-1 t-bt1px">借款手续费<span class="t-loan1"><?php echo $personal['charge'];?>元</span</p>
		<p class="t-login-center-1 t-bt1px">优惠券抵扣<span class="t-loan1"><?php echo $personal['coupon_amount'];?>元</span</p>
		<p class="t-login-center-1 t-bt1px">实际放款金额<span class="t-loan1"><?php echo $personal['payment_amount'];?>元</span></p>
		<p class="t-login-center-1 t-bt1px">到期还款金额<span class="t-loan1"><?php echo $personal['loan_amount'];?>元</span></p>
		<p class="t-login-center-1 t-bt1px">预计到期还款日<span class="t-loan1">以实际放款日计算<?php //echo date('Y-m-d',time()+ (86400*$personal['day']));?></span></p>
	    <p class="t-login-center-1">还款银行卡<span class="t-loan1"><?php echo $personal['bankcard_no'];?></span></p>
</section>
<div class="t-mask" style="display: none"></div>
<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box_prompt" style="display: none;">
	<h3 class="t-bomb_box-1" style="border-bottom:1px solid #e5e5e5">提示<a href="javascript:prompt_hide();" class="t-close-btn"></a></h3>
	<p class="t-bomb_box-6" id="t-bomb_box-6" style="line-height: 2rem;font-size: 0.85rem;height:6rem;overflow-y:visible;overflow-x:visible;padding:15px 16px 5px 16px">
		<?php if(isset($prompt)){echo $prompt;} ?>
	</p>
	<div  class="t-red">
		<a href="javascript:prompt_hide();" class="t-red-btn">确定</a>
	</div>
</div>
<?php include Kohana::find_file('views', 'public/prompt');?>
<section class="t-login-footer">	
	<p class="t-register1"><input type="checkbox" checked="checked" id="checkbox_a1" class="chk_1" /><label for="checkbox_a1"></label>同意<a href="<?php echo URL::site('Protocol/conten?num=2'); ?>">《借款服务协议》</a><a href="<?php echo URL::site('Protocol/conten?num=3'); ?>">《借款协议》</a></p>
	<p class="t-error"></p>
	<input type="submit" class="t-red-btn" value="提交借款申请">
</section>
</body>
</html>