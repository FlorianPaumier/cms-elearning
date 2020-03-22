{{ @View/templates/back|extend }}


@section(body)
<section class="container-accueil">
    <h1 class="c-white">Votre apprentissage commence ici !</h1>
    <a href="#" class="btn btn-more c-blue">En savoir plus</a>
</section>
<section class="container">
    <section class="description jumbutron col-md-12 row">
        <img class="col-md-2" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/WordPress_blue_logo.svg/1200px-WordPress_blue_logo.svg.png" alt="logo">
        <p class="col-8">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore
            veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut </p>
    </section>
    <div class="row">
        <div class="col-md-6 col-sm-12">

        <section class="testimonies">
            <h2>Témoignage</h2>
            <div class="testimonies-carousel row col-md-5">
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <article class="jumbutron <?php if ($i == 0): ?> active <?php endif;?>">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/WordPress_blue_logo.svg/1200px-WordPress_blue_logo.svg.png" alt="logo">
                        <p> <?=$i * 70?>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                            inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut </p>
                    </article>
                <?php endfor;?>
            </div>
        </section>
        <section class="home-contact jumbutron">
            <p>Vous avez besoin d’aide ? Nous sommes la pour vous...</p>
            <a href="#" class="btn btn-contact">Nous contacter</a>
        </section>
        </div>
    <section class="home-news col-md-6 jumbutron">
        <h2>Nos news</h2>
        <div id="flux-rss" class="jumbutron">
            <?php for ($y = 0; $y < 3; $y++): ?>
            <article class="news">
                <h1>Salut</h1>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem</p>
                <span class="row">
                    <a href="#" class="know-more">Voir la suite</a>
                    <span class="date">10/02/2020</span>
                </span>
            </article>
            <?php endfor;?>
        </div>
    </section>
    </div>
</section>
@endsection

@section(javascript)
<script src="/assets/scripts/carrousel.js"></script>
@endsection