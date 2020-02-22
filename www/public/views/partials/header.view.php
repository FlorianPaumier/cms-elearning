
<section class="header">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/98/WordPress_blue_logo.svg/1200px-WordPress_blue_logo.svg.png" alt="logo">
    <nav>
        <ul>
            <li><a class="nav-link" href="#">Cours</a></li>
            <li><a class="nav-link" href="#">Articles</a></li>
            <li><a class="nav-link" href="#">Évenements</a></li>
            <li class="separator"><span></span></li>
            <li>
                <form action="/search" method="get">
                    <input type="text" class="input-search" placeholder="Search">
                    <button class="btn btn-append c-blue"><i class="fas fa-search"></i></button>
                </form>

            </li>
            <li>
                <a class="btn btn-signin" href="/signin">S'inscrire</a>
            </li>
            <li>
                <a class="btn btn-login" href="/login">Se connecter</a>
            </li>
        </ul>
    </nav>
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


