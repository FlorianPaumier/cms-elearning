$(document).ready(function () {
    $('.scroll-to-top').click(function () {
        const target = $(this).data("target");
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });

    $(".hamburger").click(function(){
        $("nav.sidebar-nav").toggleClass("is-active");
        $(this).toggleClass("is-active");
    });
});