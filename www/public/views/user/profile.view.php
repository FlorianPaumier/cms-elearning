@extend(user/user)

@section(content)

<section class="container body">
    <section class="description">
        <?= $user->getDescription() ?>
    </section>
    <section class="informations">
        <ul class="list-unstyle">
            <li>Email : <?= $user->getEmail() ?></li>
            <li>Username : <?= $user->getUsername() ?></li>
            <li>Prénom : <?= $user->getFirstname() ?></li>
            <li>Nom : <?= $user->getLastname() ?></li>
            <li>Age : <?= $user->getAge() ? $user->getAge()->format("d-m-Y") : "" ?></li>
        </ul>
    </section>
    <section class="events">
        <h2>Evenement au quel vous êtes inscrit</h2>
        <ul>
        <?php foreach ($events as $event): ?>
            <li>
                <a href="@path(app_event_stream, <?= $event->getStream()->getId()?>)"><?= $event->getStream()->getEvent()->getTitle();?></a>
                le <?= $event->getStream()->getStartAt()->format("d-m-Y");?> à <?= $event->getStream()->getStartAt()->format(" H:i");?>
            </li>
        <?php endforeach; ?>
        </ul>
    </section>
</section>

@endsection