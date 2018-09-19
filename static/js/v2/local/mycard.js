
var pageIndex = 0;
$(function(){

    $(".selected").click(function(){
        var id = $(this).data('id');
        $(".selected").removeClass("mycard_border_x");
        $(this).addClass('mycard_border_x');
        console.log(id);
    });

    $(".t-myselectcard-button").click(function(){
        var id = $(".mycard_border_x").data('id');
        if(commonUtil.isnull(id,'请选择快审卡') !=true){
            return false;
        }
        var price = $(".mycard_border_x").data('price');
        var num = $(".mycard_border_x").data('num');
        var name = $(".mycard_border_x").data('name');
        if(num<=0){
            commonUtil.waring('快审卡数量不足');
            return false;
        }
        if(commonUtil.isnull(price,'金钱异常') ==true && commonUtil.isnull(name,'名称异常') ==true ){
            commonUtil.lockup();
            location.href = seajs.data.vars.jumpUrl+'?id='+id+'&&price='+price+'&&num='+num+'&&name='+name;
        }else{
            layerMobile.showlayer('异常错误！');
            layerMobile.changeCssMsg();
            return false;
        }
    });

    $(".cardul li").click(function(){
        pageIndex = $(this).index();
        $('.cardul li').removeClass('fontcolor');
        $(this).addClass('fontcolor');
        $(".section").hide().eq(pageIndex).show();
        $(".pmore").hide().eq(pageIndex).show();
        console.log(pageIndex);
    });

})
    var times = 60;
    function submit() {
        commonUtil.lockup();
        var code = $("input[name='code']").val();
        if(commonUtil.isnull(code,'验证码不能为空！') !=true){
            commonUtil.unlock();
            return false;
        }
        var cp_id = $(".t-mycard-list-b").data('id');
        if(commonUtil.isnull(cp_id,'请选择快审卡') !=true){
            commonUtil.unlock();
            return false;
        }

        $.ajax({
            url:seajs.data.vars.submit,  //<?php echo URL::site('Functions/repayCode');?>
            type:'POST',
            data:{cp_id:cp_id,code:code},
            dataType:'json',
            async: true,  //同步发送请求
            success:function(result){
                commonUtil.unlock();
                if(result.status == true){
                    location.href = seajs.data.vars.jumpUrl;
                }else{
                    commonUtil.waring(result.msg);
                    return false;
                }
            },
            error:function(){
                commonUtil.unlock();
                commonUtil.waring("手机校验失败");
                $('.t-pwd-code').removeAttr('disabled');
                return true;
            }
        });

    }
    function codeRep() {
        commonUtil.lockup();
        var cp_id = $(".t-mycard-list-b").data('id');
        if(commonUtil.isnull(cp_id,'参数错误') !=true){
            commonUtil.unlock();
            return false;
        }
        timer = setInterval(function() {
            times--;
            if(times > 0) {
                $('.t-pwd-code').text(times +'秒后重发');
                $('.t-pwd-code').attr('disabled','disabled');
            } else {
                times = 60;
                $('.t-pwd-code').text('重发验证码');
                $('.t-pwd-code').removeAttr('disabled');
                clearInterval(timer);
            }
        }, 1000);
        $.ajax({
            url:seajs.data.vars.codeurl,  //<?php echo URL::site('Functions/repayCode');?>
            type:'POST',
            data:{cp_id:cp_id},
            dataType:'json',
            async: true,  //同步发送请求
            success:function(result){
                commonUtil.unlock();
                if(result.status == true){
                    //location.href = "/Repaymoney/repayStatus"
                }else{
                    clearInterval(timer);
                    $('.t-pwd-code').text('重发验证码');
                    commonUtil.waring(result.msg);
                    $('.t-pwd-code').removeAttr('disabled');
                    return false;
                }
            },
            error:function(){
                commonUtil.unlock();
                clearInterval(timer);
                commonUtil.waring("手机校验失败");
                $('.t-pwd-code').removeAttr('disabled');
                return true;
            }
        });
    }
    function getMore() {
        commonUtil.lockup();
        if(pageIndex==0){
            lastOrder = seajs.data.vars.orderIdA;
        }else if(pageIndex==1){
            lastOrder = seajs.data.vars.orderIdH;
        }
        if(commonUtil.isnull(lastOrder,'')==true){
            console.log(lastOrder);
            if(commonUtil.isnull(seajs.data.vars.url,'异常错误！')==true){
                $.ajax({
                    url:seajs.data.vars.url,  //<?php echo URL::site('Functions/repayCode');?>
                    type:'POST',
                    data:{pageIndex:pageIndex,lastId:lastOrder},
                    dataType:'json',
                    async: true,  //同步发送请求
                    success:function(data){
                        if (data.status == true) {
                            var arrText = [];
                            for (var i = 0, t; t = data.data[i++];) {
                                arrText.push("<section class='list-s'><div class='t-mycard-list' ><div  class='border-bottom list-top'><i style='background: '></i><strong>购买失败</strong></div><p class='t-select2'><label style='color: red'>249元</label><label style='float: right'>有效期至2018-12-12</label></p></div></section>");
                                // if(t.status == 2){
                                //     arrText.push("<a href='javascript:;' class='t-expire-tag t-tag-used'></a></div></div>");
                                // }else{
                                //     arrText.push("<a href='javascript:;' class='t-expire-tag'></a></div></div>");
                                // }
                            }
                            $('.Available').append(arrText.join(''));
                            if(data.id==0){
                                $(".pmore").eq(pageIndex).html('').hide().attr('onclick','');
                            }else{
                                if(pageIndex==0){
                                    seajs.data.vars.orderIdA = data.id;
                                }else if(pageIndex==1){
                                    seajs.data.vars.orderIdH = data.id;
                                }
                            }
                            console.log(data.id);
                        }

                        // commonUtil.unlock();
                        // clearInterval(timer);
                        // if(result.status == true){
                        //     //location.href = "/Repaymoney/repayStatus"
                        // }else{
                        //     commonUtil.waring(result.msg);
                        //     return false;
                        // }

                    },
                    error:function(){
                        commonUtil.unlock();
                        commonUtil.waring("手机校验失败");
                        return false;
                        // clearInterval(timer);
                        // commonUtil.waring("手机校验失败");
                        // $('.t-pwd-code').removeAttr('disabled');
                        // return true;
                        // console.log('wwwwwwwww');
                    }
                });
            }else{
                commonUtil.unlock();
                $(".pmore").eq(pageIndex).html('').hide().attr('onclick','');
            }
        }else{
            commonUtil.unlock();
            $(".pmore").eq(pageIndex).html('').hide().attr('onclick','');
        }


        // $('.Available').append("<section class=\"list-s\"><div class='t-mycard-list' ><div  class='border-bottom list-top'><i style=\"background: \"></i><strong>购买失败</strong></div><p class='t-select2'><label style='color: red'>249元</label><label style='float: right'>有效期至2018-12-12</label></p></div></section>");
    }
