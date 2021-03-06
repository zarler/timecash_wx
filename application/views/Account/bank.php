<?php include Kohana::find_file('views', 'public/head');?>
<script>
	seajs.config({
		vars: {
			'url':'/Functions/dobank'
		}
	});
	seajs.use('js/seajs/account-bank');
</script>
<body>
<section class="t-login-nav">
    <div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a><?php echo $ntitle;?></div>
</section>
<p class="t-loan"><span class="t-line"></span><em>收款/还款银行卡</em><span></span></p>
<section class="t-login-center t-mt0px">
    <a href="javascript:;" class="t-re-bank"><p>借记卡所属银行<span></span></p></a>
	<input type="hidden" name="bank_id" />
	<input type="hidden" name="bank_code" />
    <p class="t-login-center-2 t-bt1px"><input type="text" name="card_no" placeholder="您本人的借记卡卡号" class="form-control"><span class="t-icon-close"></span></p>
    <p class="t-login-center-1"><?php echo $mobile;?></span></p>
    <!--<p class="t-login-center-1"><input type="text" placeholder="短信验证码" class="t-w240px form-control"><span class="t-icon-close t-mr"></span> <button type="button" class="t-pwd-code">获取验证码</button></p>-->
</section>
<section class="t-login-footer">
    <p class="t-error"></p>
<!--	--><?php //if(!$new){ ?>
         <p class="t-register1"><input type="checkbox" checked id="checkbox_a1" class="chk_1" /><label for="checkbox_a1"></label>同意<a href="<?php echo URL::site('Protocol/conten?num=4'); ?>">《代扣服务协议》</a></p>
<!--    --><?php // } ?>
	<input type="submit" class="t-red-btn t-red-bank" value="<?php echo $tip;?>">
    <dl class="t-re-bank1">
        <dt></dt>
        <dd>借款卡必须为本人名下借记卡，并作为您的还款卡。</dd>
    </dl>
</section>
<!-- 选择银行卡弹出 -->
<div class="t-box_alert" id="t-box_alert" style="display:none;">
    <div class="t-bomb_box t-bomb_box-5">
        <h3 class="t-bomb_box-1 t-bomb_box-4">请选择银行<span class="t-bomb_close"></span></h3>
        <div class="t-bomb_box-6">
		<?php foreach($bank as $v){
			echo '<p class="t-bank-car" code="'.$v['unionpay_code'].'" data="'.$v['name'].'" id="'.$v['id'].'"><input type="radio" name="bank_card_str" id="checkbox_a1'.$v['id'].'" class="chk_1" /><label for="checkbox_a1'.$v['id'].'"></label>'. HTML::image('static/images/bank-img/'.$v['code'].'.gif',array('class'=>'t-bank-img')).'</p>';
		}?>
		</div>
    </div>
</div>
<div class="t-box_alert" id="t-box_alert2" style="display:none;">
	<div class="t-bomb_box" id="t-bomb_box">
		<h3 class="t-bomb_box-1">重要提示</h3>
		<p class="t-bomb_box-2">
		请在借款到期前保证卡内有足够余额，到期时会自动划扣卡内余额还款。<br /><br />
		若出现逾期还款，将从您的信用卡内扣除未还款金额及罚息。</p>
	   <div class="t-bomb_btn"><a class="t-gray-btn btn-time" href="javascript:history.go(-1);">确定(10 s)</a></div>
	</div>
</div>
<?php if($new){
	echo Form::hidden('upload','upload');
}else{
	echo Form::hidden('new','new');
} ?>
<?php include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
