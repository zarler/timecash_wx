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
	<div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>立即借款</div>
</section>
<p class="t-loan"><span class="t-line"></span><em>借款信息</em><span></span></p>
<p class="t-loan" style="height:1.4rem;line-height:1.3rem"><em><small>每天<?php echo date("H:s",$faststatus['today_start']); ?>开放<?php echo $faststatus['today_max']; ?>单，现余<?php echo ($faststatus['today_max']-$faststatus['today_total'])<0?0:$faststatus['today_max']-$faststatus['today_total'] ?>单。</small></em></p>

<section class="t-login-center hidden t-withdraw1">
	<div class="t-withdraw t-withdraw5" style="border-bottom: none !important">
		借款金额
	</div>
	<ul class="demo money" style="">
		<?php if(isset($amount)&&!empty($amount)){foreach ($amount as $key=>$val){ if($key==0){?>
			<li class="link able"><em><?php echo $val; ?></em>元</li>
		<?php }else{ ?>
			<li class="link"><em><?php echo $val; ?></em>元</li>
		<?php }}} ?>
	</ul>
	<br>
	<div class="t-withdraw t-withdraw5" style="border-bottom: none !important;border-top:1px dashed #e5e5e5">
		借款期限<br>
	</div>
	<ul class="demo day" style="margin-bottom:0.6rem">
		<?php if(isset($day)&&!empty($day)){foreach ($day as $key=>$val){ if($key==0){?>
			<li class="link able"><em><?php echo $val; ?></em>天</li>
		<?php }else{ ?>
			<li class="link"><em><?php echo $val; ?></em>天</li>
		<?php }}} ?>
	</ul>
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
<?php echo Form::hidden('latitude');?>
<?php echo Form::hidden('longitude');?>
<?php echo Form::hidden('type',3);?>
<section class="t-login-footer">
    <p class="t-error"></p>
	<input type="submit" class="t-red-btn <?php if(isset($contact)&&$contact==2){ echo "BR_ATF_ACTION t-red-btn-but"; }else{ echo "t-red-btn-but-show";}?>" value="确定">
