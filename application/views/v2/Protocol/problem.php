<!DOCTYPE html>
<html lang="zh-cn" class="no-js">
<head>
	<meta http-equiv="Content-Type">
	<meta content="text/html; charset=utf-8">
	<meta charset="utf-8">
	<title><?php echo $title ?></title>
	<meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="email=no">
	<?php echo HTML::style('static/ui_bootstrap/layui/css/layui.css'); ?>
	<?php echo HTML::script('static/js/jquery-1.9.1.min.js'); ?>
	<?php echo HTML::script('static/ui_bootstrap/layui/layui.js'); ?>
	<style type="text/css">
		.layui-colla-title{
			height:auto !important;
			line-height:1.5rem !important;
			padding:10px 15px 10px 35px !important
		}
		.layui-colla-icon{
			top:10px !important;
		}
	</style>
	<script type="text/javascript">
		layui.use(['element', 'layer'], function(){
			var element = layui.element();
			var layer = layui.layer;
			//监听折叠
			element.on('collapse(test)', function(data){
				layer.msg('展开状态：'+ data.show);
			});
		});
	</script>
</head>
<body>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend style="margin-left:22%">快金常见问题与帮助</legend>
</fieldset>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
	<legend>基本问题</legend>
</fieldset>
<div class="layui-collapse" lay-accordion="">
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">1. 在哪里可以下载或注册快金?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;您可以使用微信搜索“快金”或“timecash”关注快金微信公众号,并注册和下载快金 APP。</p>
			<p>&nbsp;&nbsp;苹果用户也可在 APP Store 搜索“快金”安装和注册。</p>
		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">2. 我可以在微信公众号申请借款吗？</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;在使用APP完成基础授信后，可以使用微信公众号申请借款，也可以使用APP进行申请。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">3. 为什么我收不到验证码等短信?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;请您检查一下是否安装了类似 360 手机助手等短信拦截应用,查看短信黑名单或拦截记录。您也可以尝试在信号较强的地方重新尝试。</p>		</div>
		</div>
</div>


<fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
	<legend>信用评估</legend>
</fieldset>
<div class="layui-collapse" lay-accordion="">
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">1. 借款需要具备什么样的条件?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;担保借款：22-55周岁（以二代身份证为准）,极速贷：22-40周岁（以二代身份证为准）。</p>
		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">2. 申请借款需要什么材料?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;您需要提供本人银行卡信息、身份信息,并正确填写个人基本信息即可申请借款。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">3. 整个申请过程需要多久?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;在网络正常的情况下,整个过程一般在 3-5 分钟左右。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">4. 我提交申请后多久可以知道申请结果?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;在正确且完整提交申请资料后，极速贷会在3秒钟以内返回审核结果，担保借款则需2小时左右。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">5. 为什么我授权总是失败?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;应用在您首次操作权限时会提醒您开通相应的权限,您可能已经拒绝开通权限导致此操作失败。解决方式是去“手机设置-应用权限管理”中把对应的权限设置为允许,然后回到快金应用重新操作。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">6. 快金支持哪些银行的银行卡?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;支持的借记卡银行有：工商银行、建设银行、中信银行、民生银行、兴业银行、浦发银行、农业银行、光大银行、平安银行；支持的信用卡银行有：建设银行、中信银行、民生银行、浦发银行、广发银行、华夏银行，光大银行。由于各银行可能有相关调整，请以客服回答为准。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">7. 为什么提示我银行卡信息有误?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;请检查您填写的银行卡预留手机号是否与注册手机号一致，以及银行卡各项信息是否填写正确。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">8. 为什么我的担保比例是100%?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;我们提供了通过提交更多资料降低担保比例的功能，申请降低担保需要根据您的资料综合审核决定，最低可以降至0%。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">9. 为什么我的身份证总是无法拍摄成功?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;为了拍摄更为清晰的照片,请您按应用的提示不断调整照片的拍摄环境或角度,明亮的环境,照片无反光,角度与手机平行都是提高拍摄成功的重要因素。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">10. 为什么我的活体检测总是失败?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;活体检测需要您本人根据应用提醒做出相应的动作,为了提高识别的准确率,请您在较为明亮的环境下进行检测,同时尽快做出动作回应,动作幅度也不要过大或过小。</p>		</div>
	</div>

</div>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
	<legend>借款</legend>
