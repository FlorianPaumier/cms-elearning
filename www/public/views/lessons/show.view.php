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
            <?php foreach ($chapters as $chapterList): ?>
                <li>
                    <a href="@path(app_catalogue_show, <?= $lesson->getId() ?>)?chapter=<?= $chapterList->getPosition(); ?>"><?= $chapterList->getTitle(); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section id="lesson">

        <section id="content" class="col-md-8">
            <h1><?= $lesson->getTitle(); ?></h1>
            <?php if (!$chapter): ?>
                <?= $lesson->getDescription(); ?>
            <?php else: ?>
                <?php foreach ($chapters as $chapterShow): ?>
                    <?php if ($chapterShow->getPosition() == $chapter): ?>
                        <h1><?= $chapterShow->getTitle(); ?></h1>
                        <section class="row col-md-12">
                            <?= $chapterShow->getContent(); ?>
                        </section>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

        </section>
        <section id="pagination">
            <?php if (!$chapter): ?>
                <a href="@path(app_catalogue_show, <?= $lesson->getId() ?>)?chapter=1" class="btn btn-pagination">Commencer</a>
            <?php elseif ($chapter + 1 < $end): ?>
                <a href="@path(app_catalogue_show, <?= $lesson->getId() ?>)?chapter=<?= $chapter + 1 ?>" class="btn btn-pagination">Suivant</a>
            <?php else: ?>
                <a href="@path(app_catalogue_notate, <?= $lesson->getId() ?>)" class="btn btn-pagination">Over</a>
            <?php endif; ?>
        </section>
    </section>
</section>
@endsection

@section(javascript)
<script src="/assets/scripts/nav-lessons.js"></script>
@endsection