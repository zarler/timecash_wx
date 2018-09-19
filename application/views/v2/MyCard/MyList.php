<?php include Kohana::find_file('views','v2/public/head');?>
<script>
    seajs.config({
        vars: {
            'url':'<?php echo isset($_VArray['url'])?$_VArray['url']:null ?>',
            'orderIdA':'<?php echo isset($_VArray['lastIdA'])?$_VArray['lastIdA']:0 ?>',
            'orderIdH':<?php echo isset($_VArray['lastIdH'])?$_VArray['lastIdH']:0 ?>
        },
        map:[
            [".js",".js?v="+version],
            [".css",".css?v="+version]
        ]
    });
    seajs.use('js/v2/seajs/mycard');
</script>
<body>
<!-- 头信息 -->
<section class="t-login-nav">
    <div class='t-login-nav-1'>
        <?php if(!isset($_VArray['back'])){ ?><a class="return_i i_public" href="<?php echo URL::site('User/index?#jump=no');?>"></a><?php } ?>我的快审卡
    </div>
</section>
<!-- 头信息end -->
<div class="top_height"></div>
<ul class="cardul border-bottom">
    <li class="fontcolor">可使用</li>
    <li>历史记录</li>
</ul>
    <section class="section Available">
        <?php if(count($_VArray['MyListAvailable'])>=1){ foreach ($_VArray['MyListAvailable'] as $key=>$val){?>
            <div class="credit_delete_a">
                <section class="list-s">
                    <div class='t-mycard-list' >
                        <div  class='border-bottom list-top'>
                            <i style="background: "></i>
                            <strong><?php echo $val['status_title'] ?></strong>
                        </div>
                        <p class='t-select2'>
                            <label style=''><?php echo $val['amount']  ?>元</label>
                            <label style='float: right'>有效期360天</label>
                        </p>
                    </div>
                </section>
            </div>
        <?php }}else{ ?>
<!--            <section class="list-s"><div class='t-mycard-list' ><div  class='border-bottom list-top'><i style="background: "></i><strong>购买失败</strong></div><p class='t-select2'><label style='color: red'>249元</label><label style='float: right'>有效期至2018-12-12</label></p></div></section>-->
            <!---->
            <!--            <section class="list-s">-->
            <!--                <div class='t-mycard-list' >-->
            <!--                    <div  class='border-bottom list-top'>-->
            <!--                        <i style="background: "></i>-->
            <!--                        <strong>购买失败</strong>-->
            <!--                    </div>-->
            <!--                    <p class='t-select2'>-->
            <!--                        <label style='color: red'>249元</label>-->
            <!--                        <label style='float: right'>有效期至2018-12-12</label>-->
            <!--                    </p>-->
            <!--                </div>-->
            <!--            </section>-->
            <div style="text-align: center;line-height:40">
                <?php echo HTML::image('static/images/v2/icon_meiyoujuancard.png',array('style'=>'width:4rem;'));?>
            </div>
        <?php } ?>
    </section>
    <?php if(isset($_VArray['CountA'])&&$_VArray['CountA']>=5){ ?>
        <p class="pmore" onclick="getMore()" style="margin-top: 1.7rem;text-align: center;color: grey;height: 1.4rem;line-height: 1.4rem">加载更多</p>
    <?php } ?>

<section class="section History display_none t-tab-on">
    <?php if(count($_VArray['MyListHistory'])>=1){ foreach ($_VArray['MyListHistory'] as $key=>$val){?>
                <section class="list-s">
                    <div class='t-mycard-list t-mycard-list-bs' >
                        <div  class='border-bottom list-top-o '>
                            <i style="background: "></i>
                            <strong><?php echo $val['status_title']  ?></strong>
                        </div>
                        <p class='t-select2'>
                            <label style=''><?php echo $val['amount']  ?>元</label>
                            <label style='float: right'>有效期至<?php echo $val['expire_time']  ?></label>
                        </p>
                    </div>
                </section>
<!--        <div class="credit_delete_a">-->
<!--            <section class="list-s">-->
<!--                <div class='t-mycard-list' >-->
<!--                    <div  class='border-bottom list-top'>-->
<!--                        <i style="background: "></i>-->
<!--                        <strong>--><?php //echo $val['status_title'] ?><!--</strong>-->
<!--                    </div>-->
<!--                    <p class='t-select2'>-->
<!--                        <label style=''>--><?php //echo $val['amount']  ?><!--元</label>-->
<!--                        <label style='float: right'>有效期360天</label>-->
<!--                    </p>-->
<!--                </div>-->
<!--            </section>-->
<!--        </div>-->


    <?php }}else{ ?>

<!---->
<!--        <section class="list-s">-->
<!--            <div class='t-mycard-list t-mycard-list-bs' >-->
<!--                <div  class='border-bottom list-top-o'>-->
<!--                    <i style="background: "></i>-->
<!--                    <strong>购买失败</strong>-->
<!--                </div>-->
<!--                <p class='t-select2'>-->
<!--                    <label style=''>249元</label>-->
<!--                    <label style='float: right'>有效期至2018-12-12</label>-->
<!--                </p>-->
<!--            </div>-->
<!--        </section>-->
        <div style="text-align: center;line-height:40">
            <?php echo HTML::image('static/images/v2/icon_meiyoujuancard.png',array('style'=>'width:4rem;'));?>
        </div>
    <?php } ?>
</section>
<?php if(isset($_VArray['CountH'])&&$_VArray['CountH']>=5){ ?>
    <p class="pmore display_none" onclick="getMore()" style="margin-top: 1.7rem;text-align: center;color: grey;height: 1.4rem;line-height: 1.4rem">加载更多</p>
<?php } ?>


<div class="t-box_alert" id="t-box_alert" style="display: none;">
    <div class="t-bomb_box" id="t-bomb_box">
        <h3 class="t-bomb_box-1 t-title border-bottom">使用规则<a href="javascript:;" class="t-close-btn"></a> </h3>
        <ul class="t-rules-item">
            <li class="clear"></li>
            <li><span>•</span><p>用户在借款达到一定额度时,可以使用符合借款额度的优惠券,按面值抵扣借款手续费</p></li>
            <li><span>•</span><p>每一笔借款只能使用1张优惠券</p></li>
            <li><span>•</span><p>优惠券有效期过期后不可再使用</p></li>
            <li><span>•</span><p>每张优惠券不可重复使用,不可找零或兑现</p></li>
        </ul>
    </div>
</div>
<div class="t-mask" style="display: none"></div>
</body>
</html>
