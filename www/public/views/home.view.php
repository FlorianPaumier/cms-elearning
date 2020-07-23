@extend(templates/front)


@section(body)
<section id="main-section">
    <div class="background">
        <h1>Un site pour apprendre</h1>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis
            et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut </p>
    </div>
</section>
<section class="section-doc row">
    <?php for ($y = 0; $y < 3; $y++): ?>
        <article class="col-md-4 col-sm-10">
            <i class="fa fa-cogs icon"></i>
            <h1>Une nouvelle approche</h1>
            <p>
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa
            </p>
        </article>
    <?php endfor; ?>
</section>
<section id="section-lesson">
    <h2 class="text-center">les cours populaires</h2>
    <div id="lessons">
        <button><i class="fa fa-arrow-left"></i></button>

        <ul class="cards">
            <?php for ($y = 0; $y < 3; $y++): ?>
                <li class="cards__item">
                    <article class="lesson card <?php if ($y === 0) echo 'active' ?>">
                        <div>
                            <img src="https://unsplash.it/800/600?image=59" alt="lesson" class="card__image">
                        </div>
                        <section class="content">
                            <h2 class="card__title">Salut</h2>
                            <p class="card__text">
                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium. Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                                accusantium
                                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium. Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                                accusantium ....
                            </p>
                        </section>
                            <a href="#"  class="btn btn--block card__btn">
                                Commencer
                            </a>
                    </article>
                </li>
            <?php endfor; ?>
        </ul>
        <button><i class="fa fa-arrow-right"></i></button>
    </div>
</section>
<section id="home-news">
    <section id="testimonies" class="col-md-6">
        <h2>Témoignages</h2>
        <ul class="cards">
            <?php for ($y = 0; $y < 3; $y++): ?>
                <li class="cards_item">
                    <article class="testimony card <?php if ($y == 1) echo 'active' ?>">
                        <section class="card__title card__header">
                            <h1>Salut</h1>
                        </section>

                        <section class="card__content card__text">
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem</p>
                        </section>

                        <section class="card__footer">
                            <span class="date">10/02/2020</span>
                        </section>
                    </article>
                </li>
            <?php endfor; ?>
        </ul>
    </section>
    <section id="flux-rss" class="col-md-6 col-sm-10 col-lg-6">
        <h2>Dernières actualités</h2>
        <ul class="cards">
            <?php for ($y = 0; $y < 3; $y++): ?>
                <li class="cards_item">
                    <article class="card col-md-6 col-sm-12 col-lg-6 <?php if ($y === 0) echo 'active' ?>">
                        <section class="card__title card__header">
                            <h1>Salut</h1>
                        </section>
                        <section class="card__content card__text">
                            <p>Sed ut perspiciatis unde omnis iste natus error sit
                                voluptatem accusantium. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium ....
                            </p>
                        </section>
                        <section class="card__footer">
                            <span class="date">10/02/2020</span>
                            <a href="@path(app_home)" class="know-more">Voir la suite</a>
                        </section>
                    </article>
                </li>
            <?php endfor; ?>
        </ul>
    </section>
</section>

<section id="newsletter">
    <h2 class="text-center">Newsletter</h2>
    <div>
        {{ form }}
    </div>
</section>
@endsection

@section(javascript)
<script src="/assets/scripts/carrousel.js"></script>
@endsection