function practicalDown(){if(m=seajs.data.vars.map,K=$("#js-example-change-value output:first").text(),N=$("#js-example-change-value-2 output:first").text(),D=$("input[name=ensure_rate][checked]").val(),"100"==D)var eValue="ensure_"+K+"_"+N;else var eValue="credit_"+K+"_"+N;$(".practical em").text(eval(K-m[eValue]).toFixed(2)),$(".t-coup").hide(),$(".poundage em").text(m[eValue]),$(".expire em").text(K),$(".gamount em").text(eval(.01*K*D).toFixed(0)),poundage=m[eValue],$("input[name='poundage']").val(poundage),$(".t-check-btn-active").removeClass("t-check-btn-active"),$(".t-coupon-st1").empty().html("您有<strong>"+seajs.data.vars.num+"</strong>张优惠券</span>")}function valueOutput(element){var value=element.value;$(element).data("value",value);var output=element.parentNode.getElementsByTagName("output")[0],em=element.parentNode.parentNode.parentNode.getElementsByTagName("em")[0];if(output.innerHTML=value,a=output.innerHTML,b=output.innerHTML,m=seajs.data.vars.map,K=$("#js-example-change-value output:first").text(),N=$("#js-example-change-value-2 output:first").text(),D=$("input[name=ensure_rate][checked]").val(),"100"==D)var eValue="ensure_"+K+"_"+N;else var eValue="credit_"+K+"_"+N;$(".practical em").text(eval(K-m[eValue]).toFixed(2)),$(".t-coup").hide(),$(".poundage em").text(m[eValue]),$(".expire em").text(K),$(".gamount em").text(eval(.01*K*D).toFixed(0)),poundage=m[eValue],$("input[name='poundage']").val(poundage),$(".t-check-btn-active").removeClass("t-check-btn-active"),0!=seajs.data.vars.num&&$(".t-coupon-st1").empty().html("您有<strong>"+seajs.data.vars.num+"</strong>张优惠券</span>")}function coupon(money,day){$(".t-bomb_box-7 .t-coupon-card").each(function(index,element){switch($(this).attr("type")){case"1":difference=eval(money-$(this).attr("min_loan"));var id=$(this).attr("id");0>difference?($("#"+id).removeAttr("is"),$(this).parent(".coupon-select").removeClass("nav-coupon-list"),$(this).parent(".coupon-select").addClass("nav-coupon-list-old"),$("#t-bomb_box-6").append($(this).parent(".coupon-select"))):($("#"+id).attr("is","y"),$(this).parent(".coupon-select").removeClass("nav-coupon-list-old"),$(this).parent(".coupon-select").addClass("nav-coupon-list"));break;case"2":differencemoney=eval(money-$(this).attr("min_loan")),differenceday=day-$(this).attr("day");var id=$(this).attr("id");0>differencemoney||0>differenceday?($("#"+id).removeAttr("is"),$(this).parent(".coupon-select").removeClass("nav-coupon-list"),$(this).parent(".coupon-select").addClass("nav-coupon-list-old"),$("#t-bomb_box-6").append($(this).parent(".coupon-select"))):($("#"+id).attr("is","y"),$(this).parent(".coupon-select").removeClass("nav-coupon-list-old"),$(this).parent(".coupon-select").addClass("nav-coupon-list"));break;case"3":poundagenum=$(".poundage em").text(),differencemoney=eval(poundagenum-$(this).attr("min_loan"));var id=$(this).attr("id");0>differencemoney?($("#"+id).removeAttr("is"),$(this).parent(".coupon-select").removeClass("nav-coupon-list"),$(this).parent(".coupon-select").addClass("nav-coupon-list-old"),$("#t-bomb_box-6").append($(this).parent(".coupon-select"))):($("#"+id).attr("is","y"),$(this).parent(".coupon-select").removeClass("nav-coupon-list-old"),$(this).parent(".coupon-select").addClass("nav-coupon-list"))}})}for(var $document=$(document),selector="[data-rangeslider],[data-rangeslider-2]",$inputRange=$(selector),i=$inputRange.length-1;i>=0;i--)valueOutput($inputRange[i]);if($document.on("input",selector,function(e){valueOutput(e.target)}),$inputRange.rangeslider({polyfill:!1}),seajs.data.vars.available?$(".WellCheckBox").click(function(){$(".WellCheckBoxH").removeClass("WellCheckBoxH"),$(this).addClass("WellCheckBoxH"),$("input[name=ensure_rate]").attr("checked",!1),$(this).children("input").attr("checked",!0),practicalDown()}):$(".prompt").click(function(){$("#t-bomb_box_prompt").show(),$(".t-mask").show()}),K=$("#js-example-change-value output:first").text(),couponId=seajs.data.vars.couponId,""!=couponId&&0!=couponId&&null!=couponId){couponAmount=seajs.data.vars.couponAmount;var practic=(parseFloat(K-poundage)+parseFloat(couponAmount)).toFixed(2);practic=practic>K?K:practic,$(".practical em").text(practic),$(".t-coupon-st1").empty().html("<span class='t-coupon-st1' style='color:#ff8470;'>已使用"+seajs.data.vars.amount_start+"元优惠券<input type='hidden' name='couponid' value='"+seajs.data.vars.ordercoupinid+"' ></span>"),$(".t-coup").show()}else $(".t-coup").hide();$(".t-close-btn").on("touched click",function(){$("#t-box_alert").hide(),$(".t-mask").hide()}),$("#show-card").on("touched click",function(e){e.stopPropagation(),$("#t-box_alert").show(),$(".t-mask").show();var t=$("#js-example-change-value output:first").text(),a=$("#js-example-change-value-2 output:first").text();coupon(t,a)}),$(".t-red").on("touched click",function(){$(".t-coup").hide(),$(".t-mask").hide(),$("#t-box_alert").hide(),$(".t-coupon-st1").empty().html("您有<strong>"+seajs.data.vars.num+"</strong>张优惠券</span>"),$(".t-check-btn").removeClass("t-check-btn-active"),$(".practical em").text(parseFloat(K-poundage).toFixed(2))}),$(".t-coupon-card").on("click",function(){var e=$(this).attr("is");"y"==e&&(id=$(this).attr("id"),money=$(this).attr("data"),$(".t-check-btn").removeClass("t-check-btn-active"),$("#btn"+id).addClass("t-check-btn-active"),$("#t-box_alert").hide(),$(".t-mask").hide(),$(".t-coupon-st1").empty().html("<span style='color:#ff8470;'>已使用"+money+"元优惠券</span><input type='hidden' name='couponid' value='"+id+"' >"),$(".t-coup").show(),practical=$("#js-example-change-value output:first").text(),zmoney=(parseFloat(K-poundage)+parseFloat(money)).toFixed(2),parseFloat(zmoney).toFixed(2)>parseFloat(K).toFixed(2)?$(".practical em").text(K):$(".practical em").text(zmoney),parseInt(money-poundage)>0?$(".t-coup em").text("-"+poundage):$(".t-coup em").text("-"+money))}),$(document).ready(function(){$("a").is(".t-check-btn-is")&&$(".t-check-btn-is").addClass("t-check-btn-active"),$(".t-red-btn-show").click(function(){$(".t-mask").show(),$("#t-bomb_box_prompt").show()})});