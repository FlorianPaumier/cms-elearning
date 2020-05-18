let index = 0;

$(document).ready(function () {
    let button = $(".add-element");
    let collection = $("ul.collection");

    collection.data("index", collection.find('li').length);

    button.click(function (e) {
        e.preventDefault();
        addCollections(collection)
    });

});

function addCollections(containerHolder) {

    let prototypeStr = $(containerHolder).data("prototype");

    const key = $(containerHolder).data("key");

    let index = containerHolder.find("li").length;

    const reg = new RegExp(key, "g")

    let prototype = prototypeStr.replace(reg, index);
    console.log(prototype);

    let container = $("<li>").append(prototype);
    containerHolder.append(container);

    let addButton = container.find(".add-element");

    if(addButton.length > 0){
        $(addButton)[0].setAttribute("data-index", index );
    }

    addButton.click(function (e) {
        e.preventDefault();
        addCollections(container.find("ul"));
    });

    updateElements(container);
}


function addElements(target, content) {
    content.each((key, element) => {
        target.append(element)
    });

    return target;
}
