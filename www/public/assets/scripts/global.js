$(document).ready(function () {
    $('.scroll-to-top').click(function () {
        const target = $(this).data("target");
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });

    $(".hamburger").click(function(){
        $("nav.sidebar-nav").toggleClass("is-active");
        $(this).toggleClass("is-active");
    });
<<<<<<< HEAD
=======

    $(".footer-title").click(function() {
        let parent = $(this).parent()[0];
        parent.classList.toggle("is-active");
    })
>>>>>>> e881ede0f36dd95b53201673b4a386a88f13c4c6
});