@extend(templates/front)


@section(body)
<section id="catalogue-search">
    <form action="" method="get">
        <section class="select-form">
            <select name="category" id="search_categories">
                <option value="">Catégories</option>
            </select>
            <select name="themes" id="search_themes">
                <option value="">Thèmes</option>
            </select>
            <select name="language" id="search_language">
                <option value="">Langue</option>
            </select>
        </section>
        <input type="text" class="input-search" placeholder="Nom du cours">
        <button class="btn">Rechercher</button>
    </form>
</section>
<section id="section-lessons" class="container">
    <ul class="cards">
        <?php foreach($lessons["data"] as $lesson): ?>
            <li class="lesson cards__item">
                <article data-path="@path(app_catalogue_show, <?= $lesson->getId() ?>)">
                    <section class="content card__content">
                        <section class="img">
                            <img class="card__image" src="<?= $lesson->getThumbnail() ?? 'https://unsplash.it/800/600?image=82'?>" alt="lessons logo">
                        </section>
                        <section class="right">
                            <section class="top">
                                <h1 class="text-center card__title"><?= $lesson->getTitle() ?></h1>
                                <span>Type</span>
                                <span class="informations">
                            <div class="times"><i class="far fa-hourglass"></i> 15 Heures</div>
                            <div class="difficulty">
                                <div class="mesure">
                                    <img src="assets/images/levels.svg" alt="level">
                                </div>
                                <span>Facile</span>
                            </div>
                        </span>
                            </section>
                            <section class="bottom">
                                <p class="card__text"><?= $lesson->getDescription() ?></p>
                            </section>
                        </section>
                    </section>
                </article>
            </li>
        <?php endforeach; ?>
    </ul>

    <section class="pagination">

        <?php $lessons["links"] ?>
    </section>
</section>
@endsection

@section(javascript)
<script>
    $(document).ready(function(){
        $("article").each(function(key, article){
            $(article).click(function () {
                window.location = $(this).data("path");
            })
        })
    })
</script>
@endsection