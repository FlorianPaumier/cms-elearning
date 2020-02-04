$(document).ready(function () {
    $('.scroll-to-top').click(function () {
        const target = $(this).data("target");
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });

    $(".hamburger").click(function(){
        $(this).toggleClass("is-active");
    });
});