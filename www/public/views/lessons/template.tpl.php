@extend(templates/front)

@section(body)
<section id="show-lesson">

    <section class="col-md-2 nav">
        <div class="hamburger" id="hamburger-11" data-target="#nav-chapter">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
        <ul id="nav-chapter" class="list-unstyle">
            <li>
                <a href="@path(app_catalogue_show, <?= $lesson->getId() ?>)"><?= $lesson->getTitle(); ?></a>
            </li>
            <?php foreach ($nav as $chapterList): ?>
                <li>
                    <a
                        href="@path(app_catalogue_show, <?= $lesson->getId() ?>)?chapter=<?= $chapterList["chapter"]->getPosition(); ?>"
                        class="<?php if ($chapterList["active"]): ?> active <?php endif; ?>">
                        <?= $chapterList["chapter"]->getTitle(); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    @yield(content)
</section>
@endsection

@section(javascript)
<script src="/assets/scripts/nav-lessons.js"></script>
@endsection