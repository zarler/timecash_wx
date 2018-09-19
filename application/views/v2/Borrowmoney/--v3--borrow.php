<?php include Kohana::find_file('views', 'v2/public/head');?>
<?php echo HTML::script('static/js/v2/local/rangeslider.min.js')?>
<script>
	seajs.config({
		vars: {
			coin:<?php echo isset($_VArray['coin'])?$_VArray['coin']:0;?>,
			type:<?php echo isset($_VArray['type'])?$_VArray['type']:1;?>,
			use_ratio:<?php echo isset($_VArray['use_ratio'])?$_VArray['use_ratio']:0;?>,
			map:<?php echo $_VArray['map']?>,
			num:'<?php echo $_VArray['couponlist']['count']?$_VArray['couponlist']['count']:0;?>',
			count:'<?php echo (isset($_VArray['couponlist']['count'])&&!empty($_VArray['couponlist']['count']))?true:false ?>',
			appId:'<?php echo $_VArray['signPackage']["appId"];?>',
			timestamp:<?php echo $_VArray['signPackage']["timestamp"];?>,
			nonceStr:'<?php echo $_VArray['signPackage']["nonceStr"];?>',
			signature:'<?php echo $_VArray['signPackage']["signature"];?>',
			borrowurl:'<?php echo URL::site('Functions/borrowinfo'); ?>',
			ensure_rate:<?php echo $_VArray['rule']['ensure_rate'];?>,
			available:<?php echo isset($_VArray['available'])?$_VArray['available']:0;?>
		}
	});
	seajs.use('js/v2/seajs/borrow');
</script>
<body>
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'><a class="return_i i_public" href="/"></a>担保借款</div>
</section>
<div class="top_height"></div>
<section class="c-borrow-promote" style="position: relative">
	<div style="text-align: center;line-height: 1.6;padding-top: 1.5rem">预借现金可用余额(元)<br><em><?php echo ceil($_VArray['rule']['max_amount']);?></em></div>
	<div class='wave -one'></div>
	<div class='wave -two'></div>
	<div class='wave -three'></div>
	<div class='wave -four'></div>
</section>
<section class="t-login-center hidden t-withdraw1">
	<div class="t-withdraw21">
		<div class="t-withdraw2">
			<div id="js-example-change-value" class="js-change-value">
				<input name="money" type="range" min="<?php echo ceil($_VArray['rule']['min_amount']);?>" step="<?php echo ceil($_VArray['rule']['amount_step_line']);?>" max=<?php echo ceil($_VArray['rule']['max_amount']);?> value="<?php echo ceil($_VArray['rule']['min_amount']);?>" data-rangeslider="" style="position: absolute; width: 1px; height: 1px; overflow: hidden; opacity: 0;">
				<div class="t-jinbi" style="display: none">
					<p class="t-withdraw2-1"><span><output>500</output></span></p>
					<div class="t-withdraw2-2"></div>
					<div class="t-withdraw2-3">
					</div>
				</div>
			</div>
		</div>
		<p class="t-withdraw1 t-bbn borrowmoney t-withdraw6"><span style="float: left"><em><?php echo ceil($_VArray['rule']['min_amount']);?></em>元</span><span><em><?php echo ceil($_VArray['rule']['max_amount']);?></em>元</span></p>
		<div class="clear"></div>
	</div>
	<div class="t-withdraw21 t-withdraw1-1" style="border-bottom:none !important;">
		<div class="t-withdraw2">
			<div id="js-example-change-value-2" class="js-change-value">
				<input type="range" name="day" step="<?php echo ceil($_VArray['rule']['day_step_line']);?>" min="<?php echo empty($_VArray['rule']['min_day'])?7:$_VArray['rule']['min_day'];?>" max="<?php echo empty($_VArray['rule']['max_day'])?7:$_VArray['rule']['max_day'];?>" value="<?php echo empty($_VArray['rule']['min_day'])?7:$_VArray['rule']['min_day'];?>" data-rangeslider-2="" style="position: absolute; width: 1px; height: 1px; overflow: hidden; opacity: 0;">
				<div class="t-jinbi" style="display: none">
					<p class="t-withdraw2-1"><span><output>7</output></span></p>
					<div class="t-withdraw2-2"></div>
					<div class="t-withdraw2-3"></div>
				</div>
				<!--                <div class="t-ad"><span  class="t-minus"  id="t-minus"></span><span class="t-increase" id="t-increase"></span></div>-->
			</div>
		</div>
		<p class="t-withdraw1 t-bbn borrowday t-withdraw6"><span style="float: left"><em><?php echo empty($_VArray['rule']['min_day'])?7:$_VArray['rule']['min_day'];?></em>天</span><span><em><?php echo empty($_VArray['rule']['max_day'])?7:$_VArray['rule']['max_day'];?></em>天</span></p>
		<div class="clear"></div>
	</div>
