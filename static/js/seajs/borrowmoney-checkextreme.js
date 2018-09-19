/**
 * Created by liujinsheng on 16/9/8.
 */
define(function(require,exports,module){
    //require('/static/js/online/bank');
    $(".t-red-btn").click(function(){
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
                setTimeout(function(){
                    if(result.status == true){
                        commonUtil.unlock();
                        commonUtil.tips();
                        location.href = "/User/describe";
                    }else{
                        commonUtil.errorCode(result.code,result.msg);
                        return  false;
                    }
                }, 3000);
                return false;
            },
            error:function(){
                commonUtil.unlock();
                commonUtil.waring("表单发送失败！");
                return false;
            }
        });
    });
    var commonUtil={
        aggreement:function(aggreement){
            if(aggreement){
                commonUtil.tips();
                return true;
            }else{
                commonUtil.waring('请同意协议');
                return false;
            }
        },
        tips:function(){
            $(".t-error").text('');
        },
        waring:function(msg){
            $(".t-error").text(msg);
        },
        errorCode:function (code,msg) {
            switch (code){
                case '4005':
                case '5072':
                case '5113':
                case '5060':
                case '4012':
                case '4000':
                case '2000':
                case '2001':
                case '2010':
                case '2011':
                case '2012':
                case '2002':
                case '2005':
                case '2003':
                case '2022':
                case '5014':
                case '5013':
                case '4008':
                case '4009':
                case '5012':
                case '5066':
                case '5065':
                case '5064':
                case '5003':
                case '5116':
                    location.href = '/Error?code='+code;
                    break;
                case '5103':
                case '5123':
                    location.href = '/Error?code='+code;
                    break;
                default:
                    commonUtil.waring(msg);
                    commonUtil.unlock();
                    break;
            }
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