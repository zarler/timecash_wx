var ajax_getting = true;
var $document   = $(document);
function changeTrue(){
    ajax_getting = true;
};
function changeFalse(){
    ajax_getting = false;
};
//弹层隐藏

//显示弹层
// $document.on('touched click', '#show-rules', function(e) {
//     e.stopPropagation();
//     $("#t-box_alert").show();
//     $(".t-mask").show();
// });
//选项卡
$document.ready(function(){
    $(".t-tab li").click(function(){
        $(".t-tab li").eq($(this).index()).addClass("t-tab-cur").siblings().removeClass('t-tab-cur');
        $(".section").hide().eq($(this).index()).show();
    });
    $(".nav-coupon span").click(function(){
        $('.nav-coupon span').removeClass('orange');
        $(this).addClass('orange');
        $(".section").hide().eq($(this).index()).show();
    });
    $("#show-rules").click(function(){
        // e.stopPropagation();
        $("#t-box_alert").show();
        $(".t-mask").show();
    });
    $('.t-close-btn').click(function(){
        $("#t-box_alert").hide();
        $(".t-mask").hide();
    });
});
var last_id = seajs.data.vars.last_id;
var total = seajs.data.vars.total;
var innerHeight = window.innerHeight;
var timer2 = null;
$(window).scroll(function(){
    clearTimeout(timer2);
    timer2 = setTimeout(function() {
        var scrollTop = $(document.body).scrollTop();
        var scrollHeight = $('body').height();
        var windowHeight = innerHeight;
        var scrollWhole = Math.max(scrollHeight - scrollTop - windowHeight);
        if (scrollWhole < 10){
            if(total<5){
                ajax_getting = true
            }
            if(ajax_getting) {
                return false;
            }
            load = layer.msg('加载中', {time: -1,icon: 16});
            $.ajax({
                url: seajs.data.vars.requestUrl+'?last_id=' + last_id,
                type: 'GET',
                dataType: 'json',
                success: function (data){
                    layer.close(load);
                    if (data.status == true) {
                        var arrText = [];
                        for (var i = 0, t; t = data.data[i++];) {
                            arrText.push("<div class='nav-coupon-list-old'><div class='t-coupon-item-price float_left font_gray coupon_border_right_orange'><span>¥</span>"+parseInt(t.amount)+"</div><div class='t-coupon-item-des'><p class='t-des-txt1'>"+t.name+"</p>");
                            if(t.type == 1){
                                arrText.push("<p class='t-des-txt2'>"+t.min_loan+"元以上借款可以使用</p>");
                            }else if(t.type == 2){
                                arrText.push("<p class='t-des-txt2'>"+t.min_loan+"元以上借款,借款天数最少"+ t.min_day+"天</p>");
                            }else if(t.type == 3){
                                arrText.push("<p class='t-des-txt2'>手续费金额满"+t.full_cut+"才可以使用</p>");
                            }
                            arrText.push("<p class='t-des-txt3'>请于"+t.expire_time+"前使用</p>");
                            if(t.img){
                                arrText.push("<img src='"+t.img+"'>");
                            }
                            arrText.push("</div></div></div>");
                            // if(t.status == 2){
                            //     arrText.push("<a href='javascript:;' class='t-expire-tag t-tag-used'></a></div></div>");
                            // }else{
                            //     arrText.push("<a href='javascript:;' class='t-expire-tag'></a></div></div>");
                            // }
                        }
                        $('.t-tab-on').append(arrText.join(''));
                        total = data.total;
                        last_id = data.last_id;
//								$(".load").remove();
                    }
//							else {
//								$(".load").remove();
//								discount.append('<div class="no-data">没有更多数据。</div>');
//								$(window).unbind('scroll');
//							};
                }
            });
        };
        //$(".load").remove();
    }, 200);
});

