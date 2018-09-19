<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<link type="text/css" rel="styleSheet"  href="/static/css/v2/local/widthdrawals.css" />
<body style="background: #F3F3F3">
<div class="loading_ok" style="display: none">
<!-- 头信息 -->
<section class="t-login-nav">
    <div class='t-login-nav-1'>
        <a href="javascript:history.go(-1);" class="return_i i_public"></a><?php echo $_VArray['title']; ?>
    </div>
</section>
<!-- 头信息end -->
<div style="height: 1.2rem"></div>
<div class="top_height"></div>
<img class="i" src="/static/images/v2/icon-duigou.png">
<p class='wsp1'>提现成功</p>
<p class='wsp2'>实际到账实践取决于对方银行</p>
<a class="wspa" href="<?php echo isset($_VArray['gobackUrl'])?$_VArray['gobackUrl']:'/' ?>">返回首页</a>

</div>
</body>
</html>