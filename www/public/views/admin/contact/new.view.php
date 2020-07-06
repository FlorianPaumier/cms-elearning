@extend(templates/back)

@section(styles)
<link type="text/css" rel="stylesheet" href="/assets/styles/admin/contact.css" />
@endsection

@section(body)

<div class="container-form form-container">
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
    <button type="button" class="add-input" data-length="1" data-id="admin_contact">Ajout</button>

</div>

@include(admin/partials/skeleton)
@endsection

@section(javascripts)
<script type="text/javascript" src="/assets/scripts/core/sortable.js"></script>

<script type="text/javascript" src="/assets/scripts/core/input_form.js"></script>
@endsection