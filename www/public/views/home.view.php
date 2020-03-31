{{ @View/templates/front|extend }}


@section(body)

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