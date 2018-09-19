<?php include Kohana::find_file('views', 'v2/public/head');
	if(!empty($_VArray['ban']) && $_VArray['ban'] == '1'){
		echo HTML::script('static/js/lockPhoneBackBtn.js');
	} 
?>
<script>
	seajs.config({
		vars: {
			'durl':'<?php echo $_VArray['requestUrl'];?>',
//			'url':'/Functions/SubmitReduceApply',
			'jumpurl':'<?php echo isset($_VArray['entrance'])?$_VArray['entrance']: URL::site('Borrowmoney/guarantee');?>',
		}
	});
	seajs.use('js/v2/seajs/borrowmoney-guaranteeadd');
</script>
<body>
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<?php if(!empty($_VArray['ban']) && $_VArray['ban'] == '1'){ echo '<a href="'.URL::site('User/index').'" class="return_i i_public"></a>';}else{echo '<a href="javascript:history.go(-1);" class="return_i i_public"></a>';}?>添加担保卡
		<?php if(!isset($_VArray['entrance'])){?>
			<span style="margin-right: 0.2rem"><a href="javascript:commonUtil.showpublic('如果您没有信用卡，建议您申请无需信用卡担保的极速贷','去极速贷','/Borrowmoney/extremeBorrow?jump=guaranteeadd');commonUtil.revisecss()" id="show-rules"> <i class="problem_i"></i>没有信用卡怎么办</a></span>
		<?php }?>
	</div>
</section>
<div class="top_height"></div>
<?php include Kohana::find_file('views', 'v2/public/credit');?>
<?php if(!isset($_VArray['entrance'])){ ?>
	<section class="m-webbox">
		<div class="m-lineblock" style="border-bottom:none">
			<label>预授权金额</label><span style="font-size: .8rem"><?php echo $_VArray['amount'];?>元</span>
		</div>
	</section>
<?php } ?>
<section class="index_menu" style="margin-top:1rem">
	<p class="t-login-center-1 border-bottom">
		<input type="text" placeholder="信用卡号码" class="form-control text_width_70" name="card_no"><span class="t-icon-close"></span>
	</p>
	<!--<p class="t-login-center-1 t-bt1px"><input type="text" placeholder="有效期（月）" class="form-control" name="expire_month" style="width:40%" > / <input type="text" placeholder="有效期（年）" class="form-control" name="expire_yeah" style="width:40%" ><span class="t-icon-close"></span></p>-->
	<p class="t-login-center-1 border-bottom"><span class="form-label">有效期</span>
		<input type="text" placeholder="" style="width:30%" class="form-control form-time" name="expire_month" ><span class="t-icon-close"></span><span class="form-label">月</span>
		<input type="text" placeholder="" style="width:30%" class="form-control form-time" name="expire_yeah"><span class="t-icon-close"></span><span class="form-label">年</span>
	</p>
	<p class="t-login-center-1 border-bottom">
		<input type="text" placeholder="安全码CVV2/CVC2" class="form-control text_width_70" name="security_code"><span class="t-icon-close"></span>
	</p>
	<p class="t-login-center-1">
		<input type="text" name="phone" value="<?php echo $_VArray['mobile'];?>" class="form-control text_width_70" disabled="1"  placeholder="请输入您的手机号"><span class="t-icon-close"></span>
	</p>
<!--	<p class="t-login-center-1">-->
<!--		<input type="text" name="authcode" value="" class="t-w240px form-control text_width_70" placeholder="请输入验证码">     <span class="t-icon-close t-mr"></span><button type="button" class="t-pwd-code">获取验证码</button></p>-->
	<!--
    <p class="t-login-center-1"><input type="text" placeholder="短信验证码" class="t-w240px form-control"><span class="t-icon-close t-mr"></span> <span class="t-pwd-code">获取验证码</span></p>-->
</section>
<section class="t-login-footer">	
	<p class="t-error"></p>
	<input type="submit" class="t-orange-btn button_submit button_bank" value="下一步">
</section>
<!-- 弹窗-提示 -->
<div class="t-box_alert" id="t-box_alert" style="display:none;">
	<div class="t-bomb_box" id="t-bomb_box">
		<h3 class="t-bomb_box-1">提示</h3>
		<div class="t-bomb_box-3">
			<p>信用卡验证失败，请检查您提交的信息是否正确</p>
		</div>
	   <div class="t-bomb_btn"><input type="button" class="t-red-btn" value="确定"></div>
	</div>
</div>
<div class="t-mask" style="display: none"></div>
</body>
</html>
