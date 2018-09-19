/**
 * Created by liujinsheng on 16/9/8.
 */
    $('.t-login-footer label').click(function(){
        var aggreement = $('#checkbox_a1').is(':checked');
        if(aggreement){
            $(this).removeClass('agentment_i');
        }else{
            $(this).addClass('agentment_i');
        }
    });
    //require('/static/js/online/bank');
    $(".button_submit").click(function(){
        commonUtil.lockup();
        var aggreement = $('#checkbox_a1').is(':checked');
        if(commonUtil.aggreement(aggreement)!=true){
            commonUtil.unlock();
            return false;
        }
        $.ajax({
            url:seajs.data.vars.url,
            type:'POST',
            // data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
            data:{aggreement:aggreement},
            dataType:'json',
            async: true,  //同步发送请求t-mask
            beforeSend:function(){
            },
            success:function(result){
                // setTimeout(function(){
                if(result.status == true){
                    commonUtil.unlock();
                    commonUtil.tips();
                    if(commonUtil.isnull(result.jump)==true&&result.jump==1){
                        // location.href = '/APIPay_LianLian/Index';
                        if(commonUtil.isnull(result.jump)==true){
                            $('body').html(result.html);
                            $('#pay_form').submit();
                        }else{
                            location.href = "/User/describe?jump=index";
                        }
                    }else{
                        location.href = "/User/describe?jump=index";
                    }
                }else{
                    commonUtil.errorCode(result.code,result.msg);
                    return  false;
                }
                // }, 3000);
                return false;
            },
            error:function(){
                commonUtil.unlock();
                commonUtil.waring("表单发送失败！");
                return false;
            }
        });
    });
