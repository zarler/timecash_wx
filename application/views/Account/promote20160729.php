<?php include Kohana::find_file('views', 'public/head');?>
<?php echo HTML::script('static/js/jquery-pie-loader.js?123'); ?>
<?php echo HTML::style('static/css/jquery-pie-loader.css?1223'); ?>
<?php //echo HTML::script('static/js/zhima/chart.meter.js?123'); ?>
<style>
	#box {
		width: 100%;
		text-align: center;
		margin: 100px auto;
	}
</style>
<body>
<article>
	<section class="t-login-nav">
		<div class="t-login-nav-1"><a href="/Account/index" class="t-return"></a>提升额度</div>
	</section>
	<div class="b-tip-bar">
		<a class="b-color-orange" style="display: block" href="/Promotion"><span>•</span>下载APP提交信息降担保</a>
	</div>
<!--	<p><a class="b-supple-infotxt b-color-orange" style="display: block" href="/Promotion"><span>•</span>下载APP提交信息降担保</a></p>-->

	<p class="c-credit-basics-center">担保比例</p>
	<div  class="votebox" data-behavior="pie-chart">
	</div>
<!--	<div class="votebox" style="margin:20px auto 0 auto">-->
<!--		<dl class="barbox">-->
<!--			<dd class="barline">-->
<!--				<div w="50"; style="width: 0px" class="charts"></div>-->
<!--			</dd>-->
<!--		</dl>-->
<!--	</div>-->
	<p class="c-credit-basics">降低担保<span>提交下列信息可申请降低担保比例</span></p>
	<section class="m-webbox">
		<div class="m-lineblock">
			<span class="m-corporation"></span>
			<label>工作和家庭信息</label>
			<?php if($step['work_info']==2 && $step['home_info']==2 && $step['contact']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="/RegisterApp/Company">未提交</a>';}  ?>

		</div>
		<!--		<div class="m-lineblock">-->
		<!--			<span class="m-jiating"></span>-->
		<!--			<label>家庭信息</label>-->
		<!--			--><?php //if($step['home_info']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:;">未提交</a>';}  ?>
		<!---->
		<!--		</div>-->
		<!--		<div class="m-lineblock">-->
		<!--			<span class="m-urgency"></span>-->
		<!--			<label>紧急联系人信息</label>-->
		<!--			--><?php //if($step['contact']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:;">未提交</a>';}  ?>
		<!---->
		<!--		</div>-->
		<div class="m-lineblock">
			<span class="m-iphone"></span>
			<label>运营商和电商账号授权</label>
			<?php if(($step['account_mno']==2&&$step['account_jingdong']==2)||($step['account_mno']==8&&$step['account_jingdong']==8)||($step['account_mno']==8&&$step['account_jingdong']==2)){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="/RegisterApp/Operator">未提交</a>';}  ?>

		</div>
		<!--		<div class="m-lineblock">-->
		<!--			<span class="m-taobao"></span>-->
		<!--			<label>淘宝账号授权</label>-->
		<!--			--><?php //if($step['account_taobao']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:;">未提交</a>';}  ?>
		<!---->
		<!--		</div>-->
		<!--		<div class="m-lineblock">-->
		<!--			<span class="m-jingdong"></span>-->
		<!--			<label>京东账号授权</label>-->
		<!--			--><?php //if($step['account_jingdong']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:;">未提交</a>';}  ?>
		<!---->
		<!--		</div>-->
		<div class="m-lineblock">
			<span class="m-zhima"></span>
			<label>芝麻信用授信</label>
			<?php if($step['zhimacredit']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="/RegisterApp/Sesamecredit">未提交</a>';}  ?>
		</div>
		<!--		<div class="m-lineblock" style="border-bottom: 1px solid white">-->
		<!--			<span class="m-face"></span>-->
		<!--			<label>人脸识别认证</label>-->
		<!--			--><?php //if($step['faceid']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:;">未提交</a>';}  ?>
		<!--		</div>-->
	</section>
	<p class="c-credit-basics">基本授信</p>
	<section class="m-webbox">
		<div class="m-lineblock">
			<span class="m-autonym"></span>
			<label>实名认证</label>
			<a href="javascript:;" class="identify">已认证</a>
		</div>
		<div class="m-lineblock">
			<span class="m-tongxunlu"></span>
			<label>手机通讯录授权</label>
			<?php if($step['phone_book']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:;">未提交</a>';}  ?>

		</div>
		<div class="m-lineblock">
			<span class="m-duanxin"></span>
			<label>手机短信</label>
			<?php if($step['sms_record']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:;">未提交</a>';}  ?>

		</div>
		<div class="m-lineblock">
			<span class="m-yuyin"></span>
			<label>手机通话记录授权</label>
			<?php if($step['call_history']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:;">未提交</a>';}  ?>

		</div>
		<div class="m-lineblock" style="border-bottom: 1px solid white">
			<span class="m-map"></span>
			<label>位置信息授权</label>
			<?php if($step['location']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:;">未提交</a>';}  ?>
		</div>
	</section>

	<div style="width: 20px;height: 20px"></div>
</article>
<script language="javascript">
//	window.onload = function(){
//		Meter.setOptions({
//			element: 'meter',
//			centerPoint: {
//				x: 130,
//				y: 120
//			},
//			radius: 130,
//			data: {
//				value: 710,
//				title: '职场竞争力{t}',
//				subTitle: '评估时间：2015.07.28',
//				area: [{
//					min: 350, max: 550, text: '较弱'
//				},{
//					min: 550, max: 600, text: '一般'
//				},{
//					min: 600, max: 650, text: '很强'
//				},{
//					min: 650, max: 700, text: '超强'
//				},{
//					min: 700, max: 950, text: '极强'
//				}]
//			}
//		}).init();
//	}
	function animate(){
		$(".charts").each(function(i,item){
			var a=parseInt($(item).attr("w"));
			$(item).animate({
				width: a+"%"
			},2000);
		});
	}

	$(document).ready(function() {
		//animate();
//		var rand = function() {
//			return Math.floor((Math.random() * 100) + 1)
//		}
		$('*[data-behavior="pie-chart"]').each(function() {
			$(this).svgPie({percentage: <?php echo $ensure_rate ?>});
		});

	});
</script>
</body>
</html>

