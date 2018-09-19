
 var submitNum = 0;
 m = seajs.data.vars.map;
 //实际可抵扣金额
 var moneyCoin = 0.00;
 // var typeRatio = 'type_'+seajs.data.vars.type;
 var use_ratio = seajs.data.vars.use_ratio['type_3'];

 //限制住余额折扣按钮
 if(seajs.data.vars.coin<=0){
     $('input[name=coincheckbox]').attr('disabled','disabled');
 }
 //应还金额
 var expire = null;
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
     $('.practical em').text(parseFloat(K).toFixed(2));
     $('.expire em').text(parseFloat(expire).toFixed(2));
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

 $('.t-red-btn-but-show').click(function(){
     commonUtil.showconsupply('您需要先补充资料后再申请借款','去补充');
     //prompt_show();
 });
 function practicalMoney(){
     K = $('.money .able em').text();
     N = $('.day .able em').text();
     var eValue='_'+K+'_'+N;
     $('.practical em').text(eval(K).toFixed(2));
     //费用合计
     $('.poundage em').text(m[eValue]['total'][0]['amount']);
     $('.poundage label').text(m[eValue]['total'][0]['name']);

     // console.log(m[eValue]['total']);
    //到期还款
     expire = eval((K*1+m[eValue]['total'][0]['amount']*1)).toFixed(2);
     $('.expire em').text(expire);
     $.each(m[eValue]['item'], function(index, value, array) {
         $('.cost_'+index+' em').text(value['amount']);
         $('.cost_'+index+' label').text(value['name']);
     });
     poundage = m[eValue]['total'][0]['amount'];
     $("input[name='poundage']").val(m[eValue]['total'][0]['amount']);
     moneyCoin = eval(m[eValue]['total'][0]['amount']*use_ratio*0.01).toFixed(2);
     if(moneyCoin>seajs.data.vars.coin){
         moneyCoin = seajs.data.vars.coin;
         $('.deductible .coin_able').text(seajs.data.vars.coin);
     }else{
         $('.deductible .coin_able').text(moneyCoin);
     }
     unCoupon();
     uncheck();
 }

 //checked取消选中
 function uncheck(){
     if($('input[name=coincheckbox]').is(':checked')) {
         //取消选中
         $("input[name=coincheckbox]").prop("checked", false);
     }
 }
 //余额计算
 function coinCount(){
     var coindiff =  eval(poundage*1-moneyCoin*1).toFixed(2);
     if(coindiff>0){
         var money = eval(K*1+coindiff*1).toFixed(2);
     }else{
         var money = eval(K).toFixed(2);
     }
     $('.expire em').text(money);
 }

 //余额抵扣点击处理
 $(".checkbox").on('touched click',function(){
     if($('input[name=coincheckbox]').is(':checked')) {
         //取消选中
         unCoupon();
         coinCount();
     }else{
         //放弃选择
         $('.expire em').text(eval(K*1+poundage*1).toFixed(2));
     }
 });



 //消除优惠券
 function unCoupon() {
     $(".t-check-btn-active").removeClass("t-check-btn-active");
     //if(seajs.data.vars.num != 0){
     $(".t-coup").hide();
     if(seajs.data.vars.count) {
         $(".t-coupon-st1").empty().html("<span style='color:#ff8470;'>您有<strong>" + seajs.data.vars.num + "</strong>张优惠券</span>");
     }else{
         $(".t-coupon-st1").empty().html("<span style='color:#ff8470;'>暂无可用优惠券</span>");
     }
     //}
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
                     $(this).parent('.coupon-select').removeClass("nav-coupon-list-old");
                     $(this).parent('.coupon-select').addClass("nav-coupon-list");
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
                     $(this).parent('.coupon-select').removeClass("nav-coupon-list-old");
                     $(this).parent('.coupon-select').addClass("nav-coupon-list");
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
                     $(this).parent('.coupon-select').removeClass("nav-coupon-list-old");
                     $(this).parent('.coupon-select').addClass("nav-coupon-list");
                 }
                 break;
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
         zmoney = (parseFloat(expire)-parseFloat(money)).toFixed(2);
         // zmoney = (parseFloat(K-poundage)+parseFloat(money)).toFixed(2);
         if(parseFloat(zmoney)>parseFloat(K).toFixed(2)){
             $('.expire em').text(zmoney);
         }else{
             $('.expire em').text(K);
         }
         if(parseInt(money-poundage)>0){
             $(".t-coup em").text('-'+poundage);
         }else{
             $(".t-coup em").text('-'+money);
         }
         uncheck();
     }
 });
 
 function borrowClick() {
     submitNum = 1;
     commonUtil.lockup();
     //money = $("input[name='money']").val();
     money = $(".money .able em").text();
     day = $(".day .able em").text();
     // day = $("input[name='day']").val();
     poundage = $("input[name='poundage']").val();
     //ensure_rate_bu = $("input[name='ensure_rate']").val();

     if ($(".t-check-btn").hasClass("t-check-btn-active")) {
         coupinid = $('.t-check-btn-active').parent('.t-coupon-card').attr('id');
         offset = $('.t-check-btn-active').parent('.t-coupon-card').attr('data');
     } else {
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
     latitude = $("input[name='latitude']").val();
     longitude = $("input[name='longitude']").val();
     // if (commonUtil.isnull(latitude, '获取地址失败,请重新提交') != true) {
     //     commonUtil.unlock();
     //     return false;
     // }
     // if (commonUtil.isnull(longitude, '获取地址失败,请重新提交') != true) {
     //     commonUtil.unlock();
     //     return false;
     // }
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
             type: seajs.data.vars.type,
             longitude:longitude,
             latitude:latitude,
             coin:coin
         },
         dataType: 'json',
         async: true,  //同步发送请求t-mask
         beforeSend: function () {
         },
         success: function (result) {
             commonUtil.unlock();
             if (result.status == true) {
                 commonUtil.tips();
                 location.href = "/Borrowmoney/check";
             } else {
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

 $(".t-red-btn-but").click(function(){
     if(submitNum==1){
         borrowClick();
     }

 });