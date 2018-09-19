<?php include Kohana::find_file('views', 'public/headapp');?>
<body>
<section class="t-login-nav">
    <div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>提交授信资料<!--<a href="#" class="t-re">登录</a>--></div>
</section>
<div class="b-tip-bar">
    请尽量多授权电商账号，信息越多越有助于您通过审核
    <a href="javascript:;" class="t-tip-close"></a>
</div>
<p class="b-supple-infotxt b-color-orange"><span>•</span> 授权快金访问您的京东账户</p>
<section class="t-login-center">
    <p class="t-login-center-1 t-bt1px">
        <span class="b-icon-jingdong" style="width: 1.2rem;height: 1.2rem;position:relative;top:7px"></span>
        <?php echo Form::input('usernamec','',array('class'=>'form-control','placeholder'=>'请输入用户名/手机号/邮箱'));?>
        <span class="t-icon-close"></span> </p>
    <p class="t-login-center-1">
        <span class="t-icon-sign icon_password"></span>
        <?php echo Form::password('password','',array('class'=>'form-control','placeholder'=>'请输入密码')); ?>
        <?php echo Form::hidden('type','jd') ?>
        <span class="t-icon-close"></span></p>
    <p class="t-login-center-1 dynamiccode t-bt1px-top"  style='display: none'>
        <?php echo Form::password('dynamiccode','',array('class'=>'form-control','placeholder'=>'动态验证码')); ?>
        <span class="t-icon-close"></span></p>
</section>

<div class="t-mask" style="display: none"></div>
<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box" style="display: none">
    <h3 class="t-bomb_box-1">提示</h3>
    <p class="t-bomb_box-6" id="t-bomb_box-6" style="line-height: 2rem;font-size: 0.85rem;height:6rem;overflow-y:visible;overflow-x:visible;padding:15px 16px 5px 16px">
    </p>
        <div  class="t-red"><a href="/RegisterApp/Operator" class="t-red-btn">确定</a></div>
</div>
<section class="b-supple-tiparea">
    <p>数据仅供信用审核用，快金不会泄露您的隐私数据</p>
</section>
<section class="t-login-footer">
    <p class="t-error"></p>
	<input type="submit" class="t-red-btn t-button" value="下一步"></br>
</section>
<?php include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
<?php  echo HTML::script('static/js/online/creditforms.js?113'); ?>
<script>
    var creditzhurl='<?php echo URL::site('FunctionsAppVer/dotbjdcredit'); ?>';
    $('.t-tip-close').click(function(){
        $('.b-tip-bar').hide();
    });
</script>
