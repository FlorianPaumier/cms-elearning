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
            <label class="tgl-btn" data-tg-off="Activer" data-tg-on="Désactiver" for="admin_contact_enable"></label>
        </span>
    </section>
        <button>Valider</button>
    </form>
    <button type="button" class="add-input">Ajout</button>

</div>

@include(admin/partials/skeleton)
@endsection

@section(javascripts)
<script type="text/javascript" src="/assets/scripts/core/sortable.js"></script>
<script type="text/javascript">
    $(document).ready(function () {


        $(".add-input").click((e) => {
            let input = $($(".input-skeleton").clone());
            input.removeClass("input-skeleton")
            input.addClass("list-input")
            input[0].innerHTML = input[0].innerHTML.replace(/__NAME__/g, $(".list-input").length);
            $(".form").append(input);
            (()=> {
                enableDragSort('drag-sort-enable')
            })();
        })
        for (let i =0; i < 3; i++) {
            $(".add-input").click();
        }
        addEventListener("dragend", () => {
            resetPosition(".list-input");
        })
    })
</script>
@endsection