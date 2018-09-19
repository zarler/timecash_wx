<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.config({
		vars: {
			'codeurl':"<?php echo URL::site('/wx/Functions/repayCode');?>",
			'repayurl':"<?php echo URL::site('/wx/Functions/doRepay');?>",
			'orderstatus':"<?php echo $_VArray['order']['status'] ?>"
		}
	});
	seajs.use('js/v2/seajs/repaymoney');
</script>
<body>
		<!-- 头信息 -->
		<section class="t-login-nav">
			<div class='t-login-nav-1'>
				<a class="return_i i_public" href="<?php echo URL::site('User/index');?>"></a>立即还款
			</div>
		</section>
		<div class="top_height"></div>
		<article>
			<section class="m-refundnumbox">
				<p class="m-num"><span><?php echo $_VArray['order']['repayment_amount'];?></span>元</p>
				<p style="margin-top:.8rem;">还款金额</p>
			</section>
			<section class="t-login-center" style="padding:0">
				<!--<p class="t-login-center-1 m-addfontsize"><span>还款金额</span><label><?php //echo $order[0]['repayment_amount'];?>元</label></p>-->
				<p class="t-login-center-1  m-addfontsize border-bottom"><span>还款银行卡</span><label class="t-w-r"> <?php echo $_VArray['order']['bankcard_name'].$_VArray['order']['bankcard_no'];?></label></p>
				<div class="m-bo1px">
					<!-- <p class="t-login-center-1 m-addheight"><input type="text" placeholder="请输入短信验证码" class="t-w240px"> <span class="t-pwd-code m-position">获取验证码</span></p> -->
					<p class="t-h t-login-center-1" style="height:2.3rem;"><input type="text" placeholder="请输入短信验证码" class="t-w240px form-control" name="code" style="left:0rem"><span class="t-icon-close t-mr t-mt1"></span> <button type="button" class="t-pwd-code">获取验证码</button></p>
			    </div>
			</section> 
			<section class="t-login-footer t-mb1">	
				<p class="t-error m-refunderror"></p>
				<?php if($_VArray['order']['status']== Model_Home::PAGE_TO_REPAY_SUCC){?>
					<section class="m-toborrow">
						<input type="submit" class="t-orange-btn button_submit t-register-button m-graycolor" value="立即还款">
					</section>
				<?php }else{ ?>
					<input type="submit" class="t-orange-btn button_submit t-register-button button_repay" value="立即还款">
				<?php }?>
			</section>
			<?php  echo Form::hidden('orderid',$_VArray['order']['order_id']); ?>
		</article>
	</body>
</html>