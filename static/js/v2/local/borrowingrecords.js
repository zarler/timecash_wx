var $document   = $(document);
var ajax_getting = true;
//选项卡
// var last_id = seajs.data.vars.last_id;
// var total = seajs.data.vars.total;
var innerHeight = window.innerHeight;
var timer2 = null;
var last_id = seajs.data.vars.last_id;
var total = seajs.data.vars.total;

function getMore() {
        load = layer.msg('加载中', {time: -1,icon: 16});
        $.ajax({
                url: '/Functions/GetMoreOrder?last_id=' + last_id,
                type: 'GET',
                dataType: 'json',
                success: function (data){
                    layer.close(load);
                    if (data.status == true) {
                        var arrText = [];
                        for (var i = 0, t; t = data.data[i++];) {
                            arrText.push("<a href='/User/Singledescribe?id="+t.id+"'><ul class='ulli border-top'><li class='float_left'>"+t.start_time+"</li><li>"+t.expire_time+"</li><li style='color:#ff8470;text-align: center;'>"+t.loan_amount+"<span class='float_right' style='width: 1rem;height: 1rem;position: relative;top: .1rem;background: url(/static/images/v2/icon-into.png) no-repeat;background-size: contain;'></span></li></ul></a>");
                            arrText.push("</div></div><div class='clear'></div></div>");
                        }
                        $('.b-withdraw-list a:last').after(arrText.join(''));
                        total = data.total;
                        last_id = data.last_id;
                    }
                    if(total<10){
                        $('.b-withdraw-list button').remove();
                    }
                }
        });
}
