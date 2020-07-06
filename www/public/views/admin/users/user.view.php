@extend(templates/back)

@section(styles)
<link rel="stylesheet" href="/assets/styles/admin/form.css">
@endsection

@section(body)
<section>
    <a href="@path(admin_user_new)" id="add-lesson" class="btn c-blue">Ajout</a>
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
        foreach( $users as $user):
            ?>
            <tr>
                <td><?= $user->getId(); ?></td>
                <td><?= $user->getUsername(); ?></td>
                <td>
                    <a href="@path(admin_user_edit, <?= $user->getId(); ?>)">
                        <button class="btn btn-succes">Modifier</button>
                    </a>
                    <form action="/admin/user/delete<?= $user->getId() ?>">
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