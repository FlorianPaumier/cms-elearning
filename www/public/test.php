{{ @View/templates/back|extend }}


@section(body)
<section id="main-section">
    <div class="background">
        <h1>Un site pour apprendre</h1>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis
            et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut </p>
    </div>
</section>
<section class="section-doc">
    <article>
        <i class="fa fa-cogs icon"></i>
        <h1>Une nouvelle approche</h1>
        <p>
            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa
        </p>
    </article>
    <article>
        <i class="fa fa-cogs icon"></i>
        <h1>Une nouvelle approche</h1>
        <p>
            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa
        </p>
    </article>
    <article>
        <i class="fa fa-cogs icon"></i>
        <h1>Une nouvelle approche</h1>
        <p>
            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa
        </p>
    </article>
</section>
<section id="section-lesson">
    <h2 class="text-center">les cours populaires</h2>
    <div id="lessons">
        <button><i class="fa fa-arrow-left"></i></button>
        <?php for ($y = 0; $y < 3; $y++): ?>
            <article class="lesson <?php if ($y === 0) echo 'active' ?>">
                <section>
                    <img src="https://unsplash.it/800/600?image=59" alt="lesson">
                </section>
                <section class="content">
                    <h2>Salut</h2>
                    <p>
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium ....
                    </p>
                    <a href="#" class="btn">Commencer</a>
                </section>
            </article>
        <?php endfor; ?>
        <button><i class="fa fa-arrow-right"></i></button>
    </div>
</section>
<section id="home-news" class="row">
    <section id="testimonies" class="col-md-6">
        <?php for ($y = 0; $y < 3; $y++): ?>
            <article class="testimony <?php if ($y == 1) echo 'active' ?>">
                <h2 class="text-center">Salut</h2>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem</p>
                <span class="date">10/02/2020</span>
            </article>
        <?php endfor; ?>
    </section>
<<<<<<< HEAD
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
=======
    <section id="flux-rss" class="col-md-6 col-sm-12 col-lg-6">
        <h2>Dernières actualités</h2>
        <?php for ($y = 0; $y < 3; $y++): ?>
            <article class="news col-md-6 col-sm-12 col-lg-6 <?php if ($y == 1) echo 'active' ?>">
                <span class="date">10/02/2020</span>
>>>>>>> c2c8168034ad98f6dfb83177a77dd9b994b5556c
                <h1>Salut</h1>
                <p>Sed ut perspiciatis unde omnis iste natus error sit
                    voluptatem accusantium. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium ....
                </p>
                <a href="#" class="know-more">Voir la suite</a>
            </article>
<<<<<<< HEAD
            <?php endfor;?>
        </div>
=======
        <?php endfor; ?>
>>>>>>> c2c8168034ad98f6dfb83177a77dd9b994b5556c
    </section>
</section>

<section id="newsletter">
    <h2>Newsletter</h2>
    <div>
        <input type="email" placeholder="Votre Email..." name="newsletter-email">
        <button class="btn">M'inscrire</button>
    </div>
</section>
@endsection

@section(javascript)
<script src="/assets/scripts/carrousel.js"></script>
@endsection