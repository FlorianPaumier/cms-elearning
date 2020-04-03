$(document).ready(function () {
    let button = $(".add-element");
    let collection = $("ul.jumbutron");

    collection.data("index", $collectionHolder.find('li').length);

    button.click(function (e) {
        e.preventDefault();
        addCollections(this, collection.data("index"));
    });
});

function addCollections(source, index) {
    let target = $("#" + $(source).data("target"));
    let content = $($(target).data("prototype"));

    let container = document.createElement("li");

    container = addElements(container, content);
    container.setAttribute("data-index", index + 1);
    $(container).find(".add-element").data("index", index + 1);
    target.prepend(container);

    $(container).replace(/__index__/g, index);
    $(container).find(".add-element").click(function (e) {
        e.preventDefault();
        addCollections(this);
    });

    updateElements($(container));
}

function addElements(target, content) {
    content.each((key, element) => {
        target.append(element);
    });

    return target;
}
//# sourceMappingURL=collection.js.map