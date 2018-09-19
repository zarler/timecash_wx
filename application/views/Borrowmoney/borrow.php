<?php include Kohana::find_file('views', 'public/head');?>
<?php echo HTML::style('static/css/rangeslider.css?12113'); ?>
<script>
	var map = <?php echo $map; ?>;
	seajs.config({
		vars: {
			'num':<?php echo $couponlist['count']?$couponlist['count']:0;?>,
			'available':<?php echo isset($available)?$available:0;?>
		}
	});
	seajs.use('js/online/borrowforms');
	seajs.use('js/online/borrow');
</script>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="/Borrowmoney" class="t-return"></a>立即借款</div>
</section>
<p class="t-loan"><span class="t-line"></span><em>借款信息</em><span></span></p>
<section class="t-login-center hidden">
	<p class="t-withdraw">预借现金可用余额<span><em><?php echo ceil($rule['max_amount']);?></em>元</span></p>
	<div class="t-withdraw1">
		<!--<p class="t-withdraw t-bbn borrowmoney">借款金额<span><em>3000</em>元</span></p>-->
		<p class="t-withdraw t-bbn borrowmoney">借款金额<span><em>500</em>元</span></p>
		<div class="t-withdraw2">
			<div id="js-example-change-value" class="js-change-value">
				<input name='money' type="range" min="<?php echo ceil($rule['min_amount']);?>"  step="100" max="<?php echo ceil($rule['max_amount']);?>" value="<?php echo ceil($rule['min_amount']);?>" data-rangeslider>
				<div class="t-jinbi" style="display: none">
					<p class="t-withdraw2-1"><span><output></output></span></p>
					<div class="t-withdraw2-2"></div>
					<div class="t-withdraw2-3">
						<?php HTML::image('/static/images/t-cash-icon11.png'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="t-withdraw1 t-withdraw1-1" style="border-bottom:none !important;">
		<p class="t-withdraw t-bbn borrowday">借款期限<span><em><?php echo empty($rule['min_day'])?7:$rule['min_day'];?></em>天</span></p>
		<div class="t-withdraw2">
			<div id="js-example-change-value-2" class="js-change-value">
				<input type="range" name="day" min="<?php echo empty($rule['min_day'])?7:$rule['min_day'];?>" max="<?php echo empty($rule['max_day'])?7:$rule['max_day'];?>" value="<?php echo $rule['min_day'];?>" data-rangeslider-2>
				<div class="t-jinbi" style="display: none">
					<p class="t-withdraw2-1"><span><output></output></span></p>
					<div class="t-withdraw2-2"></div>
					<div class="t-withdraw2-3"><img src="/static/images/t-cash-icon11.png"></div>
				</div>
				<!--                <div class="t-ad"><span  class="t-minus"  id="t-minus"></span><span class="t-increase" id="t-increase"></span></div>-->
			</div>
		</div>
	</div>
	<!-- 担保比例 add 0427 -->
    </section>
	<section class="t-login-center hidden">
	<div class="t-withdraw1 t-withdraw1-1 WellForm" style="border-bottom:none !important;">
		<div class="t-withdraw t-bbn borrowscale">担保比例
			<span>
				<?php if(isset($rule['ensure_rate']) && Valid::not_empty($rule['ensure_rate']) && $rule['ensure_rate']!=100){?>
						<?php if($available){?>
							<nav class="WellCheckBox WellCheckBoxH"><input type="radio" checked = 'true' name="ensure_rate" value="<?php echo $rule['ensure_rate']?>"></nav>
							<pre><?php echo $rule['ensure_rate']?>%</pre>
							<nav class="WellCheckBox"><input type="radio" <?php if($poundageinfo['type']==1){echo 'checked = true';}?>   name="ensure_rate" value="100"></nav>
							<pre>100%</pre>
						<?php }else{?>
							<nav class="WellCheckBox prompt"><input type="radio" disabled name="ensure_rate" value="<?php echo $rule['ensure_rate']?>"></nav>
							<pre><?php echo $rule['ensure_rate']?>%</pre>
							<nav class="WellCheckBox WellCheckBoxH"><input type="radio" checked='true' name="ensure_rate" value="100"></nav>
							<pre>100%</pre>
						<?php }?>
				<?php }else{?>
					<nav class="WellCheckBox WellCheckBoxH"><input type="radio" checked='true' name="ensure_rate" value="100"></nav>
					<pre>100%</pre>
				<?php }?>
			</span>
		</div>
		<p class="t-hr-dash"></p>
		<p class="t-withdraw gamount">担保金额<span><em>0</em>元</span></p>
	</div>
	</section>



<section class="t-login-center hidden">
	<div class="t-withdraw t-withdraw5">
		<span class="x-mt poundage"><em>0</em>元</span>借款手续费<br><small>(含管理费与利息)</small>
	</div>
	<div class="t-coupon" data='1'>
		<p class="t-withdraw t-withdraw5 t-bbn"
			<?php if($couponlist['count']!='0'){ echo 'id="show-card"';} ?> >优惠券<i></i>
			<?php if(empty($ordercoupin['id'])){?>
				<?php if(isset($couponlist['count'])&&!empty($couponlist['count'])){ ?>
					<span class="t-coupon-st1">您有<strong><?php echo $couponlist['count'];?></strong>张优惠券</span>
				<?php }else{ ?>
					<span class="t-coupon-st1">暂无可用优惠券</span>
				<?php } ?>
			<?php }else{ ?>
				<span class="t-coupon-st1" style='color:#e00000;'>已使用<?php echo $ordercoupin['amount_start'];?>元优惠券<input type='hidden' name='couponid' value='<?php echo $ordercoupin['id'];?>' ></span>
			<?php } ?>
		</p>
		<!-- 已选择优惠券状态样式 动态添加/删除 t-coupon-hide 样式名称-->
		<?php if(empty($ordercoupin['id'])){ ?>
			<div class="t-coupon-hide t-coup">
				<p class="t-hr-dash"></p>
				<p class="t-withdraw t-bbn t-font-small">已抵扣手续费<span><em></em>元</span></p>
			</div>
		<?php }else{ ?>
			<div  class="t-coup">
				<p class="t-hr-dash"></p>
				<p class="t-withdraw t-bbn t-font-small">已抵扣手续费<span><em><?php echo '-'.$ordercoupin['amount'];?></em>元</span></p>
			</div>
		<?php } ?>
	</div>

	<p class="t-withdraw t-withdraw5 practical" style="border-top: 1px solid #e5e5e5">实际放款金额<span><em>0</em>元</span></p>
	<p class="t-withdraw t-withdraw5 t-bbn expire">到期还款金额<span><em>0</em>元</span></p>
</section>
<?php echo Form::hidden('poundage');?>
<?php //echo Form::hidden('type',$type);?>
<?php echo Form::hidden('latitude');?>
<?php echo Form::hidden('longitude');?>
<section class="t-login-footer">
	<p class="t-error"></p>
	<input type="submit" class="BR_ATF_ACTION t-red-btn t-red-btn-but" value="确定">
</section>
<!--优惠券弹层 -->
<div class="t-box_alert" id="t-box_alert" style="display: none;">
	<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box" style="top:45%;">
		<h3 class="t-bomb_box-1 t-title">选择优惠券<a href="javascript:;" class="t-close-btn"></a> </h3>
		<div class="t-bomb_box-6" id="t-bomb_box-6" style="border-top:1px solid #e5e5e5;overflow-x:visible">
			<?php  if($couponlist['couponlist']){foreach($couponlist['couponlist'] as $v){?>
			<div class="t-coupon-card hidden" id="<?php echo $v['id'];?>" data="<?php echo floor($v['amount']);?>"
			<?php if($v['type']=='1'){echo "type=1 min_loan=".$v['min_loan'];}elseif($v['type']=='2'){echo " type=2 min_loan=".$v['min_loan']." day=".$v['min_day'];}elseif($v['type']=='3'){echo " type=3 min_loan=".$v['full_cut'];}?>
			>
			<div class="t-coupon-card-tb">
				<div class="t-coupon-card-bg"></div>
			</div>
			<div class="t-coupon-card-list">
				<div class="t-coupon-item-price"><span>¥</span><?php echo floor($v['amount']);?></div>
				<div class="t-coupon-item-des">
					<p class="t-des-txt1"><?php echo $v['name'];?></p>
					<p class="t-des-txt2"><?php if($v['type']=='1'){echo $v['min_loan']."元以上借款可以使用";}elseif($v['type']=='2'){echo $v['min_loan']."元以上借款,借款天数最少".$v['min_day'].'天';}elseif($v['type']=='3'){echo '手续费金额满'.$v['full_cut'].'才可以使用';}?></p>
					<p class="t-des-txt3">请于<?php echo date("Y-m-d",$v['expire_time']);?>前使用</p>
				</div>
				<a href="javascript:;" class="t-check-btn <?php if($ordercoupin['id'] == $v['id']){echo "t-check-btn-active t-check-btn-is"; } ?>" id="btn<?php echo $v['id'];?>"></a>
			</div>
		</div>
		<?php }} ?>
	</div>
	<div class="coupon-pop-btn">
		<div  class="t-red"><input type="button" class="t-red-btn" value="暂不使用优惠券" ></div>
	</div>
</div>
</div>
<div class="t-mask" style="display: none"></div>
<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box_prompt" style="display: none;">
	<h3 class="t-bomb_box-1" style="border-bottom:1px solid #e5e5e5">提示<a href="javascript:prompt_hide();" class="t-close-btn"></a></h3>
	<p class="t-bomb_box-6" id="t-bomb_box-6" style="line-height: 2rem;font-size: 0.85rem;height:6rem;overflow-y:visible;overflow-x:visible;padding:15px 16px 5px 16px">
		您的授信信息已过期,请去补充
	</p>
	<div  class="t-red">
		<a href="/Promotion/" class="t-red-btn" style="border:1px solid;float:left;width: 50% ">去极速贷</a>
		<a href="javascript:prompt_hide();" class="t-red-btn" style="border:1px solid;float:right;width: 50% ">忽略</a>
	</div>
</div>


<script type="text/javascript">
	define = null;
	require = null;
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js?123"></script>
<script>
	var borrowurl ='<?php echo URL::site('Functions/borrowinfo'); ?>';
	var ensure_rate  = <?php echo $rule['ensure_rate'];?>;
	wx.config({
		debug: false,
		appId: '<?php echo $signPackage["appId"];?>',
		timestamp:<?php echo $signPackage["timestamp"];?>,
		nonceStr:'<?php echo $signPackage["nonceStr"];?>',
		signature:  '<?php echo $signPackage["signature"];?>',
		jsApiList: [
			'getLocation'
		]
	});
	wx.ready(function(){
		wx.getLocation({
			type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
			success: function (res){
				var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
				var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
				$("input[name='longitude']").val(longitude);
				$("input[name='latitude']").val(latitude);
			},
			cancel: function (res) {
				alert('用户拒绝授权获取地理位置');
			}
		});
	});


</script>
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
					if(result.status == true){
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
	})()
</script>
