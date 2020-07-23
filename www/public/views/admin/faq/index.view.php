@extend(templates/back)

@section(body)
<section>
    <a href="@path(admin_faq_new)" id="add-faq" class="btn c-blue">Ajouter</a>
</section>
<section>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Question</th>
            <th>Actions</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach( $questions as $question):
            ?>
            <tr>
                <td><?= $question->getId(); ?></td>
                <td><?= $question->getQuestion(); ?></td>
                <td>
                    <a href="/admin/faq/edit/<?= $question->getId(); ?>">
                        <button id="edit-faq" class="btn btn-danger">Modifier</button>
                    </a>
                </td>
                <td>
                    <form action="/admin/faq/delete/<?= $question->getId(); ?>" method="post">
                        <button id="delete-faq" class="btn btn-danger">Supprimer</button>
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