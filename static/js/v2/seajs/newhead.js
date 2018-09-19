/**
 * Created by liujinsheng on 16/9/7.
 */
define(function(require,exports,module){
    require('css/v2/local/m-rem-cash.css');
    require('js/v2/common_layer_mobile');
    // require('css/public.css');
    // require('js/v2/common');
    // require('js/v2/common-min');
    $(document).ready(function(){
        // layer.close(startload);
        $('.t-mask-loading').hide();
        $('.loading_ok').fadeIn('slow');
    });
});
