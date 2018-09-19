<?php include Kohana::find_file('views', 'public/head');?>
<script>
	seajs.use('js/seajs/user-index');
</script>
<body>
<article class="m-pbt">
    <section class="m-information">
        <div class="m-pic">
            <!--<span><i class="m-photo"></i></span>-->
			<img src="<?php echo $userinfo['headimgurl'];?>"/>
        </div>
        <p class="m-name"><?php echo $userinfo['name'];?></p>
        <p class="m-limit">授信额度（元）</p>
        <p class="m-limitnum"><?php echo (int)$userinfo['credit_amount'];?></p>

		<?php if($log){if(isset($userinfo['ensure_rate'])&&Valid::not_empty($userinfo['ensure_rate'])){ ?>
		<p class="m-name">担保比例<?php echo $userinfo['ensure_rate']?>%</p>
		<?php }} ?>

    </section>

    <section class="m-login-center">
        <p class="m-title">我的借款<a href="<?php echo URL::site('User/Index');?>"></a></p>
			<?php if($info['status']=== Model_Home::PAGE_TO_CLOSED){?><!-- 强制关闭 !-->
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
		 	<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Borrowmoney');?>" class="t-red-btn m-toborrowbtn">立即借款</a><!-- 这的立即借款可点 !-->
			</section>
			<?php  }elseif($info['status']=== Model_Home::PAGE_TO_PASS){?>
			<p class="m-tip"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a><!-- 通过审核准备借款 !-->
			</section>
			<?php  }elseif($info['status']=== Model_Home::PAGE_TO_REJECT){?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a><!-- 通过审核准备借款 !-->
			</section>

			<?php  }elseif($info['status']=== Model_Home::PAGE_TO_PAY_IN){?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a><!-- 通过放款审核中 !-->
			</section>
			<?php } elseif($info['status']==Model_Home::PAGE_TO_PAID){?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<?php if($info['repayment']){?>
					<a href="<?php echo URL::site('Repaymoney/index');?>" class="t-red-btn m-toborrowbtn">立即还款</a><!-- 已付待还 !-->
				<?php }else{ ?>
					<a href="javascript:;" class="t-red-btn m-graycolor">立即还款</a>
				<?php } ?>
			</section>
			<?php  }elseif($info['status']===Model_Home::PAGE_TO_ACTREPAY_IN){ ?><!-- 主动还款中 !-->
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即还款</a>
			</section>

			<?php  }elseif($info['status']===Model_Home::PAGE_TO_ACTREPAY_FAIL){ ?><!-- 主动还款失败 !-->
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<?php if($info['repayment']){?>
					<a href="<?php echo URL::site('Repaymoney/index');?>" class="t-red-btn m-toborrowbtn">立即还款</a><!-- 已付待还 !-->
				<?php }else{ ?>
					<a href="javascript:;" class="t-red-btn m-graycolor">立即还款</a>
				<?php } ?>
			</section>
			<?php  }elseif($info['status']=== Model_Home::PAGE_TO_DEDUCT_SUCC){?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即还款</a><!-- 通过放款审核中 !-->
			</section>
			<?php  }elseif($info['status']==Model_Home::PAGE_TO_DEDUCT_FAIL){?><!-- 扣款失败 !-->
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<?php if($info['repayment']){?>
					<a href="<?php echo URL::site('Repaymoney/index');?>" class="t-red-btn m-toborrowbtn">立即还款</a><!-- 已付待还 !-->
				<?php }else{ ?>
					<a href="javascript:;" class="t-red-btn m-graycolor">立即还款</a>
				<?php } ?>
			</section>
			<?php  }elseif($info['status']=== Model_Home::PAGE_TO_REPAY_IN){?><!-- 扣款处理中 !-->
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即还款</a>
			</section>
			<?php  }elseif($info['status']=== Model_Home::PAGE_TO_REPAY_FAIL){?><!-- 付款失败 !-->
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即还款</a>
			</section>
			<?php } elseif($info['status']===Model_Home::PAGE_TO_REPAY_SUCC){ ?><!-- 付款成功 !-->
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Borrowmoney');?>" class="t-red-btn m-toborrowbtn">立即借款</a><!-- 还款成功 !-->
			</section>
			<?php  }elseif($info['status']=== Model_Home::PAGE_TO_PREAUTH_IN){?><!-- 预授权处理中 !-->
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a>
			</section>
			<?php  }elseif($info['status']=== Model_Home::PAGE_TO_PREAUTH_SUCC){?><!-- 预授权还款成功 !-->
			<p class="m-tip"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即还款</a>
			</section>

			<?php  }elseif($info['status']===Model_Home::PAGE_TO_PREAUTH_FAIL){ ?><!-- 扣款失败 !-->
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<?php if($info['repayment']){?>
					<a href="<?php echo URL::site('Repaymoney/index');?>" class="t-red-btn m-toborrowbtn">立即还款</a><!-- 已付待还 !-->
				<?php }else{ ?>
					<a href="javascript:;" class="t-red-btn m-graycolor">立即还款</a>
				<?php } ?>
			</section>
			<?php  }elseif($info['status']===Model_Home::PAGE_TO_OVERDUE_IN){ ?><!-- 逾期中 !-->
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<?php if($info['repayment']){?>
					<a href="<?php echo URL::site('Repaymoney/index');?>" class="t-red-btn m-toborrowbtn">立即还款</a><!-- 已付待还 !-->
				<?php }else{ ?>
					<a href="javascript:;" class="t-red-btn m-graycolor">立即还款</a>
				<?php } ?>
			</section>

			<?php  }elseif($info['status']=== Model_Home::PAGE_TO_OVERDUE_SUCC){?>
			<p class="m-tip"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a><!-- 通过放款审核中 !-->
			</section>
			<?php  }elseif($info['status']===Model_Home::PAGE_TO_OVERDUE_FAIL){ ?><!-- 逾期中 !-->
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
				<div class="m-showinfor">
					<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
					<span><em><?php echo $info['con']['day'];?></em>天</span>
					<i></i>
				</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<?php if($info['repayment']){?>
					<a href="<?php echo URL::site('Repaymoney/index');?>" class="t-red-btn m-toborrowbtn">立即还款</a><!-- 已付待还 !-->
				<?php }else{ ?>
					<a href="javascript:;" class="t-red-btn m-graycolor">立即还款</a>
				<?php } ?>
			</section>

			<?php } elseif($info['status']=== Model_Home::PAGE_TO_LEND_MONEY){ ?>
				<p class="m-tip"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Borrowmoney');?>" class="t-red-btn m-toborrowbtn">立即借款</a><!-- 这的立即借款可点 !-->
			</section>

			<?php } elseif($info['status']=== Model_Home::PAGE_TO_GOON){ ?>
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Borrowmoney');?>" class="t-red-btn m-toborrowbtn">继续借款</a>
			</section>

			<?php } elseif($info['status']==='150'){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a>
			</section>
			<?php } elseif($info['status']=== Model_Home::PAGE_TO_CREDIT_BASE_FALSE){ ?>
				<p class="m-tip"><?php echo $info['statustext'];?> </p>
				</section>
				<section class="m-toborrow">
					<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a><!-- 基础授信未通过 !-->
				</section>
			<?php } elseif($info['status']=== Model_Home::PAGE_TO_FORBID){ ?>
				<p class="m-tip"><?php echo $info['statustext'];?> </p>
				</section>
				<section class="m-toborrow">
					<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a><!-- 基础授信未通过 !-->
				</section>



			<?php  }elseif($info['status']=== Model_Home::NEW_USER_NO_BORROW){?>
				<p class="m-tip"><?php echo $info['statustext'];?> </p>
				</section>
				<section class="m-toborrow">
					<a href="/Borrowmoney/index" class="t-red-btn">立即借款</a><!-- 新用户,暂时不能借款 !-->
				</section>



				<!--------------------下面可能没用---------------------------------------------------->

			<?php } elseif($info['status']==='170'){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
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
				<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Borrowmoney');?>" class="t-red-btn m-toborrowbtn">立即借款</a>
			</section>

			<?php }elseif($info['status']==='200'){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
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
				<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?><a href="<?php echo URL::site('User/refuse?type=order');?>"> (原因)</a></p>
			</section>
			<section class="m-toborrow">
				<a href="<?php echo URL::site('Borrowmoney');?>" class="t-red-btn m-toborrowbtn">立即借款</a>
			</section>


			<?php  }elseif($info['status']===Model_Home::PAGE_TO_INIT){ ?>
			<a href="<?php echo URL::site('User/describe?id='.$info['con']['id']);?>">
			<div class="m-showinfor">	
				<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
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
				<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
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
				<span class="m-border"><em><?php echo (int)$info['con']['loan_amount'];?></em>元</span>
				<span><em><?php echo $info['con']['day'];?></em>天</span>
				<i></i>
			</div>
			</a>
			<p class="m-yuqidate"><?php echo $info['statustext'];?></p>
			</section>
			<section class="m-toborrow">
				<a href="javascript:;" class="t-red-btn m-graycolor">立即借款</a>
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
				<a href="javascript:prompt_show();" class="t-red-btn m-toborrowbtn">提交授信</a><!-- 这的立即借款可点 !-->
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
<div class="t-mask" style="display: none"></div>
<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box" style="display: none;top:45%">
	<h3 class="t-bomb_box-1" style="border-bottom:1px solid #e5e5e5">提示</h3>
	<p class="t-bomb_box-6" id="t-bomb_box-6" style="line-height: 2rem;font-size: 0.85rem;height:6rem;overflow-y:visible;overflow-x:visible;padding:15px 16px 5px 16px">
		您尚未通过授信审核，请先在快金APP内提交信息完成授信审核
	</p>
	<div  class="t-red">
		<a href="javascript:prompt_hide();" class="t-red-btn" style="border:1px solid;float:left;width: 50% ">关闭</a>
		<a href="/Promotion/" class="t-red-btn" style="border:1px solid;float:right;width: 50% ">下载APP</a>
	</div>
</div>
</body>
</html>
