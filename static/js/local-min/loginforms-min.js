(function($){
    var formarr = {
        "company":{10001:"公司名称不能为空", 10002:"公司名称格式不对"},
        "contact":{10001:"名称不能为空",10002:"名称格式不对", 10003:"手机号不能为空",10004:"手机号格式不对"},
        "contact_people":{0:"请选择",1:"配偶", 2:"父母",3:"兄弟姐妹",4:"子女"},
        "zname":{10001:"真实名称不能为空",10002:"名称格式不对"},
    };
     $(function(){
         //输入框失去焦点x
         //text 和 password两种数据同步
         $(".pwdTip input").eq(0).blur(function(){
             $(".pwdTip input").eq(1).val($(this).val());
         });
         $(".pwdTip  input").eq(1).blur(function(){
             $(".pwdTip  input").eq(0).val($(this).val());
         });
         //判断用户名
         $("input[name='username']").blur(function(){
              commonUtil.username(this.value);
         });
		 //手机验证码
         $("input[name='authcode']").blur(function(){
              commonUtil.authcode(this.value);
         });
         //判断密码
         $("input[name='password']").blur(function(){
             commonUtil.pwd(this.value);
         });
         //判断重复密码
         $("input[name='passwordrepeat']").blur(function(){
             commonUtil.pwd(this.value,1);
         });

         //手机号码判断
         $("input[name='phone']").blur(function(){
              commonUtil.phone(this.value);
         });
		 //真实姓名判断
         $("input[name='zname']").blur(function(){
              commonUtil.zname(this.value,'zname');
         });
		//身份账号判断
         $("input[name='code']").blur(function(){
              commonUtil.code(this.value);
         });
         //公司名称
         $("input[name='comname']").blur(function(){
             commonUtil.zname(this.value,'company');
         });
         //公司联系电话
         $("input[name='comtell']").blur(function(){
             commonUtil.tell(this.value);
         });
         //公司联系电话
         $("input[name='email']").blur(function(){
             commonUtil.email(this.value);
         });
         //公司联系电话
         $("input[name='verification ']").blur(function(){
             commonUtil.isnull(this.value,'公司联系电话不能为空');
         });
         //联系人名称
         $("input[name='connamef']").blur(function(){
             commonUtil.zname(this.value,'contact');
         });
         $("input[name='connames']").blur(function(){
             commonUtil.zname(this.value,'contact');
         });

         $("input[name='comtellf']").blur(function(){
             commonUtil.phone(this.value);
         });
         $("input[name='comtells']").blur(function(){
             commonUtil.phone(this.value);
         });


         //点击查看密码
		 /*
         $(".wap2-eye").click(function(){
             var rel= $.trim($(".wap2-eye").attr("class"));
            // alert(rel);
                if(rel=='wap2-eye'){
                    $(".wap2-eye").addClass('open');
                    $("#password").hide();
                    $("#showPwd").show();

                }else{
                    $(".wap2-eye").removeClass('open');
                    $(".wap2-eye").attr('type','password');
                    $("#password").show();
                    $("#showPwd").hide();
                }
         });
		*/
         //登录按钮提交
         $(".t-login-button").click(function(){
             commonUtil.lockup();
             var phone=$("input[name='phone']").val();
             var password=$("input[name='password']").val();
             if(commonUtil.phone(phone) !=true){
                 commonUtil.unlock();
                 return false;
             }
             if( commonUtil.pwd(password) != true){
                 commonUtil.unlock();
                return false;
             }
             $.ajax({
                 url:dologinurl,
                 type:'POST',
                 data:{phone:phone,password:password},
                 dataType:'json',
                 async: true,  //同步发送请求t-mask
                 beforeSend:function(){

                 },
                 success:function(result){
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
         $(".t-red-register").click(function(){
             commonUtil.lockup();
             var phone=$("input[name='phone']").val();
             var password=$("input[name='password']").val();
             // var code=$("input[name='code']").val(); 
             // var zname=$("input[name='zname']").val(); 
             var authcode=$("input[name='authcode']").val();
             var invitecode=$("input[name='invitecode']").val();
			 var aggreement = $('#checkbox_a1').is(':checked');
             // var latitude=$("input[name='latitude']").val()?$("input[name='latitude']").val():null;
             // var longitude=$("input[name='longitude']").val()?$("input[name='longitude']").val():null;
             if(commonUtil.phone(phone)!=true) {
                 commonUtil.unlock();
                 return false;
             }
			 if(commonUtil.aggreement(aggreement)!=true){
                 commonUtil.unlock();
				return false;
			 }
             if(commonUtil.pwd(password)!=true){
                 commonUtil.unlock();
                return false;
             }
             // if(commonUtil.zname(zname,'zname')!=true){
             //     commonUtil.unlock();
             //     return false;
             // }
             // if(commonUtil.code(code)!=true){
             //     commonUtil.unlock();
             //     return false;
             // }
			 if(commonUtil.authcode(authcode)!=true){
                 commonUtil.unlock();
                 return false;
             }
             if(!commonUtil.isnull()){
                 if(commonUtil.is_number(invitecode,'邀请码格式错误')!=true){
                     commonUtil.unlock();
                     return false;
                 }
             }
			 $.ajax({
                    url:registerurl,
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
			var phone=$("input[name='phone']").val();
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
				url:sendcodeurl,
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
             var phone=$("input[name='phone']").val();
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
                 url:dobackpwdurl,
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
             $.ajax({
                 url:resetpwdurl,
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
                         $('#t-box_alert').css('display','block');
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
    var commonUtil={
        username:function(username){
                   username=$.trim(username);
                  var pattern = /^(13\d|14[57]|15[012356789]|18\d|17[013678])\d{8}$/;
                   if(username =="" || username == null ) {
                      commonUtil.waring('请输入手机号/用户名');
                       return false;
                   }
                   if(!username.match(pattern)) {
                       commonUtil.waring('用户名是手机号');
                         return false;
                    }
                    commonUtil.tips();
                    return true;
             },
        isnull:function(code,msg){
            var code  = $.trim(code);
            if(code == '') {
                commonUtil.waring(msg);
                return false;
            }
            commonUtil.tips();
            return true;
        },
        tell:function(tell){
            var tell  = $.trim(tell);
            var pattern = /^(0[0-9]{2,3}\-)?([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/;
            if(tell == '') {
                commonUtil.waring('请输入号码');
                return false;
            }
            if(!tell.match(pattern)) {
                commonUtil.waring('号码格式不正确，请重新输入');
                return false;
            }
            commonUtil.tips();
            return true;
        },
        email:function(email){
            var email  = $.trim(email);
            var pattern = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
            if(email == '') {
                commonUtil.waring('请输入邮箱');
                return false;
            }
            if(!email.match(pattern)) {
                commonUtil.waring('邮箱格式不正确，请重新输入');
                return false;
            }
            commonUtil.tips();
            return true;
        },
        is_number:function(number,msg){
            var number  = $.trim(number);
            var pattern = /^[0-9]{0,10}$/;
            if(!number.match(pattern)) {
                commonUtil.waring(msg);
                return false;
            }
            commonUtil.tips();
            return true;
        },
        phone:function(phone){
            var phone  = $.trim(phone);
            var pattern = /^(13\d|14[57]|15[012356789]|18\d|17[031678])\d{8}$/;
            var unique ='';
            if(phone == '') {
                commonUtil.waring('请输入手机号码');
                return false;
            }
            if(!phone.match(pattern)) {
                commonUtil.waring('手机号码格式不正确，请重新输入');
                return false;
            }
            commonUtil.tips();
            return true;
            //}else{
				//$.ajax({
				//	url:nameunique,
				//	type:'POST',
				//	data:{phone:phone,type:'mobile'},
				//	dataType:'json',
				//	async: false,  //同步发送请求
				//	success:function(result){
				//		unique=result.status;//alert(unique);
				//	},
				//	error:function(){
				//		commonUtil.tips("手机校验失败");
				//		return true;
				//	}
				//});
				//
            //    if(unique===false) {
            //        commonUtil.waring("手机号已经注册");
            //        return false;
            //    } else {
            //        commonUtil.tips();
            //        return true;
            //    }
            //}
        },
		aggreement:function(aggreement){
                  if(aggreement){
					commonUtil.tips();
                    return true;
				  }else{
					commonUtil.waring('请同意协议');
                    return false;
				  }
             },
		//真实姓名
		zname:function(zname,type){
			zname=$.trim(zname);
		    var pattern = /^[\u4e00-\u9fa5]{2,5}(?:·[\u4E00-\u9FA5]{2,5})*$/;
		    if(zname =="" || zname == null ) {
			  commonUtil.waring(formarr[type][10001]);
			   return false;
		    }
		    if(!zname.match(pattern)) {
                commonUtil.waring(formarr[type][10002]);
				 return false;
			}
			commonUtil.tips();
			return true;
		},
		authcode:function(authcode){			
			authcode=$.trim(authcode);

		    if(authcode =="" || authcode == null ) {
			  commonUtil.waring('请填写手机验证码');
			   return false;
		    }
		    if(authcode.length!=4) {
			   commonUtil.waring('请填写正确手机验证码');
				return false;
			}
			commonUtil.tips();
			return true;
		},
		//身份证账号
		code:function(code){			
			code=$.trim(code);
		    var pattern = /^(\d{17}X|\d{18})$/i;
		        if(code =="" || code == null ) {
			  commonUtil.waring('身份证账号不能为空');
			   return false;
		    }
		    if(!code.match(pattern)) {
			   commonUtil.waring('身份证账号格式错误');
				 return false;
			}
			commonUtil.tips();
			return true;
		},
        pwd:function(password,rep){
            if(rep == 1){
                password=$.trim(password);
                var pattern = /^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;//[0-9a-zA-Z]{6,16}
                if(password == '') {
                    commonUtil.waring('密码不能为空');
                    return false;
                }
                if(!password.match(pattern)){
                    commonUtil.waring('登录密码（6-16位字母数字组合）');
                    return false;
                }
                if(password.length<6 || password.length>16){
                    commonUtil.waring('密码位数不正确');
                    return false;
                }
                if(password != $("input[name='password']").val()){
                    commonUtil.waring('两次密码不相同！');
                    return false;
                }
                commonUtil.tips();
                return true;
            }else{
                password=$.trim(password);
                var pattern = /^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;//[0-9a-zA-Z]{6,16}
                if(password == '') {
                    commonUtil.waring('密码不能为空');
                    return false;
                }
                if(!password.match(pattern)){
                    commonUtil.waring('登录密码（6-16位字母数字组合）');
                    return false;
                }
                if(password.length<6 || password.length>16){
                    commonUtil.waring('密码位数不正确');
                    return false;
                }
                commonUtil.tips();
                return true;
            }

        },
        tips:function(){
            $(".t-error").text('');
        },
        waring:function(msg){
            $(".t-error").text(msg);

         },
        lockup:function(){
            $('.t-red-btn').addClass('t-gray-btn');
            $(".t-red-btn").attr('disabled',true);
            $('.t-red-btn').removeClass('t-red-btn');
            load = layer.load(2, {shade: false});
            $('.t-mask').show();
        },
        unlock:function(){
            $('.t-gray-btn').addClass('t-red-btn');
            $(".t-red-btn").attr('disabled',false);
            $('.t-gray-btn').removeClass('t-gray-btn');
            layer.close(load);
            $('.t-mask').hide();
        }

    }

})(jQuery);