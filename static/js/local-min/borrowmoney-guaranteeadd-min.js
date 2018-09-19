$(function(){
    //信用卡号
    $("input[name='card_no']").blur(function(){
        commonUtil.card_no(this.value);
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



$(".t-red-btn-ok").click(function(){
    commonUtil.lockup();
    var expire_month=$("input[name='expire_month']").val();//有效期
    var expire_yeah=$("input[name='expire_yeah']").val();//有效期
    var card_no=$("input[name='card_no']").val();//信用卡号
    var security_code=$("input[name='security_code']").val();//安全码

    if(commonUtil.card_no(card_no)!=true){
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

function prompt_hide(){
    $('.t-mask').hide();
    $('#t-bomb_box_prompt').hide();
};

function prompt_show(){
    $('.t-mask').show();
    $('#t-bomb_box_prompt').show();
};

var commonUtil={

    card_no:function(card_no){
        card_no=$.trim(card_no);
        var pattern = /^\d{16}$/;
        if(card_no =="" || card_no == null ) {
            commonUtil.waring('信用卡号不能为空');
            return false;
        }
        if(!card_no.match(pattern)) {
            commonUtil.waring('信用卡号格式不正确');
            return false;
        }
        commonUtil.tips();
        return true;

    },
    expire_month:function(expire_month){
        expire_month=$.trim(expire_month);
        var pattern = /^0[1-9]|1[0-2]$/;
        if(expire_month =="" || expire_month == null ) {
            commonUtil.waring('有效期(月)不能为空');
            return false;
        }
        if(!expire_month.match(pattern)||expire_month.length!=2) {
            commonUtil.waring('有效期(月)格式不正确');
            return false;
        }
        commonUtil.tips();
        return true;
    },
    expire_yeah:function(expire_yeah){
        expire_yeah=$.trim(expire_yeah);
        var myDate = new Date();
        var year = myDate.getYear()
        var year = year < 2000 ? year + 1900 : year
        var yy = year.toString().substr(2, 2);
        var pattern = /^\d{2}$/;
        if(expire_yeah =="" || expire_yeah == null ) {
            commonUtil.waring('有效期(年)不能为空');
            return false;
        }
        if(!expire_yeah.match(pattern) ) {
            commonUtil.waring('有效期(年)格式不正确');
            return false;
        }
        if(expire_yeah<yy){
            commonUtil.waring('有效期(年)不足');
            return false;
        }
        commonUtil.tips();
        return true;
    },
    security_code:function(security_code){
        security_code=$.trim(security_code);
        var pattern = /^\d{3}$/;
        if(security_code =="" || security_code == null ) {
            commonUtil.waring('安全码不能为空');
            return false;
        }
        if(!security_code.match(pattern)) {
            commonUtil.waring('安全码格式不正确');
            return false;
        }
        commonUtil.tips();
        return true;
    },
    tips:function(){
        $(".t-error").text('');
    },
    waring:function(msg){
        $(".t-error").text(msg);

    },
    lockup:function(){
        $('.t-red-btn').addClass('t-gray-btn');
        $(".t-red-btn").attr('disabled',true);
        $('.t-red-btn').removeClass('t-red-btn');
        load = layer.load(2, {shade: false});
        $('.t-mask').show();
    },
    unlock:function(){
        $('.t-gray-btn').addClass('t-red-btn');
        $(".t-red-btn").attr('disabled',false);
        $('.t-gray-btn').removeClass('t-gray-btn');
        layer.close(load);
        $('.t-mask').hide();
    }

}
