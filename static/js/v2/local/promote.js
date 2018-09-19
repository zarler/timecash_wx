
    function animate(){
        $(".charts").each(function(i,item){
            var a=parseInt($(item).attr("w"));
            $(item).animate({
                width: a+"%"
            },2000);
        });
    }
    $(document).ready(function() {
        $('*[data-behavior="pie-chart"]').each(function() {
            $(this).svgPie({percentage: seajs.data.vars.ensure_rate});
        });
        if(seajs.data.vars.enable==1 && seajs.data.vars.have_credit==1){
            $('.t-red-company').click(function () {
                commonUtil.lockup();
                $.ajax({
                    url:seajs.data.vars.url,
                    type:'POST',
                    data:{hehe:1},
                    dataType:'json',
                    async: true,  //同步发送请求t-mask
                    beforeSend:function(){
                    },
                    success:function(result){
                        if(result.status == true){
                            layer.close(load);
                            $(".t-red-company").unbind();
                            $('.t-mask').hide();
                            $('.c-credit-promote-p').text('申请审核中');
                            $('.promote_p').removeClass('t-red-company').addClass('promote_p_c');
                            commonUtil.showmsg(result.msg);
                        }else{
                            commonUtil.unlock();
                            commonUtil.showmsg(result.msg);
                            return false;
                        }
                    },
                    error:function(){
                        commonUtil.unlock();
                        commonUtil.showmsg("表单校验失败");
                        return  false;
                    }
                });
            });
        }
        
    });
    

    function nobasecreadit() {
        //layer.msg('基础信息未完成,请下载APP');
        $('.t-mask').show();
        $('#t-bomb_box_prompt').show();
    };
    function prompt_hide(){
        $('.t-mask').hide();
        $('#t-bomb_box_prompt').hide();
        $('#t-bomb_box_card').hide();
    }