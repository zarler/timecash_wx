<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
</script>
<body>

<section class="t-login-nav">
	<div class='t-login-nav-1'>
        <?php if(!isset($_VArray['back'])){ ?><a class="return_i i_public" href="<?php echo URL::site('User/index');?>"></a><?php } ?>购买快审卡
	</div>
</section>
<div class="top_height"></div>
<section style='margin-top:1rem'>
    <img style="margin: 1.6rem auto;display: block;width: 30%;" src="/static/images/v2/ksk_lutou.png">
    <p style="text-align: center;margin-bottom: .6rem;font-size: .9rem;color: #ff8470;">购买申请已提交</p>
    <p style="text-align: center;line-height: .9rem;color: rgb(173, 173, 173);margin-bottom: .8rem;">恭喜，您的购买申请已提交，稍后您可返回<br>首页，点击左上角菜单，选择“我的快审卡”<br>进入并查看购卡结果</p>
</section>
<section class="m-returnbox">
    <a href="<?php echo isset($_VArray['url'])?$_VArray['url']:'javascript:;' ?>" class="t-orange-btn button_submit t-register-button">前往我的快审卡</a>
</section>


<div class="top_height"></div>
</body>
</html>
