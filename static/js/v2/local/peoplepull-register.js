$(document).ready(function(){
    //点击获取手机验证码
    var times = 60;
    $('.veributton').click(function(){
        var phone=$("input[name='reg_phone']").val();
        if(commonUtil.phone(phone)!=true) {
            layerMobile.showlayer('手机号不能为空或格式错误!');
            layerMobile.changeCssMsg();
            return false;
        }
        timer = setInterval(function() {
            times--;
            if(times > 0) {
                $('.veributton').text(times +'秒后重发');
                $('.veributton').attr('disabled','disabled');
                // $('.t-pwd-code').addClass('t-gray');
            } else {
                times >= 60;
                $('.veributton').text('重发验证码');
                $('.veributton').removeAttr('disabled');
                //$('.t-pwd-code').removeClass('t-gray');
                clearInterval(timer);
            }
        }, 1000);
        $.ajax({
            url:seajs.data.vars.smsUrl,
            type:'POST',
            data:{phone:phone,user_id:seajs.data.vars.user_id},
            dataType:'json',
            async: true,  //同步发送请求
            success:function(result){
                if(result.status==true){
                    //显示添加密码框(注册过)
                    if(layerMobile.isnull(result.userid)==true){
                        $('.peopel_button_r a').attr('href','javascript:peopel_button_o('+result.userid+','+result.coupons+');');
                    }else{
                        //未注册
                        $('.hideshow').show();
                    }
                    return true;
                }else{
                    layerMobile.showlayer(result.msg);
                    layerMobile.changeCssMsg();
                    $('.veributton').text('重发验证码');
                    $('.veributton').removeAttr('disabled');
                    clearInterval(timer);
                    return false;
                }
            },
            error:function(){
                layerMobile.showlayer('手机校验失败!');
                layerMobile.changeCssMsg();
                $('.veributton').text('重发验证码');
                $('.veributton').removeAttr('disabled');
                clearInterval(timer);
                return false;
            }
        });
    });


    // $(".peopel_button_r").click(function(){
    //
    // });
});
//提交注册
//注册按钮
function peopel_button_r() {
    var phone=$("input[name='reg_phone']").val();
    var authcode=$("input[name='reg_authcode']").val();
    var password=$("input[name='reg_password']").val();
    if(commonUtil.phone(phone)!=true) {
        layerMobile.showlayer('手机号不能为空或格式错误!');
        layerMobile.changeCssMsg();
        return false;
    }
    if(commonUtil.authcode(authcode)!=true){
        layerMobile.showlayer('验证码不能为空或格式错误!');
        layerMobile.changeCssMsg();
        return false;
    }
    if(commonUtil.pwd(password)!=true){
        layerMobile.showlayer('登录密码必须是6-20位字母数字组合!');
        layerMobile.changeCssMsg();
        return false;
    }
    var load = layer.open({type: 2,shadeClose:false});
    $.ajax({
        url:seajs.data.vars.reqUrl,
        type:'POST',
        data:{phone:phone,password:password,authcode:authcode,user_id:seajs.data.vars.user_id},
        dataType:'json',
        async: true,  //同步发送请求t-mask
        beforeSend:function(){
        },
        success:function(result){
            layer.close(load);
            if(result.status == true){
                location.href = "/wx/SharePage/InvitationShare";
            }else{
                if(layerMobile.isnull(result.code)==true&&result.code==5007){
                    //已经注册
                    //alert(111111);
                    layerMobile.submitUrlSelect('您已注册快金，赶快去借款吧！','立即借款','/');
                    layerMobile.changeCssPromptMsg();
                }else{
                    layerMobile.showlayer(result.msg);
                    layerMobile.changeCssMsg();
                }
                return false;
            }
        },
        error:function(){
            layer.close(load);
            layerMobile.showlayer('表单校验失败');
            layerMobile.changeCssMsg();
            return  false;
        }
    });
}

//老用户提交
function peopel_button_o(userid,coupons) {
    if(layerMobile.isnull(userid)==false){
        layerMobile.showlayer('手机号不能为空或格式错误!');
        layerMobile.changeCssMsg();
        return false;
    }
    var phone=$("input[name='reg_phone']").val();
    var authcode=$("input[name='reg_authcode']").val();
    if(commonUtil.phone(phone)!=true) {
        layerMobile.showlayer('手机号不能为空或格式错误!');
        layerMobile.changeCssMsg();
        return false;
    }
    if(commonUtil.authcode(authcode)!=true){
        layerMobile.showlayer('验证码不能为空或格式错误!');
        layerMobile.changeCssMsg();
        return false;
    }
    var load = layer.open({type: 2,shadeClose:false});
    $.ajax({
        url:'/Functions/peoplePullDoregisterOld',
        type:'POST',
        data:{phone:phone,authcode:authcode,user_id:userid},
        dataType:'json',
        async: true,  //同步发送请求t-mask
        beforeSend:function(){
        },
        success:function(result){
            layer.close(load);
            if(result.status == true){
                location.href = "/SharePage/InvitationShare?user_id="+result.user_id+"&&coupons="+coupons;
            }else{
                layerMobile.showlayer(result.msg);
                layerMobile.changeCssMsg();
                return false;
            }
        },
        error:function(){
            layer.close(load);
            layerMobile.showlayer('表单校验失败');
            layerMobile.changeCssMsg();
            return  false;
        }
    });
}