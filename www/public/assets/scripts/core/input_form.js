$(document).ready(function () {
    const add = $(".add-input");

    add.click((e) => {

        let length = $(e.target).data("length");
        let id = $(e.target).data("id");

        const input = $(".input-skeleton").clone();
        const regex = new RegExp(input.data("target"), 'g')
        const regexId = new RegExp("FORM_ID", 'g')

        input.removeClass("input-skeleton")
        input.addClass("list-input")

        input[0].innerHTML = input[0].innerHTML.replace(regex, length);
        input[0].innerHTML = input[0].innerHTML.replace(regexId, id);
        input.attr('data-id', length)

        let button = $(input).find(".delete-button");

        button.click((e) => {
            let index = $(e.target).data("index")
            let ul = $(`ul[data-id='${index}']`);
            ul.remove();
            resetPosition(".list-input");
        })

        const select = input.find("select").change((ele) => {
            const value = ele.target.value
            if(value === "checkbox" || value === "select" || value === "radio"){
                input.find(".choices").toggleClass("d-none")
            }
        })

        $(".form").append(input);
        length += 1;
        $(e.target).data("length", length);


        (() => {
            enableDragSort('drag-sort-enable')
        })();
    })

    addEventListener("dragend", () => {
        resetPosition(".list-input");
    })

    if (json) {

        const form = document.querySelector("form");
        const id = $(form).data("id");

        for (const jsonKey in json) {

            let ele = json[jsonKey]
            add.click()
            const length = $(".list-input").length;
            let html = $("ul.list-input")[length - 1]
            $(html).find("select")[0].options.selectedIndex = findSelectIndex($(html).find("select")[0], ele.type);

            if (ele.required === 1) {
                $(html).find("input:checkbox")[0].click();
            }

            let inputs = $(html).find("input:text");

            for (let i = 0; i < inputs.length; i++) {

                if (inputs[i].id === `${id}[${length}][label_input]`) {
                    inputs[i].value = ele.label
                }

                if (inputs[i].id === `${id}[${length}][placeholder_input]`) {
                    inputs[i].value = ele.placeholder
                }

                if (inputs[i].id === `${id}[${length}][choice_input]`) {
                    let choices = JSON.parse(ele.choices);

                    let count = 1;
                    let choicesLength = Object.keys(choices).length
                    console.log(choices)

                    for (key in choices){
                        inputs[i].value += key+":"+choices[key]

                        if(count < choicesLength){
                            inputs[i].value += ","
                        }

                        count++
                    }

                }
            }

            if($(html).find("select")[0].value === "checkbox")
                $(html).find(".choices").toggleClass("d-none")

            $(html).find(".input-id")[0].value = ele.id;
        }
    }
})

function findSelectIndex(select, value) {
    let options = select.options;
    let index = 0;

    for (let i = 0; i < options.length; i++) {
        if (options[i].value === value) {
            index = i;
            break;
        }
    }
    return index;
}
