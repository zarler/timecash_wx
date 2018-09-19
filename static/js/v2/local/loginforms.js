
     $(function(){
         //判断密码
         $("input[name='password']").blur(function(){
             commonUtil.pwd(this.value);
         });
         //手机号码判断
         $("input[name='phone']").blur(function(){
              commonUtil.phone(this.value);
         });
         //注册手机号码判断
         $("input[name='reg_phone']").blur(function(){
             commonUtil.phone(this.value);
         });
         //注册判断密码
         $("input[name='reg_password']").blur(function(){
             commonUtil.pwd(this.value);
         });
         //手机验证码
         $("input[name='reg_authcode']").blur(function(){
             commonUtil.authcode(this.value);
         });
         //登录按钮提交
         $(".t-login-button").click(function(){
             commonUtil.lockup();
             var phone=$("input[name='phone']").val();
             var password=$("input[name='password']").val();
             if(commonUtil.phone(phone) !=true){
                 commonUtil.unlock();
                 return false;
             }
             if(commonUtil.pwd(password) != true){
                 commonUtil.unlock();
                return false;
             }
             $.ajax({
                 url:seajs.data.vars.dologinurl,
                 type:'POST',
                 data:{phone:phone,password:password},
                 dataType:'json',
                 async: true,  //同步发送请求t-mask
                 beforeSend:function(){

                 },
                 success:function(result){

                     console.log(result.status);
                     console.log(result.msg);


                     if(result.status === true){
                         commonUtil.unlock();
                         commonUtil.tips();
                         location.href = seajs.data.vars.jumpUrl;
                     }else{
                         commonUtil.waring(result.msg);
                         commonUtil.unlock();
                         return false;
                     }
                 },
                 error:function(){
                     commonUtil.unlock();
                     commonUtil.tips("表单发送失败！");
                     return false;
                 }
             });
         });

         $(".quit").click(function(){
             $.ajax({
                 url:dooutloginurl,
                 type:'POST',
                 data:'',
                 dataType:'json',
                 async: false,  //同步发送请求t-mask
                 beforeSend:function(){
                     commonUtil.lockup();
                 },
                 success:function(result){
                     if(result.status === true){
                         commonUtil.unlock();
                         commonUtil.tips();
                     }else{
                         commonUtil.waring(result.msg);
                         commonUtil.unlock();
                     }
                 },
                 error:function(){
                     commonUtil.unlock();
                     commonUtil.tips("网络错误！");
                 }
             });
         });
         $('.t-login-footer label').click(function(){
             var aggreement = $('#checkbox_a1').is(':checked');
             if(aggreement){
                 $(this).removeClass('agentment_i');
             }else{
                 $(this).addClass('agentment_i');
             }
         });
         //邀请码收缩
         $('.invitation').click(function () {
             if($(".invitationcode").is(":hidden")){
                 $(".down").addClass('up');    //如果元素为隐藏,则将它显现
                 $(".down").removeClass('down');
             }else{
                 $(".up").addClass('down');    //如果元素为隐藏,则将它显现
                 $(".up").removeClass('up');
                 $("input[name='invitecode']").val('');
                 //$(".invitationcode").hide();     //如果元素为显现,则将其隐藏
             }
             $(".invitationcode").slideToggle("slow");
         });
         //注册按钮
         $(".t-register-button").click(function(){
             commonUtil.lockup();
             var phone=$("input[name='reg_phone']").val();
             var authcode=$("input[name='reg_authcode']").val();
             var password=$("input[name='reg_password']").val();
             var invitecode=$("input[name='reg_invitecode']").val();
			 var aggreement = $('#checkbox_a1').is(':checked');
             if(commonUtil.phone(phone)!=true) {
                 commonUtil.unlock();
                 return false;
             }
             if(commonUtil.authcode(authcode)!=true){
                 commonUtil.unlock();
                 return false;
             }
             if(commonUtil.pwd(password)!=true){
                 commonUtil.unlock();
                return false;
             }
             if(!commonUtil.isnull()){
                 if(commonUtil.is_number(invitecode,'邀请码格式错误')!=true){
                     commonUtil.unlock();
                     return false;
                 }
             }
             if(commonUtil.aggreement(aggreement)!=true){
                 commonUtil.unlock();
                 return false;
             }
			 $.ajax({
                    url:seajs.data.vars.registerurl,
                    type:'POST',
                    data:{phone:phone,password:password,authcode:authcode,aggreement:aggreement,invitecode:invitecode},
                    // data:{phone:phone,password:password,code:code,zname:zname,authcode:authcode,aggreement:aggreement,latitude:latitude,longitude:longitude},
                    dataType:'json',
                    async: true,  //同步发送请求t-mask
                    beforeSend:function(){
                    },
                    success:function(result){
                        if(result.status == true){
                            commonUtil.unlock();
                            commonUtil.tips();
                            location.href = "/";
                        }else{
                            commonUtil.waring(result.msg);
                            commonUtil.unlock();
                            return  false;
                        }
                    },
                    error:function(){
                        commonUtil.unlock();
                        commonUtil.waring("表单校验失败");
                        return  false;
                    }
                });
         });
		//点击获取手机验证码
		var times = 60;
		$('.t-pwd-code').click(function(){
			var phone=$("input[name='reg_phone']").val();
			if(commonUtil.phone(phone)!=true) {
                 return false;
            }
			timer = setInterval(function() {
				times--;
				if(times > 0) {
					$('.t-pwd-code').text(times +'秒后重发');
					$('.t-pwd-code').attr('disabled','disabled');
					$('.t-pwd-code').addClass('t-gray');
				} else {
					times >= 60;
					$('.t-pwd-code').text('重发验证码');
					$('.t-pwd-code').removeAttr('disabled');
                    $('.t-pwd-code').removeClass('t-gray');
					clearInterval(timer);
				}
			}, 1000);
			$.ajax({
				url:seajs.data.vars.sendcodeurl,
				type:'POST',
				data:{phone:phone},
				dataType:'json',
				async: true,  //同步发送请求
				success:function(result){
					if(result.status==true){
                        commonUtil.tips();
                        return true;
					}else{
                        commonUtil.waring(result.msg);
                        $('.t-pwd-code').text('重发验证码');
                        $('.t-pwd-code').removeAttr('disabled');
                        clearInterval(timer);
                        return false;
					}
				},
				error:function(){
					commonUtil.waring("手机校验失败");
                    $('.t-pwd-code').text('重发验证码');
					$('.t-pwd-code').removeAttr('disabled');
                    clearInterval(timer);
					return false;
				}
			});
									
		});
         //找回密码
         $('.button_backpwd').click(function(){
             commonUtil.lockup();
             var phone=$("input[name='reg_phone']").val();
             var authcode=$("input[name='authcode']").val();
             //var token=$("input[name='token']").val();
             if(commonUtil.phone(phone)!=true) {
                 commonUtil.unlock();
                 return false;
             }
             if(commonUtil.authcode(authcode)!=true){
                 commonUtil.unlock();
                 return false;
             }
             $.ajax({
                 url:seajs.data.vars.dobackpwdurl,
                 type:'POST',
                 data:{phone:phone,authcode:authcode},
                 dataType:'json',
                 async: true,  //同步发送请求t-mask
                 beforeSend:function(){

                 },
                 success:function(result){
                     commonUtil.unlock();
                     if(result.status == true){
                         location.href = "/Login/ResetPwd";
                         commonUtil.unlock();
                         commonUtil.tips();
                         return  true;
                     }else{
                         commonUtil.waring(result.msg);
                         commonUtil.unlock();
                         return  false;
                     }
                 },
                 error:function(){
                     commonUtil.unlock();
                     commonUtil.tips("网络错误！");
                     return false;
                 }
             });
         });
         //重置密码
         $('.resetpwd_submit').click(function(){
             commonUtil.lockup();
             var password = $("input[name='password']").val();
             var passwordrepeat = $("input[name='passwordrepeat']").val();
             if(commonUtil.pwd(password)!=true){
                 commonUtil.unlock();
                 return false;
             }
             if(commonUtil.pwd(passwordrepeat,1)!=true){
                 commonUtil.unlock();
                 return false;
             }

             if(password!=passwordrepeat){
                 commonUtil.unlock();
                 commonUtil.waring('两次密码输入不同');
                 return false;
             }

             $.ajax({
                 url:seajs.data.vars.resetpwdurl,
                 type:'POST',
                 data:{password:password,passwordrepeat:passwordrepeat},
                 dataType:'json',
                 async: false,  //同步发送请求t-mask
                 beforeSend:function(){

                 },
                 success:function(result){
                     if(result.status === true){
                         commonUtil.unlock();
                         commonUtil.tips();
                         prompt_show();
                         return true;
                     }else{
                         commonUtil.waring(result.msg);
                         commonUtil.unlock();
                         return false;
                     }
                 },
                 error:function(){
                     commonUtil.unlock();
                     commonUtil.tips("网络错误！");
                     return false;
                 }
             });
         });
        //公司注册
         $('#companyForm').submit(function(){
             alert(a['comname']['10001']);
             return false;
         });
     });

 if(seajs.data.vars.bj){
     $(".section").hide();
     $(".section").hide().eq(1).show();
     $('.icon_sanjiao img').removeClass('left_icon').addClass('right_icon');

 }


$('.t-login-top a').click(function () {
    $(".section").hide().eq($(this).index()).show();
    if($(this).index() == 1){
        $('.icon_sanjiao img').removeClass('left_icon').addClass('right_icon');
    }else{
        $('.icon_sanjiao img').removeClass('right_icon').addClass('left_icon');
    }
    //判断选择的标签
    if($(this).index() == 1){
        history.pushState({}, "", "Login?bj=register");
    }else{
        history.pushState({}, "", "Login");
    }
});


function indexLogin(){
    $('.index_login').show();
    $('.index_register').hide();
    $('.t-error').text('');
}
function indexRegister(){
    $('.index_register').show();
    $('.index_login').hide();
    $('.t-error').text('');
}
