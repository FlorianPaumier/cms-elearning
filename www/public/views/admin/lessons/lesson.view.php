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
        </tr>
        </thead>
        <tbody>
        <?php
        foreach( $lessons as $lesson):
            ?>
            <tr>
                <td><?= $lesson->getId(); ?></td>
                <td><?= $lesson->geTitle(); ?></td>
                <td>
                    <form action="/admin/lesson/delete<?= $lesson->getId() ?>">
                        <button id="delete-lesson" class="btn btn-danger">Ajout</button>
                    </form></td>
            </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>
</section>
@endsection