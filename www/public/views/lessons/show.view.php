@extend(templates/front)


@section(body)
<section class="col-md-2">
    <ul>
        <?php foreach ($chapters as $chapterList): ?>
            <li>
                <a href="@path(app_catalogue_show, <?= $lesson->getId() ?>)?chapter=<?= $chapterList->getPosition(); ?>"><?= $chapterList->getTitle(); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="col-md-8">
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

    <?php if (!$chapter): ?>
        <a href="@path(app_catalogue_show, <?= $lesson->getId() ?>)?chapter=1">Commencer</a>
    <?php elseif($chapter + 1 < $end): ?>
        <a href="@path(app_catalogue_show, <?= $lesson->getId() ?>)?chapter=<?= $chapter + 1 ?>">Suivant</a>
    <?php else: ?>
        <a href="@path(app_catalogue_notate, <?= $lesson->getId() ?>)">Over</a>
    <?php endif; ?>
</section>
@endsection