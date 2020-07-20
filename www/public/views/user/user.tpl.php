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
        <li><a href="@path(app_user_profile)">Profil</a></li>
        <li><a href="@path(app_user_parameters)">Paramètres</a></li>
        <li><a href="@path(app_user_lessons)">Cours</a></li>
    </ul>
</section>
    @yield(content)
@endsection
