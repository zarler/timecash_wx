<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<script>
	seajs.config({
		vars: {
			'gainlastId':<?php echo isset($gainlastId)?$gainlastId:0; ?>,
			'userlastId':<?php echo isset($userlastId)?$userlastId:0; ?>,
			'apiUrl':'<?php echo URL::site('FunctionsApp/WalletDetailed'); ?>',
		}
	});
	seajs.use('js/v2/seajs/my-wallet');
	function LoadMore(type) {
		switch (type){
			case 'gain':
				//console.log(seajs.data.vars.gainlastId);
				var lastId = seajs.data.vars.gainlastId;
				break;
			case 'used':
				var lastId = seajs.data.vars.userlastId;
				break;
		}
		if(lastId>0){
			var layerShaw = layer.open({type: 2});
			$.ajax({
				url:seajs.data.vars.apiUrl,
				type:'POST',
				data:{last_id:lastId,type:type},
				dataType:'json',
				async: true,  //同步发送请求t-mask
				beforeSend:function(){
				},
				success:function(result){
					layer.close(layerShaw);
					if(result.status == true){
						var json = eval('(' + result.data + ')');
						if(json.last_id>0){
							switch (type){
								case 'gain':
									//console.log(seajs.data.vars.gainlastId);
									seajs.data.vars.gainlastId = json.last_id;
									console.log(json.last_id);
									$('.GainList .listshow').append(json.strList);
									break;
								case 'used':
									seajs.data.vars.userlastId = json.last_id;
									console.log(json.last_id);
									$('.UseList .listshow').append(json.strList);
									break;
							}
						}else{
							//无数据
							switch (type){
								case 'gain':
									seajs.data.vars.gainlastId = json.last_id;
									$('.GainList button').text('无更多信息');
									break;
								case 'used':
									seajs.data.vars.userlastId = json.last_id;
									$('.UseList button').text('无更多信息');
									break;
							}
						}
					}else{
						layer.open({content: result.msg,skin: 'msg',time: 2});
						return  false;
					}
				},
				error:function(){
//					commonUtil.unlock();
//					commonUtil.waring("表单发送失败！");
					layer.open({content: '表单发送失败！',skin: 'msg',time: 2});
					return false;
				}
			});

		}
	}

</script>

<body style="background: #F3F3F3">
<div class="loading_ok" style="display: none">
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a href="/Wallet/HomePage" class="return_i i_public"></a>余额明细
		<a href="/Wallet/Explain"><span id="show-rules" style="margin-right: 0.2rem"><i class="problem_i"></i>余额说明</span></a>
	</div>
</section>
<!-- 头信息end -->
<div class="top_height"></div>
<section class="wallet_secone">
	<div class="tc_divleft" style="color:#FF6A4D">
		<p style="padding: 0">获取明细</p>
	</div>
	<div class="tc_divmiddle"></div>
	<div class="tc_divleft">
		<p style="padding: 0">使用明细</p>
	</div>
</section>
<div class="spoke"></div>
<!--<p class="explain_p"><a href="/Wallet/Explain"><i></i>余额说明</a></p>-->
<!--<div style="text-align: center;line-height:3;margin-top:2rem">-->
<!--	--><?php //echo HTML::image('static/images/icon_meiyoujuan.png',array('style'=>'width:2rem;'));?>
<!--</div>-->
<div class="GainList">
	<?php if(isset($strList)&&!empty($strList)){?>
		<div class="listshow">
			<?php echo $strList; ?>
		</div>
		<?php if(isset($gainlastId)&&$gainlastId>0){?>
			<button onclick="LoadMore('gain');">点击加载更多</button>
		<?php }else{ ?>
			<button>无更多信息</button>
		<?php } ?>
	<?php }else{ ?>
		<button>暂无数据</button>
	<?php } ?>

</div>
<div style="display: none" class="UseList">
	<?php if(isset($strUserList)&&!empty($strUserList)){?>
		<div class="listshow">
			<?php echo $strUserList; ?>
		</div>
		<?php if(isset($userlastId)&&$userlastId>0){?>
			<button onclick="LoadMore('used');">点击加载更多</button>
		<?php }else{ ?>
			<button>无更多信息</button>
		<?php } ?>
	<?php }else{ ?>
		<button>暂无数据</button>
	<?php } ?>

</div>
	<!--<section class="walletList">-->
<!--	<span>邀请好友完成借款</span><br>-->
<!--	<label class="grepApan">2017-05-01  20:00:00</label>-->
<!--	<strong style="float: right">+10元</strong>-->
<!--</section>-->
<!--<section class="walletList">-->
<!--	<span>邀请好友完成借款</span><br>-->
<!--	<label class="grepApan">2017-05-01  20:00:00</label>-->
<!--	<strong style="float: right">+10元</strong>-->
<!--</section>-->
<!--<section class="walletList">-->
<!--	<span>邀请好友完成借款</span><br>-->
<!--	<label class="grepApan">2017-05-01  20:00:00</label>-->
<!--	<strong style="float: right">+10元</strong>-->
<!--</section>-->
<!--<section class="walletList">-->
<!--	<span>邀请好友完成借款</span><br>-->
<!--	<label class="grepApan">2017-05-01  20:00:00</label>-->
<!--	<strong style="float: right">+10元</strong>-->
<!--</section>-->
<!--	<div style="clear: both"></div>-->
<!--	<section class="m-webbox">-->
<!--		<a href="/PeoplePull/HomePage" class="identify1">-->
<!--			<div class="m-lineblock">-->
<!--				<i class="m-yaohaoyou left_i"></i>-->
<!--				<label>邀请好友赚现金</label>-->
<!--				<i class="inter_i float_right"></i>-->
<!--			</div>-->
<!--		</a>-->
<!--	</section>-->
</div>
</body>
</html>