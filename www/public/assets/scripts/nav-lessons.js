$(document).ready(function () {
    // code
    let hamburger = document.querySelector("#hamburger-11")

    hamburger.click((ele) => {
        let headerTarget = ele.target.getAttribute("data-target")
        let header = document.querySelector(headerTarget)
        let main = document.querySelector("main")
        let footer = document.querySelector("footer")

        console.log(headerTarget,header, main, footer);
        ele.target.classList.toggle("is-active")
        header.classList.toggle("is-open")
        main.classList.toggle("d-none")
        footer.classList.toggle("d-none")
    })
});
