$(document).ready(function () {
    const add = $(".add-input");
    add.click((e) => {

        let length = $(e.target).data("length");
        const input = $(".input-skeleton").clone();
        const regex = new RegExp(input.data("target"), 'g')
        input.removeClass("input-skeleton")
        input.addClass("list-input")
        input[0].innerHTML = input[0].innerHTML.replace(regex, length);
        input.attr('data-id', length)
        let button = $(input).find(".delete-button");

        button.click((e) => {
            let index = $(e.target).data("index")
            let ul = $(`ul[data-id='${index}']`);
            ul.remove();
            resetPosition(".list-input");
        })

        $(".form").append(input);
        length += 1;
        $(e.target).data("length", length);

        (()=> {
            enableDragSort('drag-sort-enable')
        })();
    })

    addEventListener("dragend", () => {
        resetPosition(".list-input");
    })

    for (const jsonKey in json) {
        let ele = json[jsonKey]
        add.click()
        const length = $(".list-input").length;
        let html = $("ul.list-input")[length - 1]
        $(html).find("select")[0].options.selectedIndex = findSelectIndex($(html).find("select")[0], ele.type) ;

        if(ele.required === 1){
            $(html).find("input:checkbox")[0].click();
        }

        let inputs = $(html).find("input:text");

        for (let i = 0; i < inputs.length; i++) {

            if(inputs[i].id === `admin_contact[${length}][label_input]`){
                inputs[i].value = ele.label
            }

            if(inputs[i].id === `admin_contact[${length}][placeholder_input]`){
                inputs[i].value = ele.placeholder
            }
        }

        $(html).find(".input-id")[0].value = ele.id;
    }
})

function findSelectIndex(select, value) {
    let options = select.options;
    let index = 0;

    for(let i = 0; i < options.length; i++){
        if(options[i].value === value){
            index = i;
            break;
        }
    }
    return index;
}