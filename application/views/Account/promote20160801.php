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
	<p class="c-credit-basics-center">担保比例</p>
	<div  class="votebox" data-behavior="pie-chart">
	</div>
	<p class="c-credit-basics">降低担保<span>提交下列信息可申请降低担保比例</span></p>

	<?php if($jump){ ?>
		<section class="m-webbox">
			<div class="m-lineblock">
				<span class="m-corporation"></span>
				<label>工作和家庭信息</label>
				<?php if($step['work_info']==2 && $step['home_info']==2 && $step['contact']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="/RegisterApp/Company">未提交</a>';}  ?>
			</div>
				<div class="m-lineblock">
					<span class="m-iphone"></span>
					<label>运营商和电商账号授权</label>
					<?php if($step['account_mno']==2||$step['account_mno']==8){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="/RegisterApp/Operator">未提交</a>';}  ?>

				</div>
				<div class="m-lineblock" style="border-bottom:none">
					<span class="m-zhima"></span>
					<label>芝麻信用授信</label>
					<?php if($step['zhimacredit']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="/RegisterApp/Sesamecredit">未提交</a>';}  ?>
				</div>
		</section>
	<?php }else{ ?>
		<section class="m-webbox">
				<div class="m-lineblock">
					<span class="m-corporation"></span>
					<label>工作和家庭信息</label>
					<?php if($step['work_info']==2 && $step['home_info']==2 && $step['contact']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:nobasecreadit();">未提交</a>';}  ?>
				</div>
				<div class="m-lineblock">
					<span class="m-iphone"></span>
					<label>运营商和电商账号授权</label>
					<?php if($step['account_mno']==2|$step['account_mno']==8){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:nobasecreadit();">未提交</a>';}  ?>
				</div>
				<div class="m-lineblock" style="border-bottom:none">
					<span class="m-zhima"></span>
					<label>芝麻信用授信</label>
					<?php if($step['zhimacredit']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:nobasecreadit();">未提交</a>';}  ?>
				</div>
		</section>
	<?php }?>
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
	<div class="t-mask" style="display: none"></div>
	<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box_prompt" style="display: none;">
		<h3 class="t-bomb_box-1" style="border-bottom:1px solid #e5e5e5">提示<a href="javascript:prompt_hide();" class="t-close-btn"></a></h3>
		<p class="t-bomb_box-6" id="t-bomb_box-6" style="line-height: 2rem;font-size: 0.85rem;height:6rem;overflow-y:visible;overflow-x:visible;padding:15px 16px 5px 16px">
			基础信息未完成,请下载APP!
		</p>
			<div  class="t-red">
				<a href="/Promotion/" class="t-red-btn" style="border:1px solid red;float:right;width: 100% ">下载APP</a>
			</div>
	</div>


</article>
<script language="javascript">
	function animate(){
		$(".charts").each(function(i,item){
			var a=parseInt($(item).attr("w"));
			$(item).animate({
				width: a+"%"
			},2000);
		});
	}
	$(document).ready(function() {
		$('*[data-behavior="pie-chart"]').each(function() {
			$(this).svgPie({percentage: <?php echo $ensure_rate ?>});
		});

	});
	function nobasecreadit() {
		//layer.msg('基础信息未完成,请下载APP');
		$('.t-mask').show();
		$('#t-bomb_box_prompt').show();
	}
	function prompt_hide(){
		$('.t-mask').hide();
		$('#t-bomb_box_prompt').hide();
	}
</script>
</body>
</html>

