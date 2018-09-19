<!DOCTYPE html>
<html lang="zh-cn" class="no-js">
<head>
	<meta http-equiv="Content-Type">
	<meta content="text/html; charset=utf-8">
	<meta charset="utf-8">
	<title><?php echo $title ?></title>
	<meta name="viewport">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="email=no">
	<style type="text/css">

		*{ padding: 0; margin: 0;}
		html { -webkit-text-size-adjust: none; font-size: 20px; height: 100%;}
		body{min-width:16rem; font-family:"STHeiti","Microsoft YaHei","Microsoft YaHei","SimHei", "Arial Black"; font-weight: lighter; background: #ece903;}

		.img { display: block; max-width: 100%;vertical-align:top; border: none; }

		@media only screen and (min-width: 401px){
			html {
				font-size: 25px !important;
			}
		}
		@media only screen and (min-width: 428px){
			html {
				font-size: 26.75px !important;
			}
		}
		@media only screen and (min-width: 481px){
			html {
				font-size: 30px !important;
			}
		}
		@media only screen and (min-width: 569px){
			html {
				font-size: 35px !important;
			}
		}
		@media only screen and (min-width: 641px){
			html {
				font-size: 40px !important;
			}
		}
		.cash-bg{ position: absolute; top: 0; z-index: -1;bottom:0}
		.cash-title{ width: 12.7rem; height: 4.275rem; background: url(/static/images/activity/share/icon-bj.png) no-repeat; background-size: 12.7rem auto; position: absolute;z-index: 3; top: 6.9rem; left: 50%; margin-left: -6.35rem;}
		.cash-2weima{ width: 12.7rem; height: 4.275rem; background: url() no-repeat; background-size: 12.7rem auto; position: absolute;z-index: 3; top: 6.9rem; left: 50%; margin-left: -6.35rem;}
		.cash-title p {text-align: center; color: #000000;font-size: 1.1rem; font-weight: bold; line-height: 1.2rem; padding-top: 0.38rem; }
		.cash-1{ text-align: center; font-size: 0.5rem; color: #fff; margin-top:12.2rem; padding-bottom: 0.3rem;}
		.cash-btn{ display:block; width: 4.75rem; height: 1.7rem; border-radius: 0.7rem; background-size: 4.75rem auto; font-size: 0.8rem; font-weight: bold; text-decoration: none; background: #ece903; text-align: center; line-height: 1.8rem; color: #080808; position: absolute; left: 50%; margin-left: -2.325rem;}
		.twoweima{
			margin-top:.5rem;
			height:8rem;
			width:100%;
			z-index: 6;
			text-align: center;
		}
		.smallclass{
			text-align: center;
			display:inline-block;
			width:31%
		}
		.smallclass p{
			margin-top: 0.2rem;
			font-size: 12px;
		}
		.smallclass img{
			max-width: 3rem;
		}
	</style>
</head>
<body>
<img src="/static/images/activity/share/07.png" height="100%" width="100%" class="img cash-bg" />
<section style="max-height: 13rem;width: 100%;text-align:center">
	<img style='max-height: 13rem;width: 90%' src="/static/images/activity/share/05_02.png">
</section>
<section style = 'margin:1rem 1.5rem'>
	<div class="smallclass">
		<img src="/static/images/activity/share/03_04.png">
	</div>
	<div class="smallclass">
		<img src="/static/images/activity/share/03_06.png">
	</div>
	<div class="smallclass">
		<img src="/static/images/activity/share/03_08.png">
	</div>
</section>

<div class="twoweima" >
	<img src='<?php echo $imgUrl; ?>' style="height:6rem;width:6rem;"/>
	<p style="position: relative;bottom: 0;font-size: 12px;top:0.5rem;color: black"><strong>长按识别二维码关注</strong></p>
</div>

</body>
</html>
<?php if($is_weixin){?>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>
		var titil = "<?php echo $sharetitle; ?>";
		var text = "<?php echo $text; ?>";
		var url = "<?php echo $url; ?>";
		var img_url = "<?php echo $img_url; ?>";
		wx.config({
			debug: false,
			appId: '<?php echo $signPackage["appId"];?>',
			timestamp: <?php echo $signPackage["timestamp"];?>,
			nonceStr: '<?php echo $signPackage["nonceStr"];?>',
			signature: '<?php echo $signPackage["signature"];?>',
			jsApiList: [
				'onMenuShareTimeline',
				'onMenuShareAppMessage'
			]});
		wx.ready(function () {
			wx.onMenuShareTimeline({
				title: titil, // 分享标题
				link: url, // 分享链接
				imgUrl: img_url, // 分享图标
				success:function(){
					// 用户确认分享后执行的回调函数
				},
				cancel:function(){
					// 用户取消分享后执行的回调函数
				}
			});
			wx.onMenuShareAppMessage({
				title: titil, // 分享标题
				desc: text, // 分享描述
				link: url, // 分享链接
				imgUrl: img_url, // 分享图标
				type: '', // 分享类型,music、video或link，不填默认为link
				dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
				success:function(){
					// 用户确认分享后执行的回调函数
				},
				cancel:function(){
					// 用户取消分享后执行的回调函数
				}
			});
		});
	</script>

<?php }?>


