
 var submitNum = 0;
 practicalMoney();
 //优惠券弹层隐藏
 $('.t-close-btn').on('touched click',function(e){
     $("#t-box_alert").hide();
     $('.t-mask').hide();
 });

 //暂不使用优惠券点击动作
 $(".t-red").on('touched click',function(){
     $(".t-coup").hide();
     $('.t-mask').hide();
     $("#t-box_alert").hide();
     $(".t-coupon-st1").empty().html("您有<strong>"+seajs.data.vars.num+"</strong>张优惠券</span>");
     $(".t-check-btn").removeClass("t-check-btn-active");
     $('.practical em').text(parseFloat(K-poundage).toFixed(2));
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
 $(".t-red-btn-but").click(function(){
     borrowClick();
     // if(submitNum == 1){
     //     borrowClick();
     // }else{
     //     submitNum = 1;
     // }
 });
 $('.t-red-btn-but-show').click(function(){
     commonUtil.showpublic('您需要先补充资料后再申请借款','去补充','/SpeedH5Process/ContactsExtreme');
     //prompt_show();
 });
 function practicalMoney(){
     m = seajs.data.vars.map;
     K = $('.money .able em').text();
     N = $('.day .able em').text();
     var eValue='fast_'+K+'_'+N;
     $('.practical em').text(eval((K-m[eValue])).toFixed(2));
     $(".t-coup").hide();
     $('.poundage em').text(m[eValue]);
     $('.expire em').text(K);
     $("input[name='poundage']").val(m[eValue]);
     poundage = $("input[name='poundage']").val();
     $(".t-check-btn-active").removeClass("t-check-btn-active");
     if(seajs.data.vars.count) {
         $(".t-coupon-st1").empty().html("<span style='color:#ff8470;'>您有<strong>" + seajs.data.vars.num + "</strong>张优惠券</span>");
     }else{
         $(".t-coupon-st1").empty().html("<span style='color:#ff8470;'>暂无可用优惠券</span>");
     }
 }
 //显示所有优惠券动作
 function coupon(money,day){
     $(".t-bomb_box-7 .t-coupon-card").each(function(index,element){
         switch($(this).attr("type")){
             case "1":
                 difference = eval(money-$(this).attr("min_loan"));
                 var id = $(this).attr("id");
                 if(difference<0){
                     $("#"+id).removeAttr("is");
                     $(this).parent('.coupon-select').removeClass("nav-coupon-list");
                     $(this).parent('.coupon-select').addClass("nav-coupon-list-old");
                     $("#t-bomb_box-6").append($(this).parent('coupon-select'));
                 }else{
                     $("#"+id).attr("is",'y');
                 }
                 break;
             case "2":
                 differencemoney = eval(money-$(this).attr("min_loan"));
                 differenceday = day-$(this).attr("day");
                 var id = $(this).attr("id");
                 if(differencemoney<0 || differenceday<0){
                     $("#"+id).removeAttr("is");
                     $(this).parent('.coupon-select').removeClass("nav-coupon-list");
                     $(this).parent('.coupon-select').addClass("nav-coupon-list-old");
                     $("#t-bomb_box-6").append($(this).parent('coupon-select'));
                 }else{
                     $("#"+id).attr("is",'y');
                 }
                 break;
             case "3":
                 poundagenum = $('.poundage em').text();
                 differencemoney = eval(poundagenum-$(this).attr("min_loan"));
                 var id = $(this).attr("id");
                 if(differencemoney<0){
                     $("#"+id).removeAttr("is");
                     $(this).parent('.coupon-select').removeClass("nav-coupon-list");
                     $(this).parent('.coupon-select').addClass("nav-coupon-list-old");
                     $("#t-bomb_box-6").append($(this).parent('.coupon-select'));
                 }else{
                     $("#"+id).attr("is",'y');
                 }
                 break
         }
     });
 }

 //优惠券点击动作
 $(".t-coupon-card").on("click",function(){
     var is = $(this).attr("is");
     if(is=='y'){
         id = $(this).attr('id');
         money = $(this).attr('data');
         $(".t-check-btn").removeClass("t-check-btn-active");
         $("#btn"+id).addClass("t-check-btn-active");
         $("#t-box_alert").hide();
         $(".t-mask").hide();
         $(".t-coupon-st1").empty().html("<span style='color:#ff8470;'>已使用"+money+"元优惠券</span><input type='hidden' name='couponid' value='"+id+"' >");
         $(".t-coup").show();
         practical = $('.borrowmoney em').text();
         zmoney = (parseFloat(K-poundage)+parseFloat(money)).toFixed(2);
         if(parseFloat(zmoney)>parseFloat(K)){
             $('.practical em').text(K);
         }else{
             $('.practical em').text(zmoney);
         }
         if(parseInt(money-poundage)>0){
             $(".t-coup em").text('-'+poundage);
         }else{
             $(".t-coup em").text('-'+money);
         }
     }
 });
 
 function borrowClick() {
     commonUtil.lockup();
     //money = $("input[name='money']").val();
     money = $(".money .able em").text();
     day = $(".day .able em").text();
     // day = $("input[name='day']").val();
     type = $("input[name='type']").val();
     poundage = $("input[name='poundage']").val();
     //ensure_rate_bu = $("input[name='ensure_rate']").val();
     latitude = $("input[name='latitude']").val();
     longitude = $("input[name='longitude']").val();
     if ($(".t-check-btn").hasClass("t-check-btn-active")) {
         coupinid = $('.t-check-btn-active').parent('.t-coupon-card').attr('id');
         offset = $('.t-check-btn-active').parent('.t-coupon-card').attr('data');
     } else {
         coupinid = null;
         offset = null;
     }
     $.ajax({
         url: seajs.data.vars.borrowurl,
         type: 'POST',
         //data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
         data: {
             money: money,
             day: day,
             coupinid: coupinid,
             offset: offset,
             poundage: poundage,
             type: type
         },
         dataType: 'json',
         async: true,  //同步发送请求t-mask
         beforeSend: function () {
         },
         success: function (result) {
             if (result.status == true) {
                 commonUtil.unlock();
                 commonUtil.tips();
                 location.href = "/SpeedH5Process/check";
             } else {
                 commonUtil.waring(result.msg);
                 commonUtil.unlock();
                 return false;
             }
         },
         error: function () {
             commonUtil.unlock();
             commonUtil.waring("表单发送失败！");
             return false;
         }
     });
 }
 //显示券弹层隐藏
 $('#show-card').on('touched click',function(e){
     // e.stopPropagation();
     $("#t-box_alert").show();
     $('.t-mask').show();
     var money = $('.money .able em').text();
     var day = $('.day .able em').text();
     coupon(money,day);
 });
 $(".money li").click(function(){
     $(".money .able").removeClass('able');
     $(this).addClass('able');
     practicalMoney();
 });
 $(".day li").click(function(){
     $(".day .able").removeClass('able');
     $(this).addClass('able');
     practicalMoney()
 });

