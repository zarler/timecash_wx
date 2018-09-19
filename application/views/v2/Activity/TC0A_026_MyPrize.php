<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-026/css/TCOA-026.css?1111"/>
<script>
</script>
<body style="font-size: .35rem;background:#f5f5f5">
<!--头-->
<!-- 头信息 -->
<section class="t-login-nav">
    <div class='t-login-nav-1'>
        <a class="return_i i_public" href="javascript:history.go(-1);"></a>我的奖品
    </div>
</section>
<div class="top_height"></div>
<div class="mp_o">
    <ul>
        <li>奖品</li>
        <li>名称</li>
        <li>状态</li>
    </ul>
</div>
<div class="mp_s">
    <?php echo $_VArray['prizeList']; ?>
</div>
<div class="mp_t">
    <p>温馨提示：现金奖励实时发放至您的账户；实物类奖品将于活动结束后5个工作日核实发放！</p>
</div>


<a href="<?php echo isset($_VArray['urlWithdrawals'])?$_VArray['urlWithdrawals']:'javascript:;' ?>" class="button_submit_little">继续邀请</a>


</div>
</body>
</html>