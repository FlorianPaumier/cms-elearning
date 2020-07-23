@extend(templates/front)

@section(styles)
<link rel="stylesheet" href="../../../assets/styles/frontend/commentary.css">
@endsection

@section(body)

<section class="container">
    <img src="<?= $article->getImage()?>">
    <h1>
        <?= $article->getTitle() ?>
    </h1>
    <p>
        <?= $article->getContent() ?>
    </p>
    <p>
        <?= $article->getCreatedAt() ?>
    </p>
    <?php if(is_array($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <?= $comment->getUser()->getUsername();?>
            <?= $comment->getCommentary();?>
            <?= $comment->getCreatedAt()->format("d-m-Y");?>
        <?php endforeach ?>
    <?php elseif(!is_null($comments)): ?>
        <?php dump($comments)?>
    <?php endif ?>
    <div>
        {{ commentaryForm }}
    </div>

</section>

<section class="container">
    <img src="<?= $article->getImage()?>">
    <h1>
        Titre
    </h1>
    <p>
        Article
    </p>
    <p>
        12-12-12
    </p>
    <div>
        <?php if(is_array($comments)): ?>
            <div>
                <?php foreach ($comments as $comment): ?>
                    <?= $comment->getUser()->getUsername();?>
                    <?= $comment->getCommentary();?>
                    <?= $comment->getCreatedAt()->format("d-m-Y");?>
                <?php endforeach ?>
            </div>
        <?php elseif(!is_null($comments)): ?>
            <div>
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
