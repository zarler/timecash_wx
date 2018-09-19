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
<body class="list-box">
<article>
    <div class="box2 list">
        <i class="box2-top"></i>
        <i class="box2-bottom"></i>
        <h2>获奖名单展示区</h2>
        <?php if(isset($_VArray['resultAtt'])&&Valid::not_empty($_VArray['resultAtt'])){
            foreach ($_VArray['resultAtt'] as $key => $val){
                echo "<h3><span>12月{$key}日</span></h3><ul>$val</ul>";
            }
        }else{
            echo "<h3>暂无获奖数据f</h3>";
        }  ?>
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