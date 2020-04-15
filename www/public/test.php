{{ @View/templates/back|extend }}


<<<<<<< HEAD
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
=======
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        <?php
        if(isset($title)){
            echo $title;
        }else{
            echo "Accueil";
        }
        ?></title>

    <meta lang="fr">


    <?php
    if(isset($styles)){
        foreach ($styles as $style) {
            echo "<link rel='stylesheet' href='$style'/>";
        }
    }

    ?>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/styles/frontend/main.css" rel="stylesheet">
    
</head>

<body id="page-top">

<section id="header">
    <section id="search">
        <div>
            <a href="/">
                <img src="https://i1.wp.com/s1.wp.com/wp-content/themes/h4/landing/marketing/pages/_common/components/vip-pitch/media/vip-logo.png?ssl=1" alt="">
            </a>
        </div>
        <form action="" method="post" class="input-group search">
            <input type="text" placeholder="Chercher dans le site" class="input-search">
            <button class="btn-search">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </section>
    <section id="menu">
        <nav>
            <ul>
                <li class="link"><a href="/cours">Cours</a></li>
                <li class="link"><a href="#">Article</a></li>
                <li class="link"><a href="#">Evenements</a></li>
                <li class="link"><a href="#">Contact</a></li>
                <li class="link"><a href="#">Recherche</a></li>
                <li class="profile user-menu acilir">
                    <span class="icon"><i class="fa fa-user"></i></span>
                    <div class="login-menu">
                        <a href="">Login</a>
                        <a href="">Sign Up</a>
                    </div>
                </li>
            </ul>
        </nav>
    </section>
</section>

<?php

if(isset($session))

if(isset($flash)){
    if(isset($flash["success"])){
        foreach ($flash["success"] as $key => $message){
            echo "<div class='alert alert-sucess'>$message</div>";
        }
    }
    if(isset($flash["error"])){
        foreach ($flash["error"] as $key => $message){
            echo "<div class='alert alert-error'>$message</div>";
        }
    }
}

?>

<main>
    
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
                <article class="">
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
>>>>>>> e0047328f28008121ef71c7a572012e258ce7211

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

<<<<<<< HEAD
@section(javascript)
<script src="/assets/scripts/carrousel.js"></script>
@endsection
=======
</main>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Scroll to Top Button-->
<button class="scroll-to-top btn-jelly" data-target="#page-top">
    <i class="fa fa-angle-up"></i>
</button>

<footer>
    <ul class="footer-list">
        <li>
            <ul>
                <li class="footer-title is-active">L'entreprise <i class="fa fa-chevron-down"></i></li>
                <li class="footer--item">Lorem Ipsum</li>
                <li class="footer--item">Lorem Ipsum</li>
                <li class="footer--item">Lorem Ipsum</li>
            </ul>
        </li>
        <li>
            <ul>
                <li class="footer-title">L'entreprise <i class="fa fa-chevron-down"></i></li>
                <li class="footer--item">Lorem Ipsum</li>
                <li class="footer--item">Lorem Ipsum</li>
                <li class="footer--item">Lorem Ipsum</li>
            </ul>
        </li>
        <li>
            <ul class="network-links">
                <li class="footer-title">Réseaux Sociaux</li>
                <li>
                    <ul class="row">
                        <li class="col-3"><a href="#"><i class="fab fa-twitter-square"></i></a></li>
                        <li class="col-3"><a href="#"><i class="fab fa-facebook-square"></i></a></li>
                        <li class="col-3"><a href="#"><i class="fab fa-youtube-square"></i></a></li>
                        <li class="col-3"><a href="#"><i class="fab fa-instagram-square"></i></a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</footer>

<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>

<script src="assets/scripts/global.js"></script>
<script src="assets/dist/fontawesome/js/all.min.js"></script>


<script src="/assets/scripts/header.js"></script>



</body>
</html>

>>>>>>> e0047328f28008121ef71c7a572012e258ce7211
