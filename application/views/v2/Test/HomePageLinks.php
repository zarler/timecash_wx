<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type'>
    <meta content='text/html; charset=utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1,target-densitydpi=medium-dpi">
</head>
<body>
    <section>
        <a id="iLink" href="">内跳转</a><br>
        <a id="jLink" href="">外跳转</a><br>
    </section>
    <script>
        var u = navigator.userAgent;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        var ua = u.toLowerCase();
        //内链接
        var iLink = 'http://test33.m.timecash.cn/app/Activity/TestJs?target_token={target_token}&d={device_id}#';
        //外链接
        var jLink = 'http://www.baidu.com';
        //微信
        if(isAndroid){
            document.getElementById("iLink").setAttribute('href',"javascript:window.android.JsAppInteraction('web_within','"+iLink+"');");
            document.getElementById("jLink").setAttribute('href',"javascript:window.android.JsAppInteraction('web_abroad','"+jLink+"');");
        }
        if(isiOS){
            document.getElementById("iLink").setAttribute('href',"javascript:JsAppInteraction('web_within','"+iLink+"');");
            document.getElementById("jLink").setAttribute('href',"javascript:JsAppInteraction('web_abroad','"+jLink+"');");
        }
        if(ua.match(/MicroMessenger/i)=="micromessenger") {
            document.getElementById("iLink").setAttribute('href',"javascript:location.href ='"+iLink+"'");
            document.getElementById("jLink").setAttribute('href',"javascript:location.href ='"+jLink+"'");
        }

    </script>
</body>
</html>