<?php include Kohana::find_file('views', 'v2/public/headapp');?>
<script>
    seajs.config({
        vars: {

        }
    });
    seajs.use('js/v2/seajs/giveupreason');
</script>

<style>
    /*拒绝原因*/
    .giveupreason_p{
        width: 92%;
        font-size: .55rem;
        color: #666666;
        margin: .7rem 4%;
    }
    .giveupreason_ul{
        font-size: .81rem;
    }
    .giveupreason_ul li{
        float: left;
        font-size: .65rem;
        width: 29%;
        text-align: center;
        height: 2.2rem;
        line-height: 2.2rem;
        background: white;
        margin-left: 3%;
        margin-bottom: 1rem;
        border: 1px solid white;
        color: #333333;
    }
    .giveupreason_ul .on{
        border: 1px solid #FDADA0;
    }
    .gr-tx{
        font-size: .61rem;
        background: white;
        margin: 0 3%;
        width: 90%;
        height: 9.91rem;
        padding: .6rem 2%;
        margin-bottom: 2rem;
    }
    .gr-tx::-webkit-input-placeholder {
        font-size: .61rem;
    }
    .gr-tx::-moz-placeholder {
        font-size: .61rem;
    }

</style>


<section class="t-login-nav">
    <div class='t-login-nav-1'>
        <a class="return_i i_public" href="<?php echo URL::site('User/index');?>"></a>放弃借款
    </div>
</section>
<div class="top_height_n"></div>

    <p class="giveupreason_p">放弃原因(可多选)</p>

    <ul class="giveupreason_ul">
        <li>额度太低</li>
        <li>费用太高</li>
        <li>不想借了</li>
        <li>体验太差</li>
        <li>批复太慢</li>
        <li>其他原因</li>
<!--        --><?php //echo $_VArray['listStr']; ?>
    </ul>
    <p class="giveupreason_p">意见建议：</p>
    <textarea class="gr-tx" placeholder="请留下您宝贵的意见，我们会更加努力。"></textarea>
<a href="javascript:;" class="button_submit_f">确认放弃</a>
    <!--<button class="submitButton" onclick="submit()">确定</button>-->
<!--<div class="div1"></div>-->
<!--<div class="div2"></div>-->
<!--<div class="div3"></div>-->

</body>
</html>