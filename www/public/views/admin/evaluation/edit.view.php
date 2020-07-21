@extend(templates/back)

@section(styles)
<link type="text/css" rel="stylesheet" href="/assets/styles/admin/contact.css" />
@endsection

@section(body)

<div class="container-form form-container">
    <form action="" method="post" data-id="admin_evaluation">

    <section class="form  drag-sort-enable">
        <label for="admin_evaluation_class">Titre du formulaire <input type="text" name="admin_evaluation_class" required value="<?= $form->getName() ?>"></label>
        <span>
            <span></span>
            <input class="tgl tgl-skewed"
                   type="checkbox"
                   id="admin_evaluation_enable"
                   name="admin_evaluation_enable" <?= $form->isEnabled() ? "checked" : "" ?> >
            <label class="tgl-btn" data-tg-off="Désactiver" data-tg-on="Activer" for="admin_evaluation_enable"></label>
        </span>
        <textarea name="admin_evaluation_description" id="admin_evaluation_description" cols="30" rows="10" class="ckeditor"><?= $form->getDescription() ?></textarea>
        <div>
            <label for="admin_evaluation_lesson">Cours</label>
            <select name="admin_evaluation_lesson" id="admin_evaluation_lesson">
                <?php foreach ($lessons as $lesson): ?>
                    <option value="<?= $lesson->getId() ?>" <?= $form->getLesson()->getId() == $lesson->getId() ? "selected" : "" ?>><?= $lesson->getTitle() ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </section>
        <button>Valider</button>
    </form>
    <button type="button" class="add-input" data-length="1" data-id="admin_evaluation">Ajout</button>

</div>

@include(admin/partials/skeleton)
@endsection

@section(javascripts)
<script type="text/javascript" src="/assets/scripts/ckeditor.js"></script>
<script type="text/javascript" src="/assets/scripts/core/sortable.js"></script>
<script>
    const json = {{inputs}}
</script>
<script type="text/javascript" src="/assets/scripts/core/input_form.js"></script>

@endsection