    // 转盘
    window.requestAnimFrame = (function() {
        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
        function(callback) {
            window.setTimeout(callback, 1000 / 60)
        }
    })();
    var totalDeg = 360 * 3 + 0;
    var steps = [];
    //var lostDeg = [36, 66, 96, 156, 186, 216, 276, 306, 336  0 60 120 180 240 300];
    var lostDeg = [0, 60, 120, 180, 240, 300];
    // 0 对应iPhonex 60对应88元红包 120对应3元红包  180对应20元免息券 240对应8元红包 300对应1元红包
    var prizeDeg = [0, 60, 120];
    var prize, sncode;
    var count = 0;
    var now = 0;
    var a = 0.03;
    var outter, inner, timer, running = false;


    reqData = null;

    function countSteps() {
        var t = Math.sqrt(2 * totalDeg / a);
        var v = a * t;
        for (var i = 0; i < t; i++) {
            steps.push((2 * v * i - a * i * i) / 2)
        }
        steps.push(totalDeg)
    }
    function step() {
        outter.style.webkitTransform = 'rotate(' + steps[now++] + 'deg)';
        outter.style.MozTransform = 'rotate(' + steps[now++] + 'deg)';
        if (now < steps.length) {
            requestAnimFrame(step)
        } else {
            running = false;
            setTimeout(function() {
                    if(reqData.money==0){
                        $('.coupon').show();
                    }else{
                        $('.luckmoney').show();
                    }
                    // if (prize != null) {
                //     $("#sncode").text(sncode);
                //     var type = "";
                //     if (prize == 1) {
                //         type = "一等奖"
                //     } else if (prize == 2) {
                //         type = "二等奖"
                //     } else if (prize == 3) {
                //         type = "三等奖"
                //     }
                //     $("#prizetype").text(type);
                //     $("#result").slideToggle(500);
                //     $("#outercont").slideUp(500)
                // } else {
                //     // alert("谢谢您的参与，下次再接再厉")
                // }
            },
            200)
        }
    }
    function start(deg,bool) {
        // deg = deg || lostDeg[parseInt(lostDeg.length * Math.random())];
        running = true;
        clearInterval(timer);
        totalDeg = 360 * 5 + deg;
        steps = [];
        now = 0;
        if(bool){
            countSteps();
            requestAnimFrame(step)
        }
    }
    window.start = start;
    outter = document.getElementById('outer');
    inner = document.getElementById('inner');
    i = 10;
    function subMit() {
        if (running) return;
        if (count >= 1) {
            $('.user').show();
            return
        }

        $.ajax({
            url: seajs.data.vars.reqUrl,
            dataType: "json",
            type: 'POST',
            data: {one:1},
            beforeSend: function() {
                running = true;
                timer = setInterval(function() {
                    i += 5;
                    outter.style.webkitTransform = 'rotate(' + i + 'deg)';
                    outter.style.MozTransform = 'rotate(' + i + 'deg)'
                },
                1)
            },
            success: function(data) {
                if (data.status==true) {
                    // prize = data.prizetype;
                    // sncode = data.sn;
                    // console(prizeDeg[data.prizetype - 1]);
                    reqData = data.msg;
                    start(data.msg.deg,true);



                    $('.activity-pop-text1 span').text(data.msg.prize);
                    $('.activity-pop-draw-luckmoney em').text(data.msg.money);
                    $('.activity-text').text('您有0次抽奖机会');


                } else {
                    count = 1;
                    clearInterval(timer);
                    layerMobile.showlayer(data.msg);
                    layerMobile.changeCssMsg();
                    return;
                    // running = false;
                }
                running = false;
                count++
            },
            error: function() {
                prize = null;
                start(60,false);
                running = false;
                count++
            },
            timeout: 4000
        })
        }
