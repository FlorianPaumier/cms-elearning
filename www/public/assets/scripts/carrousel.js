$(document).ready(function () {
    if(false === true){
        //setInterval(showTestimonies, 3000);
    }
});

function showTestimonies() {
    let testimonies = $(".testimonies-carousel").children();
    let indexTestimony = 0;

    testimonies.map(key => {
        if ($(testimonies[key])[0].classList.contains("active")) {
            indexTestimony = key;
        }
    });

    testimonies.map(key => {
        if ($(testimonies[key])[0].classList.contains("active")) {
            indexTestimony = key;
        }
    });

    let length = testimonies.length;

    $(testimonies[indexTestimony])[0].classList.remove("active");

    if(!$(testimonies[indexTestimony + 1])[0]){
        indexTestimony = -1;
    };

    $(testimonies[indexTestimony + 1])[0].classList.add("active");

}