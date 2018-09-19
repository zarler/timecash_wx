<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.config({

	});
//	seajs.use('js/v2/seajs/promote');
</script>
<body>
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a class="return_i i_public" href="/"></a>授信管理
	</div>
</section>
<div class="top_height"></div>
<div class="t-mask" style="display: none"></div>
<!--<p class="c-credit-basics">降低担保<span class="float_right" style="font-size:12px">提交下列信息可申请降低担保比例</span></p>-->
<!--<section class="t-down-guarantee-button">-->
<!--	<p class="t-error"></p>-->
<!--	<a href="javascript:;" class="t-gray-btn t-red-company">申请降低担保</a>-->
<!--</section>-->
<p class="c-credit-basics">完成以下资料才可申请借款</p>
<section class="m-webbox" style="margin-bottom: 10px;">
	<div class="m-lineblock" style="border-bottom:none !important;">
		<i class="m-tongxunlu"></i>
		<label>实名绑卡认证</label>
		<a style="color: #ff8470" href="javascript:commonUtil.showconfirm('请先下载APP完成基础授信','下载APP');">未提交</a>
		<i class="inter_i float_right"></i>
	</div>
</section>

<section class="m-webbox">
	<div class="m-lineblock">
		<i class="m-tongxunlu"></i>
		<label>手机通讯录授权</label>
		<a style="color: #ff8470" href="javascript:commonUtil.showconfirm('请先下载APP完成基础授信','下载APP');">未提交</a>
		<i class="inter_i float_right"></i>
	</div>
</section>

<section class="m-webbox">
	<div class="m-lineblock">
		<i class="m-map"></i>
		<label>位置信息授权</label>
		<a style="color: #ff8470" href="javascript:commonUtil.showconfirm('请先下载APP完成基础授信','下载APP');">未提交</a>
		<i class="inter_i float_right"></i>
	</div>
</section>

<section class="m-webbox">
	<div class="m-lineblock">
		<i class="m-corporation"></i>
		<label>工作和联系人信息</label>
		<a style="color: #ff8470" href="javascript:commonUtil.showconfirm('请先下载APP完成基础授信','下载APP');">未提交</a>
		<i class="inter_i float_right"></i>
	</div>
</section>
<section class="m-webbox">
	<div class="m-lineblock">
		<i class="m-autonym"></i>
		<label>实名认证</label>
		<a style="color: #ff8470" href="javascript:commonUtil.showconfirm('请先下载APP完成基础授信','下载APP');">未提交</a>
		<i class="inter_i float_right"></i>
	</div>
</section>

<section class="m-webbox">
	<div class="m-lineblock" style="border-bottom:none !important;">
		<i class="m_face_credit"></i>
		<label>人脸识别</label>
		<a style="color: #ff8470" href="javascript:commonUtil.showconfirm('请先下载APP完成基础授信','下载APP');">未提交</a>
		<i class="inter_i float_right"></i>
	</div>
</section>



<div class="t-mask" style="display: none"></div>
</body>
</html>

