@extend(templates/front)

@section(body)

<section class="container">
    <div>
        <ul>
            <?php foreach($articles['data'] as $article): ?>
            <li>
                <img src='<?= $article->getImage() ?>'>
                <a href="/article/<?= $article->getId() ?>"><?= $article->getTitle()?></a>
                <p><?= mb_strimwidth($article->getContent(), 0, 200, "..."); ?></p>
                <a href="/article/<?= $article->getId() ?>">Lire la suite</a>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="pagination-section">
            <?= $articles["links"] ?>

        </div>
    </div>
</section>

@endsection

