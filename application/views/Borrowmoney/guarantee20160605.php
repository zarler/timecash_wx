<?php include Kohana::find_file('views', 'public/head');?>
<?php echo HTML::script('static/v1/js/lockPhoneBackBtn.js'); ?>
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
	<p class="t-add-gu1">预授权金额<span><em><?php echo $amount;?></em>元</span></p>
</section>

<?php foreach($creditarray as $k){ ?>

	
	<section class="t-select-center cdefault <?php if($k["default"]=='1'){echo 't-select';}?>" data="<?php echo $k['id'];?>">
		<div href="#" class="t-select1"><?php echo HTML::image('static/v1/images/bank-img/'.$k['creditcard_id'].'.gif',array('class'=>'t-bank-img')) , $k['bank_name'];?></div>
		<p class="t-select2"><?php echo '•••• •••• •••• '.substr($k['card_no'],-4);?></p>
	</section>
<?php } ?>


<section class="t-login-center t-mb30px">
	<a href="<?php echo URL::site('Borrowmoney/guaranteeadd'); ?>" class="t-select3">
		<dl>
			<dt><?php echo HTML::image('static/v1/images/t-cash-icon7.png');?></dt>
			<dd>添加新担保卡</dd>
		</dl>
	</a>
</section>
<section class="t-login-footer">	
	<p class="t-error"></p>
	<a class="t-red-btn" href="<?php echo URL::site('Borrowmoney/check');?>">下一步</a>
</section>
<?php include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
<script>
	$(function(){
		$('.cdefault').click(function(){
			id = $(this).attr('data');
			$.ajax({
				url:"<?php echo URL::site('Borrowmoney/updatecredit');?>",
				type:'POST',
				data:{id:id},
				dataType:'json',
				async: false,  //同步发送请求t-mask
				beforeSend:function(){
					$('.t-mask').show();
				},
				success:function(result){
					unique=result.status; //alert(unique);
					$('.t-mask').hide();
				}
			});
			if(unique===true){
				$('.t-select-center').removeClass('t-select');
				$(this).addClass('t-select');
			}			
		})
	})
</script>