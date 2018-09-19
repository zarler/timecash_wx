<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<!--    <title>--><?php //echo $title;?><!----快金</title>-->
    <title>快金</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1,target-densitydpi=medium-dpi">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
    <?php echo HTML::script('static/js/sea.js'); ?>
    <?php echo HTML::script('static/js/sea-css.js')?>
    <script>
        var version='0.0.1';
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
</head>
<body>
    <div class="t-mask-loading" style="display: block">
        <img style="width:60px;margin: 230px auto 1000px auto;display: -webkit-box;" src="/static/images/v2/loading.gif">
    </div>