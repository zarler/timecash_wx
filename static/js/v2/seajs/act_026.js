/**
 * Created by liujinsheng on 16/9/7.
 */
define(function(require,exports,module){
    require('js/v2/common');
    $('.bb_modal').click(function () {
        $('.bombbox').show();
        $('.mask').show();
        $('body').css('position','fixed');
        $('body').css('width','100%');
    });
    $('.md-close').click(function () {
        $('.bombbox').hide();
        $('.bombbox1').hide();
        $('.bombbox2').hide();
        $('.bombbox3').hide();
        $('.bombbox4').hide();
        $('.mask').hide();
        $('body').css('position','');
    });
    $('.jiathis_button_2weima').click(function () {
        $('.bombbox3').hide();
        $('.mask').hide();
        $('body').css('position','');
    });

    bomob_screen.firstready();
    $('#bomb_screen').on('click',function () {
        bomob_screen.bomobremove();
    });

    if(seajs.data.vars.wx==1){
        var wx = require('https://res.wx.qq.com/open/js/jweixin-1.0.0.js?121113');
        wx.config({
            debug: false,
            appId: seajs.data.vars.appId,
            timestamp:seajs.data.vars.timestamp,
            nonceStr:seajs.data.vars.nonceStr,
            signature:seajs.data.vars.signature,
            jsApiList: [
                'onMenuShareTimeline',
                'onMenuShareAppMessage'
            ]
        });
        wx.ready(function () {
            wx.onMenuShareTimeline({
                title: seajs.data.vars.sharetitle, // 分享标题
                link: seajs.data.vars.url, // 分享链接
                imgUrl: seajs.data.vars.img_url, // 分享图标
                success:function(){
                   shareAjax();
                },
                cancel:function(){
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareAppMessage({
                title: seajs.data.vars.sharetitle, // 分享标题
                desc: seajs.data.vars.text, // 分享描述
                link: seajs.data.vars.url, // 分享链接
                imgUrl: seajs.data.vars.img_url, // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success:function(){
                   shareAjax();
                },
                cancel:function(){
                    // 用户取消分享后执行的回调函数
                }
            });
        });
    }

});
function showbombox(num) {
    $('.bombbox'+num).show();
    $('.mask').show();
    $('body').css('position','fixed');
    $('body').css('width','100%');
}
function hidebombox(num) {
    $('.bombbox'+num).hide();
    $('.mask').hide();
    $('body').css('position','');
}
function receiveReward(num,str) {
    switch (num){
        case 1:case 2:case 3:case 4:

        break;

        case 5:
            if(str==1){
                //微信端未登录
                $('.bombboxag4 a').attr('href','/Login').text('前往登录');
                $('.bombboxag4 p').text('您还没有登录哦~ 请先登录账号！');
                $('.bombbox4').show();
                $('.mask').show();
                break;
            }else{
                $('.bombboxag4 a').attr('href',str).text('前往登录');
                $('.bombboxag4 p').text('您还没有登录哦~ 请先登录账号！');
                $('.bombbox4').show();
                $('.mask').show();
                break;
            }

        //不能体现
        case  6:
            $('.bombboxag4 a').attr('href',"javascript:$('.bombbox4').hide();$('.mask').hide();").text('好的');
            $('.bombboxag4 p').html('活动尚未开始无法提现，</br>活动日期：4月26日-5月25日！');
            $('.bombbox4').show();
            $('.mask').show();
            // layerMobile.submitOk('活动尚未开始无法提现</br>活动日期：4月26日-5月25日！');
            // layerMobile.changeCssPromptMsgAtc();
            break;
        default:
            $('.bombboxag4 a').attr('href',str).text('前往登录');
            $('.bombboxag4 p').text('您还没有登录哦~ 请先登录账号！');
            $('.bombbox4').show();
            $('.mask').show();
            break;
    }
}

function Standard(num) {
    layerMobile.showlayer('借款人数满'+num+'才可领取');
    layerMobile.changeCssMsg2();
}


function shareAjax(){
    $.ajax({
        url: seajs.data.vars.shareButtonUrl,
        type: 'POST',
        //data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
        data:{action:'share',event_name:'TCOA_026'},
        dataType: 'json',
        async: true,  //同步发送请求t-mask
        beforeSend: function () {
        },
        success: function (result) {
        },
        error: function () {

        }
    });
}


//点击统计
function clickSubmit() {
    $.ajax({
        url: seajs.data.vars.clickButtonUrl,
        type: 'POST',
        //data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
        data:{action:'click_h',event_name:'TCOA_026'},
        dataType: 'json',
        async: true,  //同步发送请求t-mask
        beforeSend: function () {
        },
        success: function (result) {
        },
        error: function () {

        }
    });
}

function getPrice(obj) {
    layerMobile.lockup();
    var id = $(obj).data('code');
    if(commonUtil.isnull(id)!= true){
        layerMobile.unlock();
        layerMobile.showlayer('数据错误！');
        layerMobile.changeCssMsg2();
        return false;
    }
    $.ajax({
        url:seajs.data.vars.requestUrl,
        type:'POST',
        data:{id:id},
        dataType:'json',
        async: true,  //同步发送请求t-mask
        beforeSend:function(){
        },
        success:function(result){
            if(result.status == true){
                $('.bombbox2').show();
                $('.mask').show();
                layerMobile.unlock();
                $(obj).addClass('OA026-5-b');
                $(obj).text('已经领取');
                $(obj).attr('onclick','');
            }else{
                layerMobile.showlayer(result.msg);
                layerMobile.changeCssMsg2();
                layerMobile.unlock();
                return false;
            }
        },
        error:function(){
            layerMobile.unlock();
            layerMobile.showlayer('表单校验失败！');
            layerMobile.changeCssMsg2();
            return  false;
        }
    });

}
