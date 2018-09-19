<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>

	seajs.config({
		vars: {
            'codeurl':"<?php echo isset($_VArray['codeurl'])?$_VArray['codeurl']:'/' ?>",
            'submit':"<?php echo isset($_VArray['submit'])?$_VArray['submit']:'/' ?>",
            'jumpUrl':"<?php echo isset($_VArray['jumpUrl'])?$_VArray['jumpUrl']:'/' ?>"
		},
        map:[
            [".js",".js?v="+version]
        ]
	});
	seajs.use('js/v2/seajs/mycard');
</script>
<body>

<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<a class="return_i i_public" href="javascript:history.go(-1);"></a>选择快审卡
	</div>
</section>
<div class="top_height"></div>


<section class="list-s">
    <div class='t-mycard-list-b' data-id = '<?php echo $_VArray['cardInfo']['id'] ?>' >
        <div  class='border-bottom list-top-b'>
            <i style="background: "></i>
            <strong><?php echo $_VArray['cardInfo']['name'] ?></strong>
        </div>
        <p class='t-select2'>
            <label style='color: red'><?php echo $_VArray['cardInfo']['price'] ?>元</label>
            <label style='float: right'>有效期360天</label>
        </p>
    </div>
</section>


<section class="t-login-center" style="padding:0">
    <!--<p class="t-login-center-1 m-addfontsize"><span>还款金额</span><label><?php //echo $order[0]['repayment_amount'];?>元</label></p>-->
    <p class="t-login-center-1  m-addfontsize border-bottom"><span>还款银行卡</span><label class="t-w-r"> <?php echo $_VArray['order']['bankcard_name'].$_VArray['order']['bankcard_no'];?></label></p>
    <div class="m-bo1px">
        <!-- <p class="t-login-center-1 m-addheight"><input type="text" placeholder="请输入短信验证码" class="t-w240px"> <span class="t-pwd-code m-position">获取验证码</span></p> -->
        <p class="t-h t-login-center-1" style="height:2.3rem;"><input type="text" placeholder="请输入短信验证码" class="t-w240px form-control" name="code" style="left:0rem"><span class="t-icon-close t-mr t-mt1"></span> <button type="button"  class="t-pwd-code" onclick="<?php echo $_VArray['codeReq'];?>">获取验证码</button></p>
    </div>
</section>
<section class="t-login-footer">
    <p class="t-error"></p>
    <a class="t-orange-btn position_bottom" href="<?php echo $_VArray['submitReq'];?>">确定购买</a>
</section>
<div class="top_height"></div>
</body>
</html>
