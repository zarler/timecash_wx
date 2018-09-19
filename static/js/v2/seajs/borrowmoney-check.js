/**
 * Created by liujinsheng on 16/9/8.
 */
define(function(require,exports,module){
    //require('/static/js/online/bank');
    var submitOk = 2;
    $("#checkForm").submit(function(){
        var aggreement = $('#checkbox_a1').is(':checked');
        if(commonUtil.aggreement(aggreement)!=true){
            return false;
        }
        if(submitOk==2){
            layer.confirm('若放弃支付,订单将为"预授权确定中"状态,1小时候订单将自动关闭,您可重新进行操作。', {
                btn: ['确定','取消'] //按钮
            }, function(index){
                submitOk = 1;
                $("#checkForm").submit();
            }, function(index){
                submitOk = 2;
                layer.close(index);
            });
        }
        $('.layui-layer-dialog').css({'left':'5%','right':'5%'});
        if(submitOk==1){
            return true;
        }else{
            return false;
        }
    });
    $('.t-login-footer label').click(function(){
        var aggreement = $('#checkbox_a1').is(':checked');
        if(aggreement){
            $(this).removeClass('agentment_i');
        }else{
            $(this).addClass('agentment_i');
        }
    });
});