<?php include Kohana::find_file('views', 'v2/public/head');?>
<script>
//    seajs.config({
//        vars: {
//            'contactsourl':'<?php //echo URL::site('FunctionsApp/docontacts'); ?>//',
//            'Jumpourl':'<?php //if(isset($jumpurl)){echo $jumpurl.'?jump=yes';}else{ echo '/Account/Promote?jump=yes';} ?>//'
//        }
//    });
    seajs.use('js/v2/seajs/CreditQuery');
</script>
<body style="background: white;">
<!-- 头信息 -->
<section class="t-login-nav">
    <div class='t-login-nav-1'>
        <?php echo $title; ?>
<!--        <a href="--><?php //if(isset($url)){echo $url.'?jump=no';}else{ echo '/Account/Promote?jump=no';} ?><!--" class="return_i i_public"></a>-->
    </div>
</section>
<div class="top_height"></div>
<section class="m-webbox">
    <p class="p1"><?php echo $title; ?></p>
    <p class="p2"><?php echo $content; ?></p>
    <?php if($submit){?>
        <a href="<?php echo $url; ?>" class="t-orange-btn" style="margin-top: 1.5rem"><?php echo $submit; ?></a>
    <?php }?>
</section>
</body>
</html>