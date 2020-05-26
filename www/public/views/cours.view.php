@extend(templates/front)


@section(body)
<section id="catalogue-search">
    <form action="" method="get">
        <select name="category" id="search_categories">
            <option value="">Catégories</option>
        </select>
        <select name="themes" id="search_themes">
            <option value="">Thèmes</option>
        </select>
        <select name="language" id="search_language">
            <option value="">Langue</option>
        </select>
        <input type="text" class="input-search" placeholder="Nom du cours">
        <button class="btn">Rechercher</button>
    </form>
</section>
<section id="section-lessons" class="container">
    <ul class="cards">
        <?php for ($i = 0; $i < 10; $i++): ?>
            <li class="lesson">
                <article class="" data-path="@path(app_catalogue_show, <?= $i ?>)">
                    <img src="https://unsplash.it/800/600?image=82" alt="lessons logo">
                    <section class="content">
                        <span>Type</span>
                        <h1>Titre</h1>
                        <span class="informations">
                            <div class="times"><i class="far fa-hourglass"></i> 15 Heures</div>
                            <div class="difficulty">
                                <div class="mesure">
                                    <img src="assets/images/levels.svg" alt="level">
                                </div>
                                <span>Facile</span>
                            </div>
                        </span>
                        <p class="">This is the shorthand for flex-grow, flex-shrink and flex-basis combined. The second and third parameters (flex-shrink and flex-basis) are
                            optional.
                            Default is 0 1 auto. </p>
                    </section>
                </article>
            </li>
        <?php endfor; ?>
    </ul>

    <section class="pagination">
        <ul>
            <li><a class="pagination-prev" href="#">Précedent</a></li>
            <?php for ($i = 1; $i < 4; $i++): ?>
                <li><a href="?page=<?= $i ?>" class="<?php if ($_GET["page"] == $i) {
                        echo 'is-active';
                    } ?>"><?= $i ?></a></li>
            <? endfor; ?>
            <li><a class="pagination-next" href="#">Suivant</a></li>
        </ul>
    </section>
</section>
@endsection

@section(javascript)

@endsection