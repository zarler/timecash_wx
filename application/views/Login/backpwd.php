<?php include Kohana::find_file('views', 'public/head');?>
<style>
	input:disabled{
		background: white;
	}
</style>
<script>
	seajs.use('/static/js/online/loginforms');
</script>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>找回密码</div>
</section>
<section class="t-login-center">
	<p class="t-login-center-1 t-bt1px">
		<span class="t-icon-sign icon_iphone2"></span>
		<?php
			if($mobile){
				echo Form::input('phone',$mobile,array('class'=>'form-control','placeholder'=>'请输入您的手机号',"disabled"=>true));
			}else{
				echo Form::input('phone','',array('class'=>'form-control','placeholder'=>'请输入您的手机号'));
			}
		?>
		<span class="t-icon-close">
		</span></p>
	<p class="t-login-center-1">
		<span class="t-icon-sign icon_password"></span>
		<?php echo Form::input('authcode','',array('class'=>'t-w240px form-control','placeholder'=>'请输入验证码'));?>
		<span class="t-icon-close t-mr"></span><button  type="button" class="t-pwd-code">获取验证码</button></p>
</section>
<section class="t-login-footer">
	<p class="t-error"></p>
	<input type="submit" class="t-red-btn button_backpwd" value="下一步"></br></br>
</section>
</body>
</html>
<script>
	var sendcodeurl='<?php echo URL::site('Functions/sendcode'); ?>';
	var dobackpwdurl='<?php echo URL::site('Functions/dobackpwd'); ?>';
</script>
