<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo isset($title)?$title:'快金';?></title>
<!--    <title>快金</title>-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1,target-densitydpi=medium-dpi">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/ui_bootstrap/layer/layer.js'); ?>
    <?php echo HTML::script('static/js/sea.js'); ?>
    <?php echo HTML::script('static/js/sea-css.js')?>
    <script>
        var version = Math.random();
        seajs.config({
            base:'/static/',
            charset:'utf-8',
            timeout: 200000,
            debug:false,
            alias: {
                //防止回退
                'lockPhoneBackBtn': 'js/lockPhoneBackBtn'
            },
            map:[
                [".js",".js?v="+version]
            ]
        });
        seajs.use('js/v2/seajs/head');
    </script>
    <?php if(isset($action)&&in_array($action,array('borrow','extremeBorrow'))){ ?>
        <script type="text/javascript">
            (function() {
                _fmOpt = {
                    partner: '9douyu',
                    appName: 'kj_web',
                    token: 'kuaijin'+ "-" +new Date().getTime() + "-"+ Math.random().toString(16).substr(2),
                    fpHost: 'https://fptest.fraudmetrix.cn',
                    staticHost: 'statictest.fraudmetrix.cn',
                    tcpHost: 'fpflashtest.fraudmetrix.cn',
                    wsHost: 'fptest.fraudmetrix.cn:9090'
                };
                var cimg = new Image(1,1);
                cimg.onload = function() {
                    _fmOpt.imgLoaded = true;
                };
                cimg.src = "https://fptest.fraudmetrix.cn/fp/clear.png?partnerCode="+_fmOpt.partner+"&appName="+_fmOpt.appName+"&tokenId=" + _fmOpt.token;
                var fm = document.createElement('script'); fm.type = 'text/javascript'; fm.async = true;
                fm.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'statictest.fraudmetrix.cn/fm.js?ver=0.1&t=' + (new Date().getTime()/3600000).toFixed(0);
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(fm, s);
                if(_fmOpt.token){
                    $.ajax({
                        url:'/Functions/TdAntiFraud',
                        type:'POST',
                        data:{tokenId:_fmOpt.token},
                        dataType:'json',
                        async: true,  //同步发送请求t-mask
                        beforeSend:function(){
                        },
                        success:function(result){

                        }
                    });
                }
            })();
        </script>
    <?php }?>
</head>
<body>
    <div class="t-mask-loading" style="display: block">
        <img style="width:60px;margin: 230px auto 1000px auto;display: -webkit-box;" src="/static/images/v2/loading.gif">
    </div>