var formarr={company:{10001:"公司名称不能为空",10002:"请输入有效的公司名称"},companydetail:{10001:"公司地址不能为空",10002:"请输入有效的公司地址"},family:{10001:"家庭住址不能为空",10002:"请输入有效的家庭住址"},contact:{10001:"名称不能为空",10002:"名称格式不对",10003:"手机号不能为空",10004:"手机号格式不对"},contact_people:{parent:"父母",brother:"兄弟姐妹",spouse:"配偶",children:"子女",colleague:"同事",classmate:"同学",friend:"朋友"},zname:{10001:"姓名不能为空",10002:"请输入有效的姓名"}};$("input[name='card_no']").blur(function(){commonUtil.card_no(this.value)}),$("input[name='name']").blur(function(){commonUtil.zname(this.value,"zname")}),$("input[name='identity_code']").blur(function(){commonUtil.code(this.value)}),$("input[name='authcode']").blur(function(){commonUtil.authcode(this.value)}),$(".t-re-bank").click(function(){$("#t-box_alert").show(),$(".t-mask").show()}),$(".t-bomb_close").click(function(){$("#t-box_alert").hide(),$(".t-mask").hide()}),$(".t-bomb_box-6 p").click(function(){name=$(this).attr("data"),id=$(this).attr("id"),checkedid=$('input:radio[name="bank_card_str"]:checked').attr("id"),$("#".checkedid).removeAttr("checked"),$("#checkbox_a1"+id).attr("checked","checked"),code=$(this).attr("code"),$(".t-re-bank p").text(name),$("input[name='bank_id']").val(id),$("input[name='bank_code']").val(code),$("#t-box_alert").hide(),$(".t-mask").hide(),$(".t-bomb_box-6 .agentment_i").removeClass("agentment_i"),$(this).children("label").addClass("agentment_i")}),$(".agreement label").click(function(){var t=$("#checkbox_a1").is(":checked");t?$(this).removeClass("agentment_i"):$(this).addClass("agentment_i")});var submit=0;$(".button_bank").click(function(){commonUtil.lockup();var t=$("input[name='bank_id']").val(),n=$("input[name='card_no']").val(),e=$("input[name='name']").val(),o=$("input[name='identity_code']").val(),a=$("#checkbox_a1").is(":checked");if(1!=commonUtil.bank(t))return commonUtil.unlock(),!1;if(1!=commonUtil.card_no(n))return commonUtil.unlock(),!1;if(1!=commonUtil.zname(e,"zname"))return commonUtil.unlock(),!1;if(1!=commonUtil.code(o))return commonUtil.unlock(),!1;if(1!=commonUtil.aggreement(a))return commonUtil.unlock(),!1;if(0==submit){submit=1,commonUtil.unlock(),commonUtil.tips(),$("#t-box_alert2").show(),$(".t-mask").show();var i=$("#t-bomb_box").height();$("#t-bomb_box").css({marginTop:-i/2});var m=10;return $(".btn-time").addClass("t-gray-btn"),$(".btn-time").attr("disabled",!0),$(".btn-time").removeClass("t-red-btn"),timer=setInterval(function(){m--,m>0?$(".btn-time").text("确定("+m+" s)"):(m=10,$(".btn-time").text("确定"),$(".btn-time").attr("href","javascript:commonUtilbank.submit();"),$(".btn-time").removeClass("t-gray-btn"),$(".btn-time").addClass("t-orange-btn"),clearInterval(timer))},1e3),!1}commonUtilbank.submit()});var commonUtilbank={submit:function(){commonUtil.lockup(),commonUtil.tips();var t=$("input[name='bank_id']").val(),n=$("input[name='card_no']").val(),e=$("input[name='name']").val(),o=$("input[name='identity_code']").val(),a=$("#checkbox_a1").is(":checked");return $("#t-bomb_box").hide(),1!=commonUtil.bank(t)?(commonUtil.unlock(),!1):1!=commonUtil.card_no(n)?(commonUtil.unlock(),!1):1!=commonUtil.zname(e,"zname")?(commonUtil.unlock(),!1):1!=commonUtil.code(o)?(commonUtil.unlock(),!1):1!=commonUtil.aggreement(a)?(commonUtil.unlock(),!1):($.ajax({url:seajs.data.vars.url,type:"POST",data:{bank:t,card_no:n,aggreement:a,name:e,identity_code:o},dataType:"json",async:!0,beforeSend:function(){},success:function(t){return 1!=t.status?(commonUtil.waring(t.msg),commonUtil.unlock(),!1):(location.href=seajs.data.vars.durl,void 0)},error:function(){return commonUtil.unlock(),commonUtil.tips("表单校验失败"),!1}}),void 0)}};