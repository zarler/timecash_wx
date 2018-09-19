<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<script>
    seajs.config({
        vars: {
            'reqUrl':'<?php echo isset($_VArray['reqUrl'])?$_VArray['reqUrl']:'' ?>',
            'jumpUrl':'<?php echo isset($_VArray['jumpUrl'])?$_VArray['jumpUrl']:'' ?>'
        },
    });
    seajs.use('js/v2/seajs/withdrawals');
</script>


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
<section class="withdrawals-one">
    <p>可提现金额(元)</p>
    <h1><?php echo isset($_VArray['data']['money'])?$_VArray['data']['money']:0 ?></h1>
</section>

<section class="withdrawals-two">
    <div class="border-bottom">收款账户<span><img src="/static/images/v2/bank/<?php echo isset($_VArray['data']['code'])?$_VArray['data']['code']:0 ?>.png"><?php echo isset($_VArray['data']['bank_name'])?$_VArray['data']['bank_name']:'' ?><?php echo isset($_VArray['data']['card_no'])?$_VArray['data']['card_no']:'' ?></span></div>
    <div>收款人<span><?php echo isset($_VArray['data']['name'])?$_VArray['data']['name']:'' ?></span></div>
</section>

<section class="withdrawals-three">
    <div>提现金额<input onkeyup="this.value=this.value.replace(/[^0-9-]+/,'');" name="money" type="text" placeholder="请输入金额"></div>
</section>
<p class="withdrawals-p">单笔提现金额不小于<span>10</span>元；每月前<span>2</span>笔免费提现，超出<span>2</span>笔按<span>2</span>元/笔收费</p>
<div class="top_height"></div>
<!--<a href="--><?php //echo isset($_VArray['submit'])?$_VArray['submit']:'javascript:;' ?><!--" class="button_submit_little">确认提现</a>-->
    <a href="<?php echo isset($_VArray['submit'])?$_VArray['submit']:'javascript:;' ?>" class="button_submit_f">确认提现</a>
<div class="top_height"></div>
</div>
</body>
</html>