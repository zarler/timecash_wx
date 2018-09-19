/**
 * Created by liujinsheng on 16/9/7.
 */
define(function(require,exports,module){
    require('lockPhoneBackBtn');
    require('js/slider');
    //新闻轮播
    jQuery("#news_list").jCarouselLite({
        auto:2000,
        speed:2000,
        visible:1,
        vertical:false,
        stop:$("#news_list")});
    function prompt_show(){
        $('.t-mask').show();
        $('#t-bomb_box').show();
    }
    function prompt_hide(){
        $('.t-mask').hide();
        $('#t-bomb_box').hide();
    }
});
