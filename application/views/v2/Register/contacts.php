<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
    seajs.config({
        vars: {
            'contactsourl':'<?php echo $_VArray['requestUrl'] ?>',
            'Jumpourl':'<?php if(isset($_VArray['jumpurl'])){echo $_VArray['jumpurl'];}else{ echo '/?#jump=yes';} ?>'
        }
    });
    seajs.use('js/v2/seajs/creditforms');
</script>
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
<?php  echo Form::open('Account/Promote?#jump=yes', array('id'=>'contactForm')); ?>
<?php // echo Form::open('Account/Promote?jump=yes', array('id'=>'contactForm')); ?>
<section class="t-login-center">
    <p class="t-login-center-1 border-bottom">
        <?php echo Form::input('conname','',array('class'=>'form-control text_width_70','placeholder'=>'姓名'));?>
        <span class="t-icon-close"></span> </p>
    <p class="t-login-center-1 border-bottom">
        <?php echo Form::select('contact',array('0'=>'请选择关系','parent'=>'父母','brother'=>'兄弟姐妹','spouse'=>'配偶','children'=>'子女'),'0',array('id'=>'contact-select1','data-type'=>'1','class'=>'b-form-select'));?>
        <span class="b-icon-select"></span>
    <p class="t-login-center-1">
        <?php echo Form::input('ccomtell','',array('class'=>'form-control text_width_70','placeholder'=>'手机号码')); ?>
        <span class="t-icon-close"></span></p>
</section>
<section class="t-login-center">
    <p class="t-login-center-1 border-bottom">
        <?php echo Form::input('conname','',array('class'=>'form-control text_width_70','placeholder'=>'姓名'));?>
        <span class="t-icon-close"></span> </p>
    <p class="t-login-center-1 border-bottom">
        <?php echo Form::select('contact',array('0'=>'请选择关系','parent'=>'父母','brother'=>'兄弟姐妹','spouse'=>'配偶', 'children'=>'子女','colleague'=>'同事','classmate'=>'同学','friend'=>'朋友'),'0',array('id'=>'contact-select2','data-type'=>'2','class'=>'b-form-select'));?>
        <span class="b-icon-select"></span>
    <p class="t-login-center-1">
        <?php echo Form::input('ccomtell','',array('class'=>'form-control text_width_70','placeholder'=>'手机号码')); ?>
        <span class="t-icon-close"></span></p>
</section>
<section class="t-login-footer">
    <p class="t-error"></p>
    <input type="submit" class="t-orange-btn button_submit button_bank" value="下一步"><br><br>
<!--	<input type="submit" class="t-red-btn" value="下一步"><br><br><br>-->
</section>
<?php echo Form::close();?>
<?php //include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
