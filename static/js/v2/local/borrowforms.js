

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
     submitNum = 1;
     commonUtil.lockup();
     money = $("input[name='money']").val();
     day = $("input[name='day']").val();
     // = $("input[name='type']").val();
     poundage = $("input[name='poundage']").val();
     //ensure_rate_bu = $("input[name='ensure_rate']").val();
     //担保比例测试
     ensure_rate_bu = $('input[name=ensure_rate][checked]').val();
     if($(".t-check-btn").hasClass("t-check-btn-active")){
         coupinid = $('.t-check-btn-active').parent('.t-coupon-card').attr('id');
         offset = $('.t-check-btn-active').parent('.t-coupon-card').attr('data');
     }else{
         coupinid = null;
         offset = null;
     }
     if($('input[name=coincheckbox]').is(':checked')) {
         //取消选中
         var coin = $('.coin_able').text();
     }else{
         //放弃选择
         var coin = 0.00;
     }
     if(coupinid!=null && coin!=0.00){
         commonUtil.unlock();
         commonUtil.waring('数据异常！');
         return false;
     }
     if(seajs.data.vars.ensure_rate>ensure_rate_bu || ensure_rate_bu>100){
         commonUtil.waring('担保比例异常！');
         commonUtil.unlock();
         return false;
     }
     latitude = $("input[name='latitude']").val();
     longitude = $("input[name='longitude']").val();
     // if(commonUtil.isnull(latitude,'获取地址失败,请重新提交')!=true){
     //     commonUtil.unlock();
     //     return false;
     // }
     // if(commonUtil.isnull(longitude,'获取地址失败,请重新提交')!=true){
     //     commonUtil.unlock();
     //     return false;
     // }
     $.ajax({
         url:seajs.data.vars.borrowurl,
         type:'POST',
         // data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
         // data:{money:money,day:day,coupinid:coupinid,offset:offset,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude,coin:coin},
         data:{money:money,day:day,coupinid:coupinid,offset:offset,poundage:poundage,ensure_rate_bu:ensure_rate_bu,coin:coin,type:seajs.data.vars.type,latitude:latitude,longitude:longitude},
         dataType:'json',
         async: true,  //同步发送请求t-mask
         beforeSend:function(){
         },
         success:function(result){
             commonUtil.unlock();

             if(result.status == true){
                 location.href = "/Borrowmoney/bankinfo";
                 commonUtil.tips();
             }else{
                 if(commonUtil.isnull(result.url)==true){
                     layerMobile.submitUrl(result.msg,result.url);
                 }else{
                     if(commonUtil.isnull(result.code)==true){
                         layerMobile.submitEdit('请下载快金APP完成授信资料！','下载APP','/Promotion');
                     }else{
                         commonUtil.waring(result.msg);
                         commonUtil.unlock();
                         return  false;
                     }
                 }
             }
         },
         error:function(){
             commonUtil.unlock();
             commonUtil.waring("表单发送失败！");
             return false;
         }
     });
 };
 $(".t-orange-btn-but").click(function(){
     if(submitNum == 1){
         borrowClick();
     }

 });
    