<?php include Kohana::find_file('views', 'v2/public/head');?>
<script src="/static/js/v2/timecash.app.js"></script>
<script>
    seajs.config({
        vars: {
            'contactsourl':'<?php echo $_VArray['requestUrl'] ?>',
            'Jumpourl':'<?php if(isset($_VArray['jumpurl'])){echo $_VArray['jumpurl'];}else{ echo '/?#jump=yes';} ?>'
        }
    });
    seajs.use('js/v2/seajs/creditforms');
    var $AppInst = new $.AppInst();
    var abc = '';
</script>

<style>
    .t-credit-w{
        background: white;
        padding: 0 3%;
    }
    .t-credit-input{
        height: 2rem;
        line-height: 2rem;
        color: #b5b0b0;
    }
    .tip-p{
        padding: .5rem 3%;
        font-size: .45rem;
        background: #f8f8f8;
        color: #fabcb2;
    }
    .buttonimg{
        background: url(/static/images/v2/icon_credit_tip1.png) no-repeat;
        background-size: 100% 100%;
        background-position: center;
        height: .9rem;
        width: .9rem;
        float: right;
        margin-top: .5rem;
    }
</style>

<body>
<!-- 头信息 -->

<?php if(isset($_VArray['showtitle'])&&$_VArray['showtitle']){?>
<?php }else{?>
    <section class="t-login-nav">
        <div class='t-login-nav-1'>
            <a href="<?php if(isset($_VArray['urlHome'])){echo $_VArray['urlHome'];}else{ echo '/?#jump=no';} ?>" class="return_i i_public"></a>联系人信息
        </div>
    </section>
    <div class="top_height"></div>
<?php }?>

<p class="credit_p">请输入2位紧急联系人方式,请至少输入1位直系亲属</p>
<section class="t-credit-w contact1">
    <p class="t-credit-input border-bottom">
        <input type="text" placeholder="亲属姓名" disabled class="conname1">
        <button class="buttonimg" data-code="1" onclick='abc= $(this);$AppInst.WebJump({"type":"getPhone","par":""});'></button>
    </p>
    <p class="t-credit-input border-bottom">
        <?php echo Form::select('contact1',array('0'=>'请选择关系','parent'=>'父母','brother'=>'兄弟姐妹','spouse'=>'配偶','children'=>'子女'),'0',array('id'=>'contact-select1','data-type'=>'1','class'=>'b-form-select'));?>
        <span class="buttonimgmore"></span>
    </p>
    <p class="t-credit-input">
        <?php echo Form::input('ccomtell1','',array('class'=>'form-control text_width_70','placeholder'=>'联系电话')); ?>
        <span class="t-icon-close"></span>
    </p>

</section>
<p class="tip-p">联系人信息</p>
<section class="t-credit-w contact2">
    <p class="t-credit-input border-bottom">
        <input type="text" class="conname2" placeholder="联系人姓名" disabled>
        <button class="buttonimg" data-code="2" onclick='abc = $(this);$AppInst.WebJump({"type":"getPhone","par":""});'></button>
    </p>
    <p class="t-credit-input border-bottom">
        <!--        <span>关系</span>-->
        <?php echo Form::select('contact2',array('0'=>'请选择关系','colleague'=>'同事','classmate'=>'同学','friend'=>'朋友'),'0',array('id'=>'contact-select1','data-type'=>'1','class'=>'b-form-select'));?>
        <span class="buttonimgmore"></span>
    </p>
    <p class="t-credit-input">
        <?php echo Form::input('ccomtell2','',array('class'=>'form-control text_width_70','placeholder'=>'联系电话')); ?>
        <span class="t-icon-close"></span></p>

</section>
<section class="t-login-footer">
    <p class="t-error"></p>
    <input type="submit" class="t-orange-btn button_submit button_bank submit_new" value="下一步"><br><br>
<!--	<input type="submit" class="t-red-btn" value="下一步"><br><br><br>-->
</section>
<?php echo Form::close();?>
<?php //include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
