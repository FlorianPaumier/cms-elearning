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
        <?= $article->getCreatedAt()->format("d-m-Y"); ?>
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
