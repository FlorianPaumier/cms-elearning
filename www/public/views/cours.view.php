{{ @View/templates/front|extend }}


@section(body)
<section class="container">
    <form action="/search" method="get">
        <input type="text" class="input-search" placeholder="Search">
        <button class="btn btn-append c-blue"><i class="fas fa-search"></i></button>
    </form>
</section>
<section class="container">
    <ul class="cards jumbutron">
    <?php for($i=0;$i<10;$i++): ?>
        <li class="cards__item">
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
</section>
@endsection

@section(javascript)
@endsection