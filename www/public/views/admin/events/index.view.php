@extend(templates/back)

@section(body)

<a href="@path(admin_events_new)" type="button">Ajout</a>

<table>
    <thead>
    <tr>
        <th>Titre</th>
        <th>Créer le</th>
        <th>Publier le</th>
        <th>Ce passe le</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($list["data"] as $event): ?>
        <tr>
            <td><?= $event->getTitle() ?></td>
            <td><?= $event->getCreatedAt()->format("d-m-Y") ?></td>
            <td><?= $event->getPublishAt()->format("d-m-Y") ?></td>
            <td><?= $event->getHappenAt()->format("d-m-Y") ?></td>
            <td>
                <a href="@path(admin_events_edit, <?= $event->getId() ?>)">Edit</a>
                <a href="@path(admin_events_stream, <?= $event->getId() ?>)">Ajout d'un stream</a>
                <a href="@path(admin_events_delete, <?= $event->getId() ?>)">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $list["link"] ?>
@endsection