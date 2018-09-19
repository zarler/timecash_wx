<?php include Kohana::find_file('views', 'public/head');?>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>立即借款</div>
</section>
<p class="t-loan"><span class="t-line"></span><em>选择担保卡</em><span></span></p>
<section class="t-login-center t-mt0px">
	<dl class="t-loan2 t-add">
		<dt>●</dt>
		<dd>您须添加一张信用卡作为本次借款的担保卡。</dd>
		<dt>●</dt>
		<dd>根据您的借款金额在本平台完成预授权担保，待您成功还款后，预授权可自动取消。若发生还款违约，本预授权将交予债权人处置。</dd>
		<dt>●</dt>
		<dd>本平台只提供撮合中介服务，所有借款均由个人投资者提供</dd>
	</dl>
</section>
<?php  echo Form::open('Borrowmoney/skip', array('id'=>'skipForm')); ?>
<section class="t-login-center">
	<p class="t-add-gu1">预授权金额<span><em>2500</em>元</span></p>
</section>

<input type="hidden"  name="rand" value="<?php echo $rand;?>" />
<section class="t-login-footer">	
	<p class="t-error"></p>
	<input type="submit" class="t-red-btn" href="<?php echo URL::site('Borrowmoney/skip');?>" value="下一步">
</section>
<?php echo Form::close();?>
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