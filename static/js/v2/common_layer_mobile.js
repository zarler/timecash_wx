var layerMobile = {
    showlayer:function (msg) {
        layer.open({
            content: msg
            ,skin: 'msg'
            ,time:2  //2秒后自动关闭
        });
    },
    //提示闪框
    changeCssMsg:function () {
        $('.layui-m-layermain .layui-m-layersection').css({'vertical-align':'bottom'});
        $('.layui-m-layer-msg').css({'margin':'.3rem auto .5rem auto'});
        $('.layui-m-layercont').css({'text-align':'center','font-size':'0.75rem','padding':'.22rem .7rem'});

    },
    changeCssMsg2:function () {
        $('.layui-m-layermain .layui-m-layersection').css({'vertical-align':'bottom'});
        $('.layui-m-layer-msg').css({'margin':'.3rem auto .5rem auto'});
        $('.layui-m-layercont').css({'text-align':'center','font-size':'0.39rem','padding':'0.12rem 0.7rem'});

    },

    changeCssPromptMsg:function () {
        $('.layui-m-layer-msg').css({'margin':'.3rem auto .5rem auto'});
        $('.layui-m-layercont').css({'color':'black','font-size':'0.35rem'});
        $('.layui-m-layerbtn span[no]').css({'color':'black'});

        // $('.layui-m-layerbtn span').css({'color':'black'});
    },
    //活动
    changeCssPromptMsgAtc:function () {
        $('.layui-m-layer0 .layui-m-layerchild').css({'max-width':'10rem'});
        $('.layui-m-layerbtn').css({'height':'1.5rem','line-height':'1.5rem'});
        $('.layui-m-layerbtn span').css({'font-size':'.6rem'});
        $('.layui-m-layercont').css({'height':'2rem','font-size':'0.6rem'});
        $('.layui-m-layerbtn span[no]').css({'color':'black'});
        // $('.layui-m-layerbtn span').css({'color':'black'});
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
    submitUrl:function (msg,url) {
        layer.open({
            content: msg
            ,shadeClose : false
            ,btn: ['确定', '取消']
            ,yes: function(index){
                location.href = url;
                layer.close(index);
            }
        });
    },
    submitUrlSelect:function (msg,submsg,url) {
        layer.open({
            content: msg
            ,shadeClose : false
            ,btn: [submsg, '取消']
            ,yes: function(index){
                location.href = url;
                layer.close(index);
            }
        });
    },
    submitOk:function (msg) {
        layer.open({
            content: msg
            ,shadeClose: false
            ,btn: ['确定']
            ,yes: function(index){
                layer.close(index);
            }
        });
    },
    submitEdit:function (msg,btn,url) {
        layer.open({
            content: msg
            ,btn: [btn]
            ,yes: function(index){
                location.href = url;
            }
        });
    },
    //正数
    is_number:function(number,msg){
        var number  = $.trim(number);
        var pattern = /^[0-9]{0,10}$/;
        if(!number.match(pattern)) {
            commonUtil.waring(msg);
            return false;
        }
        commonUtil.tips();
        return true;
    },
    isnull:function(code,msg){
        var code  = $.trim(code);
        if(code == "" || code == undefined || code == null || code == 0 ) {
            return false;
        }
        return true;
    },
//    加载
    lockup:function(){
        load =  layer.open({type: 2});
    },
    unlock:function(){
        layer.close(load);
    },
}