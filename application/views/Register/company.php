<?php include Kohana::find_file('views', 'public/headapp');?>
<?php echo HTML::script('static/js/lockPhoneBackBtn.js'); ?>
<?php echo HTML::style('static/css/larea/LArea.css?123'); ?>
<?php echo HTML::style('static/css/larea/company.css?123'); ?>
<body>


<section class="t-login-nav">
    <?php if($type==2){ ?>
        <div class="t-login-nav-1"><a href="/Account/Promote?jump=no" class="t-return"></a>提交授信资料</div>
    <?php }else{ ?>
        <div class="t-login-nav-1"><a href="/Account/Promote?jump=no" class="t-return"></a>提交授信资料</div>
    <?php } ?>

</section>
<!--<section class="progress-bar b-flex-box">-->
<!--    --><?php //echo HTML::image('/static/images/credit/icon_one.png',array('style'=>'width:99%')) ?>
<!--</section>-->

<p class="b-supple-infotxt b-color-orange"><span>•</span> 请输入您的工作信息</p>
<section class="t-login-center">
    <p class="t-login-center-1 t-bt1px">
        <span class="t-icon-sign comname"></span>
        <?php echo Form::input('comname','',array('class'=>'form-control','placeholder'=>'公司名称'));?>
        <span class="t-icon-close"></span> </p>
    <!-- 省市联动-->
<!--    <p class="t-login-center-1 t-bt1px">-->
    <p class="t-login-center-1 t-bt1px" style="padding: 0.7rem 0 0 0;height: 1.9rem;" data-toggle="distpicker">
            <span style="z-index: 1; height: 26px;line-height: 30px;float: left;margin-right:10px">所在地</span>
            <label class="sr-only" for="province1">Province</label>
            <select class="sp" style="z-index: 1; height: 26px;max-width: 70px;" id="province1"><option value="" data-code="" disabled>—— 省 ——</option><option value="北京市" data-code="110000" selected="">北京市</option><option value="天津市" data-code="120000">天津市</option><option value="河北省" data-code="130000">河北省</option><option value="山西省" data-code="140000">山西省</option><option value="内蒙古自治区" data-code="150000">内蒙古自治区</option><option value="辽宁省" data-code="210000">辽宁省</option><option value="吉林省" data-code="220000">吉林省</option><option value="黑龙江省" data-code="230000">黑龙江省</option><option value="上海市" data-code="310000">上海市</option><option value="江苏省" data-code="320000">江苏省</option><option value="浙江省" data-code="330000">浙江省</option><option value="安徽省" data-code="340000">安徽省</option><option value="福建省" data-code="350000">福建省</option><option value="江西省" data-code="360000">江西省</option><option value="山东省" data-code="370000">山东省</option><option value="河南省" data-code="410000">河南省</option><option value="湖北省" data-code="420000">湖北省</option><option value="湖南省" data-code="430000">湖南省</option><option value="广东省" data-code="440000">广东省</option><option value="广西壮族自治区" data-code="450000">广西壮族自治区</option><option value="海南省" data-code="460000">海南省</option><option value="重庆市" data-code="500000">重庆市</option><option value="四川省" data-code="510000">四川省</option><option value="贵州省" data-code="520000">贵州省</option><option value="云南省" data-code="530000">云南省</option><option value="西藏自治区" data-code="540000">西藏自治区</option><option value="陕西省" data-code="610000">陕西省</option><option value="甘肃省" data-code="620000">甘肃省</option><option value="青海省" data-code="630000">青海省</option><option value="宁夏回族自治区" data-code="640000">宁夏回族自治区</option><option value="新疆维吾尔自治区" data-code="650000">新疆维吾尔自治区</option><option value="台湾省" data-code="710000">台湾省</option><option value="香港特别行政区" data-code="810000">香港特别行政区</option><option value="澳门特别行政区" data-code="820000">澳门特别行政区</option></select>
            <label class="sr-only" for="city1">City</label>
            <select class="sp" style="z-index: 1; height: 26px;max-width: 70px;" id="city1"><option value="" data-code="" disabled>—— 市 ——</option><option value="北京市市辖区" data-code="110100" selected="">北京市市辖区</option></select>
             <label class="sr-only" for="district1">District</label>
            <select class="sp" style="z-index: 1;height: 26px;max-width: 70px;" id="district1"><option value="" data-code="" disabled>—— 区 ——</option><option value="东城区" data-code="110101" selected="">东城区</option><option value="西城区" data-code="110102">西城区</option><option value="朝阳区" data-code="110105">朝阳区</option><option value="丰台区" data-code="110106">丰台区</option><option value="石景山区" data-code="110107">石景山区</option><option value="海淀区" data-code="110108">海淀区</option><option value="门头沟区" data-code="110109">门头沟区</option><option value="房山区" data-code="110111">房山区</option><option value="通州区" data-code="110112">通州区</option><option value="顺义区" data-code="110113">顺义区</option><option value="昌平区" data-code="110114">昌平区</option><option value="大兴区" data-code="110115">大兴区</option><option value="怀柔区" data-code="110116">怀柔区</option><option value="平谷区" data-code="110117">平谷区</option><option value="密云区" data-code="110118">密云区</option><option value="延庆区" data-code="110119">延庆区</option></select>
    </p>
