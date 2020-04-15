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

<<<<<<< HEAD
=======
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
>>>>>>> c2c8168034ad98f6dfb83177a77dd9b994b5556c
                </li>
            </ul>
        </nav>
    </section>
</section>

<<<<<<< HEAD

>>>>>>> e881ede0f36dd95b53201673b4a386a88f13c4c6
=======
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