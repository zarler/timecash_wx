$(function() {
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
    var lostDeg = [0, 72, 144, 216, 288, 360];
    // 0 对应iPhonex 60对应88元红包 120对应3元红包  180对应20元免息券 240对应8元红包 300对应1元红包
    var prizeDeg = [0, 72, 144];
    var prize, sncode;
    var count = 0;
    var now = 0;
    var a = 0.03;
    var outter, inner, timer, running = false;
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
                if (prize != null) {
                    $("#sncode").text(sncode);
                    var type = "";
                    if (prize == 1) {
                        type = "一等奖"
                    } else if (prize == 2) {
                        type = "二等奖"
                    } else if (prize == 3) {
                        type = "三等奖"
                    }
                    $("#prizetype").text(type);
                    $("#result").slideToggle(500);
                    $("#outercont").slideUp(500)
                } else {
                    // alert("谢谢您的参与，下次再接再厉")
                   

                }
            },
            200)
        }
    }
    function start(deg) {
        deg = deg || lostDeg[parseInt(lostDeg.length * Math.random())];
        running = true;
        clearInterval(timer);
        totalDeg = 360 * 5 + deg;
        steps = [];
        now = 0;
        countSteps();
        requestAnimFrame(step)
    }
    window.start = start;
    outter = document.getElementById('outer');
    inner = document.getElementById('inner');
    i = 10;
    $("#inner").click(function() {
        if (running) return;
        if (count >= 3) {
            alert("您已经抽了 3 次奖。");
            return
        }
        if (prize != null) {
            alert("亲，你不能再参加本次活动了喔！下次再来吧~");
            return
        }
        $.ajax({
            url: "index.php",
            dataType: "json",
            data: {
                token: "o7MB9ji5fQRsE0ZoVAMU7SlnRyMI",
                ac: "activityuser",
                tid: "5",
                t: Math.random()
            },
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
                if (data.error == "invalid") {
                    alert("您已经抽了 3 次奖。");
                    count = 3;
                    clearInterval(timer);
                    return
                }
                if (data.error == "getsn") {
                    alert('本次活动你已经中过奖，本次只显示你上次抽奖结果!兑奖SN码为:' + data.sn);
                    count = 3;
                    clearInterval(timer);
                    prize = data.prizetype;
                    sncode = data.sn;
                    start(prizeDeg[data.prizetype - 1]);
                    return
                }
                if (data.success) {
                    prize = data.prizetype;
                    sncode = data.sn;
                    start(prizeDeg[data.prizetype - 1])
                } else {
                    prize = null;
                    start()
                }
                running = false;
                count++
            },
            error: function() {
                prize = null;
                start();
                running = false;
                count++
            },
            timeout: 4000
        })
    })
});