</fieldset>
<div class="layui-collapse" lay-accordion="">
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">1. 什么是极速贷?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;极速贷是无需担保的纯信用借款产品，极速审核，极速放款。</p>
		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">2. 如何提升自己的额度?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;担保借款在按时还款，无逾期记录的前提下，会根据您的信用情况提高您的借款额度，最高提额至10000元。极速贷目前暂不支持提升额度。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">3. 借款额度和借款期限是多少?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;担保借款初始可借款 3000 元,按时还款额度会提升，目前最高可借10000元。借款期限为 7 天至 21 天。极速贷可借款 500 元或 1000元,借款期限分为7天和14天。现金将拨付至您所绑定的储蓄卡,您需要在每笔借款到期还款日保证该卡内有足够的还款金额,以按时还款,维护和提升您的信用水平。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">4. 手续费是什么?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;手续费包括借款利息与管理费。其中管理费包括身份验证费、手机验证费、银行卡验证费、账户管理费、征信审核费、信息发布费、撮合服务费、咨询费等。具体手续费请以借款页面显示为准。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">5. 手续费什么时候收取?为什么我的到账金额比选择的借款金额少?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;手续费是在每次借款成功放款时从借款金额中扣除。在您申请借款成功后,需要先支付利息,所以到账金额和您选择的借款金额不同。</p>		</div>
	</div>

	<div class="layui-colla-item">
		<h2 class="layui-colla-title">6. 确认借款后多久到账?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;在您的收款银行卡正常的情况下,确认借款后 3-5 分钟内可以到账,届时会有短信通知您。</p>		</div>
	</div>

	<div class="layui-colla-item">
		<h2 class="layui-colla-title">7. 我借款或还款时为什么会受到来自第三方公司的短信?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;由于我们会对接有支付牌照的正规第三方支付渠道来协助完成放款或扣款的操作,所以您在借款、还款过程中可能会受到第三方支付渠道的短信通知。
			</p>		</div>
	</div>

</div>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
	<legend>还款</legend>
</fieldset>
<div class="layui-collapse" lay-accordion="">
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">1. 还款日如何计算?在哪里查看我的还款日?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;还款日是按照您实际选择的借款期限自动结算,您可以在快金首页查看借款金额与还款日期。</p>
		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">2. 还款方式有哪些?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;自动扣款:我们会在到期还款日晚上 10 点自动从您所指定的银行卡中进行扣款,帮您 实现自动还款;</p>
			<p>&nbsp;&nbsp;手动还款:您可在借款后,点击首页下方还款按钮,进入还款页面对该笔借款进行手动还款。</p>
		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">3. 可以提前还款吗?提前还款是否能减少手续费?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;可以提前还款。提前还款不会减少手续费。</p>
		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">4. 还款失败怎么办?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;请确认该银行卡的有效性并确保卡内有足够的还款金额。如绑定的银行卡失效,您可重新绑定新的银行卡再次尝试手动还款（联系人工客服即可更换还款卡）或者等待系统扣款。</p>
		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">5. 未能按时还款导致逾期怎么办?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;如您到期还款日当晚22点银行卡内余额不足系统无法全额自动扣款，并且当晚24点前未手动操作还款成功，即属于逾期，会收取相应的逾期费用。</p>
		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">6. 逾期费用如何收取?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;1. 逾期罚息:按未还金额*0.3%/天</p>
			<p>&nbsp;&nbsp;2. 逾期滞纳金:按未还金额*0.1%/天</p>
			<p>&nbsp;&nbsp;同时,如发生逾期会影响您在互联网征信共享组织的信用评级,请务必准时还款!</p>
		</div>
	</div>

	<div class="layui-colla-item">
		<h2 class="layui-colla-title">7. 我借款或还款时为什么会受到来自第三方公司的短信?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;由于我们会对接有支付牌照的正规第三方支付渠道来协助完成放款或扣款的操作,所以您在借款、还款过程中可能会受到第三方支付渠道的短信通知。</p>
		</div>
	</div>

</div>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
	<legend>其他</legend>
</fieldset>
<div class="layui-collapse" lay-accordion="">
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">1. 如何修改手机号码?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;为了您的账号安全，目前暂不支持修改手机号码。</p>
		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">2. 我的个人资料会被泄露吗?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;我们绝不会在任何情况下未经本人授权将您的个人信息透露给任意第三方。</p>		</div>
	</div>
	<div class="layui-colla-item">
		<h2 class="layui-colla-title">3. 客服人员工作时间是多少?</h2>
		<div class="layui-colla-content">
			<p>&nbsp;&nbsp;人工客服工作时间是9：00-18：00。</br>&nbsp;&nbsp;客服邮箱：service@timecash.cn 。</p>	</div>
	</div>
</div>

</body>
</html>


