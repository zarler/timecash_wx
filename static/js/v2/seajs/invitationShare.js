/**
 * Created by liujinsheng on 16/9/7.
 */
define(function(require,exports,module){
    //轮播图
    //require('js/slider');
    //弹框跳出
    require('ui_bootstrap/bomb/bomb_screen');
    // require('js/v2/local/peoplepull');
    require('css/v2/local/peoplepullInvitationShare.css');

    $(document).ready(function(){
        bomob_screen.firstready();
        $('#bomb_screen').on('click',function () {
            bomob_screen.bomobremove();
        });
        $('.leftspan').click(function(){
            $('.fontcolor').removeClass('fontcolor');
            $(this).addClass('fontcolor');
            $('.right-div').hide();
            $('.left-div').show();
        });
        $('.rightspan').click(function(){
            $('.fontcolor').removeClass('fontcolor');
            $(this).addClass('fontcolor');
            $('.left-div').hide();
            $('.right-div').show();
        });
        if(seajs.data.vars.islogin==1){
                var wx = require('https://res.wx.qq.com/open/js/jweixin-1.0.0.js?123');
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
                        },
                        cancel:function(){
                            // 用户取消分享后执行的回调函数
                        }
                    });
                });
                function sendToAndroid(){
                    $('#fullbg').show();
                }
                function shareAjax() {
                    $.ajax({
                        url:'/FunctionsApp/shareWx',
                        type:'POST',
                        data:{action:'show',event_name:'TCOA_006'},
                        dataType:'json',
                        async: true,
                        beforeSend:function(){
                        },
                        success:function(result){
                        },
                        error:function(){
                        }
                    });
                }
        }
    });
});
