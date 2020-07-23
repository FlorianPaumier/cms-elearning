@extend(templates/back)

@section(body)
<section>
    <a href="@path(admin_sondage_new)" id="add-sondage" class="btn c-blue">Ajouter</a>
</section>
<section>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Question</th>
            <th>Date de création</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach( $sondages as $sondage):
            ?>
            <tr>
                <td><?= $sondage->getId(); ?></td>
                <td><?= $sondage->getQuestion(); ?></td>
                <td><?= !is_null($question->getCreatedAt()) ? $question->getCreatedAt()->format("d/m/Y") : "N/A"; ?></td>
                <td></td>
                <td>
                    <a href="/admin/sondage/edit/<?= $sondage->getId(); ?>">
                        <button id="edit-sondage" class="btn btn-danger">Modifier</button>
                    </a>
                </td>
                <td>
                    <form action="/admin/sondage/delete/<?= $sondage->getId(); ?>" method="post">
                        <button id="delete-sondage" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>
</section>
@endsection