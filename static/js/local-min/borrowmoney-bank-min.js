/**
 * Created by liujinsheng on 16/9/8.
 */
//银行卡号
var formarr = {
    "company":{10001:"公司名称不能为空", 10002:"请输入有效的公司名称"},
    "companydetail":{10001:"公司地址不能为空", 10002:"请输入有效的公司地址"},
    "family":{10001:"家庭住址不能为空", 10002:"请输入有效的家庭住址"},
    "contact":{10001:"名称不能为空",10002:"名称格式不对", 10003:"手机号不能为空",10004:"手机号格式不对"},
    "contact_people":{'parent':"父母",'brother':"兄弟姐妹",'spouse':"配偶",'children':"子女",'colleague':"同事",'classmate':"同学",'friend':"朋友"},
    "zname":{10001:"姓名不能为空",10002:"请输入有效的姓名"},
};
$("input[name='card_no']").blur(function(){
    commonUtil.card_no(this.value);
});
$("input[name='name']").blur(function(){
    commonUtil.zname(this.value,'zname');
});
//身份账号判断
$("input[name='identity_code']").blur(function(){
    commonUtil.code(this.value);
});
//手机验证码
$("input[name='authcode']").blur(function(){
    commonUtil.authcode(this.value);
});
//银行点击显示
$('.t-re-bank').click(function(){
    $('#t-box_alert').show();
    $('.t-mask').show();
});
//银行点击隐藏
$('.t-bomb_close').click(function(){
    $('#t-box_alert').hide();
    $('.t-mask').hide();
});
//点击银行的悬浮框  添加到页面银行
$('.t-bomb_box-6 p').click(function(){
    name = $(this).attr('data');
    id = $(this).attr('id');
    checkedid = $('input:radio[name="bank_card_str"]:checked').attr("id");
    $("#".checkedid).removeAttr("checked");
    $("#checkbox_a1"+id).attr("checked","checked");
    code = $(this).attr('code');
    $('.t-re-bank p').text(name);
    $("input[name='bank_id']").val(id);
    $("input[name='bank_code']").val(code);
    $('#t-box_alert').hide();
    $('.t-mask').hide();
});
var submit = 0;
//登录按钮提交
$(".t-red-bank").click(function(){
    commonUtil.lockup();
    var bank=$("input[name='bank_id']").val();
    var card_no=$("input[name='card_no']").val();
    var name=$("input[name='name']").val();
    var identity_code=$("input[name='identity_code']").val();
    // var authcode=$("input[name='authcode']").val();
    var aggreement = $('#checkbox_a1').is(':checked');
    if(commonUtil.bank(bank)!=true){
        commonUtil.unlock();
        return false;
    }
    if( commonUtil.card_no(card_no)!= true){
        commonUtil.unlock();
        return false;
    }
    if( commonUtil.zname(name,'zname')!= true){
        commonUtil.unlock();
        return false;
    }
    if( commonUtil.code(identity_code)!= true){
        commonUtil.unlock();
        return false;
    }
    // if( commonUtil.authcode(authcode)!= true){
    //     commonUtil.unlock();
    //     return false;
    // }
    if(commonUtil.aggreement(aggreement)!=true){
        commonUtil.unlock();
        return false;
    }
    if(submit == 0){
        submit = 1;
        commonUtil.unlock();
        commonUtil.tips();
        $("#t-box_alert2").show();
        $('.t-mask').show();
        var a=$("#t-bomb_box").height();
        $("#t-bomb_box").css({'marginTop':-a/2});
        var times = 10;
        durl= seajs.data.vars.durl;
        $('.btn-time').addClass('t-gray-btn');
        $(".btn-time").attr('disabled',true);
        $('.btn-time').removeClass('t-red-btn');
        timer = setInterval(function() {
            times--;
            if(times > 0) {
                $('.btn-time').text('确定('+times+' s)');
            } else {
                times = 10;
                $('.btn-time').text('确定');
                //$('.btn-time').attr('href',durl);
                $('.btn-time').attr('href','javascript:commonUtil.submit();');
                $('.btn-time').removeClass('t-gray-btn');
                $('.btn-time').addClass('t-red-btn');
                clearInterval(timer);
            }
        }, 1000);
        return false;
    }else{
        commonUtil.submit();
    }
    $.ajax({
        url:seajs.data.vars.url,
        type:'POST',
        data:{bank:bank,card_no:card_no,aggreement:aggreement,name:name,identity_code:identity_code,authcode:authcode},
        dataType:'json',
        async: true,  //同步发送请求t-mask
        beforeSend:function(){
        },
        success:function(result){
            if(result.status == true){
                commonUtil.unlock();
                commonUtil.tips();
                $("#t-box_alert2").show();
                $('.t-mask').show();
                var a=$("#t-bomb_box").height();
                $("#t-bomb_box").css({'marginTop':-a/2});
                var times = 10;
                //根据入口变量来获取跳转地址;
                durl= seajs.data.vars.durl;
                $('.btn-time').addClass('t-gray-btn');
                $(".btn-time").attr('disabled',true);
                $('.btn-time').removeClass('t-red-btn');
                timer = setInterval(function() {
                    times--;
                    if(times > 0) {
                        $('.btn-time').text('确定('+times+' s)');
                    } else {
                        times = 10;
                        $('.btn-time').text('确定');
                        $('.btn-time').attr('href',durl);
                        $('.btn-time').removeClass('t-gray-btn');
                        $('.btn-time').addClass('t-red-btn');
                        clearInterval(timer);
                    }
                }, 1000);
                return false;
            }else{
                commonUtil.waring(result.msg);
                commonUtil.unlock();
                return false;
            }
        },
        error:function(){
            commonUtil.unlock();
            commonUtil.tips("表单校验失败");
            return  false;
        }
    });
});

