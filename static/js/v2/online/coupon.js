function changeTrue(){ajax_getting=!0}function changeFalse(){ajax_getting=!1}var ajax_getting=!0,$document=$(document);$(".t-close-btn").on("touched click",function(){$("#t-box_alert").hide(),$(".t-mask").hide()}),$document.on("touched click","#show-rules",function(t){t.stopPropagation(),$("#t-box_alert").show(),$(".t-mask").show()}),$document.ready(function(){$(".t-tab li").click(function(){$(".t-tab li").eq($(this).index()).addClass("t-tab-cur").siblings().removeClass("t-tab-cur"),$(".section").hide().eq($(this).index()).show()}),$(".nav-coupon span").click(function(){$(".nav-coupon span").removeClass("orange"),$(this).addClass("orange"),$(".section").hide().eq($(this).index()).show()})});var last_id=seajs.data.vars.last_id,total=seajs.data.vars.total,innerHeight=window.innerHeight,timer2=null;$(window).scroll(function(){clearTimeout(timer2),timer2=setTimeout(function(){var t=$(document.body).scrollTop(),a=$("body").height(),s=innerHeight,e=Math.max(a-t-s);if(10>e){if(5>total&&(ajax_getting=!0),ajax_getting)return!1;load=layer.msg("加载中",{time:-1,icon:16}),$.ajax({url:"/Functions/GetMoreCoupen?last_id="+last_id,type:"GET",dataType:"json",success:function(t){if(layer.close(load),1==t.status){for(var a,s=[],e=0;a=t.data[e++];)s.push("<div class='nav-coupon-list-old'><div class='t-coupon-item-price float_left font_gray coupon_border_right_orange'><span>¥</span>"+parseInt(a.amount)+"</div><div class='t-coupon-item-des'><p class='t-des-txt1'>"+a.name+"</p>"),1==a.type?s.push("<p class='t-des-txt2'>"+a.min_loan+"元以上借款可以使用</p>"):2==a.type?s.push("<p class='t-des-txt2'>"+a.min_loan+"元以上借款,借款天数最少"+a.min_day+"天</p>"):3==a.type&&s.push("<p class='t-des-txt2'>手续费金额满"+a.full_cut+"才可以使用</p>"),s.push("<p class='t-des-txt3'>请于"+a.expire_time+"前使用</p>"),a.img&&s.push("<img src='"+a.img+"'>"),s.push("</div></div><div class='clear'></div></div>");$(".t-tab-on").append(s.join("")),total=t.total,last_id=t.last_id}}})}},200)});