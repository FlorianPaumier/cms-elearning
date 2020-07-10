@extend(templates/back)

@section(body)
<section>
    <a href="@path(admin_evaluation_new)" id="add-evaluation" class="btn c-blue">Ajout</a>
</section>
<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($forms as $form): ?>
            <tr>
                <td><?= $form->getId() ?></td>
                <td><?= $form->getName() ?></td>
                <td>
                    <a href="@path(admin_evaluation_edit, <?= $form->getId() ?>)">Edit</a><a href="@path(admin_evaluation_delete, <?= $form->getId() ?>)">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

@endsection