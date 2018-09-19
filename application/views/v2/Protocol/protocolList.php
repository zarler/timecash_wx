<?php include Kohana::find_file('views', 'v2/public/head');?>
<body>
<?php if(isset($client)&&$client=='else'){?>
	<section class="t-login-nav">
		<div class='t-login-nav-1'>
			<a class="return_i i_public" href="javascript:history.go(-1);"></a>合同列表
		</div>
	</section>
	<div class="top_height"></div>
<?php }?>
<section class="m-webbox">
    <a href="<?php echo $borrowUrl; ?>" class="identify1">
        <div class="m-lineblock">
            <i class="m-icon-Coupon left_i"></i>
            <label>借款协议</label>
            <i class="inter_i float_right"></i>
        </div>`
    </a>
    <a href="<?php echo $supplementUrl; ?>" class="identify1">
        <div class="m-lineblock">
            <i class="m-icon-Coupon left_i"></i>
            <label>借款协议补充协议</label>
            <i class="inter_i float_right"></i>
        </div>
    </a>
</section>
</body>
</html>