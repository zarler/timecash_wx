<?php include Kohana::find_file('views', 'public/head');?>
<body>
<section class="t-login-nav">
    <div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>填写邀请码<!--<a href="#" class="t-re">登录</a>--></div>
</section>
<?php  echo Form::open('Register/index', array('id'=>'InviteForm')); ?>
<section class="t-login-center">
    <p class="t-login-center-1">
        <?php echo Form::input('invitecode','',array('class'=>'form-control','placeholder'=>'填写邀请码'));?>
        <span class="t-icon-close"></span> </p>
</section>
<?php echo Form::hidden('token',$token);?>
<section class="t-login-footer">
    <p class="t-error"></p>
	<input type="submit" class="t-red-btn" value="确定">
</section>
<?php echo Form::close();?>
<?php include Kohana::find_file('views', 'public/mask');?>
</body>
</html>

<script>
    (function($){
        $(function(){
            $("input[name='invitecode']").blur(function(){
                commonUtil.invitecode(this.value);
            });
            //登录按钮提交
            $("#InviteForm").submit(function(){
                var invitecode=$("input[name='invitecode']").val();
                if( commonUtil.invitecode(invitecode)!= true){
                    return false;
                }
                //return true;
                $.ajax({
                    url:'<?php echo URL::site('Invitecode/doinvite');?>',
                    type:'POST',
                    data:$(this).serialize(),
                    dataType:'json',
                    async: false,  //同步发送请求t-mask
                    beforeSend:function(){
                        $('.t-mask').show();
                    },
                    success:function(result){
                        unique=result.status;
                        $('.t-mask').hide();
                    },
                    error:function(){
                        commonUtil.tips("邀请码校验失败");
                        return false;
                    }
                });
                if(unique===true){
                    return true;
                }else{
                    commonUtil.waring(unique);
                    return false;
                }
                return false;
            });
        });
        var commonUtil={
            invitecode:function(invitecode){
                invitecode=$.trim(invitecode);
                if(invitecode =="" || invitecode == null ) {
                    commonUtil.waring('请输入邀请码');
                    return false;
                }
                if(invitecode.length!=4) {
                    commonUtil.waring('邀请码格式不正确');
                    return false;
                }
                commonUtil.tips();
                return true;
            },
            tips:function(){
                $(".t-error").text('');
            },
            waring:function(msg){
                $(".t-error").text(msg);

            }
        }
    })(jQuery);
</script>
