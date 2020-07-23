<section id="header">
    <section id="search">
        <div>
            <a href="@path(app_home)">
                <img src="/assets/images/logo.png" alt="Logo Entreprise">
            </a>
        </div>
        <form action="" method="post" class="input-group search">
            <input type="text" placeholder="Chercher dans le site" class="input-search">
            <button class="btn-search">
                <i class="fa fa-search"></i>
            </button>
        </form>

        <div class="hamburger" id="hamburger-10" data-target="#nav-header">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </section>
    <section id="nav-header">
        <nav>
            <ul>
                <li class="search-mobile">
                    <form action="" method="post" class="input-group search">
                        <input type="text" placeholder="Chercher dans le site" class="input-search">
                        <button class="btn-search">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </li>
                <li class="link"><a href="@path(app_catalogue)">Cours</a></li>
                <li class="link"><a href="@path(article_list)">Article</a></li>
                <li class="link"><a href="@path(frontend_event_calendar)">Evenements</a></li>
                <li class="link"><a href="@path(frontend_form_contact)">Contact</a></li>
                <li class="link"><a href="#">Recherche</a></li>
                <li class="link"><a href="@path(frontend_sondage_list)">Sondages</a></li>
                <li class="link"><a href="@path(frontend_faq_list)">FAQ</a></li>
                <li class="profile user-menu acilir">
                    <span class="icon"><i class="fa fa-user"></i></span>
                    <div class="login-menu">
                        <?php
                        if (!is_null($session["app.user"])):
                            ?>
                            <a href="@path(app_user_logout)">Déconnexion</a>
                        <?php
                        if (in_array("ROLE_ADMIN", $session["app.user"]["roles"])):
                            ?>
                            <a href="@path(admin_home)">Dashboard</a>
                        <?php endif; ?>
                        <?php
                        else:
                            ?>
                            <a href="@path(app_user_login)">Se connecter</a>
                            <a href="@path(app_user_register)">S'inscrire</a>
                        <?php
                        endif;
                        ?>
                    </div>
                </li>
                <li class="profile-mobile">
                    <a href="@path(app_user_login)">
                        <button class="btn btn-primary btn-ghost btn-slide">Se connecter</button>
                    </a>
                    <a href="@path(app_user_register)">
                        <button class="btn btn-primary btn-ghost btn-slide">S'inscrire</button>
                    </a>
                    <a href="@path(app_user_logout))">
                        <button class="btn btn-primary btn-ghost btn-slide">Déconnexion</button>
                    </a>
                </li>
            </ul>
        </nav>
    </section>

</section>


<?php

if (!is_null($errors)) {
    foreach ($errors as $error) {
        echo $error;
    }
}

if (isset($session) && !is_null($session)) {
    if (isset($session["app.flash"]["success"]) && !is_null($session["app.flash"]["success"])) {
        foreach ($session["app.flash"]["success"] as $key => $message) {
            echo "<div class='alert alert-sucess'>$message</div>";
        }
    }
    if (isset($session["app.flash"]["error"]) && !is_null($session["app.flash"]["error"])) {
        foreach ($session["app.flash"]["error"] as $key => $message) {
            echo "<div class='alert alert-error'>$message</div>";
        }
    }
}

?>