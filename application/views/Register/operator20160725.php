<?php include Kohana::find_file('views', 'public/headapp');?>
<?php echo HTML::script('static/js/lockPhoneBackBtn.js'); ?>
<meta name="format-detection" content="telephone=no">
<meta http-equiv="x-rim-auto-match" content="none">
<body>
<section class="t-login-nav">
    <div class="t-login-nav-1"><a href="/Account/Promote?jump=no" class="t-return"></a>提交授信资料<!--<a href="#" class="t-re">登录</a>--></div>
</section>
<!--<ul class="progress-bar b-flex-box">-->
<!--    <li class="progress-zindex4 progress-active"><span class="progress-num progress-active">1</span></li>-->
<!--    <li class="progress-zindex3 progress-active"><span class="progress-num progress-active">2</span></li>-->
<!--    <li class="progress-zindex2 progress-active"><span class="progress-num progress-active">3</span></li>-->
<!--    <li class="progress-zindex1 progress-default"><span class="progress-num">4</span></li>-->
<!--    <li class="progress-zindex0 progress-default"></li>-->
<!--</ul>-->
<section class="progress-bar b-flex-box">
    <?php echo HTML::image('/static/images/credit/icon_tree.png',array('style'=>'width:99%')) ?>
</section>
<p class="b-supple-infotxt b-color-orange"><span>•</span> 请输入手机号码运营商服务密码</p>
<section class="t-login-center">
    <p class="t-login-center-1 t-bt1px">
        <?php echo Form::input('phone',$mobile,array('class'=>'form-control','Readonly'=>true));?>
        <span class="t-icon-close"></span> </p>
    <p class="t-login-center-1">
        <?php echo Form::password('passphone','',array('class'=>'form-control','placeholder'=>'请输入密码')); ?>
        <?php echo Form::hidden('type','sj') ?>
        <span class="t-icon-close"></span></p>
    <?php if(isset($Operator)&&$Operator=='yd'){?>
        <?php echo Form::hidden('identity',$Operator) ?>
    <p class="t-login-center-1" style="border-top: 1px solid #e0e0e0">
        <?php echo Form::input('comauthcode','',array('id'=>'comauthcode','class'=>'t-w240px form-control','placeholder'=>'验证码'));?>
        <span class="t-icon-close t-mr"></span><span class="t-pwd-code1">获取验证码</span></p>
    <?php }?>
    <p class="t-login-center-1 dynamiccode" style="border-top: 1px solid #e0e0e0;">
        <?php echo Form::input('dynamiccode','',array('id'=>'dynamiccode','class'=>'t-w240px form-control','placeholder'=>'动态验证码'));?>
        <span class="t-icon-close"></span></p>
</section>
<p class="t-register" align="center" style="margin-top: 20px">如果您不清楚手机号码运营商服务密码</p>
<p class="t-register" align="center">请拨打您运营商的客服电话查询</p>
<section class="t-login-footer" style="text-align:center;">
    <?php if(isset($Operator) and $Operator=='yd'){
        echo '<a href="javascript:sendToAndroid();">'.HTML::image('/static/images/credit/icon_yidong.png',array('style'=>'width:5rem;height:1.1rem')).'</a>';
    }elseif(isset($Operator) and $Operator=='lt'){
        echo '<a href="javascript:sendToAndroid();">'.HTML::image('/static/images/credit/icon_liantong.png',array('style'=>'width:5rem;height:1.1rem')).'</a>';
    }elseif(isset($Operator) and $Operator=='dx'){
        echo '<a href="javascript:sendToAndroid();">'.HTML::image('/static/images/credit/icon_dianxin.png',array('style'=>'width:5rem;height:1.1rem')).'</a>';
    }
    ?>
</section>
<section class="t-login-footer">
    <p class="t-error"></p>
    <input type="submit" class="t-red-btn t-button" value="下一步"></br>
</section>
<?php include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
<?php  echo HTML::script('static/js/creditforms.js?13111'); ?>
<script>
    var creditzhurl='<?php echo URL::site('FunctionsApp/dotbjdcredit'); ?>';
    <?php if(isset($Operator) and $Operator=='yd'){?>
    var dynamicSendurl='<?php echo URL::site('FunctionsApp/doDynamicSend'); ?>';
    var dynamicVerifyurl='<?php echo URL::site('FunctionsApp/doDynamicVerify'); ?>';
    var sendtime = <?php echo $sendtime; ?>;
    <?php } ?>
    function sendToAndroid(){
        <?php if($client=='android'){ ?>
            window.call.runOnAndroidJavaScript(<?php echo $cellnumber; ?>);//通过injs接口调用android的函数
        <?php }elseif($client=='ios'){ ?>
            callPhone('<?php echo $cellnumber; ?>');
        <?php }else{?>
        <?php }?>
    }

</script>
