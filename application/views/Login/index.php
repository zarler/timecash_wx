<?php include Kohana::find_file('views', 'public/head');?>
<body>
<script>
	seajs.config({
		vars: {
			'jumpUrl':"<?php echo $jumpUrl;?>"
		}
	});
	seajs.use('/static/js/online/loginforms');
</script>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="<?php echo $jumpUrl; ?>" class="t-return"></a>登录</div>
</section>
<section class="t-login-center">
	<p class="t-login-center-1 t-bt1px">
		<span class="t-icon-sign icon_iphone2"></span>
		<?php echo Form::input('phone','',array('class'=>'form-control','placeholder'=>'请输入您的手机号'));?>
		<span class="t-icon-close"></span> </p>
	<p class="t-login-center-1">
		<span class="t-icon-sign icon_password"></span>
		<?php echo Form::password('password','',array('class'=>'form-control','placeholder'=>'请输入您的登录密码'));?>
		<span class="t-icon-close"></span> </p>
</section>
<p class="t-login1"><a href="<?php echo URL::site('/Login/BackPwd') ?>">忘记密码？</a></p>
<section class="t-login-footer">
	<p class="t-error"></p>
	<input type="submit" class="t-red-btn t-login-button" value="登录"><br><br>
	<a href="/Register/Index"  class="t-red-btn">注册</a></br></br>

	<!---->
<!--	<input type="submit" class="t-red-btn" value="登录"><br><br>-->
</section>


</body>
<script type="text/javascript">
	var dologinurl='<?php echo URL::site('Functions/dologin'); ?>';
	var dooutloginurl='<?php echo URL::site('Functions/dooutlogin'); ?>';
</script>
</html>
