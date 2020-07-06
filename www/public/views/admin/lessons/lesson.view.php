@extend(templates/back)

@section(styles)
<link rel="stylesheet" href="/assets/styles/admin/form.css">
@endsection

@section(body)
<section>
    <a href="@path(admin_lesson_new)" id="add-lesson" class="btn c-blue">Ajout</a>
</section>
<section>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>title</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach( $lessons["data"] as $lesson):

            ?>
            <tr>
                <td><?= $lesson->getId(); ?></td>
                <td><?= $lesson->getTitle(); ?></td>
                <td class="row">
                    <a href="@path(admin_lesson_edit, <?= $lesson->getId(); ?>)">
                        <button class="btn btn-succes">Modifier</button>
                    </a>
                    <form action="/admin/lesson/delete<?= $lesson->getId() ?>">
                        <button id="delete-lesson" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>

    <?= $lessons["links"] ?>
</section>
@endsection