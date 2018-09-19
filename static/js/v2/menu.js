$(window).load(function(){
    $("#clickl").click(function(){
        $(".main-menu").addClass("block");
    });
    $(function() {
        $('.main-menu').simplerSidebar({
            opener: '#clickl',
            sidebar: {
                align: 'left',
                width: 500
            }
        });
    });
    // $(".settings img").show();
    //$(".main-menu").show();
});