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
        <?php foreach ($evaluations["data"] as $evaluation): ?>
            <tr>
                <td><?= $evaluation->getId() ?></td>
                <td><?= $evaluation->getName() ?></td>
                <td>
                    <a href="@path(admin_evaluation_edit, <?= $evaluation->getId() ?>)">Edit</a>
                    <a href="@path(admin_notation_index, <?= $evaluation->getId() ?>)">Notations</a>
                    <a href="@path(admin_evaluation_delete, <?= $evaluation->getId() ?>)">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

@endsection