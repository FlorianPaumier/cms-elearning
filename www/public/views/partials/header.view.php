<section id="header">
    <section id="search">
        <div>
            <a href="@path(app_home)">
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
                <li class="link"><a href="@path(app_catalogue)">Cours</a></li>
                <li class="link"><a href="#">Article</a></li>
                <li class="link"><a href="#">Evenements</a></li>
                <li class="link"><a href="#">Contact</a></li>
                <li class="link"><a href="#">Recherche</a></li>
                <li class="profile user-menu acilir">
                    <span class="icon"><i class="fa fa-user"></i></span>
                    <div class="login-menu">
                        <a href="@path(app_user_login)">Login</a>
                        <a href="@path(app_user_register)">Sign Up</a>
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