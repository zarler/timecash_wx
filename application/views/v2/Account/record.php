<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.config({
		vars: {
			'last_id':<?php echo isset($_VArray['last_id'])?$_VArray['last_id']:null;  ?>,
			'total':<?php echo isset($_VArray['total'])?$_VArray['total']:1;  ?>
		}
	});
	seajs.use('js/v2/seajs/borrowingrecords');
</script>

<body>
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a class="return_i i_public" href="/"></a>借款记录
	</div>
</section>
<div class="top_height"></div>
<section class="b-withdraw-list">
	<ul class="ulli">
		<li class='float_left'>借款日期</li>
		<li class='float_left'>到期日期</li>
		<li>借款金额</li>
	</ul>
	<div class="clear"></div>
	<?php if($_VArray['order_list']){foreach($_VArray['order_list'] as $val){?>
		<a href='/User/Singledescribe?id=<?php echo $val["id"];?>'>
			<ul class="ulli border-top">
				<li class='float_left'><?php echo $val["start_time"];?></li>
				<li><?php echo $val["expire_time"];?></li>
				<li style='color:#ff8470;text-align: center;'><?php echo $val["loan_amount"];?><span class='float_right' style="width: 1rem;height: 1rem;position: relative;top: .1rem;background: url(/static/images/v2/icon-into.png) no-repeat;
    background-size: contain;"></span></li>
			</ul>
		</a>
	<?php } if($_VArray['total']<10){}else{?>
			<button onclick="getMore()" style="margin: 1rem auto;display: -webkit-box;width: 5rem;height: 1.3rem;color: white;">查看更多</button>
			<div style="width:1rem;height: 1rem;background: white"></div>
	<?php }?>
	</section>
	<?php }else{?>
	</section>
	<div style="text-align: center;line-height:40;width: 100%;height: 100%">
		<?php echo HTML::image('static/images/icon_kong.png',array('style'=>'width:6rem;'));?>
	</div>
	<?php }?>

</body>
</html>
