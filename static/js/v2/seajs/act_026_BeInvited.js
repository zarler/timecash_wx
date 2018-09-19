/**
 * Created by liujinsheng on 16/9/7.
 */
define(function(require,exports,module){
    require('js/v2/common');
    require('Activity/TC0A-026/css/reset.css');
    require('Activity/TC0A-026/css/index.css');
    require('Activity/TC0A-026/js/pop');
    require('Activity/TC0A-026/js/lottery');
    require('Activity/TC0A-026/js/cssrem');

});
function subRegister(){
    $('.timecash').show();
}
times = 60;
//验证码
function VerCode(){
    var phone = $("input[name='phone']").val();
    if(commonUtil.phone(phone)!=true || commonUtil.phone(phone)!=true) {
        layerMobile.showlayer('手机为空或格式错误1!');
        layerMobile.changeCssMsg();
        return false;
    }
    timer = setInterval(function() {
        times--;
        if(times > 0) {
            $('.t-pwd-code').val(times +'秒后重发');
            $('.t-pwd-code').attr('disabled','disabled');
        } else {
            times = 60;
            $('.t-pwd-code').val('重发验证码');
            $('.t-pwd-code').removeAttr('disabled');
            clearInterval(timer);
        }
    }, 1000);
    $.ajax({
        url:seajs.data.vars.codeurl,  //<?php echo URL::site('Functions/repayCode');?>
        type:'POST',
        data:{phone:phone},
        dataType:'json',
        async: true,  //同步发送请求
        success:function(result){
            if(result.status===false){
                clearInterval(timer);
                $('.t-pwd-code').removeAttr('disabled');
                if(result.code==5007){
                    $('.user').show();
                    $('.timecash').hide();
                }else{
                    layerMobile.showlayer(result.msg);
                    layerMobile.changeCssMsg();
                }
                return false;
            }else if(result.status===true){
                commonUtil.tips();
                return true;
            }else if(result.status==='10023'){
                clearInterval(timer);
                layerMobile.showlayer('操作过于频繁');
                layerMobile.changeCssMsg();
                $('.t-pwd-code').removeAttr('disabled');
                return false;
            }
        },
        error:function(){
            layerMobile.showlayer('手机校验失败');
            layerMobile.changeCssMsg();
            $('.t-pwd-code').removeAttr('disabled');
            return true;
        }
    });
}
//注册
function  registerSub() {

    var phone = $("input[name='phone']").val();
    if(commonUtil.phone(phone)!=true || commonUtil.phone(phone)!=true) {
        layerMobile.showlayer('手机为空或格式错误!');
        layerMobile.changeCssMsg();
        return false;
    }
    var code = $("input[name='code']").val();

    if(code.length==4){
        var password = $("input[name='password']").val();
        if(commonUtil.pwd(password) != true){
            layerMobile.showlayer('密码为空或格式错误！');
            layerMobile.changeCssMsg();
            return false;
        }
        $.ajax({
            url:seajs.data.vars.repayurl,
            type:'POST',
            data:{phone:phone,password:password,code:code,inviterUserId:seajs.data.vars.inviterUserId,agent_code:'555000'},
            dataType:'json',
            async: true,  //同步发送请求
            beforeSend:function(){
            },
            success:function(result){
                if(result.status == true){
                    window.location.replace(seajs.data.vars.homeUrl);
                }else{
                    layerMobile.showlayer(result.msg);
                    layerMobile.changeCssMsg();
                    return false;
                }
            },
            error:function(){
                layerMobile.showlayer('表单提交失败');
                layerMobile.changeCssMsg();
                commonUtil.unlock();
                return true;
            }
        });
    }else{
        layerMobile.showlayer('验证码不能为空或格式错误!');
        layerMobile.changeCssMsg();
        return false;
    }
}
//领免息券
function  Coupons() {
    $.ajax({
        url:seajs.data.vars.couponsurl,
        type:'POST',
        data:{one:1},
        dataType:'json',
        async: true,  //同步发送请求
        beforeSend:function(){
        },
        success:function(result){
            if(result.status == true){
                $('.couponSuccess').show();
            }else{
                layerMobile.showlayer(result.msg);
                layerMobile.changeCssMsg();
                return false;
            }
        },
        error:function(){
            layerMobile.showlayer('表单提交失败');
            layerMobile.changeCssMsg();
            return true;
        }
    });
}

