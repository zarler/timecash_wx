function indexLogin(){$(".index_login").show(),$(".index_register").hide(),$(".t-error").text("")}function indexRegister(){$(".index_register").show(),$(".index_login").hide(),$(".t-error").text("")}$(function(){$("input[name='password']").blur(function(){commonUtil.pwd(this.value)}),$("input[name='phone']").blur(function(){commonUtil.phone(this.value)}),$("input[name='reg_phone']").blur(function(){commonUtil.phone(this.value)}),$("input[name='reg_password']").blur(function(){commonUtil.pwd(this.value)}),$("input[name='reg_authcode']").blur(function(){commonUtil.authcode(this.value)}),$(".t-login-button").click(function(){commonUtil.lockup();var o=$("input[name='phone']").val(),n=$("input[name='password']").val();return 1!=commonUtil.phone(o)?(commonUtil.unlock(),!1):1!=commonUtil.pwd(n)?(commonUtil.unlock(),!1):($.ajax({url:seajs.data.vars.dologinurl,type:"POST",data:{phone:o,password:n},dataType:"json",async:!0,beforeSend:function(){},success:function(o){return o.status!==!0?(commonUtil.waring(o.msg),commonUtil.unlock(),!1):(commonUtil.unlock(),commonUtil.tips(),location.href=seajs.data.vars.jumpUrl,void 0)},error:function(){return commonUtil.unlock(),commonUtil.tips("表单发送失败！"),!1}}),void 0)}),$(".quit").click(function(){$.ajax({url:dooutloginurl,type:"POST",data:"",dataType:"json",async:!1,beforeSend:function(){commonUtil.lockup()},success:function(o){o.status===!0?(commonUtil.unlock(),commonUtil.tips()):(commonUtil.waring(o.msg),commonUtil.unlock())},error:function(){commonUtil.unlock(),commonUtil.tips("网络错误！")}})}),$(".t-login-footer label").click(function(){var o=$("#checkbox_a1").is(":checked");o?$(this).removeClass("agentment_i"):$(this).addClass("agentment_i")}),$(".invitation").click(function(){$(".invitationcode").is(":hidden")?($(".down").addClass("up"),$(".down").removeClass("down")):($(".up").addClass("down"),$(".up").removeClass("up"),$("input[name='invitecode']").val("")),$(".invitationcode").slideToggle("slow")}),$(".t-register-button").click(function(){commonUtil.lockup();var o=$("input[name='reg_phone']").val(),n=$("input[name='reg_authcode']").val(),t=$("input[name='reg_password']").val(),i=$("input[name='reg_invitecode']").val(),e=$("#checkbox_a1").is(":checked");return 1!=commonUtil.phone(o)?(commonUtil.unlock(),!1):1!=commonUtil.authcode(n)?(commonUtil.unlock(),!1):1!=commonUtil.pwd(t)?(commonUtil.unlock(),!1):commonUtil.isnull()||1==commonUtil.is_number(i,"邀请码格式错误")?1!=commonUtil.aggreement(e)?(commonUtil.unlock(),!1):($.ajax({url:seajs.data.vars.registerurl,type:"POST",data:{phone:o,password:t,authcode:n,aggreement:e,invitecode:i},dataType:"json",async:!0,beforeSend:function(){},success:function(o){return 1!=o.status?(commonUtil.waring(o.msg),commonUtil.unlock(),!1):(commonUtil.unlock(),commonUtil.tips(),location.href="/",void 0)},error:function(){return commonUtil.unlock(),commonUtil.waring("表单校验失败"),!1}}),void 0):(commonUtil.unlock(),!1)});var o=60;$(".t-pwd-code").click(function(){var n=$("input[name='reg_phone']").val();return 1!=commonUtil.phone(n)?!1:(timer=setInterval(function(){o--,o>0?($(".t-pwd-code").text(o+"秒后重发"),$(".t-pwd-code").attr("disabled","disabled"),$(".t-pwd-code").addClass("t-gray")):($(".t-pwd-code").text("重发验证码"),$(".t-pwd-code").removeAttr("disabled"),$(".t-pwd-code").removeClass("t-gray"),clearInterval(timer))},1e3),$.ajax({url:seajs.data.vars.sendcodeurl,type:"POST",data:{phone:n},dataType:"json",async:!0,success:function(o){return 1==o.status?(commonUtil.tips(),!0):(commonUtil.waring(o.msg),$(".t-pwd-code").text("重发验证码"),$(".t-pwd-code").removeAttr("disabled"),clearInterval(timer),!1)},error:function(){return commonUtil.waring("手机校验失败"),$(".t-pwd-code").text("重发验证码"),$(".t-pwd-code").removeAttr("disabled"),clearInterval(timer),!1}}),void 0)}),$(".button_backpwd").click(function(){commonUtil.lockup();var o=$("input[name='reg_phone']").val(),n=$("input[name='authcode']").val();return 1!=commonUtil.phone(o)?(commonUtil.unlock(),!1):1!=commonUtil.authcode(n)?(commonUtil.unlock(),!1):($.ajax({url:seajs.data.vars.dobackpwdurl,type:"POST",data:{phone:o,authcode:n},dataType:"json",async:!0,beforeSend:function(){},success:function(o){return commonUtil.unlock(),1==o.status?(location.href="/Login/ResetPwd",commonUtil.unlock(),commonUtil.tips(),!0):(commonUtil.waring(o.msg),commonUtil.unlock(),!1)},error:function(){return commonUtil.unlock(),commonUtil.tips("网络错误！"),!1}}),void 0)}),$(".resetpwd_submit").click(function(){commonUtil.lockup();var o=$("input[name='password']").val(),n=$("input[name='passwordrepeat']").val();return 1!=commonUtil.pwd(o)?(commonUtil.unlock(),!1):1!=commonUtil.pwd(n,1)?(commonUtil.unlock(),!1):o!=n?(commonUtil.unlock(),commonUtil.waring("两次密码输入不同"),!1):($.ajax({url:seajs.data.vars.resetpwdurl,type:"POST",data:{password:o,passwordrepeat:n},dataType:"json",async:!1,beforeSend:function(){},success:function(o){return o.status===!0?(commonUtil.unlock(),commonUtil.tips(),prompt_show(),!0):(commonUtil.waring(o.msg),commonUtil.unlock(),!1)},error:function(){return commonUtil.unlock(),commonUtil.tips("网络错误！"),!1}}),void 0)}),$("#companyForm").submit(function(){return alert(a.comname["10001"]),!1})}),seajs.data.vars.bj&&($(".section").hide(),$(".section").hide().eq(1).show(),$(".icon_sanjiao img").removeClass("left_icon").addClass("right_icon")),$(".t-login-top a").click(function(){$(".section").hide().eq($(this).index()).show(),1==$(this).index()?$(".icon_sanjiao img").removeClass("left_icon").addClass("right_icon"):$(".icon_sanjiao img").removeClass("right_icon").addClass("left_icon"),1==$(this).index()?history.pushState({},"","Login?bj=register"):history.pushState({},"","Login")});