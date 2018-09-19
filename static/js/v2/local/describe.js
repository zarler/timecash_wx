function downloadContract($id) {
    if(commonUtil.isnull($id)!=true){
        commonUtil.showmsg('订单id为空!');
        return false;
    }
    load = layer.msg('获取中', {time: -1,icon: 16});
    $.ajax({
        url: seajs.data.vars.url,
        type: 'POST',
        //data:{money:money,day:day,coupinid:coupinid,offset:offset,type:type,poundage:poundage,ensure_rate_bu:ensure_rate_bu,latitude:latitude,longitude:longitude},
        data: {
            id: $id
        },
        dataType: 'json',
        async: true,  //同步发送请求t-mask
        beforeSend: function () {
        },
        success: function (result) {
            if (result.status == true) {
                commonUtil.unlock();
                commonUtil.tips();
                location.href = result.url;
            } else {
                commonUtil.showmsg(result.msg);
                commonUtil.revisecss();
                commonUtil.unlock();
                return false;
            }
        },
        error: function () {
            commonUtil.unlock();
            commonUtil.waring("表单发送失败！");
            commonUtil.revisecss();
            return false;
        }
    });
}