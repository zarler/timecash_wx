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