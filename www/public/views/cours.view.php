@extend(templates/front)


@section(body)
<section class="container col-sm-12 col-md-3 col-lg-3">
    <form action="/search" method="get">
        <input type="text" class="input-search" placeholder="Search">
        <button class="btn btn-append c-blue"><i class="fas fa-search"></i></button>
    </form>
</section>
<section class="container">
    <ul class="cards jumbutron">
    <?php for($i=0;$i<10;$i++): ?>
        <li class="cards__item col-lg-3 col-md-3 col-sm-6">
            <div class="card">
                <div class="card__image card__image--fence"></div>
                <div class="card__content">
                    <div class="card__title">Flex</div>
                    <p class="card__text">This is the shorthand for flex-grow, flex-shrink and flex-basis combined. The second and third parameters (flex-shrink and flex-basis) are optional. Default is 0 1 auto. </p>
                    <button class="btn c-blue card__btn">Button</button>
                </div>
            </div>
        </li>
    <?php endfor;?>
    </ul>

    <section class="pagination">
        <ul>
            <li><a class="pagination-prev" href="#">Précedent</a></li>
            <?php for($i=1; $i < 4; $i++): ?>
            <li><a href="?page=<?= $i ?>" class="<?php if($_GET["page"] == $i) { echo 'is-active'; } ?>"><?= $i ?></a></li>
            <? endfor; ?>
            <li><a class="pagination-next" href="#">Suivant</a></li>
        </ul>
    </section>
</section>
@endsection

@section(javascript)

@endsection