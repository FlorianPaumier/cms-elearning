@extend(lessons/template)

@section(content)

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
@endsection

