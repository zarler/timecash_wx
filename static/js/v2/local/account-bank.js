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
                        if(commonUtil.isnull(result.jump)==true&&result.jump==1){
                            // location.href = '/APIPay_LianLian/Index';
                            if(commonUtil.isnull(result.jump)==true){
                                $('body').html(result.html);
                                $('#pay_form').submit();
                            }else{
                                location.href = '/Account/bankCreditList';
                            }
                        }else{
                            location.href = '/Account/bankCreditList';
                        }
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
    
})(jQuery);