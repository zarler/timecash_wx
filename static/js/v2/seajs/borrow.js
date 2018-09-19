/**
 * Created by liujinsheng on 16/9/7.
 */
define(function(require,exports,module){
    require('lockPhoneBackBtn');
    require('css/rangeslider.css');
    require('js/v2/local/borrow');
    // require('js/v2/online/borrow');
    require('js/v2/local/borrowforms');
    // require('js/v2/online/borrowforms');
        var wx = require('https://res.wx.qq.com/open/js/jweixin-1.0.0.js?121113');
        wx.config({
            debug: false,
            appId: seajs.data.vars.appId,
            timestamp:seajs.data.vars.timestamp,
            nonceStr:seajs.data.vars.nonceStr,
            signature:seajs.data.vars.signature,
            jsApiList: [
                'getLocation'
            ]
        });
        wx.ready(function(){
            wx.getLocation({
                type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
                success: function (res){
                    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                    $("input[name='longitude']").val(longitude);
                    $("input[name='latitude']").val(latitude);
                },
                cancel: function (res) {
                    alert('用户拒绝授权获取地理位置');
                }
            });
        });
});
