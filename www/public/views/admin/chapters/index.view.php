@extend(templates/back)


@section(body)
<section>
    <a href="@path(admin_lesson_chapter_new)" id="add-lesson" class="btn c-blue">Ajout</a>
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
        foreach( $chapters as $chapter):
            ?>
            <tr>
                <td><?= $chapter->getId(); ?></td>
                <td><?= $chapter->getTitle(); ?></td>
                <td>
                    <a href="@path(admin_lesson_chapter_edit, <?= $chapter->getId() ?>)">
                        <button class="btn btn-succes">Modifier</button>
                    </a>
                    <form action="@path(admin_lesson_chapter_delete, <?= $chapter->getId() ?>)">
                        <button id="delete-lesson" class="btn btn-danger">Delete</button>
                    </form></td>
            </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>
</section>
@endsection