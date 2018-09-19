<?php include Kohana::find_file('views', 'public/head');?>
<?php echo HTML::style('static/css/rangeslider.css?12113'); ?>
<?php echo HTML::script('static/js/rangeslider.min.js'); ?>
<style>
	ul{
		margin: 0;
		padding: 0;
		text-align: center;
		list-style: none;
		overflow: hidden;
	}
	ul li{
		display: inline;
		line-height: 1.5rem;
		text-align: center;
		color: #666;
		font-size: 16px;
		border-radius: 0.3rem;
		background-color: #fefefe;
		text-decoration: none;
		border: solid 2px #eee;
		padding: 8px 20px;
		margin: 0 6px 6px 4%;
		width: 30%;
		float: left;
	}
	ul .able{
		border: solid 2px #ff7200;
		color: #ff7200;
	}
	</style>

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
	<ul class="demo money">
		<?php if(!empty($amount)){
			foreach ($amount as $key=>$val){
				if($key == 0){
					echo '<li class="link able"><em>'.$val.'</em>元</li>';
				}else{
					echo '<li class="link"><em>'.$val.'</em>元</li>';
				}
			}
		} ?>
	</ul>
	<br>
	<div class="t-withdraw t-withdraw5" style="border-bottom: none !important;border-top:1px dashed #e5e5e5">
		借款期限<br>
	</div>
	<ul class="demo day" style="margin-bottom:0.6rem ">
		<?php if(!empty($day)){
			foreach ($day as $key=>$val){
				if($key == 0){
					echo '<li class="link able"><em>'.$val.'</em>天</li>';
				}else{
					echo '<li class="link"><em>'.$val.'</em>天</li>';
				}
			}
		} ?>
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
<section class="t-login-footer">
    <p class="t-error"></p>
	<a class="t-red-btn t-red-btn-but" href="javascript:prompt_show();">确定</a>
</section>
<!--优惠券弹层 -->
<div class="t-box_alert" id="t-box_alert" style="display: none;">
    <div class="t-bomb_box t-bomb-absolute" id="t-bomb_box" style="top:45%;">
        <h3 class="t-bomb_box-1 t-title">选择优惠券<a href="javascript:;" class="t-close-btn"></a> </h3>
		<div class="t-bomb_box-6" id="t-bomb_box-6" style="border-top:1px solid #e5e5e5;overflow-x:visible">
			<?php  if($couponlist['couponlist']){foreach($couponlist['couponlist'] as $v){?>
			<div class="t-coupon-card hidden" id="<?php echo $v['id'];?>" data="<?php echo floor($v['amount']);?>"
			<?php if($v['type']=='1'){echo "type=1 min_loan=".$v['min_loan'];}elseif($v['type']=='2'){echo " type=2 min_loan=".$v['min_loan']." day=".$v['min_day'];}elseif($v['type']=='3'){echo " type=3 min_loan=".$v['full_cut'];}?>
			">
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
		您还未获得借款资格,请去补充资料!
	</p>
	<div>
		<a href="/Promotion/" class="t-red-btn" style="border:1px solid;float:left;width: 50% ">下载APP</a>
		<a href="javascript:prompt_hide();" class="t-red-btn" style="border:1px solid;float:right;width: 50% ">忽略</a>
	</div>
</div>
<script type="text/javascript">
	define = null;
	require = null;
</script>
<script>
	$(document).ready(function(){
		if($('a').is('.t-check-btn-is')){
			$('.t-check-btn-is').addClass('t-check-btn-active');
		}
		$(".money li").click(function(){
			$(".money .able").removeClass('able');
			$(this).addClass('able');
			practical();
		});
		$(".day li").click(function(){
			$(".day .able").removeClass('able');
			$(this).addClass('able');
			practical()
		});
		practical();
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
			if(parseFloat(zmoney).toFixed(2)>parseFloat(K).toFixed(2)){
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
	function practical(){
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
	function prompt_hide(){
		$('.t-mask').hide();
		$('#t-bomb_box_prompt').hide();
	};
	function prompt_show(){
		$('.t-mask').show();
		$('#t-bomb_box_prompt').show();
	};


</script>

</body>
</html>