<!--        --><?php //echo Form::input('comaddress','',array('id'=>'comaddress','class'=>'form-control','readonly'=>true,'placeholder'=>'公司所在地区'));?>
<!--        --><?php //echo Form::hidden('comaddressvalue',"",array('id'=>"comaddressvalue"));?>
<!--        <span class="t-icon-close"></span></p>-->
    <p class="t-login-center-1 t-bt1px">
        <span class="t-icon-sign icon_address"></span>
        <?php echo Form::input('comdetailaddre','',array('class'=>'form-control','placeholder'=>'公司详细地址'));?>
        <span class="t-icon-close"></span> </p>
    <p class="t-login-center-1">
        <span class="t-icon-sign icon_comtell"></span>
        <?php echo Form::input('comtell','',array('class'=>'form-control','placeholder'=>'公司联系电话,固话请包含区号'));?>
        <span class="t-icon-close"></span></p>
<!--    <p class="t-login-center-1 t-bt1px">-->
<!--        --><?php //echo Form::input('email','',array('class'=>'form-control','placeholder'=>'公司邮箱'));?>
<!--        <span class="t-icon-close"></span></p>-->
<!--    <p class="t-login-center-1">-->
<!--        --><?php //echo Form::input('authcode','',array('class'=>'t-w240px form-control','placeholder'=>'公司邮箱验证码'));?>
<!--        <span class="t-icon-close t-mr"></span><span class="t-pwd-code">获取验证码</span></p>-->
</section>
<!--<p class="b-supple-infotxt b-color-orange"><span>•</span> 请输入您的家庭信息</p>-->
<!--<section class="t-login-center">-->
<!--    <p class="t-login-center-1 t-bt1px" style="padding: 0.7rem 0 0 0;height: 1.9rem;"data-toggle="distpicker">-->
<!--        <span style="z-index: 1; height: 26px;line-height: 30px;float: left;margin-right:10px">所在地</span>-->
<!--        <label class="sr-only" for="province2">Province</label>-->
<!--        <select class="sp" style="z-index: 1; height: 26px;max-width: 70px;" id="province2"><option value="" data-code="" >—— 省 ——</option><option value="北京市" data-code="110000" selected="">北京市</option><option value="天津市" data-code="120000">天津市</option><option value="河北省" data-code="130000">河北省</option><option value="山西省" data-code="140000">山西省</option><option value="内蒙古自治区" data-code="150000">内蒙古自治区</option><option value="辽宁省" data-code="210000">辽宁省</option><option value="吉林省" data-code="220000">吉林省</option><option value="黑龙江省" data-code="230000">黑龙江省</option><option value="上海市" data-code="310000">上海市</option><option value="江苏省" data-code="320000">江苏省</option><option value="浙江省" data-code="330000">浙江省</option><option value="安徽省" data-code="340000">安徽省</option><option value="福建省" data-code="350000">福建省</option><option value="江西省" data-code="360000">江西省</option><option value="山东省" data-code="370000">山东省</option><option value="河南省" data-code="410000">河南省</option><option value="湖北省" data-code="420000">湖北省</option><option value="湖南省" data-code="430000">湖南省</option><option value="广东省" data-code="440000">广东省</option><option value="广西壮族自治区" data-code="450000">广西壮族自治区</option><option value="海南省" data-code="460000">海南省</option><option value="重庆市" data-code="500000">重庆市</option><option value="四川省" data-code="510000">四川省</option><option value="贵州省" data-code="520000">贵州省</option><option value="云南省" data-code="530000">云南省</option><option value="西藏自治区" data-code="540000">西藏自治区</option><option value="陕西省" data-code="610000">陕西省</option><option value="甘肃省" data-code="620000">甘肃省</option><option value="青海省" data-code="630000">青海省</option><option value="宁夏回族自治区" data-code="640000">宁夏回族自治区</option><option value="新疆维吾尔自治区" data-code="650000">新疆维吾尔自治区</option><option value="台湾省" data-code="710000">台湾省</option><option value="香港特别行政区" data-code="810000">香港特别行政区</option><option value="澳门特别行政区" data-code="820000">澳门特别行政区</option></select>-->
<!--        <label class="sr-only" for="city2">City</label>-->
<!--        <select class="sp" style="z-index: 1; height: 26px;max-width: 70px;" id="city2"><option value="" data-code="" >—— 市 ——</option><option value="北京市市辖区" data-code="110100" selected="">北京市市辖区</option></select>-->
<!--        <label class="sr-only" for="district2">District</label>-->
<!--        <select class="sp" style="z-index: 1;height: 26px;max-width: 70px;" id="district2"><option value="" data-code="" >—— 区 ——</option><option value="东城区" data-code="110101" selected="">东城区</option><option value="西城区" data-code="110102">西城区</option><option value="朝阳区" data-code="110105">朝阳区</option><option value="丰台区" data-code="110106">丰台区</option><option value="石景山区" data-code="110107">石景山区</option><option value="海淀区" data-code="110108">海淀区</option><option value="门头沟区" data-code="110109">门头沟区</option><option value="房山区" data-code="110111">房山区</option><option value="通州区" data-code="110112">通州区</option><option value="顺义区" data-code="110113">顺义区</option><option value="昌平区" data-code="110114">昌平区</option><option value="大兴区" data-code="110115">大兴区</option><option value="怀柔区" data-code="110116">怀柔区</option><option value="平谷区" data-code="110117">平谷区</option><option value="密云区" data-code="110118">密云区</option><option value="延庆区" data-code="110119">延庆区</option></select>-->
<!--    </p>-->
<!--    <p class="t-login-center-1 t-bt1px">-->
<!--        <span class="t-icon-sign icon_address"></span>-->
<!--        --><?php //echo Form::input('detailaddress','',array('class'=>'form-control','placeholder'=>'家庭详细地址'));?>
<!--        <span class="t-icon-close"></span> </p>-->
<!--    <p class="t-login-center-1">-->
<!--        <span class="t-icon-sign icon_comtell"></span>-->
<!--        --><?php //echo Form::input('numbertell','',array('class'=>'form-control','placeholder'=>'家庭电话(选填),固话请包含区号'));?>
<!--        <span class="t-icon-close"></span></p>-->
<!--</section>-->

