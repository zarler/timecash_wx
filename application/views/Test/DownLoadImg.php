<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Disposition" content="attachment;">
    <style>
        .feedback-overlay-black{
            background-color:#000;
            opacity:0.5;
            position:absolute;
            top:0;
            left:0;
            width:100%;
            height:100%;
            margin:0;
        }

    </style>

    <style>
        /*div{*/
            /*padding:20px;*/
            /*margin:0 auto;*/
            /*border:5px solid black;*/
        /*}*/

        h1{
            border-bottom:2px solid white;
        }

        h2{
            background: #efefef;
            padding:10px;
        }


    </style>
</head>
<body>

<div id="canvasBody">
    <div style="background:green;">
        <div style="background:blue;border-color:white;">
<!--            <div style="background:yellow;"><div style="background:orange;"><h1>Heading</h1>-->
<!--                    Text that isn't wrapped in anything.-->
<!--                    <p>Followed by some text wrapped in a <b>&lt;p&gt; paragraph.</b> </p>-->
<!--                    Maybe add a <a href="#">link</a> or a different style of <a href="#" style="background:white;" id="highlight">link with a highlight</a>.-->
<!--                    <hr />-->
<!--                    <h2>More content</h2>-->
<!--                    <div style="width:10px;height:10px;border-width:10px;padding:0;">a</div>-->
<!--                </div></div>-->
            <p>哈哈哈哈那那那</p>
            <img class="share_img" style="width: 5rem" src="/static/images/v2/activity/2weima.png">

        </div>
    </div>
    
</div>
<img src="">
<!--<div id="canvasClass"></div>-->
<a id="canvasA" href="javascript:download();"  style="margin-top: 2rem;z-index: 11111111;">下载图片</a></br></br></br>
<a  href="<?php echo $url; ?>"  style="margin-top: 2rem;z-index: 11111111;">下载图片</a>


<script type="text/javascript" src="/static/ui_bootstrap/html2canvas/html2canvas.js"></script>
<script type="text/javascript">

    //$document.ready(function(){
        location.href = 'http://weixin://wxpay/bizpayurl?pr=KJYxm47';
//        location.href = 'https://www.baidu.com';
//    });



    var canvasImg = null;
    var img = null;
//    html2canvas(document.body, {
    html2canvas(document.getElementById("canvasBody"), {
        onrendered: function(canvas) {
            canvasImg = canvas;
            img = canvasImg.toDataURL("image/png");
            document.getElementById("canvasBody").innerHTML = '<img src='+img+'>';
//            document.getElementById("canvasA").attr('download','<img src='+img+'>');
//            document.getElementById("canvasA").href = "download:"+img;


//            document.getElementById("canvasClass").appendChild(canvas);
//            var img = canvasImg.toDataURL("image/png");
//            document.body.appendChild(canvas);
        }
    });
    function download() {
        //downloadFile('ship.png', canvas.toDataURL("image/png"));
        var blob = base64Img2Blob(img);
        var aLink = document.createElement('a');
        var evt = document.createEvent("HTMLEvents");
        evt.initEvent("click", false, false);
        aLink.href = URL.createObjectURL(blob);
        aLink.dispatchEvent(evt);
//        console.log(111111111);
        //var canvas = document.getElementById("mycanvas");
//        console.log(canvasImg);
        //var img = canvasImg.toDataURL("image/png");
        //location = img;
    }

    function base64Img2Blob(code){
        var parts = code.split(';base64,');
        var contentType = parts[0].split(':')[1];
        var raw = window.atob(parts[1]);
        var rawLength = raw.length;
        var uInt8Array = new Uint8Array(rawLength);
        for (var i = 0; i < rawLength; ++i) {
            uInt8Array[i] = raw.charCodeAt(i);
        }
        return new Blob([uInt8Array], {type: contentType});
    }

    function downloadFile(){
        var aLink = document.createElement('a');
        var blob = base64Img2Blob(content); //new Blob([content]);
        var evt = document.createEvent("HTMLEvents");
        evt.initEvent("click", false, false);//initEvent 不加后两个参数在FF下会报错
        aLink.download = fileName;
        aLink.href = URL.createObjectURL(blob);
        aLink.dispatchEvent(evt);
    }
</script>
</body>
</html>
