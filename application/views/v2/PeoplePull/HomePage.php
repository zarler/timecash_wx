<?php include Kohana::find_file('views', 'v2/public/newHead');?>
<script>
    <?php if(isset($_VArray['type'])&&$_VArray['type']==1){ ?>
        seajs.config({
            vars: {
                'type':'<?php echo isset($_VArray['type'])?$_VArray['type']:0; ?>',
                'client':'<?php echo isset($_VArray['client'])?$_VArray['client']:''; ?>',
                'sharetitle':'<?php echo $_VArray['sharetitle']; ?>',
                'islogin':'<?php echo empty($_VArray['islogin'])?0:1 ?>',
                'text':'<?php echo $_VArray['text'] ?>',
                'url':'<?php echo $_VArray['url'] ?>',
                'img_url':'<?php echo $_VArray['img_url'] ?>',
                'appId':'<?php echo isset($_VArray['signPackage']["appId"])?$_VArray['signPackage']["appId"]:0;?>',
                'timestamp':'<?php echo isset($_VArray['signPackage']["timestamp"])?$_VArray['signPackage']["timestamp"]:0;?>',
                'nonceStr':'<?php echo isset($_VArray['signPackage']["nonceStr"])?$_VArray['signPackage']["nonceStr"]:0;?>',
                'signature':'<?php echo isset($_VArray['signPackage']["signature"])?$_VArray['signPackage']["signature"]:0;?>',
                'reqUrls':'<?php echo $_VArray['reqUrls'] ?>',
                'shareUrls':'<?php echo $_VArray['shareUrls'] ?>',
            }
        });
    <?php }else{ ?>
        seajs.config({
            vars: {
                'client':'<?php echo isset($_VArray['client'])?$_VArray['client']:''; ?>',
                'islogin':'<?php echo empty($_VArray['islogin'])?0:1 ?>',
                'sharetitle':'<?php echo isset($_VArray['sharetitle'])?$_VArray['sharetitle']:''; ?>',
                'text':'<?php echo isset($_VArray['text'])?$_VArray['text']:''; ?>',
                'url':'<?php echo isset($_VArray['url'])?$_VArray['url']:'';?>',
                'img_url':'<?php echo isset($_VArray['img_url'])?$_VArray['img_url']:''; ?>',
                'reqUrls':'<?php echo isset($_VArray['reqUrls'])?$_VArray['reqUrls']:''; ?>',
            }
        });
    <?php }?>
    seajs.use('js/v2/seajs/peoplepull');
</script>
<body>
<div class="loading_ok" style="display: none">
<section  class="circular">
    <img src="/static/images/v2/peoplepull/007.png" width="56%"/>
    <img src="/static/images/v2/peoplepull/008.png" width="56%" style="margin-bottom: 3rem;"/>
    <div class="peoplepull_two">
			<span style="float: left;margin-left: 9%;">
				<label>已邀好友</label><img src="/static/images/v2/peoplepull/006.png" >
				<div style="clear: both;"></div>
				<p><strong><?php echo $_VArray['inviter']; ?></strong>人</p>
			</span>
			<span style="float: right;margin-right: 9%;">
				<label>已赚现金</label><img src="/static/images/v2/peoplepull/005.png" >
				<div style="clear: both;"></div>
				<p><strong><?php echo $_VArray['cash']; ?></strong>元</p>
			</span>
    </div>
</section>
<div style="clear: both;"></div>
<!--<section class="peopel_button"><a href="/?jump=BannerUserLogin">我要去赚钱</a></section>-->
<section class="peopel_button"><a href="<?php echo $_VArray['urlSubmit']; ?>">我要去赚钱</a></section>
<img src="/static/images/v2/peoplepull/010.png" style="width: .8rem;float: right;margin-right: .6rem;position: relative;top: -.4rem;" >
<div style="clear: both;"></div>
<div class="peopel_three">
    <div class="topdiv">
        <span class="leftspan fontcolor"><img src="/static/images/v2/peoplepull/002.png" style="width:1.3rem;float: left;margin-top:0.45rem ;">邀请记录</span>
        <span class="rightspan">赚钱秘籍<img src="/static/images/v2/peoplepull/010.png" style="width:.5rem;float: right;margin:0.45rem .4rem;"></span>
    </div>
    <div class="left-div">
        <ul>
            <li>我的好友</li>
            <li>好友状态</li>
            <li>我的奖励</li>
        </ul>
        <?php echo $_VArray['listData']; ?>
    </div>
    <div class="right-div" style="margin-top: .3rem; ">
        <div class="p_notice">
            1.点击“我要去赚钱”将活动页面分享给微信好友或分享到朋友圈，好友点击进入活动页面即可领取100元新客专享大礼包。<br>
            2.领券好友必须未注册过快金账号或注册后未在快金平台产生过极速贷借款订单。<br>
            3.未注册过快金帐号的好友完成首笔极速贷借款，邀请人可获得20元现金奖励；注册后未在快金平台产生极速贷借款订单的用户完成首笔极速贷借款，邀请人可获得10元现金奖励，自身原因不可借款的好友无效。<br>
            4.优惠券有效期为到账后30个自然日。<br>
            5.好友借款后扫描页面二维码关注快金服务号，邀请人还可获得1元现金奖励，好友关注微信现金奖每月限前30名有效，重复关注无效。<br>
            6.活动最终解释权归快金所有。<br>
        </div>
    </div>
</div>
<footer><img src="/static/images/v2/peoplepull/009.png" width="100%" /></footer>
    </div>
</body>
</html>
<script type="text/javascript">

    function clickSubmit() {
        $.ajax({
            url: seajs.data.vars.reqUrls,
            type: 'POST',
            //data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
            data:{action:'click',event_name:'TCOA_007'},
            dataType: 'json',
            async: true,  //同步发送请求t-mask
            beforeSend: function () {
            },
            success: function (result) {
            },
            error: function () {

            }
        });
    }

    function sendToAndroid() {
        clickSubmit();
        if (seajs.data.vars.client == 'android') {
//            alert(seajs.data.vars.url);
            window.android.sharingFriends('<?php echo $_VArray['sharetitle']; ?>', '<?php echo $_VArray['text']; ?>', '<?php echo $_VArray['img_url']; ?>', '<?php echo $_VArray['url']; ?>','21');
//            window.android.sharingFriends(seajs.data.vars.sharetitle, seajs.data.vars.text, seajs.data.vars.img_url, seajs.data.vars.url,'21');
        }else if(seajs.data.vars.client == 'ios')
        {
            sharingFriends('<?php echo $_VArray['sharetitle']; ?>', '<?php echo $_VArray['text']; ?>', '<?php echo $_VArray['img_url']; ?>', '<?php echo $_VArray['url']; ?>','21');
        }
    }

    //分享成功

    function shareAjax() {
        $.ajax({
            url:seajs.data.vars.shareUrls,
            type:'POST',
            data:{action:'show',event_name:'TCOA_007',time:0},
            dataType:'json',
            async: true,
            beforeSend:function(){
            },
            success:function(result){
            },
            error:function(){
            }
        });
    }
</script>