<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type">
    <meta content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <title>极速贷提额</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=0.8, minimum-scale=1,target-densitydpi=medium-dpi">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/ui_bootstrap/layer/layer.js');?>
    <?php echo HTML::script('static/js/v2/common.js');?>
    <style type="text/css">
        *{ margin:0px; padding:0px; font-family:'微软雅黑'; -webkit-tap-highlight-color:rgba(0,0,0,0); font-size: .9rem }
        li{ list-style:none }
        img{ border:none}
        a{text-decoration:none;}
        .apple a{display:block; text-decoration:none;}
        .apple{ width:100%; height:2.1rem; overflow:hidden; text-align: center;}
        .apple a{width:100%; height:2.5rem; line-height:2.5rem; text-indent:20px; color:black;}

        .content {
            padding: 0 6%;
            text-align: left;
            position: relative;
            margin-bottom: 1rem;
            font-size: .8rem;
        }
        .apple span{width:100%; height:50px; line-height:50px; text-indent:20px; color:black;margin-left: 3rem;}
        .content i {
            position: absolute;
            left: 1.5rem;
            font-size: .8rem;
            top: .1rem;
            width: 1rem;
            height: 1rem;
            background: #e8457e;
            border-radius: 2rem;
            text-align: center;
            line-height: 1.5;
        }

    </style>
</head>
<body>
<div>
    <div style="position:absolute;width: 100%;text-align:center">
        <img width="83%" src="/static/images/v2/activity/foolsday/6_03.png" style="margin-top:2rem;z-index: 20;position: relative;">
        <div style="z-index: 1;position:relative;top:-7rem;border-right: .3rem solid red;border-left: .3rem solid red;;width: 30%;height: 7rem;margin: 0 auto -7rem auto;"></div>
        <a href="<?php echo $url; ?>"><img width="50%" src="/static/images/v2/activity/foolsday/5_03.png" style="z-index: -2"></a>
    </div>
    <img width="100%" src="/static/images/v2/activity/foolsday/7_01.png" style="margin-bottom: -2.5rem;">
    <div class="apple" style="position: relative;">
        <?php echo $carousel; ?>
    </div>
</div>
<div style='background: url(/static/images/v2/activity/foolsday/2_02.png) no-repeat;width: 100%;background-size: cover;text-align: center;height:19rem'>

    <img style="margin:1.5rem auto;" src="/static/images/v2/activity/foolsday/8_06.png" width="27%">
    <div class="content"> <p style="margin-left: 1.4rem;line-height: 1.4;">活动时间：4月1日上午10点至晚24点；<i>1 </i></p></div>
    <div class="content"> <p style="margin-left: 1.4rem;line-height: 1.4;">活动期间，极速贷最高额度提至2000元，限贷5000单，放完即止；<i> 2</i></p></div>
    <div class="content"> <p style="margin-left: 1.4rem;line-height: 1.4;">每人限贷一单;<i> 3</i></p></div>
    <div class="content"> <p style="margin-left: 1.4rem;line-height: 1.4;">此活动最终解释权归快金所有；<i> 4</i></p></div>

</div>
<!--<button style="padding:.5rem 2rem;margin: 2rem auto;display: block;">马上去抢</button>

<div style='height: 16rem;width: 100%;background: blue;'></div>-->
<script type="text/javascript">
    function autoScroll(obj){
        $(obj).find("ul").animate({
            marginTop : "-30px"
        },500,function(){
            $(this).css({marginTop : "0px"}).find("li:first").appendTo(this);
        })
    }
    $(function(){
        setInterval('autoScroll(".apple")',3000);
    });
    $(document).ready(function(){
        $.ajax({
            url:'/FunctionsH5/statisticsCelebrate',
            type:'POST',
            data:{action:'look'},
            dataType:'json',
            async: true,
            beforeSend:function(){

            },
            success:function(result){
            },
            error:function(){
            }
        });
    });
</script>
</div>
</body>
</html>
