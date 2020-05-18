@extend(templates/front)

@section(body)
<section>
    <article>
        <h1><?=$question->getQuestion();?></h1>
        <aside>
            <?=$question->getReponse();?>
        </aside>
    </article>
</section>
@endsection