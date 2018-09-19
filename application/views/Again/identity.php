<?php include Kohana::find_file('views', 'public/head');?>
<body>
<section class="t-login-nav">
	<div class="t-login-nav-1"><a href="javascript:history.go(-1)" class="t-return"></a>立即借款</div>
</section>
<p class="t-loan"><span class="t-line"></span><em>拍摄照片</em><span></span></p>
<?php echo Form::open('User/index', array('id'=>'identityForm')); ?>
<dl class="t-photo" id="chooseImage">
	<dt><?php echo HTML::image('static/v1/images/t-photo-img.png',array('class'=>'photo-01'));?></dt>
	<dd>身份证正面照</dd>
</dl>
<dl class="t-photo" id="chooseImage1">
	<dt><?php echo HTML::image('static/v1/images/t-photo-img1.png',array('class'=>'photo-02'));?></dt>
	<dd>手持身份证正面照</dd>
</dl>
<section class="t-login-footer">	
	<p class="t-error"></p>
	<input type="submit" class="t-red-btn" value="下一步">
</section>
<?php echo Form::close();  ?>
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
        'uploadImage',
    ]});
  wx.ready(function () {
	var images = {
		localId: [],
		serverId: []
	};
	function upimages(node,name) {
		wx.chooseImage({
		sourceType: ['camera'], 
		  success: function (res) {
			images.localId = res.localIds;
			if (images.localId.length == 0) {
			  alert('请先使用 chooseImage 接口选择图片');
			  return;
			}
			var i = 0, length = images.localId.length;
			images.serverId = [];
			function upload() {
			  wx.uploadImage({
				localId: images.localId[i],
				success: function (res) {
				  i++;
				  images.serverId.push(res.serverId);
					if (i < length) {
						upload();
					}
					imgurl = '<?php echo HTML::image("static/v1/images/loading.gif");?>';
					$(node+" dt").empty().append(imgurl);
					$.ajax({
						url:'<?php echo URL::site('Again/upload'); ?>',
						type: "POST",
						dataType:'json',
						data: {serverid:res.serverId},
						beforeSend:function(){
							$('.t-mask').show();
						},
						success: function(e){
							if(e.hash){
								$('.t-mask').hide();
								$(node+" dt").empty().append("<img src = 'data:image/png;base64,"+e.pic+"' class='photo-03'> <button class='x-photo-btn' type='button'>点击重新上传</button><input type='hidden' name='"+name+"' value='"+e.hash+"'>");
								bodyHeight = $(document.body).height();
								$(node+" dt .photo-03").load(function(){ 
									//imgurl = '<?php echo HTML::image("static/v1/images/loading.gif");?>';
									//$(node+" dt").empty().append("<img src = '"+imgurl+"' />");
									picHeight = $(node+" dt .photo-03").height();
									$(document.body).css('height',bodyHeight+picHeight + 'px');
									$(document.body).css('height','auto');
								})								
								$('.t-error').text('');								
							}else{
								$('.t-error').text('上传失败');
							}
					   }
					})
				},
				fail: function (res) {
				  alert('上传失败');
				}
			  });
			}
			upload();
		  }
		});
	  }
	
	
		$("#chooseImage").click(function(){
			upimages('#chooseImage','pic');
		})
		$("#chooseImage1").click(function(){
			upimages('#chooseImage1','pic1');
		})
	
		$('#identityForm').submit(function(){
			pic = $("input[name='pic']").val();
			pic1 = $("input[name='pic1']").val();
			if(pic==null||pic==''||pic1==''||pic1==null){
				$('.t-error').text('请选择图片');
				return false;
			}else{
				$.ajax({
					url:"<?php echo URL::site('Again/picauth');?>",
					type:'POST',
					data:$(this).serialize(),
					dataType:'json',
					async: false,  //同步发送请求t-mask
					beforeSend:function(){
						$('.t-mask').show();
					},
					success:function(result){
						unique=result.status; //alert(unique);
						$('.t-mask').hide();
					}
				});
				if(unique===true){
					return true;
				}else{
					$('.t-error').text(unique);
					return false;
				}
			}
		})
  });
  
</script>
