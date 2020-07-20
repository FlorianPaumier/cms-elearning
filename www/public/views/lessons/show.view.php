@extend(lessons/template)

@section(content)

<section id="lesson" data-id="<?= $lesson->getId() ?>">

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
        <?php if (!$chapter && $lessonUser == 0) : ?>
            <a href="@path(app_catalogue_show, <?= $lesson->getId() ?>)?chapter=1" data-option="next" data-chapter="0" class="btn btn-pagination">Commencer</a>
        <?php elseif (!$chapter && $lessonUser > 0): ?>
            <a href="@path(app_catalogue_show, <?= $lesson->getId() ?>)?chapter=1" data-option="next" data-chapter="0"
               class="btn btn-pagination">Continuer</a>
        <?php elseif ($chapter + 1 <= $end): ?>
            <a href="@path(app_catalogue_show, <?= $lesson->getId() ?>)?chapter=<?= $chapter + 1 ?>" data-option="next" data-chapter="<?= $chapter ?>"
               class="btn btn-pagination">Suivant</a>
        <?php else: ?>
            <a href="@path(app_catalogue_notate, <?= $lesson->getId() ?>)" data-option="over" data-chapter="<?= $chapter ?>" class="btn btn-pagination">Over</a>
        <?php endif; ?>
    </section>
</section>
@endsection
