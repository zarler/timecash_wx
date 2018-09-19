var $document   = $(document);
//显示弹层
$document.on('touched click', '#show-rules', function(e) {
    $("#t-box_alert").show();
    $(".t-mask").show();
});
//选项卡
$document.ready(function(){

    if(seajs.data.vars.bj){
        $('.nav-coupon span').removeClass('orange');
        $('.nav-coupon span').eq(1).addClass('orange');
        $(".section").hide().eq(1).show();
    }

    $(".nav-coupon span").click(function(){
        $('.nav-coupon span').removeClass('orange');
        $(this).addClass('orange');
        $(".section").hide().eq($(this).index()).show();
        //判断选择的标签
        if($(this).index() == 1){
            history.pushState({}, "", "bankCreditList?bj=credit");
        }else{
            history.pushState({}, "", "bankCreditList");
        }
    });
    $(".credit_delete").click(function(){
        commonUtil.lockup();
        var the = $(this);
        var vode_id = the.attr('data-bubble');
        if(commonUtil.isnull(vode_id)==false){
            commonUtil.unlock();
            return false;
        };
        $.ajax({
            url:seajs.data.vars.url,
            type:'POST',
            data:{id:vode_id},
            dataType:'json',
            async: true,  //同步发送请求t-mask
            beforeSend:function(){
            },
            success:function(result){
                if(result.status == true){
                    commonUtil.unlock();
                    commonUtil.tips();
                    the.parent().parent('.credit_delete_a').remove();
                    var lay = layer.alert('失效担保卡删除成功，如信用卡已续期再次添加即可使用', {
                        skin: 'layui-layer-molv' //样式类名
                        ,closeBtn: 0
                    }, function(){
                        layer.close(lay);
                    });
                    commonUtil.revisecss();
                }else{
                    commonUtil.waring(result.msg);
                    commonUtil.unlock();
                    return  false;
                }
            },
            error:function(){
                commonUtil.unlock();
                commonUtil.waring("表单发送失败！");
                return false;
            }
        });

    });
});


