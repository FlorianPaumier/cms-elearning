@extend(templates/back)

@section(styles)
<link rel="stylesheet" href="/assets/styles/admin/form.css">
@endsection

@section(body)
<section>
    <a href="@path(admin_user_new)" id="add-user" class="btn c-blue">Ajout</a>
</section>
<section>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach( $users["data"] as $user):

            ?>
            <tr>
                <td><?= $user->getId(); ?></td>
                <td><?= $user->getUsername(); ?></td>
                <td class="row position-btn">
                    <a href="@path(admin_user_edit, <?= $user->getId(); ?>)">
                        <button class="btn btn-succes">Modifier</button>
                    </a>
                    <form action="@path(admin_user_delete, <?= $user->getId() ?>)">
                        <button id="delete-user" class="btn btn-danger">Delete</button>
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