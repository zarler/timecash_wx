<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>

	seajs.config({
		vars: {
		    'jumpUrl':"<?php echo isset($_VArray['jumpUrl'])?$_VArray['jumpUrl']:'/' ?>"
		},
        map:[
            [".js",".js?v="+version],
            [".css",".css?v="+version]
        ]
	});
	seajs.use('js/v2/seajs/mycard');
</script>
<body>

<section class="t-login-nav">
	<div class='t-login-nav-1'>
        <?php if(!isset($_VArray['back'])){ ?><a class="return_i i_public" href="<?php echo URL::site('User/index');?>"></a><?php } ?>选择快审卡
	</div>
</section>
<div class="top_height"></div>

<!--<section class="list-s">-->
<!--    <p>当前剩余<span>99</span>张</p>-->
<!--    <div class='t-mycard-list selected' >-->
<!--        <div  class='border-bottom list-top'>-->
<!--            <div class='canBugLift'>-->
<!--                <i style="background: "></i><strong>249元</strong>-->
<!--            </div>-->
<!--            <div class='canBugRight'>1、每张快审卡可享受一次极速审核的权益<br>2、快审卡自动匹配为您已提交的订单中<br>3、快审卡仅可在相匹配的订单中使用<br>4、完成购卡后，系统将自动使用快审卡</div>-->
<!--        </div>-->
<!--        <p class='t-select2'>-->
<!--            <label style=''>249元</label>-->
<!--            <label style='float: right'>有效期360天</label>-->
<!--        </p>-->
<!--    </div>-->
<!--</section>-->

<?php if(Valid::not_empty($_VArray['list'])){
        foreach ($_VArray['list'] as $key=>$val){

            if($val['available']==1){
                if($val['available_num']>0){
                    echo "<section class='list-s'><p>当前剩余<span>{$val['available_num']}</span>张</p><div class='t-mycard-list selected' data-id = '{$val['id']}' data-price = '{$val['price']}' data-num = '{$val['available_num']}' data-name = '{$val['name']}' ><div  class='border-bottom list-top'><div class='canBugLift'><i></i><strong>{$val['name']}</strong></div><div class='canBugRight'>1、每张快审卡可享受一次极速审核的权益<br>2、快审卡自动匹配为您已提交的订单中<br>3、快审卡仅可在相匹配的订单中使用<br>4、完成购卡后，系统将自动使用快审卡</div></div><p class='t-select2'><label style=''>{$val['price']}元</label><label style='float: right'>有效期360天</label></p></div></section>";
                }else{
                    echo "<section style='margin-top:1rem'><section class='list-s'><p>当前剩余<span>{$val['available_num']}</span>张</p><div class='credit_transparent zhezhaocard'>此卡已售罄</div><div class='t-mycard-list'><div  class='border-bottom list-top'><div class='canBugLift'><i></i><strong>{$val['name']}</strong></div><div class='canBugRight'>1、每张快审卡可享受一次极速审核的权益<br>2、快审卡自动匹配为您已提交的订单中<br>3、快审卡仅可在相匹配的订单中使用<br>4、完成购卡后，系统将自动使用快审卡</div></div><p class='t-select2'><label style=''>{$val['price']}元</label><label style='float: right'>有效期360天</label></p></div></section>";
                }
            }else{
                echo "<section style='margin-top:1rem'><section class='list-s'><p>当前剩余<span>{$val['available_num']}</span>张</p><div class='t-mycard-list t-mycard-list-s'><div  class='border-bottom list-top-o'><i></i><strong>{$val['name']}</strong></div><p class='t-select2'><label style=''>{$val['price']}元</label><label style='float: right'>有效期360天</label></p></div></section>";
            }
        }
    }else{
        echo "<section style='margin-top:1rem'><h1>无法购买</h1><p>您需要先申请一笔借款，再购买审核卡。</p></section>";
    }
?>
<section class="t-login-footer">
    <p class="t-error"></p>
    <a class="t-orange-btn position_bottom t-myselectcard-button"">立即购买</a>
</section>
<div class="top_height"></div>
</body>
</html>
