<nav class="main-menu" style="display: none;">
	<div class="settings">
		<img class="float_left" src="<?php echo empty($_VArray['userinfo']['headimgurl'])?'/static/images/v2/icon-Avatar.png':$_VArray['userinfo']['headimgurl']?>">
			<span><?php echo empty($_VArray['userinfo']['name'])?(empty($userinfo['wechat_username'])?'用户名':$_VArray['$=userinfo']['wechat_username']):$_VArray['userinfo']['name'] ?><br>
				<small><?php echo isset($_VArray['userinfo']['mobile'])?$_VArray['userinfo']['mobile']:'' ?></small>
			</span>
	</div>
	<ul>
        <?php
        foreach ($_VArray['menu'] as $key=>$val){
            echo '<li><a href="'.$val['left_url'].'"><img style="width: 1.2rem;top: .26rem;position: relative;" src="'.$val['left_icon'].'"><span class="nav-text">'.$val['left_title'].'</span></a></li>';
//            echo '<li><a href="'.$val['left_url'].'"><i class="fa'.$val['left_coin'].'"></i><span class="nav-text">'.$val['left_title'].'</span></a></li>';
        }
        ?>
	</ul>
	<section class="menu_footer">
		<div><a href="tel:01056592060">联系客服</a></div>
		<div>010-56592060</div>
	</section>
</nav>
<script>
	seajs.use('js/v2/menu');
</script>

