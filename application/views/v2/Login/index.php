<?php include Kohana::find_file('views', 'v2/public/head');?>
<body style="background: white">
<script>
	seajs.config({
		vars: {
			'jumpUrl':"<?php echo $_VArray['jumpUrl'];?>",
			'dologinurl':'<?php echo URL::site('/wx/Functions/dologin'); ?>',
			'dooutloginurl':'<?php echo URL::site('/wx/Functions/dooutlogin'); ?>',
			'sendcodeurl':'<?php echo URL::site('/wx/Functions/registersendcode'); ?>',
			'registerurl':'<?php echo URL::site('/wx/Functions/doregister');?>',
			'bj':'<?php echo $_VArray['bj'];?>'
		}
	});
	seajs.use('js/v2/seajs/loginforms');
</script>
<!-- 头信息 -->
<section class="t-login">
	<a href="/" style="display: block"><i class="t-sign-clock-i"></i></a>
	<i class="t-sign-login-i"></i>
	<div class="t-login-top">
		<a href="javascript:;"><span class='border-right-1px'>登录</span></a>
		<a href="javascript:;"><span>注册</span></a>
	</div>
	<div class="icon_sanjiao">
		<img class="left_icon" src="/static/images/v2/icon–sanjiao.png">
	</div>
</section>
<div style="height: .3rem"></div>
<section class="index_login section" style="margin-top:0">
	<p class="t-login-center-1 border-bottom">
		<span class="t-icon-sign icon_iphone2"></span>
		<?php echo Form::input('phone','',array('class'=>'form-control','placeholder'=>'请输入您的手机号'));?>
            <span class="t-icon-close"></span>
		</p>
	<p class="t-login-center-1 border-bottom">
		<span class="t-icon-sign icon-cipher"></span>
		<?php echo Form::password('password','',array('class'=>'form-control text_width_70','placeholder'=>'请输入您的登录密码'));?>
            <span class="t-icon-close"></span>
	</p>
	<section class="t-login-footer">
		<p class="t-error"></p>
		<input type="submit" class="t-orange-btn t-login-button button_submit" value="登录"><br><br>
	</section>
	<div class="t-login-back">
		<a href="/Login/BackPwd">找回密码</a>
	</div>
	<div class="top_height"></div>
</section>
<section class="index_register section" style="margin-top:0">
	<p class="t-login-center-1 border-bottom">
		<span class="t-icon-sign icon_iphone2"></span>
		<input type="text" name="reg_phone" value="" class="form-control" placeholder="请输入您的手机号">
            <span class="t-icon-close">
            </span>
	</p>
	<p class="t-login-center-1 border-bottom">
		<span class="t-icon-sign icon-Invitationcode"></span>
		<input type="text" name="reg_authcode" value="" class="t-w240px form-control" placeholder="请输入验证码"><span class="t-icon-close t-mr"></span><button type="button" class="t-pwd-code">获取验证码</button>
	</p>
	<p class="t-login-center-1 border-bottom">
		<span class="t-icon-sign icon-cipher"></span>
		<input type="password" name="reg_password" value="" class="form-control"  placeholder="登录密码">
            <span class="t-icon-close">
            </span>
	</p>
	<section class="t-register2 t-register-more invitation">
		<label><a href="javascript:;">填写邀请码</a></label>
		<span class="down"></span>
	</section>
	<section class="t-login-center invitationcode" style="display: none;" >
		<p class="t-login-center-1 border-bottom">
			<span class="t-icon-sign icon-Activation"></span>
			<input type="text" name="reg_invitecode" value="" class="form-control"  placeholder="邀请码（非必填项）">
            <span class="t-icon-close">
            </span>
		</p>
	</section>

	<section class="t-login-footer">
		<p class="t-error"></p>
		<p class="t-register1">
			<input type="checkbox" id="checkbox_a1"  style="display:none;" class="chk_1"/>
			<label for="checkbox_a1" class="checkbox_a1"></label>同意<a href="<?php echo URL::site('Protocol/conten?num=1'); ?>">《用户账户注册及使用协议》</a></p>
		<input type="submit" class="t-orange-btn button_submit t-register-button" value="注册"><br><br>
	</section>

</section>
<a class="t-login-help-a" href="/Protocol/Problem">问题与帮助</a>
<div class="top_height"></div>
<div class="t-mask" style="display: none"></div>
</body>
</html>
