<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<script>

</script>
<style type="text/css">
    .button_p{
        width: 25%;
        background: #ff8470;
        height: .8rem;
        border-radius: .3rem;
        font-size: .35rem;
        color: white;
        margin-left: 10%;
        margin-right: 10%;
        border:none;
    }
</style>
<body style="background: #F3F3F3">
<div class="loading_ok" style="display: none">
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a href="/?#jump=no" class="return_i i_public"></a>关于微信
	</div>
</section>
<!-- 头信息end -->
<div class="top_height"></div>
    <p style="margin-top: 2.2rem;text-align: center;font-size: .4rem;letter-spacing: .06rem;">关注快金微信</p>
    <img style="margin: 0 auto;display: block;width: 35%;" src="/static/images/v2/activity/2weima.png">
    <p style="margin-top: .4rem;text-align: center;font-size: .35rem;color: gray;">及时获取最新贷款信息</p>
    <p style="margin-top: .4rem;text-align: center;font-size: .35rem;color: gray;">一键关注快金微信公众号</p>
    <div style="text-align: center">
        <button onclick="copyWxNum();" class="button_p">复制微信号</button>
        <button onclick="savePic();" class="button_p">保存二维码</button>
    </div>
</div>
<script>


    function copyWxNum(){
        <?php if($_VArray['client']=='android'){?>
            window.android.JsAppInteraction('copyWxNum','快金');
        <?php }elseif($_VArray['client']=='ios'){?>
            JsAppInteraction('copyWxNum','快金');
        <?php } ?>
    }
    function savePic(){
        <?php if($_VArray['client']=='android'){?>
        window.android.JsAppInteraction('savePicture','http://test33.m.timecash.cn/static/images/v2/activity/2weima.png');
        <?php }elseif($_VArray['client']=='ios'){?>
        JsAppInteraction('savePicture','http://test33.m.timecash.cn/static/images/v2/activity/2weima.png');
        <?php } ?>
    }
</script>
</body>
</html>