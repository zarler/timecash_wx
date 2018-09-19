/**
 * Created by liujinsheng on 16/9/7.
 */
define(function(require,exports,module){
    //轮播图
    //require('js/slider');
    require('css/v2/local/peoplepullmore.css');
    $(document).ready(function(){
        $('.morePeople').click(function () {
            if(seajs.data.vars.last_id>0){
                $.ajax({
                    url:seajs.data.vars.url,
                    type:'POST',
                    // data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
                    data:{last_id:seajs.data.vars.last_id},
                    dataType:'json',
                    async: true,  //同步发送请求t-mask
                    beforeSend:function(){
                    },
                    success:function(result){
                        if(result.status == true){
                            var json = json = eval('(' + result.msg + ')');
                            seajs.data.vars.last_id = json.last_id;
                            $('.left-div').append(json.strUl);
                            $('.moreSection').html(json.moreSubmit);
                        }else{
                            console.log(result.msg);
                        }
                    },
                    error:function(){
                        console.log('表单发送失败');
                        // commonUtil.unlock();
                        // commonUtil.waring("表单发送失败！");
                        return false;
                    }
                });
            }




            // $('.left-div').append('<ul class="ulcss"><li>156****8013</li><li>已注册</li><li>10元</li></ul>');
            // console.log(11111111);
        });

    });
});
