;(function($, window, document,undefined) {
    $.fn.tabs = function (options) {
        var settings = {
            tabList: ".Js_tab li",//tab list
            tabContent: ".Js_tab_main",//内容box
            tabOn:"active",//当前tab类名
            action: "click"//事件，mouseover或者click
        };
        var _this = $(this);
        if (options) $.extend(settings, options);
        _this.find(settings.tabContent).eq(0).show(); //第一栏目显示
        _this.find(settings.tabList).eq(0).addClass(settings.tabOn);

        _this.find(settings.tabList).each(function (i) {
                
                $(this).on(settings.action,function(){
                	$(this).addClass(settings.tabOn).siblings().removeClass(settings.tabOn);
                    var _tCon = _this.find(settings.tabContent).eq(i);
                    _tCon.show().siblings(settings.tabContent).hide();
                })
            });

    };
})(jQuery, window, document);