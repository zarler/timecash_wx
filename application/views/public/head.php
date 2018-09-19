<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title;?>--快金</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1,target-densitydpi=medium-dpi">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">

<!--    --><?php //echo HTML::style('static/css/t-cash.css?1521111'); ?>
<!--    --><?php //echo HTML::style('static/css/m-cash.css?1223'); ?>
<!--    --><?php //echo HTML::style('static/css/public.css?1231111'); ?>

    <?php echo HTML::script('static/js/jquery-1.9.1.min.js'); ?>
    <?php echo HTML::script('static/ui_bootstrap/layer/layer.js'); ?>
    <?php echo HTML::script('static/js/sea.js',array('id'=>"seajsnode")); ?>
    <script>
        seajs.config({
            base:'/static/',
            charset:'utf-8',
            timeout: 200000,
            debug:false,
            alias: {
                'lockPhoneBackBtn': 'js/lockPhoneBackBtn'
            }
        });
        seajs.use('js/t-cash');
        seajs.use('js/v2/seajs/head');
    </script>
</head>