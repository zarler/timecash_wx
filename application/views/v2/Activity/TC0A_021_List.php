<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>元旦有豪礼,500元现金红包抽不停</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no"/>
    <!-- <link href="images/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" /> -->
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-021/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/static/Activity/TC0A-021/css/style.css">
    <script type="text/javascript" src="/static/js/v2/compatibleEqui.js"></script>

</head>
<body class="list-box">
<article>
    <div class="list">
        <i class="list-bg"></i>
        <div class="list-main">
            <h2>获奖名单</h2>

            <?php if(isset($_VArray['resultAtt'])&&Valid::not_empty($_VArray['resultAtt'])){
                foreach ($_VArray['resultAtt'] as $key => $val){
                    echo "<h3><span>1月{$key}日</span></h3><ul>$val</ul>";
                }
            }else{
                echo "<h3 style='margin-top: 6rem;margin-bottom: 12rem;'>暂无获奖数据</h3>";
            }  ?>

        </div>
    </div>
    <img src="/static/Activity/TC0A-021/images/list-bottom.png" class="img">
</article>


</body>
</html>