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
</section>

@endsection