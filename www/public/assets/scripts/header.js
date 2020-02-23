$(document).ready(function () {

    $(".hamburger").click(function(){
        if(this.classList.contains("is-active")){
            $(".header-mobile")[0].classList.add("is-open")
            $("main")[0].classList.add("d-none")
        }else{
            $(".header-mobile")[0].classList.remove("is-open")
            $("main")[0].classList.remove("d-none")
        }
    });
});
