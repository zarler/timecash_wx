<?php include Kohana::find_file('views', 'public/head');?>
<body>
		<section class="t-login-nav">
			<div class="t-login-nav-1"><a href="<?php echo URL::site('User/index');?>" class="t-return"></a>立即还款</div>
		</section>
		<article>
			<section class="m-refundnumbox">
				<p>还款金额</p>
				<p class="m-num"><span><?php echo $order['repayment_amount'];?></span>元</p>
			</section>
			<section class="t-login-center">
				<!--<p class="t-login-center-1 m-addfontsize"><span>还款金额</span><label><?php //echo $order[0]['repayment_amount'];?>元</label></p>-->
				<p class="t-login-center-1  m-addfontsize"><span>还款银行卡</span><label class="t-w-r"> <?php echo $order['bankcard_no'];?></label></p>
				<div class="m-bo1px">
					<!-- <p class="t-login-center-1 m-addheight"><input type="text" placeholder="请输入短信验证码" class="t-w240px"> <span class="t-pwd-code m-position">获取验证码</span></p> -->
					<p class="t-h t-login-center-1" style="height:2.3rem;"><input type="text" placeholder="短信验证码" class="t-w240px form-control" name="code" style="left:0rem"><span class="t-icon-close t-mr t-mt1"></span> <button type="button" class="t-pwd-code">获取验证码</button></p>
			    </div>
			</section> 
			<section class="t-login-footer t-mb1">	
				<p class="t-error m-refunderror"></p>
				<?php if($order['status']== Model_Home::PAGE_TO_REPAY_SUCC){?>
					<section class="m-toborrow">
						<a href="javascript:;" class="t-red-btn m-graycolor">立即还款</a>
					</section>
				<?php }else{ ?>
					<input type="submit" class="t-red-btn" value="立即还款">
				<?php }?>
			</section>
			<?php  echo Form::hidden('orderid',$order['order_id']); ?>
		</article>
	</body>
</html>
<script>
		//点击获取手机验证码
	$(function(){	
		var times = 60;
		$('.t-pwd-code').click(function(){
			var orderid=$("input[name='orderid']").val();
			if(orderid == "" || orderid == undefined || orderid == null || orderid == 0 ) {
				commonUtil.waring('异常错误，请刷新！');
				return false;
			}
			timer = setInterval(function() {
				times--;
				if(times > 0) {
					$('.t-pwd-code').text(times +'秒后重发');
					$('.t-pwd-code').attr('disabled','disabled');
				} else {
					times = 60;
					$('.t-pwd-code').text('重发验证码');
					$('.t-pwd-code').removeAttr('disabled');
					clearInterval(timer);
				}            
			}, 1000);
			$.ajax({
				url:'<?php echo URL::site('Functions/repayCode');?>',
				type:'POST',
				data:{orderid:orderid},
				dataType:'json',
				async: true,  //同步发送请求
				success:function(result){
					if(result.status===false){
						clearInterval(timer);
						commonUtil.waring(result.msg);
						$('.t-pwd-code').removeAttr('disabled');
						return false;
					}else if(result.status===true){
						commonUtil.tips();
						return true;
					}else if(result.status==='10023'){
						clearInterval(timer);
						commonUtil.waring("操作过于频繁");
						$('.t-pwd-code').removeAttr('disabled');
						return false;
					}
				},
				error:function(){
					commonUtil.waring("手机校验失败");
					$('.t-pwd-code').removeAttr('disabled');
					return true;
				}
			});
		});
		<?php if($order['status']== Model_Home::PAGE_TO_REPAY_SUCC){?>
	
			<?php }else{ ?>
			$('.t-red-btn').click(function(){
				commonUtil.lockup();
				var code = $("input[name='code']").val();
				var orderid=$("input[name='orderid']").val();
				if(commonUtil.authcode(code)!=true) {
					commonUtil.unlock();
					return false;
				}
				if(orderid == "" || orderid == undefined || orderid == null || orderid == 0 ) {
					commonUtil.waring('异常错误，请刷新！');
					commonUtil.unlock();
					return false;
				}
				if(code.length==4){
					$.ajax({
						url:'<?php echo URL::site('Functions/doRepay');?>',
						type:'POST',
						data:{code:code,orderid:orderid},
						dataType:'json',
						async: true,  //同步发送请求
						beforeSend:function(){
						},
						success:function(result){
							if(result.status == true){
								location.href = "/Repaymoney/repayStatus"
							}else{
								commonUtil.unlock();
								commonUtil.waring(result.msg);
								return false;
							}
						},
						error:function(){
							commonUtil.waring("表单提交失败");
							commonUtil.unlock();
							return true;
						}
					});
				}else{
					commonUtil.unlock();
					commonUtil.waring('验证码格式错误');
					$('.t-pwd-code').removeAttr('disabled');
					return false;
				}
			});
			<?php }?>

		
		
		var commonUtil={
			lockup:function(){
				$('.t-red-btn').addClass('t-gray-btn');
				$(".t-red-btn").attr('disabled',true);
				$('.t-red-btn').removeClass('t-red-btn');
				load = layer.load(2, {shade: false});
				$('.t-mask').show();
			},
			unlock:function(){
				$('.t-gray-btn').addClass('t-red-btn');
				$(".t-red-btn").attr('disabled',false);
				$('.t-gray-btn').removeClass('t-gray-btn');
				layer.close(load);
				$('.t-mask').hide();
			},
			tips:function(){
				$(".t-error").text('');
			},
			waring:function(msg){
				$(".t-error").text(msg);

			 },
			authcode:function(authcode){
				authcode=$.trim(authcode);
				var pattern = /^[0-9]{4}$/;
				if(authcode =="" || authcode == null ) {
					commonUtil.waring('请填写验证码');
					return false;
				}
				if(!authcode.match(pattern)) {
					commonUtil.waring('请填写正确验证码');
					return false;
				}
				commonUtil.tips();
				return true;
			},

		}
		
     });
</script>