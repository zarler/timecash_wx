<?php include Kohana::find_file('views', 'public/head');?>
<script>
	seajs.use('/static/js/online/loginforms');
</script>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>重置登录密码</div>
</section>
<section class="t-login-center">
	<p class="t-login-center-1 t-bt1px">
		<span class="t-icon-sign icon_password"></span>
		<?php echo Form::password('password','',array('class'=>'form-control','placeholder'=>'设置您的新登录密码'));?>
		<span class="t-icon-close"></span></p>
	<p class="t-login-center-1">
		<span class="t-icon-sign icon_password"></span>
		<?php echo Form::password('passwordrepeat','',array('class'=>'form-control','placeholder'=>'重复输入新登录密码'));?>
		<span class="t-icon-close"></span></p>
</section>
<section class="t-login-footer">
	<p class="t-error"></p>
	<input type="submit" class="t-red-btn resetpwd_submit" value="确定">
</section>

<div class="t-box_alert" id="t-box_alert" style="display: none">
	<div class="t-mask-reset"></div>
	<div class="t-bomb_box" id="t-bomb_box">
		<h3 class="t-bomb_box-1">密码找回成功，请重新登录</h3>
<!--		<p class="t-bomb_box-2">请使用新密码重新登录</p>-->
		<div class="t-bomb_btn"><a href="<?php echo URL::site('/Login/Index') ?>" class="t-red-btn">确定</a></div>
	</div>
</div>
</body>
</html>
<script>
	var resetpwdurl='<?php echo URL::site('Functions/doresetpwd'); ?>';
</script>
