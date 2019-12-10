<html>
<head>
    <title>
        <?php
        if(isset($title)){
            echo $title;
        }else{
            echo "Accueil";
        }
        ?></title>
    <meta lang="fr">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/app.css">

    <?php
    if(isset($styles)){
        foreach ($styles as $style) {
            echo "<link rel='stylesheet' href='$style'/>";
        }
    }

    ?>

</head>
<body>

<?php

if(isset($session))
    include ("nav.view.php");

if(isset($flash)){
    if(isset($flash["success"])){
        foreach ($flash["success"] as $key => $message){
            echo "<div class='alert alert-sucess'>$message</div>";
        }
    }
    if($flash["error"]){
        foreach ($flash["error"] as $key => $message){
            echo "<div class='alert alert-error'>$message</div>";
        }
    }
}

?>

{% block body %}{% endblock %}

<footer>
    Footer
</footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<?php
if(isset($scripts)){
    foreach ($scripts as $script) {
        echo "<script type='application/javascript' href='$script'></script>";
    }
}

?>
</body>
</html>

