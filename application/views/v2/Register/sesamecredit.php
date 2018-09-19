<?php include Kohana::find_file('views', 'public/headapp');?>
<?php echo HTML::script('static/js/lockPhoneBackBtn.js'); ?>
<body>
<section class="t-login-nav">
    <div class="t-login-nav-1"><a href="/User/Index?jump=no" class="t-return"></a>提交授信资料<!--<a href="#" class="t-re">登录</a>--></div>
</section>
<ul class="progress-bar b-flex-box">
    <li class="progress-zindex4 progress-active"><span class="progress-num progress-active">1</span></li>
    <li class="progress-zindex3 progress-active"><span class="progress-num progress-active">2</span></li>
    <li class="progress-zindex2 progress-active"><span class="progress-num progress-active">3</span></li>
    <li class="progress-zindex1 progress-default"><span class="progress-num">4</span></li>
    <li class="progress-zindex0 progress-default"></li>
</ul>
<section class="t-login-center " style="margin:0px;">
    <iframe  src="<?php echo $url; ?>" id="iframepage" name="iframepage" marginheight="0" marginwidth="0" frameborder="0" scrolling="no" style="padding: 0px; width: 100%;height: 700px"></iframe>
</section>
</body>
</html>
<script type="text/javascript" language="javascript">
    function getHeight(ifr){
        var iframeHeight = ifr.clientHeight + 30 + "px";
        alert(iframeHeight);
        document.getElementById("iframepage").style.height = iframeHeight;
    }
//    function reinitIframeEND(){
//        var ifm= document.getElementById("iframepage");
//        var subWeb = document.frames ? document.frames["iframepage"].document :
//            ifm.contentDocument;
//        if(ifm != null && subWeb != null) {
//            ifm.height = subWeb.body.scrollHeight;
//        }
//    }
</script>
</script>
