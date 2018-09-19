<?php include Kohana::find_file('views', 'v2/public/head');?>
	<script>
		seajs.config({
			vars:{
				map:<?php echo $map?>,
				num:'<?php echo $couponlist['count']?$couponlist['count']:0;?>',
				count:'<?php echo (isset($couponlist['count'])&&!empty($couponlist['count']))?true:false ?>',
				appId:'<?php echo $signPackage["appId"];?>',
				timestamp:<?php echo $signPackage["timestamp"];?>,
				nonceStr:'<?php echo $signPackage["nonceStr"];?>',
				signature:'<?php echo $signPackage["signature"];?>',
				borrowurl:'<?php echo URL::site('Functions/borrowinfo'); ?>'
			}
		});
		seajs.use('js/v2/seajs/extremeforms');
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
		<p class="t-loan" style="height:1.4rem;line-height:1.3rem"><em><small><?php echo $faststatus['total_text'] ?></small></em></p>
	</section>
	<section class="t-login-center hidden t-withdraw1 rapidly">
		<div class="t-withdraw t-withdraw5" style="border-bottom: none !important">借款金额</div>
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
		<div class="clear"></div>
		<br>
		<div class="t-withdraw t-withdraw5" style="border-bottom: none !important;border-top:1px dashed #e5e5e5">借款期限<br></div>
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
		<div class="clear"></div>
	</section>
	<section class="t-login-center hidden t-withdraw1">
		<div class="t-withdraw t-withdraw5 border-bottom">
			<span class="x-mt poundage"><em>39.00</em>元</span>借款手续费<br><small>(含管理费与利息)</small><br>
		
		</div>
		<p class="t-withdraw t-withdraw5 t-bbn t-coupon" data="1"
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
		<p class="t-withdraw t-withdraw5 t-bbn t-coup border-top">已抵扣手续费<span><em></em>元</span></p>
		<p class="t-withdraw t-withdraw5 practical border-top">实际放款金额<span><em>461.00</em>元</span></p>
		<p class="t-withdraw t-withdraw5 t-bbn expire border-top">到期还款金额<span><em>500</em>元</span></p>
	</section>
	<?php echo Form::hidden('poundage');?>
	<?php echo Form::hidden('latitude');?>
	<?php echo Form::hidden('longitude');?>
	<?php echo Form::hidden('type',3);?>
	<section class="t-login-footer">
		<p class="t-error"></p>
		<a class="t-orange-btn position_bottom t-register-button <?php if(isset($contact)&&$contact==2){ echo "BR_ATF_ACTION t-red-btn-but"; }else{ echo "t-red-btn-but-show";}?>" href="javascript:;">确定</a>
	</section>


	
	<div class="t-mask" style="display: none"></div>
	<!--优惠券弹层 -->
	<div class="t-box_alert" id="t-box_alert" style="display: none;">
		<div class="t-bomb_box t-bomb-absolute" id="t-bomb_box" style="top:25%;">
			<h3 class="t-bomb_box-1 t-title border-bottom">选择优惠券<a href="javascript:;" class="t-close-btn"></a> </h3>
			<div class="t-bomb_box-7" id="t-bomb_box-6" style="overflow-x:visible">
				<?php  if($couponlist['couponlist']){foreach($couponlist['couponlist'] as $v){?>
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

<?php if(isset($contact)&&$contact==2&&isset($has_fastloan_order)&&$has_fastloan_order==0){ ?>
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