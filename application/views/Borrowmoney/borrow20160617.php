<?php include Kohana::find_file('views', 'public/head');?>
<?php echo HTML::style('static/css/rangeslider.css?123'); ?>
<?php echo HTML::script('static/js/rangeslider.min.js'); ?>
<?php echo HTML::script('static/js/borrowforms.js?123'); ?>
<?php echo HTML::script('static/js/lockPhoneBackBtn.js'); ?>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="<?php echo URL::site('User/index');?>" class="t-return"></a>立即借款</div>
</section>
<p class="t-loan"><span class="t-line"></span><em>借款信息</em><span></span></p>
<?php  echo Form::open('Borrowmoney/bankinfo', array('id'=>'borrowForm')); ?>
<section class="t-login-center hidden">
	<p class="t-withdraw">预借现金可用余额<span><em><?php echo ceil($rule['max_amount']);?></em>元</span></p>
	<div class="t-withdraw1">
		<!--<p class="t-withdraw t-bbn borrowmoney">借款金额<span><em>3000</em>元</span></p>-->
		<p class="t-withdraw t-bbn borrowmoney">借款金额<span><em><?php echo ceil($rule['min_amount']);?></em>元</span></p>
				<div class="t-withdraw2">
			<div id="js-example-change-value" class="js-change-value">
		        <input name='money' type="range" min="<?php echo ceil($rule['min_amount']);?>"  step="100" max="<?php echo ceil($rule['max_amount']);?>" value="<?php echo empty($poundageinfo['loan_amount'])?ceil($rule['min_amount']):$poundageinfo['loan_amount'];?>" data-rangeslider>
		        <div class="t-jinbi" style="display: none">
                	<p class="t-withdraw2-1"><span><output></output></span></p>
                	<div class="t-withdraw2-2"></div>
                <div class="t-withdraw2-3">
					<?php HTML::image('/static/images/t-cash-icon11.png'); ?>
				</div>
                </div>
                <div class="t-ad"><p style="margin-bottom:0.9rem;"></p></div>
		    </div>
		</div>
	</div>

	<div class="t-withdraw1 t-withdraw1-1">
		<p class="t-withdraw t-bbn borrowday">借款期限<span><em><?php echo empty($rule['min_day'])?7:$rule['min_day'];?></em>天</span></p>
		<div class="t-withdraw2">
			 <div id="js-example-change-value-2" class="js-change-value">
                <input type="range" name="day" min="<?php echo empty($rule['min_day'])?7:$rule['min_day'];?>" max="<?php echo empty($rule['max_day'])?7:$rule['max_day'];?>" value="<?php echo empty($poundageinfo['day'])?$rule['min_day']:$poundageinfo['day'];?>" data-rangeslider-2>
                <div class="t-jinbi" style="display: none">
                    <p class="t-withdraw2-1"><span><output></output></span></p>
                    <div class="t-withdraw2-2"></div>
                <div class="t-withdraw2-3"><img src="/static/images/t-cash-icon11.png"></div>
                </div>
                <div class="t-ad"><span  class="t-minus"  id="t-minus"></span><span class="t-increase" id="t-increase"></span></div>
            </div>
            
		</div>
	</div>


	<div class="t-withdraw t-withdraw5">
        <span class="x-mt poundage"><em>0</em>元</span>借款手续费<br><small>(含管理费与利息)</small>
    </div>
	
	<div class="t-coupon" data='1'>
        <p class="t-withdraw t-withdraw5 t-bbn"
			<?php if($couponlist['count']!='0'){ echo 'id="show-card"';} ?> >优惠券<i></i>
		<?php if(empty($ordercoupin['id'])){?>
		<span class="t-coupon-st1">您有<strong><?php echo $couponlist['count'];?></strong>张优惠券</span>
		<?php }else{ ?>
		<span class="t-coupon-st1" style='color:#e00000;'>已使用<?php echo $ordercoupin['amount'];?>元优惠券<input type='hidden' name='couponid' value='<?php echo $ordercoupin['id'];?>' ></span>
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
	
</section>
	
	<section class="t-login-center hidden">
		<p class="t-withdraw t-withdraw5 practical">实际放款金额<span><em>0</em>元</span></p>
		<p class="t-withdraw t-withdraw5 t-bbn expire">到期还款金额<span><em>0</em>元</span></p>
	</section>
<?php echo Form::hidden('poundage');?>
<?php echo Form::hidden('type',$type);?>
<section class="t-login-footer">
    <p class="t-error"></p>
	<input type="submit" class="t-red-btn" value="确定">
</section>
<?php echo Form::close();?>
	

<!--优惠券弹层 -->
<div class="t-box_alert" id="t-box_alert" style="display: none;">

<div class="t-mask"></div>
    <div class="t-bomb_box t-bomb-absolute" id="t-bomb_box">
        <h3 class="t-bomb_box-1 t-title">选择优惠券<a href="javascript:;" class="t-close-btn"></a> </h3>
		<div class="t-bomb_box-6" id="t-bomb_box-6">
			<?php foreach($couponlist['couponlist'] as $v){?>
			<div class="t-coupon-card hidden" id="<?php echo $v['id'];?>" data="<?php echo floor($v['amount']);?>"
			<?php if($v['type']=='1'){echo "type=1 min_loan=".$v['min_loan'];}elseif($v['type']=='2'){echo "type=2 min_loan=".$v['min_loan']."day=".$v['min_day'];}elseif($v['type']=='3'){echo '手续费金额满'.$v['full_cut'].'才可以使用';}?>
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
			<?php } ?>
		</div>
	<div class="coupon-pop-btn">
		<div  class="t-red"><input type="button" class="t-red-btn" value="暂不使用优惠券" ></div>
	</div>
    </div>

</div>
<script>
    var borrowurl ='<?php echo URL::site('Functions/borrowinfo'); ?>';
</script>
<script>
    $(function() {
        var $document   = $(document);
        var selector    = '[data-rangeslider],[data-rangeslider-2]';
        var $inputRange = $(selector);
        // Example functionality to demonstrate a value feedback
        // and change the output's value.
        function valueOutput(element) {
            var value = element.value;
            $(element).data('value', value);
            var output = element.parentNode.getElementsByTagName('output')[0];
            var em = element.parentNode.parentNode.parentNode.getElementsByTagName('em')[0];
            output.innerHTML = value;
            em.innerHTML = value;
            a=output.innerHTML;
            b=output.innerHTML;
			practical();
        }
        // Initial value output
        for (var i = $inputRange.length - 1; i >= 0; i--) {
            valueOutput($inputRange[i]);
        };
        // Update value output
        $document.on('input', selector, function(e) {
            valueOutput(e.target);
        });
        // Initialize the elements
        $inputRange.rangeslider({
            polyfill: false
        });
        // Example functionality to demonstrate programmatic value changes
        $document.on('click', '.t-minus', function(e) {
            var $inputRange = $(this).parents('.js-change-value').children('input[type="range"]');
            var a = $inputRange.data('value') ? $inputRange.data('value') : $inputRange.val();
            var value = Math.max(0, --a);
            // alert(value)
            $inputRange.val(value).change();
            $inputRange.data('value', a);
        });

        $document.on('click', '.t-increase', function(e) {
            var $inputRange = $(this).parents('.js-change-value').children('input[type="range"]');
            var a = $inputRange.data('value') ? $inputRange.data('value') : $inputRange.val();
            var value = Math.min(100000, ++a);
            // alert(value)
            $inputRange.val(value).change();
            $inputRange.data('value', a);
        });

		function practical(){
			m = <?php echo $map; ?>;
			K = $('.borrowmoney em').text();
			N = $('.borrowday em').text();
			var eValue='ensure_'+K+'_'+N;
			$('.practical em').text(eval((K-m[eValue])).toFixed(2));
			$(".t-coup").hide();
			$('.poundage em').text(m[eValue]);
			$('.expire em').text(K);
			$("input[name='poundage']").val(m[eValue]);
			num ='<?php echo $couponlist['count']?$couponlist['count']:0;?>';
			$(".t-check-btn-active").removeClass("t-check-btn-active");
			$(".t-coupon-st1").empty().html("您有<strong>"+num+"</strong>张优惠券</span>");
		}
		K = $('.borrowmoney em').text();
		//如果是使用了优惠券 在回来借 计算出实际放款 显示
		couponId='<?php echo $ordercoupin['id'];?>';
		if(couponId!=''){
			couponAmount='<?php echo $ordercoupin['amount']?>';
			var practic = (parseFloat(K-poundage)+parseFloat(couponAmount)).toFixed(2);
			practic = practic>K?K:practic;
			$('.practical em').text(practic);
			$(".t-coupon-st1").empty().html("<span class='t-coupon-st1' style='color:#e00000;'>已使用<?php echo $ordercoupin['amount'];?>元优惠券<input type='hidden' name='couponid' value='<?php echo $ordercoupin['id'];?>' ></span>");
			$(".t-coup").show();
			//$(".t-coupon").attr('data',bug+1);
		}else{
			$(".t-coup").hide();
		}
		//优惠券弹层隐藏
        $('.t-close-btn').on('touched click',function(e){
            $("#t-box_alert").hide();
        });
        //显示券弹层隐藏
        $('#show-card').on('touched click',function(e){
            e.stopPropagation();
            $("#t-box_alert").show();
			var money = $('.borrowmoney em').text();
			var day = $('.borrowday em').text();
			alertH("#t-bomb_box");
			coupon(money,day);
        });
//		//显示所有优惠券动作
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
						break;
					case "3":
						break
				}
			});
		}
    });
	//暂不使用优惠券点击动作
	$(".t-red").on('touched click',function(){
		$(".t-coup").hide();
		$("#t-box_alert").hide();
		$(".t-coupon-st1").empty().html("您有<strong>"+num+"</strong>张优惠券</span>");
		$(".t-check-btn").removeClass("t-check-btn-active");
		$('.practical em').text(parseFloat(K-poundage).toFixed(2));
	})
//
	//优惠券点击动作
		$(".t-coupon-card").on("click",function(){
			var is = $(this).attr("is");
			if(is=='y'){
				id = $(this).attr('id');
				money = $(this).attr('data');
				$(".t-check-btn").removeClass("t-check-btn-active");
				$("#btn"+id).addClass("t-check-btn-active");
				$("#t-box_alert").hide();
				$(".t-coupon-st1").empty().html("<span style='color:#e00000;'>已使用"+money+"元优惠券</span><input type='hidden' name='couponid' value='"+id+"' >");
				$(".t-coup").show();
				practical = $('.borrowmoney em').text();
				//couponAmount='<?php echo $ordercoupin['amount']?>';
				zmoney = (parseFloat(K-poundage)+parseFloat(money)).toFixed(2);
				if(parseFloat(zmoney)>parseFloat(K)){
					$('.practical em').text(K);
				}else{ //alert(zmoney);
					$('.practical em').text(zmoney);
				}
				$(".t-font-small em").text('-'+money);
			}
		})
	$(document).ready(function(){
		if($('a').is('.t-check-btn-is')){
			$('.t-check-btn-is').addClass('t-check-btn-active');
		}
	})
</script>
</body>
</html>