<?php include Kohana::find_file('views', 'v2/public/headapp');?>
<script>
    seajs.config({
        vars: {

        }
    });
    seajs.use('js/v2/seajs/repaymoney');
</script>
	<body style="color: #333333">
		<!-- 头信息 -->
		<section class="t-login-nav">
			<div class='t-login-nav-1'>
				<a class="return_i i_public" href="/?#jump=no"></a>账单详情
			</div>
		</section>
        <div class="top_height"></div>
		<section class="repaydetais1">
            <div class="one">
                <p class="p1">到期应还金额</p>
                <p class="p2">3100.00</p>
                <p class="p3">“良好的信用，从按时还款开始”</p>
            </div>
            <ul>
                <li>
                    <p>2018.03.02<br><em>借款日期</em></p>
                </li>
                <li>
                    <p>5000.00<br><em>借款金额(元)</em></p>
                </li>
                <li style="border-right: none;">
                    <p>14天<br><em>借款期数</em></p>
                </li>
            </ul>
        </section>
        <p class="repaydetais_p1">账单明细</p>
        <a class="repaydetais2" href="javascript:;">
            到期还款日
            <label>2018-02-03<em>待还</em></label>
        </a>
        <footer>
            <label>3100.00元</label>
            <a href="/app/Repaymoney/Operation">立即还款</a>
        </footer>
	</body>
</html>
