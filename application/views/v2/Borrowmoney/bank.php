<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.config({
		vars: {
			'durl':'<?php echo isset($_VArray['entrance'])?$_VArray['entrance']:URL::site('Borrowmoney/guarantee?ban=1');?>',
			'requestUrl':"<?php echo isset($_VArray['requestUrl'])?$_VArray['requestUrl']:URL::site('/wx/Functions/dobank?1234');?>"
		}
	});
	seajs.use('js/v2/seajs/borrowmoney-bank');
</script>
<body>
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<?php
            if(!isset($_VArray['back'])){
                if(isset($_VArray['backurl'])){
                    echo '<a class="return_i i_public" href="'.$_VArray['backurl'].'"></a>';
                }else{
                    echo '<a class="return_i i_public" href="javascript:history.go(-1);"></a>';
            }} ?>
        添加收款/还款卡
	</div>
</section>
<div class="top_height"></div>
<section class="rapidly_loan_ban">
	<p class="t-loan" style="color: #555555;margin-left:.75rem;text-align:left;line-height:1.3rem">借款卡必须为本人名下借记卡,并作为您的还款卡</p>
</section>
<section class="index_menu" style="margin-top:0">
	<a href="javascript:;" class="t-re-bank"><p  class="t-re-bank t-login-center-1 border-bottom">借记卡所属银行<span class=""></span></p></a>
	<input type="hidden" name="bank_id" />
	<input type="hidden" name="bank_code" />
	<p class="t-login-center-1 border-bottom">
		<input type="text" name="card_no" value="" class="form-control text_width_100"  placeholder="您本人的借记卡卡号"><span class="t-icon-close"></span>
	</p>
	<p class="t-login-center-1 border-bottom">
		<input type="text" name="name" value="" class="form-control text_width_100"  placeholder="姓名"><span class="t-icon-close"></span>
	</p>
	<p class="t-login-center-1 border-bottom">
		<input type="text" name="identity_code" value="" class="form-control text_width_100"  placeholder="身份证号"><span class="t-icon-close"></span>
	</p>
	<p class="t-login-center-1">
		<input type="text" name="phone" value="<?php echo $_VArray['userinfo']['mobile']  ?>" class="form-control" disabled="1"  placeholder="请输入您的手机号">		<span class="t-icon-close">
		</span></p>
<!--	<p class="t-login-center-1">-->
<!--		<input type="text" name="authcode" value="" class="t-w240px form-control" placeholder="请输入验证码">		<span class="t-icon-close t-mr"></span><button type="button" class="t-pwd-code">获取验证码</button></p>-->
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
<section class="t-login-footer">
	<p class="t-error"></p>
	<p class="agreement">
		<input type="checkbox"  id="checkbox_a1" class="display_none" />
		<label for="checkbox_a1"></label>同意
		<a href="<?php echo URL::site('Protocol/conten?num=4'); ?>">《代扣服务协议》</a>
	</p>
	<input type="submit" class="t-orange-btn button_submit button_bank" value="下一步"><br><br>
</section>
<div class="t-mask" style="display: none"></div>
<div class="t-box_alert" id="t-box_alert2" style="display:none;">
	<div class="t-bomb_box" id="t-bomb_box">
		<h3 class="t-bomb_box-1 border-bottom">重要提示</h3>
		<p class="t-bomb_box-2"><?php echo $_VArray['prompt']?></p>
		<div class="t-bomb_btn"><a class="t-gray-btn btn-time" href="javascript:;">确定(10 s)</a></div>
<!--		<div class="t-bomb_btn"><a class="t-gray-btn btn-time" href="javascript:;">确定(10 s)</a></div>-->
	</div>
</div>
</body>
</html>
