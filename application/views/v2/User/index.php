<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
	seajs.config({
		vars: {
			'userId':<?php echo (isset(Gv::$_userInfo['user_id'])&&!empty(Gv::$_userInfo['user_id']))?1:2; ?>
		}
	});
	seajs.use('js/v2/seajs/user-index');
</script>
<body>
<div class="loading_ok" style="display: none">
<!-- 头信息 -->
<section class="t-login-nav">
	<div class='t-login-nav-1'>
		<?php if(empty(Gv::$_userInfo['user_id'])){ ?>
		<a href="/Login"><span class="t_return_i"></span></a><lebal class="sign"></lebal>
	</div>
	</section>
		<?php }else{?>
			<a href="javascript:;"><span class="t_return_i" id='clickl'></span></a><lebal class="sign"></lebal>
			</div>
			</section>
		<?php
			include Kohana::find_file('views', 'v2/public/menu');
		}?>
<!-- 头信息end -->
<div style="height: 1.2rem"></div>
<div style="clear: both"></div>
<!--轮播图-->
<div class="main_visual">
	<div class="flicking_con">
		<?php echo $_VArray['signBanner']; ?>
	</div>
	<div class="main_image">
		<ul>
				<?php echo $_VArray['strBanner'] ?>
		</ul>
		<a style="display: none !important;" href="javascript:;" id="btn_prev"></a>
		<a style="display: none !important;" href="javascript:;" id="btn_next"></a>
	</div>
</div>
<?php echo $_VArray['bannerNotice']; ?>

<section class="m-information">
	<div class='kapian'>
		<div class='top'>
			<i></i>
			<label>我的订单</label>
            <?php
                if(isset(Gv::$_userInfo['user_id'])&&!empty(Gv::$_userInfo['user_id'])){
                    if(isset($_VArray['currentOrder']['repayButton'])&&$_VArray['currentOrder']['repayButton']){
                        echo "<a class='float_right' href='/Repaymoney'>立即还款<i></i></a>";
                    }
                }
            ?>
		</div>
		<div class="clear"></div>
		<section   class="m-card-span">
            <?php
                //无订单情况下
                if(isset($_VArray['currentOrder'])){
                    echo "<a class='aclss' href='/User/Singledescribe?id={$_VArray['currentOrder']['id']}'><span class='float_left border-right-white'>{$_VArray['currentOrder']['loanAmount']}<br><small>本次借款(元)</small></span><span class='float_left'>{$_VArray['currentOrder']['repaymentTime']}<br><small>{$_VArray['currentOrder']['timeMoun']}</small></span></div><div class='clear'></div><div class='status'>{$_VArray['currentOrder']['statusOrder']}</div></a>";
                }else{
                    echo "<span class='float_left border-right-white'>── ──<br><small>本次借款(元)</small></span><span class='float_left'>── ──<br><small>距还款日还剩</small></span></div><div class='clear'></div><div class='status'>还没有借款记录~</div>";
                }
            ?>
		</section>
        </div>
</section>
<?php if(isset($_VArray['product_list'])&&Valid::not_empty($_VArray['product_list'])){
        foreach ($_VArray['product_list'] as $key=>$val){
            switch ($val['type']){
                case "fast_loan":case "full_pre_auth_loan":case "pre_auth_loan":case "web_bar":
                    //按钮判断
                    if($val['button']['enable']==1){
                        $buttonBug = "<a href='".$val['button']['click']."'><span class='float_right spok'>".$val['button']['title']."</span></a>";
                    }else{
                        $buttonBug = "<a href='javascript:;'><span class='float_right sp b_disabled'>".$val['button']['title']."</span></a>";
                    }
                    echo "<section class='index_menu'>
                            <div style='padding:.6rem 1rem;'>
                                <i class='down_guarantee_i'></i><label>".$val['name']."<span class='float_right'>".$val['summary']."</span></label>
                            </div>
                            <div class='index_menu_b border-top' style='padding:1rem 0;'>
                                <span class='float_left'>".$val['amount'].$val['amount_unit']."<br><small style='color:#8e949b'>".$val['amount_title']."</small></span>
                                <span class='float_left'>".$val['time'].$val['time_unit']."<br><small style='color:#8e949b'>".$val['time_title']."</small></span>
                                ".$buttonBug."
                            </div>
                          </section>";
                    break;
                case 'web_url':
                    echo "<section class='index_menu' style='height: 90px;width: 100%;overflow: hidden'>
                          
                          </section>";
//                    echo "<section class='index_menu' style='height: 90px;width: 100%;overflow: hidden'>
//                            <iframe style='height: 90px;display: block;width: 100%' src='".$val['url']."'></iframe>
//                          </section>";
                    break;
                case 'web_html':
                    echo "<section class='index_menu' style='height: 90px'>
                            ".$val['html']."
                          </section>";
                    break;
                default :
                    break;
            }
        }
    }
?>
<div class="top_height"></div>
</div>
</body>
</html>