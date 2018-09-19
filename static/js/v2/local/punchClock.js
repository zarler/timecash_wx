var layerMobile = {
    showlayer:function (msg) {
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
        });
    },
    changeCssMsg:function () {
        $('.layui-m-layermain .layui-m-layersection').css({'vertical-align':'bottom'});
        $('.layui-m-layer-msg').css({'margin':'.3rem auto .5rem auto'});
        $('.layui-m-layercont').css({'text-align':'center','font-size':'.3rem'});
    },
    changeCssPromptMsg:function () {
        $('.layui-m-layer-msg').css({'margin':'.3rem auto .5rem auto'});
        $('.layui-m-layercont').css({'font-size':'.3rem'});
    },
    submitPromptCoupon:function (msg,dayy) {
        layer.open({
            content: msg
            ,btn: ['确定', '取消']
            ,yes: function(index){
                exchangeCoupon(dayy);
                layer.close(index);
            }
        });
    },
    submitPromptJump:function (msg,dayy) {
        layer.open({
            content: msg
            ,btn: ['确定', '取消']
            ,yes: function(index){
                location.href = dayy;
                layer.close(index);
            }
        });
    },
    isnull:function(code,msg){
        var code  = $.trim(code);
        if(code == "" || code == undefined || code == null || code == 0 ) {
            return false;
        }
        return true;
    },
}
function showOne(){
    $('#demo').show();
    $('#rule').hide();
    $('.orange').removeClass('orange');
    $(this).addClass('orange');
}
function showTwo(){
    $('#demo').hide();
    $('#rule').show();
    $('.orange').removeClass('orange');
}

function chargeCss(){
    $('.layui-m-layercont').css({'font-size':'.3rem'});

}
//打卡函数
function punchClock(){
    var load = layer.open({type: 2,shadeClose:false});
    $.ajax({
        url:'/wx/FunctionsAct/PunchClock',
        type:'POST',
        data:{post:1},
        dataType:'json',
        async: true,  //同步发送请求t-mask
        beforeSend:function(){
        },
        success:function(result){
            layer.close(load);
            if(result.status == true){
                $('.date-items .nowday').addClass('selected');
                $('.circular button').text('已打卡').attr('onclick',"layerMobile.showlayer('您已经打过卡');layerMobile.changeCssMsg();");
                $('.dday strong').text($('.dday strong').text()*1+1);
                layerMobile.showlayer(result.msg);
                layerMobile.changeCssMsg();
                switch(total_day*1+1){
                    case 7:
                        layerMobile.submitPromptJump('恭喜您的可兑换天数已达7天,是否前往兑换优惠券?','/Sign/SignCoupon');
                        break;
                    case 14:
                        layerMobile.submitPromptJump('恭喜您的可兑换天数已达14天,是否前往兑换优惠券?','/Sign/SignCoupon');

                        break;
                    case 21:
                        layerMobile.submitPromptJump('恭喜您的可兑换天数已达21天,是否前往兑换优惠券?','/Sign/SignCoupon');
                        break;
                    default:
                        break;
                }
                layerMobile.changeCssPromptMsg();
            }else{
                layerMobile.showlayer(result.msg);
                layerMobile.changeCssMsg();
            }
        },
        error:function(){
            layer.close(load);
            layerMobile.showlayer('表单校验失败');
            layerMobile.changeCssMsg();
        }
    });
}
//兑换优惠券
function exchangeCoupon(exchangeDay){
    if(total_day>=exchangeDay){
        switch (exchangeDay){
            case "7":
                var templateId = 281;
                var moneyy = 10;
                break;
            case "14":
                var templateId = 282;
                var moneyy = 20;
                break;
            case "21":
                var templateId = 283;
                var moneyy = 30;
                break;
        }
        if(layerMobile.isnull(templateId)==true){
            var load = layer.open({type: 2,shadeClose:false});
            $.ajax({
                url:'/wx/FunctionsAct/ExchangeCoupon',
                type:'POST',
                data:{templateId:templateId},
                dataType:'json',
                async: true,  //同步发送请求t-mask
                beforeSend:function(){
                },
                success:function(result){
                    layer.close(load);
                    if(result.status == true){
                        total_day = total_day*1-exchangeDay*1;
                        changeCouponCss();
                        bomob_screen.firstready();
                        bomob_screen.exchangeCouponOk(true,moneyy);
                    }else{
                        layerMobile.showlayer(result.msg);
                        layerMobile.changeCssMsg();
                    }
                },
                error:function(){
                    layer.close(load);
                    layerMobile.showlayer('表单校验失败');
                    layerMobile.changeCssMsg();
                }
            });
        }else{
            layerMobile.showlayer('数据异常!');
            layerMobile.changeCssMsg();
        }
    }else{
        layerMobile.showlayer('兑换天数不够');
        layerMobile.changeCssMsg();
    }
}

function changeCouponCss() {
    $('.circular li').each(function(index,element){
        if(total_day>=element.dataset.day){
            if($(element).is('.oldcoupon')){
                $(element).removeClass('oldcoupon');
            }
            $(element).addClass('newcoupon');
        }else{
            if($(element).is('.newcoupon')){
                $(element).removeClass('newcoupon');
            }
            $(element).addClass('oldcoupon');
        }
    })
}
$('.circular .newcoupon').click(function (e) {
    // var load = layer.open({type: 2,shadeClose:false});
    if(total_day>=$(this).attr('data-day')){
        switch ($(this).attr('data-day')){
            case "7":
                var msg = '确定使用7天可兑换天数兑换10元优惠券';
                break;
            case "14":
                var msg = '确定使用14天可兑换天数兑换20元优惠券';
                break;
            case "21":
                var msg = '确定使用21天可兑换天数兑换30元优惠券';
                break;
        }
        layerMobile.submitPromptCoupon(msg,$(this).attr('data-day'));
        layerMobile.changeCssPromptMsg();
    }else{
        layerMobile.showlayer('兑换天数不够');
        layerMobile.changeCssMsg();
    }
});

//统计点击次数
function StatisticsClick() {
    $.ajax({
        url:'/wx/FunctionsAct/statisticsCouponOk',
        type:'POST',
        data:{post:1},
        dataType:'json',
        async: true,  //同步发送请求t-mask
        beforeSend:function(){
        },
        success:function(result){

        },
        error:function(){
            layerMobile.showlayer('表单校验失败');
            layerMobile.changeCssMsg();
        }

    });
    location.href ='/';
}

