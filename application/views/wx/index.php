<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
  <title>微信JS-SDK Demo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
 <?php echo HTML::style('static/v1/css/style.css'); ?>
</head>
<body ontouchstart="">


<div class="wxapi_container">

    <div class="lbox_close wxapi_form">


      <span class="desc">拍照或从手机相册中选图接口</span>
      <button class="btn btn_primary" id="chooseImage">chooseImage</button>

     
    </div>
	 <div class="lbox_close wxapi_form" id="pic">

     
    </div>
  </div>
<div style="position:fixed;left:45%;top:45%;display:none;color:red;" id="status"></div>
</body>
</html>
<script type="text/javascript">
    window.jQuery || document.write("<script src='http://libs.baidu.com/jquery/1.7.2/jquery.min.js'>"+"<"+"/script>");
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
        'chooseImage',
        'uploadImage',
    ]
  });
  wx.ready(function () {
    // 在这里调用 API

	
	var images = {
		localId: [],
		serverId: []
	};
	  document.querySelector('#chooseImage').onclick = function () {
		wx.chooseImage({
		  success: function (res) {
			images.localId = res.localIds;
			//alert('已选择 ' + res.localIds.length + ' 张图片');
			
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
				  //alert('已上传：' + i + '/' + length);
				  images.serverId.push(res.serverId);
					if (i < length) {
						upload();
					}
					//将微信服务器的图片拿到我们的服务器并显示
					/* $.get('<?php echo URL::site('Wx/upload'); ?>',{serverid:res.serverId},function(e){ alert(e);
						if(e){
							$('#pic').empty().append("<img src = 'http://wx.idadui.com"+e+"' style='width:100%'>");
						}else{
							alert('上传失败');
						}
					});  */
					
					$.ajax({
						url:'<?php echo URL::site('Wx/upload'); ?>',
						type: "GET",
						data: {serverid:res.serverId},
						beforeSend:function(){
							$('#status').show().text('上传中请等待');
						},
						success: function(e){
							if(e){
								$('#status').hide();
								$('#pic').empty().append("<img src = 'http://wx.idadui.com"+e+"' style='width:100%'>");
							}else{
								$('#status').show().text('上传失败');
							}
					   }
					})
					
				},
				fail: function (res) {
				  alert(JSON.stringify(res));
				}
			  });

			}
			upload();
		
		  }
		});
	  };


  });
  
</script>

</html>
