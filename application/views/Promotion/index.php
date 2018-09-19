<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1,target-densitydpi=medium-dpi">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="email=no">
	<?php echo HTML::style('static/css/uploadapp.css?1231111'); ?>
</head>

<style type="text/css">
	a{
		text-decoration:none;
	}
	a:hover{
		background: #FF00FF;
	}
	a:focus{
		background: #FF00FF;
	}
</style>
<body style="background: white;-webkit-font-smoothing:auto">
<div class="turntable-1">
	<div class='top_include'>
		<?php echo HTML::image('static/images/promotion/2_011.png',array('class'=>'img turntable-banner'));?>
		<div class='top_font'>
			<p class='p1' style="margin-bottom:0.2em">你想要的 现在就给你</p>
			<p class='p2'>下载快金APP  马上降担保</p>
		</div>
	</div>
	<?php if($client=='android') {?>
	<div class='upload_app'>
		<a href="<?php echo $url; ?>">
		<div class="dw_zl_android">
			<span>Android版下载</span>
		</div>
		</a>
	</div>
		<?php }elseif($client=='ios'){?>
		<div class='upload_app'>
			<a href="<?php echo $url; ?>">
			<div class="dw_zl_ios">
					<span class='span1'>iPhone版下载</span>
			</div>
			</a>
		</div>
	<?php }else{?>
	<?php } ?>
	<?php echo HTML::image('static/images/promotion/2_13.png',array('class'=>'img turntable-banner'));?>
</div>
</body>
<script>
	function noonline() {
		alert("最新版本还未上线,尽请期待!");
	}


</script>
</html>
