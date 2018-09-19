<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo isset($_VArray['title'])?$_VArray['title']:'快金';?></title>
<!--    <title>快金</title>-->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
    <?php echo HTML::script('static/js/v2/common_layer_mobile.js?1111111'); ?>
    <?php echo HTML::script('static/js/sea.js'); ?>
    <?php echo HTML::script('static/js/sea-css.js')?>
    <script>
        version = Math.random();
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
                [".js",".js?v="+version],   //映射规则
                [".css",".css?v="+version]   //映射规则
            ]
        });
        seajs.use('js/v2/seajs/activityhead');

    </script>


</head>
<body>

