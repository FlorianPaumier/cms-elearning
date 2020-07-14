@extend(templates/back)

@section(body)
    <table>
        <thead>
        <tr>
            <th>id</th>
            <th>Evaluation</th>
            <th>User</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($evaluations["data"] as $evaluation): ?>
        <tr>
            <td><?= $evaluation->getId();?></td>
            <td><?= $evaluation->getEvaluation()->getName(); ?></td>
            <td><?= $evaluation->getUser() ?  $evaluation->getUser()->getEmail() : ""; ?></td>
            <td>
                <a href="@path(admin_notation_edit,[<?= $evaluation->getEvaluation()->getId(); ?>, <?= $evaluation->getId(); ?>])">Edit</a>
                <a href="@path(admin_notation_show,[<?= $evaluation->getEvaluation()->getId(); ?>, <?= $evaluation->getId(); ?>])">Show</a>
                <a href="@path(admin_notation_delete,<?= $evaluation->getId(); ?>)">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?= $evaluations["links"] ?>
@endsection