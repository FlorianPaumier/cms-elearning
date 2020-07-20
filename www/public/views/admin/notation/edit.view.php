@extend(templates/back)

@section(styles)
<link rel="stylesheet" href="/assets/styles/admin/form.css">
@endsection

@section(body)
<section>
    <a href="@path(admin_notation_index, <?= $eval->getId(); ?>)" id="add-lesson" class="btn c-blue">Retour</a>
</section>
<section class="col-6">
    <section class="mb-5">
        <h2>Information Utlisateur</h2>
        <ul class="list-unstyle">
            <li>Utilisateur : <?= $evaluation->getUser()->getEmail(); ?></li>
            <li>Date : <?= $evaluation->getCreatedAt()->format("d-m-Y"); ?></li>
            <li>Evaluation : <?= $eval->getName(); ?></li>
        </ul>
    </section>
    <section>

            <h2>Information Evaluation</h2>
        <ul class="list-unstyle">
            <?php foreach ($inputs as $input): ?>
                <li>
                    <?= $input->getInput()->getLabel() ?> :
                    <?= $input->getValue() ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <form action="" method="post">
            <label for="rating">Note : </label>
            <input type="number" name="rating" id="rating" value="<?= $evaluation->getRating() ?>">
            <button type="submit">Valider</button>
        </form>
    </section>
</section>
@endsection
