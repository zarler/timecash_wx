<?php include Kohana::find_file('views', 'v2/public/headapp');?>
<script src="/static/js/v2/timecash.app.js"></script>
<script>
    seajs.config({
        vars: {

        }
    });
    seajs.use('js/v2/seajs/repaymoney');
    var $AppInst = new $.AppInst();
</script>
	<body style="color: #333333">
		<!-- 头信息 -->
		<section class="t-login-nav">
			<div class='t-login-nav-1'>
				<a class="return_i i_public" href="JavaScript:history.go(-1);"></a>还款
			</div>
		</section>
        <div class="top_height_n"></div>
		<section class="repayope1">
            <p class="p1">还款金额</p>
            <p class="p2">2313.00</p>
        </section>
        <a href='javascript:$AppInst.WebJump({"type":"web_within", "par":"app://app.timecash/BankCard/List"});' class="repayope2">付款银行<label><img src="/static/images/v2/bank/01000000.png"><em>招商银行 7405</em><i>&nbsp;</i></label></a>
    <a class="button_submit_f">确定</a>
    <p class="repayope3">如果还款失败，请尝试<em onclick='$AppInst.WebJump({"type":"phone","par":"13643176531"})'>联系客服获取帮助</em></p>
	</body>
</html>
