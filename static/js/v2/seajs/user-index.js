/**
 * Created by liujinsheng on 16/9/7.
 */
define(function(require,exports,module){
    require('lockPhoneBackBtn');
    //提示框
    require('ui_bootstrap/bomb/bomb_screen');
    //cookie扩展
    require('js/jquery.cookie');
    //轮播图
    require('ui_bootstrap/lunbo/jquery.touchSlider');
    require('css/v2/style.css?123');
    //轮播图
    //require('js/slider');
    require('css/v2/local/menu.css');
    require('css/swiper.css');
    // require('css/v2/local/rangeslider.css');
    //动画
    require('js/swiper');
    //新闻轮播
    // jQuery("#news_list").jCarouselLite({
    //     auto:2000,
    //     speed:2000,
    //     visible:1,
    //     vertical:false,
    //     stop:$("#news_list")});


    function prompt_show(){
        $('.t-mask').show();
        $('#t-bomb_box').show();
    }
    function prompt_hide(){
        $('.t-mask').hide();
        $('#t-bomb_box').hide();
    }
    $(document).ready(function(){
        if(seajs.data.vars.userId == 2){
            if(commonUtil.isnull($.cookie('newpeople'))==true){
            }else{
                $.cookie('newpeople','1',{expires: 365,path:'/'});
                bomob_screen.firstready();
                bomob_screen.newpeople(true,'/Login');
                $('#bomb_close').bind('click',function(){
                    bomob_screen.bomobremove();
                });
            }
        }

        // $(".main_visual").hover(function(){
        //     $("#btn_prev,#btn_next").fadeIn()
        // },function(){
        //     $("#btn_prev,#btn_next").fadeOut()
        // });
        $dragBln = false;
        //左移动
        var num = 0;
        $(".main_image").touchSlider({
            flexible : true,
            speed : 200,
            btn_prev : $("#btn_prev"),
            btn_next : $("#btn_next"),
            paging : $(".flicking_con a"),
            counter : function (e){
                $(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
            }
        });
        $(".main_image").bind("mousedown", function() {
            $dragBln = false;
        });
        $(".main_image").bind("dragstart", function() {
            $dragBln = true;
        });
        $(".main_image a").click(function(){
            if($dragBln) {
                return false;
            }
        });
        timer = setInterval(function(){
            $("#btn_next").click();
        }, 3000);

        $(".main_visual").hover(function(){
            clearInterval(timer);
        },function(){
            timer = setInterval(function(){
                $("#btn_next").click();
            },3000);
        });

        $(".main_image").bind("touchstart",function(){
            clearInterval(timer);
        }).bind("touchend", function(){
            timer = setInterval(function(){
                $("#btn_next").click();
            }, 3000);
        });








    });
});
function btn_next(){

    console.log(111111);
}