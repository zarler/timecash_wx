<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type">
    <meta content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache,no-store,must-revalidate">
    <meta http-equiv="Expires" content="0">
    <title>极速贷提额</title>
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/js/v2/standard_local.js');?>
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
    <?php echo HTML::script('static/js/v2/local/punchClock.js?1111');?>
    <style type="text/css">
        *{ margin:0px; padding:0px; font-family:'微软雅黑'; -webkit-tap-highlight-color:rgba(0,0,0,0); font-size: .3rem }
        li{ list-style:none }
        img{ border:none}
        a{text-decoration:none;}
        .apple a{display:block; text-decoration:none;}
        .apple{ width:100%; height:1.1rem; overflow:hidden; text-align: center;}
        .apple a{width:100%; height:1.5rem; line-height:1.5rem; text-indent:1.2rem; color:black;}
        .content {
            padding: 0 6%;
            text-align: left;
            position: relative;
            margin-bottom: .3rem;
            font-size: .8rem;
        }
        .apple span{
            width: 100%;
            height: 50px;
            line-height: 50px;
            text-indent: 20px;
            color: black;
            margin-left: .1rem;
            display: block;
            margin-top: .5rem;
        }
        .content i {
            position: absolute;
            left: 1rem;
            font-size: .3rem;
            top: -.05rem;
            width: .5rem;
            height: .5rem;
            background: #e8457e;
            border-radius: 2rem;
            text-align: center;
            line-height: 1.9;
        }
        .content p{
            font-size: .33rem;
            margin-left: 1.1rem;
            line-height: 2.3;
        }
        .verticalbar{
            z-index: 1;
            position: relative;
            top: -3rem;
            border-right: .06rem solid red;
            border-left: .1rem solid red;
            width: 30%;
            height: 3rem;
            margin: 0 auto -3rem auto;
        }

    </style>
</head>
<body>
<div>
    <div style="position:absolute;width: 100%;text-align:center">
        <img width="89%" src="/static/images/v2/activity/foolsday/1_02.png" style="margin-top:1.3rem;z-index: 20;position: relative;">
        <div class="verticalbar"></div>
        <a href="<?php echo $url; ?>"><img width="50%" src="/static/images/v2/activity/foolsday/5_03.png" style="z-index: -2"></a>
    </div>
    <img width="100%" src="/static/images/v2/activity/foolsday/7_01.png" style="margin-bottom: -1.2rem;">
    <div class="apple" style="position: relative;">
        <?php echo $carousel; ?>
    </div>
</div>
<div style='background: url(/static/images/v2/activity/foolsday/2_02.png) no-repeat;width: 100%;background-size: cover;text-align: center;height:6.6rem'>
    <img style="margin:.8rem auto .5rem auto;" src="/static/images/v2/activity/foolsday/8_06.png" width="27%">
    <div class="content"> <p style="margin-left: 1.4rem;line-height: 1.4;">活动时间：5月18日上午10点至5月19日晚24点;<i>1 </i></p></div>
    <div class="content"> <p style="margin-left: 1.4rem;line-height: 1.4;">活动期间，极速贷最高额度提至2000元，限贷5000单，放完即止；<i> 2</i></p></div>
    <div class="content"> <p style="margin-left: 1.4rem;line-height: 1.4;">每人限贷一单;<i> 3</i></p></div>
    <div class="content"> <p style="margin-left: 1.4rem;line-height: 1.4;">此活动最终解释权归快金所有。<i> 4</i></p></div>

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
        //var timestamp = Date.parse(new Date())/1000;
        //alert(timestamp);
        $.ajax({
            url:'/FunctionsApp/statisticsAllIp',
            type:'POST',
            data:{time:1495209540,action:'look',event_name:'TCOA_009'},
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
    function statisticsBorrow(){
        $.ajax({
            url:'/FunctionsApp/statisticsBorrow',
            type:'POST',
            data:{type:2,event_name:'TCOA_009'},
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
    function showTip(msg,url){
        layer.open({
            content: msg
            ,btn: ['确定', '取消']
            ,yes: function(index){
                location.href = url;
                layer.close(index);
            }
        });
    }
    function changeCssPromptMsg() {
        $('.layui-m-layer-msg').css({'margin':'.3rem auto .5rem auto'});
        $('.layui-m-layercont').css({'font-size':'.3.5rem'});
    }

</script>
</div>
</body>
</html>
