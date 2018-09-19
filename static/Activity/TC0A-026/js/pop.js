
//判断是ios终端 才执行这个下面的FIXED
var u = navigator.userAgent;
var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
var scrollh = 0;
if(isiOS){
    $(".activity-pop-form input").focus(function(e){
        $(".activity-layer.timecash .activity-pop").css({"position":"relative","margin-top":"-60px"});
        scrollh=$(window).scrollTop();
        $("body").scrollTop(0);
        $("body").css("overflow","hidden");
        $('body').bind("touchmove",function(e){
            e.preventDefault();
        });
    });

    $(".activity-pop-form input").blur(function(e){
        $(".activity-layer.timecash .activity-pop").removeAttr("style");
        $("body").css("overflow","auto");
        $('body').bind("touchmove",function(e){
            $("body").unbind("touchmove");
        });
        $("body").scrollTop(scrollh);
    });
}
// pop
var evclick = "ontouchend" in window ? "touchend" : "click";
// 显示弹窗
$(document).on(evclick, '[data-layer]',function(event){
    event.stopPropagation();
    var $this = $(this);
    var target = $this.attr("data-layer");
    var $target = $("."+target);
    $target.show();
    //禁止鼠标穿透底层
    $target.removeClass("pointer-auto").addClass("pointer-none");
    setTimeout(function(){
        $target.removeClass("pointer-none").addClass("pointer-auto");
    }, 400);
})

$(document).on('click', '[data-toggle="mask"]', function (event) {
    event.stopPropagation();
    // event.preventDefault();
    var target = $(this).attr("data-target");
    var $target = $("."+target);
    $target.hide();
    //禁止鼠标穿透底层
    $('[data-touch="false"]').removeClass("pointer-auto").addClass("pointer-none");
    setTimeout(function(){
        $('[data-touch="false"]').removeClass("pointer-none").addClass("pointer-auto");
        $('#bonus-recevie-status').attr('attr-bonus-status','open');
    }, 400);
})

