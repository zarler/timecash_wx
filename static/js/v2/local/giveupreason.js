(function($){
    $(function() {
       //提交按钮
        $('.giveupreason_ul li').click(function (){
            if($(this).hasClass('on')){
                $(this).removeClass('on');
            }else{
                $(this).addClass('on');
            }
        });

        $('.submitButton').click(function(){

            commonUtil.lockup();
            var mycars = new Array()
            $.each($('.on'),function(){
                mycars.push($(this).data('code'));
            });
            if(mycars.length == 0){
                commonUtil.unlock();
                layerPhone.BombBox('放弃原因不能为空');layerPhone.changeCssBombBox();
                return false;
            }
            var textmsg = $('.gr-tx').val();
            if(commonUtil.isnull(textmsg)==false){
                commonUtil.unlock();
                layerPhone.BombBox('意见建议不能为空！');layerPhone.changeCssBombBox();
                return false;
            }

            $.ajax({
                url:seajs.data.vars.reqUrl,
                type:'POST',
                data:{gut_id:mycars,msg:textmsg},
                dataType:'json',
                async: true,  //同步发送请求
                beforeSend: function(xhr){
                    xhr.setRequestHeader('app-info', seajs.data.vars.seajsVer);
                    // response.addHeader("Set-Cookie","token=" + seajs.data.vars.token);
                },//这里设置header
                success:function(result){
                    if(result.code==1000){
                        layerPhone.Inquiryok('提交成功！','确定返回',seajs.data.vars.jumpUrl);
                        layerPhone.changeCssInquiry();
                    }else{
                        commonUtil.unlock();
                        layerPhone.BombBox(result.message);layerPhone.changeCssBombBox();
                    }
                },
                // error:function(XMLHttpRequest, textStatus, errorThrown){
                error:function(){
                //     $('.div1').text(JSON.stringify(XMLHttpRequest));
                //     $('.div2').text(XMLHttpRequest.readyState);
                //     $('.div3').text(textStatus);
                    commonUtil.unlock();
                    layerPhone.BombBox('请求错误！');layerPhone.changeCssBombBox();
                }
            });

        });

    })

})(jQuery);