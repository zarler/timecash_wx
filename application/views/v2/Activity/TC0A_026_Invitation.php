<?php include Kohana::find_file('views', 'v2/public/activityHeadNoRem');?>
<script>
    seajs.config({
        vars: {
            inviterUserId:'<?php echo isset($_VArray['inviterUserId'])?$_VArray['inviterUserId']:''; ?>',
            reqUrl:'<?php echo isset($_VArray['reqUrl'])?$_VArray['reqUrl']:''; ?>',
            codeurl:'<?php echo isset($_VArray['codeurl'])?$_VArray['codeurl']:''; ?>',
            repayurl:'<?php echo isset($_VArray['repayurl'])?$_VArray['repayurl']:''; ?>',
            couponsurl:'<?php echo isset($_VArray['couponsurl'])?$_VArray['couponsurl']:''; ?>',
            homeUrl:'<?php echo isset($_VArray['homeUrl'])?$_VArray['homeUrl']:''; ?>',
        }
    });
    seajs.use('js/v2/seajs/act_026_BeInvited');
</script>
<body>
<div class="activity-banner">
    <p class="activity-rule" data-layer="rule">活动规则</p>
    <div class="activity-text"><?php echo $_VArray['have_draw']; ?></div>
    <div id="outercont" data-touch="false">
        <div id="outer-cont">
            <div id="outer"><img onclick="return false" src="/static/Activity/TC0A-026/images2/activity-lottery-1.png"></div>
        </div>
        <div id="inner-cont">
            <div   id="inner"><img  onclick="<?php echo $_VArray['subMit'] ?>"  src="/static/Activity/TC0A-026/images2/activity-lottery-2.png"></div>
        </div>
    </div>
</div>
<div class="activity-box">
    <div class="activity-bg">
        <dl>
            <dd>
                <p>7天免息券</p>
                <p>（无门槛）</p>
            </dd>
            <dt onclick="<?php echo $_VArray['UrlFree']  ?>"></dt>
        </dl>
        <p class="activity-text1"><span>注册</span><span>抽奖</span><span>领券</span></p>
    </div>
</div>

<div class="activity-btn">
    <a href="/h5/Activity/TCOA026">邀请好友</a> <a href="/Promotion/">下载APP</a>
</div>

<div class="activity-title"></div>
<div class="activity-box1">
    <dl>
        <dt></dt>
        <dd>
            <h5>无抵押，无担保</h5>
            <p>全线上借款、无需担保抵押</p>
        </dd>
    </dl>
    <dl>
        <dt></dt>
        <dd>
            <h5>1分钟借款，闪电审核</h5>
            <p>1分钟注册、快速审核、30秒到账</p>
        </dd>
    </dl>
    <dl>
        <dt></dt>
        <dd>
            <h5>超低利息，无手续费</h5>
            <p>低息借款、还款自由</p>
        </dd>
    </dl>
</div>

<div class="activity-bottom">
    <span></span>
</div>

<!-- 弹窗 -->
<!-- 去注册 -->
<div class="activity-layer register">
    <div class="activity-mask"></div>
    <div class="activity-pop">
        <div class="activity-pop-pos"></div>
        <a href="javascript:;" class="activity-pop-close" data-toggle="mask" data-target="register">close</a>
        <div class="activity-pop-content">
            <p class="activity-pop-text">您还没有注册哦~ 请先注册账号！</p>
            <div class="activity-pop-btn-wrap">
                <a href="javascript:;" class="activity-pop-btn" data-layer="timecash">去注册</a>
            </div>
        </div>
    </div>
</div>
<!-- 下载app -->
<div class="activity-layer download">
    <div class="activity-mask"></div>
    <div class="activity-pop">
        <div class="activity-pop-pos"></div>
        <a href="javascript:;" class="activity-pop-close" data-toggle="mask" data-target="download">close</a>
        <div class="activity-pop-content">
            <p class="activity-pop-text">您已领取免息券<br>快去下载app使用吧!</p>
            <div class="activity-pop-btn-wrap">
                <a href="/Promotion/" class="activity-pop-btn">下载APP</a>
            </div>
        </div>
    </div>
