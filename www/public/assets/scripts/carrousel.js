$(document).ready(function () {
    setInterval(showTestimonies, 3000);
});

function startCarousel() {
    $(".carousel").each(function (carousel) {

        const carouselChild = $(carousel).children();

        let indexTestimony = 0;

        carouselChild.map(key => {
            if ($(carouselChild[key])[0].classList.contains("active")) {
                indexTestimony = key;
            }
        });

        carouselChild.map(key => {
            if ($(carouselChild[key])[0].classList.contains("active")) {
                indexTestimony = key;
            }
        });

        let length = carouselChild.length;

        $(carouselChild[indexTestimony])[0].classList.remove("active");

        if(!$(carouselChild[indexTestimony + 1])[0]){
            indexTestimony = -1;
        };

        $(carouselChild[indexTestimony + 1])[0].classList.add("active");
    });


}