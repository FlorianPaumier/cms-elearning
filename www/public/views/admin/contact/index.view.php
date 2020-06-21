@extend(templates/back)

@section(body)

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
                    <a href="@path(admin_contact_edit, <?= $form->getId() ?>)">Edit</a><a href="@path(admin_contact_delete, <?= $form->getId() ?>)">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

@endsection