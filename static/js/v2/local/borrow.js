/**
 * Created by liujinsheng on 16/9/7.
 */


/*-----------------------------------------borrow代码-----------------------------------------------------*/

var $document   = $(document);
var selector    = '[data-rangeslider],[data-rangeslider-2]';
var $inputRange = $(selector);
var m = seajs.data.vars.map;
//实际可抵扣金额
var moneyCoin = 0.00;
var typeRatio = 'type_'+seajs.data.vars.type;
var use_ratio = seajs.data.vars.use_ratio[typeRatio];


//限制住余额折扣按钮
if(seajs.data.vars.coin<=0){
    $('input[name=coincheckbox]').attr('disabled','disabled');
}
//应还金额
var expire = null;
//点击降担保的时候启用
function practicalDown(){
    // K = $('.borrowmoney em').text();
    // N = $('.borrowday em').text();
    K = $('#js-example-change-value output:first').text();
    N = $('#js-example-change-value-2 output:first').text();
    D = $('input[name=ensure_rate][checked]').val();
    if(D == '100'){
        use_ratio = seajs.data.vars.use_ratio['type_1'];
        // var eValue='ensure_'+K+'_'+N;
    }else{
        use_ratio = seajs.data.vars.use_ratio['type_2'];
        // var eValue='credit_'+K+'_'+N;
    }
    var eValue='_'+K+'_'+N;
    $('.practical em').text(eval(K).toFixed(2));
    //借款手续费
    // alert(m[eValue]['total'][0]['amount']);
    $('.poundage em').text(m[eValue]['total'][0]['amount']);
    $('.poundage label').text(m[eValue]['total'][0]['name']);
    //费用替换
    $.each(m[eValue]['item'], function(index, value, array) {
        $('.cost_'+index+' em').text(value['amount']);
        $('.cost_'+index+' label').text(value['name']);
    });

    //到期还款
    expire = eval((K*1+m[eValue]['total'][0]['amount']*1)).toFixed(2);
    $('.expire em').text(expire);
    //担保金额
    $('.gamount em').text(eval(K*D*0.01).toFixed(0));
    //手续费
    poundage = m[eValue]['total'][0]['amount'];
    $("input[name='poundage']").val(poundage);
    //需要抵扣的金额
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
//每一次调整价格或时间调动
function valueOutput(element) {
    var value = element.value;
    $(element).data('value', value);
    var output = element.parentNode.getElementsByTagName('output')[0];
    var em = element.parentNode.parentNode.parentNode.getElementsByTagName('em')[0];
    output.innerHTML = value;
    //em.innerHTML = value;
    a=output.innerHTML;
    b=output.innerHTML;
    // this.practical();
    // K = $('.borrowmoney em:first').text();
    // N = $('.borrowday em:first').text();
    K = $('#js-example-change-value output:first').text();
    N = $('#js-example-change-value-2 output:first').text();
    D = $('input[name=ensure_rate][checked]').val();
    // if(D == '100'){
    //     var eValue='ensure_'+K+'_'+N;
    // }else{
    //     var eValue='credit_'+K+'_'+N;
    // }
    var eValue='_'+K+'_'+N;
    //实际放款
    $('.practical em').text(eval(K).toFixed(2));
    //费用替换
    $.each(m[eValue]['item'], function(index, value, array) {
        $('.cost_'+index+' em').text(value['amount']);
        $('.cost_'+index+' label').text(value['name']);
    });
    //借款手续费
    $('.poundage em').text(m[eValue]['total'][0]['amount']);
    $('.poundage label').text(m[eValue]['total'][0]['name']);
    //到期还款
    expire = eval((K*1+m[eValue]['total'][0]['amount']*1)).toFixed(2);
    $('.expire em').text(expire);
    //担保金额
    $('.gamount em').text(eval(K*D*0.01).toFixed(0));
    $('.gamount em').text(eval(K*D*0.01).toFixed(0));
    //手续费
    poundage = m[eValue]['total'][0]['amount'];
    $("input[name='poundage']").val(m[eValue]['total'][0]['amount']);
    //可抵扣余额
    // $('.deductible .coin_able').text(moneyCoin);
    //需要抵扣的金额
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
                    $("#t-bomb_box-6").append($(this).parent('.coupon-select'));
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
                    $("#t-bomb_box-6").append($(this).parent('.coupon-select'));
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
                break
        }
    });
}


