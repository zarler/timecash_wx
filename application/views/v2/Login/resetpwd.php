<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.config({
		vars:{
            'resetpwdurl':"<?php echo URL::site('/wx/Functions/doresetpwd');?>",
		}
	});
	seajs.use('js/v2/seajs/loginforms');
</script>
<body>
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a class="return_i i_public" href="javascript:history.go(-1);"></a>修改密码
	</div>
</section>
<div class="top_height"></div>
<section class="t-login-center">
	<p class="t-login-center-1 border-bottom">
		<span class="t-icon-sign icon-cipher"></span>
		<?php echo Form::password('password','',array('class'=>'form-control text_width_70','placeholder'=>'设置您的新登录密码'));?>
		<span class="t-icon-close"></span></p>
	<p class="t-login-center-1">
		<span class="t-icon-sign icon-cipher"></span>
		<?php echo Form::password('passwordrepeat','',array('class'=>'form-control text_width_70','placeholder'=>'重复输入新登录密码'));?>
		<span class="t-icon-close"></span></p>
</section>
<section class="t-login-footer">
	<p class="t-error"></p>
	<input type="submit" class="t-orange-btn button_submit t-register-button resetpwd_submit" value="确定">
</section>
<div class="t-box_alert" id="t-bomb_box_prompt" style="display: none">
	<div class="t-mask-reset"></div>
	<div class="t-bomb_box" id="t-bomb_box">
		<h3 class="t-bomb_box-1">密码找回成功，请重新登录</h3>
		<a class="t-orange-btn" href="<?php echo URL::site('/Login/Index') ?>">确定</a>
	</div>
</div>
<div class="t-mask" style="display: none"></div>
</body>
</html>