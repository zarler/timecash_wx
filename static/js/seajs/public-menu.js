/**
 * Created by liujinsheng on 16/9/7.
 */
define(function(require,exports,module){
    //新闻轮播
    var url = location.pathname;//alert(url);
    if(url == '/' || url == '/User/index'){
        $('.m-nav li:eq(0)').addClass('checked');
    }else if(url == '/Account/index'){
        $('.m-nav li:eq(2)').addClass('checked');
    }
});