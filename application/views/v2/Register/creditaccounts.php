<?php include Kohana::find_file('views', 'public/headapp');?>
<?php echo HTML::script('static/js/lockPhoneBackBtn.js'); ?>
<body>
<section class="t-login-nav">
    <div class="t-login-nav-1"><a href="/Account/Promote?jump=no" class="t-return"></a>提交授信资料<!--<a href="#" class="t-re">登录</a>--></div>
</section>
<div class="b-tip-bar">
    请尽量多授权电商账号，信息越多越有助于您通过审核
    <a href="javascript:;" class="t-tip-close"></a>
</div>


<section class="progress-bar b-flex-box">
    <?php echo HTML::image('/static/images/credit/icon_tree.png',array('style'=>'width:99%')) ?>
</section>


<section class="t-login-center hidden">
<!--    <div class="b-flex-box b-credit-list">-->
<!--        <div class="b-credit-icon"><span class="b-icon">--><?php //echo HTML::image('static/images/b-credit-icon4.png',array('class'=>'b-icon4')); ?><!--</span></div>-->
<!--        <div class="b-credit-txt">淘宝账户</div>-->
<!--        <div class="b-credit-btnbox">-->
<!--            --><?php //if($taobao == Model_Home::CREDIT_NOT_SUBMIT){?>
<!--                <a href="/RegisterApp/CreditTaobao" class="b-credit-btn btn-active">可提交</a>-->
<!--            --><?php //}elseif($taobao == Model_Home::CREDIT_NOT_OPEN){?>
<!--                <a href="javascript:;" class="b-credit-btn btn-default">未开通</a>-->
<!--            --><?php //}elseif($taobao == Model_Home::CREDIT_NOT_SUBMITED){?>
<!--                <a href="javascript:;" class="b-credit-btn btn-default">已提交</a>-->
<!--            --><?php //}?>
<!--        </div>-->
<!--    </div>-->
    <div class="b-flex-box b-credit-list">
        <div class="b-credit-icon"><span class="b-icon-jingdong"></span></div>
        <div class="b-credit-txt">京东账户</div>
        <div class="b-credit-btnbox">
            <?php if($jingdong == Model_Home::CREDIT_NOT_SUBMIT){?>
                <a href="/RegisterApp/CreditJD" class="b-credit-btn btn-active">可提交</a>
            <?php }elseif($jingdong == Model_Home::CREDIT_NOT_OPEN){?>
                <a href="javascript:;" class="b-credit-btn btn-default">未开通</a>
            <?php }elseif($jingdong == Model_Home::CREDIT_NOT_SUBMITED){?>
                <a href="javascript:;" class="b-credit-btn btn-default">已提交</a>
            <?php }?>
        </div>
    </div>
</section>
<section class="t-login-footer">
    <p class="t-error"></p>
    <?php if($next){?>
     <a href="/Account/Promote?jump=yes"  class="t-red-btn">下一步</a></br>
    <?php }else{?>
      <a href="javascript:;"  class="t-gray-btn">下一步</a></br></br></br></br>
     <a href="/Account/Promote?jump=yes"  class="t-red-btn">跳过</a></br>
    <?php }?>

</section>
<?php echo Form::close();?>
<?php include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
<?php  echo HTML::script('static/js/online/loginforms.js'); ?>
<script>
    $('.t-tip-close').click(function(){
        $('.b-tip-bar').hide();
    });
</script>
