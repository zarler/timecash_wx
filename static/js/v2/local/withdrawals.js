$(document).ready(function() {


});
function submit() {
    var money = $("input[name='money']").val();
    if(layerMobile.isnull(money)==false){
        layerMobile.showlayer('金额不能为空！');
        layerMobile.changeCssMsg2();
        return false;
    }



    layerMobile.lockup();
    $.ajax({
        url:seajs.data.vars.reqUrl,  //<?php echo URL::site('Functions/repayCode');?>
        type:'POST',
        data:{money:money},
        dataType:'json',
        async: true,  //同步发送请求
        success:function(result){
            layerMobile.unlock();
            if(result.status == true){
                layerMobile.showlayer('提现成功');
                layerMobile.changeCssMsg2();
                location.href = seajs.data.vars.jumpUrl;
            }else{
                layerMobile.showlayer(result.msg);
                layerMobile.changeCssMsg2();
                return false;
            }
        },
        error:function(){
            layerMobile.unlock();
            layerMobile.showlayer('校验失败！');
            layerMobile.changeCssMsg2();
            return false;
        }
    });
}