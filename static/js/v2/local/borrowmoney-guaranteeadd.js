$(function(){
    //信用卡号
    $("input[name='card_no']").blur(function(){
        commonUtil.credit_no(this.value);
    });
    $("input[name='expire_month']").blur(function(){
        commonUtil.expire_month(this.value);
    });
    $("input[name='expire_yeah']").blur(function(){
        commonUtil.expire_yeah(this.value);
    });
    $("input[name='security_code']").blur(function(){
        commonUtil.security_code(this.value);
    });

});
$(".button_submit").click(function(){
    commonUtil.lockup();
    var expire_month=$("input[name='expire_month']").val();//有效期
    var expire_yeah=$("input[name='expire_yeah']").val();//有效期
    var card_no=$("input[name='card_no']").val();//信用卡号
    var security_code=$("input[name='security_code']").val();//安全码
    if(commonUtil.credit_no(card_no)!=true){
        commonUtil.unlock();
        return false;
    }
    if( commonUtil.security_code(security_code)!= true){
        commonUtil.unlock();
        return false;
    }
    if( commonUtil.expire_month(expire_month)!= true){
        commonUtil.unlock();
        return false;
    }
    if( commonUtil.expire_yeah(expire_yeah)!= true){
        commonUtil.unlock();
        return false;
    }
    $.ajax({
        url:seajs.data.vars.durl,
        type:'POST',
        data:{card_no:card_no,expire_month:expire_month,expire_yeah:expire_yeah,security_code:security_code},
        dataType:'json',
        async: true,  //同步发送请求t-mask
        beforeSend:function(){
            $('.t-mask').show();
        },
        success:function(result){
            commonUtil.unlock();
            if(result.status == true){
                $('.t-mask').hide();
                location.href = seajs.data.vars.jumpurl;
            }else{
                commonUtil.waring(result.msg);
                return false;
            }
        },
        error:function(){
            commonUtil.unlock();
            commonUtil.tips("表单校验失败");
            return false;
        }
    });

});
