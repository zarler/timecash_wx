<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-026/css/TCOA-026.css?111"/>

<script>

</script>

<body style="font-size: .35rem;background:#f5f5f5">
<!--头-->
<!-- 头信息 -->
<section class="t-login-nav">
    <div class='t-login-nav-1'>
        <a class="return_i i_public" href="javascript:history.go(-1);"></a>邀请记录
    </div>
</section>
<div class="top_height"></div>
<div class="T026_o">
    <div >
        <strong><?php echo $_VArray['invited'];?></strong><br>成功邀请好友(人)
    </div>
    <div >
        <strong><?php echo $_VArray['award'];?></strong><br>获取现金红包(元)
    </div>
</div>
<div class="mp_o">
    <ul><li>手机号</li><li>状态</li><li>奖励</li></ul>
</div>
<div class="T026_s">
    <?php echo $_VArray['invitedList']; ?>
</div>
<div class="top_height"></div>
<a href="<?php echo isset($_VArray['urlWithdrawals'])?$_VArray['urlWithdrawals']:'javascript:;' ?>" class="button_submit_little">继续邀请</a>

</div>
</body>
</html>