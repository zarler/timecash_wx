var $document=$(document);$document.on("touched click","#show-rules",function(){$("#t-box_alert").show(),$(".t-mask").show()}),$document.ready(function(){seajs.data.vars.bj&&($(".nav-coupon span").removeClass("orange"),$(".nav-coupon span").eq(1).addClass("orange"),$(".section").hide().eq(1).show()),$(".nav-coupon span").click(function(){$(".nav-coupon span").removeClass("orange"),$(this).addClass("orange"),$(".section").hide().eq($(this).index()).show(),1==$(this).index()?history.pushState({},"","bankCreditList?bj=credit"):history.pushState({},"","bankCreditList")}),$(".credit_delete").click(function(){commonUtil.lockup();var o=$(this),n=o.attr("data-bubble");return 0==commonUtil.isnull(n)?(commonUtil.unlock(),!1):($.ajax({url:seajs.data.vars.url,type:"POST",data:{id:n},dataType:"json",async:!0,beforeSend:function(){},success:function(n){if(1!=n.status)return commonUtil.waring(n.msg),commonUtil.unlock(),!1;commonUtil.unlock(),commonUtil.tips(),o.parent().parent(".credit_delete_a").remove();var t=layer.alert("失效担保卡删除成功，如信用卡已续期再次添加即可使用",{skin:"layui-layer-molv",closeBtn:0},function(){layer.close(t)});commonUtil.revisecss()},error:function(){return commonUtil.unlock(),commonUtil.waring("表单发送失败！"),!1}}),void 0)})});