/**
 * Created by liujinsheng on 16/9/8.
 */
$(function(){
    $('.cdefault').click(function(){
        $('.t-select-center').removeClass('t-select');
        $(this).addClass('t-select');
    })
})
$(".t-red-btn").click(function(){
    id = $('.t-select').attr('data');
    if(commonUtil.credit(id)!=true){
        return false;
    }
    $.ajax({
        url:seajs.data.vars.durl,
        type:'POST',
        data:{id:id},
        dataType:'json',
        async: true,  //同步发送请求t-mask
        beforeSend:function(){
            //$('.t-mask').show();
        },
        success:function(result){
            if(result.status === true){
                location.href = "/Borrowmoney/check";
            }else{
                commonUtil.waring(result.msg);
                return  false;
            }
        },
        error:function(){
            commonUtil.tips("表单校验失败");
            return false;
        }
    });
});
var commonUtil={
    credit:function(bank){
        bank=$.trim(bank);
        if(bank =="" || bank == null ) {
            commonUtil.waring('请选择信用卡');
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

    }
}