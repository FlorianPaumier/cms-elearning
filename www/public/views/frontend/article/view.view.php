@extend(templates/front)

@section(styles)
<link rel="stylesheet" href="../../../assets/styles/frontend/article.css">
<link rel="stylesheet" href="../../../assets/styles/frontend/commentary.css">
@endsection

@section(body)

<section class="container">
    <img class="article-view-image" src="<?= $article->getImage()?>">
    <h1 class="article-view-title" >
        <?= $article->getTitle() ?>
    </h1>
    <p class="article-view-content" >
        <?= $article->getContent() ?>
    </p>
    <p class="article-view-date" >
        <?= $article->getCreatedAt()->format("d-m-Y"); ?>
    </p>
    <div class="block-commentary">
        <span>Commentaire</span>
        <?php if(is_array($comments)): ?>
            <div class="commentary">
                <ul>
                    <li>
                        <?php foreach ($comments as $comment): ?>
                            <?= $comment->getUser()->getUsername();?>
                            <?= $comment->getCommentary();?>
                            <?= $comment->getCreatedAt()->format("d-m-Y");?>
                        <?php endforeach ?>
                    </li>
                </ul>
            </div>
        <?php elseif(!is_null($comments)): ?>
            <div class="commentary">
                <ul>
                    <li>
                        <?= $comments->getUser()->getUsername();?>
                        <?= $comments->getCommentary();?>
                        <?= $comments->getCreatedAt()->format("d-m-Y");?>
                    </li>
                </ul>
                <?= $comments->getUser()->getUsername();?>
                <?= $comments->getCommentary();?>
            </div>

        <?php endif ?>
    </div>

    <div>
        {{ commentaryForm }}
    </div>

</section>
@endsection
