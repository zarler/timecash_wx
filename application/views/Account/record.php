<?php include Kohana::find_file('views', 'public/head');?>
<style>
	.ulli li{
		 display:inline-block;
		 width:30%;
		 text-align:center;
		 font-size:.75rem;
		 border-right:1px solid #e0e0e0;
		 border-bottom:1px solid #e0e0e0;
		 height:1.35rem;
		 line-height:1.2rem
	 }
	ul li{
		display:inline-block;
		width:30%;
		text-align:center;
		font-size:.75rem;
		height:1.55rem;
		line-height:2rem
	}
</style>
<body>
<!--top bar-->
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>借款记录</div>
</section>
<!--table-->
<section class="b-withdraw-list">
	<ul class="ulli">
		<li>借款日期</li>
		<li>到期日期</li>
		<li style="border-right: none !important;">借款金额</li>
	</ul>
	<?php
	if($order_list){
	foreach($order_list as $val){?>
		<a href='/User/Singledescribe?id=<?php echo $val["id"];?>'>
		<ul style="border-bottom:1px solid #e0e0e0; height:2.5rem;margin:0 1rem">
			<li><?php echo $val["start_time"];?></li>
			<li class="b-color-red"><?php echo $val["expire_time"];?></li>
			<li class="b-color-orange"><?php echo $val["loan_amount"];?><span class='b-btn-check' style="position: relative;top: 0.2rem;left: 1.2rem"></span></li>
		</ul>
		</a>
	<?php }?>

</section>
	<?php }else{?>
	</tbody>
	</table>
</section>
<div style="text-align: center;line-height:40;width: 100%;height: 100%">
	<?php echo HTML::image('static/images/icon_kong.png',array('style'=>'width:6rem;'));?>
</div>
<?php }?>
</body>
</html>
