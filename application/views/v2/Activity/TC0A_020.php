<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>圣诞好礼属于你，OPPO手机带回家</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <!-- <link href="images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" /> -->
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-020/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-020/css/style.css">
    <script type="text/javascript" src="/static/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/static/js/v2/compatibleEqui.js"></script>
</head>
<body>
<article>
    <img src="/static/Activity/TC0A-020/images/banner.png" class="img">
    <img src="/static/Activity/TC0A-020/images/prize.png" class="img">
    <div class="box rule">
        <i class="box-top"></i>
        <i class="box-bottom"></i>
        <h2>活动规则</h2>
        <p>1.活动时间：2017.12.23-2017.12.25;</p>
        <p>2.活动期间，快金会在每天主动成功还款的用户中随机抽出10名幸运用户，获得快金圣诞好礼;</p>
        <p>3.当天获奖的用户名单会在第二天上午10点活动页面公布;</p>
        <p>4.所有获奖用户都会收到快金发送的获奖短信通知，获得一等奖OPPO手机和三等奖圣诞坚果大礼包的用户，收到短信后，请在2个工作日内把您的收件人、收件地址、以及收件人电话短信回复给快金，活动结束后的3个工作日内我们将会把奖品寄出;</p>
        <p>5.获得京东购物卡的用户请在2个工作日内短信回复<strong>“圣诞好礼”</strong>，活动结束的后的3个工作日内，我们会将购物卡的电子版兑换信息发送到您的手机;</p>
        <p>6.请获奖用户注意查收获奖短信，若未收到短信，可联系快金人工客服进行咨询010-56592060;</p>
        <p>7.如获奖用户未在规定时间内回复相关信息，将视为主动放弃此次活动获得的奖励及相关权益;</p>
        <p>8.本活动奖品只为回馈快金用户，奖品请以收到实物为准（图片仅供参考），本奖品不得折现或其他;</p>
        <p>9.本活动在法律允许范围内最终解释权归快金所有。</p>
    </div>
    <div class="box list">
        <i class="box-top"></i>
        <i class="box-bottom"></i>
        <h2>获奖名单展示区</h2>

        <?php if(isset($_VArray['resultAtt'])&&Valid::not_empty($_VArray['resultAtt'])){
            foreach ($_VArray['resultAtt'] as $key => $val){
                echo "<h3><span>12月{$key}日</span></h3><ul>$val</ul>";
            }
            echo "<a class='btn' href='{$_VArray['reqUrl']}'>查看全部</a>";
        }else{
            echo "<h3>暂无获奖数据</h3><div style='height: 1.5rem'></div>";
        }  ?>

<!--        <h3><span>12月22日</span></h3>-->
<!--        <ul>-->
<!--            <li><span>恭喜185****8721</span><span>获得OPPOR11S一部</span></li>-->
<!--            <li><span>恭喜185****8721</span><span>获得OPPOR11S一部</span></li>-->
<!--            <li><span>恭喜185****8721</span><span>获得京东电子购物卡一张</span></li>-->
<!--            <li><span>恭喜185****8721</span><span>获得OPPOR11S一部</span></li>-->
<!--            <li><span>恭喜185****8721</span><span>获得良品铺子坚果大礼包一包</span></li>-->
<!--        </ul>-->



    </div>
</article>
<script type="text/javascript">
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
            $("div[data-modul="+target+"]").layer();
        });
    })

</script>
</body>
</html>