<?php include Kohana::find_file('views', 'public/headapp');?>
<body>
<section class="t-login-nav">
    <div class="t-login-nav-1"><a href="/Login/Index" class="t-return"></a>注册<!--<a href="#" class="t-re">登录</a>--></div>
</section>
<section class="t-login-center">
    <p class="t-login-center-1 t-bt1px">
        <span class="t-icon-sign icon_iphone2"></span>
        <?php echo Form::input('phone','',array('class'=>'form-control','placeholder'=>'您的手机号'));?>
        <span class="t-icon-close"></span> </p>
    <p class="t-login-center-1 t-bt1px">
        <span class="t-icon-sign icon_password"></span>
        <?php echo Form::input('authcode','',array('class'=>'t-w240px form-control','placeholder'=>'短信验证码'));?>
        <span class="t-icon-close t-mr"></span><button  type="button" class="t-pwd-code">获取验证码</button></p>
    <p class="t-login-center-1">
        <span class="t-icon-sign icon_password"></span>
        <?php echo Form::password('password','',array('class'=>'form-control','placeholder'=>'登录密码（6-16位字母数字组合）')); ?>
        <span class="t-icon-close"></span></p>

</section>
<section class="t-login-center">
    <p class="t-login-center-1">
        <?php echo Form::password('invitecode','',array('class'=>'form-control','placeholder'=>'邀请码（非必填项）')); ?>
        <span class="t-icon-close"></span></p>
</section>
<!--<section class="t-login-center">-->
<!--    <p class="t-login-center-1 t-bt1px">-->
<!--        <span class="t-icon-sign icon_name"></span>-->
<!--	--><?php //echo Form::input('zname','',array('class'=>'form-control','placeholder'=>'您的真实姓名')); ?>
<!--	<span class="t-icon-close"></span></p>-->
<!--    <p class="t-login-center-1">-->
<!--        <span class="t-icon-sign icon_IDcar"></span>-->
<!--		--><?php //echo Form::input('code','',array('class'=>'form-control','placeholder'=>'您的真实身份证号（18位）')); ?>
<!--	<span class="t-icon-close"></span></p>-->
<!--</section>-->
<p class="t-register"><span></span>实名认证信息必须是您本人信息，请如实填写</p>
<section class="t-login-footer">
    <p class="t-error"></p>
    <p class="t-register1">
        <?php echo Form::checkbox('aggreement', '', FALSE,array('class'=>"chk_1",'id'=>'checkbox_a1')); ?>
        <label for="checkbox_a1"></label>同意<a href="<?php echo URL::site('Protocol/conten?num=1'); ?>">《用户账户注册及使用协议》</a></p>
    <?php echo Form::hidden('latitude');?>
    <?php echo Form::hidden('longitude');?>
	<input type="submit" class="t-red-btn t-red-register" value="下一步"></br></br>
</section>
<?php include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
<script>
    var sendcodeurl='<?php echo URL::site('Functions/registersendcode'); ?>';
    var registerurl='<?php echo URL::site('Functions/doregister');?>';
</script>
<?php  echo HTML::script('static/js/local-min/loginforms-min.js?11122'); ?>
