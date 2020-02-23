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


<?php

if (isset($session)) {
    if (isset($flash)) {
        if (isset($flash["success"])) {
            foreach ($flash["success"] as $key => $message) {
                echo "<div class='alert alert-sucess'>$message</div>";
            }
        }
        if (isset($flash["error"])) {
            foreach ($flash["error"] as $key => $message) {
                echo "<div class='alert alert-error'>$message</div>";
            }
        }
    }
}

?>