</div>
<!-- 邀请好友 -->
<div class="activity-layer invest">
    <div class="activity-mask"></div>
    <div class="activity-pop">
        <div class="activity-pop-pos"></div>
        <a href="javascript:;" class="activity-pop-close" data-toggle="mask" data-target="invest">close</a>
        <div class="activity-pop-content">
            <p class="activity-pop-text">您已经是我们的老用户了！<br>邀请好友可得<br>7天免息券和现金奖励哦~</p>
            <div class="activity-pop-btn-wrap">
                <a href="/h5/Activity/TCOA026" class="activity-pop-btn">邀请好友</a>
                <a href="/Promotion/" class="activity-pop-btn">下载APP</a>
            </div>
        </div>
    </div>
</div>
<!-- 限新用户 -->
<div class="activity-layer user">
    <div class="activity-mask"></div>
    <div class="activity-pop">
        <div class="activity-pop-pos"></div>
        <a href="javascript:;" class="activity-pop-close" data-toggle="mask" data-target="user">close</a>
        <div class="activity-pop-content">
            <p class="activity-pop-text">活动仅限新用户，您已经是<br>我们的老用户了！邀请好友可得<br>7天免息券和现金奖励哦~</p>
            <div class="activity-pop-btn-wrap">
                <a href="/h5/Activity/TCOA026" class="activity-pop-btn">邀请好友</a>
                <a href="/Promotion/" class="activity-pop-btn">下载APP</a>
            </div>
        </div>
    </div>
</div>
<!-- 抽中现金红包 -->
<div class="activity-layer luckmoney">
    <div class="activity-mask"></div>
    <div class="activity-pop">
        <div class="activity-pop-pos"></div>
        <a href="javascript:;" class="activity-pop-close" data-toggle="mask" data-target="luckmoney">close</a>
        <div class="activity-pop-content">
            <h6>恭喜您!</h6>
            <p class="activity-pop-text1">抽中<span>88元现金红包</span></p>
            <div class="activity-pop-draw-luckmoney"><p><em>88</em><span>元</span></p></div>
            <div class="activity-pop-tip">
                <p>温馨提示：</p>
                <p><span>1、</span>实物礼品将在活动结束后统一发放</p>
                <p><span>2、</span>现金红包请下载快金app进行提现<br>“个人—我的钱包—余额提现”</p>
                <p><span>3、</span>免息券仅用于快金平台，不兑现~</p>
            </div>
            <div class="activity-pop-btn-wrap">
                <a href="javascript:$('.luckmoney').hide();" class="activity-pop-btn">好的</a>
            </div>
        </div>
    </div>
</div>
<!-- 抽中优惠券 -->
<div class="activity-layer coupon">
    <div class="activity-mask"></div>
    <div class="activity-pop">
        <div class="activity-pop-pos"></div>
        <a href="javascript:;" class="activity-pop-close" data-toggle="mask" data-target="coupon">close</a>
        <div class="activity-pop-content">
            <h6>恭喜您!</h6>
            <p class="activity-pop-text1">抽中<span>20元免息券</span></p>
            <img src="/static/Activity/TC0A-026/images2/activity-pop-coupon.png" alt="免息券" class="activity-pop-draw-coupon">
            <div class="activity-pop-tip">
                <p>温馨提示：</p>
                <p><span>1、</span>实物礼品将在活动结束后统一发放</p>
                <p><span>2、</span>现金红包请下载快金app进行提现<br>“个人—我的钱包—余额提现”</p>
                <p><span>3、</span>免息券仅用于借款，不兑现~</p>
            </div>
            <div class="activity-pop-btn-wrap">
                <a href="javascript:$('.coupon').hide();" class="activity-pop-btn">好的</a>
            </div>
        </div>
    </div>
</div>
<!-- 领取优惠券成功 -->
<div class="activity-layer couponSuccess">
    <div class="activity-mask"></div>
    <div class="activity-pop">
        <div class="activity-pop-pos"></div>
        <a href="javascript:;" class="activity-pop-close" data-toggle="mask" data-target="couponSuccess">close</a>
        <div class="activity-pop-content">
            <h5>领取成功!</h5>
            <p class="activity-pop-text2">快点下载快金app使用免息券吧~</p>
            <div class="activity-pop-btn-wrap">
                <a href="javascript:;" class="activity-pop-btn" data-toggle="mask" data-target="couponSuccess">确定</a>
            </div>
        </div>
    </div>
