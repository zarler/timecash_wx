(function($){
     $(function(){
         //输入框失去焦点x
         //text 和 password两种数据同步
         $(".pwdTip input").eq(0).blur(function(){
             $(".pwdTip input").eq(1).val($(this).val());
         });
         $(".pwdTip  input").eq(1).blur(function(){
             $(".pwdTip  input").eq(0).val($(this).val());
         });
		 //真实姓名判断
         $("input[name='conname']").blur(function(){
              commonUtil.isnull(this.value,'名称不能为空');
         });
         $("input[name='comtell']").blur(function(){
             commonUtil.tell(this.value,2);
         });
         //公司名称判断
         $("input[name='comname']").blur(function(){
             commonUtil.details_four(this.value,'company')
         });
         //公司详细判断
         $("input[name='comdetailaddre']").blur(function(){
             commonUtil.details_two(this.value,'companydetail')
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
                 url:seajs.data.vars.companyinfourl,
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
                         location.href = seajs.data.vars.Jumpourl;
                     }else{
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
                         if(commonUtil.isnull(this.value, '名称不能为空') != true) {
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
                 url:seajs.data.vars.contactsourl,
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
             if(unique == true){
                 location.href = seajs.data.vars.Jumpourl;
                 return false;
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


     //    兼容3.0联系人
         //标示
         $('.submit_new').click(function () {
             commonUtil.lockup();
             conname1 = $(".conname1").val();
             contact1 = $("select[name='contact1']").val();
             ccomtell1 = $("input[name='ccomtell1']").val();
             conname2 = $(".conname2").val();
             contact2 = $("select[name='contact2']").val();
             ccomtell2 = $("input[name='ccomtell2']").val();

             if(commonUtil.isnull(conname1,'姓名不能为空')!=true ||commonUtil.isnull(conname2,'姓名不能为空')!=true) {
                 commonUtil.unlock();
                 return false;
             }
             if(commonUtil.isnull(contact1, '请选择您与紧急联系人的关系') != true || commonUtil.isnull(contact2, '请选择您与紧急联系人的关系') != true){
                 commonUtil.unlock();
                 return false;
             }

             if(commonUtil.phone(ccomtell1)!=true || commonUtil.phone(ccomtell2)!=true) {
                 commonUtil.unlock();
                 return false;
             }
             $AppInst.WebJump({"type":"getUserContacts","par":""})
         });
     });
})(jQuery);

function submit(){
    //判断两个返回状态
        var post_data = {"conname1":conname1,'contact1':contact1,'ccomtell1':ccomtell1,'conname2':conname2,'contact2':contact2,'ccomtell2':ccomtell2};
        $.ajax({
            url:seajs.data.vars.contactsourl,
            type:'POST',
            data:post_data,
            dataType:'json',
            async: false,  //同步发送请求t-mask
            beforeSend:function(){
            },
            success:function(result){
                if(result.status === true){
                    location.href = '/?#jump=yes';
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

}

function appCallback(msg) {
    var json = eval('(' + msg + ')');

    if(json.type == 'getUserContacts'){
        if(json.data == 'true'){
            submit();
        }else{
            commonUtil.unlock();
            layerMobile.showlayer('获取联系人信息失败！'); layerMobile.changeCssMsg();
        }
    }
    if(json.type == 'getPhone'){
//            abc.text('重新选择');
        $(".conname"+abc.data('code')).val((json.data.name).replace(/\s+/g,""));
        $("input[name='ccomtell"+abc.data('code')+"']").val((json.data.tell).replace(/\s+/g,""));
//            $("input[name='conname"+abc.data('code')+"']").val((json.data.name).replace(/\s+/g,""));
//            $("input[name='ccomtell"+abc.data('code')+"']").val((json.data.tell).replace(/\s+/g,""));
    }

}