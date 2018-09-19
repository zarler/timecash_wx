<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.config({
		vars: {
			'durl':'<?php echo $_VArray['requestUrl'];?>',
		}
	});
	seajs.use('js/v2/seajs/borrowmoney-guarantee');
</script>
<body>

<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a class="return_i i_public" href="<?php echo URL::site('User/index');?>"></a>选择担保卡
	</div>
</section>
<div class="top_height"></div>
<?php include Kohana::find_file('views', 'v2/public/credit');?>

<section class="m-webbox">
	<div class="m-lineblock" style="border-bottom:none">
		<label>预授权金额</label><span style="font-size: .8rem;"><?php echo  $_VArray['amount'];?>元</span>
	</div>
</section>

<?php foreach($_VArray['creditarray'] as $k){ ?>
	<section style="margin-top:1rem">
		<?php if($k['is_expire']==1){ ?>
			<div class="credit_transparent" STYLE="line-height: 3.5;">此卡已失效</div>
		<?php } ?>
		<div class='t-guarantee-list <?php if($_VArray['creditcard_id']==$k['id']){echo 't-select';}?>' data="<?php echo $k['id'];?>">
			<div class='border-bottom top'>
				<img src="<?php echo $k['img']  ?>">
				<label><?php echo $k['bank_name']?></label>
				<span class='float_right'>信用卡</span>
			</div>
			<div class='clear'></div>
			<p class="t-select2"><span style="position:relative;top: 4px">**** **** **** </span><?php print_r($k['card_no']) ?></p>
		</div>
	</section>
<?php } ?>
<p class="t-error"></p>
<section style="margin-top:1rem">
	<a href="<?php echo URL::site('Borrowmoney/guaranteeadd'); ?>" style="color: #b0b0b0;display: block;">
		<div class='t-guarantee-list-add' style="text-align: center;line-height: 1.3;">
				<dl>
					<dt><?php echo HTML::image('static/images/t-cash-icon7.png',array('style'=>'margin-left:auto'));?></dt>
					<dd>添加新担保卡</dd>
				</dl>
		</div>
	</a>
</section>

<div class="top_height"></div>
</body>
</html>
