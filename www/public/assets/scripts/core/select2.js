$(document).ready(function () {
    $("select.select-two").each((key, ele) => {
        console.log({ele})
        $(ele).select2()
    });
})