var commonUtil={
    bank:function(bank){
        bank=$.trim(bank);

        if(bank =="" || bank == null ) {
            commonUtil.waring('请选择银行');
            return false;
        }
        commonUtil.tips();
        return true;
    },

    submit:function () {
        commonUtil.lockup();
        commonUtil.tips();
        var bank=$("input[name='bank_id']").val();
        var card_no=$("input[name='card_no']").val();
        var name=$("input[name='name']").val();
        var identity_code=$("input[name='identity_code']").val();
        // var authcode=$("input[name='authcode']").val();
        var aggreement = $('#checkbox_a1').is(':checked');
        $('#t-bomb_box').hide();
        if(commonUtil.bank(bank)!=true){
            commonUtil.unlock();
            return false;
        }
        if( commonUtil.card_no(card_no)!= true){
            commonUtil.unlock();
            return false;
        }
        if( commonUtil.zname(name,'zname')!= true){
            commonUtil.unlock();
            return false;
        }
        if( commonUtil.code(identity_code)!= true){
            commonUtil.unlock();
            return false;
        }
        // if( commonUtil.authcode(authcode)!= true){
        //     commonUtil.unlock();
        //     return false;
        // }
        if(commonUtil.aggreement(aggreement)!=true){
            commonUtil.unlock();
            return false;
        }
        $.ajax({
            url:seajs.data.vars.url,
            type:'POST',
            data:{bank:bank,card_no:card_no,aggreement:aggreement,name:name,identity_code:identity_code},
            dataType:'json',
            async: true,  //同步发送请求t-mask
            beforeSend:function(){
            },
            success:function(result){
                if(result.status == true){
                    location.href = seajs.data.vars.durl;
                }else{
                    commonUtil.waring(result.msg);
                    commonUtil.unlock();
                    return false;
                }
            },
            error:function(){
                commonUtil.unlock();
                commonUtil.tips("表单校验失败");
                return  false;
            }
        });
    },
    aggreement:function(aggreement){
        if(aggreement){
            commonUtil.tips();
            return true;
        }else{
            commonUtil.waring('请同意协议');
            return false;
        }
    },
    card_no:function(card_no){
        card_no=$.trim(card_no);
        var pattern = /^\d{16}|\d{17}|\d{18}|\d{19}$/;
        if(card_no =="" || card_no == null ) {
            commonUtil.waring('银行卡号不能为空');
            return false;
        }
        if(!card_no.match(pattern)) {
            commonUtil.waring('银行卡号格式不正确');
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
    },
    //真实姓名
    zname:function(zname,type){
        zname=$.trim(zname);
        var pattern = /^[\u4e00-\u9fa5]{2,}$/;
        if(zname =="" || zname == null ) {
            commonUtil.waring(formarr[type][10001]);
            return false;
        }
        if(!zname.match(pattern)) {
            commonUtil.waring(formarr[type][10002]);
            return false;
        }
        commonUtil.tips();
        return true;
    },
    //身份证账号
    code:function(code){
        code=$.trim(code);
        var pattern = /^(\d{17}X|\d{18})$/i;
        if(code =="" || code == null ) {
            commonUtil.waring('身份证账号不能为空');
            return false;
        }
        if(!code.match(pattern)) {
            commonUtil.waring('身份证账号格式错误');
            return false;
        }
        commonUtil.tips();
        return true;
    },
    authcode:function(authcode,msg){
        authcode=$.trim(authcode);

        if(authcode =="" || authcode == null ) {
            if(msg==2){
                commonUtil.waring('请填写邮箱验证码');
            }else if(msg==3){
                commonUtil.waring('请填写验证码');
            }else{
                commonUtil.waring('请填写手机验证码');
            }

            return false;
        }
        if(msg==3){
            if(authcode.length!=6) {
                commonUtil.waring('验证码必须是六位整数');
                return false;
            }
        }else{
            if(authcode.length!=4) {
                if(msg==2){
                    commonUtil.waring('请填写正确邮箱验证码');
                }else{
                    commonUtil.waring('请填写正确手机验证码');
                }
                return false;
            }
        }
        commonUtil.tips();
        return true;
    },
};