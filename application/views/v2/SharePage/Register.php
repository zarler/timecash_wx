<?php //include Kohana::find_file('views', 'v2/public/newHead');?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo isset($title)?$title:'快金';?></title>
    <!--    <title>快金</title>-->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/ui_bootstrap/layer/layer.js'); ?>

</head>
<body>


<script>
//    seajs.config({
//        vars: {
//            'user_id':'<?php //echo isset($_VArray['userId'])?$_VArray['userId']:0; ?>//',
//            'smsUrl':'<?php //echo isset($_VArray['codeUrl'])?$_VArray['codeUrl']:''; ?>//',
//            'reqUrl':'<?php //echo isset($_VArray['reqUrl'])?$_VArray['reqUrl']:''; ?>//',
//        }
//    });
//    seajs.use('js/v2/seajs/peoplepull-register');
    $(document).ready(function() {
        //自定义标题风格
        layer.open({
            title: [
                '提示',
                'background-color: #FF4351; color:#fff;'
            ]
            , content: '活动已下线！'
        });
    });
</script>
<!--<style>-->
<!--    .hideshow{-->
<!--        display: none;-->
<!--    }-->
<!--</style>-->
<!--<body>-->
<!--<div class="loading_ok" style="display: none">-->
<!--<section  class="circular">-->
<!--    <img src="/static/images/v2/peoplepull/007.png" class="text_width_56"/>-->
<!--    <img src="/static/images/v2/peoplepull/008.png" class="text_width_56" style="margin-bottom: 2.5rem;"/>-->
<!--    <div class="peoplepull_r_two">-->
<!--        <p><input type="text" placeholder="请输入您的手机号" class="form-control text_width_87" name="reg_phone"></p>-->
<!--        <div style="margin: 0 6.5%;">-->
<!--            <p style="float: left;width: 53%;"><input style="width:80%" type="text" placeholder="请输入短信验证码" class="form-control text_width_40" name="reg_authcode"></p>-->
<!--            <button class="veributton" style="float: right;width: 32%;text-align: center;">获取验证码</button>-->
<!--        </div>-->
<!--        <div style="clear: both;"></div>-->
<!--        <p class="hideshow" style="display: none"><input type="password"  placeholder="请设置您的密码" class="form-control text_width_87" name="reg_password"></p>-->
<!--    </div>-->
<!--</section>-->
<!--<div style="clear: both;"></div>-->
<!--<div class="hideshow" style="width: 100%;height: 1rem"></div>-->
<!--<section class="peopel_button_r"><a style="color: #221c39;" href="javascript:peopel_button_r();">点击领取大礼包</a></section>-->
<!--<p style="text-align: center;font-size: .27rem;color: #54468A;margin-top:.5rem">-->
<!--    <img src="/static/images/v2/peoplepull/010.png" style="width: .4rem;float: left;margin-right: .6rem;left: 1.3rem;position: relative;" >新用户点击领取即视为同意<<快金注册协议>><img src="/static/images/v2/peoplepull/010.png" style="width: .4rem;float: right;margin-right: .6rem;right: 1rem;position: relative;" >-->
<!--</p>-->
<!--<div style="clear: both;"></div>-->
<!--<div class="peopel_three" style="margin-top: .5rem;">-->
<!--    <div style="color: white;height:.9rem">-->
<!--        <img src="/static/images/v2/peoplepull/010.png" style="width: .6rem;float: left;margin-right: .6rem;left: .3rem;position: relative;top: .1rem;" >-->
<!--        <p style="text-align: center;width: 85%;height: .8rem;line-height: .9rem;font-size: .4rem;">活动规则</p>-->
<!--    </div>-->
<!--    <div class="right-div" style="margin-top: .3rem;display:block; ">-->
<!--        <div class="p_notice">-->
<!--            1.点击“我要去赚钱”将活动页面分享给微信好友或分享到朋友圈，好友点击进入活动页面即可领取100元新客专享大礼包。<br>-->
<!--            2.领券好友必须未注册过快金账号或注册后未在快金平台产生过极速贷借款订单。;<br>-->
<!--            3.未注册过快金帐号的好友完成首笔借款，邀请人可获得20元现金奖励；注册后未在快金平台产生极速贷借款订单的用户完成首笔借款，邀请人可获得10元现金奖励，自身原因不可借款的好友无效。<br>-->
<!--            4.优惠券有效期为到账后30个自然日。<br>-->
<!--            5.好友借款后扫描页面二维码关注快金服务号，邀请人还可获得1元现金奖励，好友关注微信现金奖每月限前30名有效，重复关注无效。<br>-->
<!--            6.活动最终解释权归快金所有。<br>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--<section class="promptselect">为什么选择快金</section>-->
<!--<footer style="text-align: center;">-->
<!--    <span style="display: block;color: yellow;font-size: .3rem;margin-bottom: .2rem;width: 90%;">一分钟放款</span>-->
<!--    <span style="color: yellow;font-size: .3rem;margin-bottom: .2rem;position: relative;top:-5.5rem;left: .4rem;">0担保</span>-->
<!--    <img src="/static/images/v2/peoplepull/0014.png" width="60%" />-->
<!--    <span style="color: yellow;font-size: .3rem;margin-bottom: .2rem;position: relative;top:-5.8rem;right: .4rem;">3秒审核</span>-->
<!--</footer>-->
<!--    </div>-->
<!--</body>-->
<!--<script>-->
<!--    var _hmt = _hmt || [];-->
<!--    (function() {-->
<!--        var hm = document.createElement("script");-->
<!--        hm.src = "https://hm.baidu.com/hm.js?1dceaa9922352fd2c81930784948dc71";-->
<!--        var s = document.getElementsByTagName("script")[0];-->
<!--        s.parentNode.insertBefore(hm, s);-->
<!--    })();-->
<!--</script>-->
<!--</html>-->