// Initial value output
for (var i = $inputRange.length - 1; i >= 0; i--) {
    valueOutput($inputRange[i]);
};
// Update value output
$document.on('input', selector, function(e) {
    valueOutput(e.target);
});

// Initialize the elements
$inputRange.rangeslider({
    polyfill: false
});

if(seajs.data.vars.available){
    $('.WellCheckBox').click(function () {
        $('.WellCheckBoxH').removeClass("WellCheckBoxH");
        $(this).addClass('WellCheckBoxH');
        $("input[name=ensure_rate]").attr("checked",false);
        $(this).children('input').attr("checked",true);
        practicalDown();
    });
}else{
    $('.prompt').click(function () {
        $('#t-bomb_box_prompt').show();
        $('.t-mask').show();
    });
}

K = $('#js-example-change-value output:first').text();
//如果是使用了优惠券 在回来借 计算出实际放款 显示
couponId=seajs.data.vars.couponId;
if(couponId!='' && couponId!=0 &&couponId!=null){
    couponAmount=seajs.data.vars.couponAmount;
    var practic = (parseFloat(K-poundage)+parseFloat(couponAmount)).toFixed(2);
    practic = practic>K?K:practic;
    $('.practical em').text(practic);
    $(".t-coupon-st1").empty().html("<span class='t-coupon-st1' style='color:#ff8470;'>已使用"+seajs.data.vars.amount_start+"元优惠券<input type='hidden' name='couponid' value='"+seajs.data.vars.ordercoupinid+"' ></span>");
    $(".t-coup").show();
    //$(".t-coupon").attr('data',bug+1);
}else{
    $(".t-coup").hide();
}
//优惠券弹层隐藏
$('.t-close-btn').on('touched click',function(e){
    $("#t-box_alert").hide();
    $('.t-mask').hide();
});
//显示券弹层隐藏
$('#show-card').on('touched click',function(e){
    e.stopPropagation();
    $("#t-box_alert").show();
    $('.t-mask').show();
    var money = $('#js-example-change-value output:first').text();
    var day = $('#js-example-change-value-2 output:first').text();
    // var money = $('.borrowmoney em').text();
    // var day = $('.borrowday em').text();
    // alertH("#t-bomb_box");
    coupon(money,day);
});

//暂不使用优惠券点击动作
$(".t-red").on('touched click',function(){
    $('.t-mask').hide();
    $("#t-box_alert").hide();
    unCoupon();
    // $(".t-coupon-st1").empty().html("您有<strong>"+seajs.data.vars.num+"</strong>张优惠券</span>");
    // $(".t-check-btn").removeClass("t-check-btn-active");
    $('.practical em').text(parseFloat(K).toFixed(2));
    $('.expire em').text(parseFloat(expire).toFixed(2));
});
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
        practical = $('#js-example-change-value output:first').text();
        // practical = $('.borrowmoney em').first().text();
        //计算到期还款金额(到期还的钱不能低于选款金额)
        zmoney = (parseFloat(expire)-parseFloat(money)).toFixed(2);
        //zmoney = eval((K*1+m[eValue]['total'][0]['amount']*1)).toFixed(2);
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
$(document).ready(function(){
    if($('a').is('.t-check-btn-is')){
        $('.t-check-btn-is').addClass('t-check-btn-active');
    };
    $(".t-red-btn-show").click(function () {
        $('.t-mask').show();
        $('#t-bomb_box_prompt').show();
    });
});
