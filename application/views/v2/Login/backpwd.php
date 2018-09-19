<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.config({
		vars: {
			'sendcodeurl':"<?php echo URL::site('/wx/Functions/sendcode');?>",
			'dobackpwdurl':"<?php echo URL::site('/wx/Functions/dobackpwd');?>"
		}
	});
	seajs.use('js/v2/seajs/loginforms');
</script>
<body>
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a class="return_i i_public" href="javascript:;"></a>验证手机号
	</div>
</section>
<div class="top_height"></div>
<section class="index_menu" style="margin-top:0">
	<p class="t-login-center-1 border-bottom">
		<span class="t-icon-sign icon_iphone2"></span>
		<input  <?php echo empty($_VArray['mobile'])?'':'disabled="true"' ?> type="text" name="reg_phone" value="<?php echo empty($_VArray['mobile'])?'':$_VArray['mobile'] ?>" class="form-control" placeholder="请输入您的手机号"><span class="t-icon-close">
		</span></p>
	<p class="t-login-center-1">
		<span class="t-icon-sign icon_password"></span>
		<input type="text" name="authcode" value="" class="t-w240px form-control" placeholder="请输入验证码"><span class="t-icon-close t-mr"></span>
		<button type="button" class="t-pwd-code">获取验证码</button></p>
</section>
<section class="t-login-footer">
	<p class="t-error"></p>
	<input type="submit" class="t-orange-btn button_submit t-register-button button_backpwd" value="下一步"><br><br>
</section>
<div class="t-mask" style="display: none"></div>
</body>
</html>
