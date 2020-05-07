@extend(templates/back)

@section(styles)
<link type="text/css" rel="stylesheet" href="/assets/styles/admin/contact.css" />
@endsection

@section(body)

<div class="contactForm">
    <form action="" method="post">

    <section class="form  drag-sort-enable">
        <label for="admin_contact_class">Titre du formulaire<input type="text" name="admin_contact_class" required></label>
        <span>
            <span></span>
            <input class=" tgl tgl-skewed"
                   type="checkbox"
                   id="admin_contact_enable"
                   name="admin_contact_enable">
            <label class="tgl-btn" data-tg-off="Désactiver" data-tg-on="Activer" for="admin_contact_enable"></label>
        </span>
    </section>
        <button>Valider</button>
    </form>
    <button type="button" class="add-input" data-length="1">Ajout</button>

</div>

@include(admin/partials/skeleton)
@endsection

@section(javascripts)
<script type="text/javascript" src="/assets/scripts/core/sortable.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $(".add-input").click((e) => {

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
                let ul = $("ul[data-id='"+index+"']");
                console.log(ul)
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

    })
</script>
@endsection