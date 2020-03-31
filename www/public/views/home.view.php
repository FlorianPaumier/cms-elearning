{{ @View/templates/front|extend }}


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
            <?php endfor; ?>
        </div>
    </section>
@endsection

@section(javascript)
<script src="/assets/scripts/carrousel.js"></script>
@endsection