<?php include Kohana::find_file('views', 'v2/public/headapp');?>
<script>
    seajs.config({
        vars: {

        }
    });
    seajs.use('js/v2/seajs/repaymoney');
</script>
<style type="text/css">
    .repaysta1{
        width: 80%;
        height: 5rem;
        background: white;
        margin: .5rem 0 3rem 0;
        padding: 1.5rem 10%;
    }

    .repaysta1 .div1 .div_i1{
        width: .1rem;
        height: 2.5rem;
        background: red;
        float: left;
    }
    .repaysta1 .div1 .div_i1 img{
        width: 1.2rem;
        margin-left: .11rem;
        position: relative;
        left: -.65rem;
    }
    .repaysta1 .div2 .div_i2{
        width: .1rem;
        height: 2.5rem;
        background: #FFCCC2;
        display: inline-block;
        float: left;
    }
    .repaysta1 .div2 .div_i2 img{
        width: 1.2rem;
        position: relative;
        left: -.65rem;
        margin-top: 1.3rem;
    }
    .repaysta1 .div1 .p1{
        margin-left: 1.2rem;
        font-size: .7rem;
        color: #222222;
        position: relative;
        top: .1rem;
    }
    .repaysta1 .div2 .p1 {
        margin-left: 1.2rem;
        font-size: .7rem;
        color: #999999;
        position: relative;
        top: 1.5rem;
    }
    .repaysta1 .p1 span{
        display: block;
        color: #999999;
        font-size: .6rem;
        margin-top: .3rem;
    }
    .repaysta2 img{
        width: 90%;
        margin: 0 auto;
        display: block;
    }
</style>


<body style="color: #333333">
        <!-- 头信息 -->
        <section class="t-login-nav">
            <div class='t-login-nav-1'>
                <a class="return_i i_public" href="<?php echo URL::site('User/index');?>"></a>提交成功
            </div>
        </section>
        <div class="top_height_n"></div>

        <section class="repaysta1">
            <div class="div1">
                <div class="div_i1">
                    <img style="margin-left: .11rem" src="/static/images/v2/icon_gou.png">
                </div>
                <p class="p1">
                    还款申请已提交
                    <span>稍后可查看还款结果</span>
                </p>
            </div>
            <div style="clear: both"></div>
            <div class="div2">
                <div class="div_i2" style="">
                    <img style="margin-left: .11rem" src="/static/images/v2/icon_qian.png">
                </div>
                <p class="p1">还款成功</p>
            </div>
        </section>
        <a class="button_submit_f">确定</a>
        <p class="repayope3">如果还款失败，请尝试<em>联系客服获取帮助</em></p>
        <div class="top_height_n"></div>
        <section class="repaysta2">
            <img src="/static/images/v2/test/demobanner.png">
        </section>
</body>
</html>
