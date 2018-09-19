<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type">
    <meta content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache,no-store,must-revalidate">
    <meta http-equiv="Expires" content="0">
    <title>快金打卡</title>
    <?php echo HTML::script('static/js/jquery-1.9.1.min.js');?>
    <?php echo HTML::script('static/js/v2/local/calendar.js');?>
    <?php echo HTML::script('static/js/v2/standard_local.js');?>
    <script>
        var prevSignArr = <?php echo $prevSignArr ?>;
    </script>
    <link rel="stylesheet" href="/static/css/v2/local/calender.css">
    <link rel="stylesheet" href="/static/css/v2/local/punchClock.css">
    <?php echo HTML::script('static/ui_bootstrap/mobile_layer_rem/layer.js'); ?>
    <script>
        //    var total_day =20;
        var total_day = <?php echo isset($total_day)?$total_day:0?>;
    </script>

    <?php echo HTML::script('static/js/v2/local/punchClock.js?1111'); ?>
</head>
<body>
<section  class="circular">
    <?php if($is_login){if($is_checkin_today){?>
        <button   onclick="layerMobile.showlayer('您已经打过卡');layerMobile.changeCssMsg();">已打卡</button>
    <?php }else{?>
        <button   onclick="punchClock();chargeCss();">打卡</button>
    <?php }}else{?>
        <button   onclick="location.href='/Login'">打卡</button>
    <?php }?>

</section>
<section class="dday" style="text-align: center;">
    <?php if($is_login){ ?>
        <span>可兑换天数：<strong><?php echo $total_day; ?></strong>天</span><button onclick="location.href='/Sign/SignCoupon'">兑换</button>
    <?php }else{?>
        <span>可兑换天数：<strong>0</strong>天</span><button onclick="location.href='/Login'">兑换</button>
    <?php }?>
</section>
<section>
    <div class="nav-coupon">
        <span class="float_left gray orange" style="">打卡日历</span>
        <span class="float_right gray" style="">打卡规则</span>
    </div>
</section>
<div style="clear: both;"></div>

<section >
    <div class="switch" id="ca" style="display: -webkit-inline-box;"></div>
    <div class="rilimonth"><?php echo $month;?>月日历</div>
    <section class="switch ddayCssB" style="text-align: lift;display: none;">
        <span>（1）累积打卡7天可兑换10元优惠券一张,借款满500元可用;</span><br />
        <span>（2）累积打卡14天可兑换20元优惠券一张,借款满1000元可用;</span><br />
        <span>（3）累积打卡21天可兑换30元优惠券一张,借款满1500元可用;</span><br />
        <span>（4）满足上述打卡条件即可兑换相应优惠券,兑换后会减掉与其对应的累积天数;</span><br />
        <span>（5）优惠券兑换后有效期为7天(含兑换日),请及时使用。</span>
        <button style="border: none;background: white;color: white;">兑换</button>
    </section>
</section>


<script>
    $('#ca').calendar({
        width: 380,
        height: 320,
        data: [

            {
                date: '2017/12/24',
                value: 'Christmas Eve'
            },
            {
                date: '2017/12/25',
                value: 'Merry Christmas'
            },
            {
                date: '2017/01/01',
                value: 'Happy New Year'
            }
        ],
        onSelected: function (view, date, data) {

            console.log('view:' + view);
//          alert('date:' + date)
            console.log('data:' + (data || 'None'));
        }
    });


    $(".nav-coupon span").click(function(){
        $('.nav-coupon span').removeClass('orange');
        $(this).addClass('orange');
        $(".switch").hide().eq($(this).index()).show();
        if($(this).index()==0){
            $('.rilimonth').show();
        }else{
            $('.rilimonth').hide();
        }
    });
</script>

<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?1dceaa9922352fd2c81930784948dc71";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>

</body>
</html>