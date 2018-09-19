<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.config({
		vars: {
			'url':"<?php echo $_VArray['requestUrl']?>"
		}
	});
	seajs.use('js/v2/seajs/account-bank');
</script>
<body>
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a class="return_i i_public" href="javascript:history.go(-1);"></a>更改银行卡
	</div>
</section>
<div class="top_height"></div>
<p class="b-supple-infotxt  credit_p">借款卡必须为本人名下借记卡，并作为您的还款卡。</p>
<section class="index_menu" style="margin-top:0">
	<a href="javascript:;" class="t-re-bank"><p  class="t-re-bank t-login-center-1 border-bottom">借记卡所属银行<span class=""></span></p></a>
	<input type="hidden" name="bank_id" />
	<input type="hidden" name="bank_code" />
	<p class="t-login-center-1 border-bottom">
		<input type="text" name="card_no" value="" class="form-control text_width_100"  placeholder="您本人的借记卡卡号"><span class="t-icon-close"></span>
	</p>
    <p class="t-login-center-1"><?php echo $_VArray['mobile'];?></span></p>
    <!--<p class="t-login-center-1"><input type="text" placeholder="短信验证码" class="t-w240px form-control"><span class="t-icon-close t-mr"></span> <button type="button" class="t-pwd-code">获取验证码</button></p>-->
</section>
<section class="t-login-footer">
    <p class="t-error"></p>
	<p class="agreement">
		<input type="checkbox"  id="checkbox_a1" class="display_none" />
		<label for="checkbox_a1"></label>同意
		<a href="<?php echo URL::site('Protocol/conten?num=4'); ?>">《代扣服务协议》</a>
	</p>
<!--	--><?php //if(!$new){ ?>
<!--         <p class="t-register1"><input type="checkbox" checked id="checkbox_a1" class="chk_1" /><label for="checkbox_a1"></label>同意<a href="--><?php //echo URL::site('Protocol/conten?num=4'); ?><!--">《代扣服务协议》</a></p>-->
<!--    --><?php // } ?>
	<input type="submit" class="t-orange-btn button_submit button_bank t-red-bank" value="<?php echo $_VArray['tip'];?>">
<!--	<input type="submit" class="t-red-btn t-red-bank" value="--><?php //echo $tip;?><!--">-->
</section>
<!-- 选择银行卡弹出 -->
<div class="t-box_alert" id="t-box_alert" style="display:none;">
	<div class="t-bomb_box t-bomb_box-5">
		<h3 class="t-bomb_box-1 t-bomb_box-4 border-bottom">请选择银行<span class="t-bomb_close"></span></h3>
		<div class="t-bomb_box-6">
			<?php foreach($_VArray['bank'] as $v){
				echo '<p class="t-bank-car" code="'.$v['unionpay_code'].'" data="'.$v['name'].'" id="'.$v['id'].'"><input type="radio" name="bank_card_str" id="checkbox_a1'.$v['id'].'" class="chk_1 display_none" /><label for="checkbox_a1'.$v['id'].'"></label>'. HTML::image('static/images/bank-img/'.$v['code'].'.gif',array('class'=>'t-bank-img')).'</p>';
			}?>
		</div>
	</div>
</div>
<div class="t-mask" style="display: none"></div>
<?php //include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
