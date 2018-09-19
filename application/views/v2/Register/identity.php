<?php include Kohana::find_file('views', 'public/headapp');?>
<?php echo HTML::script('static/js/lockPhoneBackBtn.js'); ?>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="/User/Index" class="t-return"></a>提交授信资料</div>
</section>
<ul class="progress-bar b-flex-box">
	<li class="progress-zindex4 progress-active"><span class="progress-num progress-active">1</span></li>
	<li class="progress-zindex3 progress-active"><span class="progress-num progress-active">2</span></li>
	<li class="progress-zindex2 progress-active"><span class="progress-num progress-active">3</span></li>
	<li class="progress-zindex1 progress-active"><span class="progress-num progress-active">4</span></li>
	<li class="progress-zindex0 progress-default"></li>
</ul>
<p class="t-loan"><span class="t-line"></span><em>拍摄照片</em><span></span></p>
<dl class="t-photo" id="chooseImage">
	<dt><?php echo HTML::image('static/images/t-photo-img.png',array('class'=>'photo-01'));?></dt>
	<dd>身份证正面照</dd>
</dl>
<dl class="t-photo" id="chooseImage1">
	<dt><?php if($sex['sex']=='男'){$num = 2;}elseif($sex['sex']=='女'){$num=1;}else{$num = 2;}  echo HTML::image('static/images/t-photo-img'.$num.'.png',array('class'=>'photo-02'));?></dt>
	<dd>手持身份证正面照</dd>
</dl>
<section class="t-login-footer">
	<p class="t-error"></p>
	<input type="submit" class="t-red-btn" value="下一步">
</section>
<div style="display:none;height:500px;">
</div>
</body>
</html>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script>

	wx.config({
		debug: false,
		appId: '<?php echo $signPackage["appId"];?>',
		timestamp: <?php echo $signPackage["timestamp"];?>,
		nonceStr: '<?php echo $signPackage["nonceStr"];?>',
		signature: '<?php echo $signPackage["signature"];?>',
		jsApiList: [
			'chooseImage',
			'uploadImage'
		]});
	wx.ready(function () {
		function upimages(node,name) {
			wx.chooseImage({
				sourceType: ['camera'],
				sizeType: [ 'compressed'],
				success: function (res) {
					var localId = res.localIds;
					if (localId == 0) {
						alert('请先使用 chooseImage 接口选择图片');
						return;
					}
					function upload(localId){
						wx.uploadImage({
							localId: localId[0],
							isShowProgressTips: 1,
							success: function (res) {
								var serverId = res.serverId;
								imgurl = '<?php echo HTML::image("static/images/loading.gif");?>';
								$(node+" dt").empty().append(imgurl);
								$.ajax({
									url:'<?php echo URL::site('Functions/upload'); ?>',
									type: "POST",
									data: {serverid:serverId},
									dataType:'json',
									async: true,  //同步发送请求
									beforeSend:function(){
									},
									success: function(e){
										if(e.hash=='ok'){
											$('.t-mask').hide();
											$(node+" dt").empty().append("<img src = 'data:image/png;base64,"+e.pic+"' class='photo-03' id='"+name+"'> <button class='x-photo-btn' type='button'>点击重新上传</button>");
											bodyHeight = $(document.body).height();
											$(node+" dt .photo-03").load(function(){
												picHeight = $(node+" dt .photo-03").height();
												$(document.body).css('height',bodyHeight+picHeight + 'px');
												$(document.body).css('height','auto');
											});
											commonUtil.tips();
										}else{
											commonUtil.waring("上传失败");
										}
									},
									error:function(){
										$('.t-mask').hide();
										commonUtil.waring("网络错误");
									}
								})
							},
							fail: function (res) {
								$('.t-mask').hide();
								alert('上传失败');
							}
						});
					}
					upload(localId);
				}
			});
		}
		$("#chooseImage").click(function(){
			upimages('#chooseImage','pic');
		});
		$("#chooseImage1").click(function(){
			upimages('#chooseImage1','pic1');
		});
		$('.t-red-btn').click(function(){
			commonUtil.lockup();
			pic = $('#pic').attr('src');
			pic1 = $('#pic1').attr('src');

			if(pic==null||pic==''||pic1==''||pic1==null){
				commonUtil.waring('您还有照片没有提交');
				commonUtil.unlock();
				return false;
			}else{
				$.ajax({
					url:"<?php echo URL::site('Functions/picauth');?>",
					type:'POST',
					data:{pic:pic,pic1:pic1},
					dataType:'json',
					async: true,  //同步发送请求t-mask
					beforeSend:function(){

					},
					success:function(result){
						commonUtil.unlock();
						if(result.status == true){
							commonUtil.tips();
							location.href = "/User/Index"
						}else{
							commonUtil.waring(result.msg);
						}
					},
					error:function(){
						commonUtil.unlock();
					}
				});
			}
		});
		var commonUtil={

			tips:function(){
				$(".t-error").text('');
			},
			waring:function(msg){
				$(".t-error").text(msg);
			},
			lockup:function(){
				$('.t-red-btn').addClass('t-gray-btn');
				$(".t-red-btn").attr('disabled',true);
				$('.t-red-btn').removeClass('t-red-btn');
				load = layer.load(2, {shade: false});
				$('.t-mask').show();
			},
			unlock:function(){
				$('.t-gray-btn').addClass('t-red-btn');
				$(".t-red-btn").attr('disabled',false);
				$('.t-gray-btn').removeClass('t-gray-btn');
				layer.close(load);
				$('.t-mask').hide();
			}

		}
	});

</script>
