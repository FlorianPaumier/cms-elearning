@extend(templates/front)


@section(body)
<section>
    <ul>
        <?php foreach ($chapters as $chapter): ?>
        <li>
            <?= $chapter->getTitle(); ?>
        </li>
        <?php endforeach; ?>
    </ul>
</section>
<section>
    <?= $lesson->getDescription(); ?>
</section>
@endsection