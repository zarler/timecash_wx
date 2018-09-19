<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <?php echo HTML::style('static/css/activity/extension_1/extension_1.css'); ?>
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js'); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<style>
    .m-login-center{
        margin: 0 2.95rem;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: .3rem;
        position:fixed;
        top: 200px;
        z-index: 3;
        text-align: center;
        width: 60%;
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
        padding: 2.55rem 1rem;
    }
</style>

<body>
    <div class="all">
        <section>
            <div>
                <?php echo HTML::image('static/images/activity/extension_1/icon_07.png',array("class"=>"icon_07"));?>
                <div>
                    <?php echo HTML::image('static/images/activity/extension_1/icon_01.png',array("class"=>"icon_01"));?>
                    <?php echo HTML::image('static/images/activity/extension_1/icon_02.png',array("class"=>"icon_02"));?>
                </div>
                <div>
                    <a href="javascript:sendToAndroid();">
                        <?php echo HTML::image('static/images/activity/extension_1/icon_button.png',array("id"=>"extensions"));?>
                    </a>
                </div>
                <div>
                    <?php echo HTML::image('static/images/activity/extension_1/icon_04.png',array("class"=>"icon_04"));?>
                    <p class="activity_time">活动时间</p>
                </div>
                <div>
                    <?php echo HTML::image('static/images/activity/extension_1/icon_08.png',array("class"=>"icon_08"));?>
                    <p class="activity_times">即日起至10月30日</p>
                </div>
                <div>
                    <?php echo HTML::image('static/images/activity/extension_1/icon_04-1.png',array("class"=>"icon_04-1"));?>
                    <p class="activity_rule">活动规则</p>
                </div>
                <div>
                    <?php echo HTML::image('static/images/activity/extension_1/icon_05.png',array("class"=>"icon_05"));?>
                    <div class="activity_rules" >
                        <p><?php echo HTML::image('static/images/activity/extension_1/01_03.png',array("class"=>"icon_06"));?>邀请微信好友关注快金服务号并注册；</p>
                        <p><?php echo HTML::image('static/images/activity/extension_1/01_07.png',array("class"=>"icon_06"));?>每天前100名邀请成功的用户，即可获500元提额奖励；</p>
                        <p><?php echo HTML::image('static/images/activity/extension_1/01_12.png',array("class"=>"icon_06"));?>活动期间邀请总数前三名的用户；</p>
                        <p>分别可提额3000、2000、1000元；</p>
                        <p><?php echo HTML::image('static/images/activity/extension_1/01_12.png',array("class"=>"icon_06"));?>本次活动提额奖励总额最高可达10000元；</p>
                        <p><?php echo HTML::image('static/images/activity/extension_1/01_14.png',array("class"=>"icon_06"));?>本活动解释权归快金所有。</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="dialog">
        <?php echo HTML::image('static/images/activity/extension_1/02_03.png',array("id"=>"extension"));?>
    </div>
    <div id="fullbg" style="display: none"></div>
    <section class="m-login-center" id="t-bomb_box_prompt" style="display: none">
        <p class="m-title">提示</p>
        <p class="m-tip" style="padding-left:10px;padding-right:10px; text-align: left; ">登录后才能参与活动，点击确定前往登录。登录后记得回来分享呦!</p>
        <a href="/Login?jump=no" class="m-title" style="border-top: 1px solid #e0e0e0;display:block;height:3.25rem;line-height:4  ">确定</a>
    </section>
</body>
</html>
<?php echo HTML::script('static/js/jquery.js'); ?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    function sendToAndroid(){
        <?php if($client=='android'){ if($login){ ?>
            window.share.runOnAndroidJavaScript('<?php echo $title; ?>','<?php echo $text; ?>','<?php echo $img_url; ?>','<?php echo $url; ?>');
        <?php } else{?>
            Prompt_show();
        <?php }?>
        <?php } else if($client=='ios'){ if($login){ ?>
            sharePhone('<?php echo $title; ?>','<?php echo $text; ?>','<?php echo $img_url; ?>','<?php echo $url; ?>');
        <?php } else{?>
             Prompt_show();
            <?php }?>
        <?php } ?>
    }
    $('#fullbg').click(function(){
        Prompt_hide();
    });
    $('#extensions').click(function(){
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
    }

</script>

