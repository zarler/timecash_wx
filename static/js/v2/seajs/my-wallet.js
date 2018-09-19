/**
 * Created by liujinsheng on 16/9/7.
 */
define(function(require,exports,module){
    //轮播图
    //require('js/slider');
    require('css/v2/local/wallet.css');
    // require('js/v2/local/my-wallet');
    require('ui_bootstrap/mobile_layer_rem/layer');
    $(document).ready(function(){
        $('.wallet_secone .tc_divleft').click(function () {
           // $(".t-tab li").eq($(this).index()).addClass("t-tab-cur").siblings().removeClass('t-tab-cur');
            //$(".section").hide().eq($(this).index()).show();
            $('.wallet_secone .tc_divleft').css('color','black');
            $(this).css('color','#FF6A4D');
            if($(this).index()==0){
                $('.spoke').css('left','10%');
                $('.GainList').show();
                $('.UseList').hide();

            }else{
                $('.spoke').css('left','60%');
                $('.UseList').show();
                $('.GainList').hide();
            }
            $(this).css('');
            // console.log();
        });
    })

});