</section>
<section class="t-login-center hidden t-withdraw1">
	<div class="t-withdraw t-withdraw5 WellForm practical border-bottom">担保比例
			<span>
				<?php if(isset($rule['ensure_rate']) && Valid::not_empty($_VArray['rule']['ensure_rate']) && $_VArray['rule']['ensure_rate']!=100){?>
					<?php if($_VArray['available']){?>
						<nav class="WellCheckBox WellCheckBoxH"><input type="radio" checked = 'true' name="ensure_rate" value="<?php echo $_VArray['rule']['ensure_rate']?>"></nav>
						<pre><?php echo $_VArray['rule']['ensure_rate']?>%</pre>
						<nav class="WellCheckBox"><input type="radio" <?php if($_VArray['poundageinfo']['type']==1){echo 'checked = true';}?>   name="ensure_rate" value="100"></nav>
						<pre>100%</pre>
					<?php }else{?>
						<nav class="WellCheckBox prompt"><input type="radio" disabled name="ensure_rate" value="<?php echo $_VArray['rule']['ensure_rate']?>"></nav>
						<pre><?php echo $rule['ensure_rate']?>%</pre>
						<nav class="WellCheckBox WellCheckBoxH"><input type="radio" checked='true' name="ensure_rate" value="100"></nav>
						<pre>100%</pre>
					<?php }?>
				<?php }else{?>
					<nav class="WellCheckBox WellCheckBoxH"><input type="radio" checked='true' name="ensure_rate" value="100"></nav>
					<pre>100%</pre>
				<?php }?>
			</span>
		</p>
	</div>
	<p class="t-withdraw t-withdraw5  border-bottom gamount">担保金额<span><em>0</em>元</span></p>
	<div class="t-withdraw t-withdraw5 border-bottom">
		<?php echo $_VArray['adminCostStr']; ?>
	</div>
	<p class="t-withdraw t-withdraw5 t-bbn t-coupon" data="1"
		<?php if($_VArray['couponlist']['count']!='0'){ echo 'id="show-card"';} ?> >优惠券<img onclick="javascript:commonUtil.cancelShowMsg('每次借款只能选择使用一种优惠方式,您若已选择使用优惠券,将无法使用其他优惠。','我知道了');commonUtil.revisecss();" style="z-index:10;width: 18px;position: relative;top: 4px;" src="/static/images/v2/icon-query.png"><i></i>
		<?php if(empty($_VArray['ordercoupin']['id'])){?>
			<?php if(isset($couponlist['count'])&&!empty($_VArray['couponlist']['count'])){ ?>
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
			<input type="checkbox" name="coincheckbox" style="height: 30px;"/>
			<label></label>
		  </span>
		</label>
	</p>
	<p class="t-withdraw t-withdraw5 practical border-top">实际放款金额<span><em>461.00</em>元</span></p>
	<p class="t-withdraw t-withdraw5 t-bbn expire border-top">到期还款金额<span><em>500</em>元</span></p>
</section>

<?php echo Form::hidden('poundage');?>
<?php echo Form::hidden('latitude');?>
<?php echo Form::hidden('longitude');?>
<section class="t-login-footer">
	<p class="t-error"></p>
	<input style="z-index: 12;" type="submit" class="BR_ATF_ACTION t-orange-btn position_bottom t-orange-btn-but" value="确定"><br><br>
</section>
<div class="t-mask" style="display: none"></div>

<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box_prompt" style="display: none;">
	<h3 class="t-bomb_box-1" style="border-bottom:1px solid #e5e5e5">提示<a href="javascript:prompt_hide();" class="t-close-btn"></a></h3>
	<p class="t-bomb_box-6"  style="line-height: 2rem;font-size: 0.85rem;height:6rem;overflow-y:visible;overflow-x:visible;padding:15px 16px 5px 16px">
		您的授信信息已过期,请去补充
	</p>
	<div  class="t-red">
		<a href="/Promotion/" class="t-red-btn" style="border:1px solid;float:left;width: 50% ">去极速贷</a>
		<a href="javascript:prompt_hide();" class="t-red-btn" style="border:1px solid;float:right;width: 50% ">忽略</a>
	</div>
</div>
<!--优惠券弹层 -->
<div class="t-box_alert" id="t-box_alert" style="display: none;">
	<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box" style="top:15%;">
		<h3 class="t-bomb_box-1 t-title border-bottom">选择优惠券<a href="javascript:;" class="t-close-btn"></a> </h3>
		<div class="t-bomb_box-7" id="t-bomb_box-6" style="overflow-x:visible">
			<?php  if($_VArray['couponlist']['couponlist']){foreach($_VArray['couponlist']['couponlist'] as $v){?>
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

<script type="text/javascript">
	;(function(){
		var win = window,
			doc = document,
			br = win["BAIRONG"] = win["BAIRONG"] || {},
			s = doc.createElement("script"),
			url = '//static.100credit.com/ifae/js/braf.min.js';
		s.charset = "utf-8";
		s.src = url;
		br.client_id = "3000128";
		doc.getElementsByTagName("head")[0].appendChild(s);
		br.BAIRONG_INFO = {
			"app" : "antifraud",  //业务类型 必选
			"event" : "lend",   //借款事件   必选
			//登录事件为"event" : "login",    注册事件为"event" : "register",
			"page_type" : "dft"    //当前页面类型，请勿修改    必选
		};
		win.GetSwiftNumber=function(data){
			if(window.isGetSwiftNumberExec){
				return;
			}
			window.isGetSwiftNumberExec = true;
			//客户代码写到下方，接口请求超过一秒，立即执行GetSwiftNumber并且无法拿到流水号
			$.ajax({
				url:'/Functions/BaiRongCredit',
				type:'POST',
				data:{event:data.response.event,swift_number:data.response.af_swift_number},
				dataType:'json',
				async: true,  //同步发送请求
				success:function(result){
					if(result.status==true){
						//commonUtil.tips();
						borrowClick();
					}else{
						commonUtil.waring(result.msg);
					}
				},
				error:function(){
					commonUtil.waring("数据获取失败");
				}
			});
		};
	})();
	function stopBubbling(e) {
		e = window.event || e;
		if (e.stopPropagation) {
			e.stopPropagation();      //阻止事件 冒泡传播
		} else {
			e.cancelBubble = true;   //ie兼容
		}
	}
</script>
