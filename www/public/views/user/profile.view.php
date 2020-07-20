@extend(templates/front)

@section(body)

    <section class="container nav">
        <div class="avatar">
            <?php if($user->getAvatar()): ?>
            <img src="" alt=""></div>
            <?php else: ?>
                <span><?= $user->getUsername()?></span>
            <?php endif; ?>
        <ul class="list-unstyle">
            <li>Profil</li>
            <li>Paramètres</li>
            <li>Cours</li>
        </ul>
    </section>

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
                <li><a href="@path(app_user_update)" class="btn btn-primary">Modifier</a></li>
            </ul>
        </section>
    </section>

@endsection