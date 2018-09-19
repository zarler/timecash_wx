$(function(){


    //弹窗关闭隐藏
    $(document).on('touchend', '[data-toggle="mask"]', function (event) {
        event.stopPropagation();
        var target = $(this).attr("data-target");
        $("."+target).hide();

    });

    // 弹窗调用
    $(document).on('touchend', 'a[data-target]',function(event){
        event.stopPropagation();
        var target = $(this).attr("data-target");
        $("div[data-module="+target+"]").show();
    });
})