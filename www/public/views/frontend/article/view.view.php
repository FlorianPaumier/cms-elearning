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
    <div>
        {{ commentaryForm }}
    </div>

</section>
@endsection