<section class="t-login-footer">
    <p class="t-error"></p>
    <input type="submit" class="t-red-btn t-red-company" value="下一步"></br></br>
<!--    <a href="/RegisterApp/Contacts"  class="t-red-btn">跳过</a></br>-->
</section>
</body>
<script type="text/javascript">
    var companyinfourl='<?php echo URL::site('FunctionsApp/docompanyinfo'); ?>';
</script>
</html>
<?php  echo HTML::script('static/js/local-min/creditforms-min.js?112221'); ?>
<?php  echo HTML::script('static/js/larea/distpicker.data.js?1111'); ?>
<?php  echo HTML::script('static/js/larea/distpicker.js?1111'); ?>
<script>
//    var area2 = new LArea();
//    area2.init({
//        'trigger': '#comaddress',
//        'valueTo': '#comaddressvalue',
//        'keys': {
//            id: 'value',
//            name: 'text'
//        },
//        'type': 2,
//        'data': [provs_data, citys_data, dists_data]
//    });
//    var area3 = new LArea();
//    area3.init({
//        'trigger': '#address',
//        'valueTo': '#addressvalue',
//        'keys': {
//            id: 'value',
//            name: 'text'
//        },
//        'type': 2,
//        'data': [provs_data, citys_data, dists_data]
//    });
</script>
