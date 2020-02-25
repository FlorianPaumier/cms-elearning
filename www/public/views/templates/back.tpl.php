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

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="assets/dist/fontawesome/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/styles/main.css" rel="stylesheet" type="text/css">

    @section(style)
</head>

<body id="page-top">

@include(partials/header.view.php)

<?php
    if($session["user"]):
?>
        @include(partials/sidebar.view.php)
<?php endif; ?>

@section(body)


@include(partials/modal.view.php)
@include(partials/footer.view.php)

@section(script)
</body>
</html>

