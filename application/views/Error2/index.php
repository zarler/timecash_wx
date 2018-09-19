<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>信息提示</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1,target-densitydpi=medium-dpi">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
    <?php echo HTML::style('static/css/public.css'); ?>
    <?php echo HTML::style('static/css/t-cash.css'); ?>
	<?php echo HTML::script('static/js/lockPhoneBackBtn.js'); ?>
</head>
<body>
<section class="x-404">
	<?php echo HTML::image('static/images/x-404.png');?>
	<p><?php echo $error?><a href="<?php echo URL::site('User/index');?>">返回首页</a></p>
</section>
</body>
</html>