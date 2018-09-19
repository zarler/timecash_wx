<?php include Kohana::find_file('views', 'public/head');?>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>登录<a href="<?php echo URL::site('/Register/Index') ?>" class="t-re">注册</a></div>
</section>
<section class="t-login-center">
	<p class="t-login-center-1 t-bt1px">
		<?php echo Form::input('phone','',array('class'=>'form-control','placeholder'=>'请输入您的手机号'));?>
		<span class="t-icon-close"></span> </p>
	<p class="t-login-center-1">
		<?php echo Form::password('password','',array('class'=>'form-control','placeholder'=>'请输入您的登录密码'));?>

		<span class="t-icon-close"></span> </p>
</section>
<p class="t-login1"><a href="<?php echo URL::site('/Login/BackPwd') ?>">忘记密码？</a></p>
<section class="t-login-footer">
	<p class="t-error"></p>
	<input type="submit" class="t-red-btn t-login-button" value="登录"><br><br>
<!---->
<!--	<input type="submit" class="t-red-btn" value="登录"><br><br>-->
</section>
</body>
<script type="text/javascript">
	var dologinurl='<?php echo URL::site('Functions/dologin'); ?>';
	var dooutloginurl='<?php echo URL::site('Functions/dooutlogin'); ?>';
</script>
</html>
<?php  echo HTML::script('static/js/loginforms.js?11121111'); ?>
