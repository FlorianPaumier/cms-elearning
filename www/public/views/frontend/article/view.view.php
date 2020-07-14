@extend(templates/front)

@section(styles)
@endsection

@section(body)
<div>
    <h1>
        <?= $article->getTitle() ?>
    </h1>
    <p>
        <?= $article->getContent() ?>
    </p>
    <div>
        {{ commentaryForm }}
    </div>

</div>
@endsection
