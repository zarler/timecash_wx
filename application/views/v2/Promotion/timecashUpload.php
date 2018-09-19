<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>快金升级</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1,target-densitydpi=medium-dpi">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="email=no">
	<?php echo HTML::style('static/css/uploadapp.css?1231111'); ?>
	<?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <script src="/static/js/v2/timecash.app.js?11"></script>
</head>
<script>
    var $AppInst = new $.AppInst();
</script>

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
			<p class='p2'>下载快金APP  想借就借</p>
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
			<a href="javascript:clickTj('<?php echo $url; ?>');">
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
	<?php if(in_array($client,array('android','ios'))){ if(!empty($userId)){?>
	function clickTj($url) {
		$.ajax({
			url:"/Promotion/StatisticsClick",
			type:'POST',
			data:{userid:<?php echo $userId ?>},
			dataType:'json',
			async: true,  //同步发送请求t-mask
			beforeSend:function(){
			},
			success:function(result){
//				alert(result.msg);
				location.href = $url;
			},
			error:function(){
				location.href = $url;
			}
		});
	}
	<?php }else{ ?>
		function clickTj($url) {
			location.href = $url;
		}
	<?php }} ?>

</script>
</html>
