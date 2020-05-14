$(document).ready(function () {

    $(".hamburger").click(function () {
        $("#menu").toggleClass("is-active")
        $("main").toggleClass("d-none")
        $("footer").toggleClass("d-none")
    });

});