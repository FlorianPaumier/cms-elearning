@extend(user/user)

@section(content)

<section class="container">
        <table class="table">
            <thead>
            <tr>
                <th>Lesson</th>
                <th>Dernier Chapitre</th>
                <th>Terminé</th>
                <th>Début</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($lessons as $lesson): ?>
                <tr>
                    <td>
                        <?= $lesson["title"]?>
                    </td>
                    <td><?= $lesson["chapter"] ?></td>
                    <td><?= $lesson["over"] ?></td>
                    <td><?= $lesson["start"] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
</section>
<section class="container">
    <table class="table">
        <thead>
        <tr>
            <th>Lesson</th>
            <th>Evaluation</th>
            <th>Note</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($evaluations as $evaluation): ?>
            <tr>
                <td>
                    <?= $evaluation->getEvaluation()->getLesson()->getTitle()?>
                </td>
                <td><?= $evaluation->getName() ?></td>
                <td><?= $evaluation->getRating() ?></td>
                <td><?= $evaluation->getCreatedAt() ? $evaluation->getCreatedAt()->format("d-m-Y") : "" ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
@endsection