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
            <ul>
                <?php foreach ($evaluations as $evaluation): ?>
                    <li>
                        <a href="@path(evaluation_index, <?= $evaluation->getId() ?>)"><?= $evaluation->getName(); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </section>
    </section>
</section>
@endsection

@section(javascript)
<script src="/assets/scripts/nav-lessons.js"></script>
@endsection