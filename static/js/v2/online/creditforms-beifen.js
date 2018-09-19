(function($){
    var formarr = {
        "company":{10001:"公司名称不能为空", 10002:"请输入有效的公司名称"},
        "companydetail":{10001:"公司地址不能为空", 10002:"请输入有效的公司地址"},
        "family":{10001:"家庭住址不能为空", 10002:"请输入有效的家庭住址"},
        "contact":{10001:"名称不能为空",10002:"名称格式不对", 10003:"手机号不能为空",10004:"手机号格式不对"},
        "contact_people":{'parent':"父母",'brother':"兄弟姐妹",'spouse':"配偶",'children':"子女",'colleague':"同事",'classmate':"同学",'friend':"朋友"},
        "zname":{10001:"姓名不能为空",10002:"请输入有效的姓名"},
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
         //授信账号（淘宝，京东）
         $("input[name='usernamec']").blur(function(){
             commonUtil.username(this.value,2);
         });
		 //手机验证码
         $("input[name='authcode']").blur(function(){
              commonUtil.authcode(this.value);
         });
         //移动验证码
         $("input[name='comauthcode']").blur(function(){
             commonUtil.authcode(this.value,3);
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
         //运营商密码
         $("input[name='passphone']").blur(function(){
             commonUtil.passphone(this.value);
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
             commonUtil.details_four(this.value,'company');
         });
         //公司联系电话
         $("input[name='comtell']").blur(function(){
             commonUtil.tell(this.value,2);
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
         $("input[name='comdetailaddre']").blur(function(){
             commonUtil.details_two(this.value,'companydetail');
         });
         $("input[name='detailaddress']").blur(function(){
             commonUtil.details_two(this.value,'family');
         });

         $("input[name='dynamiccode']").blur(function(){
             commonUtil.dynamiccode(this.value);
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
         var times = 60;
		//点击获取公司邮箱验证码
		$('.t-pwd-code').click(function(){
			var email = $("input[name='email']").val();
			if(commonUtil.email(email)!=true) {
                 return false;
            }
            timer();
			$.ajax({
				url:sendcodeurl,
				type:'POST',
				data:{email:email},
				dataType:'json',
				async: false,  //同步发送请求
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
					commonUtil.waring("网络异常！");
                    $('.t-pwd-code').text('重发验证码');
					$('.t-pwd-code').removeAttr('disabled');
                    clearInterval(timer);
					return true;
				}
			});
		});
         //公司信息注册
         $(".t-red-company").click(function(){
             commonUtil.lockup();
             var comname = $("input[name='comname']").val();
             //var comaddress = $("input[name='comaddress']").val();
             var comaddress_province1 = $("#province1").val();
             var comaddress_city1 = $("#city1").val();
             var comaddress_district1 = $("#district1").val();
             var comaddress = comaddress_province1+','+comaddress_city1+','+comaddress_district1;
             var comdetailaddre=$("input[name='comdetailaddre']").val();
             var comtell=$("input[name='comtell']").val();
             if(commonUtil.details_four(comname,'company')!=true) {
                 commonUtil.unlock();
                 return false;
             }
             if(commonUtil.isnull(comaddress,'公司地址不能为空')!=true) {
                 commonUtil.unlock();
                 return false;
             }
             if(commonUtil.details_two(comdetailaddre,'companydetail')!=true) {
                 commonUtil.unlock();
                 return false;
             }
             if(commonUtil.tell(comtell,2)!=true) {
                 commonUtil.unlock();
                 return false;
             }
             $.ajax({
                 url:companyinfourl,
                 type:'POST',
                 data:{comname:comname,comaddress:comaddress,comdetailaddre:comdetailaddre,comtell:comtell},
                 //data:{comname:comname,comaddress:comaddress,comdetailaddre:comdetailaddre,comtell:comtell,address:address,detailaddress:detailaddress,numbertell:numbertell},
                 dataType:'json',
                 async: true,  //同步发送请求t-mask
                 beforeSend:function(){
                 },
                 success:function(result){
                     if(result.status == true){
                         commonUtil.unlock();
                         commonUtil.tips();
                         location.href = "/RegisterApp/Contacts"
                     }else{
                         alert(result.msg);
                         commonUtil.waring(result.msg);
                         commonUtil.unlock();
                         return  false;
                     }
                 },
                 error:function(){
                     commonUtil.unlock();
                     commonUtil.tips("表单校验失败");
                     return false;
                 }
             });
         });
            //紧急联系人
         $('#contactForm').submit(function(){
             commonUtil.lockup();
             var a = $(this).serializeArray();
             var post_data = '';
             $.each(a, function(key,val) {
                 switch (this.name){
                     case 'conname':
                         if(commonUtil.zname(this.value, 'zname') != true) {
                             element = false;
                         }else{
                             element = true;
                         }
                         break;
                 case 'contact':
                     if(commonUtil.isnull(this.value, '请选择您与紧急联系人的关系') != true) {
                         element = false;
                     }else{
                         element = true;
                     }
                 break;
                 case 'ccomtell':
                         if(commonUtil.phone(this.value) != true) {
                             element = false;
                         }else{
                             element = true;
                         }
                         break;
                     default:
                         element = false;
                         break
                 }
                 if(element == false){
                     return false;
                 }else{
                     switch(key){
                         case 0:case 1:case 2:
                         post_data += "&"+this.name+'1='+this.value;
                         break;
                         case 3:case 4:case 5:
                         post_data += "&"+this.name+'2='+this.value;
                         break;
                     }
                 }

             });
             if(element == false){
                 commonUtil.unlock();
                 return false;
             }
             $.ajax({
                 url:contactsourl,
                 type:'POST',
                 data:post_data,
                 dataType:'json',
                 async: false,  //同步发送请求t-mask
                 beforeSend:function(){

                 },
                 success:function(result){
                     if(result.status === true){
                         unique=result.status; //alert(unique);
                         commonUtil.unlock();
                         commonUtil.tips();
                         unique =  true;
                     }else{
                         commonUtil.waring(result.msg);
                         commonUtil.unlock();
                         unique =  false;
                     }
                 },
                 error:function(){
                     commonUtil.unlock();
                     commonUtil.tips("表单校验失败");
                     unique = false;
                 }
             });
             if(unique==true){
                 location.href = Jumpourl;
                 return false;
                 //return true;
             }else{
                 return false;
             }
         });
         $("#contact-select1").change(function(){
             if( this.value == 'spouse'){
                 var str = '<option value="0" selected="selected">请选择</option>';
                 $.each(formarr['contact_people'], function(i,val){
                     if(i != 'spouse'){
                         str += '<option value='+i+'>'+val+'</option>';
                     }
                 });
                 $("#contact-select2").html(str);
             }
         });
         $("#contact-select2").change(function(){
             if( this.value == 'spouse'){
                 var str = '<option value="0" selected="selected">请选择</option>';
                 $.each(formarr['contact_people'], function(i,val){
                     if(i != 'spouse'){
                         str += '<option value='+i+'>'+val+'</option>';
                     }
                 });
                 $("#contact-select1").html(str);
             }
         });
         $('.t-button').click(function(){
                 commonUtil.lockup_credit('正在读取数据,请等待1-2分钟');
                 var type=$("input[name='type']").val();
                 var search_password = null;
                 if(commonUtil.isnull(type,'异常错误请刷新')!=true){
                     commonUtil.unlock();
                     return false;
                 }

                 if(type=='sj'){
                     var phone=$("input[name='phone']").val();
                     var passphone=$("input[name='passphone']").val();
                     if($('.iconcode').data('code')==1){
                         if(commonUtil.is_searchcode(passphone,'')!=true) {
                             commonUtil.unlock();
                             return false;
                         }
                         search_password = $("input[name='search_password']").val();
                         if(commonUtil.isnull(search_password,'服务密码不能为空')==true){
                             if(commonUtil.passphone(search_password,'服务密码必须是6-8位整数')!=true){
                                 commonUtil.unlock();
                                 return false;
                             }
                         }else{
                             commonUtil.unlock();
                             return false;
                         }
                     }else{
                         if(commonUtil.passphone(passphone,'服务密码必须是6-8位整数')!=true) {
                             commonUtil.unlock();
                             return false;
                         }
                     }
                 }else{
                     var usernamec=$("input[name='usernamec']").val();
                     var password=$("input[name='password']").val();
                     if(commonUtil.isnull(usernamec,'账号不能为空！')!=true) {
                         commonUtil.unlock();
                         return false;
                     }
                     if(commonUtil.pwd(password)!=true){
                         commonUtil.unlock();
                         return false;
                     }
                     //京东动态验证码（坑）
                     if(commonUtil.dynamiccode(dynamiccode)!=true){
                         commonUtil.unlock();
                         return false;
                     }
                 }

                 if(sendtime!=0){
                     var dynamiccode = $("input[name='dynamiccode']").val()?$("input[name='dynamiccode']").val():null;
                     if(commonUtil.isnull(dynamiccode,'动态验证码不能为空')==true){
                         if(commonUtil.is_number(dynamiccode)!=true){
                             commonUtil.unlock();
                             return false;
                         }
                     }else{
                         commonUtil.unlock();
                         return false;
                     }
                 }

                
                 if(type=='sj'){
                     if(sendtime == 0){
                         url = creditzhurl;
                     }else if(sendtime == 1){
                         url = dynamicVerifyurl;
                     }else{
                         url = dynamicVerifyurl;
                         // commonUtil.waring("异常错误！");
                         // return false;
                     }
                     post_data="&phone="+phone+"&passphone="+passphone+"&dynamiccode="+dynamiccode+"&type="+type+"&search_password="+search_password;
                     //post_data="&phone="+phone+"&passphone="+passphone+"&type="+type;
                 }else{
                     url = creditzhurl;
                     //post_data="&usernamec="+usernamec+"&password="+password+"&type="+type;
                     post_data="&usernamec="+usernamec+"&password="+password+"&type="+type+"&dynamiccode="+dynamiccode;
                 }
                 $.ajax({
                     url:url,
                     type:'POST',
                     data:post_data,
                     dataType:'json',
                     async: true,  //同步发送请求t-mask
                     beforeSend:function(){
                     },
                     success:function(result){
                         if(result.status == true){
                             commonUtil.unlock();
                             commonUtil.tips();
                             if(type=='sj'){
                                 location.href = "/RegisterApp/CreditAccounts";
                             }else{
                                 location.href = "/RegisterApp/CreditAccounts";
                             }
                         }else{
                             //京东动态验证码
                             if(result.code == 5106){
                                 sendtime = 1;
                                 commonUtil.is_time(times);
                                 commonUtil.unlock();
                                 $('.dynamiccode').show();
                                 commonUtil.waring(result.msg);
                                 return false;
                             }
                             if(result.code == 5080){
                                 location.href = "/RegisterApp/CreditAccounts";
                             }
                             if(result.code == 5084){
                                 commonUtil.unlock();
                                 $('.t-mask').show();
                                 $('#t-bomb_box').show();
                                 $('#t-bomb_box-6').text(result.msg);
                                 return false;
                             }
                            if(result.code == 10002){
                                commonUtil.unlock();
                                commonUtil.waring(result.msg);
                                return false;
                            }else{
                                commonUtil.unlock();
                                commonUtil.waring(result.msg);
                                return false;
                            }
                         }
                     },
                     error:function(){
                         commonUtil.unlock();
                         commonUtil.tips("表单校验失败");
                         return false;
                     }
                 });
             //if(unique==true){
             //    commonUtil.unlock();
             //    return true;
             //}else{
             //    commonUtil.unlock();
             //    return false;
             //}
         });
         //获取移动验证码
         $('.t-pwd-code1').click(function(){
             commonUtil.lockup_credit('正在获取验证码,请等待1-2分钟');
             var type=$("input[name='type']").val();
             var search_password = null;
             if(commonUtil.isnull(type,'异常错误请刷新')!=true){
                 commonUtil.unlock();
                 return false;
             }
             var comtimes = 60;
             var phone = $("input[name='phone']").val();
             var passphone = $("input[name='passphone']").val();
             if(commonUtil.phone(phone)!=true) {
                 commonUtil.unlock();
                 return false;
             }

             if($('.iconcode').data('code')==1){
                 if(commonUtil.is_searchcode(passphone,'')!=true) {
                     commonUtil.unlock();
                     return false;
                 }
                 search_password = $("input[name='search_password']").val();
                 if(commonUtil.isnull(search_password,'')==true){
                     if(commonUtil.passphone(search_password,'服务密码必须是6-8位整数')!=true){
                         commonUtil.unlock();
                         return false;
                     }
                 }
             }else{
                 if(commonUtil.passphone(passphone,'服务密码必须是6-8位整数')!=true) {
                     commonUtil.unlock();
                     return false;
                 }
             }

             if(sendtime == 0){
                 url = creditzhurl;
                 post_data="&phone="+phone+"&passphone="+passphone+"&type="+type+"&search_password="+search_password;
             }else if(sendtime == 1){
                 url = dynamicSendurl;
                 post_data="&mobile="+phone+"&passphone="+passphone+"&search_password="+search_password;
             }else{
                 url = dynamicSendurl;
                 post_data="&mobile="+phone+"&passphone="+passphone+"&search_password="+search_password;
                 // commonUtil.waring("异常错误！");
                 // return false;
             }
             $.ajax({
                 url:url,
                 type:'POST',
                 data:post_data,
                 dataType:'json',
                 async: true,  //同步发送请求
                 success:function(result){
                     if(result.status==true){
                         commonUtil.unlock();
                         commonUtil.tips();
                         sendtime = 1;
                         commonUtil.is_time(times);
                         return true;
                     }else{
                         if(result.code == 5080){
                             location.href = "/RegisterApp/Sesamecredit";
                         }else{
                             commonUtil.unlock();
                             commonUtil.waring(result.msg);
                             $('.t-pwd-code1').text('重发验证码');
                             $('.t-pwd-code1').removeAttr('disabled');
                             //clearInterval(timer);
                             return false;
                         }

                     }
                 },
                 error:function(){
                     commonUtil.unlock();
                     commonUtil.waring("网络异常！");
                     $('.t-pwd-code1').text('重发验证码');
                     $('.t-pwd-code1').removeAttr('disabled');
                     //clearInterval(timer);
                     return true;
                 }
             });
         });
     });
    var commonUtil={
        username:function(username,type){
            username=$.trim(username);
            var pattern = /^(13\d|14[57]|15[012356789]|18\d|17[01678])\d{8}$/;
            if(username =="" || username == null ) {
                commonUtil.waring('请输入手机号/用户名');
                return false;
            }
            if(type==2){

            }else{
                if(!username.match(pattern)) {
                    commonUtil.waring('用户名是手机号');
                    return false;
                }
            }
            commonUtil.tips();
            return true;
        },
        isnull:function(code,msg){
            var code  = $.trim(code);
            if(code == "" || code == undefined || code == null || code == 0 ) {
                commonUtil.waring(msg);
                return false;
            }
            commonUtil.tips();
            return true;
        },
        tell:function(tell,msg){
            var tell  = $.trim(tell);
            //var pattern = /(\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$/;
            var pattern = /(^[0-1]{1}\d{10}$)|(^1[34578]\d{9}$)|(^[0-1]{1}\d{11}$)/;
            if(tell == '') {
                if(msg==2){
                    commonUtil.waring('公司联系电话不能为空');
                }else{
                    commonUtil.waring('家庭电话不能为空');
                }
                return false;
            }
            if(!tell.match(pattern)) {
                if(msg==2){
                    commonUtil.waring('请输入有效的公司联系电话');
                }else{
                    commonUtil.waring('请输入有效的家庭电话');
                }
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
        is_time:function (times) {
            timer = setInterval(function() {
                times--;
                if(times > 0) {
                    $('.t-pwd-code1').text(times +'秒后重发');
                    $('.t-pwd-code1').attr('disabled','disabled');
                    $('.t-pwd-code1').css('background','gainsboro');
                } else {
                    times = 60;
                    $('.t-pwd-code1').text('重发验证码');
                    $('.t-pwd-code1').removeAttr('disabled');
                    $('.t-pwd-code1').css('background','#ff7200');
                    clearInterval(timer);

                }
            }, 1000);
        },
        is_number:function(number){
            var number  = $.trim(number);
            var pattern = /^[0-9a-zA-Z]{0,10}$/;
            if(number == '') {
                commonUtil.waring('请输入动态验证码');
                return false;
            }
            if(!number.match(pattern)) {
                commonUtil.waring('动态验证码格式不正确，请重新输入');
                return false;
            }
            commonUtil.tips();
            return true;
        },
        is_searchcode:function(code){
            var code  = $.trim(code);
            var pattern = /[0-9a-zA-Z]*/;
            if(code == '') {
                commonUtil.waring('请输入网站密码');
                return false;
            }
            if(!code.match(pattern)) {
                commonUtil.waring('网站密码格式不正确，请重新输入');
                return false;
            }
            commonUtil.tips();
            return true;
        },
        phone:function(phone){
            var phone  = $.trim(phone);
            var pattern = /^(13\d|14[57]|15[012356789]|18\d|17[01678])\d{8}$/;
            var unique ='';
            if(phone == '') {
                commonUtil.waring('请输入手机号码');
                return false;
            }
            if(!phone.match(pattern)) {
                commonUtil.waring('请输入有效手机号码');
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
        passphone:function(passphone,msg){
            //var reg = /[0-9a-zA-Z]*/;
            var reg = /(^(\d{6})$)|(^(\d{7})$)|(^(\d{8})$)/i;
            if(!passphone.match(reg)) {
                commonUtil.waring(msg);
                return false;
            }
            commonUtil.tips();
            return true;
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
		    var pattern = /^[\u4e00-\u9fa5]{2,}$/;
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
        //公司姓名
        cname:function(cname,type){
            cname=$.trim(cname);
            var pattern = /([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{4,}([a-zA-Z0-9]{0,})/;
            if(cname =="" || cname == null ) {
                commonUtil.waring(formarr[type][10001]);
                return false;
            }
            if(!cname.match(pattern)) {
                commonUtil.waring(formarr[type][10002]);
                return false;
            }
            commonUtil.tips();
            return true;
        },

        namerule:function(cname,type){
            cname=$.trim(cname);
            var pattern = /([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{4,}([a-zA-Z0-9]{0,})|([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{3,}([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{1,}([a-zA-Z0-9]{0,})|([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{2,}([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{2,}([a-zA-Z0-9]{0,})|([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{1,}([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{3,}([a-zA-Z0-9]{0,})/;
            if(cname =="" || cname == null ) {
                commonUtil.waring(formarr[type][10001]);
                return false;
            }
            if(!cname.match(pattern)) {
                commonUtil.waring(formarr[type][10002]);
                return false;
            }
            commonUtil.tips();
            return true;
        },


        details_four:function(cname,type){
            cname=$.trim(cname);
            var pattern = /([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{4,}([a-zA-Z0-9]{0,})|([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{3,}([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{1,}([a-zA-Z0-9]{0,})|([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{2,}([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{2,}([a-zA-Z0-9]{0,})|([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{1,}([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{3,}([a-zA-Z0-9]{0,})/;
            if(cname =="" || cname == null ) {
                commonUtil.waring(formarr[type][10001]);
                return false;
            }
            if(!cname.match(pattern)) {
                commonUtil.waring(formarr[type][10002]);
                return false;
            }
            commonUtil.tips();
            return true;
        },

        details_two:function(cname,type){
            cname=$.trim(cname);
            //var pattern = /([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{2,}([a-zA-Z0-9]{0,})|([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{1,}([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{1,}([a-zA-Z0-9]{0,})|([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{0,}([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{2,}([a-zA-Z0-9]{0,})/;
            var pattern = /([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{2,}([a-zA-Z0-9]{0,})|([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{1,}([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{1,}([a-zA-Z0-9]{0,})|([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{0,}([a-zA-Z0-9]{0,})[\u4e00-\u9fa5]{2,}([a-zA-Z0-9]{0,})/;
            if(cname =="" || cname == null ) {
                commonUtil.waring(formarr[type][10001]);
                return false;
            }
            if(!cname.match(pattern)) {
                commonUtil.waring(formarr[type][10002]);
                return false;
            }
            commonUtil.tips();
            return true;
        },


        authcode:function(authcode,msg){
			authcode=$.trim(authcode);

		    if(authcode =="" || authcode == null ) {
                if(msg==2){
                    commonUtil.waring('请填写邮箱验证码');
                }else if(msg==3){
                    commonUtil.waring('请填写验证码');
                }else{
                    commonUtil.waring('请填写手机验证码');
                }

			   return false;
		    }
            if(msg==3){
                if(authcode.length!=6) {
                        commonUtil.waring('验证码必须是六位整数');
                    return false;
                }
            }else{
                if(authcode.length!=4) {
                    if(msg==2){
                        commonUtil.waring('请填写正确邮箱验证码');
                    }else{
                        commonUtil.waring('请填写正确手机验证码');
                    }
                    return false;
                }
            }
			commonUtil.tips();
			return true;
		},
        dynamiccode:function(authcode){
            authcode=$.trim(authcode);
            if(authcode.length>0){
                var pattern = /[0-9]{6,}/;
                if(!authcode.match(pattern)){
                    commonUtil.waring('动态验证码格式错误（6位以上数字组合）');
                    return false;
                }
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
                    commonUtil.waring('登录密码（6-20位字母数字组合）');
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
        },
        lockup_credit:function(msg){
            $('.t-red-btn').addClass('t-gray-btn');
            $(".t-red-btn").attr('disabled',true);
            $('.t-red-btn').removeClass('t-red-btn');
            load = layer.msg(msg, {time: -1,icon: 16,offset:['210px','60px']});
            $('.t-mask').show();
        }


    }

})(jQuery);