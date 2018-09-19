function appCallback(msg) {
    var json = eval('(' + msg + ')');
    if(json.type == 'getBank'){
        $('.repayope2 img').attr('src','/static/images/v2/bank/'+json.data.bankCode+'.png');
        $('.repayope2 em').text(json.data.bankName);
    }

}