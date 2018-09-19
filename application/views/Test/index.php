<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
  <title>微信JS-SDK Demo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
 <?php echo HTML::style('static/css/style.css'); ?>
</head>
<body ontouchstart="">
<?php echo $despic; ?>

<div class="wxapi_container">
	<?php echo HTML::style('static/v1/css/style.css'); ?>

  </div>
<a style="margin-top: 60px;display:block" href="/Test/Index">刷新</a>
<a style="margin-top: 60px;display:block" href="/Test/Index?ac=delete">删除</a>
<div style="position:fixed;left:45%;top:45%;display:none;color:red;" id="status"></div>
</body>
</html>

</html>
