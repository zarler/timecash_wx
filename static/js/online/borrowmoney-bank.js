var formarr={company:{10001:"公司名称不能为空",10002:"请输入有效的公司名称"},companydetail:{10001:"公司地址不能为空",10002:"请输入有效的公司地址"},family:{10001:"家庭住址不能为空",10002:"请输入有效的家庭住址"},contact:{10001:"名称不能为空",10002:"名称格式不对",10003:"手机号不能为空",10004:"手机号格式不对"},contact_people:{parent:"父母",brother:"兄弟姐妹",spouse:"配偶",children:"子女",colleague:"同事",classmate:"同学",friend:"朋友"},zname:{10001:"姓名不能为空",10002:"请输入有效的姓名"}};$("input[name='card_no']").blur(function(){commonUtil.card_no(this.value)}),$("input[name='name']").blur(function(){commonUtil.zname(this.value,"zname")}),$("input[name='identity_code']").blur(function(){commonUtil.code(this.value)}),$("input[name='authcode']").blur(function(){commonUtil.authcode(this.value)}),$(".t-re-bank").click(function(){$("#t-box_alert").show(),$(".t-mask").show()}),$(".t-bomb_close").click(function(){$("#t-box_alert").hide(),$(".t-mask").hide()}),$(".t-bomb_box-6 p").click(function(){name=$(this).attr("data"),id=$(this).attr("id"),checkedid=$('input:radio[name="bank_card_str"]:checked').attr("id"),$("#".checkedid).removeAttr("checked"),$("#checkbox_a1"+id).attr("checked","checked"),code=$(this).attr("code"),$(".t-re-bank p").text(name),$("input[name='bank_id']").val(id),$("input[name='bank_code']").val(code),$("#t-box_alert").hide(),$(".t-mask").hide()});var submit=0;$(".t-red-bank").click(function(){commonUtil.lockup();var t=$("input[name='bank_id']").val(),n=$("input[name='card_no']").val(),o=$("input[name='name']").val(),e=$("input[name='identity_code']").val(),a=$("#checkbox_a1").is(":checked");if(1!=commonUtil.bank(t))return commonUtil.unlock(),!1;if(1!=commonUtil.card_no(n))return commonUtil.unlock(),!1;if(1!=commonUtil.zname(o,"zname"))return commonUtil.unlock(),!1;if(1!=commonUtil.code(e))return commonUtil.unlock(),!1;if(1!=commonUtil.aggreement(a))return commonUtil.unlock(),!1;if(0==submit){submit=1,commonUtil.unlock(),commonUtil.tips(),$("#t-box_alert2").show(),$(".t-mask").show();var i=$("#t-bomb_box").height();$("#t-bomb_box").css({marginTop:-i/2});var m=10;return durl=seajs.data.vars.durl,$(".btn-time").addClass("t-gray-btn"),$(".btn-time").attr("disabled",!0),$(".btn-time").removeClass("t-red-btn"),timer=setInterval(function(){m--,m>0?$(".btn-time").text("确定("+m+" s)"):(m=10,$(".btn-time").text("确定"),$(".btn-time").attr("href","javascript:commonUtil.submit();"),$(".btn-time").removeClass("t-gray-btn"),$(".btn-time").addClass("t-red-btn"),clearInterval(timer))},1e3),!1}commonUtil.submit(),$.ajax({url:seajs.data.vars.url,type:"POST",data:{bank:t,card_no:n,aggreement:a,name:o,identity_code:e,authcode:authcode},dataType:"json",async:!0,beforeSend:function(){},success:function(t){if(1==t.status){commonUtil.unlock(),commonUtil.tips(),$("#t-box_alert2").show(),$(".t-mask").show();var n=$("#t-bomb_box").height();$("#t-bomb_box").css({marginTop:-n/2});var o=10;return durl=seajs.data.vars.durl,$(".btn-time").addClass("t-gray-btn"),$(".btn-time").attr("disabled",!0),$(".btn-time").removeClass("t-red-btn"),timer=setInterval(function(){o--,o>0?$(".btn-time").text("确定("+o+" s)"):(o=10,$(".btn-time").text("确定"),$(".btn-time").attr("href",durl),$(".btn-time").removeClass("t-gray-btn"),$(".btn-time").addClass("t-red-btn"),clearInterval(timer))},1e3),!1}return commonUtil.waring(t.msg),commonUtil.unlock(),!1},error:function(){return commonUtil.unlock(),commonUtil.tips("表单校验失败"),!1}})});var commonUtil={bank:function(t){return t=$.trim(t),""==t||null==t?(commonUtil.waring("请选择银行"),!1):(commonUtil.tips(),!0)},submit:function(){commonUtil.lockup(),commonUtil.tips();var t=$("input[name='bank_id']").val(),n=$("input[name='card_no']").val(),o=$("input[name='name']").val(),e=$("input[name='identity_code']").val(),a=$("#checkbox_a1").is(":checked");return $("#t-bomb_box").hide(),1!=commonUtil.bank(t)?(commonUtil.unlock(),!1):1!=commonUtil.card_no(n)?(commonUtil.unlock(),!1):1!=commonUtil.zname(o,"zname")?(commonUtil.unlock(),!1):1!=commonUtil.code(e)?(commonUtil.unlock(),!1):1!=commonUtil.aggreement(a)?(commonUtil.unlock(),!1):($.ajax({url:seajs.data.vars.url,type:"POST",data:{bank:t,card_no:n,aggreement:a,name:o,identity_code:e},dataType:"json",async:!0,beforeSend:function(){},success:function(t){return 1!=t.status?(commonUtil.waring(t.msg),commonUtil.unlock(),!1):(location.href=seajs.data.vars.durl,void 0)},error:function(){return commonUtil.unlock(),commonUtil.tips("表单校验失败"),!1}}),void 0)},aggreement:function(t){return t?(commonUtil.tips(),!0):(commonUtil.waring("请同意协议"),!1)},card_no:function(t){t=$.trim(t);var n=/^\d{16}|\d{17}|\d{18}|\d{19}$/;return""==t||null==t?(commonUtil.waring("银行卡号不能为空"),!1):t.match(n)?(commonUtil.tips(),!0):(commonUtil.waring("银行卡号格式不正确"),!1)},tips:function(){$(".t-error").text("")},waring:function(t){$(".t-error").text(t)},lockup:function(){$(".t-red-btn").addClass("t-gray-btn"),$(".t-red-btn").attr("disabled",!0),$(".t-red-btn").removeClass("t-red-btn"),load=layer.load(2,{shade:!1}),$(".t-mask").show()},unlock:function(){$(".t-gray-btn").addClass("t-red-btn"),$(".t-red-btn").attr("disabled",!1),$(".t-gray-btn").removeClass("t-gray-btn"),layer.close(load),$(".t-mask").hide()},zname:function(t,n){t=$.trim(t);var o=/^[\u4e00-\u9fa5]{2,10}(?:·[\u4E00-\u9FA5]{2,10})*$/;return""==t||null==t?(commonUtil.waring(formarr[n][10001]),!1):t.match(o)?(commonUtil.tips(),!0):(commonUtil.waring(formarr[n][10002]),!1)},code:function(t){t=$.trim(t);var n=/^(\d{17}X|\d{18})$/i;return""==t||null==t?(commonUtil.waring("身份证账号不能为空"),!1):t.match(n)?(commonUtil.tips(),!0):(commonUtil.waring("身份证账号格式错误"),!1)},authcode:function(t,n){if(t=$.trim(t),""==t||null==t)return 2==n?commonUtil.waring("请填写邮箱验证码"):3==n?commonUtil.waring("请填写验证码"):commonUtil.waring("请填写手机验证码"),!1;if(3==n){if(6!=t.length)return commonUtil.waring("验证码必须是六位整数"),!1}else if(4!=t.length)return 2==n?commonUtil.waring("请填写正确邮箱验证码"):commonUtil.waring("请填写正确手机验证码"),!1;return commonUtil.tips(),!0}};