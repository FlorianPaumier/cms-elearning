@extend(templates/front)

@section(style)
<link rel="stylesheet" href="../../../assets/styles/frontend/article.css">
@endsection

@section(body)

<section class="container">
    <h1>{{title}}</h1>
    <div class="article">
        <ul class="article-list">
            <?php foreach($articles['data'] as $article): ?>
            <li class="article-row row">
                <div class="article-row-image col-2">
                    <img src='<?= $article->getImage() ?>'>
                </div >
                <div class="article-row-content col-10">
                    <a class="article-row-title" href="/article/<?= $article->getId() ?>"><?= $article->getTitle()?></a>
                    <p class="article-row-description"><?= mb_strimwidth($article->getContent(), 0, 200, "..."); ?></p>
                    <a class="article-row-watch" href="/article/<?= $article->getId() ?>">Lire la suite</a>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
        <?= $articles["links"] ?>
    </div>
</section>

@endsection

