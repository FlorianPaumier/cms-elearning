let hamburger = document.getElementsByClassName("hamburger")[0]

hamburger.addEventListener("click", (ele) => {
    let headerTarget = ele.target.getAttribute("data-target")
    let header = document.querySelector(headerTarget)
    let main = document.querySelector("main")
    let footer = document.querySelector("footer")

    console.log(headerTarget)
    ele.target.classList.toggle("is-active")
    header.classList.toggle("is-open")
    main.classList.toggle("d-none")
    footer.classList.toggle("d-none")
})