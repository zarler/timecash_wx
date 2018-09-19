<?php include Kohana::find_file('views', 'public/head');?>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="<?php echo URL::site('User/index');?>" class="t-return"></a><?php echo $tit;?></div>
</section>
<p class="t-loan"><?php echo $title;?></p>
<p class="t-fail">请详细阅读页面说明</p>
<section class="t-login-center t-mt0px">
	<h3 class="t-fail-1">失败原因</h3>
	<dl class="t-fail-2 t-bt1px">
		<dt>●</dt>
		<dd><span style="width: inherit;"><?php echo $message;?></span></dd>
	</dl>

</section>
<section class="t-fail-3">
	<a href="javascript:history.go(-1);"  class="t-red-btn2 t-w-half">放弃借款</a>
	<!--<input type="submit" value="重新提交" class="t-red-btn t-w-half">-->
	<a href="<?php echo $url; ?>" class="t-red-btn t-w-half">重新提交</a>
</section>

</body>
</html>