</div>
<!-- 领取红包成功 -->
<div class="activity-layer luckmoneySuccess">
    <div class="activity-mask"></div>
    <div class="activity-pop">
        <div class="activity-pop-pos"></div>
        <a href="javascript:;" class="activity-pop-close" data-toggle="mask" data-target="luckmoneySuccess">close</a>
        <div class="activity-pop-content">
            <h5>领取成功!</h5>
            <div class="activity-pop-tip">
                <p>温馨提示：</p>
                <p><span>1、</span>实物礼品将在活动结束后统一发放</p>
                <p><span>2、</span>现金红包请下载快金平台进行提现<br>“个人—我的钱包—余额提现”</p>
                <p><span>3、</span>快点下载快金app使用抵息券吧~</p>
            </div>
            <div class="activity-pop-btn-wrap">
                <a href="javascript:;" class="activity-pop-btn" data-toggle="mask" data-target="luckmoneySuccess">确定</a>
            </div>
        </div>
    </div>
</div>
<!-- 抽奖机会已用完 -->
<div class="activity-layer limit">
    <div class="activity-mask"></div>
    <div class="activity-pop">
        <a href="javascript:;" class="activity-pop-close" data-toggle="mask" data-target="limit">close</a>
        <div class="activity-pop-content">
            <img src="/static/Activity/TC0A-026/images2/activity-pop-icon1.png" alt="提示" class="activity-pop-icon">
            <p class="activity-pop-text3">抽奖机会已用完<br>快去邀请好友来参加吧！</p>
            <div class="activity-pop-btn-wrap">
                <a href="/h5/Activity/TCOA026" class="activity-pop-btn">邀请好友></a>
            </div>
        </div>
    </div>
</div>
<!-- 活动已结束 -->
<div class="activity-layer end">
    <div class="activity-mask"></div>
    <div class="activity-pop">
        <a href="javascript:;" class="activity-pop-close" data-toggle="mask" data-target="end">close</a>
        <div class="activity-pop-content">
            <img src="/static/Activity/TC0A-026/images2/activity-pop-icon2.png" alt="提示" class="activity-pop-icon">
            <p class="activity-pop-text2">活动已结束！</p>
            <div class="activity-pop-btn-wrap">
                <a href="javascript:;" class="activity-pop-btn" data-toggle="mask" data-target="end">确定</a>
            </div>
        </div>
    </div>
</div>
<!-- 注册快金会员 -->
<div class="activity-layer timecash">
    <div class="activity-mask"></div>
    <div class="activity-pop">
        <div class="activity-pop-pos"></div>
        <a href="javascript:;" class="activity-pop-close" data-toggle="mask" data-target="timecash">close</a>
        <div class="activity-pop-content">
            <p class="activity-pop-text1">注册并获得快金额度，新用户参与抽奖</p>
            <div class="activity-pop-form">
                    <input type="number" class="activity-pop-input" name="phone" value="" placeholder="请输入手机号">
                    <div class="activity-pop-group">
                        <input type="number" class="activity-pop-input min" name="code" value="" placeholder="请输入验证码">
                        <input type="button" onclick="VerCode();" class="activity-pop-btn min t-pwd-code" name="" value="获取验证码">
                    </div>
                    <input type="password" class="activity-pop-input" name="password" value="" placeholder="登录密码（6-16位密码，至少包含一位字母）">
                    <p class="activity-form-tip"></p>
                    <input type="button" onclick="registerSub();" class="activity-pop-btn max" name="" value="注册快金会员">
            </div>
        </div>
    </div>
</div>
<!-- 活动规则 -->
<div class="activity-layer rule">
    <div class="activity-mask"></div>
    <div class="activity-pop">
        <a href="javascript:;" class="activity-pop-close" data-toggle="mask" data-target="rule">close</a>
        <div class="activity-pop-content">
            <h2>活动规则</h2>
            <p>1、活动时间：2018年4月26日-5月25日</p>
            <p>2、活动仅限从未在快金注册过的新用户，同一手机号仅限参与一次活动，相同奖品同一手机号限领一次；</p>
            <p>3、活动期间，快金新注册用户获得一张7天免息券，免息券仅限在快金平台借款时使用；</p>
            <p>4、新注册用户可在“新用户抽奖”区参与1次抽奖活动；</p>
            <p>5、实物类奖励将在活动结束后5个工作日内统一发放；现金奖励请下载快金平台进行提现（“个人-我的钱包-零钱提现”）；免息券可在借款时直接抵用；</p>
            <p>6、参与活动的用户若存在涉嫌欺骗性行为，快金有权利不给涉及账号奖励！</p>
            <p>7、如有疑问，请咨询：010-56592060</p>
        </div>
    </div>
</div>

</body>
</html>
