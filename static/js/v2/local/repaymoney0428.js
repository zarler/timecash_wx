var times = 60;
$('.t-pwd-code').click(function(){
    var orderid=$("input[name='orderid']").val();
    if(orderid == "" || orderid == undefined || orderid == null || orderid == 0 ) {
        commonUtil.waring('异常错误，请刷新！');
        return false;
    }
    timer = setInterval(function() {
        times--;
        if(times > 0) {
            $('.t-pwd-code').text(times +'秒后重发');
            $('.t-pwd-code').attr('disabled','disabled');
        } else {
            times = 60;
            $('.t-pwd-code').text('重发验证码');
            $('.t-pwd-code').removeAttr('disabled');
            clearInterval(timer);
        }
    }, 1000);
    $.ajax({    
        url:seajs.data.vars.codeurl,  //<?php echo URL::site('Functions/repayCode');?>
        type:'POST',
        data:{orderid:orderid},
        dataType:'json',
        async: true,  //同步发送请求
        success:function(result){
            if(result.status===false){
                clearInterval(timer);
                commonUtil.waring(result.msg);
                $('.t-pwd-code').removeAttr('disabled');
                return false;
            }else if(result.status===true){
                commonUtil.tips();
                return true;
            }else if(result.status==='10023'){
                clearInterval(timer);
                commonUtil.waring("操作过于频繁");
                $('.t-pwd-code').removeAttr('disabled');
                return false;
            }
        },
        error:function(){
            commonUtil.waring("手机校验失败");
            $('.t-pwd-code').removeAttr('disabled');
            return true;
        }
    });
});

if(seajs.data.vars.orderstatus == 'repay_succ'){

}else{
    $('.button_repay').click(function(){
        commonUtil.lockup();
        var code = $("input[name='code']").val();
        var orderid=$("input[name='orderid']").val();
        if(commonUtil.authcode(code)!=true) {
            commonUtil.unlock();
            return false;
        }
        if(orderid == "" || orderid == undefined || orderid == null || orderid == 0 ) {
            commonUtil.waring('异常错误，请刷新！');
            commonUtil.unlock();
            return false;
        }
        if(code.length==4){
            $.ajax({
                url:seajs.data.vars.repayurl,
                type:'POST',
                data:{code:code,orderid:orderid},
                dataType:'json',
                async: true,  //同步发送请求
                beforeSend:function(){
                },
                success:function(result){
                    if(result.status == true){
                        location.href = "/Repaymoney/repayStatus"
                    }else{
                        commonUtil.unlock();
                        commonUtil.waring(result.msg);
                        return false;
                    }
                },
                error:function(){
                    commonUtil.waring("表单提交失败");
                    commonUtil.unlock();
                    return true;
                }
            });
        }else{
            commonUtil.unlock();
            commonUtil.waring('验证码格式错误');
            $('.t-pwd-code').removeAttr('disabled');
            return false;
        }
    });
}
