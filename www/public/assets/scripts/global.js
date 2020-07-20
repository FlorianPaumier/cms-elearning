$(document).ready(function () {
    $('.scroll-to-top').click(function () {
        const target = $(this).data("target");
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });

    $(".hamburger").click(function(){
        $("nav.sidebar-nav").toggleClass("is-active");
        $(this).toggleClass("is-active");
    });

    $(".footer-title").click(function() {
        let parent = $(this).parent()[0];
        parent.classList.toggle("is-active");
    })

    $('.close').click((e) => {
        const target = e.target.closest("."+e.target.getAttribute("data-dismiss"))
        target.classList.add("hide")

    });
});