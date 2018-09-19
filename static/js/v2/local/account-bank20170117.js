(function($){
    $(function(){
        //银行卡号
        $("input[name='card_no']").blur(function(){
            commonUtil.card_no(this.value);
        });
        //银行点击显示
        $('.t-re-bank').click(function(){
            $('#t-box_alert').show();
            $('.t-mask').show();
        })
        //银行点击隐藏
        $('.t-bomb_close').click(function(){
            $('#t-box_alert').hide();
            $('.t-mask').hide();
        });
        // //点击银行的悬浮框  添加到页面银行
        // $('.t-bomb_box-6 p').click(function(){
        //     name = $(this).attr('data');
        //     id = $(this).attr('id');
        //     checkedid = $('input:radio[name="bank_card_str"]:checked').attr("id");
        //     $("#".checkedid).removeAttr("checked");
        //     $("#checkbox_a1"+id).attr("checked","checked");
        //     code = $(this).attr('code');
        //     $('.t-re-bank p').text(name);
        //     $("input[name='bank_id']").val(id);
        //     $("input[name='bank_code']").val(code);
        //     $('#t-box_alert').hide();
        //     $('.t-mask').hide();
        // })

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
            $('.t-bomb_box-6 .agentment_i').removeClass('agentment_i');
            $(this).children('label').addClass('agentment_i');
        });

        $('.agreement label').click(function(){
            var aggreement = $('#checkbox_a1').is(':checked');
            if(aggreement){
                $(this).removeClass('agentment_i');
            }else{
                $(this).addClass('agentment_i');
            }
        });


        //登录按钮提交
        $(".t-red-bank").click(function(){
            commonUtil.lockup();
            var bank=$("input[name='bank_id']").val();
            var card_no=$("input[name='card_no']").val();
            var newbank = $("input[name='new']").val();
            var aggreement = $('#checkbox_a1').is(':checked');
            if(commonUtil.bank(bank)!=true){
                commonUtil.unlock();
                return false;
            }
            if( commonUtil.card_no(card_no)!= true){
                commonUtil.unlock();
                return false;
            }
            if(commonUtil.aggreement(aggreement)!=true){
                commonUtil.unlock();
                return false;
            }
            $.ajax({
                url:seajs.data.vars.url,
                type:'POST',
                data:{bank:bank,card_no:card_no,aggreement:aggreement,upload:'upload',new:newbank},
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
                                $('.btn-time').attr('href','javascript:history.go(-1)');
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

})(jQuery);