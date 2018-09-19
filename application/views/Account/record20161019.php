<?php include Kohana::find_file('views', 'public/head');?>
<body>
<!--top bar-->
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>借款记录</div>
</section>
<!--table-->
<section class="b-withdraw-list">
	<table>
		<thead>
		<th>借款日期</th>
		<th>到期日期</th>
		<th class="b-nobr">借款金额</th>
		<th class="b-td-check b-nobr"></th>
		</thead>
		<tbody>
		<!-- hr-line-->
		<?php
		if($order_list){
		foreach($order_list as $val){?>
			<tr>
				<td colspan='3' class='b-nopad'>
					<div class='b-line b-line-mart'></div>
				</td>
			</tr>
			<tr>
				<td><?php echo $val["start_time"];?></td>
				<td class='b-color-red'><?php echo $val["expire_time"];?></td>
				<td class='b-color-orange'><?php echo $val["loan_amount"];?></td>
				<td class='b-td-check'><a href='/User/Singledescribe?id=<?php echo $val["id"];?>' class='b-btn-check'></a></td>
			</tr>
		<?php }?>
		</tbody>
	</table>
	


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
