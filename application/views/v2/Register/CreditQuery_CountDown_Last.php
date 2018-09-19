
<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
    seajs.use('js/v2/seajs/CreditQuery');
</script>
<body>
<!-- 头信息 -->
<section class="t-login-nav">
    <div class='t-login-nav-1'>
        <a href="javascript:clickback();" class="return_i i_public"></a>等待审核
    </div>
</section>
<div class="top_height"></div>


<!-- 代码部分begin -->
<div id="js-alert-box" class="alert-box">
    <svg class="alert-circle" width="234" height="234">
        <circle cx="117" cy="117" r="108" fill="#FFF" stroke="#ff8470" stroke-width="17"></circle>
        <circle id="js-sec-circle" class="alert-sec-circle" cx="117" cy="117" r="108" fill="transparent" stroke="#BDBDBD" stroke-width="18" transform="rotate(-90 117 117)"></circle>
        <text class="alert-sec-unit" x="82" y="172" fill="#BDBDBD">Seconds</text>
    </svg>
    <div id="js-sec-text" class="alert-sec-text"></div>
    <div class="alert-body">
        <div id="js-alert-head" class="alert-head"></div>
    </div>
    <script>
        function alertSet(e) {
            document.getElementById("js-alert-box").style.display = "block";
             document.getElementById("js-alert-head").innerHTML = e;
            var t = c = <?php echo $_VArray['time']; ?>,
                n = document.getElementById("js-sec-circle"),
//                v = Math.round(t-60),
                v = Math.round(t-2),
                p = 0;
            
                document.getElementById("js-sec-text").innerHTML = t;
                var timeSet = setInterval(function() {
                        if (0 == t){
                            if(c==180){
                                location.href="/app/CreditFlow/CreditQuery_CountDown_Result?jump=overtime_3"+"<?php if(isset($_VArray['tc_no'])){echo "&&tc_no={$_VArray['tc_no']}";}if(isset($_VArray['outUniqueId'])){echo "&&outUniqueId={$_VArray['outUniqueId']}";}?>";//#时间到后跳转超时地址
                            }else{
                                location.href="/app/CreditFlow/CreditQuery_CountDown_Result?jump=overtime_2";//#时间到后跳转超时地址
                            }
                        }else {
                            t -= 1,
                                document.getElementById("js-sec-text").innerHTML = t;
                            var e = Math.round(t / c * 735);
                            n.style.strokeDashoffset = e - 735
                            var k = t%15;


                            if(t<v){
                                if(k==0){
                                    if(c==120){
                                        var varPost = 'Count';
                                        p =p+1;
                                    }else{
                                        var varPost = 'noCount';
                                    }
                                    //每隔五秒请求一次
                                    $.ajax({
                                        url:'<?php echo $_VArray['requestUrl'];?>',
                                        type:'POST',
                                        data:{one:'one',varPost:varPost,p:p,
                                            <?php
                                                if(isset($_VArray['tc_no'])){
                                                    echo 'tc_no:\''."{$_VArray['tc_no']}"."'";
                                                }
                                                if(isset($_VArray['outUniqueId'])){
                                                    echo 'outUniqueId:\''."{$_VArray['outUniqueId']}"."'";
                                                }
                                             ?>
                                        },
                                        //data:{comname:comname,comaddress:comaddress,comdetailaddre:comdetailaddre,comtell:comtell,address:address,detailaddress:detailaddress,numbertell:numbertell},
                                        dataType:'json',
                                        async: true,  //同步发送请求t-mask
                                        beforeSend:function(){
                                        },
                                        success:function(result){
                                            console.log(result.msg);
                                            if(result.status == true){
                                                //分情况
                                                switch (result.msg){
                                                    case 'processing':case 'back':
                                                    //不管
                                                    return  false;
                                                    break;
                                                    case 'unknown':
                                                        return  false;
//                                                        location.href = '<?php //echo $_VArray['requestjump']; ?>//'+'?jump=unknown';
                                                        break;
                                                    case 'pass':
//                                                        location.href = '<?php //echo $_VArray['requestjump']; ?>//'+'?jump=pass';
                                                        location.href = '/?#jump=yes';
                                                        break;
                                                    default:

                                                        break;
                                                }
                                            }else{
                                                clearInterval(timeSet);
                                                layer.alert(result.msg, {
                                                    skin: 'layui-layer-molv' //样式类名
                                                    ,closeBtn: 0
                                                }, function(){
                                                    location.href = '/?#jump=no';
                                                });
                                                return  false;
                                            }
                                        },
                                        error:function(){
//                                        commonUtil.unlock();
//                                        commonUtil.tips("表单校验失败");
                                            return false;
                                        }
                                    });
                                }
                            }
                        }
                    },
                    970);
        }
        alertSet('<?php echo $_VArray['content'];?>');
        function clickback() {
            var showLayer = layer.confirm('您若选择返回,则需要重新进行运营商授权流程,且最多重试3次。建议耐心等待审核结果？', {
                btn: ['确定返回','取消'] //按钮
            }, function(){
                location.href = '/?#jump=no';
            }, function(){
                layer.close(showLayer);
            });
            $('.layui-layer-dialog').css({'left':'5%','right':'5%'});
        }
    </script>
    <!-- 代码部分end -->
</body>
</html>