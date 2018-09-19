<?php include Kohana::find_file('views', 'public/head');?>
	<body>
		<article>
			<section class="m-con">
			<!--
				<div class="m-block">
					<div class="m-pr">
						<i></i>
						<p>提升额度</p>  
						<em></em>
					</div>
				</div>-->
				<div class="m-block m-addline">
					<div class="m-pr">
						<i class="m-papericon" style="background: url(/static/images/credit/icon_record.png) 0 0 no-repeat;background-size:cover"></i>
						<?php if($log){echo "<a class='m-border' href='".URL::site('Account/BorrowingRecords')."' ><p class='m-border'>借款记录</p>  </a>";}else{echo "<a  href='javascript:layer.msg(\"未登录\")'><p class='m-border'>借款记录</p>  </a>";}?>
						<em></em>
					</div>
					<div class="m-pr">
						<i class="m-papericon" style="background: url(/static/images/credit/icon_manage.png) 0 0 no-repeat;background-size:cover"></i>
						<?php if($log){echo "<a href='".URL::site('Account/Promote')."' ><p >授信管理</p>  </a>";}else{echo "<a href='javascript:layer.msg(\"未登录\")'><p >授信管理</p></a>";}?>
						<em></em>
					</div>
				</div>
				<div class="m-block m-addline">
					<div class="m-pr">
						<i class="m-papericon" style="background: url(/static/images/credit/icon_bankcard.png) 0 0 no-repeat;background-size:cover"></i>
						<?php if($log){ if(in_array($credited,array(1,2,3,4,5,6,7,15))){
							echo "<a  href='".URL::site('Account/bankinfo')."' ><p class='m-border'>更换收款/还款卡</p>  </a>";
						}else{
							echo "<a  href='javascript:layer.msg(\"请先完成授信\")'><p class='m-border'>更换收款/还款卡</p>  </a>";
						}
						}else{echo "<a  href='javascript:layer.msg(\"未登录\")'><p class='m-border'>更换收款/还款卡</p>  </a>";}?>
						<em></em>
					</div>
					<div class="m-pr">
						<i class="m-papericon" style="background: url(/static/images/credit/icon_changepassword.png) 0 0 no-repeat;background-size:cover"></i>
						<?php if($log){echo "<a href='".URL::site('Login/BackPwd')."' ><p >修改密码</p>  </a>";}else{echo "<a href='javascript:layer.msg(\"未登录\")'><p >修改密码</p></a>";}?>
						<em></em>
				    </div>
				 </div>
<!--				 <div class="m-block">-->
<!--					<div class="m-pr">-->
<!--						<i class="m-helpicon"></i>-->
<!--						<a href="--><?php //echo URL::site('Promote/index'); ?><!--" ><p>帮助</p>   </a>-->
<!--						<em></em>-->
<!--					</div>-->
<!--				</div>-->
			</section>
			<?php include Kohana::find_file('views', 'public/menu');?>
		</article>
	</body>
</html>

