@extend(templates/back)


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
        foreach( $lessons as $lesson):
            ?>
            <tr>
                <td><?= $lesson->getId(); ?></td>
                <td><?= $lesson->getTitle(); ?></td>
                <td>
                    <a href="<?= \App\Core\Cache\ConfigHandler::get("router")->getPath("admin_lesson_edit", $lesson->getId()); ?>" class="btn-success">Modifier</a>
                    <form method="post" action="/admin/lesson/delete/<?= $lesson->getId() ?>">
                        <button id="delete-lesson" class="btn btn-danger">Delete</button>
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