</section>
<!--优惠券弹层 -->
<div class="t-box_alert" id="t-box_alert" style="display: none;">
    <div class="t-bomb_box t-bomb-absolute" id="t-bomb_box" style="top:45%;">
        <h3 class="t-bomb_box-1 t-title">选择优惠券<a href="javascript:;" class="t-close-btn"></a> </h3>
		<div class="t-bomb_box-6" id="t-bomb_box-6" style="border-top:1px solid #e5e5e5;overflow-x:visible">
			<?php  if($couponlist['couponlist']){foreach($couponlist['couponlist'] as $v){?>
			<div class="t-coupon-card hidden" id="<?php echo $v['id'];?>" data="<?php echo floor($v['amount']);?>"
			<?php if($v['type']=='1'){echo "type=1 min_loan=".$v['min_loan'];}elseif($v['type']=='2'){echo " type=2 min_loan=".$v['min_loan']." day=".$v['min_day'];}elseif($v['type']=='3'){echo " type=3 min_loan=".$v['full_cut'];}?>>
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
		您需要先补充资料后再申请借款
	</p>
	<div  class="t-red">
		<a href="/RegisterApp/ContactsExtreme" class="t-red-btn" style="border:1px solid;float:left;width: 50% ">去补充</a>
		<a href="javascript:prompt_hide();" class="t-red-btn" style="border:1px solid;float:right;width: 50% ">留在此页</a>
	</div>
</div>
<script type="text/javascript">
	define = null;
	require = null;
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js?123"></script>
<script>
	var borrowurl ='<?php echo URL::site('Functions/borrowinfo'); ?>';
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

	function practicalMoney(){
		m = <?php echo $map?>;
		K = $('.money .able em').text();
		N = $('.day .able em').text();
		var eValue='fast_'+K+'_'+N;
		$('.practical em').text(eval((K-m[eValue])).toFixed(2));
		$(".t-coup").hide();
		$('.poundage em').text(m[eValue]);
		$('.expire em').text(K);
		$("input[name='poundage']").val(m[eValue]);
		poundage = $("input[name='poundage']").val();
		num ='<?php echo $couponlist['count']?$couponlist['count']:0;?>';
		$(".t-check-btn-active").removeClass("t-check-btn-active");
		<?php if(isset($couponlist['count'])&&!empty($couponlist['count'])){ ?>
			$(".t-coupon-st1").empty().html("<span>您有<strong>"+num+"</strong>张优惠券</span>");
		<?php } ?>
	}
	$(document).ready(function(){
		if($('a').is('.t-check-btn-is')){
			$('.t-check-btn-is').addClass('t-check-btn-active');
		};
		$(".money li").bind('click',function(){
			$(".money .able").removeClass('able');
			$(this).addClass('able');
			practicalMoney();
		});
		$(".day li").bind('click',function(){
			$(".day .able").removeClass('able');
			$(this).addClass('able');
			practicalMoney();
		});
		$('.t-red-btn-but-show').click(function(){
			prompt_show();
		});
		practicalMoney();
	});
	//优惠券弹层隐藏
	$('.t-close-btn').on('touched click',function(e){
		$("#t-box_alert").hide();
		$('.t-mask').hide();
	});
	//显示券弹层隐藏
	$('#show-card').on('touched click',function(e){
		e.stopPropagation();
		$("#t-box_alert").show();
		$('.t-mask').show();
		var money = $('.money .able em').text();
		var day = $('.day .able em').text();
		alertH("#t-bomb_box");
		coupon(money,day);
	});
	//暂不使用优惠券点击动作
	$(".t-red").on('touched click',function(){
		$(".t-coup").hide();
		$('.t-mask').hide();
		$("#t-box_alert").hide();
		$(".t-coupon-st1").empty().html("您有<strong>"+num+"</strong>张优惠券</span>");
		$(".t-check-btn").removeClass("t-check-btn-active");
		$('.practical em').text(parseFloat(K-poundage).toFixed(2));
	});
	function coupon(money,day){
		$(".t-bomb_box-6 .t-coupon-card").each(function(index,element){
			switch($(this).attr("type")){
				case "1":
					difference = eval(money-$(this).attr("min_loan"));
					var id = $(this).attr("id");
					if(difference<0){
						$("#"+id).removeAttr("is");
						$(this).addClass("t-expire");
						$(this).find('.t-check-btn').removeClass("t-check-btn-active");
						$("#t-bomb_box-6").append($(this));
					}else{
						$("#"+id).attr("is",'y');
						$(this).removeClass("t-expire");
					}
					break;
				case "2":
					differencemoney = eval(money-$(this).attr("min_loan"));
					differenceday = day-$(this).attr("day");
					var id = $(this).attr("id");
					if(differencemoney<0 || differenceday<0){
						$("#"+id).removeAttr("is");
						$(this).addClass("t-expire");
						$(this).find('.t-check-btn').removeClass("t-check-btn-active");
						$("#t-bomb_box-6").append($(this));
					}else{
						$("#"+id).attr("is",'y');
						$(this).removeClass("t-expire");
					}
					break;
				case "3":
					poundagenum = $('.poundage em').text();
					differencemoney = eval(poundagenum-$(this).attr("min_loan"));
					var id = $(this).attr("id");
					if(differencemoney<0){
						$("#"+id).removeAttr("is");
						$(this).addClass("t-expire");
						$(this).find('.t-check-btn').removeClass("t-check-btn-active");
						$("#t-bomb_box-6").append($(this));

					}else{
						$("#"+id).attr("is",'y');
						$(this).removeClass("t-expire");

					}
					break
			}
		});
	}
	//优惠券点击动作
	$(".t-coupon-card").on("click",function(){
		var is = $(this).attr("is");
		if(is=='y'){
			id = $(this).attr('id');
			money = $(this).attr('data');
			$(".t-check-btn").removeClass("t-check-btn-active");
			$("#btn"+id).addClass("t-check-btn-active");
			$("#t-box_alert").hide();
			$(".t-mask").hide();
			$(".t-coupon-st1").empty().html("<span style='color:#e00000;'>已使用"+money+"元优惠券</span><input type='hidden' name='couponid' value='"+id+"' >");
			$(".t-coup").show();
			practical = $('.borrowmoney em').text();
			zmoney = (parseFloat(K-poundage)+parseFloat(money)).toFixed(2);
			if(parseFloat(zmoney)>parseFloat(K)){
				$('.practical em').text(K);
			}else{
				$('.practical em').text(zmoney);
			}
			if(parseInt(money-poundage)>0){
				$(".t-font-small em").text('-'+poundage);
			}else{
				$(".t-font-small em").text('-'+money);
			}
		}
	});
	function prompt_hide(){
		$('.t-mask').hide();
		$('#t-bomb_box_prompt').hide();
	}
	function prompt_show(){
		$('.t-mask').show();
		$('#t-bomb_box_prompt').show();
	}
</script>
</body>
</html>

<?php if(isset($contact)&&$contact==2){ ?>
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
		})()
	</script>
<?php } ?>