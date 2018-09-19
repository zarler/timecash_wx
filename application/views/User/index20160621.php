<?php include Kohana::find_file('views', 'public/head');?>
<?php echo HTML::script('static/js/lockPhoneBackBtn.js'); ?>
<body>
<article class="m-pbt">
    <section class="m-information">
        <div class="m-pic">
            <!--<span><i class="m-photo"></i></span>-->
			<img src="<?php echo $userinfo['headimgurl'];?>"/>
        </div>
        <p class="m-name"><?php echo $userinfo['name'];?></p>
        <p class="m-limit">授信额度（元）</p>
        <p class="m-limitnum"><?php echo $userinfo['credit_amount'];?></p>
    </section>
	
    <section class="m-login-center">
        <p class="m-title">进行中的借款<a href="<?php echo URL::site('User/Index');?>"></a></p>
			<?php if($info['status']=== Model_Home::PAGE_TO_CLOSED){?>
			<p class="m-tip"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a><!-- 这的立即借款可点 !-->
			</section>

			<?php }elseif($info['status']==='110'){ ?>
				<p class="m-tip"><?php echo $info['statustext'];?> <a href="<?php echo URL::site('User/refuse?type=identity');?>"> (原因)</a></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a><!-- 这的立即借款可点 !-->
			</section>

			<?php } elseif($info['status']=== Model_Home::PAGE_TO_LEND_MONEY){ ?>
				<p class="m-tip"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Borrowmoney/borrow');?>" class="t-red-btn m-toborrowbtn">立即借款</a><!-- 这的立即借款可点 !-->
			</section>

			<?php } elseif($info['status']=== Model_Home::PAGE_TO_GOON){ ?>
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo $info['con']['loan_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Borrowmoney/borrow');?>" class="t-red-btn m-toborrowbtn">继续借款</a>
			</section>

			<?php } elseif($info['status']==='150'){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo $info['con']['repayment_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a>
			</section>

			<?php } elseif($info['status']==='170'){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo $info['con']['repayment_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?> </p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a>
			</section>


			<?php }elseif($info['status']==='190'){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo $info['con']['repayment_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Borrowmoney/borrow');?>" class="t-red-btn m-toborrowbtn">立即借款</a>
			</section>

			<?php }elseif($info['status']==='200'){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo $info['con']['repayment_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a>
			</section>

			<?php }elseif($info['status']==='210'){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo $info['con']['repayment_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?><a href="<?php echo URL::site('User/refuse?type=order');?>"> (原因)</a></p>
			</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Borrowmoney/borrow');?>" class="t-red-btn m-toborrowbtn">立即借款</a>
			</section>

			<?php  }elseif($info['status']===Model_Home::PAGE_TO_ACTREPAY_IN){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">
				<span class="m-border"><em><?php echo $info['con']['repayment_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a>
			</section>

			<?php  }elseif($info['status']===Model_Home::PAGE_TO_INIT){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo $info['con']['repayment_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a>
			</section>

			<?php  }elseif($info['status']===Model_Home::PAGE_TO_READY){ ?>   <!-- 待审状态 !-->
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">
				<span class="m-border"><em><?php echo $info['con']['repayment_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a>
			</section>

			<?php } elseif($info['status']=== Model_Home::PAGE_TO_LOGIN){ ?><!-- 待审状态 !-->
				<p class="m-tip"><?php echo $info['statustext'];?> </p>
				</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Login/Index');?>" class="t-red-btn m-toborrowbtn">立即登录</a>
			</section>

			<?php }elseif($info['status']==='230'){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo $info['con']['repayment_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a>
			</section>

			<?php } elseif($info['status']===Model_Home::PAGE_TO_PAID){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo $info['con']['repayment_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Repaymoney/index');?>" class="t-red-btn m-toborrowbtn">立即还款</a>
			</section>


			<?php } elseif($info['status']=== Model_Home::PAGE_TO_LOGIN){ ?>
				<p class="m-tip"><?php echo $info['statustext'];?> </p>
				</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Login/Index');?>" class="t-red-btn m-toborrowbtn">立即登录</a><!-- 这的立即借款可点 !-->
			</section>

			<?php } elseif($info['status']=== Model_Home::PAGE_TO_CREDIT){ ?>
				<p class="m-tip"><?php echo $info['statustext'];?> </p>
				</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('RegisterApp/Company');?>" class="t-red-btn m-toborrowbtn">提交授信</a><!-- 这的立即借款可点 !-->
			</section>

			<?php } elseif($info['status']=== Model_Home::PAGE_TO_CREDIT_READY){ ?>
				<p class="m-tip"><?php echo $info['statustext'];?> </p>
				</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">审核中</a><!-- 授信审核中 !-->
			</section>

			<?php } elseif($info['status']=== Model_Home::PAGE_TO_CREDIT_SUBMITTED){ ?>
				<p class="m-tip"><?php echo $info['statustext'];?> </p>
				</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">待审核</a><!-- 授信审核中 !-->
			</section>

			<?php } else{ ?>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a>
			</section>
			<?php } ?>
<?php include Kohana::find_file('views', 'public/menu');?>
	
	

</article>
</body>
</html>
<?php echo HTML::script('static/js/slider.js'); ?>
<script>
	//新闻轮播
	jQuery("#news_list").jCarouselLite({
		auto:2000,
		speed:2000,
		visible:1,
		vertical:false,
		stop:$("#news_list")});
</script>