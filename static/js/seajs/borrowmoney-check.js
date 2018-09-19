/**
 * Created by liujinsheng on 16/9/8.
 */
define(function(require,exports,module){
    //require('/static/js/online/bank');
    $("#checkForm").submit(function(){
        var aggreement = $('#checkbox_a1').is(':checked');
        if(commonUtil.aggreement(aggreement)!=true){
            return false;
        }
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
        }
    }
    
});