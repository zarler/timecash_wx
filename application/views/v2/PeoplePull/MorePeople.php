<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<script>
    seajs.config({
        vars: {
            'last_id':'<?php echo isset($_VArray['last_id'])?$_VArray['last_id']:0; ?>',
            'url':'<?php echo isset($_VArray['reqUrl'])?$_VArray['reqUrl']:''; ?>',
        }
    });
    seajs.use('js/v2/seajs/morepeoplepull');

</script>
<body>
<section class="t-login-nav">
    <div class='t-login-nav-1'>
        <a href="javascript:history.go(-1);" class="return_i i_public"></a>邀请记录
    </div>
</section>
<div class="top_height"></div>
<section  class="circular">
</section>
<section>
    <div class="left-div">
        <ul>
            <li>我的好友</li>
            <li>好友状态</li>
            <li>我的奖励</li>
        </ul>
        <?php echo $_VArray['strUl']; ?>

<!--        <span class="left-span">邀请记录为空呦，赶快去邀请吧！</span>-->
    </div>
</section>
<div style="clear: both"></div>
<section style="position: relative;top: -1rem;" class="moreSection">
    <?php echo $_VArray['moreSubmit']; ?>
</section>
</body>
</html>