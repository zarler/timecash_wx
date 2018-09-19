<?php include Kohana::find_file('views', 'public/head');?>
<script>
	seajs.config({
		vars: {
			'durl':'<?php echo URL::site('Functions/docreditorder?1234');?>'
		}
	});
	seajs.use('js/seajs/borrowmoney-guarantee');
</script>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="<?php echo URL::site('User/index');?>" class="t-return"></a>立即借款</div>
</section>
<p class="t-loan"><span class="t-line"></span><em>选择担保卡</em><span></span></p>
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
<section class="t-login-center">
	<p class="t-add-gu1">预授权金额<span><em><?php echo (int)$amount;?></em>元</span></p>
</section>

<?php foreach($creditarray as $k){ ?>
<section class="t-select-center cdefault <?php if($creditcard_id==$k['creditcard_id']){echo 't-select';}?>" data="<?php echo $k['id'];?>">
		<div href="#" class="t-select1"><?php echo HTML::image('static/images/bank-img/'.$k['bank_code'].'.gif',array('class'=>'t-bank-img')) , $k['bank_name'];?></div>
		<p class="t-select2"><span style="position:relative;top: 4px">**** **** **** </span><?php print_r($k['card_no']) ?></p>
	</section>
<?php } ?>


<section class="t-login-center t-mb30px">
	<a href="<?php echo URL::site('Borrowmoney/guaranteeadd'); ?>" class="t-select3">
		<dl>
			<dt><?php echo HTML::image('static/images/t-cash-icon7.png');?></dt>
			<dd>添加新担保卡</dd>
		</dl>
	</a>
</section>
<section class="t-login-footer">	
	<p class="t-error"></p>
	<a class="t-red-btn" href="javascript:;">下一步</a>
</section>
<?php include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
