/**
 * Created by liujinsheng on 16/9/8.
 */
$(function(){
    $('.cdefault').click(function(){
        $('.t-select-center').removeClass('t-select');
        $(this).addClass('t-select');
    });
    $(".t-guarantee-list").click(function(){
        id = $(this).attr('data');
        if(commonUtil.is_number(id,'异常错误')!=true){
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
})
