<?php include Kohana::find_file('views', 'public/headapp');?>
<body>
<section class="t-login-nav">
    <div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>提交授信资料<!--<a href="#" class="t-re">登录</a>--></div>
</section>
<div class="b-tip-bar">
    请尽量多授权电商账号，信息越多越有助于您通过审核
    <a href="javascript:;" class="t-tip-close"></a>
</div>
<p class="b-supple-infotxt b-color-orange"><span>•</span> 授权快金访问您的淘宝账户</p>
<section class="t-login-center">
    <p class="t-login-center-1 t-bt1px">
        <?php echo Form::input('usernamec','',array('class'=>'form-control','placeholder'=>'请输入账号'));?>
        <span class="t-icon-close"></span> </p>
    <p class="t-login-center-1">
        <?php echo Form::password('password','',array('class'=>'form-control','placeholder'=>'请输入密码')); ?>
        <?php echo Form::hidden('type','tb') ?>
        <span class="t-icon-close"></span></p>
</section>
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
<?php  echo HTML::script('static/js/creditforms.js?113123'); ?>
<script>
    var creditzhurl='<?php echo URL::site('FunctionsAppVer/dotbjdcredit'); ?>';
    $('.t-tip-close').click(function(){
        $('.b-tip-bar').hide();
    });
</script>