/**
 * Created by liujinsheng on 16/9/8.
 */
define(function(require,exports,module){
    //require('/static/js/online/bank');
    require('/static/js/jquery-pie-loader');
    function animate(){
        $(".charts").each(function(i,item){
            var a=parseInt($(item).attr("w"));
            $(item).animate({
                width: a+"%"
            },2000);
        });
    }
    $(document).ready(function() {
        // if(seajs.data.vars.show==1) {
        //     var url = seajs.data.var.url;
        //     $('.t-red-company').click(function () {
        //         $.get(url, {}, function (data) {
        //             var json = eval('(' + data + ')');
        //             if (json.status) {
        //                 $('.t-error').text('');
        //                 $('.t-red-btn').addClass('t-gray-btn');
        //                 $('.t-red-btn').removeClass('t-red-btn');
        //             } else {
        //                 $('.t-error').text(json.msg);
        //             }
        //         });
        //     });
        // }
        $('*[data-behavior="pie-chart"]').each(function() {
            $(this).svgPie({percentage: seajs.data.vars.ensure_rate});
        });

    });
    
    if(seajs.data.vars.enable==1 && seajs.data.vars.have_credit==1){
        $('.t-red-company').click(function () {
            commonUtil.lockup();
            $.ajax({
                url:seajs.data.vars.url,
                type:'POST',
                data:{},
                dataType:'json',
                async: true,  //同步发送请求t-mask
                beforeSend:function(){
                },
                success:function(result){
                    if(result.status == true){
                        layer.close(load);
                        $('.t-mask').hide();
                        commonUtil.waring(result.msg);
                    }else{
                        commonUtil.unlock();
                        commonUtil.waring(result.msg);
                        return false;
                    }
                },
                error:function(){
                    commonUtil.unlock();
                    commonUtil.waring("表单校验失败");
                    return  false;
                }
            });
        });
    }

    if(seajs.data.vars.enable==1 && seajs.data.vars.have_credit == 0){
        $('.t-red-company').click(function () {
            //layer.msg('基础信息未完成,请下载APP');
            $('.t-mask').show();
            $('#t-bomb_box_card').show();
        });
    }
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
        }

    }
    
});