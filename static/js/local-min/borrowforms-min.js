

        var submitNum = 0;
         //银行卡号
         $("input[name='card_no']").blur(function(){
             commonUtil.card_no(this.value);
         });
         //银行点击显示
         $('.t-re-bank').click(function(){
             $('#t-box_alert').show();
             $('.t-mask').show();
         });
         //银行点击隐藏
         $('.t-bomb_close').click(function(){
             $('#t-box_alert').hide();
             $('.t-mask').hide();
         });
         //点击银行的悬浮框  添加到页面银行
         $('.t-bomb_box-6 p').click(function(){
             name = $(this).attr('data');
             id = $(this).attr('id');
             checkedid = $('input:radio[name="bank_card_str"]:checked').attr("id");
             $("#".checkedid).removeAttr("checked");
             $("#checkbox_a1"+id).attr("checked","checked");
             code = $(this).attr('code');
             $('.t-re-bank p').text(name);
             $("input[name='bank_id']").val(id);
             $("input[name='bank_code']").val(code);
             $('#t-box_alert').hide();
             $('.t-mask').hide();
         });
         function borrowClick(){
             commonUtil.lockup();
             money = $("input[name='money']").val();
             day = $("input[name='day']").val();
             // = $("input[name='type']").val();
             poundage = $("input[name='poundage']").val();
             //ensure_rate_bu = $("input[name='ensure_rate']").val();
             //担保比例测试
             ensure_rate_bu = $('input[name=ensure_rate][checked]').val();
             latitude = $("input[name='latitude']").val();
             longitude = $("input[name='longitude']").val();
             if($(".t-check-btn").hasClass("t-check-btn-active")){
                 coupinid = $('.t-check-btn-active').parent().parent('.t-coupon-card').attr('id');
                 offset = $('.t-check-btn-active').parent().parent('.t-coupon-card').attr('data');
             }else{
                 coupinid = null;
                 offset = null;
             }
             if(ensure_rate>ensure_rate_bu || ensure_rate_bu>100){
                 commonUtil.waring('担保比例异常！');
                 commonUtil.unlock();
                 return false;
             }
             if(commonUtil.isnull(latitude,'获取地址失败,请重新提交')!=true){
                 commonUtil.unlock();
                 return false;
             }
             if(commonUtil.isnull(longitude,'获取地址失败,请重新提交')!=true){
                 commonUtil.unlock();
                 return false;
             }
             $.ajax({
                 url:borrowurl,
                 type:'POST',
                 // data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
                 data:{money:money,day:day,coupinid:coupinid,offset:offset,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
                 dataType:'json',
                 async: true,  //同步发送请求t-mask
                 beforeSend:function(){
                 },
                 success:function(result){
                     if(result.status == true){
                         commonUtil.unlock();
                         commonUtil.tips();
                         location.href = "/Borrowmoney/bankinfo";
                     }else{
                         commonUtil.waring(result.msg);
                         commonUtil.unlock();
                         return  false;
                     }
                 },
                 error:function(){
                     commonUtil.unlock();
                     commonUtil.waring("表单发送失败！");
                     return false;
                 }
             });
         };
         $(".t-red-btn-but").click(function(){
             if(submitNum == 1){
                 borrowClick();
             }else{
                 submitNum = 1;
             }
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
            var pattern = /(\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$/;
            if(tell == '') {
                if(msg==2){
                    commonUtil.waring('请输入公司联系电话');
                }else{
                    commonUtil.waring('请输入联系电话');
                }
                return false;
            }
            if(!tell.match(pattern)) {
                if(msg==2){
                    commonUtil.waring('联系电话号码格式不正确，请重新输入');
                }else{
                    commonUtil.waring('号码格式不正确，请重新输入');
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
        phone:function(phone){
            var phone  = $.trim(phone);
            var pattern = /^(13\d|14[57]|15[012356789]|18\d|17[01678])\d{8}$/;
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
        passphone:function(passphone,msg){
            var reg = /^(\d{6})$/i;
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