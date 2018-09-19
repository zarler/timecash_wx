<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="email=no">
</head>

<style type="text/css">
	html,body{ width: 100%; position:relative;margin:0;padding: 0;background: white;}
	.all{ width: 100%;1136px}
	.header{ width: 12rem; background:url("/static/images/activity/receivecoupon/lips.png") 0 0 no-repeat; background-size: contain; height: 12rem; margin: auto;position:fixed;left:0; right:0; top:0; bottom:0;}
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
<body>
<div class="all">
	<a href="wxe28c2110b2833b40://openwebview/?ret=0">
	<header class="header">
	</header>
	</a>
</div>
</body>
<?php echo HTML::script('static/js/jquery-1.9.1.min.js'); ?>
<script>
	$('.header').click(function(){
		location.href = 'wx234ad233ae222://openwebview/?ret=0';
	});
</script>
</html>
