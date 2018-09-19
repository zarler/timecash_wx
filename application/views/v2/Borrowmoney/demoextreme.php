<?php include Kohana::find_file('views', 'v2/public/head');?>
	<script>
		seajs.config({
			vars: {
				'coin':<?php echo isset($_VArray['coin'])?$_VArray['coin']:0;?>,
				'use_ratio':<?php echo isset($_VArray['use_ratio'])?$_VArray['use_ratio']:0;?>,
				'map':<?php echo $_VArray['map']?>,
				'num':'<?php echo $_VArray['couponlist']['count']?$_VArray['couponlist']['count']:0;?>',
				'count':'<?php echo (isset($_VArray['couponlist']['count'])&&!empty($_VArray['couponlist']['count']))?true:false ?>'
			}
		});
		seajs.use('js/v2/seajs/extremeforms-demo');
	</script>
	<body>
	<!-- 头信息 -->
	<section class="t-login-nav">
		<div class='t-login-nav-1'>
			<a class="return_i i_public" href="/"></a>极速贷
		</div>
	</section>
	<div class="top_height"></div>
	<section class="rapidly_loan_ban">
		<p class="t-loan" style="height:1.4rem;line-height:1.3rem"><em><small><?php echo $_VArray['faststatus']['total_text'] ?></small></em></p>
	</section>
	<section class="t-login-center hidden t-withdraw1 rapidly">
		<div class="t-withdraw t-withdraw5" style="border-bottom: none !important">借款金额</div>
		<ul class="demo money">
			<?php if(!empty($_VArray['amount'])){
				foreach ($_VArray['amount'] as $key=>$val){
					if($key == 0){
						echo '<li class="link able"><em>'.$val.'</em>元</li>';
					}else{
						echo '<li class="link"><em>'.$val.'</em>元</li>';
					}
				}
			} ?>
		</ul>
		<div class="clear"></div>
		<br>
		<div class="t-withdraw t-withdraw5" style="border-bottom: none !important;border-top:1px dashed #e5e5e5">借款期限<br></div>
		<ul class="demo day" style="margin-bottom:0.6rem ">
			<?php if(!empty($_VArray['day'])){
				foreach ($_VArray['day'] as $key=>$val){
					if($key == 0){
						echo '<li class="link able"><em>'.$val.'</em>天</li>';
					}else{
						echo '<li class="link"><em>'.$val.'</em>天</li>';
					}
				}
			} ?>
		</ul>
		<div class="clear"></div>
	</section>
	<section class="t-login-center hidden t-withdraw1">
		<div class="t-withdraw t-withdraw5 border-bottom">
			<?php echo $_VArray['adminCostStr']; ?>
		</div>
		<p class="t-withdraw t-withdraw5 t-bbn t-coupon" data="1"
			<?php if($_VArray['couponlist']['count']!='0'){ echo 'id="show-card"';} ?> >优惠券<img onclick="javascript:commonUtil.cancelShowMsg('每次借款只能选择使用一种优惠方式,您若已选择使用优惠券,将无法使用其他优惠。','我知道了');commonUtil.revisecss();" style="z-index:10;width: 18px;position: relative;top: 4px;" src="/static/images/v2/icon-query.png"><i></i>
			<?php if(empty($_VArray['ordercoupin']['id'])){?>
				<?php if(isset($_VArray['couponlist']['count'])&&!empty($_VArray['couponlist']['count'])){ ?>
					<span class="t-coupon-st1">您有<strong><?php echo $_VArray['couponlist']['count'];?></strong>张优惠券</span>
				<?php }else{ ?>
					<span class="t-coupon-st1">暂无可用优惠券</span>
				<?php } ?>
			<?php }else{ ?>
				<span class="t-coupon-st1" style='color:#e00000;'>已使用<?php echo $_VArray['ordercoupin']['amount_start'];?>元优惠券<input type='hidden' name='couponid' value='<?php echo $_VArray['ordercoupin']['id'];?>' ></span>
			<?php } ?>
		</p>
		<p class="t-withdraw t-withdraw5 t-bbn t-coup border-top">已抵扣手续费<span><em></em>元</span></p>
		<p class="t-withdraw t-withdraw5 deductible border-top">余额抵扣
			<label style="color: #ADABAB;font-size: 10px;margin-left: 15px">余额<em><?php  echo $_VArray['coin'];?></em>元,此次可用<em class="coin_able">0.00</em>元</label>
			<label class="model-1" style="margin-left: 2rem;margin-top: 3rem;">
		  <span class="checkbox" style="top: -.5rem;">
			<input type="checkbox" name="coincheckbox"/>
			<label></label>
		  </span>
			</label>
		</p>
		<p class="t-withdraw t-withdraw5 practical border-top">实际放款金额<span><em>461.00</em>元</span></p>
		<p class="t-withdraw t-withdraw5 t-bbn expire border-top">到期还款金额<span><em>500</em>元</span></p>
	</section>
	<?php echo Form::hidden('poundage');?>
	<section class="t-login-footer">
		<p class="t-error"></p>
		<a class="t-orange-btn position_bottom t-register-button" href="javascript:commonUtil.showconfirm('您还未获得借款资格,请去补充资料!','下载APP');">确定</a>
	</section>
	<div class="t-mask" style="display: none"></div>
	<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box_prompt" style="display: none;">
		<h3 class="t-bomb_box-1" style="border-bottom:1px solid #e5e5e5">提示<a href="javascript:prompt_hide();" class="t-close-btn"></a></h3>
		<p class="t-bomb_box-6" id="t-bomb_box-6" style="line-height: 2rem;font-size: 0.85rem;height:6rem;overflow-y:visible;overflow-x:visible;padding:15px 16px 5px 16px">
			您还未获得借款资格,请去补充资料!
		</p>
		<div>
			<a href="/Promotion/" class="t-red-btn" style="border:1px solid;float:left;width:49% ">下载APP</a>
			<a href="javascript:prompt_hide();" class="t-red-btn" style="border:1px solid;float:right;width: 50% ">忽略</a>
		</div>
	</div>

	<!--优惠券弹层 -->
	<div class="t-box_alert" id="t-box_alert" style="display: none;">
		<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box" style="top:15%;">
			<h3 class="t-bomb_box-1 t-title border-bottom">选择优惠券<a href="javascript:;" class="t-close-btn"></a> </h3>
			<div class="t-bomb_box-7" id="t-bomb_box-6" style="overflow-x:visible">
				<?php if($_VArray['couponlist']['couponlist']){foreach($_VArray['couponlist']['couponlist'] as $v){?>
					<div class="nav-coupon-list coupon-select">
						<div class="t-coupon-card" id="<?php echo $v['id'];?>" data="<?php echo floor($v['amount']);?>"
							<?php if($v['type']=='1'){echo "type=1 min_loan=".$v['min_loan'];}elseif($v['type']=='2'){echo " type=2 min_loan=".$v['min_loan']." day=".$v['min_day'];}elseif($v['type']=='3'){echo " type=3 min_loan=".$v['full_cut'];}?>
						>
							<div class="t-coupon-item-price float_left coupon_border_right_orange"><span>¥</span><?php echo floor($v['amount']);?></div>
							<div class="t-coupon-item-des">
								<p class="t-des-txt1"><?php echo $v['name'];?></p>
								<p class="t-des-txt2"><?php if($v['type']=='1'){echo $v['min_loan']."元以上借款可以使用";}elseif($v['type']=='2'){echo $v['min_loan']."元以上借款,借款天数最少".$v['min_day'].'天';}elseif($v['type']=='3'){echo '手续费金额满'.$v['full_cut'].'才可以使用';}?></p>
								<p class="t-des-txt3">请于<?php echo date("Y-m-d",$v['expire_time']);?>前使用</p>
							</div>
							<a href="javascript:;" class="t-check-btn"  id="btn<?php echo $v['id'];?>"></a>
						</div>
					</div>
				<?php }} ?>
			</div>
			<div class="coupon-pop-btn">
				<p class="t-red" style="">暂不使用优惠券</p>
			</div>
		</div>
	</div>

	</body>
</html>
