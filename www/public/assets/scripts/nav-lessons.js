$(document).ready(function () {
    // code
    let hamburger = document.querySelector("#hamburger-11")

    hamburger.click((ele) => {
        let headerTarget = ele.target.getAttribute("data-target")
        let header = document.querySelector(headerTarget)
        let main = document.querySelector("main")
        let footer = document.querySelector("footer")

        ele.target.classList.toggle("is-active")
        header.classList.toggle("is-open")
        main.classList.toggle("d-none")
        footer.classList.toggle("d-none")
    })

    let links = document.querySelectorAll("#pagination>a")

    links.forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();

            const option = e.target.getAttribute("data-option")
            const chapter = e.target.getAttribute("data-chapter")
            const url = e.target.getAttribute("href")
            const id = document.getElementById("lesson").getAttribute("data-id")

            const response = fetch("/cours/" + id + "/management", {
                method: "POST",
                body: JSON.stringify({
                    option,
                    chapter
                }),
                headers: {
                    "Content-Type": "application/json"
                },
            }).then(res => {
                return res.json();
            }).then(res => {
                window.location.href = url;
            }).catch(err => {
                console.error(err)
            })
        })
    })
});
