<?php include Kohana::find_file('views', 'public/head');?>

<script>
	
</script>

<body>
<section class="t-login-nav">
    <div class="t-login-nav-1"><a href="javascript:history.go(-1);" class="t-return"></a>立即借款</div>
</section>
<p class="t-loan"><span class="t-line"></span><em>收款/还款银行卡</em><span></span></p>
<section class="t-login-center t-mt0px">
    <a href="javascript:;" class="t-re-bank"><p>借记卡所属银行<span></span></p></a>
	<input type="hidden" name="bank_id" />
	<input type="hidden" name="bank_code" />
    <p class="t-login-center-1 t-bt1px"><input type="text" name="card_no" placeholder="您本人的借记卡卡号" class="form-control" style="left: 0px;"><span class="t-icon-close"></span></p>
    <p class="t-login-center-1"><?php echo $mobile;?></span></p>
    <!--<p class="t-login-center-1"><input type="text" placeholder="短信验证码" class="t-w240px form-control"><span class="t-icon-close t-mr"></span> <button type="button" class="t-pwd-code">获取验证码</button></p>-->
</section>
<section class="t-login-footer">
    <p class="t-error"></p>
    <p class="t-register1"><input type="checkbox" id="checkbox_a1" class="chk_1" /><label for="checkbox_a1"></label>同意<a href="<?php echo URL::site('Protocol/conten?num=4'); ?>">《代扣服务协议》</a></p>
    <input type="submit" class="t-red-btn t-red-bank" value="下一步">
    <dl class="t-re-bank1">
        <dt></dt>
        <dd>借款卡必须为本人名下借记卡，并作为您的还款账号，如需修改请联系微信客服。</dd>
    </dl>
</section>
<!-- 选择银行卡弹出 -->
<div class="t-box_alert" id="t-box_alert" style="display:none;">
    <div class="t-bomb_box t-bomb_box-5">
        <h3 class="t-bomb_box-1 t-bomb_box-4">请选择银行<span class="t-bomb_close"></span></h3>
        <div class="t-bomb_box-6">
		<?php foreach($bank as $v){
			echo '<p class="t-bank-car" code="'.$v['unionpay_code'].'" data="'.$v['name'].'" id="'.$v['id'].'"><input type="radio" name="bank_card_str" id="checkbox_a1'.$v['id'].'" class="chk_1" /><label for="checkbox_a1'.$v['id'].'"></label>'. HTML::image('static/images/bank-img/'.$v['code'].'.gif',array('class'=>'t-bank-img')).'</p>';
		}?>
		</div>
    </div>
</div>
<div class="t-box_alert" id="t-box_alert2" style="display:none;">
	<div class="t-bomb_box" id="t-bomb_box">
		<h3 class="t-bomb_box-1">重要提示</h3>
		<p class="t-bomb_box-2">
		请在借款到期前保证卡内有足够余额，到期时会自动划扣卡内余额还款。<br /><br />
		若出现逾期还款，将从您的信用卡内扣除未还款金额及罚息。</p>
	   <div class="t-bomb_btn"><a class="t-gray-btn btn-time" href="javascript:;">确定(10 s)</a></div>
	</div>
