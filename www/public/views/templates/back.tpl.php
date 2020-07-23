<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?? "Easy To Learn" ?> </title>

    <meta lang="fr">

    <!-- Librairie -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="/assets/dist/fontawesome/css/all.css">

    <!-- Include Editor style. -->
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.5.1/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@2.5.1/css/froala_style.min.css" rel="stylesheet" type="text/css" />

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/assets/styles/admin/main.css" rel="stylesheet">
    @yield(styles)

</head>

<body id="page-top">

@include(admin/partials/sidebar)

@include(admin/partials/titlebar)

<?php
if ($errors) {
    foreach ($errors as $error) {
        var_dump($error);
    }
}
?>

@yield(body)


@include(partials/modal)


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="/assets/scripts/core/observer.js"></script>

<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.5.1//js/froala_editor.pkgd.min.js"></script>

<script src="/assets/scripts/ckeditor.js"></script>

@yield(javascripts)

@include(admin/partials/footer)

</body>
</html>
