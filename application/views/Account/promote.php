<?php include Kohana::find_file('views', 'public/head');?>
<?php echo HTML::style('static/css/jquery-pie-loader.css?1223'); ?>
<?php //echo HTML::script('static/js/zhima/chart.meter.js?123'); ?>
<style>
	#box {
		width: 100%;
		text-align: center;
		margin: 100px auto;
	}
</style>
<script>
	seajs.config({
		vars: {
			'url':'/Functions/SubmitReduceApply',
			'shows':<?php echo $reduce_apply['show'];?>,
			'ensure_rate':<?php echo $ensure_rate;?>,
			'enable':<?php echo (isset($reduce_apply['enable'])&&!empty($reduce_apply['enable']))?$reduce_apply['enable']:0 ?>,
			'have_credit':<?php echo ((isset($have_credit)&&!empty($have_credit)))?1:0 ?>
		}
	});
	seajs.use('js/seajs/promote');
	function nobasecreadit() {
		//layer.msg('基础信息未完成,请下载APP');
		$('.t-mask').show();
		$('#t-bomb_box_prompt').show();
	};
	
	function prompt_hide(){
		$('.t-mask').hide();
		$('#t-bomb_box_prompt').hide();
		$('#t-bomb_box_card').hide();
	}
</script>
<body>
<article>
	<section class="t-login-nav">
		<div class="t-login-nav-1"><a href="/Account/index" class="t-return"></a>授信管理</div>
	</section>
	<div class="b-tip-bar">
		<a class="b-color-orange" style="display: block" href="/Promotion"><span>•</span>下载APP提交信息降担保</a>
	</div>
	<section class="c-credit-promote">
		<div style="position:relative;top:60px;margin:0 auto;z-index: 999">
			<p class="c-credit-basics-center" style="color:white;z-index: 999">担保比例</p>
			<div  class="votebox" data-behavior="pie-chart"></div>
		</div>
		<div class="creditban"></div>
	</section>
	<p class="c-credit-basics">降低担保<span>提交下列信息可申请降低担保比例</span></p>
	<?php if($jump){ if(isset($credited)&&$credited==5){?>
		<section class="m-webbox">
			<div class="m-lineblock" style="border-bottom:none !important;">
				<span class="m-corporation"></span>
				<label>工作和联系人信息</label>
				<?php echo '<a href="javascript:;" class="identify1">已通过</a>'; ?>
			</div>
		</section>
	<?php }else{?>
		<section class="m-webbox">
			<div class="m-lineblock" style="border-bottom:none !important;">
				<span class="m-corporation"></span>
				<label>工作和联系人信息</label>
				<?php if($step['work_info']==2 && $step['contact']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="/RegisterApp/Company">未提交</a>';}  ?>
			</div>
		</section>
	<?php }}else{?>
		<section class="m-webbox">
				<div class="m-lineblock" style="border-bottom:none !important;">
					<span class="m-corporation"></span>
					<label>工作和联系人信息</label>
					<?php if($step['work_info']==2 && $step['contact']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a href="javascript:nobasecreadit();">未提交</a>';}  ?>
				</div>
		</section>
	<?php }?>
	<section class="t-login-footer">
		<p class="t-error"></p>
			<?php if($reduce_apply['enable']==1){if($have_credit){?>
				<a href="javascript:;" class="t-red-btn t-red-company">申请降低担保</a>
			<?php }else{ ?>
				<a href="javascript:;" class="t-red-btn t-red-company">申请降低担保</a>
			<?php }}else{ ?>
				<a href="javascript:;" class="t-gray-btn t-red-btn t-red-company">申请降低担保</a>
			<?php } ?>
	</section>
	<p class="c-credit-basics">基本授信</p>
	<section class="m-webbox">
		<div class="m-lineblock">
			<span class="m-autonym"></span>
			<label>实名认证</label>
			<?php if($step['identity']==2){echo '<a href="javascript:;" class="identify1">已通过</a>';}else{echo '<a href="/Borrowmoney/bankinfo?entrance=promote">未提交</a>';}  ?>

		</div>
		<div class="m-lineblock">
			<span class="m-tongxunlu"></span>
			<label>手机通讯录授权</label>
			<?php if($step['phone_book']==2){echo '<a href="javascript:;" class="identify1">已通过</a>';}else{echo '<a href="javascript:nobasecreadit();">未提交</a>';}  ?>

		</div>
		<div class="m-lineblock">
			<span class="m-duanxin"></span>
			<label>手机短信</label>
			<?php if($step['sms_record']==2){echo '<a href="javascript:;" class="identify1">已通过</a>';}else{echo '<a href="javascript:nobasecreadit();">未提交</a>';}  ?>

		</div>
		<div class="m-lineblock">
			<span class="m-yuyin"></span>
			<label>手机通话记录授权</label>
			<?php if($step['call_history']==2){echo '<a href="javascript:;" class="identify1">已通过</a>';}else{echo '<a href="javascript:nobasecreadit();">未提交</a>';}  ?>

		</div>
		<div class="m-lineblock">
			<span class="m-map"></span>
			<label>位置信息授权</label>
			<?php if($step['location']==2){echo '<a href="javascript:;" class="identify1">已通过</a>';}else{echo '<a href="javascript:nobasecreadit();">未提交</a>';}  ?>
		</div>
		<div class="m-lineblock" style="border-bottom: 1px solid white">
			<span class="m_face_credit"></span>
			<label>人脸识别</label>
			<?php if($step['faceid']==2){echo '<a href="javascript:;" class="identify1">已通过</a>';}else{echo '<a href="javascript:nobasecreadit();">未提交</a>';}  ?>
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
	<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box_card" style="display: none;">
		<h3 class="t-bomb_box-1" style="border-bottom:1px solid #e5e5e5">提示<a href="javascript:prompt_hide();" class="t-close-btn"></a></h3>
		<p class="t-bomb_box-6" id="t-bomb_box-6" style="line-height: 2rem;font-size: 0.85rem;height:6rem;overflow-y:visible;overflow-x:visible;padding:15px 16px 5px 16px">
			请先添加担保卡和收款还款卡后再进行此操作
		</p>
		<div  class="t-red">
			<a href="/Borrowmoney/guaranteeadd?entrance=promote" class="t-red-btn" style="border:1px solid;float:left;width: 50% ">确定</a>
			<a href="javascript:prompt_hide();" class="t-red-btn" style="border:1px solid;float:right;width: 50% ">取消</a>
		</div>
	</div>
</article>
</body>

</html>