</div>
<?php include Kohana::find_file('views', 'public/mask');?>
</body>
</html>
<script>
(function($){
     $(function(){
		 //银行卡号
         $("input[name='card_no']").blur(function(){
              commonUtil.card_no(this.value);
         });
		 //银行点击显示
		 $('.t-re-bank').click(function(){
			 $('#t-box_alert').show();
			 $('.t-mask').show();
		 })
		 //银行点击隐藏
		 $('.t-bomb_close').click(function(){
			 $('#t-box_alert').hide();
			 $('.t-mask').hide();
		 })
		 //点击银行的悬浮框  添加到页面银行
		 $('.t-bomb_box-6 p').click(function(){
			 name = $(this).attr('data');
			 id = $(this).attr('id');
			 checkedid = $('input:radio[name="bank_card_str"]:checked').attr("id");
			 $("#".checkedid).removeAttr("checked");
			 $("#checkbox_a1"+id).attr("checked","checked");
			 code = $(this).attr('code');
			 $('.t-re-bank p').text(name);
			 $("input[name='bank_id']").val(id);
			 $("input[name='bank_code']").val(code);
			 $('#t-box_alert').hide();
			 $('.t-mask').hide();
		 })
         //登录按钮提交
         $(".t-red-bank").click(function(){
			 commonUtil.lockup();
             var bank=$("input[name='bank_id']").val();
             var card_no=$("input[name='card_no']").val();
			 var aggreement = $('#checkbox_a1').is(':checked');
			 if(commonUtil.bank(bank)!=true){
				 commonUtil.unlock();
				return false;
			 }
			 if(commonUtil.aggreement(aggreement)!=true){
				 commonUtil.unlock();
				return false;
			 }
             if( commonUtil.card_no(card_no)!= true){
				 commonUtil.unlock();
                return false;
             }
			$.ajax({
				url:"<?php echo URL::site('Functions/dobank?1234');?>",
				type:'POST',
				data:{bank:bank,card_no:card_no,aggreement:aggreement},
				dataType:'json',
				async: true,  //同步发送请求t-mask
				beforeSend:function(){
				},
				success:function(result){
					if(result.status == true){
						commonUtil.unlock();
						commonUtil.tips();
						$("#t-box_alert2").show();
						$('.t-mask').show();
						var a=$("#t-bomb_box").height();
						$("#t-bomb_box").css({'marginTop':-a/2});
						var times = 10;
						durl='<?php echo URL::site('Borrowmoney/guarantee?ban=1');?>';
						$('.btn-time').addClass('t-gray-btn');
						$(".btn-time").attr('disabled',true);
						$('.btn-time').removeClass('t-red-btn');
						timer = setInterval(function() {
							times--;
							if(times > 0) {
								$('.btn-time').text('确定('+times+' s)');
							} else {
								times = 10;
								$('.btn-time').text('确定');
								$('.btn-time').attr('href',durl);
								$('.btn-time').removeClass('t-gray-btn');
								$('.btn-time').addClass('t-red-btn');
								clearInterval(timer);
							}
						}, 1000);
						return false;
					}else{
						commonUtil.waring(result.msg);
						commonUtil.unlock();
						return false;
					}
				},
				error:function(){
					commonUtil.unlock();
					commonUtil.tips("表单校验失败");
					return  false;
				}
			});
         });
     });
    var commonUtil={
		bank:function(bank){
                   bank=$.trim(bank);

                   if(bank =="" || bank == null ) {
                      commonUtil.waring('请选择银行');
                       return false;
                   }
                    commonUtil.tips();
                    return true;
             },

		aggreement:function(aggreement){
                  if(aggreement){
					commonUtil.tips();
                    return true;
				  }else{
					commonUtil.waring('请同意协议');
                    return false;
				  }
             },
		 card_no:function(card_no){
                   card_no=$.trim(card_no);
                  var pattern = /^\d{16}|\d{17}|\d{18}|\d{19}$/;
                   if(card_no =="" || card_no == null ) {
                      commonUtil.waring('银行卡号不能为空');
                       return false;
                   }
                   if(!card_no.match(pattern)) {
                       commonUtil.waring('银行卡号格式不正确');
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

         },
		lockup:function(){
			$('.t-red-btn').addClass('t-gray-btn');
			$(".t-red-btn").attr('disabled',true);
			$('.t-red-btn').removeClass('t-red-btn');
			load = layer.load(2, {shade: false});
			$('.t-mask').show();
		},
		unlock:function(){
			$('.t-gray-btn').addClass('t-red-btn');
			$(".t-red-btn").attr('disabled',false);
			$('.t-gray-btn').removeClass('t-gray-btn');
			layer.close(load);
			$('.t-mask').hide();
		}

    }

})(jQuery);
</script>