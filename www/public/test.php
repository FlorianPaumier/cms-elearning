<!DOCTYPE html>
<html lang="en">

<head>

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
    
<<<<<<< HEAD
<link rel="stylesheet" href="assets/styles/admin/login.css">

=======
>>>>>>> c2c8168034ad98f6dfb83177a77dd9b994b5556c
</head>

<body id="page-top">

<<<<<<< HEAD
<section class="header">
    <div class="col-sm-10">
        <a href="/">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/WordPress_blue_logo.svg/1200px-WordPress_blue_logo.svg.png" alt="logo">
        </a>
    </div>
    <nav class="nav-header">
        <ul>
            <li><a class="nav-link col-md-3" href="#">Cours</a></li>
            <li><a class="nav-link col-md-3" href="#">Articles</a></li>
            <li><a class="nav-link col-md-3" href="#">Évenements</a></li>
            <li class="separator"><span></span></li>
            <li>
                <form action="/search" method="get">
                    <input type="text" class="input-search" placeholder="Search">
                    <button class="btn btn-append c-blue"><i class="fas fa-search"></i></button>
                </form>

            </li>
            <li>
                <a class="btn btn-login" href="/signin">S'inscrire</a>
            </li>
            <li>
                <a class="btn btn-login" href="/login">Se connecter</a>
            </li>
        </ul>
    </nav>
    <div class="hamburger" id="hamburger-10">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
    </div>
</section>
<section class="header-mobile">
    <nav class="nav-header-mobile">
        <ul>
            <li class="search-form">
                <form action="/search" method="get">
                    <input type="text" class="input-search" placeholder="Search">
                    <button class="btn btn-append c-blue"><i class="fas fa-search"></i></button>
                </form>
            </li>
            <li class="nav-link"><a href="#">Cours</a></li>
            <li class="nav-link"><a class="nav-link" href="#">Articles</a></li>
            <li class="nav-link"><a class="nav-link" href="#">Évenements</a></li>
            <ul class="footer-header">
                <li>
                    <a class="btn btn-login" href="/signin">S'inscrire</a>
                </li>
                <li>
                    <a class="btn btn-login" href="/login">Se connecter</a>
                </li>
            </ul>
        </ul>
    </nav>
</section>


=======
<section id="header">
    <section id="search">
        <div>
            <img src="https://i1.wp.com/s1.wp.com/wp-content/themes/h4/landing/marketing/pages/_common/components/vip-pitch/media/vip-logo.png?ssl=1" alt="">
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
                <li class="link"><a href="#">Cours</a></li>
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

>>>>>>> c2c8168034ad98f6dfb83177a77dd9b994b5556c
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
    
<<<<<<< HEAD
<section class="wrapper">
    <div class="login">
        <p class="title">Log in</p>
        <form class="form-container" action="/login-check" method="POST">
    
<div class="form-group">
    <label for="app_form_username">Username</label>
    <input type="text"
           id="app_form_username"
           class="form-control form-control-user " placeholder="Username"
           name="app_form_username" value="" >
</div>

<div class="form-group">
    <label for="app_form_password">Password</label>
    <input type="password"
           id="app_form_password"
           class="form-control form-control-user " placeholder="Password"
           name="app_form_password" value="" >
</div>

<div class="form-group">
    <ul class="tg-list">
        <li class="tg-list-item row">
            <span>Ce souvenir de moi</span>
            <input class="col-1 tgl tgl-skewed"
                   type="checkbox"
                   id="app_form_remember_me"placeholder="Ce souvenir de moi"
                   name="app_form_remember_me" value="" >
            <label class="tgl-btn pl-5 " data-tg-off="OFF" data-tg-on="ON" for="app_form_remember_me"></label>
        </li>
    </ul>
</div>

    <button id="app_form_submit" name="app_form_submit" type="submit" class="btn btn-primary">Se connecter</button>

</form>
=======
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
    <section id="flux-rss" class="col-md-6 col-sm-12 col-lg-6">
        <h2>Dernières actualités</h2>
        <?php for ($y = 0; $y < 3; $y++): ?>
            <article class="news col-md-6 col-sm-12 col-lg-6 <?php if ($y == 1) echo 'active' ?>">
                <span class="date">10/02/2020</span>
                <h1>Salut</h1>
                <p>Sed ut perspiciatis unde omnis iste natus error sit
                    voluptatem accusantium. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium ....
                </p>
                <a href="#" class="know-more">Voir la suite</a>
            </article>
        <?php endfor; ?>
    </section>
</section>

<section id="newsletter">
    <h2>Newsletter</h2>
    <div>
        <input type="email" placeholder="Votre Email..." name="newsletter-email">
        <button class="btn">M'inscrire</button>
>>>>>>> c2c8168034ad98f6dfb83177a77dd9b994b5556c
    </div>
</section>

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

<<<<<<< HEAD
=======
<script src="/assets/scripts/carrousel.js"></script>

>>>>>>> c2c8168034ad98f6dfb83177a77dd9b994b5556c
</body>
</html>

