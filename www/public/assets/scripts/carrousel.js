$(document).ready(function () {
//setInterval(showTestimonies, 3000);
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

    $(testimonies[indexTestimony])[0].classList.remove("active");
    $(testimonies[indexTestimony + 1])[0].classList.add("active");

}