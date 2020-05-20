@extend(templates/back)

@section(body)

<a href="@path(admin_events_new)" type="button">Ajout</a>

<table>
    <thead></thead>
    <tbody>
    <?php if($list): ?>
    <?php foreach ($list as $event): ?>
        <tr>
            <td><?= $event->getTitle() ?></td>
            <td><?= $event->getCreatedAt()->format("d-m-Y") ?></td>
            <td><?= $event->getPublishAt()->format("d-m-Y") ?></td>
            <td><?= $event->getHappenAt()->format("d-m-Y") ?></td>
        </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
@endsection