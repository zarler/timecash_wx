<!DOCTYPE html>
<html lang="zh-cn" class="no-js">
<head>
    <meta http-equiv="Content-Type">
    <meta content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <title>快金一周年</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=0.9, minimum-scale=0.8,target-densitydpi=medium-dpi">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <style type="text/css">
        *{ padding: 0; margin: 0;}
        html { -webkit-text-size-adjust: none; font-size: 20px; height: 100%;}
        body{min-width:16rem; font-family:"STHeiti","Microsoft YaHei","Microsoft YaHei","SimHei", "Arial Black"; font-weight: lighter; background: #d5242a;}

        .img { display: block; max-width: 100%; height:auto;  vertical-align:top; border: none; }
        @media (min-device-width : 375px) and (max-device-width : 667px) and (-webkit-min-device-pixel-ratio : 2){
            html{color: black; font-weight:bold}
            /*iphone 6*/
        }
        @media (min-device-width : 414px) and (max-device-width : 736px) and (-webkit-min-device-pixel-ratio : 3){
            /*iphone 6 plus*/
            html{color: black; font-weight:bold}
        }
        .cash-bg{ position: absolute; top: 0; z-index: -1;}
        .cash-title p {text-align: center; color: #000000;font-size: 1.1rem; font-weight: bold; line-height: 1.2rem; padding-top: 0.38rem; }
        section{
            text-align:center;position:absolute;top:51%;width: 100%;color: white;font-size: .6rem;font-weight: inherit
        }
        .activity_date{
            background: yellow;width: 20%;padding: .3rem;border-radius: .2rem;margin: 0 auto;color: black;
        }
        .activity_content{
            background: yellow;width: 20%;padding: .3rem;border-radius: .2rem;margin: .5rem auto;color: black;
        }
        .content{
            padding: 0 6%;text-align:left;line-height: .9rem;position: relative;margin-bottom:.3rem
        }
        .content i{
            position: absolute;
            left: 1.5rem;
            font-size: 14px;
            top: .3rem;
            width: .3rem;
            height: .3rem;
            background: yellow;
            border-radius: 2rem;
        }
    </style>
</head>
<body style="font-size: 62.5%">
<img src="/static/images/v2/activity/festival_background.png" height="100%" width="100%" class="img cash-bg" />
<section>
    <div class="activity_date"><strong>活动日期</strong></div>
    <div style="margin: .5rem auto;">2017年3月10日-3月12日</div>
        <a href="javascript:;" onclick="clicksjclick()">
            <img style='max-height: 13rem;width: 8rem;' id="extensions" src="/static/images/v2/activity/festival_button.png">
        </a>
    <div  class="activity_content"><strong>活动内容</strong></div>
    <div class="content">
        <p style="margin-left: 1rem">凡在3.10 0：00--3.12 24：00在快金平台借款的用户均可享受手续费随机立减的优惠<i> </i></p>
    </div>
    <div class="content">
        <p style="margin-left: 1rem">手续费立减额度最低5元，最高免息<i> </i></p>
    </div>
    <div class="content">
        <p style="margin-left: 1rem">此活动优惠力度较大，不可与线上其他促销活动（包括但不限于优惠券）同时使用；用户在活动期间借款默认只享受此活动<i> </i></p>
    </div>
    <div class="content">
        <p style="margin-left: 1rem">此活动最终解释权归快金所有<i> </i></p>
    </div>
    
</section>

</body>
<script>
    window.onload = function(){
        $("section").css("top",(document.body.scrollHeight*0.373)+"px");
    };
    $(document).ready(function(){
        $.ajax({
            url:'/FunctionsApp/statisticsCelebrate',
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
    function clicksjclick(){
            $.ajax({
                url:'/FunctionsApp/statisticsCelebrate',
                type:'POST',
                data:{action:'click'},
                dataType:'json',
                async: true,
                beforeSend:function(){
                },
                success:function(result){
                    location.href = 'http://m.timecash.cn?jump=no';
                },
                error:function(){
                }
            });
    }
</script>
</html>



