<?php include Kohana::find_file('views', 'public/headapp');?>
<?php echo HTML::script('static/js/lockPhoneBackBtn.js'); ?>
<body>
<section class="t-login-nav">
    <div class="t-login-nav-1"><a href="<?php if(isset($url)){echo $url.'?jump=no';}else{ echo '/Account/Promote?jump=no';} ?>" class="t-return"></a>提交授信资料<!--<a href="#" class="t-re">登录</a>--></div>
</section>
<!--<section class="progress-bar b-flex-box">-->
<!--    --><?php //echo HTML::image('/static/images/credit/icon_two.png',array('style'=>'width:99%')) ?>
<!--</section>-->
<p class="b-supple-infotxt b-color-orange"><span>•</span> 请输入2位紧急联系人方式</p>
<?php  echo Form::open('Account/Promote?jump=yes', array('id'=>'contactForm')); ?>
<?php // echo Form::open('RegisterApp/CreditAccounts', array('id'=>'contactForm')); ?>

<section class="t-login-center">
    <p class="t-login-center-1 t-bt1px">
        <span class="t-icon-sign icon_name"></span>
        <?php echo Form::input('conname','',array('class'=>'form-control','placeholder'=>'姓名'));?>
        <span class="t-icon-close"></span> </p>
    <p class="t-login-center-1 t-bt1px">
        <span class="t-icon-sign icon_relation"></span>
        <?php echo Form::select('contact',array('0'=>'请选择关系','parent'=>'父母','brother'=>'兄弟姐妹','spouse'=>'配偶','children'=>'子女'),'0',array('id'=>'contact-select1','data-type'=>'1','class'=>'b-form-select'));?>
        <span class="b-icon-select"></span>
    <p class="t-login-center-1">
        <span class="t-icon-sign icon_iphone2"></span>
        <?php echo Form::input('ccomtell','',array('class'=>'form-control','placeholder'=>'手机号码')); ?>
        <span class="t-icon-close"></span></p>
</section>

<section class="t-login-center">
    <p class="t-login-center-1 t-bt1px">
        <span class="t-icon-sign icon_name"></span>
        <?php echo Form::input('conname','',array('class'=>'form-control','placeholder'=>'姓名'));?>
        <span class="t-icon-close"></span> </p>
    <p class="t-login-center-1 t-bt1px">
        <span class="t-icon-sign icon_relation"></span>
        <?php echo Form::select('contact',array('0'=>'请选择关系','parent'=>'父母','brother'=>'兄弟姐妹','spouse'=>'配偶', 'children'=>'子女','colleague'=>'同事','classmate'=>'同学','friend'=>'朋友'),'0',array('id'=>'contact-select2','data-type'=>'2','class'=>'b-form-select'));?>
        <span class="b-icon-select"></span>
    <p class="t-login-center-1">
        <span class="t-icon-sign icon_iphone2"></span>
        <?php echo Form::input('ccomtell','',array('class'=>'form-control','placeholder'=>'手机号码')); ?>
        <span class="t-icon-close"></span></p>
</section>

<section class="t-login-footer">
    <p class="t-error"></p>
	<input type="submit" class="t-red-btn" value="下一步"><br><br><br>
</section>
<?php echo Form::close();?>
<?php include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
<script type="text/javascript">
    var contactsourl='<?php echo URL::site('FunctionsApp/docontacts'); ?>';
    var Jumpourl='<?php if(isset($url)){echo $url.'?jump=yes';}else{ echo '/Account/Promote?jump=yes';} ?>';
</script>
<?php  echo HTML::script('static/js/online/creditforms.js?212'); ?>
