<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	<?php if($startExtreme){?>
		seajs.config({
			vars: {
				'url': '/FunctionsH5/checkSubmit'
			}
		});
		seajs.use('js/v2/seajs/borrowmoney-checkextremeH5');
	<?php }else{ ?>
		 $(function () {
			 $(".button_submit").click(function(){
				 var lay = layer.alert('<?php echo $prompt ?>', {
					 skin: 'layui-layer-molv' //样式类名
					 ,closeBtn: 0
				 }, function(){
					 layer.close(lay);
				 });
				 commonUtil.revisecss();
			 });
		 });
	<?php }?>

</script>
<body>
<!--<section class="rapidly_loan_ban">-->
<!--	<p class="t-loan" style="color: white;line-height:1.3rem">核对借款信息</p>-->
<!--</section>-->

<section class="index_menu" style="margin-top:0;border-bottom:none;margin-bottom: 1rem">
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款人姓名</span><label class="float_right"><?php echo $name;?></label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">手机号</span><label class="float_right"><?php echo $mobile;?></label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款金额</span><label class="float_right"><?php echo $personal['loan_amount'];?>元</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款类型</span><label class="float_right">极速贷</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款期限</span><label class="float_right"><?php echo $personal['day'];?>天</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">借款手续费</span><label class="float_right"><?php echo $personal['charge'];?>元</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">优惠券抵扣</span><label class="float_right"><?php echo $personal['coupon_amount'];?>元</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">实际放款金额</span><label class="float_right"><?php echo $personal['payment_amount'];?>元</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">到期还款金额</span><label class="float_right"><?php echo $personal['loan_amount'];?>元</label></p>
	<p class="t-login-center-1 border-bottom"><span class="form-control float_left">预计到期还款日</span><label class="float_right">以实际放款日计算</label></p>
	<p class="t-login-center-1"><span class="form-control float_left">还款银行卡</span><label class="float_right"><?php echo $personal['bankcard_no'];?></label></p>
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
<?php include Kohana::find_file('views', 'v2/public/prompt');?>
<section class="t-login-footer">
	<p class="t-error"></p>
	<p class="t-register1"><input type="checkbox" id="checkbox_a1"  style="display:none;" class="chk_1"/><label for="checkbox_a1" class="checkbox_a1"></label>同意<a href="<?php echo URL::site('Protocol/conten?num=2'); ?>">《借款服务协议》</a><a href="<?php echo URL::site('Protocol/conten?num=3&&type='.$personal['type']); ?>">《借款协议》</a></p>
	<input type="submit" class="t-orange-btn button_submit" value="提交借款申请"><br><br>
</section>
</body>
</html>