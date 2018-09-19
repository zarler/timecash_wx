<?php include Kohana::find_file('views', 'public/head');
	if(!empty($ban) && $ban == '1'){
		echo HTML::script('static/js/lockPhoneBackBtn.js');
	} 
?>
<script>
	seajs.config({
		vars: {
			'durl':'<?php echo URL::site('Functions/docredit');?>',
			'url':'/Functions/SubmitReduceApply',
			'jumpurl':'<?php echo isset($entrance)?$entrance: URL::site('Borrowmoney/guarantee');?>'
		}
	});
	seajs.use('js/seajs/borrowmoney-guaranteeadd');
</script>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><?php if(!empty($ban) && $ban == '1'){ echo '<a href="'.URL::site('User/index').'" class="t-return"></a>';}else{echo '<a href="javascript:history.go(-1);" class="t-return"></a>';}?>立即借款</div>
</section>
<p class="t-loan"><span class="t-line"></span><em>添加担保卡</em><span></span></p>
<section class="t-login-center t-mt0px">
	<dl class="t-loan2 t-add">
		<dt>●</dt>
		<dd>您须添加一张信用卡作为本次借款的担保卡。</dd>
		<dt>●</dt>
		<dd>本次借款将通过信用卡预授权订购携程礼品卡作为担保物。</dd>
		<dt>●</dt>
		<dd>本平台只提供撮合中介服务，所有借款均由个人投资者提供。</dd>
		<dt>●</dt>
		<dd>违约或逾期时会将记录写入到信用卡银行的信用报告中。</dd>
	</dl>
</section>


<p class="t-rules"><img src="/static/images/t-cash-question.png"> <a href="javascript:prompt_show();" id="show-rules"> 没有信用卡怎么办?</a></p>

<?php if(!isset($entrance)){ ?>
<section class="t-login-center">
	<p class="t-add-gu1">预授权金额<span><em><?php echo (int)$amount;?></em>元</span></p>
</section>
<?php } ?>

<section class="t-login-center">
	<p class="t-login-center-2 t-bt1px"><input type="text" placeholder="信用卡号码" class="form-control" name="card_no"><span class="t-icon-close"></span></p>
	<!--<p class="t-login-center-1 t-bt1px"><input type="text" placeholder="有效期（月）" class="form-control" name="expire_month" style="width:40%" > / <input type="text" placeholder="有效期（年）" class="form-control" name="expire_yeah" style="width:40%" ><span class="t-icon-close"></span></p>-->
	<p class="t-login-center-2 t-bt1px"><span class="form-label">有效期</span><input type="text" placeholder="" class="form-control form-time" name="expire_month" ><span class="t-icon-close"></span><span class="form-label">月 </span><input type="text" placeholder="" class="form-control form-time" name="expire_yeah"><span class="t-icon-close"></span><span class="form-label">年</span></p>
	<p class="t-login-center-2 t-bt1px"><input type="text" placeholder="安全码CVV2/CVC2" class="form-control" name="security_code"><span class="t-icon-close"></span></p>
	<p class="t-login-center-2"><span class="form-label"><?php echo $mobile;?></span></p>
	<!--
	<p class="t-login-center-1"><input type="text" placeholder="短信验证码" class="t-w240px form-control"><span class="t-icon-close t-mr"></span> <span class="t-pwd-code">获取验证码</span></p>-->
</section>
<section class="t-login-footer">	
	<p class="t-error"></p>
	<!--
	<p class="t-register1"><input type="checkbox" id="checkbox_a1" class="chk_1" /><label for="checkbox_a1"></label>同意<a href="#">《某某协议》</a></p>-->
	<input type="submit" class="t-red-btn t-red-btn-ok" value="下一步">
</section>
<!-- 弹窗-提示 -->
<div class="t-box_alert" id="t-box_alert" style="display:none;">
	<div class="t-bomb_box" id="t-bomb_box">
		<h3 class="t-bomb_box-1">提示</h3>
		<div class="t-bomb_box-3">
			<p>信用卡验证失败，请检查您提交的信息是否正确</p>
		</div>
	   <div class="t-bomb_btn"><input type="button" class="t-red-btn" value="确定"></div>
	</div>
</div>

<div class="t-mask" style="display: none"></div>
<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box_prompt" style="display: none;">
	<h3 class="t-bomb_box-1" style="border-bottom:1px solid #e5e5e5">提示<a href="javascript:prompt_hide();" class="t-close-btn"></a></h3>
	<p class="t-bomb_box-6" id="t-bomb_box-6" style="line-height: 2rem;font-size: 0.85rem;height:6rem;overflow-y:visible;overflow-x:visible;padding:15px 16px 5px 16px">
		如果您没有信用卡，建议您申请无需信用卡担保的极速贷
	</p>
	<div  class="t-red">
		<a href="javascript:prompt_hide();" class="t-red-btn" style="border:1px solid;float:left;width: 50% ">留在此页</a>
		<a href="/Borrowmoney/extremeBorrow" class="t-red-btn" style="border:1px solid;float:right;width: 50% ">去极速贷</a>
	</div>
</div>
<?php include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
