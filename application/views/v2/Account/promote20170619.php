<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.config({
		vars: {
			'url':'<?php echo URL::site('Functions/SubmitReduceApply'); ?>',
			'shows':<?php echo $reduce_apply['show'];?>,
			'ensure_rate':<?php echo $ensure_rate;?>,
			'enable':<?php echo (isset($reduce_apply['enable'])&&!empty($reduce_apply['enable']))?$reduce_apply['enable']:0 ?>,
			'have_credit':<?php echo ((isset($have_credit)&&!empty($have_credit)))?1:0 ?>
		}
	});
	seajs.use('js/v2/seajs/promote');
</script>
<body>
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a class="return_i i_public" href="/"></a>授信管理
	</div>
</section>
<div class="top_height"></div>
<div class="b-tip-bar">
	<a class="b-color-orange" style="display: block" href="/Promotion"><span>•</span>下载APP提交信息降担保</a>
</div>
<div class="t-mask" style="display: none"></div>
<section class="c-credit-promote">
	<div style="position:relative;top:50px;margin:0 auto;z-index: 1">
		<p class="c-credit-basics-center" style="color:white;z-index: 999">担保比例</p>
		<div class="votebox" style="text-align:center" data-behavior="pie-chart"></div>
	</div>
	<div class="creditban"></div>
	<!-- 可以按按钮 -->
	<?php if($reduce_apply['enable']==1){if($have_credit){?>
		<!-- 直接提交按钮申请 -->
		<a href="javascript:;"><p class="promote_p t-red-company">申请降担保</p></a>
	<?php }else{ ?>
		<!-- 添加信用卡提示 -->
		<a href="javascript:commonUtil.showpublic('请先提交担保卡再进行此操作','确定','/Borrowmoney/guaranteeadd?entrance=promote');commonUtil.revisecss()"><p class="promote_p">申请降担保</p></a>
	<?php }}else{?>
		<!-- 按钮不可以按 -->
		<a href="javascript:;"><p class="promote_p promote_p_c">申请降担保</p></a>
	<?php } ?>
	<p class="c-credit-promote-p"><?php echo $tvtips; ?></p>
</section>
<p class="c-credit-basics">降低担保<span class="float_right" style="font-size:12px">提交下列信息可申请降低担保比例</span></p>

<?php if($jump){ if(isset($credited)&&$credited==5){?>
	<section class="m-webbox">
		<div class="m-lineblock no_border">
			<i class="m-corporation"></i>
			<label>工作和联系人信息</label>
			<?php echo '<a href="javascript:;" class="identify1">已通过</a>'; ?>
			<i class="inter_i float_right"></i>
		</div>
	</section>
<?php }else{?>
	<section class="m-webbox">
		<div class="m-lineblock" style="border-bottom:none !important;">
			<i class="m-corporation"></i>
			<label>工作和联系人信息</label>
			<?php if($step['work_info']==2 && $step['contact']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a style="color: #ff8470" href="/RegisterApp/Company">未提交</a>';}  ?>
			<i class="inter_i float_right"></i>
		</div>
	</section>
<?php }}else{?>
	<section class="m-webbox">
		<div class="m-lineblock" style="border-bottom:none !important;">
			<i class="m-corporation"></i>
			<label>工作和联系人信息</label>
			<?php if($step['work_info']==2 && $step['contact']==2){echo '<a href="javascript:;" class="identify">已提交</a>';}else{echo '<a style="color: #ff8470" href="javascript:commonUtil.showconfirm(\'您还未获得借款资格,请去补充资料!\',\'下载APP\');">未提交</a>';}  ?>
			<i class="inter_i float_right"></i>
		</div>
	</section>
<?php }?>


<!--<section class="t-down-guarantee-button">-->
<!--	<p class="t-error"></p>-->
<!--	<a href="javascript:;" class="t-gray-btn t-red-company">申请降低担保</a>-->
<!--</section>-->
<p class="c-credit-basics">基本授信</p>
<section class="m-webbox">
	<div class="m-lineblock">
		<i class="m-tongxunlu"></i>
		<label>手机通讯录授权</label>
		<?php if($step['phone_book']==2){echo '<a href="javascript:;" class="identify1">已通过</a>';}else{echo '<a style="color: #ff8470" href="javascript:commonUtil.showconfirm(\'请先下载APP完成基础授信\',\'下载APP\');">未提交</a>';}  ?>
		<i class="inter_i float_right"></i>
	</div>
</section>

<section class="m-webbox">
	<div class="m-lineblock">
		<i class="m-map"></i>
		<label>位置信息授权</label>
		<?php if($step['location']==2){echo '<a href="javascript:;" class="identify1">已通过</a>';}else{echo '<a style="color: #ff8470" href="javascript:commonUtil.showconfirm(\'请先下载APP完成基础授信\',\'下载APP\');">未提交</a>';}  ?>
		<i class="inter_i float_right"></i>
	</div>
</section>

<section class="m-webbox">
	<div class="m-lineblock">
		<i class="m-autonym"></i>
		<label>实名认证</label>
		<?php if($step['identity']==2){echo '<a href="javascript:;" class="identify1">已通过</a>';}else{echo '<a style="color: #ff8470" href="javascript:commonUtil.showconfirm(\'请先下载APP完成基础授信\',\'下载APP\');">未提交</a>';}  ?>
		<i class="inter_i float_right"></i>
	</div>
</section>

<section class="m-webbox">
	<div class="m-lineblock no_border">
		<i class="m_face_credit"></i>
		<label>人脸识别</label>
		<?php if($step['faceid']==2){echo '<a href="javascript:;" class="identify1">已通过</a>';}else{echo '<a style="color: #ff8470" href="javascript:commonUtil.showconfirm(\'请先下载APP完成基础授信\',\'下载APP\');">未提交</a>';}  ?>
		<i class="inter_i float_right"></i>
	</div>
</section>
<div class="t-mask" style="display: none"></div>
</body>
</html>

