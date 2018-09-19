<!DOCTYPE html>
<html lang="zh-cn" class="no-js">
<head>
    <meta http-equiv="Content-Type">
    <meta content="text/html; charset=utf-8">
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
    <meta name="viewport" content="width=320,maximum-scale=1.3,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
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


        /* @media only screen and (min-width: 401px){
             html {
                 font-size: 25px !important;
             }
         }
         @media only screen and (min-width: 428px){
             html {
                 font-size: 26.75px !important;
             }
         }
         @media only screen and (min-width: 481px){
             html {
                 font-size: 30px !important;
             }
         }
         @media only screen and (min-width: 569px){
             html {
                 font-size: 35px !important;
             }
         }
         @media only screen and (min-width: 641px){
             html {
                 font-size: 40px !important;
             }
         }*/
        .cash-bg{ position: absolute; top: 0; z-index: -1;}
        .cash-title{ width: 12.7rem; height: 4.275rem; background: url(/static/images/activity/share/icon-bj.png) no-repeat; background-size: 12.7rem auto; position: absolute;z-index: 3; top: 6.9rem; left: 50%; margin-left: -6.35rem;}
        .cash-2weima{ width: 12.7rem; height: 4.275rem; background: url() no-repeat; background-size: 12.7rem auto; position: absolute;z-index: 3; top: 6.9rem; left: 50%; margin-left: -6.35rem;}
        .cash-title p {text-align: center; color: #000000;font-size: 1.1rem; font-weight: bold; line-height: 1.2rem; padding-top: 0.38rem; }
        .cash-1{ text-align: center; font-size: 0.5rem; color: #fff; margin-top:12.2rem; padding-bottom: 0.3rem;}
        .cash-btn{ display:block; width: 4.75rem; height: 1.7rem; border-radius: 0.7rem; background-size: 4.75rem auto; font-size: 0.8rem; font-weight: bold; text-decoration: none; background: #d5242a; text-align: center; line-height: 1.8rem; color: #080808; position: absolute; left: 50%; margin-left: -2.325rem;}
        .twoweima{
            height:8rem;
            width:100%;
            z-index: 6;
            text-align: center;
        }
        .smallclass{
            text-align: center;
            display:inline-block;
            width:31%
        }
        .smallclass p{
            margin-top: 0.2rem;
            font-size: 12px;
        }
        .smallclass img{
            max-width: 1.6rem;max-height: 1.6rem;
        }
        #fullbg{
            position: fixed;
            background-color: rgba(0,0,0,.8);
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: 99;
        }
        .m-login-center{
            margin: 0 2rem;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: .3rem;
            position:fixed;
            top: 200px;
            z-index: 100;
            text-align: center;
            width: 80%;
        }
        .m-login-center p.m-title{
            height: 2.25rem;
            line-height: 2.25rem;
            border-bottom: 1px solid #e5e5e5;
            font-size: .75rem;
            color: #5d5d5d;
            position: relative;
        }
        p.m-tip {
            padding: 2rem 1rem;
        }
    </style>
</head>
<body>
<img src="/static/images/activity/extension_1/icon_07.png" height="100%" width="100%" class="img cash-bg" />
<section style="max-height: 13rem;width: 100%;text-align:center">
    <img style='max-height: 13rem;width: 90%;margin-top:3rem' src="/static/images/activity/extension_1/icon_01.png">
    <img style='max-height: 13rem;width: 90%;margin-top:.75rem' src="/static/images/activity/extension_1/icon_02.png">
</section>
<section style="max-height: 19rem;width: 100%;text-align:center">
    <a href="javascript:;">
        <img style='max-height: 13rem;width: 6rem;margin-top:12rem' id="extensions" src="/static/images/activity/extension_1/icon_button.png">
    </a>
</section>
<p style="background: url(/static/images/activity/extension_1/icon_04.png) no-repeat;background-size: contain;display:block;margin: 1.6rem auto 1rem auto;text-align:center;width: 7rem;font-size:14px; line-height:1.7rem" class="activity_time"><strong>活动时间</strong></p>
<p style="background: url(/static/images/activity/extension_1/icon_08.png) no-repeat;background-size: contain;display:block;margin: 1rem auto 1rem auto;text-align:center;width: 80%;font-size:14px; line-height:2rem; height:3rem;color:black  " class="activity_time">2016年11月7日-2016年11月13日</p>
<p style="background: url(/static/images/activity/extension_1/icon_04.png) no-repeat;background-size: contain;display:block;margin: 1rem auto 1rem auto;text-align:center;width: 7rem;font-size:14px; line-height:1.7rem" class="activity_time"><strong>活动规则</strong></p>
<section style="background: url(/static/images/activity/extension_1/icon_05.png) no-repeat;background-size: contain;display:block;margin: 1rem auto 1rem auto;width: 80%;font-size:12px; line-height:1rem; height:10.8rem;padding:.4rem .5rem;color:black " class="activity_time">
    <apan><img src="/static/images/activity/extension_1/01_03.png" style="width:.6rem;margin:0 .2rem;position:relative;top: .1rem" >每天邀请成功的前1000个用户，获得提额200-1000元，可重复获得;</apan><br>
    <apan><img src="/static/images/activity/extension_1/01_07.png" style="width:.6rem;margin:0 .2rem;position:relative;top: .1rem" >活动期间邀请数前3名，分别获得10000，8000，5000元提额;</apan><br>
    <apan><img src="/static/images/activity/extension_1/01_10.png" style="width:.6rem;margin:0 .2rem;position:relative;top: .1rem" >所有获奖额度均在11-14（下周一）统一发放到位;</apan><br>
    <apan><img src="/static/images/activity/extension_1/01_12.png" style="width:.6rem;margin:0 .2rem;position:relative;top: .1rem" >快金对本次活动拥有最终解释权;</apan><br>
</section>
<div id="dialog" style="display: none">
    <img style='max-height: 10rem;position:fixed;top:1rem;right: 0;width: 9rem;z-index:100' src="/static/images/activity/extension_1/02_03.png">
</div>
<div id="fullbg" style="display: none"></div>
<section class="m-login-center" id="t-bomb_box_prompt" style="display: none">
    <p class="m-title">提示</p>
    <p class="m-tip" style="padding-left:10px;padding-right:10px; text-align: left;font-size:14px;line-height:1.5rem ">登录后才能参与活动，点击确定前往登录。登录后记得回来分享呦!</p>
    <a href="/Login?activity=inviteFriend&&jump=no" class="m-title" style="border-top: 1px solid #e0e0e0;display:block;height:3.25rem;line-height:3;text-decoration:none;  ">确定</a>
</section>
<!--<section style="max-height: 13rem;width: 100%;text-align:center;">-->
<!--    <img style='max-height: 13rem;width: 80%' src="/static/images/activity/share/06_06.png">-->
<!--</section>-->

</body>
</html>

<?php echo HTML::script('static/js/jquery-1.9.1.min.js'); ?>
<?php if($is_weixin){ if($login){?>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        var titil = "<?php echo $sharetitle; ?>";
        var text = "<?php echo $text; ?>";
        var url = "<?php echo $url; ?>";
        var img_url = "<?php echo $img_url; ?>";

        wx.config({
            debug: false,
            appId: '<?php echo $signPackage["appId"];?>',
            timestamp: <?php echo $signPackage["timestamp"];?>,
            nonceStr: '<?php echo $signPackage["nonceStr"];?>',
            signature: '<?php echo $signPackage["signature"];?>',
            jsApiList: [
                'onMenuShareTimeline',
                'onMenuShareAppMessage'
            ]});
        wx.ready(function () {
            wx.onMenuShareTimeline({
                title: titil, // 分享标题
                link: url, // 分享链接
                imgUrl: img_url, // 分享图标
                success:function(){
                    // 用户确认分享后执行的回调函数
                },
                cancel:function(){
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareAppMessage({
                title: titil, // 分享标题
                desc: text, // 分享描述
                link: url, // 分享链接
                imgUrl: img_url, // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success:function(){
                    // 用户确认分享后执行的回调函数
                },
                cancel:function(){
                    // 用户取消分享后执行的回调函数
                }
            });
        });
    </script>

<?php }}?>

<script type="text/javascript">
    function sendToAndroid(){
        <?php if($client=='android'){ if($login){ ?>
            window.share.runOnAndroidJavaScript('<?php echo $sharetitle; ?>','<?php echo $text; ?>','<?php echo $img_url; ?>','<?php echo $url; ?>');
        <?php } else{?>
            Prompt_show();
        <?php }?>
        <?php } else if($client=='ios'){ if($login){ ?>
            sharePhone('<?php echo $sharetitle; ?>','<?php echo $text; ?>','<?php echo $img_url; ?>','<?php echo $url; ?>');
        <?php } else{?>
            Prompt_show();
        <?php }?>
        <?php } ?>
    }
    $('#fullbg').click(function(){
        Prompt_hide();
    });
    $('#extensions').click(function(){
        statistics();
        <?php if($is_weixin){ if($login){?>
            $("#dialog").show();
            $('#fullbg').show();
        <?php }else{?>
            Prompt_show();
        <?php }}else{?>
            sendToAndroid();
        <?php }?>
    });

    function Prompt_show(){
        $("#t-bomb_box_prompt").show();
        $('#fullbg').show();

    }
    function Prompt_hide(){
        $("#t-bomb_box_prompt").hide();
        $('#fullbg').hide();
        $("#dialog").hide();
    }
    function statistics() {
        var obj = new Object();
        obj.user_id = "<?php echo empty($browseTotal['user_id'])?0:$browseTotal['user_id'] ?>";
        obj.pagetype = "<?php echo empty($browseTotal['pagetype'])?null:$browseTotal['pagetype'] ?>";
        obj.uniqueid = "<?php echo empty($browseTotal['uniqueid'])?null:$browseTotal['uniqueid'] ?>";
        obj.reg_app =  "<?php echo empty($browseTotal['reg_app'])?null:$browseTotal['reg_app'] ?>";
        obj.activity_id =  <?php echo empty($browseTotal['activity_id'])?null:$browseTotal['activity_id'] ?>;
        $.ajax({
            url:'/Activity/inviteFriend',
            type:'POST',
            data:{user_id:obj.user_id,pagetype:obj.pagetype,uniqueid:obj.uniqueid,reg_app:obj.reg_app,activity_id:obj.activity_id},
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


