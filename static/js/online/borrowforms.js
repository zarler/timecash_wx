function borrowClick(){return commonUtil.lockup(),money=$("input[name='money']").val(),day=$("input[name='day']").val(),poundage=$("input[name='poundage']").val(),ensure_rate_bu=$("input[name=ensure_rate][checked]").val(),latitude=$("input[name='latitude']").val(),longitude=$("input[name='longitude']").val(),$(".t-check-btn").hasClass("t-check-btn-active")?(coupinid=$(".t-check-btn-active").parent().parent(".t-coupon-card").attr("id"),offset=$(".t-check-btn-active").parent().parent(".t-coupon-card").attr("data")):(coupinid=null,offset=null),ensure_rate>ensure_rate_bu||ensure_rate_bu>100?(commonUtil.waring("担保比例异常！"),commonUtil.unlock(),!1):1!=commonUtil.isnull(latitude,"获取地址失败,请重新提交")?(commonUtil.unlock(),!1):1!=commonUtil.isnull(longitude,"获取地址失败,请重新提交")?(commonUtil.unlock(),!1):($.ajax({url:borrowurl,type:"POST",data:{money:money,day:day,coupinid:coupinid,offset:offset,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},dataType:"json",async:!0,beforeSend:function(){},success:function(t){return 1!=t.status?(commonUtil.waring(t.msg),commonUtil.unlock(),!1):(commonUtil.unlock(),commonUtil.tips(),location.href="/Borrowmoney/bankinfo",void 0)},error:function(){return commonUtil.unlock(),commonUtil.waring("表单发送失败！"),!1}}),void 0)}var submitNum=0;$("input[name='card_no']").blur(function(){commonUtil.card_no(this.value)}),$(".t-re-bank").click(function(){$("#t-box_alert").show(),$(".t-mask").show()}),$(".t-bomb_close").click(function(){$("#t-box_alert").hide(),$(".t-mask").hide()}),$(".t-bomb_box-6 p").click(function(){name=$(this).attr("data"),id=$(this).attr("id"),checkedid=$('input:radio[name="bank_card_str"]:checked').attr("id"),$("#".checkedid).removeAttr("checked"),$("#checkbox_a1"+id).attr("checked","checked"),code=$(this).attr("code"),$(".t-re-bank p").text(name),$("input[name='bank_id']").val(id),$("input[name='bank_code']").val(code),$("#t-box_alert").hide(),$(".t-mask").hide()}),$(".t-red-btn-but").click(function(){1==submitNum?borrowClick():submitNum=1});var commonUtil={username:function(t,n){t=$.trim(t);var o=/^(13\d|14[57]|15[012356789]|18\d|17[01678])\d{8}$/;if(""==t||null==t)return commonUtil.waring("请输入手机号/用户名"),!1;if(2==n);else if(!t.match(o))return commonUtil.waring("用户名是手机号"),!1;return commonUtil.tips(),!0},isnull:function(t,n){var t=$.trim(t);return""==t||void 0==t||null==t||0==t?(commonUtil.waring(n),!1):(commonUtil.tips(),!0)},tell:function(t,n){var t=$.trim(t),o=/(\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$/;return""==t?(2==n?commonUtil.waring("请输入公司联系电话"):commonUtil.waring("请输入联系电话"),!1):t.match(o)?(commonUtil.tips(),!0):(2==n?commonUtil.waring("联系电话号码格式不正确，请重新输入"):commonUtil.waring("号码格式不正确，请重新输入"),!1)},email:function(t){var t=$.trim(t),n=/^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;return""==t?(commonUtil.waring("请输入邮箱"),!1):t.match(n)?(commonUtil.tips(),!0):(commonUtil.waring("邮箱格式不正确，请重新输入"),!1)},phone:function(t){var t=$.trim(t),n=/^(13\d|14[57]|15[012356789]|18\d|17[01678])\d{8}$/;return""==t?(commonUtil.waring("请输入手机号码"),!1):t.match(n)?(commonUtil.tips(),!0):(commonUtil.waring("手机号码格式不正确，请重新输入"),!1)},passphone:function(t,n){var o=/^(\d{6})$/i;return t.match(o)?(commonUtil.tips(),!0):(commonUtil.waring(n),!1)},aggreement:function(t){return t?(commonUtil.tips(),!0):(commonUtil.waring("请同意协议"),!1)},zname:function(t,n){t=$.trim(t);var o=/^[\u4e00-\u9fa5]{2,10}(?:·[\u4E00-\u9FA5]{2,10})*$/;return""==t||null==t?(commonUtil.waring(formarr[n][10001]),!1):t.match(o)?(commonUtil.tips(),!0):(commonUtil.waring(formarr[n][10002]),!1)},authcode:function(t,n){if(t=$.trim(t),""==t||null==t)return 2==n?commonUtil.waring("请填写邮箱验证码"):3==n?commonUtil.waring("请填写验证码"):commonUtil.waring("请填写手机验证码"),!1;if(3==n){if(6!=t.length)return commonUtil.waring("验证码必须是六位整数"),!1}else if(4!=t.length)return 2==n?commonUtil.waring("请填写正确邮箱验证码"):commonUtil.waring("请填写正确手机验证码"),!1;return commonUtil.tips(),!0},code:function(t){t=$.trim(t);var n=/^(\d{17}X|\d{18})$/i;return""==t||null==t?(commonUtil.waring("身份证账号不能为空"),!1):t.match(n)?(commonUtil.tips(),!0):(commonUtil.waring("身份证账号格式错误"),!1)},pwd:function(t,n){if(1==n){t=$.trim(t);var o=/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;return""==t?(commonUtil.waring("密码不能为空"),!1):t.match(o)?6>t.length||t.length>16?(commonUtil.waring("密码位数不正确"),!1):t!=$("input[name='password']").val()?(commonUtil.waring("两次密码不相同！"),!1):(commonUtil.tips(),!0):(commonUtil.waring("登录密码（6-16位字母数字组合）"),!1)}t=$.trim(t);var o=/^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;return""==t?(commonUtil.waring("密码不能为空"),!1):t.match(o)?6>t.length||t.length>16?(commonUtil.waring("密码位数不正确"),!1):(commonUtil.tips(),!0):(commonUtil.waring("登录密码（6-16位字母数字组合）"),!1)},tips:function(){$(".t-error").text("")},waring:function(t){$(".t-error").text(t)},lockup:function(){$(".t-red-btn").addClass("t-gray-btn"),$(".t-red-btn").attr("disabled",!0),$(".t-red-btn").removeClass("t-red-btn"),load=layer.load(2,{shade:!1}),$(".t-mask").show()},unlock:function(){$(".t-gray-btn").addClass("t-red-btn"),$(".t-red-btn").attr("disabled",!1),$(".t-gray-btn").removeClass("t-gray-btn"),layer.close(load),$(".t-mask").hide()}};