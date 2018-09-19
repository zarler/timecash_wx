<html>
<head>
    <meta charset="utf-8">
    <title>28天极速贷来袭</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--<link rel="stylesheet" href="//res.layui.com/layui/build/css/layui.css"  media="all">-->
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/js/v2/standard_local.js');?>
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
    <?php echo HTML::script('static/js/v2/common_layer_mobile.js'); ?>

    <script>
        function autoScroll(obj){
            $(obj).find("ul").animate({
                marginTop : "-39px"
            },500,function(){
                $(this).css({marginTop : "0px"}).find("li:first").appendTo(this);
            })
        }
        $(function(){
            setInterval('autoScroll(".apple")',3000);
        })
    </script>
    <style type="text/css">
        *{
            margin: 0;padding: 0;
            font-size: .3rem;
        }
        body{
            background:#f45b5e;
        }
        li{ list-style:none;font-size: .02rem; }
        a{text-decoration:none;color: black}
        #example1 {
            background-image: url(/static/images/v2/activity/WholePoitGo/10.png);
            background-position: left top;
            background-repeat: no-repeat;
            background-size:contain;
            padding: 13px;
            margin: 0 .5rem;
        }
        #example2 {
            background-image: url(/static/images/v2/activity/WholePoitGo/5.png);
            background-position: left top;
            background-repeat: no-repeat;
            background-size:contain;
            width: 3.9rem;
            height: .96rem;
            display: inline-block;
            position: relative;
            right: -.4rem;
            top: .1rem;
            text-align: center;
            line-height: 5.5;
        }
        #example2 span{
            font-size:.3rem ;
            position: relative;
            top: -.3rem;
        }
        .buoy{
            position: fixed;
            bottom: .5rem;
            right: .3rem;
            background: url(/static/images/v2/activity/WholePoitGo/8.png);
            background-position: left top;
            background-repeat: no-repeat;
            background-size:cover;
            width: 2rem;
            height: 2.3rem;
        }
        p{
            padding: .3rem .5rem;
            line-height:2;
            height:5rem;
            font-size: .32rem;
        }
        strong{
            font-size: .35rem;
        }
    </style>
</head>
<body>
<img  width="100%" src="/static/images/v2/activity/WholePoitGo/9.png">
<section style="background: #f45b5e;width: 100%;padding: .2rem 0;margin-top:-.6rem">
    <div style="border: .04rem dashed black; width: 94%;height: 1.6rem;border-radius: .2rem;margin:.8rem auto .5rem auto;">
        <img src="/static/images/v2/activity/WholePoitGo/4.png" style="width:.7rem;margin-top: .4rem;margin-left: .2rem;">
        <strong style="position: relative;top: -0.4rem;left: .1rem;">极速贷</strong>
        <strong style="display:inline-block;margin-left: .5rem;text-align: center;line-height: .45rem;">
            500-1500元<br>
            7--28天
        </strong>
        <a href="<?php echo $url_rapidly; ?>"><article id="example2"><span>立即申请</span></article></a>
    </div>
    <div id="example1" >
        <h2 style="text-align:center;margin-top: .5rem;color: #f45b5e;font-size:.4rem ;">活动规则</h2>
        <p style="">
            1、活动时间:8月8日-8月10日;<br>
            2、活动期间，极速贷产品最长借款周期延长至28天,每天限贷3000单,贷完为止;<br>
            3、每人限贷一单;<br>
            4、此活动最终解释权归快金所有。<br>
        </p>
    </div>
</section>
<img  width="100%" src="/static/images/v2/activity/WholePoitGo/7.png">
<!--		<div class="ceshi" style="width: 2rem;height: 2rem;"></div>-->
</body>

<script>
    function clickEvent() {
        $.ajax({
            url:'/FunctionsApp/statisticsUserIdIp',
            type:'POST',
            data:{action:'click',event_name:'TCOA_014'},
            dataType:'json',
            async: true,
            beforeSend:function(){
            },
            success:function(result){
            },
            error:function(){
            }
        });
    }
</script>


</html>
