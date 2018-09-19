<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
  <title>微信JS-SDK Demo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
  <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
<!--  --><?php //echo HTML::script('static/ui_bootstrap/layui/layui.js');?>
</head>
<body>
<button style="width: 12rem;height: 6rem;background: red;font-size: 3rem;color: white;" onclick="submit()">
    点我
</button>

<div id="divId"></div>

</body>
</html>
<script>
    function submit() {
        try
        {
            var testJson = "{\"type\":\"web_within\",\"url\":\"http:\\/\\/test33.m.timecash.cn\\/app\\/Activity\\/TestJs?target_token={target_token}&d={device_id}#\"}";
            testJson = eval("(" + testJson + ")");
            window.webkit.messageHandlers.JsAppInteraction.postMessage(testJson);
        }
        catch(err)
        {
            //在这里处理错误
            console.log(2222222);
        }
    }
    callBack();
    function callBack(msg) {
        testJson = eval("(" + msg + ")");
        alert(testJson.ver);

        var a = confirm("去打电话？");
        if(a == true){
            window.webkit.messageHandlers.callIphone.postMessage('13643176531');
        }else{
            alert('取消打电话');
        }
        $("#divId").html(testJson.ver);
    }
</script>
</html>
