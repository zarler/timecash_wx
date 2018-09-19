function LoadMore(type) {
    switch (type){
        case 'gain':
            //console.log(seajs.data.vars.gainlastId);
            var lastId = seajs.data.vars.gainlastId;
            break;
        case 'used':
            var lastId = seajs.data.vars.userlastId;
            break;
    }
    if(lastId>0){
        var layerShaw = layer.open({type: 2});
        $.ajax({
            url:seajs.data.vars.apiUrl,
            type:'POST',
            data:{last_id:lastId,type:type},
            dataType:'json',
            async: true,  //同步发送请求t-mask
            beforeSend:function(){
            },
            success:function(result){
                layer.close(layerShaw);
                if(result.status == true){
                    var json = eval('(' + result.data + ')');
                    switch (type){
                        case 'gain':
                            //console.log(seajs.data.vars.gainlastId);
                            seajs.data.vars.gainlastId = json.last_id;
                            $('.GainList .listshow').append(json.strList);
                            break;
                        case 'used':
                            seajs.data.vars.userlastId = json.last_id;
                            $('.UseList .listshow').append(json.strList);
                            break;
                    }
                }else{
//						commonUtil.waring(result.msg);
//						commonUtil.unlock();
//						return  false;
                }
            },
            error:function(){
                commonUtil.unlock();
                commonUtil.waring("表单发送失败！");
                return false;
            }
        });

    }
}